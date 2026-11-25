<?php
 include("../bjksadkhrej121lkjkjk.php");
 include("../../plugin/PHPExcel/PHPExcel.php");

 $dayList = array(
  "Mon" => "Senin",
  "Tue" => "Selasa",
  "Wed" => "Rabu",
  "Thu" => "Kamis",
  "Fri" => "Jum'at",
  "Sat" => "Sabtu",
  "Sun" => "Minggu",
 );

 $dari_tanggal = $_POST['dari'] ?? date('Y-m-d');
 $sampai_tanggal = $_POST['sampai'] ?? date('Y-m-d');
 $dari_tgl = $dari_tanggal." 00:00:00";
 $sampai_tgl = $sampai_tanggal." 23:59:59";

 $list = "";

 $where = "";
 $types = "";
 $params = [];

 if(isset($_POST['karyawan_id']) && $_POST['karyawan_id'] !== "")
  { $where .= " and karyawan.id = ?";
    $types .= "d";
    $params[] = $_POST['karyawan_id'];

    $karyawan_id = $_POST['karyawan_id'];
    $execute = $koneksi->prepare("select ifnull(sum(ifnull(uang_makan, 0) + ifnull(uang_transport, 0) + ifnull(uang_lembur, 0)), 0) as uang_lembur from lembur where karyawan_id = ? and tanggal >= ? and tanggal <= ?");
    $execute->bind_param("iss", $karyawan_id, $dari_tanggal, $sampai_tanggal);
    $execute->execute();
    $result = $execute->get_result();
    $arrayLembur = $result->fetch_assoc();
  }

 $dataRows = [];
 $execute = $koneksi->prepare("select karyawan.*, jabatan.jabatan from karyawan left join jabatan on karyawan.jabatan_id = jabatan.id where karyawan.status_aktif = 1".$where." order by karyawan.nama asc");
 if(count($params) > 0)
  { $execute->bind_param($types, ...$params);
  }
 $execute->execute();
 $result = $execute->get_result();
 $dataRows = $result->fetch_all(MYSQLI_ASSOC);

 $execute = $koneksi->prepare("select absensi.*, date(tanggal_waktu) as tanggal from absensi where tanggal_waktu >= ? and tanggal_waktu <= ? ".str_replace("karyawan.id", "karyawan_id", $where)." order by tanggal_waktu asc");
 $execute->bind_param("ss".$types, $dari_tgl, $sampai_tgl, ...$params);
 $execute->execute();
 $result = $execute->get_result();
 $arrayAbsensi = $result->fetch_all(MYSQLI_ASSOC);

 $arrayShiftJamKerja = array();
 $arr_jam_kerja_id = array_values(array_unique(array_column($dataRows, 'jam_kerja_id')));
 $placeholders = implode(',', array_fill(0, count($arr_jam_kerja_id), '?'));
 $types = str_repeat('i', count($arr_jam_kerja_id));
 if(count($arr_jam_kerja_id) > 0)
  { $execute = $koneksi->prepare("select * from shift_jam_kerja where jam_kerja_id in (".$placeholders.")");
    $execute->bind_param($types, ...$arr_jam_kerja_id);
    $execute->execute();
    $result = $execute->get_result();
    $arrayShiftJamKerja = $result->fetch_all(MYSQLI_ASSOC);
  }

 $execute = $koneksi->prepare("select * from hari_libur where dari_tanggal >= ? or (dari_tanggal >= ? and sampai_tanggal <= ?)");
 $execute->bind_param("sss", $dari_tanggal, $dari_tanggal, $sampai_tanggal);
 $execute->execute();
 $result = $execute->get_result();
 $arrayHariLibur = $result->fetch_all(MYSQLI_ASSOC);

 $execute = $koneksi->prepare("select izin.*, jenis_izin.jenis_izin from izin left join jenis_izin on izin.jenis_izin_id = jenis_izin.id where izin.dari_tanggal >= ? or (izin.dari_tanggal >= ? and izin.sampai_tanggal <= ?)");
 $execute->bind_param("sss", $dari_tanggal, $dari_tanggal, $sampai_tanggal);
 $execute->execute();
 $result = $execute->get_result();
 $arrayIzin = $result->fetch_all(MYSQLI_ASSOC);

 function getRincianAbsen($koneksi, $dayList, $dataRows, $arrayAbsensi, $arrayShiftJamKerja, $arrayHariLibur, $arrayIzin, $tanggal)
  { $dari_tgl = date('Y-m-d', strtotime($tanggal))." 00:00:00";
    $sampai_tgl = date('Y-m-d', strtotime($tanggal))." 23:59:59";

    $item = "";
    for($i=0; $i<count($dataRows); $i++)
     { $karyawan_id = $dataRows[$i]['id'];
       $jam_kerja_id = $dataRows[$i]['jam_kerja_id'];
       $tgl_sekarang = date('Y-m-d', strtotime($tanggal));
       $hari = strtolower(str_replace("'", "", $dayList[date('D', strtotime($tanggal))]));

       $keterangan = "";
       $jam_masuk = "";
       $jam_pulang = "";

       $hadir = 0;
       $absen = 1;
       $izin_cuti = 0;
       $izin_sakit = 0;
       $izin_terlambat_masuk = 0;
       $izin_pulang_sebelum_waktunya = 0;
       $terlambat_masuk = 0;
       $pulang_sebelum_waktunya = 0;
       $tidak_absen_masuk = 0;
       $tidak_absen_pulang = 0;

       //Absensi Masuk
       $absensiMasukYangDivalidasi = array_values(array_filter($arrayAbsensi, function ($var) use ($karyawan_id, $tgl_sekarang) {
        return ($var['karyawan_id'] == $karyawan_id && $var['tanggal'] == $tgl_sekarang && $var['jenis_absen'] == "Masuk" && $var['status'] == "2");
       }));
       if(count($absensiMasukYangDivalidasi) > 0)
        { $jam_masuk = date('H:i', strtotime($absensiMasukYangDivalidasi[0]['tanggal_waktu']));
        }
       $absensiMasukBelumDivalidasi = array_values(array_filter($arrayAbsensi, function ($var) use ($karyawan_id, $tgl_sekarang) {
         return ($var['karyawan_id'] == $karyawan_id && $var['tanggal'] == $tgl_sekarang && $var['jenis_absen'] == "Masuk" && $var['status'] == "0");
        }));

       //Absensi Pulang
       $absensiPulangYangDivalidasi = array_values(array_filter($arrayAbsensi, function ($var) use ($karyawan_id, $tgl_sekarang) {
        return ($var['karyawan_id'] == $karyawan_id && $var['tanggal'] == $tgl_sekarang && $var['jenis_absen'] == "Pulang" && $var['status'] == "2");
       }));
       if(count($absensiPulangYangDivalidasi) > 0)
        { $jam_pulang = date('H:i', strtotime($absensiPulangYangDivalidasi[0]['tanggal_waktu']));
        }
       $absensiPulangBelumDivalidasi = array_values(array_filter($arrayAbsensi, function ($var) use ($karyawan_id, $tgl_sekarang) {
        return ($var['karyawan_id'] == $karyawan_id && $var['tanggal'] == $tgl_sekarang && $var['jenis_absen'] == "Pulang" && $var['status'] == "0");
       }));

       //Status Hadir
       if(count($absensiMasukYangDivalidasi) > 0 || count($absensiPulangYangDivalidasi) > 0)
        { $hadir = 1;
          $absen = 0;
          if(count($absensiMasukYangDivalidasi) == 0)
           { $tidak_absen_masuk = 1;
           }
          if(count($absensiPulangYangDivalidasi) == 0)
           { $tidak_absen_pulang = 1;
           }
        }

       //Jika tidak ada Shift Jam Kerja, maka status = Libur
       $shift_jam_masuk = null;
       $shift_jam_pulang = null;
       $shift = array_values(array_filter($arrayShiftJamKerja, function ($var) use ($jam_kerja_id, $hari) {
        return ($var['jam_kerja_id'] == $jam_kerja_id && $var[$hari] == 1);
       }));
       if(count($shift) > 0)
        { //Tentukan jam masuk
          $jarak = 84600;
          $shift_jam_masuk = $shift[0]['jam_masuk']; //jam_masuk default
          $shift_jam_pulang = $shift[0]['jam_pulang']; //jam_pulang default

          //pilih jam shift terdekat dengan waktu absensi
          if(isset($absensiMasukYangDivalidasi[0]['tanggal_waktu']))
           { $tgl_ = date('Y-m-d', strtotime($absensiMasukYangDivalidasi[0]['tanggal_waktu']));
             $jam_ = date('H:i:s', strtotime($absensiMasukYangDivalidasi[0]['tanggal_waktu']));
             for($j=0; $j<count($shift); $j++)
              { $waktu_absensi = strtotime($tgl_." ".$jam_);
                $waktu_shift = strtotime($tgl_." ".$shift[$j]['jam_masuk']);
                if($waktu_shift - $waktu_absensi < $jarak)
                 { $jarak = $waktu_shift - $waktu_absensi;
                   $shift_jam_masuk = $tgl_." ".$shift[$j]['jam_masuk'];
                   $shift_jam_pulang = $tgl_." ".$shift[$j]['jam_pulang'];
                 }
              }
           }

          if(isset($absensiMasukYangDivalidasi[0]['tanggal_waktu']) && $absensiMasukYangDivalidasi[0]['tanggal_waktu'] > $shift_jam_masuk)
           { $terlambat_masuk = 1;
           }

          if(isset($absensiPulangYangDivalidasi[0]['tanggal_waktu']) && $absensiPulangYangDivalidasi[0]['tanggal_waktu'] < $shift_jam_pulang)
           { $pulang_sebelum_waktunya = 1;
           }
        }

       //Jika Izin sudah disetel, maka status = Izin
       $dataIzin = array_values(array_filter($arrayIzin, function ($var) use ($karyawan_id, $tgl_sekarang) {
        return ($var['karyawan_id'] == $karyawan_id && $var['dari_tanggal'] >= $tgl_sekarang && $var['sampai_tanggal'] <= $tgl_sekarang);
       }));
       if(count($dataIzin) > 0)
        { if($dataIzin[0]['jenis_izin_id'] == "1")
           { $izin_cuti = 1;
             $tidak_absen_masuk = 0;
             $tidak_absen_pulang = 0;
             $terlambat_masuk = 0;
             $pulang_sebelum_waktunya = 0;
           }
          else if($dataIzin[0]['jenis_izin_id'] == "2")
           { $izin_sakit = 1;
             $tidak_absen_masuk = 0;
             $tidak_absen_pulang = 0;
             $terlambat_masuk = 0;
             $pulang_sebelum_waktunya = 0;
           }
          else if($dataIzin[0]['jenis_izin_id'] == "3" && $jam_masuk !== "")
           { $izin_terlambat_masuk = 1;
             $terlambat_masuk = 0;
           }
          else if($dataIzin[0]['jenis_izin_id'] == "4" && $jam_pulang !== "")
           { $izin_pulang_sebelum_waktunya = 1;
             $pulang_sebelum_waktunya = 0;
           }
        }

       if(count($shift) == 0)
        { $hadir = 0;
          $absen = 0;
        }

       //Jika Hari Libur sudah disetel, maka status = Libur
       $dataLibur = array_values(array_filter($arrayHariLibur, function ($var) use ($tgl_sekarang) {
        return ($var['dari_tanggal'] >= $tgl_sekarang && $var['sampai_tanggal'] <= $tgl_sekarang);
       }));
       if(count($dataLibur) > 0)
        { $hadir = 0;
          $absen = 0;
        }

       return array(
        "hadir" => $hadir,
        "absen" => $absen,
        "izin_cuti" => $izin_cuti,
        "izin_sakit" => $izin_sakit,
        "izin_terlambat_masuk" => $izin_terlambat_masuk,
        "izin_pulang_sebelum_waktunya" => $izin_pulang_sebelum_waktunya,
        "terlambat_masuk" => $terlambat_masuk,
        "pulang_sebelum_waktunya" => $pulang_sebelum_waktunya,
        "tidak_absen_masuk" => $tidak_absen_masuk,
        "tidak_absen_pulang" => $tidak_absen_pulang,
       );
     }
  }

 $hadir = 0;
 $absen = 0;
 $izin_cuti = 0;
 $izin_sakit = 0;
 $izin_terlambat_masuk = 0;
 $izin_pulang_sebelum_waktunya = 0;
 $terlambat_masuk = 0;
 $pulang_sebelum_waktunya = 0;
 $tidak_absen_masuk = 0;
 $tidak_absen_pulang = 0;

 $dari = intval(strtotime($dari_tanggal));
 $sampai = intval(strtotime($sampai_tanggal));
 for($i=$dari; $i<=$sampai; $i=$i+86400)
  { $result = getRincianAbsen($koneksi, $dayList, $dataRows, $arrayAbsensi, $arrayShiftJamKerja, $arrayHariLibur, $arrayIzin, date('Y-m-d', $i));
    $hadir += $result['hadir'];
    $absen += $result['absen'];
    $izin_cuti += $result['izin_cuti'];
    $izin_sakit += $result['izin_sakit'];
    $izin_terlambat_masuk += $result['izin_terlambat_masuk'];
    $izin_pulang_sebelum_waktunya += $result['izin_pulang_sebelum_waktunya'];
    $terlambat_masuk += $result['terlambat_masuk'];
    $pulang_sebelum_waktunya += $result['pulang_sebelum_waktunya'];
    $tidak_absen_masuk += $result['tidak_absen_masuk'];
    $tidak_absen_pulang += $result['tidak_absen_pulang'];
  }

?>
<textarea id="hadir"><?= formatAngka($hadir) ?></textarea>
<textarea id="absen"><?= formatAngka($absen) ?></textarea>
<textarea id="izin_cuti"><?= formatAngka($izin_cuti) ?></textarea>
<textarea id="izin_sakit"><?= formatAngka($izin_sakit) ?></textarea>
<textarea id="izin_terlambat_masuk"><?= formatAngka($izin_terlambat_masuk) ?></textarea>
<textarea id="izin_pulang_sebelum_waktunya"><?= formatAngka($izin_pulang_sebelum_waktunya) ?></textarea>
<textarea id="terlambat_masuk"><?= formatAngka($terlambat_masuk) ?></textarea>
<textarea id="pulang_sebelum_waktunya"><?= formatAngka($pulang_sebelum_waktunya) ?></textarea>
<textarea id="tidak_absen_masuk"><?= formatAngka($tidak_absen_masuk) ?></textarea>
<textarea id="tidak_absen_pulang"><?= formatAngka($tidak_absen_pulang) ?></textarea>
<textarea id="jabatan"><?= ($dataRows[0]['jabatan'] ?? null) ?></textarea>
<textarea id="gaji_pokok"><?= formatAngka($dataRows[0]['gaji_pokok'] ?? 0) ?></textarea>
<textarea id="utang"><?= formatAngka($dataRows[0]['utang'] ?? 0) ?></textarea>
<textarea id="uang_makan_per_hari"><?= formatAngka($dataRows[0]['uang_makan_per_hari'] ?? 0) ?></textarea>
<textarea id="potongan_per_tidak_masuk"><?= formatAngka($dataRows[0]['potongan_per_tidak_masuk'] ?? 0) ?></textarea>
<textarea id="potongan_per_terlambat_masuk"><?= formatAngka($dataRows[0]['potongan_per_terlambat_masuk'] ?? 0) ?></textarea>
<textarea id="potongan_per_pulang_sebelum_waktunya"><?= formatAngka($dataRows[0]['potongan_per_pulang_sebelum_waktunya'] ?? 0) ?></textarea>
<textarea id="potongan_per_tidak_absen_masuk"><?= formatAngka($dataRows[0]['potongan_per_tidak_absen_masuk'] ?? 0) ?></textarea>
<textarea id="potongan_per_tidak_absen_pulang"><?= formatAngka($dataRows[0]['potongan_per_tidak_absen_pulang'] ?? 0) ?></textarea>
<textarea id="uang_lembur"><?= formatAngka($arrayLembur['uang_lembur'] ?? 0) ?></textarea>