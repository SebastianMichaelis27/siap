<?php
 $koneksi = mysqli_connect("localhost", "root", "", "siap") or die("Koneksi gagal!");

 error_reporting(E_ALL);
 ini_set('display_errors', 1);

 ini_set('memory_limit','800100M');
 ini_set('upload_max_filesize', '800100M');
 ini_set('post_max_size', '800100M');
 set_time_limit(0);
 date_default_timezone_set('Asia/Jakarta');

 $username = "";
 if(isset($_POST['username']) && $_POST['username'] !== "")
  { $username = str_replace("'", "\'", $_POST['username']);
  }
 $users_level_id = "";
 if(isset($_POST['users_level_id']) && $_POST['users_level_id'] !== "")
  { $users_level_id = $_POST['users_level_id'];
  }
 $token = "";
 if(isset($_POST['token']) && $_POST['token'] !== "")
  { $token = str_replace("'", "\'", $_POST['token']);
  }
 $query = "select hex(aes_encrypt(concat(ifnull(username, ''), ifnull(password, ''), ifnull(users_level_id, ''), ifnull(cabang_id, ''), ifnull(last_login, '')), 'Kjsd902Jks97161h1kd')) as token from users where username = '".$username."'";
 $execute = mysqli_query($koneksi, $query);
 if(mysqli_num_rows($execute) > 0)
  { while($row = mysqli_fetch_array($execute))
    { if(strval($token) !== strval($row['token']))
       { $koneksi = null;
       }
    }
  }
 else
  { $koneksi = null;
  }
 if($koneksi == null)
  { echo "<script>
           location.href = 'logout';
          </script>";
    exit;
  }

 $actual_link = $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
 $array_url = explode("/", $actual_link);
 if(strval(strpos($actual_link, "/action/")) !== "")
  { if(strtolower($array_url[count($array_url) - 2]) !== "index")
     { $query = "select * from menu_akses where users_level_id = '".$users_level_id."' and lower(url) = '".strtolower($array_url[count($array_url) - 2])."' and lower(action) = '".strtolower($array_url[count($array_url) - 1])."'";
       $execute = mysqli_query($koneksi, $query);
       if(mysqli_num_rows($execute) < 1)
        { echo "Anda tidak memiliki otoritas untuk menggunakan fitur ini";
          $koneksi = null;
          exit;
        }
     }
  }

 function array_orderby()
  { $args = func_get_args();
    $data = array_shift($args);
    foreach ($args as $n => $field) {
        if (is_string($field)) {
            $tmp = array();
            foreach ($data as $key => $row)
                $tmp[$key] = $row[$field];
            $args[$n] = $tmp;
            }
    }
    $args[] = &$data;
    call_user_func_array('array_multisort', $args);
    return array_pop($args);
  }

 function normalisasi($nilai)
  { $n=strlen($nilai);
    $hasil="";
    $d=0;
    for($i=1;$i<=$n;$i++)
     { if(substr($nilai,$d,1)=="0" || substr($nilai,$d,1)=="1" || substr($nilai,$d,1)=="2" || substr($nilai,$d,1)=="3" || substr($nilai,$d,1)=="4" ||
       substr($nilai,$d,1)=="5" || substr($nilai,$d,1)=="6" || substr($nilai,$d,1)=="7" || substr($nilai,$d,1)=="8" || substr($nilai,$d,1)=="9" || substr($nilai,$d,1)==",")
        { if(substr($nilai,$d,1)==",")
           { $hasil=$hasil.".";
           }
          else
           { $hasil=$hasil.substr($nilai,$d,1);
           }
        }
       $d++;
     }
    if($hasil<1)
     { $hasil=0;
     }
    return $hasil;
  }

 function formatnomor($teks)
  { return number_format(normalisasi($teks), 0, ",", ".");
  }

 function refleshHalaman()
  { $pageURL='http';
    if(isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"]=="on")
     { $pageURL .= "s";
     }
    $pageURL .= "://";
    if(isset($_SERVER["SERVER_PORT"]) && $_SERVER["SERVER_PORT"]!="80")
     { $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
     }
    else
     { $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
     }
    return $pageURL;
  }

 function array_group_by(array $arr, callable $key_selector)
  { $result = array();
    foreach ($arr as $i)
     { $key = call_user_func($key_selector, $i);
       $result[$key][] = $i;
     }  
    return $result;
  }

 function rangeMonth($date1, $date2)
  { $ts1 = strtotime($date1);
    $ts2 = strtotime($date2);
    $year1 = date('Y', $ts1);
    $year2 = date('Y', $ts2);
    $month1 = date('m', $ts1);
    $month2 = date('m', $ts2);
    $diff = (($year2 - $year1) * 12) + ($month2 - $month1);
    return $diff;
  }

 function rangeYear($date1, $date2)
  { $y1 = intval(date('Y', strtotime($date1)));
    $y2 = intval(date('Y', strtotime($date2)));
    return ($y2 - $y1);
  }

 function plusMonthDate($date_input, $plus)
  { $date = date_create(date("Y-m-d", strtotime($date_input)));
    date_add($date, date_interval_create_from_date_string($plus." month"));
    return date_format($date, "Y-m-d");
  }

 function plusYearDate($date_input, $plus)
  { $date = date_create(date("Y-m-d", strtotime($date_input)));
    date_add($date, date_interval_create_from_date_string($plus." year"));
    return date_format($date, "Y-m-d");
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

 function getMonthName2($month)
  { $monthList = array(
     '01' => 'Jan',
     '02' => 'Feb',
     '03' => 'Mar',
     '04' => 'Apr',
     '05' => 'Mei',
     '06' => 'Jun',
     '07' => 'Jul',
     '08' => 'Ags',
     '09' => 'Sep',
     '10' => 'Okt',
     '11' => 'Nov',
     '12' => 'Des'
    );
    if(isset($monthList[$month]) && $monthList[$month] !== "")
     { return $monthList[$month];
     }
    else
     { return "null";
     }
  }

 function format_tanggal($tanggal)
  { $result = date('d', strtotime($tanggal))." ".getMonthName(date('m', strtotime($tanggal)))." ".date('Y', strtotime($tanggal));
    if(strlen($tanggal) > 10)
     { $result .= " ".date('H:i', strtotime($tanggal));
     }
    return $result;
  }

 function format_tanggal2($tanggal)
  { $result = date('d', strtotime($tanggal))."-".getMonthName2(date('m', strtotime($tanggal)))."-".date('Y', strtotime($tanggal));
    if(strlen($tanggal) > 10)
     { $result .= " ".date('H:i', strtotime($tanggal));
     }
    return $result;
  }

 function sebutkan_tanggal($tanggal)
  { $nama_bulan = array(
     1 => 'Januari',
     2 => 'Februari',
     3 => 'Maret',
     4 => 'April',
     5 => 'Mei',
     6 => 'Juni',
     7 => 'Juli',
     8 => 'Agustus',
     9 => 'September',
     10 => 'Oktober',
     11 => 'November',
     12 => 'Desember',
    );
    return date('d', strtotime($tanggal))." ".$nama_bulan[intval(date('m', strtotime($tanggal)))]." ".date('Y', strtotime($tanggal));
  }

 function sebutkanHari($tanggal)
  { $day = array(
     "Sun" => "Minggu",
     "Mon" => "Senin",
     "Tue" => "Selasa",
     "Wed" => "Rabu",
     "Thu" => "Kamis",
     "Fri" => "Jum'at",
     "Sat" => "Sabtu",
    );
    return $day[date('D', strtotime($tanggal))];
  }

 function getLastDateOfMonth($date)
  { return date("t", strtotime($date));
  }

 function rangeWaktu($strtime_start, $strtime_stop)
  { $durasi = "";
    $range = $strtime_stop - $strtime_start;
    $hari = 0;
    if($range >= 86400)
     { $hari = intval($range / 86400);
       $range = $range - ($hari * 86400);
     }
    if($hari > 0)
     { if($durasi !== "")
        { $durasi .= ", ";
        }
       $durasi .= $hari." Hari";
     }
     $jam = 0;
    if($range >= 3600)
     { $jam = intval($range / 3600);
       $range = $range - ($jam * 3600);
     }
    if($jam > 0)
     { if($durasi !== "")
        { $durasi .= ", ";
        }
       $durasi .= $jam." Jam";
     }
    $menit = 0;
    if($range >= 60)
     { $menit = intval($range / 60);
       $range = $range - ($menit * 60);
     }
    if($menit > 0)
     { if($durasi !== "")
        { $durasi .= ", ";
        }
       $durasi .= $menit." Menit";
     }
    return $durasi;
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

 function formatAngka($angka)
  { return rtrim(rtrim(number_format($angka ?? 0, 2, ',', '.'), '0'), ',');
  }

 function showArray($array)
  { for($i=0; $i<count($array); $i++)
     { print_r($array[$i]); echo "<br>";
     }
  }
 function penyebut($nilai)
  { $nilai = abs(intval($nilai));
    $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if($nilai < 12)
     { $temp = " ". $huruf[$nilai];
     }
    else if($nilai <20)
     { $temp = penyebut($nilai - 10). " belas";
     }
    else if($nilai < 100)
     { $temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
     }
    else if($nilai < 200)
     { $temp = " seratus" . penyebut($nilai - 100);
     }
    else if($nilai < 1000)
     { $temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
     }
    else if($nilai < 2000)
     { $temp = " seribu" . penyebut($nilai - 1000);
     }
    else if($nilai < 1000000)
     { $temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
     }
    else if($nilai < 1000000000)
     { $temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
     }
    else if($nilai < 1000000000000)
     { $temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
     }
    else if($nilai < 1000000000000000)
     { $temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
     }     
    return $temp;
  }
 
 function terbilang($nilai)
  { $hasil = "";
    if(!$nilai == "")
     { $minus = "";
       if($nilai < 0)
        { $minus = "minus ";
        }
       $nilai = abs($nilai);
       $hasil = penyebut($nilai);
       if(intval($nilai) < $nilai)
        { $hasil .= " koma";
          $koma = explode(".", strval($nilai))[1];
          $hasil = perulanganKoma($hasil, $koma)["hasil"];
        }
       $hasil = $minus.$hasil;
     }
    
    return ucwords($hasil);
  }

 function perulanganKoma($hasil, $koma)
  { if(substr($koma, 0, 1) == "0")
     { $hasil .= " nol";
       $koma = substr($koma, 1, strlen($koma) - 1);
       $hasil = perulanganKoma($hasil, $koma)["hasil"];
     }
    else
     { $hasil = $hasil." ".penyebut($koma);
     }
    return array(
     "hasil" => $hasil,
     "koma" => $koma,
    );
  }

 function pembulatan($nilai)
  { if($nilai - intval($nilai) >= 0.5)
     { $nilai = intval($nilai) + 1;
     }
    else
     { $nilai = intval($nilai);
     }
    return $nilai;
  }

 function setDetail($koneksi, $is_commit, $tabel_parent, $tabel_child, $id_parent)
  { $descTable = array();
    $query = "desc ".$tabel_child;
    $execute = mysqli_query($koneksi, $query);
    while($row = mysqli_fetch_array($execute))
     { array_push($descTable, array(
        "Field" => $row['Field'],
        "Type" => $row['Type'],
       ));
     }
    $detail = array();
    $query = "select * from ".$tabel_child." where ".$tabel_parent."_id = '".$id_parent."'";
    $execute = mysqli_query($koneksi, $query);
    while($row = mysqli_fetch_array($execute))
     { $array_push = array();
       for($i=0; $i<count($descTable); $i++)
        { if(isset($row[$descTable[$i]['Field']]) && $row[$descTable[$i]['Field']] !== "")
           { if(strval(strpos($descTable[$i]['Type'], "decimal")) !== "" || strval(strpos($descTable[$i]['Type'], "int")) !== "" || strval(strpos($descTable[$i]['Type'], "bigint")) !== "")
              { $array_push[$descTable[$i]['Field']] = $row[$descTable[$i]['Field']] * 1;
              }
             else if(strval(strpos($descTable[$i]['Type'], "text")) !== "")
              { try
                 { $array_push[$descTable[$i]['Field']] = json_decode($row[$descTable[$i]['Field']], true);
                 }
                catch(Exception $ex)
                 { $array_push[$descTable[$i]['Field']] = $row[$descTable[$i]['Field']];
                 }
              }
             else
              { $array_push[$descTable[$i]['Field']] = $row[$descTable[$i]['Field']];
              }
           }
          else
           { $array_push[$descTable[$i]['Field']] = null;
           }
        }
       array_push($detail, $array_push);
     }
    $query = "update ".$tabel_parent." set ".str_replace($tabel_parent."_", "", $tabel_child)." = '".str_replace("'", "\'", json_encode($detail))."' where id = '".$id_parent."'";
    $execute = mysqli_query($koneksi, $query);
    if(!$execute)
     { $is_commit = 0;
     }
    return $is_commit;
  }

 function insertUpdateDeletePenjualanDetailDitandai($koneksi, $is_commit, $penjualan_detail_id, $array_ditandai)
  { 
    //insert/update/delete penjualan_detail_ditandai
    if(is_array($array_ditandai))
     { foreach($array_ditandai as $key => $value)
        { $query1 = "select id from penjualan_detail_ditandai where penjualan_detail_id = '".$penjualan_detail_id."' and barang_masuk_detail_id = '".intval($value['barang_masuk_detail_id'])."'";
          $execute1 = mysqli_query($koneksi, $query1);
          if(mysqli_num_rows($execute1) > 0)
           { $query2 = "update penjualan_detail_ditandai set jumlah = '".intval($value['jumlah'])."' where penjualan_detail_id = '".$penjualan_detail_id."' and barang_masuk_detail_id = '".intval($value['barang_masuk_detail_id'])."'";
             $execute2 = mysqli_query($koneksi, $query2);
             if(!$execute2)
              { $is_commit = 0;
              }
           }
          else
           { $query2 = "insert into penjualan_detail_ditandai(penjualan_detail_id, barang_masuk_detail_id, jumlah) values('".$penjualan_detail_id."', '".intval($value['barang_masuk_detail_id'])."', '".intval($value['jumlah'])."')";
             $execute2 = mysqli_query($koneksi, $query2);
             if(!$execute2)
              { $is_commit = 0;
              }
           }
        }
     }

    $query1 = "delete from penjualan_detail_ditandai where penjualan_detail_id = '".$penjualan_detail_id."' and jumlah = 0";
    $execute1 = mysqli_query($koneksi, $query1);
    if(!$execute1)
     { $is_commit = 0;
     }

    //set ditandai pada tabel penjualan_detail
    $is_commit = setDetail($koneksi, $is_commit, "penjualan_detail", "penjualan_detail_ditandai", $penjualan_detail_id);

    return $is_commit;
  }

 function deleteDirectory($dir)
  { if(!is_dir($dir))
     { return false;
     }
    $files = scandir($dir);
    foreach ($files as $file)
     { if($file != "." && $file != "..")
        { $filePath = $dir . DIRECTORY_SEPARATOR . $file;
          if (is_dir($filePath))
           { // Recursively delete subdirectory
             deleteDirectory($filePath);
           }
          else
           { // Delete file
             unlink($filePath);
           }
        }
     }
    // Remove the main directory once it's empty
    return rmdir($dir);
  }

 function generateRandomString($length = 10)
  { $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for($i = 0; $i < $length; $i++)
     { $randomString .= $characters[random_int(0, $charactersLength - 1)];
     }
    return $randomString;
  }

 function isDecimal($value)
  { return is_numeric($value) && fmod($value, 1) != 0.0;
  }

 function resizeImage($source, $destination, $max_size)
  { $width = $max_size;
    $height = $max_size;
    $size = getimagesize($source);
    $source_width = $size[0];
    $source_height = $size[1];
    if($source_width >= $source_height)
     { $height = $source_height / $source_width * $max_size;
     }
    else
     { $width = $source_width / $source_height * $max_size;
     }
    // Ambil info gambar
    list($orig_width, $orig_height) = getimagesize($source);
    // Buat image dari file
    $src_image = imagecreatefrompng($source);
    // Buat canvas baru
    $dst_image = imagecreatetruecolor($width, $height);
    // Resize
    imagecopyresampled(
        $dst_image,
        $src_image,
        0, 0, 0, 0,
        $width, $height,
        $orig_width, $orig_height
    );
    // Simpan gambar baru
    imagejpeg($dst_image, $destination, 90);
    // Bersihkan memory
    imagedestroy($src_image);
    imagedestroy($dst_image);
  }

 function splitText($teks, $max_length, $result = [])
  { $teks = trim($teks ?? '');
    $result[] = substr($teks, 0, $max_length);
    $teks = substr($teks, $max_length, strlen($teks) - 1);
    $teks = trim($teks ?? '');
    if(strlen($teks) > 0)
     { $result = splitText($teks, $max_length, $result);
     }
    return $result;
  }

 function debugQuery($query, $types, $params)
  { $escaped = [];
    foreach($params as $key => $value)
     { if($types[$key] == 's')
        { $escaped[] = "'" . addslashes($value ?? '') . "'";
        }
       elseif($types[$key] == 'i' || $types[$key] == 'd')
        { $escaped[] = $value;
        }
       else
        { $escaped[] = "'" . addslashes($value ?? '') . "'";
        }
     }
    $queryParts = explode('?', $query);
    $finalQuery = '';
    foreach($queryParts as $index => $part)
     { $finalQuery .= $part;
       if(isset($escaped[$index]))
        { $finalQuery .= $escaped[$index];
        }
     }
    return $finalQuery;
  }

?>