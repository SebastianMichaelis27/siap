<?php

 include("../bjksadkhrej121lkjkjk.php");

 $is_commit = 1;
 mysqli_autocommit($koneksi, FALSE);

 $DataTidakBolehRangkap = [];
 if(isset($_POST['DataTidakBolehRangkap']) && is_array($_POST['DataTidakBolehRangkap']))
  { $DataTidakBolehRangkap = $_POST['DataTidakBolehRangkap'];
  }
 $data = [];
 if(isset($_POST['data']) && is_array($_POST['data']))
  { $data = $_POST['data'];
  }
 $data['updated_at'] = $now;
 $data['updated_by'] = $user_id;

 $id = $_POST['id'] ?? null;

 $execute = $koneksi->prepare("select * from utang where gaji_id = ?");
 $execute->bind_param("i", $id);
 $execute->execute();
 $result = $execute->get_result();
 $utang = $result->fetch_assoc();
 $utang_id = $utang['id'] ?? "";
 if($utang_id !== "")
  { $execute = $koneksi->prepare("update utang set nominal = 0 where id = ?");
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

 $where = " id <> ?";
 $types = "i";
 $values = [];
 $values[] = $id;
 foreach($DataTidakBolehRangkap as $field => $value)
  { if($where !== "")
     { $where .= " and ";
     }
    if($value === null || strtolower($value) === 'null' || $value === '')
     { $where .= "ifnull(lower(concat(".preg_replace('/[^a-zA-Z0-9_]/', '', $field).")), '') = ''";
     }
    else
     { $where .= "ifnull(lower(concat(".preg_replace('/[^a-zA-Z0-9_]/', '', $field).")), '') = ?";
       $types .= "s";
       $values[] = $value;
     }
  }
 $jlh = 0;
 if(count($DataTidakBolehRangkap) > 0)
  { $execute = $koneksi->prepare("select count(*) as jlh from ".preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['Nama_Tabel'])." where ".$where);
    $execute->bind_param($types, ...$values);
    $execute->execute();
    $result = $execute->get_result();
    while($row = $result->fetch_assoc())
     { $jlh = intval($row['jlh']);
     }
  }

 if($jlh < 1)
  { $types = "";
    $values = [];
    $set = [];
    foreach($data as $field => $value)
     { $normalisasi_field = preg_replace('/[^a-zA-Z0-9_]/', '', $field);
       if($value === null || strtolower($value) === 'null' || $value === '')
        { $set[] = $normalisasi_field." = null";
        }
       else
        { $types .= "s";
          $values[] = $value;
          $set[] = $normalisasi_field." = ?";
        }
     }
    $types .= "i";
    $values[] = intval($_POST['id']);

    $execute = $koneksi->prepare("update ".preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['Nama_Tabel'])." set ".implode(", ", $set)." where id = ?");
    $execute->bind_param($types, ...$values);
    if(!$execute->execute())
     { $is_commit = 0;
       echo '<div class="error">Gagal!</div>';
     }

    if(isset($data['potongan_utang']) && strval($data['potongan_utang']) !== "" && strval($data['potongan_utang']) !== "null")
     { if($utang_id !== "")
        { $execute = $koneksi->prepare("update utang set karyawan_id = ?, gaji_id = ?, tanggal = ?, nominal = ?, updated_at = ?, updated_by = ? where id = ?");
          $execute->bind_param("iisisii", $data['karyawan_id'], $id, $data['tanggal'], $data['potongan_utang'], $now, $user_id, $utang_id);
          if(!$execute->execute())
           { $is_commit = 0;
           }
        }
       else
        { $execute = $koneksi->prepare("insert into utang(karyawan_id, gaji_id, tanggal, jenis_transaksi, keterangan, nominal, created_at, created_by) values(?, ?, ?, 'Membayar Utang', 'Dipotong Dari Gaji', ?, ?, ?)");
          $execute->bind_param("iisisi", $data['karyawan_id'], $id, $data['tanggal'], $data['potongan_utang'], $now, $user_id);
          if($execute->execute())
           { $utang_id = $koneksi->insert_id;
           }
          else
           { $is_commit = 0;
           }
        }

       $execute = $koneksi->prepare("update karyawan set utang = ifnull(utang, 0) - ? where id = ?");
       $execute->bind_param("ii", $data['potongan_utang'], $data['karyawan_id']);
       if(!$execute->execute())
        { $is_commit = 0;
        }
     }

    if($utang_id !== "")
     { $deleted_at = null;
       $deleted_by = null;
       $execute = $koneksi->prepare("select * from utang where id = ? and nominal = 0");
       $execute->bind_param("i", $utang_id);
       $execute->execute();
       $result = $execute->get_result();
       if($result->num_rows > 0)
        { $deleted_at = $now;
          $deleted_by = $user_id;
        }

       $execute = $koneksi->prepare("insert into log_utang select utang.*, ?, ?, (select ifnull(max(no_urut), 0) + 1 from log_utang where id = ?) from utang where id = ?");
       $execute->bind_param("siii", $deleted_at, $deleted_by, $utang_id, $utang_id);
       if(!$execute->execute())
        { $is_commit = 0;
        }

       if($deleted_at !== null)
        { $execute = $koneksi->prepare("delete from utang where id = ? and nominal = 0");
          $execute->bind_param("i", $utang_id);
          if(!$execute->execute())
           { $is_commit = 0;
           }
        }
     }

    $execute = $koneksi->prepare("insert into log_".preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['Nama_Tabel'])." select ".preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['Nama_Tabel']).".*, null, null, (select ifnull(max(no_urut), 0) + 1 from log_".preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['Nama_Tabel'])." where id = ?) from ".preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['Nama_Tabel'])." where id = ?");
    $execute->bind_param("ii", $id, $id);
    if(!$execute->execute())
     { $is_commit = 0;
     }

  }
 else
  { $is_commit = 0;
    echo '<div class="error">Gagal! Data duplikat</div>';
  }

 if($is_commit == 1)
  { mysqli_commit($koneksi);
    echo '<div class="success"></div>';
  }
 else
  { mysqli_rollback($koneksi);
  }

?>