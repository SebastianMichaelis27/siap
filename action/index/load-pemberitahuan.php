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

 $jlh_pemberitahuan = "";
 $judul_pemberitahuan = "Tidak ada pemberitahuan";
 $list_pemberitahuan = "";

 $jlh_notif_absensi = 0;
 $jlh_notif_izin = 0;
 $jlh_notif_lembur = 0;

 $query = "select * from absen where status = 0";
 $execute = mysqli_query($koneksi, $query);
 $jlh_notif_absensi = mysqli_num_rows($execute);
 if($jlh_notif_absensi > 0)
  { $list_pemberitahuan .= "<li><a href='validasi-absensi'><i class='fa fa-calendar-check-o text-yellow'></i>Terdapat ".number_format($jlh_notif_absensi, 0, ",", ".")." Validasi Absensi</a></li>";
  }

 $query = "select * from izin where status = 0";
 $execute = mysqli_query($koneksi, $query);
 $jlh_notif_izin = mysqli_num_rows($execute);
 if($jlh_notif_izin > 0)
  { $list_pemberitahuan .= "<li><a href='validasi-izin'><i class='fa fa-calendar-check-o text-yellow'></i>Terdapat ".number_format($jlh_notif_izin, 0, ",", ".")." Pengajuan Izin</a></li>";
  }

 $query = "select * from lembur where status = 0";
 $execute = mysqli_query($koneksi, $query);
 $jlh_notif_lembur = mysqli_num_rows($execute);
 if($jlh_notif_lembur > 0)
  { $list_pemberitahuan .= "<li><a href='validasi-lembur'><i class='fa fa-calendar-check-o text-yellow'></i>Terdapat ".number_format($jlh_notif_lembur, 0, ",", ".")." Pengajuan Lembur</a></li>";
  }

 if($jlh_notif_absensi > 0 || $jlh_notif_izin > 0 || $jlh_notif_lembur > 0)
  { $jlh_pemberitahuan = number_format($jlh_notif_absensi + $jlh_notif_izin + $jlh_notif_lembur, 0, ",", ".");
    $judul_pemberitahuan = number_format($jlh_notif_absensi + $jlh_notif_izin + $jlh_notif_lembur, 0, ",", ".")." Pemberitahuan";
  }

?>
<script>
 document.getElementById('jumlah-pemberitahuan').innerHTML = '<?= $jlh_pemberitahuan ?>';
 document.getElementById('judul-pemberitahuan').innerHTML = '<?= $judul_pemberitahuan ?>';
 document.getElementById('list-pemberitahuan').innerHTML = `<?= $list_pemberitahuan ?>`;
</script>