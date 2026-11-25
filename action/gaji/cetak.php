<?php
 include("../bjksadkhrej121lkjkjk.php");
 include("../../plugin/pdf/autoload.php");

 $folder = "../../files/";
 if(!is_dir($folder))
  { mkdir($folder, 0755);
  }
 $folder .= "gaji/";
 if(!is_dir($folder))
  { mkdir($folder, 0755);
  }

 $id = $_POST['id'] ?? null;

 $execute = $koneksi->prepare("select * from gaji where id = ?");
 $execute->bind_param("i", $id);
 $execute->execute();
 $result = $execute->get_result();
 $dataGaji = $result->fetch_assoc();

 if(isset($dataGaji['karyawan_id']) && $dataGaji['karyawan_id'] !== "")
  { $execute = $koneksi->prepare("select * from karyawan where id = ?");
    $execute->bind_param("i", $dataGaji['karyawan_id']);
    $execute->execute();
    $result = $execute->get_result();
    $dataKaryawan = $result->fetch_assoc();
  }

 $nama = $dataKaryawan['nama'] ?? "";

 //hapus file 5 menit lalu
 $scandir = scandir($folder);
 $scandir = array_values(array_filter($scandir, function($var) {
  return ($var !== '.' && $var !== '..');
 }));
 for($i=0; $i<count($scandir); $i++)
  { $created = intval(filectime($folder.$scandir[$i]));
    $sekarang = intval(strtotime($now));
    if($created + 3000 < $sekarang)
     { unlink($folder.$scandir[$i]);
     }
  }

 $nama_file = generateRandomString().".pdf";

 $html = '<style>
           @font-face
            { font-family: "Source Sans Pro Regular";
              src: url("../../fonts/source-sans-pro.regular.ttf");
            }
           body
            { font-family : "Source Sans Pro Regular";
            }
           table tr th, table tr td
            { text-align : left;
              vertical-align : top;
              padding : 1px 0px;
            }
          </style>
          <div style="text-align:justify;">
           <table style="margin-left:15px;">
            <tr>
             <td style="padding-right:0px;"><img src="../../img/logo_kop.png" style="height:100%; max-height:2cm;"></td>
             <td style="text-align:center;">
              <div style="font-size:18px; font-weight:bold;">PT MITRA INTEGRASI ENGINEERING</div>
              <div style="font-size:16px;">Jl. Suka Cerdas IV. 3 B STM Ujung, Suka Maju, Kec. Medan Johor<br> Kota Medan, Sumatera Utara 20147</div>
              <div style="font-size:16px;">+62 822-9944-7705 - <a href="https://mitraintegrasiengineering.com" style="text-decoration:none;">mitraintegrasiengineering.com</a></div>
             </td>
            </tr>
           </table>
           <div style="width:100%; height:2px; background:black;"></div>
           <div style="width:100%; height:0.5px; background:black; margin-top:1.5px;"></div>
           <div style="text-align:center; font-weight:bold; margin:20px 0px;">SLIP GAJI</div>

           <table cellpadding="0" cellspacing="0" style="width:100%;">
            <tr>
             <th style="width:auto;">NAMA</th>
             <th style="width:20px; text-align:center;">:</th>
             <td>'.$nama.'</td>
             <th style="width:auto;">TANGGAL</th>
             <th style="width:20px; text-align:center;">:</th>
             <td style="width:185px;">'.(isset($dataGaji['tanggal']) && $dataGaji['tanggal'] !== "" ? date('d-m-Y', strtotime($dataGaji['tanggal'])) : "").'</td>
            </tr>
            <tr>
             <th>JABATAN</th>
             <th style="text-align:center;">:</th>
             <td>'.($dataGaji['jabatan'] ?? '').'</td>
             <th>PERIODE</th>
             <th style="text-align:center;">:</th>
             <td>'.(isset($dataGaji['dari']) && $dataGaji['dari'] !== "" ? date('d-m-Y', strtotime($dataGaji['dari'])) : "").' s/d '.(isset($dataGaji['sampai']) && $dataGaji['sampai'] !== "" ? date('d-m-Y', strtotime($dataGaji['sampai'])) : "").'</td>
            </tr>
           </table>

           <table cellpadding="0" cellspacing="0" style="width:100%; margin-top:20px;">
            <tr>
             <th>Hadir</th>
             <th style="width:15px; text-align:center;">:</th>
             <td>'.formatAngka($dataGaji['hadir']).'</td>
             <td style="width:15px;"></td>
             <th>Absen</th>
             <th style="width:15px; text-align:center;">:</th>
             <td>'.formatAngka($dataGaji['absen']).'</td>
             <td style="width:15px;"></td>
             <th>Izin Cuti</th>
             <th style="width:15px; text-align:center;">:</th>
             <td>'.formatAngka($dataGaji['izin_cuti']).'</td>
             <td style="width:15px;"></td>
             <th>Izin Sakit</th>
             <th style="width:15px; text-align:center;">:</th>
             <td>'.formatAngka($dataGaji['izin_sakit']).'</td>
             <td style="width:15px;"></td>
             <th>Izin Terlambat</th>
             <th style="width:15px; text-align:center;">:</th>
             <td>'.formatAngka($dataGaji['izin_terlambat_masuk']).'</td>
            </tr>
            <tr>
             <th style="text-align:left;">Izin Pulang</th>
             <th style="text-align:center;">:</th>
             <td>'.formatAngka($dataGaji['izin_pulang_sebelum_waktunya']).'</td>
             <td></td>
             <th>Terlambat</th>
             <th style="text-align:center;">:</th>
             <td>'.formatAngka($dataGaji['terlambat_masuk']).'</td>
             <td></td>
             <th>Pulang Deluan</th>
             <th style="text-align:center;">:</th>
             <td>'.formatAngka($dataGaji['pulang_sebelum_waktunya']).'</td>
             <td></td>
             <th>Tidak Absen Masuk</th>
             <th style="text-align:center;">:</th>
             <td>'.formatAngka($dataGaji['tidak_absen_masuk']).'</td>
             <td></td>
             <th>Tidak Absen Pulang</th>
             <th style="text-align:center;">:</th>
             <td>'.formatAngka($dataGaji['tidak_absen_pulang']).'</td>
            </tr>
           </table>

           <table cellpadding="0" cellspacing="0" style="width:100%; margin-top:20px; border-collapse:collapse">
            <tr>
             <th style="border:1px solid black; border-bottom:0px; padding:5px;">PENDAPATAN</th>
            </tr>
            <tr>
             <td style="border:1px solid black; padding:5px;">
              <table cellpadding="0" cellspacing="0" style="width:100%;">
               <tr>
                <th style="width:100px;">Gaji Pokok</th>
                <th style="width:15px; text-align:center;">:</th>
                <td style="width:auto; text-align:right;">'.formatAngka($dataGaji['gaji_pokok']).'</td>
                <td style="width:50px;"></td>
                <th style="width:100px;">Bonus</th>
                <th style="width:15px; text-align:center;">:</th>
                <td style="width:auto; text-align:right;">'.formatAngka($dataGaji['bonus']).'</td>
               </tr>
               <tr>
                <th>Uang Makan <small>('.formatAngka($dataGaji['uang_makan_per_hari']).' × '.formatAngka($dataGaji['hadir']).')</small></th>
                <th style="text-align:center;">:</th>
                <td style="text-align:right;">'.formatAngka($dataGaji['uang_makan']).'</td>
                <td></td>
                <th>THR</th>
                <th style="text-align:center;">:</th>
                <td style="text-align:right;">'.formatAngka($dataGaji['tunjangan_hari_raya']).'</td>
               </tr>
               <tr>
                <th>Uang Lembur</th>
                <th style="text-align:center;">:</th>
                <td style="text-align:right;">'.formatAngka($dataGaji['uang_lembur']).'</td>
                <td></td>
                <th>Total Pendapatan</th>
                <th style="text-align:center;">:</th>
                <th style="text-align:right; color:green;">'.formatAngka($dataGaji['total_pendapatan']).'</th>
               </tr>
              </table>
             </td>
            </tr>
           </table>

           <table cellpadding="0" cellspacing="0" style="width:100%; margin-top:20px; border-collapse:collapse">
            <tr>
             <th style="border:1px solid black; border-bottom:0px; padding:5px;">POTONGAN & TOTAL GAJI</th>
            </tr>
            <tr>
             <td style="border:1px solid black; padding:5px;">
              <table cellpadding="0" cellspacing="0" style="width:100%;">
               <tr>
                <th style="width:100px;">Potongan Absen<br><small>('.formatAngka($dataGaji['potongan_per_tidak_masuk']).' × '.formatAngka($dataGaji['absen']).')</small></th>
                <th style="width:15px; text-align:center;">:</th>
                <td style="width:auto; text-align:right;">'.formatAngka($dataGaji['potongan_per_tidak_masuk']).'</td>
                <td style="width:50px;"></td>
                <th style="width:100px;">Denda Tidak Absen Pulang<br><small>('.formatAngka($dataGaji['potongan_per_tidak_absen_pulang']).' × '.formatAngka($dataGaji['tidak_absen_pulang']).')</small></th>
                <th style="width:15px; text-align:center;">:</th>
                <td style="width:auto; text-align:right;">'.formatAngka($dataGaji['potongan_tidak_absen_pulang']).'</td>
               </tr>
               <tr>
                <th style="width:100px;">Denda Terlambat<br><small>('.formatAngka($dataGaji['potongan_per_terlambat_masuk']).' × '.formatAngka($dataGaji['terlambat_masuk']).')</small></th>
                <th style="width:15px; text-align:center;">:</th>
                <td style="width:auto; text-align:right;">'.formatAngka($dataGaji['potongan_terlambat_masuk']).'</td>
                <td style="width:50px;"></td>
                <th style="width:100px;">Potongan Utang</th>
                <th style="width:15px; text-align:center;">:</th>
                <td style="width:auto; text-align:right;">'.formatAngka($dataGaji['potongan_utang']).'</td>
               </tr>
               <tr>
                <th style="width:100px;">Denda Pulang Deluan<br><small>('.formatAngka($dataGaji['potongan_per_pulang_sebelum_waktunya']).' × '.formatAngka($dataGaji['pulang_sebelum_waktunya']).')</small></th>
                <th style="width:15px; text-align:center;">:</th>
                <td style="width:auto; text-align:right;">'.formatAngka($dataGaji['potongan_pulang_sebelum_waktunya']).'</td>
                <td style="width:50px;"></td>
                <th style="width:100px;">Total Potongan</th>
                <th style="width:15px; text-align:center;">:</th>
                <th style="width:auto; text-align:right; color:red;"><div style="border-bottom:1px solid red;">'.formatAngka($dataGaji['total_potongan']).'</div></th>
               </tr>
               <tr>
                <th style="width:100px;">Denda Tidak Absen Masuk<br><small>('.formatAngka($dataGaji['potongan_per_tidak_absen_masuk']).' × '.formatAngka($dataGaji['tidak_absen_masuk']).')</small></th>
                <th style="width:15px; text-align:center;">:</th>
                <td style="width:auto; text-align:right;">'.formatAngka($dataGaji['potongan_tidak_absen_masuk']).'</td>
                <td style="width:50px;"></td>
                <th style="width:100px;">Total Gaji</th>
                <th style="width:15px; text-align:center;">:</th>
                <th style="width:auto; text-align:right; color:green;">'.formatAngka($dataGaji['total_gaji']).'</th>
               </tr>
              </table>
             </td>
            </tr>
           </table>


          </div>';

 $mpdf = new \Mpdf\Mpdf();
 $mpdf->AddPage('P','','','','', 20, 20, 5, 15, 15, 15);
 $mpdf->WriteHTML($html);
 $mpdf->Output($folder.$nama_file, 'F');
?>
<textarea id="nama_file"><?= $nama_file ?></textarea>