<?php

 include("../bjksadkhrej121lkjkjk.php");

 $doc_prepared_by = "";
 $query = "select nama from karyawan where id in (select karyawan_id from users where username = '".str_replace("'", "\'", $_POST['username'])."')";
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $doc_prepared_by = $row['nama'];
  }

 $lokasi_folder = "../export/";
 if(!is_dir($lokasi_folder))
  { mkdir($lokasi_folder, 0755);
  }
 $lokasi_folder .= $username."/";
 $lokasi_folder .= "pengiriman/";
 if(!is_dir($lokasi_folder))
  { mkdir($lokasi_folder, 0755);
  }
 deleteDirectory($lokasi_folder);
 if(!is_dir($lokasi_folder))
  { mkdir($lokasi_folder, 0755);
  }

 $tanggal = "";
 $penjualan_id = "";
 $nomor_pengiriman = "";
 $query = "select pengiriman.*, concat(pengiriman.kode, ' ', lpad(pengiriman.nomor, if(3 > length(pengiriman.nomor), 3, length(pengiriman.nomor)), '0'), '/', right(pengiriman.tahun, 2)) as nomor_pengiriman from pengiriman where id = '".intval($_POST['id'])."'";
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $penjualan_id = $row['penjualan_id'];
    $nomor_pengiriman = $row['nomor_pengiriman'];
    $tanggal = date('d-m-Y', strtotime($row['tanggal']));
  }

 $nomor_penjualan = "";
 $customer_id = "";
 $query = "select penjualan.*, concat(penjualan.kode, ' ', lpad(penjualan.nomor, if(3 > length(penjualan.nomor), 3, length(penjualan.nomor)), '0'), '/', right(penjualan.tahun, 2)) as nomor_penjualan from penjualan where id = '".intval($penjualan_id)."'";
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $nomor_penjualan = $row['nomor_penjualan'];
    $customer_id = $row['customer_id'];
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

 $list = "";
 $ship_by = "Ship By<br><br><br><br><br><br><hr style='margin-bottom:7px; margin-top:3px;'>Date :";
 $no = 0;
 $query = "select barang.kode, barang.nama, barang.merek, barang.model, barang.tipe, barang.jenis, pengiriman_detail.jumlah, rak.nama_rak, pengiriman.jenis_pengiriman from pengiriman_detail left join pengiriman on pengiriman_detail.pengiriman_id = pengiriman.id left join penjualan_detail_ditandai on pengiriman_detail.penjualan_detail_ditandai_id = penjualan_detail_ditandai.id left join penjualan_detail on penjualan_detail_ditandai.penjualan_detail_id = penjualan_detail.id left join barang_masuk_detail on penjualan_detail_ditandai.barang_masuk_detail_id = barang_masuk_detail.id left join rak on barang_masuk_detail.rak_id = rak.id left join barang on penjualan_detail.barang_id = barang.id left join satuan on barang.satuan_id = satuan.id where pengiriman_detail.pengiriman_id = '".intval($_POST['id'])."'";
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $no++;
    $item = $row['kode']." - ".$row['nama'];
    if(isset($row['merek']) && $row['merek'] !== "")
     { $item .= " ".$row['merek'];
     }
    if(isset($row['model']) && $row['model'] !== "")
     { $item .= " ".$row['model'];
     }
    if(isset($row['tipe']) && $row['tipe'] !== "")
     { $item .= " ".$row['tipe'];
     }
    if(isset($row['jenis_pengiriman']) && $row['jenis_pengiriman'] == "Diambil")
     { $ship_by = "";
     }
    $list .= "<tr>
               <td style='border:1px solid #016c98; padding:5px; text-align:right;'>".$no."</td>
               <td style='border:1px solid #016c98; padding:5px;'>".$item."</td>
               <td style='border:1px solid #016c98; padding:5px; text-align:right;'>".number_format($row['jumlah'], 2, ",", ".")."</td>
               <td style='border:1px solid #016c98; padding:5px;'>".$row['nama_rak']."</td>
               <td style='border:1px solid #016c98; padding:5px;' colspan='2'></td>
              </tr>";
  }

 $html = "<img src='../../dist/img/kop.jpg' style='width:100%;'>
          <table style='width:100%; border-collapse:collapse;' cellpadding='0px' cellspacing='0px'>
           <tr>
           <tr>
            <td colspan='6'>
             <b style='font-size:22px; color:#016c98;'>Surat Jalan</b>
            </td>
           </tr>
           <tr>
            <td style='border:0.5px solid #016c98; border-right:0.5px solid white; font-weight:bold; background-color:#016c98; color:white; padding:5px;' colspan='3'>
             <b>Ship To</b>
            </td>
            <td style='border:0.5px solid #016c98; font-weight:bold; background-color:#016c98; color:white; padding:5px;' colspan='3'>
             <b>Delivery Order</b>
            </td>
           </tr>
           <tr>
            <td style='border:0.5px solid #016c98; padding:5px; vertical-align:top;' colspan='3'>
             <b>".$customer."</b><br>".$address."
            </td>
            <td style='border:0.5px solid #016c98; padding:5px; vertical-align:top;' colspan='3'>
             <table>
              <tr>
               <td><b>Date</b></td>
               <td>:</td>
               <td>".$tanggal."</td>
              </tr>
              <tr>
               <td><b>DO Number</b></td>
               <td>:</td>
               <td>".$nomor_pengiriman."</td>
              </tr>
              <tr>
               <td><b>SO Number</b></td>
               <td>:</td>
               <td>".$nomor_penjualan."</td>
              </tr>
             </table>
            </td>
           </tr>
           <tr>
            <td style='border:0.5px solid #016c98; border-right:0.5px solid white; background-color:#016c98; color:white; padding:5px; text-align:center; width:50px;'><b>No.</b></td>
            <td style='border:0.5px solid #016c98; border-right:0.5px solid white; background-color:#016c98; color:white; padding:5px; width:250px;'><b>Item</b></td>
            <td style='border:0.5px solid #016c98; border-right:0.5px solid white; background-color:#016c98; color:white; padding:5px; text-align:center; width:80px;'><b>Qty</b></td>
            <td style='border:0.5px solid #016c98; border-right:0.5px solid white; background-color:#016c98; color:white; padding:5px;'><b>Rak</b></td>
            <td colspan='2' style='border:0.5px solid #016c98; background-color:#016c98; color:white; padding:5px; text-align:center;'><b>Description</b></td>
           </tr>
           ".$list."
          </table>
          <table style='width:100%; margin-top:50px;'>
           <tr>
            <td style='width:100%; font-size:11mm; padding-right:50px;'>
             Doc Prepared By<br><br><br><br><br><b>".$doc_prepared_by."</b><hr style='margin-bottom:7px; margin-top:3px;'>Date : ".sebutkan_tanggal(date('Y-m-d'))."
            </td>
            <td style='width:100%; font-size:11mm; padding-right:50px; padding-left:50px;'>".$ship_by."</td>
            <td style='width:100%; font-size:11mm; padding-left:50px;'>
             Received By<br><br><br><br><br><br><hr style='margin-bottom:7px; margin-top:3px;'>Date :
            </td>
           </tr>
          </table>";

 $nama_file = generateRandomString().".pdf";

 require '../../vendor/autoload.php';
 $mpdf = new \Mpdf\Mpdf();
 $mpdf->AddPage('P','','','','', 15, 15, 5, 15, 15, 15);
 $mpdf->WriteHTML($html);
 $mpdf->Output($lokasi_folder.$nama_file, 'F');
 echo str_replace("..", "action", $lokasi_folder.$nama_file);

?>