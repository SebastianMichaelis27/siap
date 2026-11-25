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

 $query = "insert into log_".$_POST['Nama_Tabel']." select ".$_POST['Nama_Tabel'].".*, '".$now."', '".$username."', (select ifnull(max(no_urut), 0) + 1 from log_".$_POST['Nama_Tabel']." where id = '".intval($_POST['id'])."') from ".$_POST['Nama_Tabel']." where id = '".intval($_POST['id'])."'";
 $execute = mysqli_query($koneksi, $query);
 if(!$execute)
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