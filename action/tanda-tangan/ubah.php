<?php

 include("../bjksadkhrej121lkjkjk.php");

 $folder = "../../gambar/";
 if(!is_dir($folder))
  { mkdir($folder, 0755);
  }

 $folder .= "tanda-tangan/";
 if(!is_dir($folder))
  { mkdir($folder, 0755);
  }

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

 $query = "select file_ttd from tanda_tangan";
 $execute = mysqli_query($koneksi, $query);
 $data_lama = mysqli_fetch_assoc($execute);
 $file_lama = $data_lama['file_ttd'] ?? "none.png";

 if($jlh < 1)
  { $queryUpdate = "";
    foreach($data as $field => $value)
     { if(isset($value) && $value !== "")
        { $value = "'".str_replace("'", "\'", $value)."'";
        }
       else
        { $value = "null";
        }
       if($queryUpdate !== "")
        { $queryUpdate .= ", ";
        }
       $queryUpdate .= $field." = ".$value;
     }

    $nama_file = date('YmdHis').".png";
    if(isset($_FILES['file_ttd']))
     { $is_commit = 0;
       if(move_uploaded_file($_FILES['file_ttd']['tmp_name'], $folder.$nama_file))
        { $queryUpdate .= ", file_ttd = '".$nama_file."'";
          $is_commit = 1;
          if(file_exists($folder.$file_lama))
           { unlink($folder.$file_lama);
           }
        }
     }
    else if(isset($_POST['hapus_file']) && $_POST['hapus_file'] == "none")
     { if(file_exists($folder.$file_lama))
        { unlink($folder.$file_lama);
        }
     }

    $query = "update ".$_POST['Nama_Tabel']." set ".$queryUpdate." where id = '".intval($_POST['id'])."'";
    $execute = mysqli_query($koneksi, $query);
    if(!$execute)
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