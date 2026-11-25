<?php
 include("../akjja012j19210239.php");
 $query = "select * from perusahaan limit 1";
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { echo "gambar/".$row['logo'];
  }
?>