<?php
 include("../akjja012j19210239.php");

 $result = array(
  "status" => "0",
  "pesan" => "Gagal!",
 );

 date_default_timezone_set('Asia/Jakarta');
 $info = getdate();
 $date = $info['mday'];
 $month = $info['mon'];
 $year = $info['year'];
 $hour = $info['hours'];
 $min = $info['minutes'];
 $sec = $info['seconds'];
 $now = $year."-".str_pad($month,2,"0",STR_PAD_LEFT)."-".str_pad($date,2,"0",STR_PAD_LEFT)." ".str_pad($hour,2,"0",STR_PAD_LEFT).":".str_pad($min,2,"0",STR_PAD_LEFT).":".str_pad($sec,2,"0",STR_PAD_LEFT);

 $username = "";
 if(isset($_POST['username']) && $_POST['username'] !== "")
  { $username = str_replace("'", "\'", $_POST['username']);
  }
 $password = "";
 if(isset($_POST['password']) && $_POST['password'] !== "")
  { $password = str_replace("'", "\'", $_POST['password']);
  }

 $query = "select * from users where username = '".$username."' limit 1";
 $execute = mysqli_query($koneksi, $query);
 if(mysqli_num_rows($execute) > 0)
  { while($row = mysqli_fetch_array($execute))
     { $query2 = "select username, hex(aes_encrypt(concat(ifnull(username, ''), ifnull(password, ''), ifnull(users_level_id, ''), ifnull(cabang_id, ''), '".$now."'), 'Kjsd902Jks97161h1kd')) as token, users_level_id, cabang_id from users where username = '".str_replace("'", "\'", $row['username'])."' and password = hex(aes_encrypt('".$password."', 'Kjsd902Jks97161h1kd')) limit 1";
       $execute2 = mysqli_query($koneksi, $query2);
       if(mysqli_num_rows($execute2) > 0)
        { $query3 = "update users set last_login = '".$now."' where username = '".str_replace("'", "\'", $row['username'])."'";
          $execute3 = mysqli_query($koneksi, $query3);
          if($execute3)
           { while($row2 = mysqli_fetch_array($execute2))
              { $result = array(
                 "status" => "1",
                 "pesan" => "Berhasil",
                 "username" => strval($row2['username']),
                 "token" => strval($row2['token']),
                 "users_level_id" => strval($row2['users_level_id']),
                 "cabang_id" => strval($row2['cabang_id']),
                );
              }
           }
        }
       else
        { $result = array(
           "status" => "0",
           "pesan" => "Password salah!",
          );
        }
     }
  }
 else
  { $result = array(
     "status" => "0",
     "pesan" => "Username salah!",
    );
  }

 echo json_encode($result);

?>