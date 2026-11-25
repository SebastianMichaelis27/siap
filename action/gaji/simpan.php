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
 $data['created_at'] = $now;
 $data['created_by'] = $user_id;

 $where = "";
 $types = '';
 $values = [];
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
    while ($row = $result->fetch_assoc())
     { $jlh = intval($row['jlh']);
     }
  }

 if($jlh < 1)
  { $normalisasi_data = [];
    $types = "";
    $values = [];
    $params = [];
    foreach($data as $field => $value)
     { $normalisasi_field = preg_replace('/[^a-zA-Z0-9_]/', '', $field);
       $normalisasi_data[$normalisasi_field] = $value;
       if($value === null || strtolower($value) === 'null' || $value === '')
        { $params[] = "null";
        }
       else
        { $types .= "s";
          $values[] = $value;
          $params[] = "?";
        }
     }
    $data = $normalisasi_data;

    $execute = $koneksi->prepare("insert into ".preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['Nama_Tabel'])." (".implode(',', array_keys($data)).") values(".implode(", ", $params).")");
    $execute->bind_param($types, ...$values);
    if($execute->execute())
     { $id = $koneksi->insert_id;

       if(isset($data['potongan_utang']) && strval($data['potongan_utang']) !== "" && strval($data['potongan_utang']) !== "null")
        { $execute2 = $koneksi->prepare("insert into utang(karyawan_id, gaji_id, tanggal, jenis_transaksi, keterangan, nominal, created_at, created_by) values(?, ?, ?, 'Membayar Utang', 'Dipotong Dari Gaji', ?, ?, ?)");
          $execute2->bind_param("iisisi", $data['karyawan_id'], $id, $data['tanggal'], $data['potongan_utang'], $now, $user_id);
          if($execute2->execute())
           { $utang_id = $koneksi->insert_id;
           }
          else
           { $is_commit = 0;
           }

          $execute2 = $koneksi->prepare("update karyawan set utang = ifnull(utang, 0) - ? where id = ?");
          $execute2->bind_param("ii", $data['potongan_utang'], $data['karyawan_id']);
          if(!$execute2->execute())
           { $is_commit = 0;
           }

          $execute2 = $koneksi->prepare("insert into log_utang select utang.*, null, null, (select ifnull(max(no_urut), 0) + 1 from log_utang where id = ?) from utang where id = ?");
          $execute2->bind_param("ii", $utang_id, $utang_id);
          if(!$execute2->execute())
           { $is_commit = 0;
           }
        }

       $execute2 = $koneksi->prepare("insert into log_".preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['Nama_Tabel'])." select ".preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['Nama_Tabel']).".*, null, null, (select ifnull(max(no_urut), 0) + 1 from log_".preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['Nama_Tabel'])." where id = ?) from ".preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['Nama_Tabel'])." where id = ?");
       $execute2->bind_param("ii", $id, $id);
       if(!$execute2->execute())
        { $is_commit = 0;
        }
     }
    else
     { $is_commit = 0;
       echo '<div class="error">Gagal Terimpan!</div>';
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