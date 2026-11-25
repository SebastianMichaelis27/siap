<?php
 if(isset($_GET['username']) && $_GET['username'] !== "")
  { $_POST['username'] = $_GET['username'];
  }
 if(isset($_GET['users_level_id']) && $_GET['users_level_id'] !== "")
  { $_POST['users_level_id'] = $_GET['users_level_id'];
  }
 if(isset($_GET['gudang_id']) && $_GET['gudang_id'] !== "")
  { $_POST['gudang_id'] = $_GET['gudang_id'];
  }
 if(isset($_GET['token']) && $_GET['token'] !== "")
  { $_POST['token'] = $_GET['token'];
  }
 include("../bjksadkhrej121lkjkjk.php");

 $list = array();
 $query = "select * from karyawan where (nik like '%".str_replace("'", "\'", $_GET['search'])."%' or nama like '%".str_replace("'", "\'", $_GET['search'])."%')";
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $list = array(array(
     "id" => $row['id'],
     "text" => $row['nik']." - ".$row['nama'],
    ));
  }
 echo json_encode($list);
?>