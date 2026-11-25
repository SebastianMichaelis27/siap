<?php

 include("../bjksadkhrej121lkjkjk.php");
 include("../../design/url.php");

 $lokasi_folder = "../../gambar/";
 if(!is_dir($lokasi_folder))
  { mkdir($lokasi_folder, 0755);
  }
 $lokasi_folder .= "barang/";
 if(!is_dir($lokasi_folder))
  { mkdir($lokasi_folder, 0755);
  }

 $kategori = array();
 $queryFilter = "";
 if(isset($_POST['filter']) && ($_POST['filter'] !== "" || $_POST['filter'] !== "[]"))
  { $filter = json_decode($_POST['filter'], true);
    for($i=0; $i<count($filter); $i++)
     { if($filter[$i]['field'] == 'barang.kapasitas_pk' || $filter[$i]['field'] == 'barang.btuh' || $filter[$i]['field'] == 'barang.harga_beli' || $filter[$i]['field'] == 'barang.harga_jual')
        { if($queryFilter !== "")
           { $queryFilter .= " and";
           }
          $queryFilter .= " ".str_replace("'", "\'", $filter[$i]['field'])." = ".str_replace("'", "\'", trim($filter[$i]['value']));
        }
       else if($filter[$i]['field'] == 'barang.kategori')
        { $kategori = json_decode($filter[$i]['value'], true);
        }
       else
        { if($queryFilter !== "")
           { $queryFilter .= " and";
           }
          $queryFilter .= " concat(".str_replace("'", "\'", $filter[$i]['field']).") like '%".str_replace("'", "\'", trim($filter[$i]['value']))."%'";
        }
     }
  }

 $filter = "";
 foreach($kategori as $field => $value)
  { if($filter !== "")
     { $filter .= " or ";
     }
    $filter .= "barang.kategori like '%\"kategori_id\":\"".$value['kategori_id']."\"%'";
  }
 if($filter !== "")
  { if($queryFilter !== "")
     { $queryFilter .= " and";
     }
    $queryFilter = " (".$filter.")";
  }

 if($queryFilter !== "")
  { $queryFilter = " where".$queryFilter;
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
         <th style='padding:2px 4px 2px 4px;'>Kode</th>
         <th style='padding:2px 4px 2px 4px;'>Nama</th>
         <th style='padding:2px 4px 2px 4px;'>Merek</th>
         <th style='padding:2px 4px 2px 4px;'>Model</th>
         <th style='padding:2px 4px 2px 4px;'>Tipe</th>
         <th style='padding:2px 4px 2px 4px;'>Jenis</th>
         <th style='padding:2px 4px 2px 4px;'>Satuan</th>
         <th style='padding:2px 4px 2px 4px; text-align:center; width:150px; max-width:150px; min-width:150px;'>Harga Jual</th>
         <th style='padding:2px 4px 2px 4px; text-align:center; width:150px; max-width:150px; min-width:150px;'>Act</th>
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

 $filter_satuan = "";

 $dataRows = array();
 $DataEdit = "";
 $limit = $halaman * $_POST['maxRecord'];
 $start = $limit - $_POST['maxRecord'];
 $query = "select * from ".$_POST['Nama_Tabel'].$queryFilter." order by id desc limit ".$_POST['maxRecord']." offset ".$start;
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $array_push = array();
    for($i=0; $i<count($descTable); $i++)
     { if(isset($row[$descTable[$i]['Field']]) && $row[$descTable[$i]['Field']] !== "")
        { if(strval(strpos($descTable[$i]['Type'], "decimal")) !== "")
           { $array_push[$descTable[$i]['Field']] = formatAngka($row[$descTable[$i]['Field']], 2, ",", ".");
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
       if($descTable[$i]['Field'] == "foto")
        { if(strval($row[$descTable[$i]['Field']]) !== "" && !file_exists($lokasi_folder.$row[$descTable[$i]['Field']]))
           { $array_push[$descTable[$i]['Field']] = 'dist/img/no_image.png';
           }
          else
           { $array_push[$descTable[$i]['Field']] = $url."/gambar/barang/".$row[$descTable[$i]['Field']];
           }
        }
       
       $DataEdit .= "<textarea class='textarea_edit-".$descTable[$i]['Field']."'>".$array_push[$descTable[$i]['Field']]."</textarea>";
     }
    array_push($dataRows, $array_push);
    if(strval(strpos($filter_satuan, "id = '".$row['satuan_id']."'")) == "" && strval($row['satuan_id']) !== "")
     { if($filter_satuan !== "")
        { $filter_satuan .= " or";
        }
       $filter_satuan .= " id = '".$row['satuan_id']."'";
     }

    $lokasi = "../../gambar/barang/".$row['id'];
    if(is_dir($lokasi))
     { $foto = scandir($lokasi);
       $foto = array_values(array_filter($foto, function($var){
        return ($var !== "." && $var !== "..");
       }));
       $DataEdit .= "<textarea class='textarea_edit-file'>".json_encode($foto)."</textarea>";
     }
    else
     { $DataEdit .= "<textarea class='textarea_edit-file'>[]</textarea>";
     }

    $diskon = array();
    if(isset($row['diskon_jenis_customer']) && $row['diskon_jenis_customer'] !== "")
     { $row['diskon_jenis_customer'] = str_replace('}]"', '}]', str_replace('"[{', '[{', $row['diskon_jenis_customer']));
       $diskon = json_decode($row['diskon_jenis_customer'], true);
     }
    $DataEdit .= "<div class='div_diskon'>";
    foreach($diskon as $key => $value)
     { $DataEdit .= "<textarea class='div_diskon-jenis_customer_id'>".$value['jenis_customer_id']."</textarea>
                     <textarea class='div_diskon-diskon_item_detail'>".json_encode($value['diskon_item_detail'])."</textarea>";
     }
    $DataEdit .= "</div>";
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
  { $satuan = "";
    $index = array_search($dataRows[$i]['satuan_id'], array_column($arraySatuan, 'id'));
    if(strval($index) !== "")
     { $satuan = $arraySatuan[$index]['satuan'];
     }
    echo "<tr>
           <td style='padding:2px 4px 2px 4px;'>".$dataRows[$i]['kode']."</td>
           <td style='padding:2px 4px 2px 4px;'>".$dataRows[$i]['nama']."</td>
           <td style='padding:2px 4px 2px 4px;'>".$dataRows[$i]['merek']."</td>
           <td style='padding:2px 4px 2px 4px;'>".$dataRows[$i]['model']."</td>
           <td style='padding:2px 4px 2px 4px;'>".$dataRows[$i]['tipe']."</td>
           <td style='padding:2px 4px 2px 4px;'>".$dataRows[$i]['jenis']."</td>
           <td style='padding:2px 4px 2px 4px;'>".$satuan."</td>
           <td style='padding:2px 4px 2px 4px; text-align:right;'>".$dataRows[$i]['harga_jual']."</td>
           <td style='padding:2px 4px 2px 4px; text-align:center;'>
            <button type='button' class='btn btn-default view' title='View' onclick='view(this);'><i class='fa fa-search'></i></button>
            <button type='button' class='btn btn-default edit' title='Edit' onclick='edit(this);'><i class='fa fa-edit'></i></button>
            <button type='button' class='btn btn-default hapus' title='Hapus' onclick='konfirmasiHapus(this);'><i class='fa fa-trash'></i></button>
           </td>
          </tr>";
  }

 echo " </table>Menampilkan ".count($dataRows)." dari ".$nListView." record";

 echo "<div style='display:none;'>".$DataEdit."</div>";

?>