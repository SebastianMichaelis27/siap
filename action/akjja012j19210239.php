<?php
 $koneksi = mysqli_connect("localhost", "root", "", "siap") or die("Koneksi gagal!");
 ini_set('memory_limit','800100M');
 ini_set('upload_max_filesize', '800100M');
 ini_set('post_max_size', '800100M');
 set_time_limit(0);
 date_default_timezone_set('Asia/Jakarta');
?>