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

 $query = "insert into log_".$_POST['Nama_Tabel']." select ".$_POST['Nama_Tabel'].".*, '".$now."', '".$username."', (select ifnull(max(no_urut), 0) + 1 from log_".$_POST['Nama_Tabel']." where id = '".intval($_POST['id'])."') from ".$_POST['Nama_Tabel']." where id = '".intval($_POST['id'])."'";
 $execute = mysqli_query($koneksi, $query);
 if(!$execute)
  { $is_commit = 0;
  }

 $query = "update pesanan_detail set jumlah = 0 where pesanan_id = '".intval($id)."'";
 $execute = mysqli_query($koneksi, $query);
 if(!$execute)
  { $is_commit = 0;
  }

 //Update jumlah_pesanan pada tabel penawaran
 $query1 = "select id from penawaran where id in (select penawaran_id from penawaran_detail where id in (select penawaran_detail_id from pesanan_detail where pesanan_id = '".intval($_POST['id'])."'))";
 $execute1 = mysqli_query($koneksi, $query1);
 while($row1 = mysqli_fetch_array($execute1))
  { $query2 = "update penawaran set jumlah_pesanan = (select ifnull(sum(ifnull(jumlah, 0)), 0) from pesanan_detail where penawaran_detail_id in (select id from penawaran_detail where penawaran_id = '".intval($row1['id'])."')) where id = '".intval($row1['id'])."'";
    $execute2 = mysqli_query($koneksi, $query2);
    if(!$execute2)
     { $is_commit = 0;
     }
  }

 //Update jumlah_pesanan pada tabel penawaran
 $query1 = "select id from penawaran where id in (select penawaran_id from penawaran_detail where id in (select penawaran_detail_id from pesanan_detail where pesanan_id = '".intval($id)."'))";
 $execute1 = mysqli_query($koneksi, $query1);
 while($row1 = mysqli_fetch_array($execute1))
  { $query2 = "update penawaran set jumlah_pesanan = (select ifnull(sum(ifnull(jumlah, 0)), 0) from pesanan_detail where penawaran_detail_id in (select id from penawaran_detail where penawaran_id = '".intval($row1['id'])."')) where id = '".intval($row1['id'])."'";
    $execute2 = mysqli_query($koneksi, $query2);
    if(!$execute2)
     { $is_commit = 0;
     }
  }
 //update jumlah_pesanan pada tabel penawaran_detail
 $query1 = "select penawaran_detail_id from pesanan_detail where pesanan_id = '".intval($id)."'";
 $execute1 = mysqli_query($koneksi, $query1);
 while($row1 = mysqli_fetch_array($execute1))
  { $query2 = "update penawaran_detail set jumlah_pesanan = (select ifnull(sum(ifnull(jumlah, 0)), 0) from pesanan_detail where penawaran_detail_id = '".intval($row1['penawaran_detail_id'])."') where id = '".$row1['penawaran_detail_id']."'";
    $execute2 = mysqli_query($koneksi, $query2);
    if(!$execute2)
     { $is_commit = 0;
     }
  }
 //update detail pada tabel penawaran
 $query1 = "select id from penawaran where id in (select penawaran_id from penawaran_detail where id in (select penawaran_detail_id from pesanan_detail where pesanan_id = '".intval($id)."'))";
 $execute1 = mysqli_query($koneksi, $query1);
 while($row1 = mysqli_fetch_array($execute1))
  { $is_commit = setDetail($koneksi, $is_commit, "penawaran", "penawaran_detail", $row1['id']);
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