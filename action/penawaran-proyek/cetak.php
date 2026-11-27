<?php

 include("../bjksadkhrej121lkjkjk.php");

 $lokasi_folder = "../export/";
 if(!is_dir($lokasi_folder))
  { mkdir($lokasi_folder, 0755);
  }
 $lokasi_folder .= $username."/";
 $lokasi_folder .= "penawaran-proyek/";
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
 $query = "select penawaran_proyek.*, concat(penawaran_proyek.kode, '/', lpad(penawaran_proyek.nomor, if(3 > length(penawaran_proyek.nomor), 3, length(penawaran_proyek.nomor)), '0'), '/MIE/', to_roman(month(tanggal)), '/', penawaran_proyek.tahun) as nomor_penawaran, kata_pengantar.kata_pengantar from penawaran_proyek left join kata_pengantar on penawaran_proyek.kata_pengantar_id = kata_pengantar.id where penawaran_proyek.id = '".intval($_POST['id'])."'";
 $execute = mysqli_query($koneksi, $query);

 $id = intval($_POST['id']);
 $execute = $koneksi->prepare("select penawaran_proyek.*, concat(penawaran_proyek.kode, '/', lpad(penawaran_proyek.nomor, if(3 > length(penawaran_proyek.nomor), 3, length(penawaran_proyek.nomor)), '0'), '/MIE/', to_roman(month(tanggal)), '/', penawaran_proyek.tahun) as nomor_penawaran, kata_pengantar.kata_pengantar from penawaran_proyek left join kata_pengantar on penawaran_proyek.kata_pengantar_id = kata_pengantar.id where penawaran_proyek.id = ?");
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

 $total = 0;
 $diskon = 0;
 foreach($dataPenawaran['detail'] as $key => $data)
  { $no++;
    $list .= "<tr>
               <td style='border:1px solid black; padding:5px; text-align:right;'>".($no)."</td>
               <td style='border:1px solid black; padding:5px;'></td>
               <td style='border:1px solid black; padding:5px; text-align:center;'></td>
               <td style='border:1px solid black; padding:5px; text-align:right;'></td>
               <td style='border:1px solid black; padding:5px; text-align:right;'></td>
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

 $html = "<div style='font-size:14px; padding:0px 2cm;'>
           <table style='width:100%; margin:0px; padding:0px;' cellpadding='0px' cellspacing='0px'>
            <tr>
             <td style='width:30px; font-size:12px;'>No</td>
             <td style='text-align:center; width:10px; font-size:12px;'>:</td>
             <td style='width:350px; font-size:12px;'></td>
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
              <th style='border:1px solid black; padding:5px; width:90px;'>Price</th>
              <th style='border:1px solid black; padding:5px; width:110px;'>Amount</th>
             </tr>
            </thead>
            <tbody>
             ".$list."
             <tr>
              <th style='border:1px solid black; padding:5px; text-align:center;' colspan='".$colspan."'>Total</th>
              <th style='border:1px solid black; padding:5px; text-align:right;'>".formatAngka($total)."</th>
             </tr>
             <tr>
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