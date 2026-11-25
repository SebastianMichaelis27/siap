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

 $jenis_customer_id = "";
 if(isset($_POST['customer_id']) && $_POST['customer_id'] !== "")
  { $query = "select jenis_customer_id from customer where id = '".intval($_POST['customer_id'])."'";
    $execute = mysqli_query($koneksi, $query);
    while($row = mysqli_fetch_array($execute))
     { $jenis_customer_id = $row['jenis_customer_id'];
     }
  }

 $queryFilter = "";
 if(isset($_POST['cari']) && $_POST['cari'] !== "")
  { $queryFilter .= " where (kode like '%".str_replace("'", "\'", trim($_POST['cari']))."%' or nama like '%".str_replace("'", "\'", trim($_POST['cari']))."%' or merek like '%".str_replace("'", "\'", trim($_POST['cari']))."%')";
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

 //Tampilan ListView--------------------------------------------------------------------------------------------------------------

 echo "<input type='hidden' id='txthalamanbarang' value='".$halaman."'>
       <input type='hidden' id='txtnhalamanbarang' value='".$nhalaman."'>
       <select style='display:none;' id='temp-preview-halaman-barang'>".$option_halaman."</select>";

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
 $filter_pembelian_detail = "";

 $dataRows = array();
 $DataEdit = "";
 $limit = $halaman * $_POST['maxRecord'];
 $start = $limit - $_POST['maxRecord'];
 $query = "select * from ".$_POST['Nama_Tabel'].$queryFilter." order by nama asc, kode asc limit ".$_POST['maxRecord']." offset ".$start;
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $array_push = array();
    for($i=0; $i<count($descTable); $i++)
     { if(isset($row[$descTable[$i]['Field']]) && $row[$descTable[$i]['Field']] !== "")
        { if($descTable[$i]['Type'] == "decimal(20,2)" || $descTable[$i]['Type'] == "decimal(10,2)")
           { $array_push[$descTable[$i]['Field']] = formatAngka($row[$descTable[$i]['Field']]);
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
       $DataEdit .= "<textarea class='textarea_barang-".$descTable[$i]['Field']."'>".$array_push[$descTable[$i]['Field']]."</textarea>";
     }

    $array_push['diskon'] = "";
    $array_push['diskon_item_detail'] = array();
    $diskon_jenis_customer = array();
    if(isset($row['diskon_jenis_customer']) && $row['diskon_jenis_customer'] !== "")
     { $row['diskon_jenis_customer'] = str_replace('}]"', '}]', str_replace('"[{', '[{', $row['diskon_jenis_customer']));
       $diskon_jenis_customer = json_decode($row['diskon_jenis_customer'], true);
     }
    $index = array_search($jenis_customer_id, array_column($diskon_jenis_customer, 'jenis_customer_id'));
    if(strval($index) !== "")
     { $array_push['diskon_item_detail'] = $diskon_jenis_customer[$index]['diskon_item_detail'];
     }

    for($i=0; $i<count($array_push['diskon_item_detail']); $i++)
     { $item_diskon = $array_push['diskon_item_detail'][$i]['jumlah']."%";
       if($array_push['diskon_item_detail'][$i]['jenis'] == "Rp")
        { $item_diskon = "Rp".number_format($array_push['diskon_item_detail'][$i]['jumlah'], 2, ",", ".");
        }
       if($array_push['diskon'] !== "")
        { $array_push['diskon'] .= " + ";
        }
       $array_push['diskon'] .= $item_diskon;
     }

    $DataEdit .= "<textarea class='textarea_barang-diskon_item_detail'>".json_encode($array_push['diskon_item_detail'])."</textarea>";

    array_push($dataRows, $array_push);
    if(strval(strpos($filter_satuan, "id = '".$row['satuan_id']."'")) == "" && strval($row['satuan_id']) !== "")
     { if($filter_satuan !== "")
        { $filter_satuan .= " or";
        }
       $filter_satuan .= " id = '".$row['satuan_id']."'";
     }
    if(strval(strpos($filter_pembelian_detail, "pembelian_detail.barang_id = '".$row['id']."'")) == "" && strval($row['id']) !== "")
     { if($filter_pembelian_detail !== "")
        { $filter_pembelian_detail .= " or";
        }
       $filter_pembelian_detail .= " pembelian_detail.barang_id = '".$row['id']."'";
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

 $arrayBarangMasukDetail = array(); 
 if($filter_pembelian_detail !== "")
  { $query = "select barang_masuk_detail.*, pembelian_detail.barang_id from barang_masuk_detail left join pembelian_detail on barang_masuk_detail.pembelian_detail_id = pembelian_detail.id where".$filter_pembelian_detail;
    $execute = mysqli_query($koneksi, $query);
    while($row = mysqli_fetch_array($execute))
     { $stok = $row['jumlah'] - $row['terjual'] - $row['mutasi'] - $row['retur'] - $row['rusak'] - $row['hilang'];
       $index = array_search($row['barang_id'], array_column($arrayBarangMasukDetail, 'barang_id'));
       if(strval($index) == "")
        { array_push($arrayBarangMasukDetail, array(
           "barang_id" => $row['barang_id'],
           "stok" => $stok,
          ));
        }
       else
        { $arrayBarangMasukDetail[$index]['stok'] += $stok;
        }
     }
  }

 echo "<div class='kontainer'>";

 for($i=0; $i<count($dataRows); $i++)
  { $satuan = "";
    $index = array_search($dataRows[$i]['satuan_id'], array_column($arraySatuan, 'id'));
    if(strval($index) !== "")
     { $satuan = $arraySatuan[$index]['satuan'];
     }

    $DataEdit .= "<div class='list_foto'>";
    $foto = "dist/img/no_image.jpg";
    if(is_dir("../../gambar/barang/".$dataRows[$i]['id']))
     { $file = scandir("../../gambar/barang/".$dataRows[$i]['id']);
       $file = array_values(array_filter($file, function($var) {
        return ($var !== '.' && $var !== '..');
       }));
       if(count($file) > 0)
        { $foto = "gambar/barang/".$dataRows[$i]['id']."/".$file[0];
        }
       for($j=0; $j<count($file); $j++)
        { $DataEdit .= "<textarea>gambar/barang/".$dataRows[$i]['id']."/".$file[$j]."</textarea>";
        }
     }
    $DataEdit .= "</div>";

    $stok = null;
    $index = array_search($dataRows[$i]['id'], array_column($arrayBarangMasukDetail, 'barang_id'));
    if(strval($index) !== "")
     { if(isDecimal($arrayBarangMasukDetail[$index]['stok']))
        { $stok = number_format($arrayBarangMasukDetail[$index]['stok'], 2, ",", ".");
        }
       else
        { $stok = number_format($arrayBarangMasukDetail[$index]['stok'], 0, ",", ".");
        }
     }

    $DataEdit .= "<textarea class='textarea_barang-satuan'>".$satuan."</textarea>";

    echo "<div class='produk'>
           <div class='detail'>
            <div>
             <img src='".$foto."' style='width:100%;'>
             <div class='row'>
              <div class='col-md-3'>
               <label>Kode</label>
              </div>
              <div class='col-md-9'>
               ".$dataRows[$i]['kode']."
              </div>
             </div>
             <div class='row'>
              <div class='col-md-3'>
               <label>Nama</label>
              </div>
              <div class='col-md-9'>
               ".$dataRows[$i]['nama']."
              </div>
             </div>
            </div>
            <div>
             <div class='row'>
              <div class='col-md-3'>
               <label>Merek</label>
              </div>
              <div class='col-md-9'>
               ".$dataRows[$i]['merek']."
              </div>
             </div>
             <div class='row'>
              <div class='col-md-3'>
               <label>Model</label>
              </div>
              <div class='col-md-9'>
               ".$dataRows[$i]['model']."
              </div>
             </div>
             <div class='row'>
              <div class='col-md-3'>
               <label>Tipe</label>
              </div>
              <div class='col-md-9'>
               ".$dataRows[$i]['tipe']."
              </div>
             </div>
             <div class='row'>
              <div class='col-md-3'>
               <label>Jenis</label>
              </div>
              <div class='col-md-9'>
               ".$dataRows[$i]['jenis']."
              </div>
             </div>
             <div class='row'>
              <div class='col-md-3'>
               <label>PK</label>
              </div>
              <div class='col-md-9' style='text-align:right;'>
               ".$dataRows[$i]['kapasitas_pk']."
              </div>
             </div>
             <div class='row'>
              <div class='col-md-5'>
               <label>BTU/H</label>
              </div>
              <div class='col-md-7' style='text-align:right;'>
               ".$dataRows[$i]['btuh']."
              </div>
             </div>
             <div class='row'>
              <div class='col-md-5'>
               <label>Ukuran</label>
              </div>
              <div class='col-md-7'>
               ".(strval($dataRows[$i]['ukuran']) !== "" ? $dataRows[$i]['ukuran']." ".$satuan : "")."
              </div>
             </div>
             <div class='row'>
              <div class='col-md-5'>
               <label>Harga</label>
              </div>
              <div class='col-md-7' style='text-align:right;'>
               ".$dataRows[$i]['harga_jual']."
              </div>
             </div>
             <div class='row'>
              <div class='col-md-5'>
               <label>Diskon</label>
              </div>
              <div class='col-md-7' style='text-align:right;'>
               ".$dataRows[$i]['diskon']."
              </div>
             </div>
             <div class='row'>
              <div class='col-md-3'>
               <label>Stok</label>
              </div>
              <div class='col-md-9' style='text-align:right;'>
               ".$stok." ".$satuan."
              </div>
             </div>
            </div>
           </div>
           <div style='display:grid; grid-template-columns:1fr 1fr; gap:5px; margin-top:5px;'>
            <button type='button' class='btn btn-default lihat-gambar' onclick='lihatGambar(this);'><i class='fa fa-file-image-o'></i> Lihat Gambar</button>
            <button type='button' class='btn btn-success pilih-barang' onclick='pilihBarang(this);'><i class='fa fa-plus'></i> Tambahkan</button>
           </div>
          </div>";
  }

 //Tampilan ListView--------------------------------------------------------------------------------------------------------------

 echo "</div>
       <div style='display:none;'>".$DataEdit."</div>";

?>