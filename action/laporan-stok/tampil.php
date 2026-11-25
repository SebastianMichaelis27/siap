<?php
 include("../bjksadkhrej121lkjkjk.php");

 $filter = "";
 if(isset($_POST['nama_barang']) && $_POST['nama_barang'] !== "")
  { $filter = " where concat(nama, merek, model, tipe) like '%".str_replace("'", "\'", $_POST['nama_barang'])."%'";
  }

 $barang = array();
 $query = "select barang.*, satuan.satuan from barang left join satuan on barang.satuan_id = satuan.id".$filter." order by barang.kode asc, barang.nama asc";
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $nama_barang = $row['nama'];
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
     { $nama_barang .= " ".$row['kapasitas_pk']." PK";
     }
    if(isset($row['btuh']) && $row['btuh'] !== "")
     { $nama_barang .= " (".$row['btuh']." BTU/H)";
     }
    array_push($barang, array(
     "id" => $row['id'],
     "kode" => $row['kode'],
     "nama_barang" => $nama_barang,
     "satuan" => $row['satuan'],
     "harga_beli" => $row['harga_beli'],
     "harga_jual" => $row['harga_jual'],
     "kategori" => $row['kategori'],
     "digudang" => 0,
     "stok" => 0,
    ));
  }
 $barangMasukDetail = array();
 $query = "select barang_masuk.tanggal, barang_masuk.sumber, rak.nama_rak, pembelian_detail.barang_id, barang_masuk_detail.jumlah, barang_masuk_detail.terjual, barang_masuk_detail.dikirim from barang_masuk_detail left join pembelian_detail on barang_masuk_detail.pembelian_detail_id = pembelian_detail.id left join barang_masuk on barang_masuk_detail.barang_masuk_id = barang_masuk.id left join rak on barang_masuk_detail.rak_id = rak.id left join barang on pembelian_detail.barang_id = barang.id where barang_masuk.gudang_id = '".intval($_POST['gudang_id'])."'";
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $index = array_search($row['barang_id'], array_column($barang, 'id'));
    if(strval($index) !== "")
     { $barang[$index]['digudang'] += $row['jumlah'] - $row['dikirim'];
       $barang[$index]['stok'] += $row['jumlah'] - $row['terjual'];
     }
    if(isset($row['tanggal']) && $row['tanggal'] !== "")
     { $row['tanggal'] = date('d-m-Y', strtotime($row['tanggal']));
     }
    array_push($barangMasukDetail, array(
     "tanggal" => $row['tanggal'],
     "sumber" => $row['sumber'],
     "barang_id" => $row['barang_id'],
     "nama_rak" => $row['nama_rak'],
     "digudang" => $row['jumlah'] - $row['dikirim'],
     "stok" => $row['jumlah'] - $row['terjual'],
    ));
  }
 $list = "";
 foreach($barang as $key => $value)
  { $list .= "<tr class='group-hover' onclick='showDetail(this);'>
               <td style='text-align:right;'>
                ".($key + 1)."
                <input type='hidden' class='barang_id' value='".$value['id']."'>
               </td>
               <td class='kode_barang'>".$value['kode']."</td>
               <td class='nama_barang'>".$value['nama_barang']."</td>
               <td class='satuan_barang'>".$value['satuan']."</td>
               <td style='text-align:right;'>".formatAngka($value['digudang'])."</td>
               <td style='text-align:right;'>".formatAngka($value['stok'])."</td>
              </tr>";
  }
?>
<style>
 #form-cetak table
  { width : 100%;
  }
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
 <button type='button' class='btn btn-danger pull-right' onclick='print();'><i class='fa fa-print'></i></button>
 <h4>STOCK REPORT</h4>
 <table>
  <thead>
   <tr>
    <th style='width:50px;'>No.</th>
    <th>Kode</th>
    <th>Barang</th>
    <th>Satuan</th>
    <th style='width:120px; text-align:center;'>Qty Digudang</th>
    <th style='width:120px; text-align:center;'>Qty Stok</th>
   </tr>
  </thead>
  <tbody>
   <?= $list ?>
  </tbody>
 </table>
</div>
<textarea style='display:none;' id='temp-detail_barang'><?= json_encode($barangMasukDetail) ?></textarea>