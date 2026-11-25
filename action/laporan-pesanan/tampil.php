<?php
 include("../bjksadkhrej121lkjkjk.php");
 $no = 0;
 $total_keseluruhan = 0;
 $ppn_keseluruhan = 0;
 $list = "";
 $query = "select concat(pesanan.kode, '/', lpad(pesanan.nomor, if(3 > length(pesanan.nomor), 3, length(pesanan.nomor)), '0'), '/MIE/', to_roman(month(tanggal)), '/', pesanan.tahun) as nomor_pesanan, pesanan.* from pesanan where pesanan.cabang_id = '".intval($_POST['cabang_id_'])."' and pesanan.tanggal >= '".date('Y-m-d', strtotime($_POST['dari_tanggal']))."' and pesanan.tanggal <= '".date('Y-m-d', strtotime($_POST['sampai_tanggal']))."' order by tanggal asc";
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $no++;
    $total_keseluruhan += $row['total'] * 1;
    $list .= "<tr class='group-hover'>
               <td style='text-align:right;'>".$no."</td>
               <td style='text-align:right;'>".date('d-m-Y', strtotime($row['tanggal']))."</td>
               <td>".$row['nomor_pesanan']."</td>
               <td>".$row['nama_customer']."</td>
               <td style='text-align:right;'>".number_format($row['total'], 2, ",", ".")."</td>
              </tr>";
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
  <h4><b>LAPORAN PESANAN</b></h4>
  <div style='display:grid; grid-template-columns:auto auto auto; font-weight:bold;'>
   <div>TOTAL PESANAN</div>
   <div style='width:20px; text-align:center;'>:</div>
   <div style='text-align:right;'><?= number_format($total_keseluruhan, 2, ",", ".") ?></div>
  </div>
 </div>
 <div class='responsiveku'>
  <div style='width:10000px;' id='lebar'>
   <table>
    <thead>
     <tr>
      <th style='text-align:center;'>No.</th>
      <th>Tanggal</th>
      <th>Nomor</th>
      <th>Customer</th>
      <th style='text-align:center;'>Total</th>
     </tr>
    </thead>
    <tbody>
     <?= $list ?>
     <tr>
      <th style='text-align:center;' colspan='4'>Total</th>
      <th style='text-align:right;'><?= number_format($total_keseluruhan, 2, ",", ".") ?></th>
     </tr>
    </tbody>
   </table>
  </div>
 </div>
</div>

