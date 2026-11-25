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
    $data['kode'] = "PO";
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
        { if($field == "no_telp_supplier" || $field == "no_wa_supplier" || $field == "email_supplier")
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
    $queryValue .= ", (select ifnull(max(ifnull(nomor, 0)), 0) + 1 as nomor from ".$_POST['Nama_Tabel']." where tanggal = '".date('Y-m-d', strtotime($data['tanggal']))."' and kode = '".str_replace("'", "\'", $data['kode'])."')";
    $query = "insert into ".$_POST['Nama_Tabel']."(".$queryField.") select ".$queryValue;
    $execute = mysqli_query($koneksi, $query);
    if($execute)
     { $id = mysqli_insert_id($koneksi);

       $queryDelete = "update ".$_POST['Nama_Tabel']."_detail set jumlah = 0 where pembelian_id = '".intval($id)."'";
       $executeDelete = mysqli_query($koneksi, $queryDelete);
       if(!$executeDelete)
        { $is_commit = 0;
        }
       foreach($data['detail'] as $key => $detail)
        { $fieldInsert = "";
          $valueInsert = "";
          $sqlUpdate = "";
          if(strval($detail['id']) == "")
           { foreach($detail as $field => $value)
              { if(isset($value) && $value !== "")
                 { $value = "'".str_replace("'", "\'", $value)."'";
                 }
                else
                 { $value = "null";
                 }
                if($fieldInsert !== "")
                 { $fieldInsert .= ", ";
                   $valueInsert .= ", ";
                 }
                $fieldInsert .= $field;
                $valueInsert .= $value;
              }
             $fieldInsert .= ", pembelian_id";
             $valueInsert .= ", ".$id;
             $queryInsert = "insert into ".$_POST['Nama_Tabel']."_detail(".$fieldInsert.") select ".$valueInsert;
             $executeInsert = mysqli_query($koneksi, $queryInsert);
             if(!$executeInsert)
              { $is_commit = 0;
              }
           }
          else
           { foreach($detail as $field => $value)
              { if(isset($value) && $value !== "")
                 { $value = "'".str_replace("'", "\'", $value)."'";
                 }
                else
                 { $value = "null";
                 }
                if($sqlUpdate !== "")
                 { $fieldUpdate .= ", ";
                 }
                $sqlUpdate .= " ".$field." = ".$value;
              }
             $queryUpdate = "update ".$_POST['Nama_Tabel']."_detail set ".$sqlUpdate." where id  = '".$detail['id']."'";
             $executeUpdate = mysqli_query($koneksi, $queryUpdate);
             if(!$executeUpdate)
              { $is_commit = 0;
              }
           }
        }
       $queryDelete = "delete from ".$_POST['Nama_Tabel']."_detail where ifnull(jumlah, 0) = 0 and pembelian_id = '".intval($id)."'";
       $executeDelete = mysqli_query($koneksi, $queryDelete);
       if(!$executeDelete)
        { $is_commit = 0;
        }
       $is_commit = setDetail($koneksi, $is_commit, $_POST['Nama_Tabel'], $_POST['Nama_Tabel']."_detail", $id);

       //update data supplier berdasarkan data transaksi pembelian terakhir
       $query2 = "update supplier left join (select * from pembelian where id = '".$id."') as pembelian on supplier.id = pembelian.supplier_id set supplier.nama = pembelian.nama_supplier, supplier.alamat = pembelian.alamat_supplier, supplier.no_telp = replace(pembelian.no_telp_supplier, '_supplier', ''), supplier.no_wa = replace(pembelian.no_wa_supplier, '_supplier', ''), supplier.email = replace(pembelian.email_supplier, '_supplier', '') where supplier.id in (select supplier_id from pembelian where id = '".$id."')";
       $execute2 = mysqli_query($koneksi, $query2);
       if(!$execute2)
        { $is_commit = 0;
        }

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