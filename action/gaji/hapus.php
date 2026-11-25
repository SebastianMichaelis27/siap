<?php

 include("../bjksadkhrej121lkjkjk.php");

 $is_commit = 1;
 mysqli_autocommit($koneksi, FALSE);

 $id = $_POST['id'] ?? null;

 $execute = $koneksi->prepare("select * from utang where gaji_id = ?");
 $execute->bind_param("i", $id);
 $execute->execute();
 $result = $execute->get_result();
 $utang = $result->fetch_assoc();
 $utang_id = $utang['id'] ?? "";

 if($utang_id !== "")
  { $execute = $koneksi->prepare("insert into log_utang select utang.*, ?, ?, (select ifnull(max(no_urut), 0) + 1 from log_utang where id = ?) from utang where id = ?");
    $execute->bind_param("siii", $now, $user_id, $utang_id, $utang_id);
    if(!$execute->execute())
     { $is_commit = 0;
     }

    $execute = $koneksi->prepare("delete from utang where id = ?");
    $execute->bind_param("i", $utang_id);
    if(!$execute->execute())
     { $is_commit = 0;
     }

    $execute = $koneksi->prepare("update karyawan set utang = ifnull(utang, 0) + ? where id = ?");
    $execute->bind_param("ii", $utang['nominal'], $utang['karyawan_id']);
    if(!$execute->execute())
     { $is_commit = 0;
     }
  }

 $execute = $koneksi->prepare("delete from ".preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['Nama_Tabel'])." where id = ?");
 $execute->bind_param("i", $id);
 if(!$execute->execute())
  { $is_commit = 0;
    echo '<div class="error">Gagal!</div>';
  }

 if($is_commit == 1)
  { mysqli_commit($koneksi);
    echo '<div class="success"></div>';
  }
 else
  { mysqli_rollback($koneksi);
  }

?>