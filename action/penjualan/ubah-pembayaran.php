<?php

 include("../bjksadkhrej121lkjkjk.php");

 $is_commit = 1;
 mysqli_autocommit($koneksi, FALSE);

 date_default_timezone_set('Asia/Jakarta');
 $info = getdate();
 $date = $info['mday'];
 $month = $info['mon'];
 $year = $info['year'];
 $hour = $info['hours'];
 $min = $info['minutes'];
 $sec = $info['seconds'];
 $now = $year."-".str_pad($month,2,"0",STR_PAD_LEFT)."-".str_pad($date,2,"0",STR_PAD_LEFT)." ".str_pad($hour,2,"0",STR_PAD_LEFT).":".str_pad($min,2,"0",STR_PAD_LEFT).":".str_pad($sec,2,"0",STR_PAD_LEFT);

 $DataTidakBolehRangkap = array();
 if(isset($_POST['DataTidakBolehRangkap']) && $_POST['DataTidakBolehRangkap'] !== "")
  { $DataTidakBolehRangkap = json_decode($_POST['DataTidakBolehRangkap'], true);
  }

 $data = array();
 if(isset($_POST['data']) && $_POST['data'] !== "")
  { $data = json_decode($_POST['data'], true);
  }
 $data['updated_by'] = $username;
 $data['updated_at'] = $now;

 $queryUpdate = "";
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
 $query = "update ".$_POST['Nama_Tabel']." set ".$queryUpdate." where id = '".intval($_POST['id'])."'";
 $execute = mysqli_query($koneksi, $query);
 if($execute)
  { $query2 = "update penjualan set dibayar = (select sum(ifnull(nominal, 0)) from penjualan_pembayaran where penjualan_id = '".$data['penjualan_id']."') where id = '".$data['penjualan_id']."'";
    $execute2 = mysqli_query($koneksi, $query2);
    if(!$execute2)
     { $is_commit = 0;
     }

    $is_commit = setDetail($koneksi, $is_commit, "penjualan", "penjualan_pembayaran", $data['penjualan_id']);

    $query2 = "insert into log_".$_POST['Nama_Tabel']." select ".$_POST['Nama_Tabel'].".*, null, null, (select ifnull(max(no_urut), 0) + 1 from log_".$_POST['Nama_Tabel']." where id = '".intval($_POST['id'])."') from ".$_POST['Nama_Tabel']." where id = '".intval($_POST['id'])."'";
    $execute2 = mysqli_query($koneksi, $query2);
    if(!$execute2)
     { $is_commit = 0;
     }
  }
 else
  { $is_commit = 0;
  }

 //update dibayar pada tabel penjualan_termin---------------------------------------------------------------------------
 $execute2 = $koneksi->prepare("update penjualan_termin set dibayar = null where penjualan_id = ?");
 $execute2->bind_param("i", $data['penjualan_id']);
 if(!$execute2->execute())
  { $is_commit = 0;
  }

 $execute2 = $koneksi->prepare("select * from penjualan_termin where penjualan_id = ? order by tanggal asc, id asc");
 $execute2->bind_param("i", $data['penjualan_id']);
 $execute2->execute();
 $result2 = $execute2->get_result();
 $dataPenjualanTermin = $result2->fetch_all(MYSQLI_ASSOC);

 $execute2 = $koneksi->prepare("select ifnull(dibayar, 0) as dibayar from penjualan where id = ?");
 $execute2->bind_param("i", $data['penjualan_id']);
 $execute2->execute();
 $result2 = $execute2->get_result();
 $dataPenjualan = $result2->fetch_assoc();
 $dibayar = $dataPenjualan['dibayar'] ?? 0;

 for($i=0; $i<count($dataPenjualanTermin); $i++)
  { if($dibayar >= $dataPenjualanTermin[$i]['nominal'])
     { $execute2 = $koneksi->prepare("update penjualan_termin set dibayar = ? where id = ?");
       $execute2->bind_param("ii", $dataPenjualanTermin[$i]['nominal'], $dataPenjualanTermin[$i]['id']);
       if(!$execute2->execute())
        { $is_commit = 0;
        }
       $dibayar -= $dataPenjualanTermin[$i]['nominal'];
     }
    else
     { $execute2 = $koneksi->prepare("update penjualan_termin set dibayar = ? where id = ?");
       $execute2->bind_param("ii", $dibayar, $dataPenjualanTermin[$i]['id']);
       if(!$execute2->execute())
        { $is_commit = 0;
        }
       $dibayar = 0;
     }
  }
 //update dibayar pada tabel penjualan_termin---------------------------------------------------------------------------

 if($is_commit == 1)
  { mysqli_commit($koneksi);
    echo "1";
  }
 else
  { mysqli_rollback($koneksi);
  }

?>