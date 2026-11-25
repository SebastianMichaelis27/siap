<?php

 include("../bjksadkhrej121lkjkjk.php");

 $lokasi_folder = "../export/";
 if(!is_dir($lokasi_folder))
  { mkdir($lokasi_folder, 0755);
  }
 $lokasi_folder .= $username."/";
 if(!is_dir($lokasi_folder))
  { mkdir($lokasi_folder, 0755);
  }
 $lokasi_folder .= "penjualan/";
 if(!is_dir($lokasi_folder))
  { mkdir($lokasi_folder, 0755);
  }
 deleteDirectory($lokasi_folder);

 $queryFilter = " where ifnull(approved_at, '') = '' and ifnull(rejected_at, '') = ''";
 if(isset($_POST['jenis_list']) && $_POST['jenis_list'] == "Diterima")
  { $queryFilter = " where ifnull(approved_at, '') <> '' and ifnull(rejected_at, '') = ''";
  }
 if(isset($_POST['jenis_list']) && $_POST['jenis_list'] == "Ditolak")
  { $queryFilter = " where ifnull(approved_at, '') = '' and ifnull(rejected_at, '') <> ''";
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

 echo "<input type='hidden' id='txthalaman' value='".$halaman."'>
       <input type='hidden' id='txtnhalaman' value='".$nhalaman."'>
       <select style='display:none;' id='temp-preview-halaman'>".$option_halaman."</select>";

 echo "<table class='table table-bordered' style='margin-top:5px; margin-bottom:5px;'>
        <tr>
         <th style='padding:2px 4px 2px 4px; min-width:100px;'>Cabang</th>
         <th style='padding:2px 4px 2px 4px; min-width:100px;'>Nomor PO</th>
         <th style='padding:2px 4px 2px 4px; min-width:200px;'>Customer</th>
         <th style='padding:2px 4px 2px 4px; min-width:200px;'>Alamat Customer</th>
         <th style='padding:2px 4px 2px 4px; min-width:200px;'>Sales</th>
         <th style='padding:2px 4px 2px 4px; text-align:center; width:150px; max-width:150px; min-width:150px;'>Total</th>
         <th style='padding:2px 4px 2px 4px; text-align:center; width:50px; max-width:50px; min-width:50px;'>Act</th>
        </tr>";

 $descTable = array();
 $query = "desc ".$_POST['Nama_Tabel'];
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { array_push($descTable, array(
     "Field" => $row['Field'],
     "Type" => $row['Type'],
    ));
  }

 $filter_cabang = "";
 $filter_barang = "";
 $filter_jasa = "";
 $filter_karyawan = "";

 $dataRows = array();
 $DataEdit = "";
 $limit = $halaman * $_POST['maxRecord'];
 $start = $limit - $_POST['maxRecord'];
 $query = "select ".$_POST['Nama_Tabel'].".*, concat(".$_POST['Nama_Tabel'].".kode, ' ', lpad(".$_POST['Nama_Tabel'].".nomor, if(3 > length(".$_POST['Nama_Tabel'].".nomor), 3, length(".$_POST['Nama_Tabel'].".nomor)), '0'), '/', right(".$_POST['Nama_Tabel'].".tahun, 2)) as nomor_penjualan from ".$_POST['Nama_Tabel'].$queryFilter." order by id desc limit ".$_POST['maxRecord']." offset ".$start;
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $array_push = array();
    $array_push['nomor_penjualan'] = $row['nomor_penjualan'];
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
       $DataEdit .= "<textarea class='textarea_edit-".$descTable[$i]['Field']."'>".$array_push[$descTable[$i]['Field']]."</textarea>";
     }
    $DataEdit .= "<textarea class='textarea_edit-nomor_penjualan'>".$array_push['nomor_penjualan']."</textarea>";
    $detail = array();
    if(isset($row['detail']) && $row['detail'] !== "")
     { $detail = json_decode($row['detail'], true);
     }
    $array_push['detail'] = $detail;
    array_push($dataRows, $array_push);
    foreach($detail as $key => $value)
     { if(strval(strpos($filter_barang, "barang.id = '".$value['barang_id']."'")) == "")
        { if($filter_barang !== "")
           { $filter_barang .= " or";
           }
          $filter_barang .= " barang.id = '".$value['barang_id']."'";
        }
       if(strval(strpos($filter_jasa, "jasa.id = '".($value['jasa_id'] ?? '')."'")) == "")
        { if($filter_jasa !== "")
           { $filter_jasa .= " or";
           }
          $filter_jasa .= " jasa.id = '".$value['jasa_id']."'";
        }
     }
    if(strval(strpos($filter_cabang, "id = '".$row['cabang_id']."'")) == "")
     { if($filter_cabang !== "")
        { $filter_cabang .= " or";
        }
       $filter_cabang .= " id = '".$row['cabang_id']."'";
     }
    if(strval(strpos($filter_karyawan, "id = '".$row['karyawan_id']."'")) == "")
     { if($filter_karyawan !== "")
        { $filter_karyawan .= " or";
        }
       $filter_karyawan .= " id = '".$row['karyawan_id']."'";
     }
  }

 $arrayCabang = array();
 if($filter_cabang !== "")
  { $query = "select * from cabang where".$filter_cabang;
    $execute = mysqli_query($koneksi, $query);
    while($row = mysqli_fetch_array($execute))
     { $data_push = array();
       foreach($row as $key => $value)
        { if($key !== 0 && intval($key) == 0)
           { $data_push[$key] = $value;
           }
        }
       array_push($arrayCabang, $data_push);
     }
  }

 $arrayBarang = array();
 if($filter_barang !== "")
  { $query = "select barang.*, satuan.satuan from barang left join satuan on barang.satuan_id = satuan.id where".$filter_barang;
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

 $arrayJasa = array();
 if($filter_jasa !== "")
  { $query = "select * from jasa where".$filter_jasa;
    $execute = mysqli_query($koneksi, $query);
    while($row = mysqli_fetch_array($execute))
     { $data_push = array();
       foreach($row as $key => $value)
        { if($key !== 0 && intval($key) == 0)
           { $data_push[$key] = $value;
           }
        }
       array_push($arrayJasa, $data_push);
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
  { $cabang = "";
    $index = array_search($dataRows[$i]['cabang_id'], array_column($arrayCabang, 'id'));
    if(strval($index) !== "")
     { $cabang = $arrayCabang[$index]['nama'];
     }
    $karyawan = "";
    $index = array_search($dataRows[$i]['karyawan_id'], array_column($arrayKaryawan, 'id'));
    if(strval($index) !== "")
     { $karyawan = $arrayKaryawan[$index]['nik']." - ".$arrayKaryawan[$index]['nama'];
     }
    echo "<tr class='group-hover list-penjualan' onclick='konfirmasi(this);'>
           <td style='padding:2px 4px 2px 4px;'>".$cabang."</td>
           <td style='padding:2px 4px 2px 4px;'>".$dataRows[$i]['nomor_penjualan']."</td>
           <td style='padding:2px 4px 2px 4px;'>".$dataRows[$i]['nama_customer']."</td>
           <td style='padding:2px 4px 2px 4px;'>".$dataRows[$i]['alamat_customer']."</td>
           <td style='padding:2px 4px 2px 4px;'>".$karyawan."</td>
           <td style='padding:2px 4px 2px 4px; text-align:right;'>".$dataRows[$i]['total']."</td>
           <td style='padding:2px 4px 2px 4px; text-align:center;'>
            <button type='button' class='btn btn-default konfirmasi' title='Konfirmasi'><i class='fa fa-search'></i></button>
           </td>
          </tr>";
    $DataEdit .= "<select class='select_edit-karyawan_id'><option value='".$dataRows[$i]['karyawan_id']."' selected>".$karyawan."</option></select>";
    $DataEdit .= "<div class='div-detail_barang'>";
    foreach($dataRows[$i]['detail'] as $key => $data)
     { $kode = "";
       $nama = "";
       $merek = "";
       $model = "";
       $tipe = "";
       $jenis = "";
       $kapasitas_pk = "";
       $btuh = "";
       $satuan = "";
       $index = array_search($data['barang_id'], array_column($arrayBarang, 'id'));
       if(strval($index) !== "")
        { $kode = $arrayBarang[$index]['kode'];
          $nama = $arrayBarang[$index]['nama'];
          $merek = $arrayBarang[$index]['merek'];
          $model = $arrayBarang[$index]['model'];
          $tipe = $arrayBarang[$index]['tipe'];
          $jenis = $arrayBarang[$index]['jenis'];
          $kapasitas_pk = $arrayBarang[$index]['kapasitas_pk'];
          $btuh = $arrayBarang[$index]['btuh'];
          $satuan = $arrayBarang[$index]['satuan'];
        }
       $index = array_search($data['jasa_id'] ?? '', array_column($arrayJasa, 'id'));
       if(strval($index) !== "")
        { $nama = $arrayJasa[$index]['jasa'];
        }
       $DataEdit .= "<textarea class='detail_barang-kode'>".$kode."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-nama'>".$nama."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-merek'>".$merek."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-model'>".$model."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-tipe'>".$tipe."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-jenis'>".$jenis."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-kapasitas_pk'>".$kapasitas_pk."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-btuh'>".$btuh."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-satuan'>".$satuan."</textarea>";
       foreach($data as $key => $value)
        { if(intval($key) == 0 && strval($key) !== "0")
           { if(is_numeric($value) && $key !== "id" && strval(strpos($key, "id_")) == "" && strval(strpos($key, "_id")) == "" && is_numeric($value))
              { $value = formatAngka($value);
              }
             if(is_array($value))
              { $DataEdit .= "<textarea class='detail_barang-".$key."'>".json_encode($value)."</textarea>";
              }
             else
              { $DataEdit .= "<textarea class='detail_barang-".$key."'>".$value."</textarea>";
              }
           }
        }
     }
    $DataEdit .= "</div>";
  }

 echo " </table>Menampilkan ".count($dataRows)." dari ".$nListView." record";

 echo "<div style='display:none;'>".$DataEdit."</div>";

?>