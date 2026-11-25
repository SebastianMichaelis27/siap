<?php

 include("../bjksadkhrej121lkjkjk.php");

 if(isset($_POST['data']) && $_POST['data'] <> "" && $_POST['data'] <> "[]")
  { $data = json_decode($_POST['data'], true);
    $query_insert_akses = "";
    for($i=0; $i<count($data); $i++)
     { if($query_insert_akses == "")
        { $query_insert_akses .= "('".$_POST['users_level_id_']."', '".$data[$i]['url']."', '".$data[$i]['action']."')";
        }
       else
        { $query_insert_akses .= ", ('".$_POST['users_level_id_']."', '".$data[$i]['url']."', '".$data[$i]['action']."')";
        }
     }
    if($query_insert_akses !== "")
     { $query = "delete from menu_akses where users_level_id = '".$_POST['users_level_id_']."'";
       $execute = mysqli_query($koneksi, $query);
       $query_insert_akses = "insert into menu_akses(users_level_id, url, action) values".$query_insert_akses;
       $execute_insert_akses = mysqli_query($koneksi, $query_insert_akses);
       if($execute_insert_akses)
        { echo "1";
        }
     }
  }
 else
  { $query = "delete from menu_akses where users_level_id = '".$_POST['users_level_id_']."'";
    $execute = mysqli_query($koneksi, $query);
    if($execute)
     { echo "1";
     }
  }

?>