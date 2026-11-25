<?php

 include("../bjksadkhrej121lkjkjk.php");

 $is_commit = 1;
 mysqli_autocommit($koneksi, FALSE);

 $id = intval($_POST['id']);

 //jika terjual melebihi barang masuk maka batalkan transaksi
 $query2 = "select barang.kode, barang.nama, barang.merek, barang.model, barang.tipe, barang.jenis, satuan.satuan, barang_masuk_detail.jumlah, barang_masuk_detail.terjual from barang_masuk_detail left join pembelian_detail on barang_masuk_detail.pembelian_detail_id = pembelian_detail.id left join barang on pembelian_detail.barang_id = barang.id left join satuan on barang.satuan_id = satuan.id where barang_masuk_detail.barang_masuk_id = '".$id."' and ifnull(barang_masuk_detail.terjual, 0) > 0";
 $execute2 = mysqli_query($koneksi, $query2);
 while($row2 = mysqli_fetch_array($execute2))
  { $is_commit = 0;
    $nama_barang = $row2['kode']." - ".$row2['nama'];
    if(isset($row2['merek']) && $row2['merek'] !== "")
     { $nama_barang .= " ".$row2['merek'];
     }
    if(isset($row2['model']) && $row2['model'] !== "")
     { $nama_barang .= " ".$row2['model'];
     }
    if(isset($row2['tipe']) && $row2['tipe'] !== "")
     { $nama_barang .= " ".$row2['tipe'];
     }
    if(isset($row2['jenis']) && $row2['jenis'] !== "")
     { $nama_barang .= " ".$row2['jenis'];
     }
    if(isset($row2['satuan']) && $row2['satuan'] !== "")
     { $nama_barang .= " (".number_format($row2['jumlah'], 2, ",", ".")." ".$row2['satuan'].")";
     }
    echo "\nBarang ".$nama_barang." telah terjual sebanyak ".number_format($row2['terjual'] ?? 0, 2, ",", ".")." ".$row2['satuan']."!\n";
  }

 //inisialisasi detail yang akan dihapus bila tidak digunakan lagi
 $query = "update barang_masuk_detail set jumlah = 0 where barang_masuk_id = '".$id."'";
 $execute = mysqli_query($koneksi, $query);
 if(!$execute)
  { $is_commit = 0;
  }

 $query = "select pembelian_detail_id from barang_masuk_detail where barang_masuk_id = '".$id."' group by pembelian_detail_id";
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { //update masuk_gudang pada tabel pembelian_detail
    $query2 = "update pembelian_detail set masuk_gudang = (select ifnull(sum(ifnull(jumlah, 0)), 0) from barang_masuk_detail where pembelian_detail_id = '".$row['pembelian_detail_id']."') where id = '".$row['pembelian_detail_id']."'";
    $execute2 = mysqli_query($koneksi, $query2);
    if(!$execute2)
     { $is_commit = 0;
     }
  }

 $query = "select pembelian_id from pembelian_detail where id in (select pembelian_detail_id from barang_masuk_detail where barang_masuk_id = '".$id."') group by pembelian_id";
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { //set detail pada tabel pembelian
    $is_commit = setDetail($koneksi, $is_commit, "pembelian", "pembelian_detail", $row['pembelian_id']);
  }

 //hapus detail
 $query = "delete from barang_masuk_detail where barang_masuk_id = '".$id."'";
 $execute = mysqli_query($koneksi, $query);
 if(!$execute)
  { $is_commit = 0;
  }

 $query = "delete from ".$_POST['Nama_Tabel']." where id = '".intval($_POST['id'])."'";
 $execute = mysqli_query($koneksi, $query);
 if(!$execute)
  { $is_commit = 0;
  }

 if($is_commit == 1)
  { mysqli_commit($koneksi);
    echo "1";
  }
 else
  { mysqli_rollback($koneksi);
  }

?>