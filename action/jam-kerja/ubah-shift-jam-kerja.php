<?php

 include("../bjksadkhrej121lkjkjk.php");

 $is_commit = 1;
 mysqli_autocommit($koneksi, FALSE);

 $DataTidakBolehRangkap = array();
 if(isset($_POST['DataTidakBolehRangkap']) && $_POST['DataTidakBolehRangkap'] !== "")
  { $DataTidakBolehRangkap = json_decode($_POST['DataTidakBolehRangkap'], true);
  }

 $data = array();
 if(isset($_POST['data']) && $_POST['data'] !== "")
  { $data = json_decode($_POST['data'], true);
  }

 $queryUpdate = "";
 foreach($data as $field => $value)
  { if(isset($value) && $value !== "")
     { $value = "'".str_replace("'", "\'", $value)."'";
     }
    else
     { $value = "null";
     }
    if($queryUpdate !== "")
     { $queryUpdate .= ", ";
     }
    $queryUpdate .= $field." = ".$value;
  }
 $query = "update ".$_POST['Nama_Tabel']." set ".$queryUpdate." where id = '".intval($_POST['id'])."'";
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