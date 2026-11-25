<?php

 include("../bjksadkhrej121lkjkjk.php");
 include("../../design/url.php");

 $queryFilter = " where cabang_id = '".intval($_POST['cari_cabang_id'])."'";
 $queryFilter = " where id is not null";
 if(isset($_POST['filter']) && ($_POST['filter'] !== "" || $_POST['filter'] !== "[]"))
  { $filter = json_decode($_POST['filter'], true);
    for($i=0; $i<count($filter); $i++)
     { $queryFilter .= " and concat(".str_replace("'", "\'", $filter[$i]['field']).") like '%".str_replace("'", "\'", trim($filter[$i]['value']))."%'";
     }
  }

 $nhalaman = 1;
 $halaman = 1;
 if(isset($_POST['halaman']) && $_POST['halaman'] !== "")
  { $halaman = $_POST['halaman'];
  }

 $nListView = 0;
 $query = "select count(*) as jlh from ".$_POST['Nama_Tabel'].$queryFilter;
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $nListView = $row['jlh'];
  }
 
 if($nListView > $_POST['maxRecord'])
  { $bagi = $nListView / $_POST['maxRecord'];
    $mod = $nListView % $_POST['maxRecord'];
    if($mod == 0)
     { $nhalaman = intval($bagi);
     }
    else
     { $nhalaman = intval($bagi) + 1;
     }
  }

 if($halaman > $nhalaman)
  { $halaman = $nhalaman;
  }
 if($halaman < 1)
  { $halaman = 1;
  }

 $option_halaman = "<option></option>";
 for($i=1; $i<=$nhalaman; $i++)
  { if($i == $halaman)
     { $option_halaman .= "<option value='".$i."' selected>".$i."</option>";
     }
    else
     { $option_halaman .= "<option value='".$i."'>".$i."</option>";
     }
  }

 //Tampilan ListView---------------------------------------------------------------------------------------------------------------------------------------------

 echo "<input type='hidden' id='txthalaman' value='".$halaman."'>
       <input type='hidden' id='txtnhalaman' value='".$nhalaman."'>
       <select style='display:none;' id='temp-preview-halaman'>".$option_halaman."</select>";

 echo "<table class='table table-bordered' style='margin-top:5px; margin-bottom:5px;'>";

 $descTable = array();
 $query = "desc ".$_POST['Nama_Tabel'];
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { array_push($descTable, array(
     "Field" => $row['Field'],
     "Type" => $row['Type'],
    ));
  }

 $filter_jabatan = "";
 $filter_jam_kerja = "";

 $dataRows = array();
 $DataEdit = "";
 $limit = $halaman * $_POST['maxRecord'];
 $start = $limit - $_POST['maxRecord'];
 $query = "select ".$_POST['Nama_Tabel'].".*, aes_decrypt(unhex(password), 'Kjsd902Jks97161h1kd') as pswd from ".$_POST['Nama_Tabel'].$queryFilter." order by id desc limit ".$_POST['maxRecord']." offset ".$start;
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $row['password'] = $row['pswd'];
    $array_push = array();
    for($i=0; $i<count($descTable); $i++)
     { if(isset($row[$descTable[$i]['Field']]) && $row[$descTable[$i]['Field']] !== "")
        { if($descTable[$i]['Type'] == "decimal(20,2)")
           { $array_push[$descTable[$i]['Field']] = number_format($row[$descTable[$i]['Field']], 2, ",", ".");
           }
          else if($descTable[$i]['Type'] == "date")
           { $array_push[$descTable[$i]['Field']] = date('d-m-Y', strtotime($row[$descTable[$i]['Field']]));
           }
          else
           { $array_push[$descTable[$i]['Field']] = $row[$descTable[$i]['Field']];
           }
        }
       else
        { $array_push[$descTable[$i]['Field']] = null;
        }
       if($descTable[$i]['Field'] == "no_hp")
        { $DataEdit .= "<select class='select_edit-".$descTable[$i]['Field']."'>";
          $data = array();
          if(isset($array_push[$descTable[$i]['Field']]) && $array_push[$descTable[$i]['Field']] !== "")
           { $data = json_decode($array_push[$descTable[$i]['Field']], true);
           }
          foreach($data as $key => $value)
           { $DataEdit .= "<option value='".$value[$descTable[$i]['Field']]."' selected>".$value[$descTable[$i]['Field']]."</option>";
           }
          $DataEdit .= "</select>";
        }
       else
        { $DataEdit .= "<textarea class='textarea_edit-".$descTable[$i]['Field']."'>".$array_push[$descTable[$i]['Field']]."</textarea>";
        }
     }
    array_push($dataRows, $array_push);
    if(strval(strpos($filter_jabatan, " id = '".$row['jabatan_id']."'")) == "")
     { if($filter_jabatan !== "")
        { $filter_jabatan .= " or";
        }
       $filter_jabatan .= " id = '".$row['jabatan_id']."'";
     }
    if(strval(strpos($filter_jam_kerja, " id = '".$row['jam_kerja_id']."'")) == "")
     { if($filter_jam_kerja !== "")
        { $filter_jam_kerja .= " or";
        }
       $filter_jam_kerja .= " id = '".$row['jam_kerja_id']."'";
     }
  }

 $arrayJabatan = array();
 if($filter_jabatan !== "")
  { $query = "select * from jabatan where".$filter_jabatan;
    $execute = mysqli_query($koneksi, $query);
    while($row = mysqli_fetch_array($execute))
     { array_push($arrayJabatan, array(
        "id" => $row['id'],
        "jabatan" => $row['jabatan'],
       ));
     }
  }

 $arrayJamKerja = array();
 if($filter_jam_kerja !== "")
  { $query = "select * from jam_kerja where".$filter_jam_kerja;
    $execute = mysqli_query($koneksi, $query);
    while($row = mysqli_fetch_array($execute))
     { array_push($arrayJabatan, array(
        "id" => $row['id'],
        "jam_kerja" => $row['jam_kerja'],
       ));
     }
  }

 $status_aktif = array();
 $status_aktif[''] = "";
 $status_aktif['0'] = "Tidak Aktif";
 $status_aktif['1'] = "Aktif";

 for($i=0; $i<count($dataRows); $i++)
  { $lokasi_foto = "dist/img/no_profil.png";
    if(isset($dataRows[$i]['file_foto']) && $dataRows[$i]['file_foto'] !== "")
     { if(file_exists("../../gambar/karyawan/".$dataRows[$i]['file_foto']))
        { $lokasi_foto = "gambar/karyawan/".$dataRows[$i]['file_foto'];
        } 
     }

    $jabatan = "";
    $index = array_search($dataRows[$i]['jabatan_id'], array_column($arrayJabatan, 'id'));
    if(strval($index) !== "")
     { $jabatan = $arrayJabatan[$index]['jabatan'];
     }

    $no_hp = "";
    $data = array();
    if(isset($dataRows[$i]['no_hp']) && $dataRows[$i]['no_hp'] !== "")
     { $data = json_decode($dataRows[$i]['no_hp'], true);
     }
    foreach($data as $key => $value)
     { if($no_hp !== "")
        { $no_hp .= ", ";
        }
       $no_hp .= $value['no_hp'];
     }

    $jam_kerja = "";
    $index = array_search($dataRows[$i]['jam_kerja_id'], array_column($arrayJamKerja, 'id'));
    if(strval($index) !== "")
     { $jam_kerja = $arrayJamKerja[$index]['jam_kerja'];
     }

    echo "<tr>
           <td style='padding:10px; width:150px; text-align:center;'>
            <div class='box-foto-profil'>
             <a href='".$url."/".$lokasi_foto."' target='blank' style='display:inline-block;'><div><img src='".$url."/".$lokasi_foto."'></div></a>
             <button type='button' class='btn btn-default' onclick=\"document.getElementById('id_upload').value = '".$dataRows[$i]['id']."';\" data-toggle='modal' data-target='#myModal2' data-backdrop='static' data-keyboard='false'><i class='fa fa-camera'></i></button>
            </div>
           </td>
           <td style='padding:10px; vertical-align:top;'>
            <table style='width:100%;'>
             <tr style='background-color:#f4f4f4;'>
              <th style='min-width:250px;'>NIK</th>
              <td style='min-width:250px;'>".$dataRows[$i]['nik']."</td>
              <td style='width:10px; min-width:10px; max-width:10px;'></td>
              <th style='min-width:250px;'>Tunjangan Jabatan Per Bulan</th>
              <td style='min-width:250px; text-align:right;'>".$dataRows[$i]['tunjangan_jabatan_per_bulan']."</td>
             </tr>
             <tr>
              <th>Nama</th>
              <td>".$dataRows[$i]['nama']."</td>
              <td style='width:10px; min-width:10px; max-width:10px;'></td>
              <th>Tunjangan Kesehatan Per Bulan</th>
              <td style='text-align:right;'>".$dataRows[$i]['tunjangan_kesehatan_per_bulan']."</td>
             </tr>
             <tr style='background-color:#f4f4f4;'>
              <th>Jabatan</th>
              <td>".$jabatan."</td>
              <td style='width:10px; min-width:10px; max-width:10px;'></td>
              <th>Tunjangan Transportasi Per Bulan</th>
              <td style='text-align:right;'>".$dataRows[$i]['tunjangan_transportasi_per_bulan']."</td>
             </tr>
             <tr>
              <th>No. HP</th>
              <td>".$no_hp."</td>
              <td style='width:10px; min-width:10px; max-width:10px;'></td>
              <th>Potongan Per Tidak Masuk</th>
              <td style='text-align:right;'>".$dataRows[$i]['potongan_per_tidak_masuk']."</td>
             </tr>
             <tr style='background-color:#f4f4f4;'>
              <th>Alamat</th>
              <td>".$dataRows[$i]['alamat']."</td>
              <td style='width:10px; min-width:10px; max-width:10px;'></td>
              <th>Potongan Per Izin Cuti</th>
              <td style='text-align:right;'>".$dataRows[$i]['potongan_per_izin_cuti']."</td>
             </tr>
             <tr>
              <th>Gaji Per Bulan</th>
              <td style='text-align:right;'>".$dataRows[$i]['gaji_per_bulan']."</td>
              <td style='width:10px; min-width:10px; max-width:10px;'></td>
              <th>Potongan Per Terlambat Masuk</th>
              <td style='text-align:right;'>".$dataRows[$i]['potongan_per_terlambat_masuk']."</td>
             </tr>
             <tr style='background-color:#f4f4f4;'>
              <th>Gaji Per Hari</th>
              <td style='text-align:right;'>".$dataRows[$i]['gaji_per_hari']."</td>
              <td style='width:10px; min-width:10px; max-width:10px;'></td>
              <th>Potongan Per Pulang Sebelum Waktunya</th>
              <td style='text-align:right;'>".$dataRows[$i]['potongan_per_pulang_sebelum_waktunya']."</td>
             </tr>
             <tr>
              <th>Uang Makan Per Hari</th>
              <td style='text-align:right;'>".$dataRows[$i]['uang_makan_per_hari']."</td>
              <td style='width:10px; min-width:10px; max-width:10px;'></td>
              <th>Potongan Per Tidak Absen Masuk</th>
              <td style='text-align:right;'>".$dataRows[$i]['potongan_per_tidak_absen_masuk']."</td>
             </tr>
             <tr style='background-color:#f4f4f4;'>
              <th>Uang Makan Lembur Per Hari</th>
              <td style='text-align:right;'>".$dataRows[$i]['uang_makan_lembur_per_hari']."</td>
              <td style='width:10px; min-width:10px; max-width:10px;'></td>
              <th>Potongan Per Tidak Absen Pulang</th>
              <td style='text-align:right;'>".$dataRows[$i]['potongan_per_tidak_absen_pulang']."</td>
             </tr>
             <tr>
              <th>Uang Pulsa Per Bulan</th>
              <td style='text-align:right;'>".$dataRows[$i]['uang_pulsa_per_bulan']."</td>
              <td style='width:10px; min-width:10px; max-width:10px;'></td>
              <th>Tanggal Masuk</th>
              <td>".$dataRows[$i]['tanggal_masuk']."</td>
             </tr>
             </tr>
             <tr style='background-color:#f4f4f4;'>
              <th>Uang Lembur Per Jam</th>
              <td style='text-align:right;'>".$dataRows[$i]['uang_lembur_per_jam']."</td>
              <td style='width:10px; min-width:10px; max-width:10px;'></td>
              <th>Tanggal Gajian Tiap Bulan</th>
              <td>".str_pad($dataRows[$i]['tanggal_gajian_tiap_bulan'] ?? '', 2, "0", STR_PAD_LEFT)."</td>
             </tr>
             <tr>
              <th>Uang Servis Kendaraan Per Bulan</th>
              <td style='text-align:right;'>".$dataRows[$i]['uang_servis_kendaraan_per_bulan']."</td>
              <td style='width:10px; min-width:10px; max-width:10px;'></td>
              <th>Status Aktif</th>
              <td>".$status_aktif[$dataRows[$i]['status_aktif']]."</td>
             </tr>
             <tr style='background-color:#f4f4f4;'>
              <th>Tunjangan Harian</th>
              <td style='text-align:right;'>".$dataRows[$i]['tunjangan_harian']."</td>
              <td style='width:10px; min-width:10px; max-width:10px;'></td>
              <th>Jam Kerja</th>
              <td>".$jam_kerja."</td>
             </tr>
             <tr>
              <th></th>
              <td></td>
              <td style='width:10px; min-width:10px; max-width:10px;'></td>
              <td colspan='2' style='text-align:right;'>
               <button type='button' class='btn btn-default edit' onclick='edit(this);'><i class='fa fa-edit'></i></button>
               <button type='button' class='btn btn-default hapus' data-toggle='modal' data-target='#myModal' onclick='konfirmasiHapus(this);'><i class='fa fa-trash'></i></button>
              </td>
             </tr>
            </table>
           </td>
          </tr>";
  }

 echo " </table>Menampilkan ".count($dataRows)." dari ".$nListView." record";

 //Tampilan ListView---------------------------------------------------------------------------------------------------------------------------------------------

 echo "<div style='display:none;'>".$DataEdit."</div>";

?>