<?php

 include("../bjksadkhrej121lkjkjk.php");

 $now = date('Y-m-d H:i:s');

 $queryFilter = " where ifnull(approved_at, '') <> '' and date_add(tanggal, interval ifnull(batas_waktu, 0) day) >= '".date('Y-m-d')."' and cabang_id = '".intval($_POST['cabng_id'])."' and customer_id = '".intval($_POST['customer_id'])."' and ifnull(jumlah_penjualan, 0) = 0 and date_add(tanggal, INTERVAL batas_waktu DAY) >= '".date('Y-m-d', strtotime($now))."'";
 if(isset($_POST['cari']) && $_POST['cari'] !== "")
  { $queryFilter .= " and (concat(".$_POST['Nama_Tabel'].".kode, '/', lpad(".$_POST['Nama_Tabel'].".nomor, if(3 > length(".$_POST['Nama_Tabel'].".nomor), 3, length(".$_POST['Nama_Tabel'].".nomor)), '0'), '/MIE/', to_roman(month(tanggal)), '/', ".$_POST['Nama_Tabel'].".tahun) like '%".str_replace("'", "\'", $_POST['cari'])."%' or ".$_POST['Nama_Tabel'].".customer_id in (select id from customer where nama like '%".str_replace("'", "\'", $_POST['cari'])."%' or nomor_po like '%".str_replace("'", "\'", $_POST['cari'])."%'))";
  }

 $nhalaman = 1;
 $halaman = 1;
 if(isset($_POST['halaman']) && $_POST['halaman'] !== "")
  { $halaman = $_POST['halaman'];
  }

 $nListView = 0;
 $query = "select count(*) as jlh from ".$_POST['Nama_Tabel'].$queryFilter;
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $nListView = $row['jlh'];
  }
 
 if($nListView > $_POST['maxRecord'])
  { $bagi = $nListView / $_POST['maxRecord'];
    $mod = $nListView % $_POST['maxRecord'];
    if($mod == 0)
     { $nhalaman = intval($bagi);
     }
    else
     { $nhalaman = intval($bagi) + 1;
     }
  }

 if($halaman > $nhalaman)
  { $halaman = $nhalaman;
  }
 if($halaman < 1)
  { $halaman = 1;
  }

 $option_halaman = "<option></option>";
 for($i=1; $i<=$nhalaman; $i++)
  { if($i == $halaman)
     { $option_halaman .= "<option value='".$i."' selected>".$i."</option>";
     }
    else
     { $option_halaman .= "<option value='".$i."'>".$i."</option>";
     }
  }

 echo "<input type='hidden' id='txthalamanpesanan' value='".$halaman."'>
       <input type='hidden' id='txtnhalamanpesanan' value='".$nhalaman."'>
       <select style='display:none;' id='temp-preview-halaman-pesanan'>".$option_halaman."</select>";

 echo "<table class='table table-bordered table-hover' style='margin-top:5px; margin-bottom:5px;'>
        <thead>
         <tr>
          <th style='padding:2px 4px 2px 4px;'>Tanggal</th>
          <th style='padding:2px 4px 2px 4px;'>No. Pesanan</th>
          <th style='padding:2px 4px 2px 4px;'>No. PO</th>
          <th style='padding:2px 4px 2px 4px;'>Customer</th>
          <th style='padding:2px 4px 2px 4px;'>Alamat Customer</th>
          <th style='padding:2px 4px 2px 4px; text-align:center; width:150px; min-width:150px; max-width:150px;'>Total</th>
         </tr>
        </thead>
        <tbody>";

 $descTable = array();
 $query = "desc ".$_POST['Nama_Tabel'];
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { array_push($descTable, array(
     "Field" => $row['Field'],
     "Type" => $row['Type'],
    ));
  }

 $filter_barang = "";
 $filter_karyawan = "";

 $dataRows = array();
 $DataEdit = "";
 $limit = $halaman * $_POST['maxRecord'];
 $start = $limit - $_POST['maxRecord'];
 $query = "select ".$_POST['Nama_Tabel'].".*, concat(".$_POST['Nama_Tabel'].".kode, '/', lpad(".$_POST['Nama_Tabel'].".nomor, if(3 > length(".$_POST['Nama_Tabel'].".nomor), 3, length(".$_POST['Nama_Tabel'].".nomor)), '0'), '/MIE/', to_roman(month(tanggal)), '/', ".$_POST['Nama_Tabel'].".tahun) as nomor_pesanan from ".$_POST['Nama_Tabel'].$queryFilter." order by tanggal desc, id desc limit ".$_POST['maxRecord']." offset ".$start;
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $array_push = array();
    $array_push['nomor_pesanan'] = $row['nomor_pesanan'];
    for($i=0; $i<count($descTable); $i++)
     { if(isset($row[$descTable[$i]['Field']]) && $row[$descTable[$i]['Field']] !== "")
        { if($descTable[$i]['Type'] == "decimal(20,2)")
           { $array_push[$descTable[$i]['Field']] = number_format($row[$descTable[$i]['Field']], 2, ",", ".");
           }
          else if($descTable[$i]['Type'] == "date")
           { $array_push[$descTable[$i]['Field']] = date('d-m-Y', strtotime($row[$descTable[$i]['Field']]));
           }
          else
           { $array_push[$descTable[$i]['Field']] = $row[$descTable[$i]['Field']];
           }
        }
       else
        { $array_push[$descTable[$i]['Field']] = null;
        }
       $DataEdit .= "<textarea class='textarea_pesanan-".$descTable[$i]['Field']."'>".$array_push[$descTable[$i]['Field']]."</textarea>";
     }
    $DataEdit .= "<textarea class='textarea_pesanan-nomor_pesanan'>".$array_push['nomor_pesanan']."</textarea>";
    $detail = array();
    if(isset($row['detail']) && $row['detail'] !== "")
     { $detail = json_decode($row['detail'], true);
     }
    $array_push['detail'] = $detail;
    array_push($dataRows, $array_push);
    foreach($detail as $key => $value)
     { if(strval(strpos($filter_barang, "id = '".$value['barang_id']."'")) == "")
        { if($filter_barang !== "")
           { $filter_barang .= " or";
           }
          $filter_barang .= " id = '".$value['barang_id']."'";
        }
     }
    if(strval(strpos($filter_karyawan, "id = '".$row['karyawan_id']."'")) == "")
     { if($filter_karyawan !== "")
        { $filter_karyawan .= " or";
        }
       $filter_karyawan .= " id = '".$row['karyawan_id']."'";
     }
  }

 $arrayBarang = array();
 if($filter_barang !== "")
  { $query = "select * from barang where".$filter_barang;
    $execute = mysqli_query($koneksi, $query);
    while($row = mysqli_fetch_array($execute))
     { $data_push = array();
       foreach($row as $key => $value)
        { if($key !== 0 && intval($key) == 0)
           { $data_push[$key] = $value;
           }
        }
       array_push($arrayBarang, $data_push);
     }
  }

 $arrayKaryawan = array();
 if($filter_karyawan !== "")
  { $query = "select * from karyawan where".$filter_karyawan;
    $execute = mysqli_query($koneksi, $query);
    while($row = mysqli_fetch_array($execute))
     { array_push($arrayKaryawan, array(
        "id" => $row['id'],
        "nik" => $row['nik'],
        "nama" => $row['nama'],
       ));
     }
  }

 for($i=0; $i<count($dataRows); $i++)
  { echo "<tr style='cursor:pointer;' class='tr-pesanan' onclick='pilihPesanan(this);'>
           <td style='padding:2px 4px 2px 4px;'>".$dataRows[$i]['tanggal']."</td>
           <td style='padding:2px 4px 2px 4px;'>".$dataRows[$i]['nomor_pesanan']."</td>
           <td style='padding:2px 4px 2px 4px;'>".$dataRows[$i]['nomor_po']."</td>
           <td style='padding:2px 4px 2px 4px;'>".$dataRows[$i]['nama_customer']."</td>
           <td style='padding:2px 4px 2px 4px;'>".$dataRows[$i]['alamat_customer']."</td>
           <td style='padding:2px 4px 2px 4px; text-align:right;'>".$dataRows[$i]['total']."</td>
          </tr>";
    $DataEdit .= "<div class='div_pesanan-detail_barang'>";
    foreach($dataRows[$i]['detail'] as $key => $data)
     { $kode = "";
       $nama = "";
       $merek = "";
       $model = "";
       $tipe = "";
       $jenis = "";
       $kapasitas_pk = "";
       $btuh = "";
       $index = array_search($data['barang_id'], array_column($arrayBarang, 'id'));
       if(strval($index) !== "")
        { $kode = $arrayBarang[$index]['kode'];
          $nama = $arrayBarang[$index]['nama'];
          $merek = $arrayBarang[$index]['merek'];
          $model = $arrayBarang[$index]['model'];
          $tipe = $arrayBarang[$index]['tipe'];
          $jenis = $arrayBarang[$index]['jenis'];
          $kapasitas_pk = formatAngka($arrayBarang[$index]['kapasitas_pk']);
          $btuh = $arrayBarang[$index]['btuh'];
        }
       if($data['harga'] * 1 > 0)
        { $data['harga'] = formatAngka($data['harga']);
        }
       if($data['jumlah'] * 1 > 0)
        { $data['jumlah'] = formatAngka($data['jumlah']);
        }
       if($data['total'] * 1 > 0)
        { $data['total'] = formatAngka($data['total']);
        }
       $DataEdit .= "<textarea class='detail_barang-kode'>".$kode."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-nama'>".$nama."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-merek'>".$merek."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-model'>".$model."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-tipe'>".$tipe."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-jenis'>".$jenis."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-kapasitas_pk'>".$kapasitas_pk."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-btuh'>".$btuh."</textarea>";

       foreach($data as $key => $value)
        { if(is_array($value))
           { $value = json_encode($value);
           }
          if(intval($key) == 0 && strval($key) !== "0" )
           { if(is_numeric($value) && $key !== "id" && strval(strpos($key, "id_")) == "" && strval(strpos($key, "_id")) == "")
              { $value = number_format($value, 2, ",", ".");
              }
             $DataEdit .= "<textarea class='detail_barang-".$key."'>".$value."</textarea>";
           }
        }
     }
    $DataEdit .= "</div>";

    $list_karayawan = "";
    $index = array_search($dataRows[$i]['karyawan_id'], array_column($arrayKaryawan, 'id'));
    if(strval($index) !== "")
     { $list_karayawan .= "<option value='".$dataRows[$i]['karyawan_id']."' selected>".$arrayKaryawan[$index]['nik']." - ".$arrayKaryawan[$index]['nama']."</option>";
     }
    $DataEdit .= "<select class='select_pesanan-karyawan_id'>".$list_karayawan."</select>";
  }

 echo "  </tbody>
        </table>Menampilkan ".count($dataRows)." dari ".$nListView." record";

 echo "<div style='display:none;'>".$DataEdit."</div>";

?>