<?php

 include("../bjksadkhrej121lkjkjk.php");

 $query = "select * from users where username = '".$username."'";
 $execute = mysqli_query($koneksi, $query);
 if(mysqli_num_rows($execute) > 0)
  { while($row = mysqli_fetch_array($execute))
     { $query2 = "select * from users where username = '".$row['username']."' and password = hex(aes_encrypt('".$_POST['password_lama']."', 'Kjsd902Jks97161h1kd'))";
       $execute2 = mysqli_query($koneksi, $query2);
       if(mysqli_num_rows($execute2) > 0)
        { $query3 = "update users set password = hex(aes_encrypt('".$_POST['password_baru']."', 'Kjsd902Jks97161h1kd')) where username = '".$row['username']."'";
          $execute3 = mysqli_query($koneksi, $query3);
          if($execute3)
           { echo "<script>
                    alert('Password diubah');
                    location.href = 'logout';
                   </script>";
           }
        }
       else
        { echo "<script>
                 alert('Password salah!');
                </script>";
        }
     }
  }

?>