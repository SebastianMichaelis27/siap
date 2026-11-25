<?php

 include("../bjksadkhrej121lkjkjk.php");

 $lokasi_folder = "../../gambar/";
 if(!is_dir($lokasi_folder))
  { mkdir($lokasi_folder, 0755);
  }
 $lokasi_folder .= "karyawan/";
 if(!is_dir($lokasi_folder))
  { mkdir($lokasi_folder, 0755);
  }

 $file_foto = "none.png";
 $query = "select * from karyawan where id = '".intval($_POST['id'])."'";
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { if(isset($row['file_foto']) && $row['file_foto'] !== "")
     { $file_foto = $row['file_foto'];
     }
  }

 date_default_timezone_set('Asia/Jakarta');
 $info = getdate();
 $date = $info['mday'];
 $month = $info['mon'];
 $year = $info['year'];
 $hour = $info['hours'];
 $min = $info['minutes'];
 $sec = $info['seconds'];
 $nama_file = intval($_POST['id'])."_".$year.str_pad($month,2,"0",STR_PAD_LEFT).str_pad($date,2,"0",STR_PAD_LEFT).str_pad($hour,2,"0",STR_PAD_LEFT).str_pad($min,2,"0",STR_PAD_LEFT).str_pad($sec,2,"0",STR_PAD_LEFT).".png";

 if(isset($_FILES["file"]))
  { $fileTmpLoc = $_FILES["file"]["tmp_name"];
    $fileType = $_FILES["file"]["type"];
    $fileSize = $_FILES["file"]["size"];
    $fileErrorMsg = $_FILES["file"]["error"];
    if(move_uploaded_file($fileTmpLoc, $lokasi_folder.$nama_file))
     { $query = "update karyawan set file_foto = '".$nama_file."' where id = '".intval($_POST['id'])."'";
       $execute = mysqli_query($koneksi, $query);
       if($execute)
        { echo "1";
          if(file_exists($lokasi_folder.$file_foto))
           { unlink($lokasi_folder.$file_foto);
           }
        }
     }
  }

?>