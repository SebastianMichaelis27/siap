<?php

 include("../bjksadkhrej121lkjkjk.php");

 $lokasi_folder = "../export/";
 if(!is_dir($lokasi_folder))
  { mkdir($lokasi_folder, 0755);
  }
 $lokasi_folder .= $username."/";
 $lokasi_folder .= "pesanan/";
 if(!is_dir($lokasi_folder))
  { mkdir($lokasi_folder, 0755);
  }
 deleteDirectory($lokasi_folder);
 if(!is_dir($lokasi_folder))
  { mkdir($lokasi_folder, 0755);
  }

 $id = intval($_POST['id']);

 $execute = $koneksi->prepare("select pesanan.*, concat(pesanan.kode, right(year(pesanan.tanggal), 2), lpad(month(pesanan.tanggal), 2, '0'), lpad(day(pesanan.tanggal), 2, '0'), '-MIE-', lpad(pesanan.nomor, if(3 > length(pesanan.nomor), 3, length(pesanan.nomor)), '0') ) as nomor_pesanan from pesanan where id = ?");
 $execute->bind_param("i", $id);
 $execute->execute();
 $result = $execute->get_result();
 $dataPemesanan = $result->fetch_assoc();

 $detail = array();
 if(isset($dataPemesanan['detail']) && $dataPemesanan['detail'] !== "")
  { $dataPemesanan['detail'] = str_replace('}"', '}', str_replace('"{', '{', str_replace(']"', ']', str_replace('"[', '[', $dataPemesanan['detail']))));
    $detail = json_decode($dataPemesanan['detail'], true);
  }

 $cabang_id = $dataPemesanan['cabang_id'] ?? "";
 $execute = $koneksi->prepare("select * from cabang where id = ?");
 $execute->bind_param("i", $cabang_id);
 $execute->execute();
 $result = $execute->get_result();
 $dataCabang = $result->fetch_assoc();
 $dataPemesanan['kabupaten_kota'] = $dataCabang['kabupaten_kota'] ?? "";

 $list = "";
 for($i=0; $i<count($detail); $i++)
  { $diskon = "";
    $add_diskon = "";
    if(is_array($detail[$i]['diskon_item_detail']))
     { for($j=0; $j<count($detail[$i]['diskon_item_detail']); $j++)
        { $view_diskon = ""; 
          if($detail[$i]['diskon_item_detail'][$j] == "%")
           { $view_diskon = $detail[$i]['diskon_item_detail'][$j]['jumlah'].$detail[$i]['diskon_item_detail'][$j]['jenis'];
           }
          else
           { $view_diskon = $detail[$i]['diskon_item_detail'][$j]['jenis'].formatAngka($detail[$i]['diskon_item_detail'][$j]['jumlah']);
           }
          if($j == 0)
           { $diskon = $view_diskon;
           }
          else
           { if($add_diskon !== "")
              { $add_diskon .= " + ";
              }
             $add_diskon .= $view_diskon;
           }
        }
     }

    $list .= "<tr>
               <td style='border:0.5px solid #000000; text-align:center; padding:2px 5px;'>".$detail[$i]['nama_produk']."</td>
               <td style='border:0.5px solid #000000; text-align:right; padding:2px 5px;'>".formatAngka($detail[$i]['harga'])."</td>
               <td style='border:0.5px solid #000000; text-align:center; padding:2px 5px;'>".formatAngka($detail[$i]['jumlah'])."</td>
               <td style='border:0.5px solid #000000; text-align:center; padding:2px 5px;'>".$diskon."</td>
               <td style='border:0.5px solid #000000; text-align:center; padding:2px 5px;'>".$add_diskon."</td>
               <td style='border:0.5px solid #000000; text-align:center; padding:2px 5px;'>".$detail[$i]['satuan']."</td>
               <td style='border:0.5px solid #000000; text-align:right; padding:2px 5px;'>".formatAngka($detail[$i]['sub_total_sebelum_ppn'])."</td>
              </tr>";
  }

 $customer_id = intval($dataPemesanan['customer_id']);
 $execute = $koneksi->prepare("select * from customer where id = ?");
 $execute->bind_param("i", $customer_id);
 $execute->execute();
 $result = $execute->get_result();
 $dataCustomer = $result->fetch_assoc();

 $diskon_faktur = "";
 if(isset($dataPemesanan['diskon']) && $dataPemesanan['diskon'] * 1 > 0)
  { $diskon_faktur .= "<tr>
                        <td colspan='3'></td>
                        <td colspan='3' style='border:0.5px solid #000000; text-align:right; padding:2px 5px;'>DISC</td>
                        <td style='border:0.5px solid #000000; text-align:right; padding:2px 5px;'>".formatAngka($dataPemesanan['diskon'])."</td>
                       </tr>";
  }

 $html = "<div style='font-size:11px; padding:0px 2cm;'>
           <div style='text-align:center;'><b style='font-size:16px;'>Pesanan Masuk</b></div>
           <table cellpadding='0' cellspacing='0' style='margin-top:10px;'>
            <tr>
             <td style='font-size:12px;'>No. PO</td>
             <td style='font-size:12px; width:30px; text-align:center;'>:</td>
             <td style='font-size:12px;'>".$dataPemesanan['nomor_po']."</td>
            </tr>
            <tr>
             <td style='font-size:12px;'>Tanggal</td>
             <td style='font-size:12px; text-align:center;'>:</td>
             <td style='font-size:12px;'>".format_tanggal($dataPemesanan['tanggal'])."</td>
            </tr>
            <tr>
             <td style='font-size:12px;'>Customer</td>
             <td style='font-size:12px; text-align:center;'>:</td>
             <td style='font-size:12px;'>".$dataCustomer['nama']."</td>
            </tr>
           </table>
           <table style='width:100%; border-collapse:collapse; margin-top:10px; font-size:11px;' cellpadding='0px' cellspacing='0px'>
            <thead>
             <tr>
              <th style='border:0.5px solid #000000; padding:2px 5px;'>DESCRIPTION</th>
              <th style='border:0.5px solid #000000; padding:2px 5px;'>PRICE</th>
              <th style='border:0.5px solid #000000; padding:2px 5px; width:50px;'>QTY</th>
              <th style='border:0.5px solid #000000; padding:2px 5px; width:50px;'>DISC</th>
              <th style='border:0.5px solid #000000; padding:2px 5px; width:70px;'>ADD DISC</th>
              <th style='border:0.5px solid #000000; padding:2px 5px; width:50px;'>SAT</th>
              <th style='border:0.5px solid #000000; padding:2px 5px;'>SUB TOTAL</th>
             </tr>
            </thead>
            <tbody>
             ".$list.$diskon_faktur."
             <tr>
              <td colspan='3'></td>
              <th colspan='3' style='border:0.5px solid #000000; text-align:right; padding:2px 5px;'>TOTAL EXC VAT(Rp)</th>
              <th style='border:0.5px solid #000000; text-align:right; padding:2px 5px;'>".formatAngka($dataPemesanan['dpp'])."</th>
             </tr>
             <tr>
              <td colspan='3'></td>
              <th colspan='3' style='border:0.5px solid #000000; text-align:right; padding:2px 5px;'>TOTAL INC VAT(Rp)</th>
              <th style='border:0.5px solid #000000; text-align:right; padding:2px 5px;'>".formatAngka($dataPemesanan['total'])."</th>
             </tr>
            </tbody>
           </table>
          </div>";

 $nama_file = generateRandomString().".pdf";

 require '../../vendor/autoload.php';
 $mpdf = new \Mpdf\Mpdf();
 $mpdf->SetHTMLHeader('<img src="'.__DIR__.'/../../dist/img/kop.jpg" style="width:100%;">');
 $mpdf->SetHTMLFooter('<img src="'.__DIR__.'/../../dist/img/footer.png" style="width:100%;">');
 $mpdf->AddPage('P','','','','', 0, 0, 40, 40, 0, 0);
 $mpdf->WriteHTML($html);
 $mpdf->Output($lokasi_folder.$nama_file, 'F');
 echo str_replace("..", "action", $lokasi_folder.$nama_file);

?>