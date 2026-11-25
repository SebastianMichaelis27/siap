<?php

 include("../bjksadkhrej121lkjkjk.php");

 date_default_timezone_set('Asia/Jakarta');
 $info = getdate();
 $date = $info['mday'];
 $month = $info['mon'];
 $year = $info['year'];
 $hour = $info['hours'];
 $min = $info['minutes'];
 $sec = $info['seconds'];
 $now = $year."-".str_pad($month,2,"0",STR_PAD_LEFT)."-".str_pad($date,2,"0",STR_PAD_LEFT)." ".str_pad($hour,2,"0",STR_PAD_LEFT).":".str_pad($min,2,"0",STR_PAD_LEFT).":".str_pad($sec,2,"0",STR_PAD_LEFT);

 $is_commit = 1;
 mysqli_autocommit($koneksi, FALSE);

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
    $data['kode'] = "INV";
    $data['tahun'] = $tahun;
    $data['updated_at'] = $now;
    $data['updated_by'] = $username;
  }

 $id = $_POST['id'] ?? null;

 $execute = $koneksi->prepare("select * from penjualan where id = ?");
 $execute->bind_param("i", $id);
 $execute->execute();
 $result = $execute->get_result();
 $penjualanOld = $result->fetch_assoc();

 $execute = $koneksi->prepare("select * from penjualan_pembayaran where penjualan_id = ?");
 $execute->bind_param("i", $id);
 $execute->execute();
 $result = $execute->get_result();
 $pembayaranOld = $result->fetch_all(MYSQLI_ASSOC);

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
        { if($field == "no_telp_customer" || $field == "no_wa_customer" || $field == "email_customer")
           { $value = "'".str_replace("'", "\'", json_encode($value))."'";
           }
          else if($field == "detail" || $field == "termin")
           { $value = "null";
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
     {
       //termin---------------------------------------------------------------------------------------------------------------
       $execute2 = $koneksi->prepare("update penjualan_termin set nominal = null where penjualan_id = ?");
       $execute2->bind_param("i", $id);
       if(!$execute2->execute())
        { $is_commit = 0;
        }
       $data['termin'] = array_orderby($data['termin'], 'tanggal', SORT_ASC);
       for($i=0; $i<count($data['termin']); $i++)
        { $execute2 = $koneksi->prepare("select * from penjualan_termin where penjualan_id = ? and tanggal = ?");
          $execute2->bind_param("is", $id, $data['termin'][$i]['tanggal']);
          $execute2->execute();
          $result2 = $execute2->get_result();
          $dataTermin = $result2->fetch_assoc();
          if(isset($dataTermin['id']) && $dataTermin['id'] !== "")
           { $execute3 = $koneksi->prepare("update penjualan_termin set nominal = ? where id = ?");
             $execute3->bind_param("ii", $data['termin'][$i]['nominal'], $dataTermin['id']);
             if(!$execute3->execute())
              { $is_commit = 0;
              }
           }
          else
           { $execute3 = $koneksi->prepare("insert into penjualan_termin(penjualan_id, tanggal, nominal) values(?, ?, ?)");
             $execute3->bind_param("isi", $id, $data['termin'][$i]['tanggal'], $data['termin'][$i]['nominal']);
             if(!$execute3->execute())
              { $is_commit = 0;
              }
           }
        }
       $execute2 = $koneksi->prepare("delete from penjualan_termin where nominal is null and penjualan_id = ?");
       $execute2->bind_param("i", $id);
       if(!$execute2->execute())
        { $is_commit = 0;
        }
       $is_commit = setDetail($koneksi, $is_commit, "penjualan", "penjualan_termin", $id);
       //termin---------------------------------------------------------------------------------------------------------------

       //update dibayar pada tabel penjualan_termin---------------------------------------------------------------------------
       $execute2 = $koneksi->prepare("update penjualan_termin set dibayar = null where penjualan_id = ?");
       $execute2->bind_param("i", $id);
       if(!$execute2->execute())
        { $is_commit = 0;
        }

       $execute2 = $koneksi->prepare("select * from penjualan_termin where penjualan_id = ? order by tanggal asc, id asc");
       $execute2->bind_param("i", $id);
       $execute2->execute();
       $result2 = $execute2->get_result();
       $dataPenjualanTermin = $result2->fetch_all(MYSQLI_ASSOC);

       $execute2 = $koneksi->prepare("select ifnull(dibayar, 0) as dibayar from penjualan where id = ?");
       $execute2->bind_param("i", $id);
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

       //simpan penjualan_pembayaran
       if(isset($_POST['jenis_pembayaran']) && $_POST['jenis_pembayaran'] == "Lunas" && count($pembayaranOld) < 1)
        { $penjualan_pembayaran_id = null;
          $metode_pembayaran_id = $_POST['metode_pembayaran_id'] ?? null;
          $execute2 = $koneksi->prepare("insert into penjualan_pembayaran(penjualan_id, tanggal, nominal, metode_pembayaran_id, created_at, created_by) values(?, ?, ?, ?, ?, ?)");
          $execute2->bind_param("isiiss", $id, $data['tanggal'], $data['total'], $metode_pembayaran_id, $now, $username);
          if($execute2->execute())
           { $penjualan_pembayaran_id = mysqli_insert_id($koneksi);
           }
          else
           { $is_commit = 0;
           }
          $execute2 = $koneksi->prepare("update penjualan set dibayar = (select sum(ifnull(nominal, 0)) from penjualan_pembayaran where penjualan_id = ?) where id = ?");
          $execute2->bind_param("ii", $id, $id);
          if(!$execute2->execute())
           { $is_commit = 0;
           }
          $execute2 = $koneksi->prepare("insert into log_penjualan_pembayaran select penjualan_pembayaran.*, null, null, (select ifnull(max(no_urut), 0) + 1 from log_penjualan_pembayaran where id = ?) from penjualan_pembayaran where id = ?");
          $execute2->bind_param("ii", $penjualan_pembayaran_id, $penjualan_pembayaran_id);
          if(!$execute2->execute())
           { $is_commit = 0;
           }
        }

       //update jumlah_transaksi pada tabel customer--------------------------------------------------------------------------
       $execute2 = $koneksi->prepare("update customer set jumlah_transaksi = (select count(*) from penjualan where customer_id = ?) where id = ?");
       $execute2->bind_param("ii", $data['customer_id'], $data['customer_id']);
       if(!$execute2->execute())
        { $is_commit = 0;
        }
       if(isset($penjualanOld['customer_id']) && $penjualanOld['customer_id'] !== "")
        { $execute2 = $koneksi->prepare("update customer set jumlah_transaksi = (select count(*) from penjualan where customer_id = ?) where id = ?");
          $execute2->bind_param("ii", $penjualanOld['customer_id'], $penjualanOld['customer_id']);
          if(!$execute2->execute())
           { $is_commit = 0;
           }
        }
       //update jumlah_transaksi pada tabel customer--------------------------------------------------------------------------

       //set 0 data jumlah agar nanti dihapus bila nilainya tetap 0
       $queryUpdate = "update ".$_POST['Nama_Tabel']."_detail set jumlah = 0 where penjualan_id = '".intval($id)."'";
       $executeUpdate = mysqli_query($koneksi, $queryUpdate);
       if(!$executeUpdate)
        { $is_commit = 0;
        }
       $queryUpdate = "update penjualan_detail_ditandai set jumlah = 0 where penjualan_detail_id in (select id from penjualan_detail where penjualan_id = '".intval($id)."')";
       $executeUpdate = mysqli_query($koneksi, $queryUpdate);
       if(!$executeUpdate)
        { $is_commit = 0;
        }

       //Update jumlah_penjualan pada tabel pesanan
       $query1 = "select id from pesanan where id in (select pesanan_id from pesanan_detail where id in (select pesanan_detail_id from penjualan_detail where penjualan_id = '".intval($id)."'))";
       $execute1 = mysqli_query($koneksi, $query1);
       while($row1 = mysqli_fetch_array($execute1))
        { $query2 = "update pesanan set jumlah_penjualan = (select ifnull(sum(ifnull(jumlah, 0)), 0) from penjualan_detail where pesanan_detail_id in (select id from pesanan_detail where pesanan_id = '".intval($row1['id'])."')) where id = '".intval($row1['id'])."'";
          $execute2 = mysqli_query($koneksi, $query2);
          if(!$execute2)
           { $is_commit = 0;
           }
        }
       //update jumlah_penjualan pada tabel pesanan_detail
       $query1 = "select pesanan_detail_id from penjualan_detail where penjualan_id = '".intval($id)."'";
       $execute1 = mysqli_query($koneksi, $query1);
       while($row1 = mysqli_fetch_array($execute1))
        { $query2 = "update pesanan_detail set jumlah_penjualan = (select ifnull(sum(ifnull(jumlah, 0)), 0) from penjualan_detail where pesanan_detail_id = '".intval($row1['pesanan_detail_id'])."') where id = '".$row1['pesanan_detail_id']."'";
          $execute2 = mysqli_query($koneksi, $query2);
          if(!$execute2)
           { $is_commit = 0;
           }
        }
       //update detail pada tabel pesanan
       $query1 = "select id from pesanan where id in (select pesanan_id from pesanan_detail where id in (select pesanan_detail_id from penjualan_detail where penjualan_id = '".intval($id)."'))";
       $execute1 = mysqli_query($koneksi, $query1);
       while($row1 = mysqli_fetch_array($execute1))
        { $is_commit = setDetail($koneksi, $is_commit, "pesanan", "pesanan_detail", $row1['id']);
        }

       foreach($data['detail'] as $key => $detail)
        { $fieldInsert = "";
          $valueInsert = "";
          $sqlUpdate = "";
          if(strval($detail['id']) == "")
           { foreach($detail as $field => $value)
              { if(isset($value) && $value !== "" && $field !== "ditandai")
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
             $fieldInsert .= ", penjualan_id";
             $valueInsert .= ", ".$id;
             $queryInsert = "insert into ".$_POST['Nama_Tabel']."_detail(".$fieldInsert.") select ".$valueInsert;
             $executeInsert = mysqli_query($koneksi, $queryInsert);
             if($executeInsert)
              { $is_commit = insertUpdateDeletePenjualanDetailDitandai($koneksi, $is_commit, mysqli_insert_id($koneksi), $detail['ditandai']);
              }
             else
              { $is_commit = 0;
              }
           }
          else
           { foreach($detail as $field => $value)
              { if(isset($value) && $value !== "" && $field !== "ditandai")
                 { $value = "'".str_replace("'", "\'", $value)."'";
                 }
                else
                 { $value = "null";
                 }
                if($sqlUpdate !== "")
                 { $sqlUpdate .= ", ";
                 }
                $sqlUpdate .= " ".$field." = ".$value;
              }
             $queryUpdate = "update ".$_POST['Nama_Tabel']."_detail set ".$sqlUpdate." where id  = '".$detail['id']."'";
             $executeUpdate = mysqli_query($koneksi, $queryUpdate);
             if($executeUpdate)
              { $is_commit = insertUpdateDeletePenjualanDetailDitandai($koneksi, $is_commit, intval($detail['id']), $detail['ditandai']);
              }
             else
              { $is_commit = 0;
              }
           }
        }
       $queryDelete = "delete from ".$_POST['Nama_Tabel']."_detail where ifnull(jumlah, 0) = 0 and penjualan_id = '".intval($id)."'";
       $executeDelete = mysqli_query($koneksi, $queryDelete);
       if(!$executeDelete)
        { $is_commit = 0;
        }
       $is_commit = setDetail($koneksi, $is_commit, $_POST['Nama_Tabel'], $_POST['Nama_Tabel']."_detail", $id);

       //Update jumlah_penjualan pada tabel pesanan
       $query1 = "select id from pesanan where id in (select pesanan_id from pesanan_detail where id in (select pesanan_detail_id from penjualan_detail where penjualan_id = '".intval($id)."'))";
       $execute1 = mysqli_query($koneksi, $query1);
       while($row1 = mysqli_fetch_array($execute1))
        { $query2 = "update pesanan set jumlah_penjualan = (select ifnull(sum(ifnull(jumlah, 0)), 0) from penjualan_detail where pesanan_detail_id in (select id from pesanan_detail where pesanan_id = '".intval($row1['id'])."')) where id = '".intval($row1['id'])."'";
          $execute2 = mysqli_query($koneksi, $query2);
          if(!$execute2)
           { $is_commit = 0;
           }
        }
       //update jumlah_penjualan pada tabel pesanan_detail
       $query1 = "select pesanan_detail_id from penjualan_detail where penjualan_id = '".intval($id)."'";
       $execute1 = mysqli_query($koneksi, $query1);
       while($row1 = mysqli_fetch_array($execute1))
        { $query2 = "update pesanan_detail set jumlah_penjualan = (select ifnull(sum(ifnull(jumlah, 0)), 0) from penjualan_detail where pesanan_detail_id = '".intval($row1['pesanan_detail_id'])."') where id = '".$row1['pesanan_detail_id']."'";
          $execute2 = mysqli_query($koneksi, $query2);
          if(!$execute2)
           { $is_commit = 0;
           }
        }
       //update detail pada tabel pesanan
       $query1 = "select id from pesanan where id in (select pesanan_id from pesanan_detail where id in (select pesanan_detail_id from penjualan_detail where penjualan_id = '".intval($id)."'))";
       $execute1 = mysqli_query($koneksi, $query1);
       while($row1 = mysqli_fetch_array($execute1))
        { $is_commit = setDetail($koneksi, $is_commit, "pesanan", "pesanan_detail", $row1['id']);
        }

       //update data customer berdasarkan data transaksi penjualan terakhir
       $query2 = "update customer left join (select * from penjualan where id = '".$id."') as penjualan on customer.id = penjualan.customer_id set customer.nama = penjualan.nama_customer, customer.alamat = penjualan.alamat_customer, customer.no_telp = replace(penjualan.no_telp_customer, '_customer', ''), customer.no_wa = replace(penjualan.no_wa_customer, '_customer', ''), customer.email = replace(penjualan.email_customer, '_customer', '') where customer.id in (select customer_id from penjualan where id = '".$id."')";
       $execute2 = mysqli_query($koneksi, $query2);
       if(!$execute2)
        { $is_commit = 0;
        }

       //set terjual pada tabel barang_masuk_detail
       $query2 = "select id from barang_masuk_detail where id in (select barang_masuk_detail_id from penjualan_detail_ditandai where penjualan_detail_id in (select id from penjualan_detail where penjualan_id = '".$id."'))";
       $execute2 = mysqli_query($koneksi, $query2);
       while($row2 = mysqli_fetch_array($execute2))
        { $query3 = "update barang_masuk_detail set terjual = (select sum(ifnull(jumlah, 0)) from penjualan_detail_ditandai where barang_masuk_detail_id = '".$row2['id']."') where id = '".$row2['id']."'";
          $execute3 = mysqli_query($koneksi, $query3);
          if(!$execute3)
           { $is_commit = 0;
           }
        }
       //set detail pada tabel barang_masuk
       $query2 = "select id from barang_masuk where id in (select barang_masuk_id from barang_masuk_detail where id in (select barang_masuk_detail_id from penjualan_detail_ditandai where penjualan_detail_id in (select id from penjualan_detail where penjualan_id = '".$id."')))";
       $execute2 = mysqli_query($koneksi, $query2);
       while($row2 = mysqli_fetch_array($execute2))
        { $is_commit = setDetail($koneksi, $is_commit, "barang_masuk", "barang_masuk_detail", $row2['id']);
        }
       //cek jumlah terjual tidak melebihi jumlah barang masuk
       $query2 = "select barang.kode, barang.nama, barang.merek, barang.model, barang.tipe, barang.jenis, satuan.satuan from barang_masuk_detail left join pembelian_detail on barang_masuk_detail.pembelian_detail_id = pembelian_detail.id left join barang on pembelian_detail.barang_id = barang.id left join satuan on barang.satuan_id = satuan.id where ifnull(barang_masuk_detail.terjual, 0) > ifnull(barang_masuk_detail.jumlah, 0) and barang_masuk_detail.id in (select barang_masuk_detail_id from penjualan_detail_ditandai where penjualan_detail_id in (select id from penjualan_detail where penjualan_id = '".$id."'))";
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
          if(isset($row2['jenis']) && $row2['jenis'] !== "")
           { $nama_barang .= " ".$row2['jenis'];
           }
          if(isset($row2['satuan']) && $row2['satuan'] !== "")
           { $nama_barang .= " (".$row2['satuan'].")";
           }
          echo "\nBarang ".$nama_barang." ditandai melebihi stok yang tersedia!\n";
        }

       $query2 = "select barang.kode, barang.nama, barang.merek, barang.model, barang.tipe, barang.jenis, satuan.satuan from penjualan_detail left join barang on penjualan_detail.barang_id = barang.id left join satuan on barang.satuan_id = satuan.id where ifnull(penjualan_detail.jumlah_ditandai, 0) > ifnull(penjualan_detail.jumlah, 0)";
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
          if(isset($row2['jenis']) && $row2['jenis'] !== "")
           { $nama_barang .= " ".$row2['jenis'];
           }
          if(isset($row2['satuan']) && $row2['satuan'] !== "")
           { $nama_barang .= " (".$row2['satuan'].")";
           }
          echo "\nBarang ".$nama_barang." ditandai melebihi jumlah barang yang dijual!\n";
        }

       //cek verifikasi harga--------------------------------------------------------------------------------------------
       $diskon_yang_diizinkan = 0;
       $query2 = "select ifnull(sum(ifnull(diskon, 0)), 0) as diskon from pesanan where id in (select pesanan_id from pesanan_detail where id in (select pesanan_detail_id from penjualan_detail where penjualan_id = '".intval($id)."'))";
       $execute2 = mysqli_query($koneksi, $query2);
       while($row2 = mysqli_fetch_array($execute2))
        { $diskon_yang_diizinkan = $row2['diskon'] * 1;
        }

       $perlu_dikonfirmasi = 0;
       if($data['diskon'] * 1 > $diskon_yang_diizinkan)
        { $perlu_dikonfirmasi = 1;
        }

       $jenis_customer_id = "";
       $query2 = "select jenis_customer_id from customer where id = ".intval($data['customer_id']);
       $execute2 = mysqli_query($koneksi, $query2);
       while($row2 = mysqli_fetch_array($execute2))
        { $jenis_customer_id = $row2['jenis_customer_id'];
        }
       $query2 = "select * from penjualan_detail where penjualan_id = '".$id."'";
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

          if(isset($row2['pesanan_detail_id']) && $row2['pesanan_detail_id'] !== "")
           { //cek status approval pesanan
             $query3 = "select approved_at from pesanan where id = (select pesanan_id from pesanan_detail where id = '".intval($row2['pesanan_detail_id'])."')";
             $execute3 = mysqli_query($koneksi, $query3);
             $result3 = mysqli_fetch_assoc($execute3);
             if(isset($result3['approved_at']) && $result3['approved_at'] !== "")
              { $query4 = "select * from pesanan_detail where id = '".intval($row2['pesanan_detail_id'])."'";
                $execute4 = mysqli_query($koneksi, $query4);
                $result4 = mysqli_fetch_assoc($execute4);
                $harga_jual_minimal_approved = ($result4['harga_sebelum_ppn'] * $result4['jumlah']) - $result4['diskon_item'] - $result4['diskon_faktur'];
                if($harga_jual_minimal_approved < $harga_jual_minimal)
                 { $harga_jual_minimal = $harga_jual_minimal_approved;
                 }
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
           { $query4 = "update penjualan_detail set approved_by = null, approved_at = null, approved_type = null, rejected_at = null, rejected_by = null where id = '".$row2['id']."'";
             $execute4 = mysqli_query($koneksi, $query4);
             if(!$execute4)
              { $is_commit = 0;
              }
             $perlu_dikonfirmasi = 1;
           }
          else
           { $query4 = "update penjualan_detail set approved_by = '".$username."', approved_at = '".$now."', approved_type = 'auto', rejected_at = null, rejected_by = null where id = '".$row2['id']."'";
             $execute4 = mysqli_query($koneksi, $query4);
             if(!$execute4)
              { $is_commit = 0;
              }
           }
           
        }
       if($perlu_dikonfirmasi == 1)
        { $query2 = "update penjualan set approved_at = null, approved_by = null, approved_type = null, rejected_at = null, rejected_by = null where id = ".intval($id);
          $execute2 = mysqli_query($koneksi, $query2);
          if(!$execute2)
           { $is_commit = 0;
           }
        }
       else
        { $query2 = "update penjualan set approved_at = '".$now."', approved_by = '".$username."', approved_type = 'auto', rejected_at = null, rejected_by = null where id = ".intval($id);
          $execute2 = mysqli_query($koneksi, $query2);
          if(!$execute2)
           { $is_commit = 0;
           }
        }
       //cek verifikasi harga--------------------------------------------------------------------------------------------

       $query2 = "insert into log_".$_POST['Nama_Tabel']." select ".$_POST['Nama_Tabel'].".*, null, null, (select ifnull(max(no_urut), 0) + 1 from log_".$_POST['Nama_Tabel']." where id = '".$id."') from ".$_POST['Nama_Tabel']." where id = '".$id."'";
       $execute2 = mysqli_query($koneksi, $query2);
       if(!$execute2)
        { $is_commit = 0;
        }
     }
    else
     { $is_commit = 0;
       echo "Gagal! Koneksi terputus";
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