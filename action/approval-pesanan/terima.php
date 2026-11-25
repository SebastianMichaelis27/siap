<?php
 include("../bjksadkhrej121lkjkjk.php");

 $now = date('Y-m-d H:i:s');

 $is_commit = 1;
 mysqli_autocommit($koneksi, FALSE);

 $query = "update pesanan set approved_at = '".$now."', approved_by = '".$username."', approved_type = 'confirm', rejected_at = null, rejected_by = null where id = ".intval($_POST['id']);
 $execute = mysqli_query($koneksi, $query);
 if(!$execute)
  { $is_commit = 0;
  }

 $query = "update pesanan_detail set approved_at = '".$now."', approved_by = '".$username."', approved_type = 'confirm', rejected_at = null, rejected_by = null where pesanan_id = ".intval($_POST['id']);
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