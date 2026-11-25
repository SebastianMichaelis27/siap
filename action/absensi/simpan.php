<?php

 include("../bjksadkhrej121lkjkjk.php");

 date_default_timezone_set('Asia/Jakarta');
 $info = getdate();
 $date = $info['mday'];
 $month = $info['mon'];
 $year = $info['year'];
 $hour = $info['hours'];
 $min = $info['minutes'];
 $sec = $info['seconds'];
 $now = $year."-".str_pad($month,2,"0",STR_PAD_LEFT)."-".str_pad($date,2,"0",STR_PAD_LEFT)." ".str_pad($hour,2,"0",STR_PAD_LEFT).":".str_pad($min,2,"0",STR_PAD_LEFT).":".str_pad($sec,2,"0",STR_PAD_LEFT);

 $lokasi_folder = "../../gambar/";
 if(!is_dir($lokasi_folder))
  { mkdir($lokasi_folder, 0755);
  }
 $lokasi_folder .= "absensi/";
 if(!is_dir($lokasi_folder))
  { mkdir($lokasi_folder, 0755);
  }

 $is_commit = 0;
 mysqli_autocommit($koneksi, FALSE);

 $karyawan_id = "";
 $query = "select * from users where username = '".$username."'";
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $karyawan_id = $row['karyawan_id'];
  }

 $cabang_id = "";
 $query = "select cabang_id from karyawan where id = ".intval($karyawan_id);
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $cabang_id = $row['cabang_id'];
  }

 $query = "insert into absensi(cabang_id, karyawan_id, jenis_absen, tanggal_waktu, status) values('".intval($cabang_id)."', '".intval($karyawan_id)."', '".str_replace("'", "\'", $_POST['jenis_absen'])."', '".$now."', '0')";
 $execute = mysqli_query($koneksi, $query);
 if($execute)
  { $nama_file = mysqli_insert_id($koneksi).".png";
    if(isset($_FILES["file"]))
     { $fileTmpLoc = $_FILES["file"]["tmp_name"];
       $fileType = $_FILES["file"]["type"];
       $fileSize = $_FILES["file"]["size"];
       $fileErrorMsg = $_FILES["file"]["error"];
       if(move_uploaded_file($fileTmpLoc, $lokasi_folder.$nama_file))
        { $is_commit = 1;
        }
     }
  }

 if($is_commit == 1)
  { mysqli_commit($koneksi);
    echo "1";
  }
 else
  { mysqli_rollback($koneksi);
  }

?>