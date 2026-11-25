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
 $lokasi_folder .= "pesanan/";
 if(!is_dir($lokasi_folder))
  { mkdir($lokasi_folder, 0755);
  }
 deleteDirectory($lokasi_folder);

 $queryFilter = " where cabang_id = '".intval($_POST['cabng_id'])."'";
 if(isset($_POST['filter']) && ($_POST['filter'] !== "" || $_POST['filter'] !== "[]"))
  { $filter = json_decode($_POST['filter'], true);
    for($i=0; $i<count($filter); $i++)
     { if($filter[$i]['field'] == "pesanan.tanggal")
        { $queryFilter .= " and concat(".str_replace("'", "\'", $filter[$i]['field']).") = '".date('Y-m-d', strtotime($filter[$i]['value']))."'";
        }
       else
        { $queryFilter .= " and concat(".str_replace("'", "\'", $filter[$i]['field']).") like '%".str_replace("'", "\'", trim($filter[$i]['value']))."%'";
        }
     }
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
         <th style='padding:2px 4px 2px 4px; min-width:100px;'>Tanggal</th>
         <th style='padding:2px 4px 2px 4px; min-width:100px;'>No. Pesanan</th>
         <th style='padding:2px 4px 2px 4px; min-width:200px;'>Customer</th>
         <th style='padding:2px 4px 2px 4px; min-width:200px;'>Alamat Customer</th>
         <th style='padding:2px 4px 2px 4px; min-width:200px;'>Sales</th>
         <th style='padding:2px 4px 2px 4px; text-align:center; width:150px; max-width:150px; min-width:150px;'>Total</th>
         <th style='padding:2px 4px 2px 4px; text-align:center; width:150px; max-width:150px; min-width:150px;'>Act</th>
         <th style='padding:2px 4px 2px 4px; text-align:center; width:50px; max-width:50px; min-width:50px;'>Print</th>
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

 $filter_barang = "";
 $filter_karyawan = "";
 $filter_penawaran_detail = "";

 $dataRows = array();
 $DataEdit = "";
 $limit = $halaman * $_POST['maxRecord'];
 $start = $limit - $_POST['maxRecord'];
 $query = "select ".$_POST['Nama_Tabel'].".*, concat(".$_POST['Nama_Tabel'].".kode, '/', lpad(".$_POST['Nama_Tabel'].".nomor, if(3 > length(".$_POST['Nama_Tabel'].".nomor), 3, length(".$_POST['Nama_Tabel'].".nomor)), '0'), '/MIE/', to_roman(month(tanggal)), '/', ".$_POST['Nama_Tabel'].".tahun) as nomor_pesanan from ".$_POST['Nama_Tabel'].$queryFilter." order by pesanan.tanggal desc, pesanan.id desc limit ".$_POST['maxRecord']." offset ".$start;
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
       $DataEdit .= "<textarea class='textarea_edit-".$descTable[$i]['Field']."'>".$array_push[$descTable[$i]['Field']]."</textarea>";
     }
    $DataEdit .= "<textarea class='textarea_edit-nomor_pesanan'>".$array_push['nomor_pesanan']."</textarea>";
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
       if(strval(strpos($filter_penawaran_detail, "penawaran_detail.id = '".$value['penawaran_detail_id']."'")) == "")
        { if($filter_penawaran_detail !== "")
           { $filter_penawaran_detail .= " or";
           }
          $filter_penawaran_detail .= " penawaran_detail.id = '".$value['penawaran_detail_id']."'";
        }
     }
    if(strval(strpos($filter_karyawan, "id = '".$row['karyawan_id']."'")) == "")
     { if($filter_karyawan !== "")
        { $filter_karyawan .= " or";
        }
       $filter_karyawan .= " id = '".$row['karyawan_id']."'";
     }

    $no_telp_customer = array();
    if(isset($row['no_telp_customer']) && $row['no_telp_customer'] !== "")
     { $no_telp_customer = json_decode($row['no_telp_customer'], true);
     }
    $DataEdit .= "<div class='detail-no_telp_customer'>";
    foreach($no_telp_customer as $key => $value)
     { foreach($value as $key2 => $value2)
        { $DataEdit .= '<textarea class="detail-no_telp_customer-'.$key2.'">'.$value2.'</textarea>';
        }
     }
    $DataEdit .= "</div>";

    $no_wa_customer = array();
    if(isset($row['no_wa_customer']) && $row['no_wa_customer'] !== "")
     { $no_wa_customer = json_decode($row['no_wa_customer'], true);
     }
    $DataEdit .= "<div class='detail-no_wa_customer'>";
    foreach($no_wa_customer as $key => $value)
     { foreach($value as $key2 => $value2)
        { $DataEdit .= '<textarea class="detail-no_wa_customer-'.$key2.'">'.$value2.'</textarea>';
        }
     }
    $DataEdit .= "</div>";

    $email_customer = array();
    if(isset($row['email_customer']) && $row['email_customer'] !== "")
     { $email_customer = json_decode($row['email_customer'], true);
     }
    $DataEdit .= "<div class='detail-email_customer'>";
    foreach($email_customer as $key => $value)
     { foreach($value as $key2 => $value2)
        { $DataEdit .= '<textarea class="detail-email_customer-'.$key2.'">'.$value2.'</textarea>';
        }
     }
    $DataEdit .= "</div>";
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

 $arrayPenawaranDetail = array();
 if($filter_penawaran_detail !== "")
  { $query = "select penawaran_detail.id, concat(penawaran.kode, '/', lpad(penawaran.nomor, if(3 > length(penawaran.nomor), 3, length(penawaran.nomor)), '0'), '/MIE/', to_roman(month(tanggal)), '/', penawaran.tahun) as nomor_penawaran, penawaran.tahun from penawaran_detail left join penawaran on penawaran_detail.penawaran_id = penawaran.id where".$filter_penawaran_detail;
    $execute = mysqli_query($koneksi, $query);
    while($row = mysqli_fetch_array($execute))
     { array_push($arrayPenawaranDetail, array(
        "id" => $row['id'],
        "nomor_penawaran" => $row['nomor_penawaran'],
       ));
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
  { $karyawan = "";
    $index = array_search($dataRows[$i]['karyawan_id'], array_column($arrayKaryawan, 'id'));
    if(strval($index) !== "")
     { $karyawan = $arrayKaryawan[$index]['nik']." - ".$arrayKaryawan[$index]['nama'];
     }
    $btn_print = "";
    if(strval($dataRows[$i]['approved_at']) == "" && strval($dataRows[$i]['rejected_at']) == "")
     { $btn_print = "<button type='button' class='btn btn-warning cetak' title='Menunggu Konfirmasi'><i class='fa fa-clock-o'></i></button>";
     }
    else if(strval($dataRows[$i]['rejected_at']) !== "")
     { $btn_print = "<button type='button' class='btn btn-default cetak' title='Ditolak'><i class='fa fa-close'></i></button>";
     }
    else
     { $btn_print = "<button type='button' class='btn btn-danger cetak' title='Cetak' onclick='cetak(this);'><i class='fa fa-file-pdf-o'></i></button>";
     }
    echo "<tr>
           <td style='padding:2px 4px 2px 4px;'>".$dataRows[$i]['tanggal']."</td>
           <td style='padding:2px 4px 2px 4px;'>".$dataRows[$i]['nomor_pesanan']."</td>
           <td style='padding:2px 4px 2px 4px;'>".$dataRows[$i]['nama_customer']."</td>
           <td style='padding:2px 4px 2px 4px;'>".$dataRows[$i]['alamat_customer']."</td>
           <td style='padding:2px 4px 2px 4px;'>".$karyawan."</td>
           <td style='padding:2px 4px 2px 4px; text-align:right;'>".$dataRows[$i]['total']."</td>
           <td style='padding:2px 4px 2px 4px; text-align:center;'>
            <button type='button' class='btn btn-default view' title='View' onclick='view(this);'><i class='fa fa-search'></i></button>
            <button type='button' class='btn btn-default edit' title='Edit' onclick='edit(this);'><i class='fa fa-edit'></i></button>
            <button type='button' class='btn btn-default hapus' title='Hapus' onclick='konfirmasiHapus(this);'><i class='fa fa-trash'></i></button>
           </td>
           <td style='padding:2px 4px 2px 4px; text-align:center;'>".$btn_print."</td>
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
        }
       $nomor_penawaran = "";
       $index = array_search($data['penawaran_detail_id'], array_column($arrayPenawaranDetail, 'id'));
       if(strval($index) !== "")
        { $nomor_penawaran = $arrayPenawaranDetail[$index]['nomor_penawaran'];
        }
       $DataEdit .= "<textarea class='detail_barang-nomor_penawaran'>".$nomor_penawaran."</textarea>";
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
          if(intval($key) == 0 && strval($key) !== "0")
           { if(is_numeric($value) && $key !== "id" && strval(strpos($key, "id_")) == "" && strval(strpos($key, "_id")) == "")
              { $value = number_format($value, 2, ",", ".");
              }
             $DataEdit .= "<textarea class='detail_barang-".$key."'>".$value."</textarea>";
           }
        }
     }
    $DataEdit .= "</div>";
  }

 echo " </table>Menampilkan ".count($dataRows)." dari ".$nListView." record";

 echo "<div style='display:none;'>".$DataEdit."</div>";

?>