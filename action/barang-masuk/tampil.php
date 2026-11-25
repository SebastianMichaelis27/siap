<?php

 include("../bjksadkhrej121lkjkjk.php");

 $queryFilter = " where gudang_id = '".intval($_POST['gudang_id'])."'";
 if(isset($_POST['filter']) && ($_POST['filter'] !== "" || $_POST['filter'] !== "[]"))
  { $filter = json_decode($_POST['filter'], true);
    for($i=0; $i<count($filter); $i++)
     { $queryFilter .= " and concat(".str_replace("'", "\'", $filter[$i]['field']).") like '%".str_replace("'", "\'", trim($filter[$i]['value']))."%'";
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

 //Tampilan ListView---------------------------------------------------------------------------------------------------------------------------------------------

 echo "<input type='hidden' id='txthalaman' value='".$halaman."'>
       <input type='hidden' id='txtnhalaman' value='".$nhalaman."'>
       <select style='display:none;' id='temp-preview-halaman'>".$option_halaman."</select>";

 echo "<table class='table table-bordered' style='margin-top:5px; margin-bottom:5px;'>
        <thead>
         <tr>
          <th style='padding:2px 4px 2px 4px;'>Tanggal</th>
          <th style='padding:2px 4px 2px 4px;'>Gudang</th>
          <th style='padding:2px 4px 2px 4px; text-align:center; width:150px; max-width:150px; min-width:150px;'>Act</th>
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

 $filter_gudang = "";
 $filter_pembelian_detail = "";
 $filter_rak = "";
 $detail = array();
 $dataRows = array();
 $DataEdit = "";
 $limit = $halaman * $_POST['maxRecord'];
 $start = $limit - $_POST['maxRecord'];
 $query = "select * from ".$_POST['Nama_Tabel'].$queryFilter." order by tanggal desc, id desc limit ".$_POST['maxRecord']." offset ".$start;
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $data = array();
    if(isset($row['detail']) && $row['detail'] !== "")
     { $data = json_decode($row['detail'], true);
     }
    for($i=0; $i<count($data); $i++)
     { if(strval(strpos($filter_pembelian_detail, "pembelian_detail.id = '".$data[$i]['pembelian_detail_id']."'")) == "")
        { if($filter_pembelian_detail !== "")
           { $filter_pembelian_detail .= " or";
           }
          $filter_pembelian_detail .= " pembelian_detail.id = '".$data[$i]['pembelian_detail_id']."'";
        }
       if(strval(strpos($filter_rak, "rak.id = '".$data[$i]['rak_id']."'")) == "")
        { if($filter_rak !== "")
           { $filter_rak .= " or";
           }
          $filter_rak .= " rak.id = '".$data[$i]['rak_id']."'";
        }
       $data[$i]['barang_id'] = "";
       $data[$i]['kode'] = "";
       $data[$i]['nama'] = "";
       $data[$i]['merek'] = "";
       $data[$i]['model'] = "";
       $data[$i]['tipe'] = "";
       $data[$i]['jenis'] = "";
       $data[$i]['kapasitas'] = "";
       $data[$i]['btuh'] = "";
       $data[$i]['ukuran'] = "";
       $data[$i]['satuan'] = "";
       $data[$i]['nama_rak'] = "";
     }
    $detail = array_merge($detail, $data);

    $array_push = array();
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
    array_push($dataRows, $array_push);
    if(strval(strpos($filter_gudang, "gudang.id = '".$row['gudang_id']."'")) == "")
     { if($filter_gudang !== "")
        { $filter_gudang .= " or";
        }
       $filter_gudang .= " gudang.id = '".$row['gudang_id']."'";
     }
  }

 if($filter_pembelian_detail !== "")
  { $query = "select barang.*, satuan.satuan, pembelian_detail.id as pembelian_detail_id from pembelian_detail left join barang on pembelian_detail.barang_id = barang.id left join satuan on barang.satuan_id = satuan.id where ".$filter_pembelian_detail;
    $execute = mysqli_query($koneksi, $query);
    while($row = mysqli_fetch_array($execute))
     { $pembelian_detail_id = $row['pembelian_detail_id'];
       $search = array_filter($detail, function($var) use($pembelian_detail_id) {
        return ($var['pembelian_detail_id'] == $pembelian_detail_id);
       });
       foreach($search as $key => $value)
        { $detail[$key]['barang_id'] = $row['id'];
          $detail[$key]['kode'] = $row['kode'];
          $detail[$key]['nama'] = $row['nama'];
          $detail[$key]['merek'] = $row['merek'];
          $detail[$key]['model'] = $row['model'];
          $detail[$key]['tipe'] = $row['tipe'];
          $detail[$key]['jenis'] = $row['jenis'];
          $detail[$key]['kapasitas_pk'] = $row['kapasitas_pk'];
          $detail[$key]['btuh'] = $row['btuh'];
          $detail[$key]['ukuran'] = $row['ukuran'];
          $detail[$key]['satuan'] = $row['satuan'];
        }
     }
  }

 if($filter_rak !== "")
  { $query = "select * from rak where ".$filter_rak;
    $execute = mysqli_query($koneksi, $query);
    while($row = mysqli_fetch_array($execute))
     { $rak_id = $row['id'];
       $search = array_filter($detail, function($var) use($rak_id) {
        return ($var['rak_id'] == $rak_id);
       });
       foreach($search as $key => $value)
        { $detail[$key]['nama_rak'] = $row['nama_rak'];
        }
     }
  }

 $arrayGudang = array();
 if($filter_gudang !== "")
  { $query = "select * from gudang where ".$filter_gudang;
    $execute = mysqli_query($koneksi, $query);
    while($row = mysqli_fetch_array($execute))
     { array_push($arrayGudang, array(
        "id" => $row['id'],
        "nama" => $row['nama'],
       ));
     }
  }

 for($i=0; $i<count($dataRows); $i++)
  { $barang_masuk_id = $dataRows[$i]['id'];
    $search = array_filter($detail, function($var) use($barang_masuk_id) {
     return ($var['barang_masuk_id'] == $barang_masuk_id);
    });
    $group = array();
    foreach($search as $key => $value)
     { $index = array_search($value['barang_id']." - ".$value['rak_id'], array_column($group, 'key'));
       if(strval($index) == "")
        { array_push($group, array(
           "key" => $value['barang_id']." - ".$value['rak_id'],
           "barang_id" => $value['barang_id'],
           "kode" => $value['kode'],
           "nama" => $value['nama'],
           "merek" => $value['merek'],
           "model" => $value['model'],
           "tipe" => $value['tipe'],
           "jenis" => $value['jenis'],
           "kapasitas_pk" => $value['kapasitas_pk'],
           "btuh" => $value['btuh'],
           "ukuran" => $value['ukuran'],
           "satuan" => $value['satuan'],
           "rak_id" => $value['rak_id'],
           "nama_rak" => $value['nama_rak'],
           "jumlah" => $value['jumlah'] * 1,
           "barang_masuk_detail" => array(array(
            "pembelian_detail_id" => strval($value['pembelian_detail_id']),
            "jumlah" => $value['jumlah'] * 1,
           )),
          ));
        }
       else
        { $group[$index]['jumlah'] += $value['jumlah'] * 1;
          array_push($group[$index]['barang_masuk_detail'], array(
           "pembelian_detail_id" => strval($value['pembelian_detail_id']),
           "jumlah" => $value['jumlah'] * 1,
          ));
        }
     }
    $DataEdit .= "<div class='div-detail'>";
    foreach($group as $key => $value)
     { $DataEdit .= "<textarea class='div-detail-barang_id'>".$value['barang_id']."</textarea>";
       $DataEdit .= "<textarea class='div-detail-kode'>".$value['kode']."</textarea>";
       $DataEdit .= "<textarea class='div-detail-nama'>".$value['nama']."</textarea>";
       $DataEdit .= "<textarea class='div-detail-merek'>".$value['merek']."</textarea>";
       $DataEdit .= "<textarea class='div-detail-model'>".$value['model']."</textarea>";
       $DataEdit .= "<textarea class='div-detail-tipe'>".$value['tipe']."</textarea>";
       $DataEdit .= "<textarea class='div-detail-jenis'>".$value['jenis']."</textarea>";
       $DataEdit .= "<textarea class='div-detail-kapasitas_pk'>".$value['kapasitas_pk']."</textarea>";
       $DataEdit .= "<textarea class='div-detail-btuh'>".$value['btuh']."</textarea>";
       $DataEdit .= "<textarea class='div-detail-ukuran'>".formatAngka($value['ukuran'])."</textarea>";
       $DataEdit .= "<textarea class='div-detail-satuan'>".$value['satuan']."</textarea>";
       $DataEdit .= "<textarea class='div-detail-jumlah'>".number_format($value['jumlah'], 2, ",", ".")."</textarea>";
       $DataEdit .= "<select class='div-detail-rak'><option></option><option value='".$value['rak_id']."' selected>".$value['nama_rak']."</option></select>";
       $DataEdit .= "<textarea class='div-detail-barang_masuk_detail'>".json_encode($value['barang_masuk_detail'])."</textarea>";
     }
    $DataEdit .= "</div>";

    $gudang = "";
    $index = array_search($dataRows[$i]['gudang_id'], array_column($arrayGudang, 'id'));
    if(strval($index) !== "")
     { $gudang = $arrayGudang[$index]['nama'];
     }
    echo "<tr>
           <td style='padding:2px 4px 2px 4px;'>".$dataRows[$i]['tanggal']."</td>
           <td style='padding:2px 4px 2px 4px;'>".$gudang."</td>
           <td style='padding:2px 4px 2px 4px; text-align:center;'>
            <button type='button' class='btn btn-default view' title='View' onclick='view(this);'><i class='fa fa-search'></i></button>
            <button type='button' class='btn btn-default edit' title='Edit' onclick='edit(this);'><i class='fa fa-edit'></i></button>
            <button type='button' class='btn btn-default hapus' title='Hapus' onclick='konfirmasiHapus(this);'><i class='fa fa-trash'></i></button>
           </td>
          </tr>";
  }

 echo "  </tbody>
        </table>Menampilkan ".count($dataRows)." dari ".$nListView." record";

 //Tampilan ListView---------------------------------------------------------------------------------------------------------------------------------------------

 echo "<div style='display:none;'>".$DataEdit."</div>";

?>