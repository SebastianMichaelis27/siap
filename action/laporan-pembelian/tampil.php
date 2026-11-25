<?php
 include("../bjksadkhrej121lkjkjk.php");
 $no = 0;
 $total_keseluruhan = 0;
 $ppn_keseluruhan = 0;
 $list = "";
 $query = "select pembelian.id, pembelian.tanggal, concat(pembelian.kode, right(year(pembelian.tanggal), 2), lpad(month(pembelian.tanggal), 2, '0'), lpad(day(pembelian.tanggal), 2, '0'), '-MIE-', lpad(pembelian.nomor, if(3 > length(pembelian.nomor), 3, length(pembelian.nomor)), '0') ) as nomor_pembelian, supplier.nama as supplier, barang.kode, barang.nama, barang.merek, barang.model, barang.tipe, barang.jenis, barang.kapasitas_pk, barang.btuh, barang.ukuran, pembelian_detail.jumlah, pembelian_detail.harga_sebelum_ppn, pembelian_detail.sub_total, pembelian_detail.diskon_item, pembelian_detail.diskon_faktur, pembelian_detail.dpp, pembelian_detail.nominal_ppn, pembelian_detail.total, satuan.satuan from pembelian_detail left join pembelian on pembelian_detail.pembelian_id = pembelian.id left join supplier on pembelian.supplier_id = supplier.id left join barang on pembelian_detail.barang_id = barang.id left join satuan on barang.satuan_id = satuan.id where pembelian.cabang_id = '".intval($_POST['cabang_id_'])."' and pembelian.tanggal >= '".date('Y-m-d', strtotime($_POST['dari_tanggal']))."' and pembelian.tanggal <= '".date('Y-m-d', strtotime($_POST['sampai_tanggal']))."' order by tanggal asc";
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $no++;
    $nama_barang = $row['nama'];
    if(isset($row['merek']) && $row['merek'] !== "")
     { $nama_barang .= " ".$row['merek'];
     }
    if(isset($row['model']) && $row['model'] !== "")
     { $nama_barang .= " ".$row['model'];
     }
    if(isset($row['tipe']) && $row['tipe'] !== "")
     { $nama_barang .= " ".$row['tipe'];
     }
    if(isset($row['jenis']) && $row['jenis'] !== "")
     { $nama_barang .= " ".$row['jenis'];
     }
    if(isset($row['kapasitas_pk']) && $row['kapasitas_pk'] !== "")
     { $nama_barang .= " ".formatAngka($row['kapasitas_pk'])." PK";
     }
    if(isset($row['btuh']) && $row['btuh'] !== "")
     { $nama_barang .= " (".$row['btuh']." BTU/H)";
     }
    if(isset($row['ukuran']) && $row['ukuran'] !== "")
     { $nama_barang .= " ".formatAngka($row['ukuran']);
       if(isset($row['satuan']) && $row['satuan'] !== "")
        { $nama_barang .= " ".$row['satuan'];
        }
     }
    $total_keseluruhan += $row['total'] * 1;
    $ppn_keseluruhan += $row['nominal_ppn'] * 1;
    $list .= "<tr class='group-hover'>
               <td style='text-align:right;'>".$no."</td>
               <td style='text-align:right;'>".date('d-m-Y', strtotime($row['tanggal']))."</td>
               <td>".$row['nomor_pembelian']."</td>
               <td>".$row['supplier']."</td>
               <td>".$row['kode']."</td>
               <td>".$nama_barang."</td>
               <td style='text-align:right;'>".number_format($row['jumlah'], 2, ",", ".")."</td>
               <td>".$row['satuan']."</td>
               <td style='text-align:right;'>".number_format($row['harga_sebelum_ppn'], 2, ",", ".")."</td>
               <td style='text-align:right;'>".number_format($row['harga_sebelum_ppn'] * $row['jumlah'], 2, ",", ".")."</td>
               <td style='text-align:right;'>".number_format($row['diskon_item'], 2, ",", ".")."</td>
               <td style='text-align:right;'>".number_format($row['diskon_faktur'], 2, ",", ".")."</td>
               <td style='text-align:right;'>".number_format($row['dpp'], 2, ",", ".")."</td>
               <td style='text-align:right;'>".number_format($row['nominal_ppn'], 2, ",", ".")."</td>
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
  <h4><b>LAPORAN PEMBELIAN</b></h4>
  <div style='display:grid; grid-template-columns:auto auto auto; font-weight:bold;'>
   <div>TOTAL PEMBELIAN</div>
   <div style='width:20px; text-align:center;'>:</div>
   <div style='text-align:right;'><?= number_format($total_keseluruhan, 2, ",", ".") ?></div>
   <div>PPN MASUKAN</div>
   <div style='width:20px; text-align:center;'>:</div>
   <div style='text-align:right;'><?= number_format($ppn_keseluruhan, 2, ",", ".") ?></div>
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
      <th>Supplier</th>
      <th>Kode</th>
      <th>Barang</th>
      <th style='text-align:center;'>Jumlah</th>
      <th style='text-align:center;'>Unit</th>
      <th style='text-align:center;'>Harga</th>
      <th style='text-align:center;'>Sub Total</th>
      <th style='text-align:center;'>Diskon Item</th>
      <th style='text-align:center;'>Diskon Faktur</th>
      <th style='text-align:center;'>DPP</th>
      <th style='text-align:center;'>PPN</th>
      <th style='text-align:center;'>Total</th>
     </tr>
    </thead>
    <tbody>
     <?= $list ?>
     <tr>
      <th style='text-align:center;' colspan='13'>Total</th>
      <th style='text-align:right;'><?= number_format($ppn_keseluruhan, 2, ",", ".") ?></th>
      <th style='text-align:right;'><?= number_format($total_keseluruhan, 2, ",", ".") ?></th>
     </tr>
    </tbody>
   </table>
  </div>
 </div>
</div>

