<?php
 $koneksi = mysqli_connect("localhost", "u674869047_siap_mie", "1N$?*rzt1N$?*rz", "u674869047_siap_mie") or die("Koneksi gagal!");
 ini_set('memory_limit','800100M');
 ini_set('upload_max_filesize', '800100M');
 ini_set('post_max_size', '800100M');
 set_time_limit(0);

 $username = "";
 if(isset($_POST['username']) && $_POST['username'] !== "")
  { $username = str_replace("'", "\'", $_POST['username']);
  }
 $token = "";
 if(isset($_POST['token']) && $_POST['token'] !== "")
  { $token = str_replace("'", "\'", $_POST['token']);
  }

 $query = "select * from karyawan where nik = '".$username."' and hex(aes_encrypt(concat(ifnull(nik, ''), ifnull(password, ''), ifnull(last_login, '')), 'Kjsd902Jks97161h1kd')) = '".$token."'";
 $execute = mysqli_query($koneksi, $query);
 if(mysqli_num_rows($execute) < 1)
  { $koneksi = null;
    $result = array(
     "status" => "-1",
     "sql" => array(array(
      "sql" => "delete from users",
     )),
    );
    echo json_encode($result);
    exit;
  }

 function format_tanggal($tanggal)
  { $result = date('d', strtotime($tanggal))." ".getMonthName(date('m', strtotime($tanggal)))." ".date('Y', strtotime($tanggal));
    if(strlen($tanggal) > 10)
     { $result .= " ".date('H:i', strtotime($tanggal));
     }
    return $result;
  }

 function getMonthName($month)
  { $monthList = array(
     '01' => 'Januari',
     '02' => 'Februari',
     '03' => 'Maret',
     '04' => 'April',
     '05' => 'Mei',
     '06' => 'Juni',
     '07' => 'Juli',
     '08' => 'Agustus',
     '09' => 'September',
     '10' => 'Oktober',
     '11' => 'November',
     '12' => 'Desember'
    );
    if(isset($monthList[$month]) && $monthList[$month] !== "")
     { return $monthList[$month];
     }
    else
     { return "null";
     }
  }

 function getWeekGroup($tanggal)
  { $dayRange = array(
     'Sun' => 0,
     'Mon' => 86400,
     'Tue' => 172800,
     'Wed' => 259200,
     'Thu' => 345600,
     'Fri' => 432000,
     'Sat' => 518400,
    );

    $tanggal = date('Y-m-', strtotime($tanggal))."01";
    $range = $dayRange[date('D', strtotime($tanggal))];
    $tgl_minggu_pertama = date('Y-m-d', intval(strtotime($tanggal)) - $range);

    $arrayMinggu = array();
    for($i=0; $i<6; $i++)
     { $start_date = intval(strtotime($tgl_minggu_pertama)) + ($i * 604800);
       $end_date = $start_date + 518400;
       if(date('m', $end_date) == date('m', strtotime($tanggal)))
        { array_push($arrayMinggu, array(
           "start_date" => date('Y-m-d', $start_date),
           "end_date" => date('Y-m-d', $end_date),
          ));
        }
     }
    return $arrayMinggu;
  }

?>