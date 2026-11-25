<?php

 include("../bjksadkhrej121lkjkjk.php");

 $detail_other = array();
 if(isset($_POST['detail_other']) && $_POST['detail_other'] !== "")
  { $detail_other = json_decode($_POST['detail_other'], true);
  }

 $detail_selected = array();
 if(isset($_POST['detail_selected']) && $_POST['detail_selected'] !== "")
  { $detail_selected = json_decode($_POST['detail_selected'], true);
  }

 $detail_saved = array();
 if(isset($_POST['detail_saved']) && $_POST['detail_saved'] !== "")
  { $detail_saved = json_decode($_POST['detail_saved'], true);
  }

 $queryFilter = " where pembelian_detail.barang_id = '".intval($_POST['barang_id'])."' and ((ifnull(pembelian_detail.jumlah, 0) - ifnull(pembelian_detail.masuk_gudang, 0) - ifnull(pembelian_detail.retur, 0)) > 0 or pembelian_detail.id in (select pembelian_detail_id from barang_masuk_detail where barang_masuk_id = '".intval($_POST['id'])."'))";
 if(isset($_POST['cari']) && $_POST['cari'] !== "")
  { $queryFilter .= " and concat(pembelian.kode, right(year(pembelian.tanggal), 2), lpad(month(pembelian.tanggal), 2, '0'), lpad(day(pembelian.tanggal), 2, '0'), '-MIE-', lpad(pembelian.nomor, if(3 > length(pembelian.nomor), 3, length(pembelian.nomor)), '0') ) like '%".str_replace("'", "\'", trim($_POST['cari']))."%'";
  }

 $nhalaman = 1;
 $halaman = 1;
 if(isset($_POST['halaman']) && $_POST['halaman'] !== "")
  { $halaman = $_POST['halaman'];
  }

 $nListView = 0;
 $query = "select count(*) as jlh from pembelian_detail left join pembelian on pembelian_detail.pembelian_id = pembelian.id left join barang on pembelian_detail.barang_id = barang.id ".$queryFilter;
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

 echo "<input type='hidden' id='txthalamanpembeliandetail' value='".$halaman."'>
       <input type='hidden' id='txtnhalamanpembeliandetail' value='".$nhalaman."'>
       <select style='display:none;' id='temp-preview-halaman-pembelian-detail'>".$option_halaman."</select>";

 echo "<table class='table table-bordered table-hover' style='margin-top:5px; margin-bottom:5px;'>
        <thead>
         <tr>
          <th style='padding:4px 4px 4px 4px;'>Tanggal Pembelian</th>
          <th style='padding:4px 4px 4px 4px;'>Nomor Pembelian</th>
          <th style='padding:4px 4px 4px 4px; text-align:center;'>Tersedia</th>
          <th style='padding:4px 4px 4px 4px; text-align:center; width:150px; min-width:150px; max-width:150px;'>Jumlah</th>
         </tr>
        </thead>
        <tbody>";

 $descTable = array();
 $query = "desc pembelian_detail";
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { array_push($descTable, array(
     "Field" => $row['Field'],
     "Type" => $row['Type'],
    ));
  }
 array_push($descTable,
  array(
     "Field" => "tanggal",
     "Type" => "date",
  ),
  array(
     "Field" => "kode",
     "Type" => "varchar(225)",
  ),
  array(
     "Field" => "nama",
     "Type" => "varchar(225)",
  ),
  array(
     "Field" => "merek",
     "Type" => "varchar(225)",
  ),
  array(
     "Field" => "model",
     "Type" => "varchar(225)",
  ),
 );

 $dataRows = array();
 $DataEdit = "";
 $limit = $halaman * $_POST['maxRecord'];
 $start = $limit - $_POST['maxRecord'];
 $query = "select pembelian_detail.*, (ifnull(pembelian_detail.jumlah, 0) - ifnull(pembelian_detail.masuk_gudang, 0) - ifnull(pembelian_detail.retur, 0)) as tersedia, pembelian.tanggal, pembelian.tahun, concat(pembelian.kode, right(year(pembelian.tanggal), 2), lpad(month(pembelian.tanggal), 2, '0'), lpad(day(pembelian.tanggal), 2, '0'), '-MIE-', lpad(pembelian.nomor, if(3 > length(pembelian.nomor), 3, length(pembelian.nomor)), '0') ) as nomor_pembelian from pembelian_detail left join pembelian on pembelian_detail.pembelian_id = pembelian.id left join barang on pembelian_detail.barang_id = barang.id ".$queryFilter." order by pembelian.tanggal desc, barang.nama asc limit ".$_POST['maxRecord']." offset ".$start;
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $pembelian_detail_id = $row['id'];
    
    $other_cart = 0;
    $search = array_filter($detail_other, function($var) use($pembelian_detail_id) {
     return ($var['pembelian_detail_id'] == $pembelian_detail_id);
    });
    foreach($search as $key => $value)
     { $other_cart += $value['jumlah'] * 1;
     }
    
    $selected_cart = 0;
    $search = array_filter($detail_selected, function($var) use($pembelian_detail_id) {
     return ($var['pembelian_detail_id'] == $pembelian_detail_id);
    });
    foreach($search as $key => $value)
     { $selected_cart += $value['jumlah'] * 1;
     }

    $jumlah_saved = 0;
    $search = array_filter($detail_saved, function($var) use($pembelian_detail_id) {
     return ($var['pembelian_detail_id'] == $pembelian_detail_id);
    });
    foreach($search as $key => $value)
     { $jumlah_saved += $value['jumlah'] * 1;
     }

    $array_push = array();
    $array_push['nomor_pembelian'] = $row['nomor_pembelian'];
    $array_push['tersedia'] = $row['tersedia'] - $other_cart + $jumlah_saved;
    $array_push['selected_cart'] = $selected_cart;
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
       $DataEdit .= "<textarea class='textarea_pembelian_detail-".$descTable[$i]['Field']."'>".$array_push[$descTable[$i]['Field']]."</textarea>";
     }
    $DataEdit .= "<textarea class='textarea_pembelian_detail-tersedia'>".$array_push['tersedia']."</textarea>";
    array_push($dataRows, $array_push);
  }

 for($i=0; $i<count($dataRows); $i++)
  { $selected_cart = "";
    if($dataRows[$i]['selected_cart'] > 0)
     { $selected_cart = number_format($dataRows[$i]['selected_cart'], 2, ",", ".");
     }
    echo "<tr>
           <td style='padding:4px 4px 4px 4px;'>".$dataRows[$i]['tanggal']."</td>
           <td style='padding:4px 4px 4px 4px;'>".$dataRows[$i]['nomor_pembelian']."</td>
           <td style='padding:4px 4px 4px 4px; text-align:right;'>".number_format($dataRows[$i]['tersedia'], 2, ",", ".")."</td>
           <td style='padding:4px 4px 4px 4px;'>
            <input type='text' class='form-control change-jumlah' onkeypress='return hanyaAngka(this);' onkeyup='changeJumlah(this);' onchange='changeJumlah(this);' onfocus='this.select();' onfocusout='fnomor2(this);' style='text-align:right;' value='".$selected_cart."'>
           </td>
          </tr>";
  }

 echo "  </tbody>
        </table>Menampilkan ".count($dataRows)." dari ".$nListView." record";

 //Tampilan ListView---------------------------------------------------------------------------------------------------------------------------------------------

 echo "<div style='display:none;'>".$DataEdit."</div>";

?>