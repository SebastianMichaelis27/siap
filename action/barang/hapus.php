<?php

 include("../bjksadkhrej121lkjkjk.php");

 $result = array(
  "status" => 1,
  "pesan" => "",
  "id" => "",
 );

 $is_commit = 1;
 mysqli_autocommit($koneksi, FALSE);

 $query = "delete from ".$_POST['Nama_Tabel']." where id = '".intval($_POST['id'])."'";
 $execute = mysqli_query($koneksi, $query);
 if(!$execute)
  { $is_commit = 0;
    $result['status'] = 0;
    $result['pesan'] = "Gagal! Koneksi terputus";
  }

 if($is_commit == 1)
  { mysqli_commit($koneksi);
  }
 else
  { mysqli_rollback($koneksi);
  }

 echo json_encode($result);

?>