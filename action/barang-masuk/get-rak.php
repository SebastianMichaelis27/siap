<?php
 if(isset($_GET['username']) && $_GET['username'] !== "")
  { $_POST['username'] = $_GET['username'];
  }
 if(isset($_GET['users_level_id']) && $_GET['users_level_id'] !== "")
  { $_POST['users_level_id'] = $_GET['users_level_id'];
  }
 if(isset($_GET['cabang_id']) && $_GET['cabang_id'] !== "")
  { $_POST['cabang_id'] = $_GET['cabang_id'];
  }
 if(isset($_GET['token']) && $_GET['token'] !== "")
  { $_POST['token'] = $_GET['token'];
  }
 include("../bjksadkhrej121lkjkjk.php");
 $list = array();
 $query = "select * from rak where gudang_id = '".intval($_GET['gudang_id'])."' and nama_rak like '%".str_replace("'", "\'", $_GET['search'])."%' order by nama_rak asc";
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { array_push($list, array(
     "id" => $row['id'],
     "text" => $row['nama_rak'],
    ));
  }
 echo json_encode($list);
?>