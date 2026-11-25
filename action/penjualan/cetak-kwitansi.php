<?php

 include("../bjksadkhrej121lkjkjk.php");

 $id = $_POST['id'] ?? null;

 $lokasi_folder = "../export/";
 if(!is_dir($lokasi_folder))
  { mkdir($lokasi_folder, 0755);
  }
 $lokasi_folder .= $username."/";
 $lokasi_folder .= "kwitansi-penjualan/";
 if(!is_dir($lokasi_folder))
  { mkdir($lokasi_folder, 0755);
  }
 deleteDirectory($lokasi_folder);
 if(!is_dir($lokasi_folder))
  { mkdir($lokasi_folder, 0755);
  }

 $execute = $koneksi->prepare("select * from penjualan_pembayaran where id = ?");
 $execute->bind_param("i", $id);
 $execute->execute();
 $result = $execute->get_result();
 $dataPenjualanPembayaran = $result->fetch_assoc();

 $execute = $koneksi->prepare("select * from perusahaan");
 $execute->execute();
 $result = $execute->get_result();
 $dataPerusahaan = $result->fetch_assoc();
 $nama_perusahaan = $dataPerusahaan['nama_perusahaan'] ?? '';

 $penjualan_id = $dataPenjualanPembayaran['penjualan_id'] ?? null;
 $execute = $koneksi->prepare("select penjualan.*, concat(penjualan.kode, right(year(penjualan.tanggal), 2), lpad(month(penjualan.tanggal), 2, '0'), lpad(day(penjualan.tanggal), 2, '0'), '-MIE-', lpad(penjualan.nomor, if(3 > length(penjualan.nomor), 3, length(penjualan.nomor)), '0') ) as nomor_penjualan from penjualan where id = ?");
 $execute->bind_param("i", $penjualan_id);
 $execute->execute();
 $result = $execute->get_result();
 $dataPenjualan = $result->fetch_assoc();

 $customer_id = $dataPenjualan['customer_id'] ?? null;
 $execute = $koneksi->prepare("select * from customer where id = ?");
 $execute->bind_param("i", $customer_id);
 $execute->execute();
 $result = $execute->get_result();
 $dataCustomer = $result->fetch_assoc();

 $cabang_id = $dataPenjualan['cabang_id'] ?? "";
 $execute = $koneksi->prepare("select * from cabang where id = ?");
 $execute->bind_param("i", $cabang_id);
 $execute->execute();
 $result = $execute->get_result();
 $dataCabang = $result->fetch_assoc();

 $execute = $koneksi->prepare("select * from tanda_tangan");
 $execute->execute();
 $result = $execute->get_result();
 $dataTandaTangan = $result->fetch_assoc();

 $bank_id = $dataPenjualan['bank_id'] ?? "";
 $execute = $koneksi->prepare("select * from bank where id = ?");
 $execute->bind_param("i", $bank_id);
 $execute->execute();
 $result = $execute->get_result();
 $dataBank = $result->fetch_assoc();

 $nama_file = generateRandomString().".pdf";

 $html = '<table style="border:1px solid black; border-collapse:collapse; margin-left:auto; margin-right:auto;" cellpadding="0" cellspacing="0" border="1">
           <tr>
            <td>

             <table style="border-collapse:collapse;" cellpadding="0" cellspacing="0">
              <tr>
               <th colspan="3" style="padding:5px 7px; text-align:center; text-decoration:underline;">
                Kwitansi<br><br><br>
               </th>
              </tr>
              <tr>
               <td style="padding:5px 7px; vertical-align:top;">Sudah Terima Dari</td>
               <td style="padding:5px 7px; vertical-align:top; text-align:center;">:</td>
               <td style="padding:5px 7px; vertical-align:top; width:450px; vertical-align:top;">
                '.($dataCustomer['nama'] ?? null).'
               </td>
              </tr>
              <tr>
               <td style="padding:5px 7px; vertical-align:top;">Uang Sebesar</td>
               <td style="padding:5px 7px; vertical-align:top; text-align:center;">:</td>
               <td style="padding:5px 7px; vertical-align:top; width:450px;">
                Rp. '.(formatAngka($dataPenjualanPembayaran['nominal']) ?? null).'
               </td>
              </tr>
              <tr>
               <td style="padding:5px 7px; vertical-align:top;">Untuk Pembayaran</td>
               <td style="padding:5px 7px; vertical-align:top; text-align:center;">:</td>
               <td style="padding:5px 7px; vertical-align:top; width:450px;">
                '.($dataPenjualanPembayaran['keterangan'] ?? null).'
               </td>
              </tr>
              <tr>
               <td style="padding:5px 7px; vertical-align:top;">Nomor Invoice</td>
               <td style="padding:5px 7px; vertical-align:top; text-align:center;">:</td>
               <td style="padding:5px 7px; vertical-align:top; width:450px;">
                '.($dataPenjualan['nomor_penjualan'] ?? null).'
               </td>
              </tr>
              <tr>
               <td style="padding:5px 7px; vertical-align:top;">Terbilang</td>
               <td style="padding:5px 7px; vertical-align:top; text-align:center;">:</td>
               <td style="padding:5px 5px 0px 5px; vertical-align:top; width:450px;">
                <table style="width:100%;">
                 <tr>
                  <td style="padding:5px 7px; background: repeating-linear-gradient(to bottom, #00000010 0px, #00000010 0.1px, #fff 0.5px, #fff 5px);">
                   '.(terbilang($dataPenjualanPembayaran['nominal']) ?? null).' Rupiah
                  </td>
                 </tr>
                </table>
               </td>
              </tr>
              <tr>
               <td colspan="3">

                <table style="width:100%;">
                 <tr>
                  <td style="vertical-align:bottom;">
                   <table style="font-size:11px;">
                    <tr>
                     <th style="vertical-align:top; text-align:left;">Nama Bank</th>
                     <th style="vertical-align:top; width:20px; text-align:center;">:</th>
                     <th style="vertical-align:top; text-align:left;">'.($dataBank['nama_bank'] ?? '').'</th>
                    </tr>
                    <tr>
                     <th style="vertical-align:top; text-align:left;">Nomor Rekening</th>
                     <th style="vertical-align:top; width:20px; text-align:center;">:</th>
                     <th style="vertical-align:top; text-align:left;">'.($dataBank['nomor_rekening'] ?? '').'</th>
                    </tr>
                    <tr>
                     <th style="vertical-align:top; text-align:left;">Nama Rekening</th>
                     <th style="vertical-align:top; width:20px; text-align:center;">:</th>
                     <th style="vertical-align:top; text-align:left;">'.($dataBank['nama_rekening'] ?? '').'</th>
                    </tr>
                   </table>
                  </td>
                  <td style="vertical-align:top; text-align:right;">

                   <table>
                    <tr>
                     <td style="text-align:center;">
                      <br>
                      '.($dataCabang['kabupaten_kota'] ?? null).', '.format_tanggal($dataPenjualanPembayaran['tanggal']).'<br><b>'.$nama_perusahaan.'</b>
                      <br><br><br><br><br><br>
                      <b style="text-decoration:underline;">'.($dataTandaTangan['nama']).'</b><br>
                      <b>'.($dataTandaTangan['jabatan']).'</b>
                     </td>
                    </tr>
                   </table>

                  </td>
                  
                 </tr>
                </table>

               </td>
              </tr>
             </table>

            </td>
           </tr>
          </table>

          ';

 require '../../vendor/autoload.php';
 $mpdf = new \Mpdf\Mpdf([
  'default_font_size' => 10,
 ]);
 $mpdf->AddPage('P','','','','', 5, 5, 5, 5, 0, 0);
 $mpdf->WriteHTML($html);
 $mpdf->Output($lokasi_folder.$nama_file, 'F');
 echo str_replace("..", "action", $lokasi_folder.$nama_file);

?>