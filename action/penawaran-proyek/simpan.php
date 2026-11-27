<?php

 include("../bjksadkhrej121lkjkjk.php");

 $now = date('Y-m-d H:i:s');

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
 $tahun = date('Y', strtotime($now));

 $DataTidakBolehRangkap = array();
 if(isset($_POST['DataTidakBolehRangkap']) && $_POST['DataTidakBolehRangkap'] !== "")
  { $DataTidakBolehRangkap = json_decode($_POST['DataTidakBolehRangkap'], true);
  }

 $data = array();
 if(isset($_POST['data']) && $_POST['data'] !== "")
  { $data = json_decode($_POST['data'], true);
    if(isset($data['tanggal']) && $data['tanggal'] !== "")
     { $tahun = date('Y', strtotime($data['tanggal']));
     }
    $data['kode'] = "02";
    $data['tahun'] = $tahun;
    $data['created_at'] = $now;
    $data['created_by'] = $username;
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
        { if($field == "no_telp_customer" || $field == "no_wa_customer" || $field == "email_customer")
           { $value = "'".str_replace("'", "\'", json_encode($value))."'";
           }
          else if($field == "detail")
           { $value = "null";
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
    $queryField .= ", nomor";
    $queryValue .= ", (select ifnull(max(ifnull(nomor, 0)), 0) + 1 as nomor from ".$_POST['Nama_Tabel']." where year(tanggal) = '".$tahun."')";
    $query = "insert into ".$_POST['Nama_Tabel']."(".$queryField.") select ".$queryValue;
    $execute = mysqli_query($koneksi, $query);
    if($execute)
     { $id = mysqli_insert_id($koneksi);

       //IUD Detail----------------------------------------------------------------------------------------------------------------
       $execute2 = $koneksi->prepare("update penawaran_proyek_detail set jumlah = null where penawaran_proyek_id = ?");
       $execute2->bind_param("i", $id);
       if(!$execute2->execute())
        { $is_commit = 0;
        }
       for($i=0; $i<count($data['detail']); $i++)
        { $execute2 = $koneksi->prepare("select * from penawaran_proyek_detail where id = ?");
          $execute2->bind_param("i", $data['detail'][$i]['id']);
          $execute2->execute();
          $result2 = $execute2->get_result();
          if($result2->num_rows > 0)
           { $execute3 = $koneksi->prepare("update penawaran_proyek_detail set penawaran_proyek_id = ?, no_kelompok = ?, nama_kelompok = ?, uraian = ?, jumlah = ?, satuan = ?, harga = ?, total = ? where id = ?");
             $execute3->bind_param("iissisiii", $id, $data['detail'][$i]['nomor_kelompok'], $data['detail'][$i]['nama_kelompok'], $data['detail'][$i]['uraian'], $data['detail'][$i]['jumlah'], $data['detail'][$i]['satuan'], $data['detail'][$i]['harga'], $data['detail'][$i]['total'], $data['detail'][$i]['id']);
             if(!$execute3->execute())
              { $is_commit = 0;
              }
           }
          else
           { $execute3 = $koneksi->prepare("insert into penawaran_proyek_detail(penawaran_proyek_id, no_kelompok, nama_kelompok, uraian, jumlah, satuan, harga, total) values(?, ?, ?, ?, ?, ?, ?, ?)");
             $execute3->bind_param("iissisii", $id, $data['detail'][$i]['nomor_kelompok'], $data['detail'][$i]['nama_kelompok'], $data['detail'][$i]['uraian'], $data['detail'][$i]['jumlah'], $data['detail'][$i]['satuan'], $data['detail'][$i]['harga'], $data['detail'][$i]['total']);
             if(!$execute3->execute())
              { $is_commit = 0;
              }
           }
        }
       $execute2 = $koneksi->prepare("delete from penawaran_proyek_detail where jumlah is null and penawaran_proyek_id = ?");
       $execute2->bind_param("i", $id);
       if(!$execute2->execute())
        { $is_commit = 0;
        }
       $is_commit = setDetail($koneksi, $is_commit, "penawaran_proyek", "penawaran_proyek_detail", $id);
       //IUD Detail----------------------------------------------------------------------------------------------------------------

       $query2 = "insert into log_".$_POST['Nama_Tabel']." select ".$_POST['Nama_Tabel'].".*, null, null, (select ifnull(max(no_urut), 0) + 1 from log_".$_POST['Nama_Tabel']." where id = '".$id."') from ".$_POST['Nama_Tabel']." where id = '".$id."'";
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