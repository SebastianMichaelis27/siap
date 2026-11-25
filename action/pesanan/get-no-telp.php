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
 $list = array(array(
  "id" => preg_replace('/\D/', '', $_GET['search']),
  "text" => preg_replace('/\D/', '', $_GET['search']),
 ));
 echo json_encode($list);
?>