<?php

 include("../bjksadkhrej121lkjkjk.php");

 date_default_timezone_set('Asia/Jakarta');
 $info = getdate();
 $date = $info['mday'];
 $month = $info['mon'];
 $year = $info['year'];
 $hour = $info['hours'];
 $min = $info['minutes'];
 $sec = $info['seconds'];
 $now = $year."-".str_pad($month,2,"0",STR_PAD_LEFT)."-".str_pad($date,2,"0",STR_PAD_LEFT)." ".str_pad($hour,2,"0",STR_PAD_LEFT).":".str_pad($min,2,"0",STR_PAD_LEFT).":".str_pad($sec,2,"0",STR_PAD_LEFT);

 $is_commit = 1;
 mysqli_autocommit($koneksi, FALSE);

 $id = intval($_POST['id']);

 //jika ada masuk_gudang maka batalkan transaksi
 $query2 = "select barang.kode, barang.nama, barang.merek, barang.model, barang.tipe, barang.jenis, pembelian_detail.jumlah, satuan.satuan, pembelian_detail.masuk_gudang from pembelian_detail left join barang on pembelian_detail.barang_id = barang.id left join satuan on barang.satuan_id = satuan.id where pembelian_detail.pembelian_id = '".intval($_POST['id'])."' and ifnull(pembelian_detail.masuk_gudang, 0) > 0";
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
    echo "\nBarang ".$nama_barang." telah masuk ke gudang sebanyak ".number_format($row2['masuk_gudang'], 2, ",", ".")." ".$row2['satuan']."!\n";
  }

 $query = "insert into log_".$_POST['Nama_Tabel']." select ".$_POST['Nama_Tabel'].".*, '".$now."', '".$username."', (select ifnull(max(no_urut), 0) + 1 from log_".$_POST['Nama_Tabel']." where id = '".intval($_POST['id'])."') from ".$_POST['Nama_Tabel']." where id = '".intval($_POST['id'])."'";
 $execute = mysqli_query($koneksi, $query);
 if(!$execute)
  { $is_commit = 0;
  }

 //set jumlah = 0 pada tabel pembelian_detail
 $queryUpdate = "update pembelian_detail set jumlah = 0 where pembelian_id = ".intval($_POST['id']);
 $executeUpdate = mysqli_query($koneksi, $queryUpdate);
 if(!$executeUpdate)
  { $is_commit = 0;
  }

 $query = "delete from ".$_POST['Nama_Tabel']." where id = '".intval($_POST['id'])."'";
 $execute = mysqli_query($koneksi, $query);
 if(!$execute)
  { $is_commit = 0;
  }

 $query = "delete from ".$_POST['Nama_Tabel']."_detail where ".$_POST['Nama_Tabel']."_id = '".intval($_POST['id'])."'";
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