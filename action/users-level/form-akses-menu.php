<?php
 include("../bjksadkhrej121lkjkjk.php");

 $arrayAkses = array();
 $query = "select * from menu_akses where users_level_id = '".$_POST['users_level_id_']."'";
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $arrayAkses[$row['url']."-".$row['action']] = "1";
  }

 $d = 0;
 $list_title = "";
 $list_content = "";
 $query = "select * from menu where ifnull(url, '') <> '' order by menu asc";
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $d++;

    $content = "<ul style='list-style-type:none; margin:0px; padding:0px;'><li><label style='font-weight:normal; user-select:none;'><input type='checkbox' class='check-all' onclick='checkAll(this)'>&nbsp Check/Uncheck All</label></li>";
    $files = scandir("../".$row['url']);
    for($i=2; $i<count($files); $i++)
     { $checked = "";
       if(isset($arrayAkses[$row['url']."-".$files[$i]]) && $arrayAkses[$row['url']."-".$files[$i]] == "1")
        { $checked = "checked";
        }

       $content .= "<li>
                    <label style='font-weight:normal; user-select:none;'><input type='checkbox' class='check-".$d." check-item' ".$checked.">&nbsp ".$files[$i]."</label>
                    <input type='hidden' class='hidden-url' value='".$row['url']."'>
                    <input type='hidden' class='hidden-action' value='".$files[$i]."'>
                    </li>";
     }
    $content .= "</ul>";

    if($d == 1)
     { $list_title .= "<button type='button' class='tab-button active' onclick='openTab(this);'>
                        ".$row['menu']."
                       </button>";
       $list_content .= "<div class='tab-content active'>".$content."</div>";
     }
    else
     { $list_title .= "<button type='button' class='tab-button' onclick='openTab(this);'>
                        ".$row['menu']."
                       </button>";
       $list_content .= "<div class='tab-content'>".$content."</div>";
     }
  }
?>

<div class='row'>
 <div class='col-md-12'>
  <div style='text-align:right;'><label style='font-weight:normal; user-select:none;'><input type='checkbox' id='check-all-menu' onclick='checkAllMenu()'> Check All</label><div>
 </div>
</div>
<div class='row' style='margin-top:5px;'>
  <div class='col-md-12'>

   <div class='tab-container'>
    <div class='tab-buttons'>
     <?= $list_title ?>
    </div>
    <?= $list_content ?>
   </div>

  </div>
 </div>
</div>