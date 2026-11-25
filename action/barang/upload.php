<?php

 include("../bjksadkhrej121lkjkjk.php");

 $lokasi_folder = "../../gambar/";
 if(!is_dir($lokasi_folder))
  { mkdir($lokasi_folder, 0755);
  }
 $lokasi_folder .= "barang/";
 if(!is_dir($lokasi_folder))
  { mkdir($lokasi_folder, 0755);
  }
 $folder_thumbnail = str_replace("barang/", "barang-thumbnail/", $lokasi_folder);
 if(!is_dir($folder_thumbnail))
  { mkdir($folder_thumbnail, 0755);
  }
 $lokasi_folder .= intval($_POST['id'])."/";
 if(!is_dir($lokasi_folder))
  { mkdir($lokasi_folder, 0755);
  }
 $folder_thumbnail .= intval($_POST['id'])."/";
 if(!is_dir($folder_thumbnail))
  { mkdir($folder_thumbnail, 0755);
  }
 if(move_uploaded_file($_FILES['foto']['tmp_name'], $lokasi_folder.date('YmdHis').".png"))
  { sleep(1);
  }

 $list_foto = scandir($lokasi_folder);
 $list_foto = array_values(array_filter($list_foto, function($var){
  return ($var !== "." && $var !== "..");
 }));
 if(count($list_foto) > 0)
  { //hapus tumbnail lama-------------------------------
    $list_thumbnail = scandir($folder_thumbnail);
    $list_thumbnail = array_values(array_filter($list_thumbnail, function($var){
     return ($var !== "." && $var !== "..");
    }));
    for($i=0; $i<count($list_thumbnail); $i++)
     { if($list_thumbnail[$i] !== $list_foto[0])
        { if(file_exists($folder_thumbnail.$list_thumbnail[$i]))
           { unlink($folder_thumbnail.$list_thumbnail[$i]);
           }
        }
     }
    //hapus tumbnail lama-------------------------------

    $source = $lokasi_folder.$list_foto[0];
    $destination = $folder_thumbnail.$list_foto[0];
    $max_size = 300;
    resizeImage($source, $destination, $max_size);
  }

?>