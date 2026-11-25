<?php

 include("../bjksadkhrej121lkjkjk.php");

 $is_commit = 1;
 mysqli_autocommit($koneksi, FALSE);

 $DataTidakBolehRangkap = array();
 if(isset($_POST['DataTidakBolehRangkap']) && $_POST['DataTidakBolehRangkap'] !== "")
  { $DataTidakBolehRangkap = json_decode($_POST['DataTidakBolehRangkap'], true);
  }

 $data = array();
 if(isset($_POST['data']) && $_POST['data'] !== "")
  { $data = json_decode($_POST['data'], true);
  }

 $filterExist = "";
 for($i=0; $i<count($DataTidakBolehRangkap); $i++)
  { if(isset($DataTidakBolehRangkap[$i]['value']) && $DataTidakBolehRangkap[$i]['value'] !== "")
     { $DataTidakBolehRangkap[$i]['value'] = "'".str_replace("'", "\'", $DataTidakBolehRangkap[$i]['value'])."'";
     }
    else
     { $DataTidakBolehRangkap[$i]['value'] = "null";
     }
    if($filterExist == "")
     { $filterExist = "ifnull(lower(concat(".$DataTidakBolehRangkap[$i]['field'].")), '') = ".$DataTidakBolehRangkap[$i]['value'];
     }
    else
     { $filterExist .= " and ifnull(lower(concat(".$DataTidakBolehRangkap[$i]['field'].")), '') = ".$DataTidakBolehRangkap[$i]['value'];
     }
  }

 $jlh = 0;
 if($filterExist !== "")
  { $query = "select count(*) as jlh from ".$_POST['Nama_Tabel']." where ".$filterExist." and id <> '".intval($_POST['id'])."'";
    $execute = mysqli_query($koneksi, $query);
    while($row = mysqli_fetch_array($execute))
     { $jlh = intval($row['jlh']); 
     }
  }

 if($jlh < 1)
  { $queryUpdate = "";
    foreach($data as $field => $value)
     { if(isset($value) && $value !== "")
        { if($field == "no_hp")
           { $value = "'".str_replace("'", "\'", json_encode($value))."'";
           }
          else if($field == "password")
           { $value = "hex(aes_encrypt('".str_replace("'", "\'", $value)."', 'Kjsd902Jks97161h1kd'))";
           }
          else
           { $value = "'".str_replace("'", "\'", $value)."'";
           }
        }
       else
        { $value = "null";
        }
       if($queryUpdate !== "")
        { $queryUpdate .= ", ";
        }
       $queryUpdate .= $field." = ".$value;
     }
    $query = "update ".$_POST['Nama_Tabel']." set ".$queryUpdate." where id = '".intval($_POST['id'])."'";
    $execute = mysqli_query($koneksi, $query);
    if($execute)
     { $karyawan_id = intval($_POST['id']);
       $query2 = "delete from users where karyawan_id = '".$karyawan_id."'";
       $execute2 = mysqli_query($koneksi, $query2);
       if(!$execute2)
        { $is_commit = 0;
        }
       $query2 = "insert into users(username, password, users_level_id, cabang_id, nama, jabatan, karyawan_id) select karyawan.nik, karyawan.password, '2', karyawan.cabang_id, karyawan.nama, jabatan.jabatan, karyawan.id from karyawan left join jabatan on karyawan.jabatan_id = jabatan.id where karyawan.id = '".$karyawan_id."'";
       $execute2 = mysqli_query($koneksi, $query2);
       if(!$execute2)
        { $is_commit = 0;
        }
     }
    else
     { $is_commit = 0;
     }
  }
 else
  { $is_commit = 0;
    echo "Gagal! Data duplikat";
  }

 if($is_commit == 1)
  { mysqli_commit($koneksi);
    echo "1";
  }
 else
  { mysqli_rollback($koneksi);
  }

?>