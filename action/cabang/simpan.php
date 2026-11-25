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
     { if(isset($value) && $value !== "")
        { if($field == "no_telp" || $field == "no_wa" || $field == "email")
           { $value = "'".str_replace("'", "\'", json_encode($value))."'";
           }
          else
           { $value = "'".str_replace("'", "\'", $value)."'";
           }
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