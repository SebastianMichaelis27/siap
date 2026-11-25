<?php

 include("../bjksadkhrej121lkjkjk.php");

 $result = array(
  "status" => 1,
  "pesan" => "",
  "id" => "",
 );

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

 if(isset($_POST['diskon']) && $_POST['diskon'] !== "")
  { $data['diskon_jenis_customer'] = $_POST['diskon'];
  }
 else
  { $data['diskon_jenis_customer'] = null;
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
  { $query = "select count(*) as jlh from ".$_POST['Nama_Tabel']." where ".$filterExist;
    $execute = mysqli_query($koneksi, $query);
    while($row = mysqli_fetch_array($execute))
     { $jlh = intval($row['jlh']); 
     }
  }

 if($jlh < 1)
  { $queryField = "";
    $queryValue = "";
    foreach($data as $field => $value)
     { if(is_array($value))
        { $value = json_encode($value);
        }
       if(isset($value) && $value !== "")
        { $value = "'".str_replace("'", "\'", $value)."'";
        }
       else
        { $value = "null";
        }
       if($queryField !== "")
        { $queryField .= ", ";
          $queryValue .= ", ";
        }
       $queryField .= $field;
       $queryValue .= $value;
     }
    $query = "insert into ".$_POST['Nama_Tabel']." (".$queryField.") values (".$queryValue.")";
    $execute = mysqli_query($koneksi, $query);
    if($execute)
     { $result['id'] = mysqli_insert_id($koneksi);
     }
    else
     { $is_commit = 0;
       $result['status'] = 0;
       $result['pesan'] = "Gagal! Koneksi terputus";
     }
  }
 else
  { $is_commit = 0;
    $result['status'] = 0;
    $result['pesan'] = "Gagal! Data Duplikat";
  }

 if($is_commit == 1)
  { mysqli_commit($koneksi);
  }
 else
  { mysqli_rollback($koneksi);
  }

 echo json_encode($result);

?>