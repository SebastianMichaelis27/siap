<?php

 include("../bjksadkhrej121lkjkjk.php");

 $penjualan_id = $_POST['id'] ?? null;

 $lokasi_folder = "../export/";
 if(!is_dir($lokasi_folder))
  { mkdir($lokasi_folder, 0755);
  }
 $lokasi_folder .= $username."/";
 $lokasi_folder .= "penjualan/";
 if(!is_dir($lokasi_folder))
  { mkdir($lokasi_folder, 0755);
  }
 deleteDirectory($lokasi_folder);
 if(!is_dir($lokasi_folder))
  { mkdir($lokasi_folder, 0755);
  }

 $execute = $koneksi->prepare("select * from perusahaan");
 $execute->execute();
 $result = $execute->get_result();
 $dataPerusahaan = $result->fetch_assoc();
 $nama_perusahaan = $dataPerusahaan['nama_perusahaan'] ?? '';

 $execute = $koneksi->prepare("select * from cabang where id = (select cabang_id from penjualan where id = ?)");
 $execute->bind_param("i", $penjualan_id);
 $execute->execute();
 $result = $execute->get_result();
 $dataCabang = $result->fetch_assoc();

 $execute = $koneksi->prepare("select penjualan.*, concat(penjualan.kode, right(year(penjualan.tanggal), 2), lpad(month(penjualan.tanggal), 2, '0'), lpad(day(penjualan.tanggal), 2, '0'), '-MIE-', lpad(penjualan.nomor, if(3 > length(penjualan.nomor), 3, length(penjualan.nomor)), '0') ) as nomor_penjualan from penjualan where id = ?");
 $execute->bind_param("i", $penjualan_id);
 $execute->execute();
 $result = $execute->get_result();
 $dataPenjualan = $result->fetch_assoc();

 $detail = (isset($dataPenjualan['detail']) && $dataPenjualan['detail'] !== "") ? json_decode($dataPenjualan['detail'], true) : array();

 $pesanan_detail_id = array_column($detail, 'pesanan_detail_id');
 $placeholders = implode(',', array_fill(0, count($pesanan_detail_id), '?'));
 $types = str_repeat('i', count($pesanan_detail_id));

 $execute = $koneksi->prepare("select pesanan.nomor_po from pesanan_detail left join pesanan on pesanan_detail.pesanan_id = pesanan.id where pesanan_detail.id in (".$placeholders.") group by pesanan.id");
 $execute->bind_param($types, ...$pesanan_detail_id);
 $execute->execute();
 $result = $execute->get_result();
 $dataNomorPO = $result->fetch_all(MYSQLI_ASSOC);
 $dataNomorPO = array_values(array_unique(array_column($dataNomorPO, 'nomor_po')));

 $nomor_po = implode(", ", $dataNomorPO);
 if($nomor_po !== "")
  { $nomor_po .= '<tr>
                   <td style="text-align:left;">Nomor PO</td>
                   <td style="text-align:center;">:</td>
                   <td>'.$nomor_po.'</td>
                  </tr>';
  }

 $customer_id = $dataPenjualan['customer_id'] ?? null;
 $execute = $koneksi->prepare("select * from customer where id = ?");
 $execute->bind_param("i", $customer_id);
 $execute->execute();
 $result = $execute->get_result();
 $dataCustomer = $result->fetch_assoc();

 $bank_id = $dataPenjualan['bank_id'] ?? null;
 $execute = $koneksi->prepare("select * from bank where id = ?");
 $execute->bind_param("i", $bank_id);
 $execute->execute();
 $result = $execute->get_result();
 $dataBank = $result->fetch_assoc();

 $tanda_tangan_id = $dataPenjualan['tanda_tangan_id'] ?? null;
 $execute = $koneksi->prepare("select * from tanda_tangan where id = ?");
 $execute->bind_param("i", $tanda_tangan_id);
 $execute->execute();
 $result = $execute->get_result();
 $dataTandaTangan = $result->fetch_assoc();
 $tanda_tangan = "";
 if(isset($dataTandaTangan['file_ttd']) && $dataTandaTangan['file_ttd'] !== "" && file_exists("../../gambar/tanda-tangan/".$dataTandaTangan['file_ttd']))
  { $tanda_tangan = "<img src='../../gambar/tanda-tangan/".$dataTandaTangan['file_ttd']."' style='height:80px;'>";
  }
 else
  { $tanda_tangan = "<br><br><br><br><br>";
  }

 $sub_total = 0;
 $total_diskon = 0;
 $list = '';
 for($i=0; $i<count($detail); $i++)
  { $list .= '<tr>
               <td style="text-align:left; border-bottom:1px solid black;">'.$detail[$i]['nama_produk'].'</td>
               <td style="text-align:left; width:100px; border-bottom:1px solid black;">'.$detail[$i]['satuan'].'</td>
               <td style="text-align:right; width:120px; border-bottom:1px solid black;">'.formatAngka($detail[$i]['harga']).'</td>
               <td style="text-align:right; width:50px; border-bottom:1px solid black;">'.formatAngka($detail[$i]['jumlah']).'</td>
               <td style="text-align:right; width:120px; border-bottom:1px solid black;">'.formatAngka($detail[$i]['jumlah'] * $detail[$i]['harga']).'</td>
              </tr>';
    $sub_total += $detail[$i]['jumlah'] * $detail[$i]['harga'];
    $total_diskon += $detail[$i]['diskon_item'] + $detail[$i]['diskon_faktur'];
  }

 $header = '<div>
             <table style="width:100%;" cellpadding="0" cellspacing="0">
              <tr>
               <td>
                <img src="'.__DIR__.'/../../dist/img/logo_landscape.png" style="width:350px;">
                <table style="margin-top:5px;"><tr><td>'.(nl2br(($dataCabang['alamat'] ?? ""))).'</td></tr></table>
               </td>
               <td style="font-size:20px; vertical-align:top; text-align:right;">
                <table cellpadding="0" cellspacing="0">
                 <tr>
                  <td style="text-align:left;">
                   <b>'.($dataPenjualan['nomor_penjualan'] ?? "").'</b>
                   <table cellpadding="0" cellspacing="0">
                    <tr>
                     <td style="text-align:left;">Tanggal</td>
                     <td style="width:20px; text-align:center;">:</td>
                     <td>'.(sebutkan_tanggal($dataPenjualan['tanggal']) ?? "").'</td>
                    </tr>
                    <tr>
                     <td style="text-align:left;">Hari</td>
                     <td style="text-align:center;">:</td>
                     <td>'.(sebutkanHari($dataPenjualan['tanggal']) ?? "").'</td>
                    </tr>
                    '.$nomor_po.'
                   </table>
                  </td>
                 </tr>
                </table>
               </td>
              </tr>
             </table>
            </div>';

 $nama_file = generateRandomString().".pdf";

 require '../../vendor/autoload.php';
 $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
 $fontDirs = $defaultConfig['fontDir'];
 $fontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
 $fontData = $fontConfig['fontdata'];
 $mpdf = new \Mpdf\Mpdf([
  'fontDir' => array_merge($fontDirs, [
   '../../dist/font', // arahkan ke folder font kamu
  ]),
  'fontdata' => $fontData + [
    'derringer' => [
        'R' => 'Derringer-Serial-Regular.ttf',
    ]
  ],
  'default_font' => 'derringer'
 ]);
 $mpdf->SetHTMLHeader($header);
 $mpdf->AddPage('P','','','','', 4, 4, 35, 10, 4, 10);
 $currentY = $mpdf->y;

 $mpdf->WriteHTML('<div style="padding:0px 55px 0px 50px;">
                    <table>
                     <tr>
                      <th style="text-align:left; vertical-align:top;">BILLED TO</th>
                      <th style="text-align:center; width:30px; vertical-align:top;">:</th>
                      <td style="text-align:left; vertical-align:top;">
                       <b>'.strtoupper(($dataCustomer['nama']) ?? "").'</b><br>
                       '.nl2br($dataCustomer['alamat'] ?? "").'
                      </td>
                     </tr>
                     <tr>
                      <th colspan="3" style="text-align:left;">
                       <br>
                       PAYMENT INFORMATION
                      </th>
                     </tr>
                     <tr>
                      <td>Bank</td>
                      <td></td>
                      <td>'.($dataBank['nama_bank'] ?? "").'</td>
                     </tr>
                     <tr>
                      <td>Account Name</td>
                      <td></td>
                      <td>'.($dataBank['nama_rekening'] ?? "").'</td>
                     </tr>
                     <tr>
                      <td>Account Number</td>
                      <td></td>
                      <td>'.($dataBank['nomor_rekening'] ?? "").'</td>
                     </tr>
                    </table>
                    <br>
                    <table style="width:100%; border-collapse:collapse;" cellspacing="0" cellpadding="4">
                     <tr>
                      <th style="text-align:left; vertical-align:top; border-bottom:1px solid black;">DESCRIPTION</th>
                      <th style="text-align:left; vertical-align:top; width:100px; border-bottom:1px solid black;">SAT</th>
                      <th style="text-align:right; vertical-align:top; width:120px; border-bottom:1px solid black;">PRICE</th>
                      <th style="text-align:right; vertical-align:top; width:50px; border-bottom:1px solid black;">QTY</th>
                      <th style="text-align:right; vertical-align:top; width:120px; border-bottom:1px solid black;">TOTAL</th>
                     </tr>
                     '.$list.'
                    </table>
                   </div>');

 /*
 //Menghitung tinggi baris----------------------------------------------------------------------------------------
 $awalY = $mpdf->y;
 $mpdf->WriteHTML('<div style="padding:0px 55px 0px 50px;">
                    <table style="width:100%; border-collapse:collapse;" cellspacing="0" cellpadding="4">
                     <tr>
                      <td style="text-align:left; vertical-align:top; border-bottom:1px solid black;">Barang</td>
                      <td style="text-align:left; vertical-align:top; width:100px; border-bottom:1px solid black;">Pcs</td>
                      <td style="text-align:right; vertical-align:top; width:120px; border-bottom:1px solid black;">3.000.000</td>
                      <td style="text-align:right; vertical-align:top; width:50px; border-bottom:1px solid black;">2</th>
                      <td style="text-align:right; vertical-align:top; width:120px; border-bottom:1px solid black;">6.000.000</td>
                     </tr>
                    </table>
                   </div>');
 $akhirY = $mpdf->y;
 $tinggiBaris = $akhirY - $awalY;
 //Menghitung tinggi baris----------------------------------------------------------------------------------------
 */

 $tinggiBaris = 8;
 $currentY = $mpdf->y;
 $pageHeight = $mpdf->h;
 $bottomMargin = $mpdf->bMargin;
 $sisaRuang = $pageHeight - $bottomMargin - $currentY;
 $sisaBaris = floor($sisaRuang / $tinggiBaris);

 $sisaBaris -= 11; //kurangi baris untuk space sub total, ppn, grand total dan tanda tangan

 $row_diskon = '';
 if($total_diskon > 0)
  { $row_diskon = '<tr>
                    <td style="text-align:left; vertical-align:top;">Diskon</td>
                    <td style="text-align:right; vertical-align:top; width:120px;">'.formatAngka($total_diskon).'</td>
                   </tr>
                   <tr>
                    <td style="text-align:left; vertical-align:top;">Harga Setelah Diskon</td>
                    <td style="text-align:right; vertical-align:top; width:120px;">'.formatAngka($sub_total - $total_diskon).'</td>
                   </tr>';
    $sisaBaris -= 2;
  }
 $row_grand_total = '<tr>
                      <th style="text-align:left; vertical-align:top; border-top:1px solid black;">GRAND TOTAL</th>
                      <th style="text-align:right; vertical-align:top; width:120px; border-top:1px solid black;">'.formatAngka($dataPenjualan['total']).'</th>
                     </tr>';
 if($dataPenjualan['dibayar'] * 1 > 0)
  { $sisaBaris -= 2;
    $sisa_pelunasan = $dataPenjualan['total'] - $dataPenjualan['dibayar'];
    if($sisa_pelunasan < 0)
     { $sisa_pelunasan = 0;
     }
    $row_grand_total = '<tr>
                         <th style="text-align:left; vertical-align:top;">GRAND TOTAL</th>
                         <th style="text-align:right; vertical-align:top; width:120px;">'.formatAngka($dataPenjualan['total']).'</th>
                        </tr>
                        <tr>
                         <td style="text-align:left; vertical-align:top;">UANG MUKA</td>
                         <td style="text-align:right; vertical-align:top; width:120px;">'.formatAngka($dataPenjualan['dibayar']).'</td>
                        </tr>
                        <tr>
                         <th style="text-align:left; vertical-align:top; border-top:1px solid black;">SISA PELUNASAN</th>
                         <th style="text-align:right; vertical-align:top; width:120px; border-top:1px solid black;">'.formatAngka($sisa_pelunasan).'</th>
                        </tr>';
  }

 for($i=0; $i<$sisaBaris; $i++)
  { $mpdf->WriteHTML('<div style="padding:0px 55px 0px 50px;">
                       <table style="width:100%; border-collapse:collapse;" cellspacing="0" cellpadding="4">
                        <tr>
                         <td colspan="5" style="text-align:left; vertical-align:top; border-bottom:1px solid black;">&nbsp;</td>
                        </tr>
                       </table>
                      </div>');
  }

 $mpdf->WriteHTML('<div style="padding:0px 55px 0px 50px;">
                    <table style="width:100%; border-collapse:collapse;" cellspacing="0" cellpadding="4">
                     <tr>
                      <td style="text-align:left; vertical-align:top;">Sub Total</td>
                      <td style="text-align:right; vertical-align:top; width:120px;">'.formatAngka($sub_total).'</td>
                     </tr>
                     '.$row_diskon.'
                     <tr>
                      <td style="text-align:left; vertical-align:top;">PPN</td>
                      <td style="text-align:right; vertical-align:top; width:120px;">'.formatAngka($dataPenjualan['ppn']).'</td>
                     </tr>
                     '.$row_grand_total.'
                     <tr>
                      <td colspan="2" style="text-align:justify;">
                       <br>
                       Payment is required within '.formatAngka($dataPenjualan['batas_waktu_pembayaran']).' business days of invoice date. Please send remittance to frencoolgroup@gmail.com. <br><br>
                       Thank you for your business.
                      </td>
                     </tr>
                    </table>
                    <table style="width:100%;">
                     <tr>
                      <td style="text-align:right;">

                       <table>
                        <tr>
                         <td style="text-align:center;">
                          Hormat Kami,<br>
                          <b>'.$nama_perusahaan.'</b><br>
                          '.$tanda_tangan.'<br>
                          <b>'.($dataTandaTangan['nama'] ?? "").'</b>
                          <div style="border-top:1px solid black;"><b>'.($dataTandaTangan['jabatan'] ?? "").'</b></div>
                         </td>
                        </tr>
                       </table>

                       
                      </td>
                     </tr>
                    </table>
                   </div>');

 $mpdf->Output($lokasi_folder.$nama_file, 'F');
 echo str_replace("..", "action", $lokasi_folder.$nama_file);

?>