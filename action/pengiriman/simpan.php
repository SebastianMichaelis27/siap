<?php

 include("../bjksadkhrej121lkjkjk.php");
 include("function.php");

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
    $data['kode'] = "DO";
    $data['tahun'] = $tahun;
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

 //JAGAN LUPA BUAT KONDISI NOMOR SO BERGANTI

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
    $queryField .= ", nomor";
    $queryValue .= ", (select ifnull(max(ifnull(nomor, 0)), 0) + 1 as nomor from ".$_POST['Nama_Tabel']." where tanggal = '".$data['tanggal']."' and kode = '".str_replace("'", "\'", $data['kode'])."')";
    $query = "insert into ".$_POST['Nama_Tabel']."(".$queryField.") select ".$queryValue;
    $execute = mysqli_query($koneksi, $query);
    if($execute)
     { $pengiriman_id = mysqli_insert_id($koneksi);

       //Set Ditandai--------------------------------------------------------------------------------------------------------------------------

       //update jumlah = 0 pada tabel penjualan_detail_ditandai
       $query2 = "update penjualan_detail_ditandai set jumlah = 0 where id in (select penjualan_detail_ditandai_id from pengiriman_detail where pengiriman_id = '".$pengiriman_id."')";
       $execute2 = mysqli_query($koneksi, $query2);
       if(!$execute2)
        { $is_commit = 0;
        }

       //update jumlah = 0 pada tabel pengiriman_detail
       $query2 = "update pengiriman_detail set jumlah = 0 where pengiriman_id = '".$pengiriman_id."'";
       $execute2 = mysqli_query($koneksi, $query2);
       if(!$execute2)
        { $is_commit = 0;
        }

       $is_commit = paketUpdate($koneksi, $pengiriman_id, $is_commit);

       //insert/update penjualan_detail_ditandai berdasarkan data terbaru barang yang ditandai
       foreach($detail as $detail_index => $detail_value)
        { $query2 = "select * from penjualan_detail_ditandai where penjualan_detail_id = '".$detail_value['penjualan_detail_id']."' and barang_masuk_detail_id = '".$detail_value['barang_masuk_detail_id']."'";
          $execute2 = mysqli_query($koneksi, $query2);
          if(mysqli_num_rows($execute2) > 0)
           { $query3 = "update penjualan_detail_ditandai set jumlah = '".$detail_value['jumlah']."' where penjualan_detail_id = '".$detail_value['penjualan_detail_id']."' and barang_masuk_detail_id = '".$detail_value['barang_masuk_detail_id']."'";
             $execute3 = mysqli_query($koneksi, $query3);
             if(!$execute3)
              { $is_commit = 0;
              }
           }
          else
           { $query3 = "insert into penjualan_detail_ditandai(penjualan_detail_id, barang_masuk_detail_id, jumlah) values('".$detail_value['penjualan_detail_id']."', '".$detail_value['barang_masuk_detail_id']."', '".$detail_value['jumlah']."')";
             $execute3 = mysqli_query($koneksi, $query3);
             if(!$execute3)
              { $is_commit = 0;
              }
           }
        }

       //alasanku tidak men set detail disini karna bisa jadi, masih ada perubahan dari pengiriman_detail
       //jadi set detail nya di bawah saja, setelah semua perubahan selesai terjadi

       //Set Ditandai--------------------------------------------------------------------------------------------------------------------------


       //Set Pengiriman------------------------------------------------------------------------------------------------------------------------

       $detail = array_filter($detail, function($var) {
        return ($var['add_kirim'] * 1 > 0);
       });
       foreach($detail as $key => $value)
        { $query2 = "select id from penjualan_detail_ditandai where penjualan_detail_id = '".$value['penjualan_detail_id']."' and barang_masuk_detail_id = '".$value['barang_masuk_detail_id']."'";
          $execute2 = mysqli_query($koneksi, $query2);
          while($row2 = mysqli_fetch_array($execute2))
           { $penjualan_detail_ditandai_id = $row2['id'];

             //insert/update pengiriman_detail
             $query3 = "select * from pengiriman_detail where pengiriman_id = '".$pengiriman_id."' and penjualan_detail_ditandai_id = '".$penjualan_detail_ditandai_id."'";
             $execute3 = mysqli_query($koneksi, $query3);
             if(mysqli_num_rows($execute3) > 0)
              { $query4 = "update pengiriman_detail set jumlah = '".$value['add_kirim']."' where pengiriman_id = '".$pengiriman_id."' and penjualan_detail_ditandai_id = '".$penjualan_detail_ditandai_id."'";
                $execute4 = mysqli_query($koneksi, $query4);
                if(!$execute4)
                 { $is_commit = 0;
                 }
              }
             else
              { $query4 = "insert into pengiriman_detail(pengiriman_id, penjualan_detail_ditandai_id, jumlah) values('".$pengiriman_id."', '".$penjualan_detail_ditandai_id."', '".$value['add_kirim']."')";
                $execute4 = mysqli_query($koneksi, $query4);
                if(!$execute4)
                 { $is_commit = 0;
                 }
              }
           }
        }

       $is_commit = paketUpdate($koneksi, $pengiriman_id, $is_commit);

       //Set Pengiriman------------------------------------------------------------------------------------------------------------------------


       //Pengecekan Jumlah Kirim tidak Melebihi Jumlah Penjualan-------------------------------------------------------------------------------
       
       //cek dikirim tidak melebihi jumlah pada tabel penjualan_detail_ditandai
       $query2 = "select barang.kode, barang.nama, barang.merek, barang.model, barang.tipe, barang.jenis, satuan.satuan from penjualan_detail_ditandai left join penjualan_detail on penjualan_detail_ditandai.penjualan_detail_id = penjualan_detail.id left join barang on penjualan_detail.barang_id = barang.id left join satuan on barang.satuan_id = satuan.id where penjualan_detail_ditandai.id in (select penjualan_detail_ditandai_id from pengiriman_detail where pengiriman_id = '".$pengiriman_id."') and ifnull(penjualan_detail_ditandai.dikirim, 0) > ifnull(penjualan_detail_ditandai.jumlah, 0)";
       $execute2 = mysqli_query($koneksi, $query2);
       while($row2 = mysqli_fetch_array($execute2))
        { $is_commit = 0;
          $nama_barang = $row2['kode']." - ".$row2['nama'];
          if(isset($row2['merek']) && $row2['merek'] !== "")
           { $nama_barang .= " ".$row2['merek'];
           }
          if(isset($row2['model']) && $row2['model'] !== "")
           { $nama_barang .= " ".$row2['model'];
           }
          if(isset($row2['tipe']) && $row2['tipe'] !== "")
           { $nama_barang .= " ".$row2['tipe'];
           }
          if(isset($row2['satuan']) && $row2['satuan'] !== "")
           { $nama_barang .= " (".$row2['satuan'].")";
           }
          echo "\nBarang ".$nama_barang." dikirim melebihi yang ditandai!a\n";
        }

       //cek jumlah_dikirim tidak melebihi jumlah_ditandai pada tabel penjualan_detail
       $query2 = "select barang.kode, barang.nama, barang.merek, barang.model, barang.tipe, barang.jenis, satuan.satuan from penjualan_detail left join barang on penjualan_detail.barang_id = barang.id left join satuan on barang.satuan_id = satuan.id where penjualan_detail.id in (select penjualan_detail_id from penjualan_detail_ditandai where id in (select penjualan_detail_ditandai_id from pengiriman_detail where pengiriman_id = '".$pengiriman_id."')) and ifnull(penjualan_detail.jumlah_dikirim, 0) > ifnull(penjualan_detail.jumlah_ditandai, 0)";
       $execute2 = mysqli_query($koneksi, $query2);
       while($row2 = mysqli_fetch_array($execute2))
        { $is_commit = 0;
          $nama_barang = $row2['kode']." - ".$row2['nama'];
          if(isset($row2['merek']) && $row2['merek'] !== "")
           { $nama_barang .= " ".$row2['merek'];
           }
          if(isset($row2['model']) && $row2['model'] !== "")
           { $nama_barang .= " ".$row2['model'];
           }
          if(isset($row2['tipe']) && $row2['tipe'] !== "")
           { $nama_barang .= " ".$row2['tipe'];
           }
          if(isset($row2['satuan']) && $row2['satuan'] !== "")
           { $nama_barang .= " (".$row2['satuan'].")";
           }
          echo "\nBarang ".$nama_barang." dikirim melebihi yang ditandai!\n";
        }

       //cek dikirim tidak melebihi terjual pada tabel barang_masuk_detail
       $query2 = "select barang.kode, barang.nama, barang.merek, barang.model, barang.tipe, barang.jenis, satuan.satuan from barang_masuk_detail left join pembelian_detail on barang_masuk_detail.pembelian_detail_id = pembelian_detail.id left join barang on pembelian_detail.barang_id = barang.id left join satuan on barang.satuan_id = satuan.id where barang_masuk_detail.id in (select id from penjualan_detail_ditandai where id in (select penjualan_detail_ditandai_id from pengiriman_detail where pengiriman_id = '".$pengiriman_id."')) and ifnull(barang_masuk_detail.dikirim, 0) > ifnull(barang_masuk_detail.terjual, 0)";
       $execute2 = mysqli_query($koneksi, $query2);
       while($row2 = mysqli_fetch_array($execute2))
        { $is_commit = 0;
          $nama_barang = $row2['kode']." - ".$row2['nama'];
          if(isset($row2['merek']) && $row2['merek'] !== "")
           { $nama_barang .= " ".$row2['merek'];
           }
          if(isset($row2['model']) && $row2['model'] !== "")
           { $nama_barang .= " ".$row2['model'];
           }
          if(isset($row2['tipe']) && $row2['tipe'] !== "")
           { $nama_barang .= " ".$row2['tipe'];
           }
          if(isset($row2['satuan']) && $row2['satuan'] !== "")
           { $nama_barang .= " (".$row2['satuan'].")";
           }
          echo "\nBarang ".$nama_barang." dikirim melebihi yang terjual!\n";
        }

       //Pengecekan Jumlah Kirim tidak Melebihi Jumlah Penjualan-------------------------------------------------------------------------------


       //Delete Jumlah 0 & Set Detail----------------------------------------------------------------------------------------------------------

       $query2 = "select pengiriman_id as id from pengiriman_detail where pengiriman_id = '".$pengiriman_id."' group by pengiriman_id";
       $execute2 = mysqli_query($koneksi, $query2);
       $all_pengiriman = mysqli_fetch_all($execute2, MYSQLI_ASSOC);

       $query2 = "select id from penjualan_detail where id in (select penjualan_detail_id from penjualan_detail_ditandai where id in (select penjualan_detail_ditandai_id from pengiriman_detail where pengiriman_id = '".$pengiriman_id."'))";
       $execute2 = mysqli_query($koneksi, $query2);
       $all_penjualan_detail = mysqli_fetch_all($execute2, MYSQLI_ASSOC);

       $query2 = "select id from penjualan where id in (select penjualan_id from penjualan_detail where id in (select penjualan_detail_id from penjualan_detail_ditandai where id in (select penjualan_detail_ditandai_id from pengiriman_detail where pengiriman_id = '".$pengiriman_id."')))";
       $execute2 = mysqli_query($koneksi, $query2);
       $all_penjualan = mysqli_fetch_all($execute2, MYSQLI_ASSOC);
       
       //hapus data pengiriman_detail yang jumlahnya 0
       $query2 = "delete from pengiriman_detail where pengiriman_id = '".$pengiriman_id."' and ifnull(jumlah, 0) = 0";
       $execute2 = mysqli_query($koneksi, $query2);
       if(!$execute2)
        { $is_commit = 0;
        }
       //set detail pada tabel pengiriman
       foreach($all_pengiriman as $index_pengiriman => $value_pengiriman)
        { $is_commit = setDetail($koneksi, $is_commit, "pengiriman", "pengiriman_detail", $value_pengiriman['id']);
        }

       //hapus data penjualan_detail_ditandai yang jumlahnya 0
       $query2 = "delete from penjualan_detail_ditandai where id in (select penjualan_detail_ditandai_id from pengiriman_detail where pengiriman_id = '".$pengiriman_id."') and ifnull(jumlah, 0) = 0";
       $execute2 = mysqli_query($koneksi, $query2);
       if(!$execute2)
        { $is_commit = 0;
        }
       //set ditandai pada tabel penjualan_detail
       foreach($all_penjualan_detail as $index_penjualan_detail => $value_penjualan_detail)
        { $is_commit = setDetail($koneksi, $is_commit, "penjualan_detail", "penjualan_detail_ditandai", $value_penjualan_detail['id']);
        }

       //hapus data penjualan_detail yang jumlahnya 0
       $query2 = "delete from penjualan_detail where id in (select penjualan_detail_id from penjualan_detail_ditandai where id in (select penjualan_detail_ditandai_id from pengiriman_detail where pengiriman_id = '".$pengiriman_id."') and ifnull(jumlah, 0) = 0)";
       $execute2 = mysqli_query($koneksi, $query2);
       if(!$execute2)
        { $is_commit = 0;
        }
       //set detail pada tabel penjualan
       foreach($all_penjualan as $index_penjualan => $value_penjualan)
        { $is_commit = setDetail($koneksi, $is_commit, "penjualan", "penjualan_detail", $value_penjualan['id']);
        }

       //Delete Jumlah 0 & Set Detail----------------------------------------------------------------------------------------------------------

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