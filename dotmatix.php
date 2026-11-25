<?php

$tmpdir = sys_get_temp_dir();
$file = tempnam($tmpdir, 'ctk');
$handle = fopen($file, 'w');

$data  = "\x1B@";      // Reset printer
$data .= "\x0F";       // Condensed ON
$data .= $_POST['data'] ?? "Test";

fwrite($handle, $data);
fclose($handle);

copy($file, "//localhost/EPSONLX");
unlink($file);

?>