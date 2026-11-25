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

 $id = $_POST['id'] ?? null;

 $execute = $koneksi->prepare("select * from penjualan where id = ?");
 $execute->bind_param("i", $id);
 $execute->execute();
 $result = $execute->get_result();
 $penjualanOld = $result->fetch_assoc();

 $execute = $koneksi->prepare("select * from penjualan_pembayaran where penjualan_id = ?");
 $execute->bind_param("i", $id);
 $execute->execute();
 $result = $execute->get_result();
 $pembayaranOld = $result->fetch_all(MYSQLI_ASSOC);
 if(count($pembayaranOld) > 0)
  { echo "Transaks Pembayaran sudah ada!";
    $is_commit = 0;
    exit;
  }

 $execute = $koneksi->prepare("delete from penjualan_termin where penjualan_id = ?");
 $execute->bind_param("i", $id);
 if(!$execute->execute())
  { $is_commit = 0;
  }

 $query = "insert into log_".$_POST['Nama_Tabel']." select ".$_POST['Nama_Tabel'].".*, '".$now."', '".$username."', (select ifnull(max(no_urut), 0) + 1 from log_".$_POST['Nama_Tabel']." where id = '".intval($_POST['id'])."') from ".$_POST['Nama_Tabel']." where id = '".intval($_POST['id'])."'";
 $execute = mysqli_query($koneksi, $query);
 if(!$execute)
  { $is_commit = 0;
  }

 //set jumlah = 0 pada tabel penjualan_detail_ditandai
 $queryUpdate = "update penjualan_detail_ditandai set jumlah = 0 where penjualan_detail_id in (select id from penjualan_detail where penjualan_id = '".intval(intval($_POST['id']))."')";
 $executeUpdate = mysqli_query($koneksi, $queryUpdate);
 if(!$executeUpdate)
  { $is_commit = 0;
  }
 //set terjual pada tabel barang_masuk_detail
 $query2 = "select id from barang_masuk_detail where id in (select barang_masuk_detail_id from penjualan_detail_ditandai where penjualan_detail_id in (select id from penjualan_detail where penjualan_id = '".intval($_POST['id'])."'))";
 $execute2 = mysqli_query($koneksi, $query2);
 while($row2 = mysqli_fetch_array($execute2))
  { $query3 = "update barang_masuk_detail set terjual = (select sum(ifnull(jumlah, 0)) from penjualan_detail_ditandai where barang_masuk_detail_id = '".$row2['id']."') where id = '".$row2['id']."'";
    $execute3 = mysqli_query($koneksi, $query3);
    if(!$execute3)
     { $is_commit = 0;
     }
  }
 //set detail pada tabel barang_masuk
 $query2 = "select id from barang_masuk where id in (select barang_masuk_id from barang_masuk_detail where id in (select barang_masuk_detail_id from penjualan_detail_ditandai where penjualan_detail_id in (select id from penjualan_detail where penjualan_id = '".intval($_POST['id'])."')))";
 $execute2 = mysqli_query($koneksi, $query2);
 while($row2 = mysqli_fetch_array($execute2))
  { $is_commit = setDetail($koneksi, $is_commit, "barang_masuk", "barang_masuk_detail", $row2['id']);
  }

 //hapus penjualan_detail_ditandai
 $query = "delete from penjualan_detail_ditandai where penjualan_detail_id in (select id from penjualan_detail where penjualan_id = '".intval($_POST['id'])."')";
 $execute = mysqli_query($koneksi, $query);
 if(!$execute)
  { $is_commit = 0;
  }

 //set 0 data jumlah agar nanti dihapus bila nilainya tetap 0
 $queryUpdate = "update ".$_POST['Nama_Tabel']."_detail set jumlah = 0 where penjualan_id = '".intval($_POST['id'])."'";
 $executeUpdate = mysqli_query($koneksi, $queryUpdate);
 if(!$executeUpdate)
  { $is_commit = 0;
  }
 //Update jumlah_penjualan pada tabel pesanan
 $query1 = "select id from pesanan where id in (select pesanan_id from pesanan_detail where id in (select pesanan_detail_id from penjualan_detail where penjualan_id = '".intval($_POST['id'])."'))";
 $execute1 = mysqli_query($koneksi, $query1);
 while($row1 = mysqli_fetch_array($execute1))
  { $query2 = "update pesanan set jumlah_penjualan = (select ifnull(sum(ifnull(jumlah, 0)), 0) from penjualan_detail where pesanan_detail_id in (select id from pesanan_detail where pesanan_id = '".intval($row1['id'])."')) where id = '".intval($row1['id'])."'";
    $execute2 = mysqli_query($koneksi, $query2);
    if(!$execute2)
     { $is_commit = 0;
     }
  }
 //update jumlah_penjualan pada tabel pesanan_detail
 $query1 = "select pesanan_detail_id from penjualan_detail where penjualan_id = '".intval($_POST['id'])."'";
 $execute1 = mysqli_query($koneksi, $query1);
 while($row1 = mysqli_fetch_array($execute1))
  { $query2 = "update pesanan_detail set jumlah_penjualan = (select ifnull(sum(ifnull(jumlah, 0)), 0) from penjualan_detail where pesanan_detail_id = '".intval($row1['pesanan_detail_id'])."') where id = '".$row1['pesanan_detail_id']."'";
    $execute2 = mysqli_query($koneksi, $query2);
    if(!$execute2)
     { $is_commit = 0;
     }
  }
 //update detail pada tabel pesanan
 $query1 = "select id from pesanan where id in (select pesanan_id from pesanan_detail where id in (select pesanan_detail_id from penjualan_detail where penjualan_id = '".intval($_POST['id'])."'))";
 $execute1 = mysqli_query($koneksi, $query1);
 while($row1 = mysqli_fetch_array($execute1))
  { $is_commit = setDetail($koneksi, $is_commit, "pesanan", "pesanan_detail", $row1['id']);
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

 //update jumlah_transaksi pada tabel customer--------------------------------------------------------------------------
 if(isset($penjualanOld['customer_id']) && $penjualanOld['customer_id'] !== "")
  { $execute2 = $koneksi->prepare("update customer set jumlah_transaksi = (select count(*) from penjualan where customer_id = ?) where id = ?");
    $execute2->bind_param("ii", $penjualanOld['customer_id'], $penjualanOld['customer_id']);
    if(!$execute2->execute())
     { $is_commit = 0;
     }
  }
 //update jumlah_transaksi pada tabel customer--------------------------------------------------------------------------

 if($is_commit == 1)
  { mysqli_commit($koneksi);
    echo "1";
  }
 else
  { mysqli_rollback($koneksi);
  }

?>