<?php

 include("../bjksadkhrej121lkjkjk.php");

 $folder = "../../gambar/";
 if(!is_dir($folder))
  { mkdir($folder, 0755);
  }

 $folder .= "tanda-tangan/";
 if(!is_dir($folder))
  { mkdir($folder, 0755);
  }

 $is_commit = 1;
 mysqli_autocommit($koneksi, FALSE);

 $query = "select file_ttd from tanda_tangan";
 $execute = mysqli_query($koneksi, $query);
 $data_lama = mysqli_fetch_assoc($execute);
 $file_lama = $data_lama['file_ttd'] ?? "none.png";

 $query = "delete from ".$_POST['Nama_Tabel']." where id = '".intval($_POST['id'])."'";
 $execute = mysqli_query($koneksi, $query);
 if($execute)
  { if(file_exists($folder.$file_lama))
     { unlink($folder.$file_lama);
     }
  }
 else
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