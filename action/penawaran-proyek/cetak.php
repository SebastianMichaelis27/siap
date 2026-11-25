<?php

 include("../bjksadkhrej121lkjkjk.php");

 $lokasi_folder = "../export/";
 if(!is_dir($lokasi_folder))
  { mkdir($lokasi_folder, 0755);
  }
 $lokasi_folder .= $username."/";
 $lokasi_folder .= "penawaran/";
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

 $filter_barang = "";
 
 $dataRows = array();
 $query = "select penawaran.*, concat(penawaran.kode, '/', lpad(penawaran.nomor, if(3 > length(penawaran.nomor), 3, length(penawaran.nomor)), '0'), '/MIE/', to_roman(month(tanggal)), '/', penawaran.tahun) as nomor_penawaran, kata_pengantar.kata_pengantar from penawaran left join kata_pengantar on penawaran.kata_pengantar_id = kata_pengantar.id where penawaran.id = '".intval($_POST['id'])."'";
 $execute = mysqli_query($koneksi, $query);

 $id = intval($_POST['id']);
 $execute = $koneksi->prepare("select penawaran.*, concat(penawaran.kode, '/', lpad(penawaran.nomor, if(3 > length(penawaran.nomor), 3, length(penawaran.nomor)), '0'), '/MIE/', to_roman(month(tanggal)), '/', penawaran.tahun) as nomor_penawaran, kata_pengantar.kata_pengantar from penawaran left join kata_pengantar on penawaran.kata_pengantar_id = kata_pengantar.id where penawaran.id = ?");
 $execute->bind_param("i", $id);
 $execute->execute();
 $result = $execute->get_result();
 $dataPenawaran = $result->fetch_assoc();

 $customer_id = $dataPenawaran['customer_id'] ?? null;
 $tanggal = $dataPenawaran['tanggal'] ?? null;
 $kata_pengantar = $dataPenawaran['kata_pengantar'] ?? null;
 $nomor_penawaran = $dataPenawaran['nomor_penawaran'] ?? null;
 $total_keseluruhan = $dataPenawaran['total'];
 $terbilang = terbilang($dataPenawaran['total'] * 1) ?? null;
 $detail = isset($dataPenawaran['detail']) && $dataPenawaran['detail'] !== "" ? json_decode($dataPenawaran['detail'], true) : array();
 $dataPenawaran['detail'] = $detail;

 $barang_id = array_column($detail, 'barang_id');
 $placeholders = implode(',', array_fill(0, count($barang_id), '?'));
 $types = str_repeat('i', count($barang_id));

 $execute = $koneksi->prepare("select * from barang where id in (".$placeholders.")");
 $execute->bind_param($types, ...$barang_id);
 $execute->execute();
 $result = $execute->get_result();
 $arrayBarang = $result->fetch_all(MYSQLI_ASSOC);

 $satuan_id = array_column($arrayBarang, 'satuan_id') ?? array();
 $placeholders = implode(',', array_fill(0, count($satuan_id), '?'));
 $types = str_repeat('i', count($satuan_id));

 $execute = $koneksi->prepare("select * from satuan where id in (".$placeholders.")");
 $execute->bind_param($types, ...$satuan_id);
 $execute->execute();
 $result = $execute->get_result();
 $arraySatuan = $result->fetch_all(MYSQLI_ASSOC);
 $map_satuan = array_column($arraySatuan, 'satuan', 'id');
 foreach($arrayBarang as &$item)
  { $item['satuan'] = $map_satuan[$item['satuan_id']] ?? null;
  }
 unset($item);

 $catatan_penawaran_id = $dataPenawaran['catatan_penawaran_id'] ?? "";
 $execute = $koneksi->prepare("select * from catatan_penawaran where id = ?");
 $execute->bind_param("i", $catatan_penawaran_id);
 $execute->execute();
 $result = $execute->get_result();
 $dataCatatan = $result->fetch_assoc();
 $dataPenawaran['catatan'] = isset($dataCatatan['catatan']) && $dataCatatan['catatan'] !== "" ? json_decode($dataCatatan['catatan'], true) : array();

 $list = "";
 $no = 0;
 $colspan = 4;

 $ada_diskon_item = false;
 foreach($dataPenawaran['detail'] as $key => $data)
  { if($data['diskon_item'] * 1 > 0 || $data['diskon_faktur'] * 1 > 0)
     { $ada_diskon_item = true;
     }
  }
 if($ada_diskon_item)
  { //$colspan++;
  }

 if($dataPenawaran['ppn'] * 1 > 0)
  { //$colspan++;
  }
 $total = 0;
 $total_ppn = 0;
 $diskon = 0;
 foreach($dataPenawaran['detail'] as $key => $data)
  { $no++;
    //$diskon = "";
    if($data['diskon_faktur'] * 1 > 0)
     { /*if($diskon == "")
        { $diskon .= "0 + ";
        }
       else
        { $diskon .= " + ";
        }*/
       //$diskon .= formatAngka($data['diskon_faktur']);
     }

    $total += $data['jumlah'] * $data['harga_sebelum_ppn'];
    $total_ppn += $data['nominal_ppn'];
    $diskon += ($data['diskon_item'] * 1) + ($data['diskon_faktur'] * 1);

    $list .= "<tr>
               <td style='border:1px solid black; padding:5px; text-align:right;'>".($no)."</td>
               <td style='border:1px solid black; padding:5px;'>".$data['nama_produk']."</td>
               <td style='border:1px solid black; padding:5px; text-align:center;'>".formatAngka($data['jumlah'])." ".$data['satuan']."</td>
               <td style='border:1px solid black; padding:5px; text-align:right;'>".formatAngka($data['harga_sebelum_ppn'])."</td>";
    if($ada_diskon_item)
     { //$list .= "<td style='border:1px solid black; padding:5px; text-align:right;'>".$diskon."</td>";
     }
    if($dataPenawaran['ppn'] * 1 > 0)
     { //$list .= "<td style='border:1px solid black; padding:5px; text-align:right;'>".$data['nominal_ppn']."</td>";
     }
    $list .= " <td style='border:1px solid black; padding:5px; text-align:right;'>".formatAngka($data['jumlah'] * $data['harga_sebelum_ppn'])."</td>
              </tr>";
  }

 $customer = "";
 $address = "";
 $no_telp = array();
 $no_wa = array();
 $email = array();
 $query = "select * from customer where id = '".intval($customer_id)."'";
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $customer = $row['nama'];
    $address = $row['alamat'];
    if(isset($row['no_telp']) && $row['no_telp'] !== "")
     { $no_telp = json_decode($row['no_telp'], true);
     }
    if(isset($row['no_wa']) && $row['no_wa'] !== "")
     { $no_wa = json_decode($row['no_wa'], true);
     }
    if(isset($row['email']) && $row['email'] !== "")
     { $email = json_decode($row['email'], true);
     }
  }
 $contact = "";
 foreach($no_telp as $key => $value)
  { if($contact !== "")
     { $contact .= ", ";
     }
    $contact .= $value['no_telp'];
  }
 $whatsapp = "";
 foreach($no_wa as $key => $value)
  { if($whatsapp !== "")
     { $whatsapp .= ", ";
     }
    $whatsapp .= $value['no_wa'];
  }
 $e_mail = "";
 foreach($email as $key => $value)
  { if($e_mail !== "")
     { $e_mail .= ", ";
     }
    $e_mail .= $value['email'];
  }

 $tanda_tangan_id = $dataPenawaran['tanda_tangan_id'] ?? null;
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

 $list_catatan = "";
 for($i=0; $i<count($dataPenawaran['catatan']); $i++)
  { $list_catatan .= "<tr>
                       <td style='padding-right:5px; font-size:11px;'>-</td>
                       <td style='font-size:11px;'>".$dataPenawaran['catatan'][$i]."</td>
                      </tr>";
  }
 if($list_catatan !== "")
  { $list_catatan = "<b style='font-size:11px;'>Catatan :</b><br><table border='0' cellpadding='0' cellspacing='0'>".$list_catatan."</table>";
  }

 $html = "<div style='font-size:12px; padding:0px 2cm;'>
           <table style='width:100%; margin:0px; padding:0px;' cellpadding='0px' cellspacing='0px'>
            <tr>
             <td style='width:30px; font-size:12px;'>No</td>
             <td style='text-align:center; width:10px; font-size:12px;'>:</td>
             <td style='width:350px; font-size:12px;'>".$nomor_penawaran."</td>
             <td style='text-align:right; font-size:12px;'>Medan, ".sebutkan_tanggal($tanggal)."</td>
            </tr>
            <tr>
             <td style='font-size:12px;'>Hal</td>
             <td style='font-size:12px; text-align:center;'>:</td>
             <td style='font-size:12px;' colspan='2'>Surat Penawaran</td>
            </tr>
           </table><br><br>
           Kepada Yth,<br><b>".$customer."</b><br>di<br><div style='padding-left:40px;'>Tempat</div>
           <div style='text-align:justify; margin-top:15px;'>
            ".$kata_pengantar."
           </div>
           <table style='border-collapse:collapse; margin-top:10px; margin-bottom:10px; width:100%; font-size:11px;'>
            <thead>
             <tr>
              <th style='border:1px solid black; padding:5px; width:50px;'>No.</th>
              <th style='border:1px solid black; padding:5px; text-align:left;'>Item</th>
              <th style='border:1px solid black; padding:5px; width:50px;'>Qty</th>
              <th style='border:1px solid black; padding:5px; width:90px;'>Price</th>";
 if($ada_diskon_item)
  { //$html .= "<th style='border:1px solid black; padding:5px; width:90px;'>Discount</th>";
  }
 if($dataPenawaran['ppn'] * 1 > 0)
  { //$html .= "<th style='border:1px solid black; padding:5px; width:80px;'>PPN</th>";
  }
 $html .= "   <th style='border:1px solid black; padding:5px; width:110px;'>Amount</th>
             </tr>
            </thead>
            <tbody>
             ".$list."
             <tr>
              <th style='border:1px solid black; padding:5px; text-align:center;' colspan='".$colspan."'>Total</th>
              <th style='border:1px solid black; padding:5px; text-align:right;'>".formatAngka($total)."</th>
             </tr>
             <tr>";
 if($diskon > 0)
  { $html .= "<tr>
               <th style='border:1px solid black; padding:5px; text-align:center;' colspan='".$colspan."'>Diskon</th>
               <th style='border:1px solid black; padding:5px; text-align:right;'>".formatAngka($diskon)."</th>
              </tr>";
  }
 $html .= "  <tr>
              <th style='border:1px solid black; padding:5px; text-align:center;' colspan='".$colspan."'>PPN</th>
              <th style='border:1px solid black; padding:5px; text-align:right;'>".formatAngka($total_ppn)."</th>
             </tr>
             <tr>
              <th style='border:1px solid black; padding:5px; text-align:center;' colspan='".$colspan."'>Grand Total</th>
              <th style='border:1px solid black; padding:5px; text-align:right;'>".formatAngka($total_keseluruhan)."</th>
             </tr>
            </tbody>
           </table>
           Demikianlah penawaran ini dibuat. Atas perhatian dan kerjasamanya kami ucapkan terimakasih.
           <table style='width:100%; margin-top:20px;'>
            <tr>
             <td>".$list_catatan."</td>
             <td style='width:280px; font-size:12px; text-align:center;'>
              <div style='text-align:center; font-size:12px;'>Hormat Kami,</div>
              <div style='text-align:center; font-size:12px; font-weight:bold;'>".$nama_perusahaan."</div>
              <div style='height:80px;'>".$tanda_tangan."</div>
              <div style='text-align:center; font-size:12px; font-weight:bold;'>".($dataTandaTangan['nama'] ?? "")."</div>
              <div style='text-align:center; font-size:12px; font-weight:bold; border-top:1px solid black;'>".($dataTandaTangan['jabatan'] ?? "")."</div>
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