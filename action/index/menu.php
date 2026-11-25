<?php

 include("../bjksadkhrej121lkjkjk.php");
 include("../../design/url.php");

 $last_actual_link = "";
 if(isset($_POST['last_actual_link']) && $_POST['last_actual_link'] !== "")
  { $last_actual_link = $_POST['last_actual_link'];
  }

 $arrayAksesMenu = array();
 $query = "select * from menu_akses where users_level_id = '".$users_level_id."' group by url";
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { array_push($arrayAksesMenu, array(
     "url" => $row['url'],
     "action" => $row['action'],
    ));
  }

 $arrayMenuHeader = array();
 $arrayMenu = array();
 $query = "select * from menu order by no_urut asc";
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { if(strval($row['id_induk']) == "")
     { array_push($arrayMenuHeader, array(
        "id" => $row['id'],
        "menu" => $row['menu'],
        "icon" => $row['icon'],
        "url" => $row['url']."",
        "no_urut" => $row['no_urut'],
       ));
     }
    else
     { array_push($arrayMenu, array(
        "id" => $row['id'],
        "id_induk" => $row['id_induk'],
        "menu" => $row['menu'],
        "icon" => $row['icon'],
        "url" => $row['url']."",
        "no_urut" => $row['no_urut'],
       ));
     }
  }

 $execute = $koneksi->prepare("select * from perusahaan");
 $execute->execute();
 $result = $execute->get_result();
 $dataPerusahaan = $result->fetch_assoc();
 $nama_perusahaan = $dataPerusahaan['kode_perusahaan'] ?? '';

 $level_user = "";
 $query = "select level from users_level where id = '".$users_level_id."'";
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $level_user = $row['level'];
  }

 echo "<li class='header' style='text-align:center;'>".$nama_perusahaan."</li>";
 for($i=0; $i<count($arrayMenuHeader); $i++)
  { if($arrayMenuHeader[$i]['url'] == "")
     { $A = $arrayMenuHeader[$i]['id'];
       $B = array_filter($arrayMenu, function ($var) use ($A) {
        return ($var['id_induk'] == $A);
       });
       $B = array_values($B);
       $subMenu = "";
       $class = "";
       for($j=0; $j<count($B); $j++)
        { if($last_actual_link == $B[$j]['url'])
           { $subMenu .= "<li class='active'><a href='".$url."/".$B[$j]['url']."'><i class='fa fa-".$B[$j]['icon']."'></i> <span>".$B[$j]['menu']."</span></a></li>";
             $class = "active menu-open";
           }
          else
           { $index = array_search($B[$j]['url'], array_column($arrayAksesMenu, 'url'));
             $validasiIndex = $index."";
             if($validasiIndex == "") {} else
              { $subMenu .= "<li><a href='".$url."/".$B[$j]['url']."'><i class='fa fa-".$B[$j]['icon']."'></i> <span>".$B[$j]['menu']."</span></a></li>";
              }
           }
        }
       if($subMenu !== "")
        { echo "<li class='treeview ".$class."'>
                 <a>
                  <i class='fa fa-".$arrayMenuHeader[$i]['icon']."'></i>
                  <span>".$arrayMenuHeader[$i]['menu']."</span>
                  <span class='pull-right-container'>
                   <i class='fa fa-angle-left pull-right'></i>
                  </span>
                  </a>
                 <ul class='treeview-menu'>".$subMenu."</ul>
                </li>";
        }
     }
    else
     { if($last_actual_link == $arrayMenuHeader[$i]['url'])
        { echo "<li class='active'><a href='".$url."/".$arrayMenuHeader[$i]['url']."'><i class='fa fa-".$arrayMenuHeader[$i]['icon']."'></i><span>".$arrayMenuHeader[$i]['menu']."</span></a></li>";
        }
       else
        { $index = array_search($arrayMenuHeader[$i]['url'], array_column($arrayAksesMenu, 'url'));
          $validasiIndex = $index."";
          if($validasiIndex == "") {} else
           { echo "<li><a href='".$url."/".$arrayMenuHeader[$i]['url']."'><i class='fa fa-".$arrayMenuHeader[$i]['icon']."'></i><span>".$arrayMenuHeader[$i]['menu']."</span></a></li>";
           }
        }
     }
  }

 if(strtolower($last_actual_link) == "absensi")
  { $nama_perusahaan = "ABSENSI";
  }

?>

<textarea style='display:none;' id='hidden-nama-perusahaan'><?= $nama_perusahaan ?></textarea>
<textarea style='display:none;' id='hidden-level-user'><?= $level_user ?></textarea>
<script type="text/javascript">
 document.getElementById('label-nama-perusahaan').innerHTML = document.getElementById('hidden-nama-perusahaan').value;
 document.getElementById('label-jabatan').innerHTML = document.getElementById('hidden-level-user').value;
</script>