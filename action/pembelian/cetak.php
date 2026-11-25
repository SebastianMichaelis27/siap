<?php

 include("../bjksadkhrej121lkjkjk.php");

 $lokasi_folder = "../export/";
 if(!is_dir($lokasi_folder))
  { mkdir($lokasi_folder, 0755);
  }
 $lokasi_folder .= $username."/";
 $lokasi_folder .= "pembelian/";
 if(!is_dir($lokasi_folder))
  { mkdir($lokasi_folder, 0755);
  }
 deleteDirectory($lokasi_folder);
 if(!is_dir($lokasi_folder))
  { mkdir($lokasi_folder, 0755);
  }

 $id = intval($_POST['id']);

 $execute = $koneksi->prepare("select pembelian.*, concat(pembelian.kode, right(year(pembelian.tanggal), 2), lpad(month(pembelian.tanggal), 2, '0'), lpad(day(pembelian.tanggal), 2, '0'), '-MIE-', lpad(pembelian.nomor, if(3 > length(pembelian.nomor), 3, length(pembelian.nomor)), '0') ) as nomor_pembelian from pembelian where id = ?");
 $execute->bind_param("i", $id);
 $execute->execute();
 $result = $execute->get_result();
 $dataPemesanan = $result->fetch_assoc();

 $detail = array();
 if(isset($dataPemesanan['detail']) && $dataPemesanan['detail'] !== "")
  { $dataPemesanan['detail'] = str_replace('}"', '}', str_replace('"{', '{', str_replace(']"', ']', str_replace('"[', '[', $dataPemesanan['detail']))));
    $detail = json_decode($dataPemesanan['detail'], true);
  }

 $barang_id = array_column($detail, 'barang_id');
 $placeholders = implode(',', array_fill(0, count($barang_id), '?'));
 $types = str_repeat('i', count($barang_id));

 $execute = $koneksi->prepare("select * from barang where id in (".$placeholders.")");
 $execute->bind_param($types, ...$barang_id);
 $execute->execute();
 $result = $execute->get_result();
 $dataBarang = $result->fetch_all(MYSQLI_ASSOC);
 $map_unit = array_column($dataBarang, 'unit', 'id');
 $map_cap = array_column($dataBarang, 'cap', 'id');
 $map_description = array_column($dataBarang, 'cap', 'id');
 $map_satuan_id = array_column($dataBarang, 'satuan_id', 'id');
 foreach($detail as &$item)
  { $item['unit'] = $map_unit[$item['barang_id']] ?? null;
    $item['cap'] = $map_cap[$item['barang_id']] ?? null;
    $item['description'] = $map_description[$item['barang_id']] ?? null;
    $item['satuan_id'] = $map_satuan_id[$item['barang_id']] ?? null;
  }
 unset($item);

 $satuan_id = array_column($detail, 'satuan_id');
 $placeholders = implode(',', array_fill(0, count($satuan_id), '?'));
 $types = str_repeat('i', count($satuan_id));

 $execute = $koneksi->prepare("select * from satuan where id in (".$placeholders.")");
 $execute->bind_param($types, ...$satuan_id);
 $execute->execute();
 $result = $execute->get_result();
 $dataSatuan = $result->fetch_all(MYSQLI_ASSOC);
 $map_satuan = array_column($dataSatuan, 'satuan', 'id');
 foreach($detail as &$item)
  { $item['satuan'] = $map_satuan[$item['satuan_id']] ?? null;
  }
 unset($item);

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
               <td style='border:0.5px solid #000000; text-align:center; padding:2px 5px;'>".$detail[$i]['unit']."</td>
               <td style='border:0.5px solid #000000; text-align:center; padding:2px 5px;'>".$detail[$i]['cap']."</td>
               <td style='border:0.5px solid #000000; text-align:center; padding:2px 5px;'>".$detail[$i]['description']."</td>
               <td style='border:0.5px solid #000000; text-align:right; padding:2px 5px;'>".formatAngka($detail[$i]['harga'])."</td>
               <td style='border:0.5px solid #000000; text-align:center; padding:2px 5px;'>".formatAngka($detail[$i]['jumlah'])."</td>
               <td style='border:0.5px solid #000000; text-align:center; padding:2px 5px;'>".$diskon."</td>
               <td style='border:0.5px solid #000000; text-align:center; padding:2px 5px;'>".$add_diskon."</td>
               <td style='border:0.5px solid #000000; text-align:center; padding:2px 5px;'>".$detail[$i]['satuan']."</td>
               <td style='border:0.5px solid #000000; text-align:right; padding:2px 5px;'>".formatAngka($detail[$i]['sub_total_sebelum_ppn'])."</td>
              </tr>";
  }

 $supplier_id = intval($dataPemesanan['supplier_id']);
 $execute = $koneksi->prepare("select * from supplier where id = ?");
 $execute->bind_param("i", $supplier_id);
 $execute->execute();
 $result = $execute->get_result();
 $dataSupplier = $result->fetch_assoc();

 $tanda_tangan_id = $dataPemesanan['tanda_tangan_id'] ?? null;
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

 $diskon_faktur = "";
 if(isset($dataPemesanan['diskon']) && $dataPemesanan['diskon'] * 1 > 0)
  { $diskon_faktur .= "<tr>
                        <td colspan='5'></td>
                        <td colspan='3' style='border:0.5px solid #000000; text-align:right; padding:2px 5px;'>DISC</td>
                        <td style='border:0.5px solid #000000; text-align:right; padding:2px 5px;'>".formatAngka($dataPemesanan['diskon'])."</td>
                       </tr>";
  }

 $html = "<div style='font-size:11px; padding:0px 2cm;'>
           <b>Supplier :</b> ".$dataSupplier['nama']."
           <table style='width:100%; border-collapse:collapse; margin-top:10px; font-size:11px;' cellpadding='0px' cellspacing='0px'>
            <thead>
             <tr>
              <th style='border:0.5px solid #000000; padding:2px 5px;'>UNIT</th>
              <th style='border:0.5px solid #000000; padding:2px 5px;'>CAP</th>
              <th style='border:0.5px solid #000000; padding:2px 5px;'>DESCRIPTION</th>
              <th style='border:0.5px solid #000000; padding:2px 5px;'>PRICE</th>
              <th style='border:0.5px solid #000000; padding:2px 5px;'>QTY</th>
              <th style='border:0.5px solid #000000; padding:2px 5px; width:50px;'>DISC</th>
              <th style='border:0.5px solid #000000; padding:2px 5px; width:70px;'>ADD DISC</th>
              <th style='border:0.5px solid #000000; padding:2px 5px;'>SAT</th>
              <th style='border:0.5px solid #000000; padding:2px 5px;'>SUB TOTAL</th>
             </tr>
            </thead>
            <tbody>
             ".$list.$diskon_faktur."
             <tr>
              <td colspan='5'></td>
              <th colspan='3' style='border:0.5px solid #000000; text-align:right; padding:2px 5px;'>TOTAL EXC VAT(Rp)</th>
              <th style='border:0.5px solid #000000; text-align:right; padding:2px 5px;'>".formatAngka($dataPemesanan['dpp'])."</th>
             </tr>
             <tr>
              <td colspan='5'></td>
              <th colspan='3' style='border:0.5px solid #000000; text-align:right; padding:2px 5px;'>TOTAL INC VAT(Rp)</th>
              <th style='border:0.5px solid #000000; text-align:right; padding:2px 5px;'>".formatAngka($dataPemesanan['total'])."</th>
             </tr>
            </tbody>
           </table>
           <table>
            <tr>
             <td>
              <div style='font-size:11px; font-weight:bold;'>No. PO : ".($dataPemesanan['nomor_pembelian'] ?? "")."</div>
              <div style='font-size:11px; font-weight:bold;'>".$dataPemesanan['kabupaten_kota'].", ".format_tanggal($dataPemesanan['tanggal'])."</div>
              <div style='height:80px;'>".$tanda_tangan."</div>
              <div style='font-size:11px; font-weight:bold;'>".($dataTandaTangan['nama'] ?? "")."</div>
              <div style='font-size:11px; font-weight:bold; border-top:1px solid black; width:100%;'>".($dataTandaTangan['jabatan'] ?? "")."</div>
             </td>
            </tr>
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