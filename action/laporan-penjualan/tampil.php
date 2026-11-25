<?php
 include("../bjksadkhrej121lkjkjk.php");

 $filter = "";
 if(isset($_POST['karyawan_id']) && $_POST['karyawan_id'] !== "")
  { $filter .= " and penjualan.karyawan_id = ".intval($_POST['karyawan_id']);
  }
 if(isset($_POST['customer_id']) && $_POST['customer_id'] !== "")
  { $filter .= " and penjualan.customer_id = ".intval($_POST['customer_id']);
  }
 if(isset($_POST['jenis_customer_id']) && $_POST['jenis_customer_id'] !== "")
  { $filter .= " and customer.jenis_customer_id = ".intval($_POST['jenis_customer_id']);
  }
 if(isset($_POST['merek']) && $_POST['merek'] !== "")
  { $filter .= " and barang.merek like '%".$_POST['merek']."%'";
  }
 if(isset($_POST['tipe']) && $_POST['tipe'] !== "")
  { $filter .= " and barang.tipe like '%".$_POST['tipe']."%'";
  }
 if(isset($_POST['kapasitas_pk']) && $_POST['kapasitas_pk'] !== "")
  { $filter .= " and barang.kapasitas_pk = ".$_POST['kapasitas_pk'];
  }

 $penjualan_belum_ditandai = "";
 $query = "select concat(penjualan.kode, right(year(penjualan.tanggal), 2), lpad(month(penjualan.tanggal), 2, '0'), lpad(day(penjualan.tanggal), 2, '0'), '-MIE-', lpad(penjualan.nomor, if(3 > length(penjualan.nomor), 3, length(penjualan.nomor)), '0') ) as nomor_penjualan from penjualan_detail left join penjualan on penjualan_detail.penjualan_id = penjualan.id where ifnull(penjualan_detail.jumlah_ditandai, 0) < ifnull(penjualan_detail.jumlah, 0) and penjualan.cabang_id = '".intval($_POST['cabang_id_'])."' and ifnull(penjualan.approved_at, '') <> '' and penjualan.tanggal >= '".date('Y-m-d', strtotime($_POST['dari_tanggal']))."' and penjualan.tanggal <= '".date('Y-m-d', strtotime($_POST['sampai_tanggal']))."'";
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { if($penjualan_belum_ditandai !== "")
     { $penjualan_belum_ditandai .= ", ";
     }
    $penjualan_belum_ditandai .= "<b>".$row['nomor_penjualan']."</b>";
  }
 if($penjualan_belum_ditandai !== "")
  { $penjualan_belum_ditandai = "<div class='alert alert-warning' role='alert'>Penjualan dengan Nomor : ".$penjualan_belum_ditandai." belum ditandai!</div>";
  }

 $list = "";
 $no = 0;
 $total_penerimaan_keseluruhan = 0;
 $total_ppn_disetor = 0;
 $total_margin = 0;
 $query = "select penjualan.tanggal, concat(penjualan.kode, right(year(penjualan.tanggal), 2), lpad(month(penjualan.tanggal), 2, '0'), lpad(day(penjualan.tanggal), 2, '0'), '-MIE-', lpad(penjualan.nomor, if(3 > length(penjualan.nomor), 3, length(penjualan.nomor)), '0') ) as nomor_penjualan, karyawan.nama as sales, customer.nama as customer, customer.jumlah_transaksi, penjualan.alamat_customer, penjualan.no_telp_customer, penjualan.no_wa_customer, concat(pembelian.kode, right(year(pembelian.tanggal), 2), lpad(month(pembelian.tanggal), 2, '0'), lpad(day(pembelian.tanggal), 2, '0'), '-MIE-', lpad(pembelian.nomor, if(3 > length(pembelian.nomor), 3, length(pembelian.nomor)), '0') ) as nomor_pembelian, barang.kode as kode_barang, barang.nama as nama_barang, barang.merek, barang.model, barang.tipe, barang.jenis, barang.kapasitas_pk, barang.btuh, barang.ukuran, penjualan_detail_ditandai.jumlah, penjualan_detail.harga_sebelum_ppn, penjualan_detail.persen_ppn as persen_ppn_penjualan, penjualan_detail.jumlah as jumlah_penjualan, penjualan_detail.diskon_item, penjualan_detail.diskon_faktur, satuan.satuan, pembelian_detail.total as total_pembelian, ifnull(pembelian_detail.dpp, 0) / ifnull(pembelian_detail.jumlah, 0) as harga_beli, pembelian_detail.jumlah as jumlah_pembelian, pembelian_detail.nominal_ppn as ppn_pembelian from penjualan_detail_ditandai left join penjualan_detail on penjualan_detail_ditandai.penjualan_detail_id = penjualan_detail.id left join penjualan on penjualan_detail.penjualan_id = penjualan.id left join customer on penjualan.customer_id = customer.id left join karyawan on penjualan.karyawan_id = karyawan.id left join barang on penjualan_detail.barang_id = barang.id left join satuan on barang.satuan_id = satuan.id left join barang_masuk_detail on penjualan_detail_ditandai.barang_masuk_detail_id = barang_masuk_detail.id left join pembelian_detail on barang_masuk_detail.pembelian_detail_id = pembelian_detail.id left join pembelian on pembelian_detail.pembelian_id = pembelian.id where penjualan.cabang_id = '".intval($_POST['cabang_id_'])."' and ifnull(penjualan.approved_at, '') <> '' and penjualan.tanggal >= '".date('Y-m-d', strtotime($_POST['dari_tanggal']))."' and penjualan.tanggal <= '".date('Y-m-d', strtotime($_POST['sampai_tanggal']))."'".$filter;
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $no++;
    $nama_barang = $row['nama_barang'];
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
    $persen_ppn_penjualan = 0;
    if(isset($row['persen_ppn_penjualan']) && $row['persen_ppn_penjualan'] !== "")
     { $persen_ppn_penjualan = $row['persen_ppn_penjualan'] * 1;
     }
    $ppn_pembelian = 0;
    if(isset($row['ppn_pembelian']) && $row['ppn_pembelian'] !== "")
     { $ppn_pembelian = $row['ppn_pembelian'] * 1;
     }
    $harga_beli = $row['harga_beli'] ?? 0;

    $nominal_ppn_pembelian = 0;
    if($ppn_pembelian > 0 && isset($row['jumlah_pembelian']) && $row['jumlah_pembelian'] * 1 > 0 && $row['jumlah'] * 1 > 0)
     { $nominal_ppn_pembelian = ($ppn_pembelian / $row['jumlah_pembelian']) * $row['jumlah'];
     }

    $sub_total = 0;
    if(isset($row['jumlah']) && $row['jumlah'] * 1 > 0 && isset($row['harga_sebelum_ppn']) && $row['harga_sebelum_ppn'] * 1 > 0)
     { $sub_total = $row['jumlah'] * $row['harga_sebelum_ppn'];
     }
    $diskon_item = 0;
    if(isset($row['jumlah']) && $row['jumlah'] * 1 > 0 && isset($row['diskon_item']) && $row['diskon_item'] * 1 > 0 && isset($row['jumlah_penjualan']) && $row['jumlah_penjualan'] * 1 > 0)
     { $diskon_item = ($row['diskon_item'] / $row['jumlah_penjualan']) * $row['jumlah'];
     }
    $diskon_faktur = 0;
    if(isset($row['jumlah']) && $row['jumlah'] * 1 > 0 && isset($row['diskon_faktur']) && $row['diskon_faktur'] * 1 > 0 && isset($row['jumlah_penjualan']) && $row['jumlah_penjualan'] * 1 > 0)
     { $diskon_faktur = ($row['diskon_faktur'] / $row['jumlah_penjualan']) * $row['jumlah'];
     }
    $nominal_ppn_penjualan = 0;
    $total_penjualan = $sub_total - $diskon_item - $diskon_faktur;
    $total_pembelian = $harga_beli * $row['jumlah'];
    $total_hpp = $total_pembelian + $nominal_ppn_pembelian;
    if($persen_ppn_penjualan > 0)
     { $nominal_ppn_penjualan = $total_penjualan * $persen_ppn_penjualan / 100;
       $total_hpp = $total_pembelian;
     }
    $total_penerimaan = $total_penjualan + $nominal_ppn_penjualan;
    $margin = $total_penjualan - $total_hpp;
    $nominal_ppn_disetor = 0;
    if($nominal_ppn_penjualan > 0)
     { $nominal_ppn_disetor = $nominal_ppn_penjualan - $nominal_ppn_pembelian;
     }

    $total_ppn_disetor += $nominal_ppn_disetor;
    $total_margin += $margin;
    $total_penerimaan_keseluruhan += $total_penerimaan;

    $no_hp = "";
    $no_telp_customer = array();
    if(isset($row['no_telp_customer']) && $row['no_telp_customer'] !== "")
     { $no_telp_customer = json_decode($row['no_telp_customer'], true);
       $no_hp .= implode(", ", array_column($no_telp_customer, 'no_telp_customer'));
     }
    $no_hp_customer = array();
    if(isset($row['no_hp_customer']) && $row['no_hp_customer'] !== "")
     { $no_hp_customer = json_decode($row['no_hp_customer'], true);
       $no_hp .= implode(", ", array_column($no_hp_customer, 'no_hp_customer'));
     }

    $list .= "<tr class='group-hover'>
               <td style='text-align:right;'>".$no."</td>
               <td>".date('d-m-Y', strtotime($row['tanggal']))."</td>
               <td>".$row['nomor_penjualan']."</td>
               <td>".$row['sales']."</td>
               <td>".$row['customer']."</td>
               <td style='text-align:right;'>".formatAngka($row['jumlah_transaksi'])."</td>
               <td>".$row['alamat_customer']."</td>
               <td>".$no_hp."</td>
               <td>".$row['nomor_pembelian']."</td>
               <td>".$row['kode_barang']."</td>
               <td>".$nama_barang."</td>
               <td style='text-align:right;'>".number_format($row['jumlah'], 2, ",", ".")."</td>
               <td>".$row['satuan']."</td>
               <td style='text-align:right;'>".number_format($harga_beli, 2, ",", ".")."</td>
               <td style='text-align:right;'>".number_format($row['harga_sebelum_ppn'], 2, ",", ".")."</td>
               <td style='text-align:right;'>".number_format($sub_total, 2, ",", ".")."</td>
               <td style='text-align:right;'>".number_format($diskon_item, 2, ",", ".")."</td>
               <td style='text-align:right;'>".number_format($diskon_faktur, 2, ",", ".")."</td>
               <td style='text-align:right;'>".number_format($total_pembelian, 2, ",", ".")."</td>
               <td style='text-align:right;'>".number_format($nominal_ppn_pembelian, 2, ",", ".")."</td>
               <td style='text-align:right;'>".number_format($total_hpp, 2, ",", ".")."</td>
               <td style='text-align:right;'>".number_format($total_penjualan, 2, ",", ".")."</td>
               <td style='text-align:right;'>".number_format($margin, 2, ",", ".")."</td>
               <td style='text-align:right;'>".number_format($nominal_ppn_penjualan, 2, ",", ".")."</td>
               <td style='text-align:right;'>".number_format($nominal_ppn_disetor, 2, ",", ".")."</td>
               <td style='text-align:right;'>".number_format($total_penerimaan, 2, ",", ".")."</td>
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
 <?= $penjualan_belum_ditandai ?>
 <div style='text-align:right;'><button type='button' class='btn btn-danger' onclick='print();'><i class='fa fa-print'></i></button></div>
 <div style='display:grid; grid-template-columns:1fr auto; gap:10px; align-items:end;'>
  <h4><b>LAPORAN PENJUALAN</b></h4>
  <div style='display:grid; grid-template-columns:auto auto auto; font-weight:bold;'>
   <div>TOTAL PENERIMAAN</div>
   <div style='width:20px; text-align:center;'>:</div>
   <div style='text-align:right;'><?= number_format($total_penerimaan_keseluruhan, 2, ",", ".") ?></div>
   <div>TOTAL MARGIN</div>
   <div style='width:20px; text-align:center;'>:</div>
   <div style='text-align:right;'><?= number_format($total_margin, 2, ",", ".") ?></div>
   <div>TOTAL PPN DISETOR</div>
   <div style='width:20px; text-align:center;'>:</div>
   <div style='text-align:right;'><?= number_format($total_ppn_disetor, 2, ",", ".") ?></div>
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
      <th>Sales</th>
      <th>Customer</th>
      <th>Jlh Transaksi</th>
      <th>Alamat</th>
      <th>No. Hp</th>
      <th>No. Pembelian</th>
      <th>Kode</th>
      <th>Barang</th>
      <th style='text-align:center;'>Jumlah</th>
      <th style='text-align:center;'>Unit</th>
      <th style='text-align:center;'>Harga Beli</th>
      <th style='text-align:center;'>Harga Jual</th>
      <th style='text-align:center;'>Sub Total Penjualan</th>
      <th style='text-align:center;'>Diskon Item Penjualan</th>
      <th style='text-align:center;'>Diskon Faktur Penjualan</th>
      <th style='text-align:center;'>Total Pembelian</th>
      <th style='text-align:center;'>PPN Pembelian</th>
      <th style='text-align:center;'>Total HPP</th>
      <th style='text-align:center;'>Total Penjualan</th>
      <th style='text-align:center;'>Margin</th>
      <th style='text-align:center;'>PPN Penjualan</th>
      <th style='text-align:center;'>PPN Disetor</th>
      <th style='text-align:center;'>Total Penerimaan</th>
     </tr>
    </thead>
    <tbody>
     <?= $list ?>
     <tr>
      <th style='text-align:center;' colspan='21'>Total</th>
      <th style='text-align:right;'><?= number_format($total_margin, 2, ",", ".") ?></th>
      <th style='text-align:right;'></th>
      <th style='text-align:right;'><?= number_format($total_ppn_disetor, 2, ",", ".") ?></th>
      <th style='text-align:right;'><?= number_format($total_penerimaan_keseluruhan, 2, ",", ".") ?></th>
     </tr>
    </tbody>
   </table>
  </div>
 </div>
</div>

