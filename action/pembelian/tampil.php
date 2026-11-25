<?php

 include("../bjksadkhrej121lkjkjk.php");

 $queryFilter = " where cabang_id = '".intval($_POST['cari_cabang_id'])."'";
 if(isset($_POST['filter']) && ($_POST['filter'] !== "" || $_POST['filter'] !== "[]"))
  { $filter = json_decode($_POST['filter'], true);
    for($i=0; $i<count($filter); $i++)
     { if($filter[$i]['field'] == "pembelian.tanggal")
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
         <th style='padding:2px 4px 2px 4px;'>Tanggal</th>
         <th style='padding:2px 4px 2px 4px;'>Nomor Pembelian</th>
         <th style='padding:2px 4px 2px 4px;'>Supplier</th>
         <th style='padding:2px 4px 2px 4px;'>Alamat Supplier</th>
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

 $dataRows = array();
 $DataEdit = "";
 $limit = $halaman * $_POST['maxRecord'];
 $start = $limit - $_POST['maxRecord'];
 $query = "select ".$_POST['Nama_Tabel'].".*, concat(".$_POST['Nama_Tabel'].".kode, right(year(".$_POST['Nama_Tabel'].".tanggal), 2), lpad(month(".$_POST['Nama_Tabel'].".tanggal), 2, '0'), lpad(day(".$_POST['Nama_Tabel'].".tanggal), 2, '0'), '-MIE-', lpad(".$_POST['Nama_Tabel'].".nomor, if(3 > length(".$_POST['Nama_Tabel'].".nomor), 3, length(".$_POST['Nama_Tabel'].".nomor)), '0') ) as nomor_pembelian from ".$_POST['Nama_Tabel'].$queryFilter." order by pembelian.tanggal desc, pembelian.id desc limit ".$_POST['maxRecord']." offset ".$start;
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $array_push = array();
    $array_push['nomor_pembelian'] = $row['nomor_pembelian'];
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
    $DataEdit .= "<textarea class='textarea_edit-nomor_pembelian'>".$array_push['nomor_pembelian']."</textarea>";
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

    $no_telp_supplier = array();
    if(isset($row['no_telp_supplier']) && $row['no_telp_supplier'] !== "")
     { $no_telp_supplier = json_decode($row['no_telp_supplier'], true);
     }
    $DataEdit .= "<div class='detail-no_telp_supplier'>";
    foreach($no_telp_supplier as $key => $value)
     { foreach($value as $key2 => $value2)
        { $DataEdit .= '<textarea class="detail-no_telp_supplier-'.$key2.'">'.$value2.'</textarea>';
        }
     }
    $DataEdit .= "</div>";

    $no_wa_supplier = array();
    if(isset($row['no_wa_supplier']) && $row['no_wa_supplier'] !== "")
     { $no_wa_supplier = json_decode($row['no_wa_supplier'], true);
     }
    $DataEdit .= "<div class='detail-no_wa_supplier'>";
    foreach($no_wa_supplier as $key => $value)
     { foreach($value as $key2 => $value2)
        { $DataEdit .= '<textarea class="detail-no_wa_supplier-'.$key2.'">'.$value2.'</textarea>';
        }
     }
    $DataEdit .= "</div>";

    $email_supplier = array();
    if(isset($row['email_supplier']) && $row['email_supplier'] !== "")
     { $email_supplier = json_decode($row['email_supplier'], true);
     }
    $DataEdit .= "<div class='detail-email_supplier'>";
    foreach($email_supplier as $key => $value)
     { foreach($value as $key2 => $value2)
        { $DataEdit .= '<textarea class="detail-email_supplier-'.$key2.'">'.$value2.'</textarea>';
        }
     }
    $DataEdit .= "</div>";
  }

 $filter_satuan = "";
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
       if(strval(strpos($filter_satuan, "id = '".$row['satuan_id']."'")) == "" && strval($row['satuan_id']) !== "")
        { if($filter_satuan !== "")
           { $filter_satuan .= " or";
           }
          $filter_satuan .= " id = '".$row['satuan_id']."'";
        }
     }
  }

 $arraySatuan = array();
 if($filter_satuan !== "")
  { $query = "select * from satuan where".$filter_satuan;
    $execute = mysqli_query($koneksi, $query);
    while($row = mysqli_fetch_array($execute))
     { array_push($arraySatuan, array(
        "id" => $row['id'],
        "satuan" => $row['satuan'],
       ));
     }
  }

 for($i=0; $i<count($dataRows); $i++)
  { echo "<tr>
           <td style='padding:2px 4px 2px 4px;'>".$dataRows[$i]['tanggal']."</td>
           <td style='padding:2px 4px 2px 4px;'>".$dataRows[$i]['nomor_pembelian']."</td>
           <td style='padding:2px 4px 2px 4px;'>".$dataRows[$i]['nama_supplier']."</td>
           <td style='padding:2px 4px 2px 4px;'>".$dataRows[$i]['alamat_supplier']."</td>
           <td style='padding:2px 4px 2px 4px; text-align:center;'>
            <button type='button' class='btn btn-default view' title='View' onclick='view(this);'><i class='fa fa-search'></i></button>
            <button type='button' class='btn btn-default edit' title='Edit' onclick='edit(this);'><i class='fa fa-edit'></i></button>
            <button type='button' class='btn btn-default hapus' title='Hapus' onclick='konfirmasiHapus(this);'><i class='fa fa-trash'></i></button>
           </td>
           <td style='padding:2px 4px 2px 4px; text-align:center;'>
            <button type='button' class='btn btn-danger cetak' title='Cetak' onclick='cetak(this);'><i class='fa fa-file-pdf-o'></i></button>
           </td>
          </tr>";
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
       $ukuran = "";
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
          $ukuran = formatAngka($arrayBarang[$index]['ukuran']);
          $satuan = "";
          $index2 = array_search($arrayBarang[$index]['satuan_id'], array_column($arraySatuan, 'id'));
          if(strval($index2) !== "")
           { $satuan = $arraySatuan[$index2]['satuan'];
           }
        }
       $DataEdit .= "<textarea class='detail_barang-kode'>".$kode."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-nama'>".$nama."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-merek'>".$merek."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-model'>".$model."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-tipe'>".$tipe."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-jenis'>".$jenis."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-kapasitas_pk'>".$kapasitas_pk."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-btuh'>".$btuh."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-ukuran'>".$ukuran."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-satuan'>".$satuan."</textarea>";
       foreach($data as $key => $value)
        { if(is_array($value))
           { $value = json_encode($value);
           }
          if(intval($key) == 0 && strval($key) !== "0")
           { if(is_numeric($value) && $key !== "id" && strval(strpos($key, "id_")) == "" && strval(strpos($key, "_id")) == "")
              { $value = number_format(isset($value) ? $value : 0, 2, ",", ".");
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