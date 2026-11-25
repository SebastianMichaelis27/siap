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
    $data['created_at'] = $now;
    $data['created_by'] = $username;
  }

 $detail = array();
 if(isset($_POST['detail']) && $_POST['detail'] !== "")
  { $detail = json_decode($_POST['detail'], true);
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
     { $id = mysqli_insert_id($koneksi);

       //inisialisasi detail yang akan dihapus bila tidak digunakan lagi
       $query2 = "update barang_masuk_detail set jumlah = 0 where barang_masuk_id = '".$id."'";
       $execute2 = mysqli_query($koneksi, $query2);
       if(!$execute2)
        { $is_commit = 0;
        }

       for($i=0; $i<count($detail); $i++)
        { $query2 = "select * from barang_masuk_detail where barang_masuk_id = '".$id."' and pembelian_detail_id = '".$detail[$i]['pembelian_detail_id']."' and rak_id = '".$detail[$i]['rak_id']."'";
          $execute2 = mysqli_query($koneksi, $query2);
          if(mysqli_num_rows($execute2) > 0)
           { while($row2 = mysqli_fetch_array($execute2))
              { $query3 = "update barang_masuk_detail set jumlah = '".$detail[$i]['jumlah']."' where barang_masuk_id = '".$id."' and pembelian_detail_id = '".$detail[$i]['pembelian_detail_id']."' and rak_id = '".$detail[$i]['rak_id']."'";
                $execute3 = mysqli_query($koneksi, $query3);
                if(!$execute3)
                 { $is_commit = 0;
                 }
              }
           }
          else
           { $query3 = "insert into barang_masuk_detail(barang_masuk_id, pembelian_detail_id, rak_id, jumlah) values('".$id."', '".$detail[$i]['pembelian_detail_id']."', '".$detail[$i]['rak_id']."', '".$detail[$i]['jumlah']."')";
             $execute3 = mysqli_query($koneksi, $query3);
             if(!$execute3)
              { $is_commit = 0;
              }
           }

          //update masuk_gudang pada tabel pembelian_detail
          $query2 = "update pembelian_detail set masuk_gudang = (select ifnull(sum(ifnull(jumlah, 0)), 0) from barang_masuk_detail where pembelian_detail_id = '".$detail[$i]['pembelian_detail_id']."') where id = '".$detail[$i]['pembelian_detail_id']."'";
          $execute2 = mysqli_query($koneksi, $query2);
          if(!$execute2)
           { $is_commit = 0;
           }

          //validasi apakah jumlah barang masuk gudang tidak melebihi jumlah barang yang dibeli
          $query2 = "select barang.kode, barang.nama, barang.merek, barang.model, barang.tipe from pembelian_detail left join barang on pembelian_detail.barang_id = barang.id where pembelian_detail.id = '".$detail[$i]['pembelian_detail_id']."' and ifnull(pembelian_detail.jumlah, 0) < ifnull(pembelian_detail.masuk_gudang, 0)";
          $execute2 = mysqli_query($koneksi, $query2);
          if(mysqli_num_rows($execute2) > 0)
           { while($row2 = mysqli_fetch_array($execute2))
              { $nama_barang = $row2['kode']." - ".$row2['nama'];
                if(isset($row2['merek']) && $row2['merek'] !== "")
                 { $nama_barang .= " ".$row2['merek'];
                 }
                if(isset($row2['model']) && $row2['model'] !== "")
                 { $nama_barang .= " ".$row2['model'];
                 }
                if(isset($row2['tipe']) && $row2['tipe'] !== "")
                 { $nama_barang .= " ".$row2['tipe'];
                 }
                echo "Barang ".$nama_barang." melebihi batas stok yang tersedia!\n";
              }
             $is_commit = 0;
           }
        }

       $query2 = "select pembelian_id from pembelian_detail where id in (select pembelian_detail_id from barang_masuk_detail where barang_masuk_id = '".$id."') group by pembelian_id";
       $execute2 = mysqli_query($koneksi, $query2);
       while($row2 = mysqli_fetch_array($execute2))
        { //set detail pada tabel pembelian
          $is_commit = setDetail($koneksi, $is_commit, "pembelian", "pembelian_detail", $row2['pembelian_id']);
        }

       //hapus detail yang sudah tidak digunakan lagi
       $query2 = "delete from barang_masuk_detail where ifnull(jumlah, 0) = 0 and barang_masuk_id = '".$id."'";
       $execute2 = mysqli_query($koneksi, $query2);
       if(!$execute2)
        { $is_commit = 0;
        }

       //set detail
       $is_commit = setDetail($koneksi, $is_commit, $_POST['Nama_Tabel'], $_POST['Nama_Tabel']."_detail", $id);

       //simpan log
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