<?php
 include("../bjksadkhrej121lkjkjk.php");

 $where = "";
 $params = [];
 $types = "";

 if(isset($_POST['dari_tanggal']) && $_POST['dari_tanggal'] !== "")
  { $_POST['dari_tanggal'] = date('Y-m-d', strtotime($_POST['dari_tanggal']));
    if($where !== "")
     { $where .= " and ";
     }
    $where .= "penjualan_pembayaran.tanggal >= ?";
    $types .= "s";
    $params[] = $_POST['dari_tanggal'];
  }

 if(isset($_POST['sampai_tanggal']) && $_POST['sampai_tanggal'] !== "")
  { $_POST['sampai_tanggal'] = date('Y-m-d', strtotime($_POST['sampai_tanggal']));
    if($where !== "")
     { $where .= " and ";
     }
    $where .= "penjualan_pembayaran.tanggal <= ?";
    $types .= "s";
    $params[] = $_POST['sampai_tanggal'];
  }

 if(isset($_POST['cabang_id_']) && $_POST['cabang_id_'] !== "")
  { if($where !== "")
     { $where .= " and ";
     }
    $where .= "penjualan.cabang_id = ?";
    $types .= "i";
    $params[] = $_POST['cabang_id_'];
  }

 if(isset($_POST['metode_pembayaran_id']) && $_POST['metode_pembayaran_id'] !== "")
  { if($where !== "")
     { $where .= " and ";
     }
    $where .= "penjualan_pembayaran.metode_pembayaran_id = ?";
    $types .= "i";
    $params[] = $_POST['metode_pembayaran_id'];
  }

 if($where !== "")
  { $where = " where ".$where;
  }

 $execute = $koneksi->prepare("select penjualan_pembayaran.*, concat(penjualan.kode, right(year(penjualan.tanggal), 2), lpad(month(penjualan.tanggal), 2, '0'), lpad(day(penjualan.tanggal), 2, '0'), '-MIE-', lpad(penjualan.nomor, if(3 > length(penjualan.nomor), 3, length(penjualan.nomor)), '0') ) as nomor_penjualan, penjualan.total as tagihan, penjualan.dibayar as telah_dibayar, customer.nama as nama_customer, metode_pembayaran.metode_pembayaran from penjualan_pembayaran left join penjualan on penjualan_pembayaran.penjualan_id = penjualan.id left join customer on penjualan.customer_id = customer.id left join metode_pembayaran on penjualan_pembayaran.metode_pembayaran_id = metode_pembayaran.id".$where);
 if(count($params) > 0)
  { $execute->bind_param($types, ...$params);
  }
 $execute->execute();
 $result = $execute->get_result();
 $dataPenjualanPembayaran = $result->fetch_all(MYSQLI_ASSOC);

 $total_penerimaan = 0;
 $list = "";
 for($i=0; $i<count($dataPenjualanPembayaran); $i++)
  { $list .= "<tr>
               <td style='text-align:right;'>".($i + 1)."</td>
               <td>".(isset($dataPenjualanPembayaran[$i]['tanggal']) && $dataPenjualanPembayaran[$i]['tanggal'] !== "" ? date('d-m-Y', strtotime($dataPenjualanPembayaran[$i]['tanggal'])) : "")."</td>
               <td>".$dataPenjualanPembayaran[$i]['nomor_penjualan']."</td>
               <td>".$dataPenjualanPembayaran[$i]['nama_customer']."</td>
               <td style='text-align:right;'>".formatAngka($dataPenjualanPembayaran[$i]['tagihan'])."</td>
               <td style='text-align:right;'>".formatAngka($dataPenjualanPembayaran[$i]['telah_dibayar'])."</td>
               <td style='text-align:right;'>".formatAngka($dataPenjualanPembayaran[$i]['nominal'])."</td>
               <td>".$dataPenjualanPembayaran[$i]['metode_pembayaran']."</td>
              </tr>";
    $total_penerimaan += $dataPenjualanPembayaran[$i]['nominal'] * 1;
  }

?>
<style>
 #form-cetak table thead tr th, #form-cetak table tbody tr th, #form-cetak table tbody tr td
  { border : 1px solid black;
    padding : 5px 10px;
  }
</style>
<style media='print'>
 @page
  { margin-top: 2mm;
    margin-bottom: 2mm;
    margin-left: 5mm;
    margin-right: 5mm;
  }
 .main-footer, .btn-danger, .box-default, .btn
  { display:none;
  }
</style>

<div style='background:white; padding:10px;'>
 <div style='text-align:right;'><button type='button' class='btn btn-danger' onclick='print();'><i class='fa fa-print'></i></button></div>
 <div style='display:grid; grid-template-columns:1fr auto; gap:10px; align-items:end;'>
  <h4><b>LAPORAN PENERIMAAN PEMBAYARAN</b></h4>
  <div style='display:grid; grid-template-columns:auto auto auto; font-weight:bold;'>
   <div>TOTAL PENERIMAAN</div>
   <div style='width:20px; text-align:center;'>:</div>
   <div style='text-align:right;'><?= number_format($total_penerimaan, 2, ",", ".") ?></div>
  </div>
 </div>
 <div class='responsiveku'>
  <div style='width:20000px;' id='lebar'>
   <table>
    <thead>
     <tr>
      <th style='text-align:center;'>No.</th>
      <th>Tanggal</th>
      <th>No. Penjualan</th>
      <th>Customer</th>
      <th>Tagihan</th>
      <th>Telah Dibayar</th>
      <th>Penerimaan</th>
      <th>Metode Pembayaran</th>
     </tr>
    </thead>
    <tbody>
     <?= $list ?>
     <tr>
      <th style='text-align:center;' colspan='6'>Total</th>
      <th style='text-align:right;'><?= formatAngka($total_penerimaan) ?></th>
      <th style='text-align:right;'></th>
     </tr>
    </tbody>
   </table>
  </div>
 </div>
</div>

