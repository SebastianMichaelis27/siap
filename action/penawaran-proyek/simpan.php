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

       $queryDelete = "update ".$_POST['Nama_Tabel']."_detail set jumlah = 0 where penawaran_id = '".intval($id)."'";
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
             $fieldInsert .= ", penawaran_id";
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
       $queryDelete = "delete from ".$_POST['Nama_Tabel']."_detail where ifnull(jumlah, 0) = 0 and penawaran_id = '".intval($id)."'";
       $executeDelete = mysqli_query($koneksi, $queryDelete);
       if(!$executeDelete)
        { $is_commit = 0;
        }

       //cek verifikasi harga--------------------------------------------------------------------------------------------
       $perlu_dikonfirmasi = 0;
       $jenis_customer_id = "";
       $query2 = "select jenis_customer_id from customer where id = ".intval($data['customer_id']);
       $execute2 = mysqli_query($koneksi, $query2);
       while($row2 = mysqli_fetch_array($execute2))
        { $jenis_customer_id = $row2['jenis_customer_id'];
        }
       $query2 = "select * from penawaran_detail where penawaran_id = '".$id."'";
       $execute2 = mysqli_query($koneksi, $query2);
       while($row2 = mysqli_fetch_array($execute2))
        { 
          $harga_jual_minimal = 0;
          if(isset($row2['barang_id']) && $row2['barang_id'] !== "")
           { $query3 = "select harga_jual, diskon_jenis_customer from barang where id = ".intval($row2['barang_id']);
             $execute3 = mysqli_query($koneksi, $query3);
             while($row3 = mysqli_fetch_array($execute3, MYSQLI_ASSOC))
              { $harga_jual_minimal = $row3['harga_jual'] * $row2['jumlah'];
                $diskon_jenis_customer = array();
                if(isset($row3['diskon_jenis_customer']) && $row3['diskon_jenis_customer'] !== "")
                 { $row3['diskon_jenis_customer'] = str_replace('}]"', '}]', str_replace('"[{', '[{', $row3['diskon_jenis_customer']));
                   $diskon_jenis_customer = json_decode($row3['diskon_jenis_customer'], true);
                 }
                $index = array_search($jenis_customer_id, array_column($diskon_jenis_customer, 'jenis_customer_id'));
                if(strval($index) !== "")
                 { $harga_jual_minimal -= $diskon_jenis_customer[$index]['diskon'] * $row2['jumlah'];
                 }
              }
           }
          else
           { $query3 = "select harga from jasa where id = ".intval($row2['jasa_id']);
             $execute3 = mysqli_query($koneksi, $query3);
             while($row3 = mysqli_fetch_array($execute3, MYSQLI_ASSOC))
              { $harga_jual_minimal = $row3['harga'] * $row2['jumlah'];
              }
           }

          $harga_sebelum_ppn = 0;
          if(strval($row2['harga_sebelum_ppn']) !== "")
           { $harga_sebelum_ppn = $row2['harga_sebelum_ppn'] * $row2['jumlah'];
           }
          $diskon_item = 0;
          if(strval($row2['diskon_item']) !== "")
           { $diskon_item = $row2['diskon_item'];
           }
          $diskon_faktur = 0;
          if(strval($row2['diskon_faktur']) !== "")
           { $diskon_faktur = $row2['diskon_faktur'];
           }
          $harga_jual = $harga_sebelum_ppn - $diskon_item - $diskon_faktur;

          if($harga_jual < $harga_jual_minimal)
           { $query4 = "update penawaran_detail set approved_by = null, approved_at = null, approved_type = null, rejected_at = null, rejected_by = null where id = '".$row2['id']."'";
             $execute4 = mysqli_query($koneksi, $query4);
             if(!$execute4)
              { $is_commit = 0;
              }
             $perlu_dikonfirmasi = 1;
           }
          else
           { $query4 = "update penawaran_detail set approved_by = '".$username."', approved_at = '".$now."', approved_type = 'auto', rejected_at = null, rejected_by = null where id = '".$row2['id']."'";
             $execute4 = mysqli_query($koneksi, $query4);
             if(!$execute4)
              { $is_commit = 0;
              }
           }

        }
       if($perlu_dikonfirmasi == 1)
        { $query2 = "update penawaran set approved_at = null, approved_by = null, approved_type = null, rejected_at = null, rejected_by = null where id = ".intval($id);
          $execute2 = mysqli_query($koneksi, $query2);
          if(!$execute2)
           { $is_commit = 0;
           }
        }
       else
        { $query2 = "update penawaran set approved_at = '".$now."', approved_by = '".$username."', approved_type = 'auto', rejected_at = null, rejected_by = null where id = ".intval($id);
          $execute2 = mysqli_query($koneksi, $query2);
          if(!$execute2)
           { $is_commit = 0;
           }
        }
       //cek verifikasi harga--------------------------------------------------------------------------------------------

       $is_commit = setDetail($koneksi, $is_commit, $_POST['Nama_Tabel'], $_POST['Nama_Tabel']."_detail", $id);

       //update data customer berdasarkan data transaksi penawaran terakhir
       $query2 = "update customer left join (select * from penawaran where id = '".$id."') as penawaran on customer.id = penawaran.customer_id set customer.nama = penawaran.nama_customer, customer.alamat = penawaran.alamat_customer, customer.no_telp = replace(penawaran.no_telp_customer, '_customer', ''), customer.no_wa = replace(penawaran.no_wa_customer, '_customer', ''), customer.email = replace(penawaran.email_customer, '_customer', '') where customer.id in (select customer_id from penawaran where id = '".$id."')";
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