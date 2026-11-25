<?php

 include("../bjksadkhrej121lkjkjk.php");

 $penjualan_id = $_POST['penjualan_id'] ?? null;

 $detail_other = array();
 if(isset($_POST['detail_other']) && $_POST['detail_other'] !== "")
  { $detail_other = json_decode($_POST['detail_other'], true);
  }

 $detail_selected = array();
 if(isset($_POST['detail_selected']) && $_POST['detail_selected'] !== "")
  { $detail_selected = json_decode($_POST['detail_selected'], true);
  }

 date_default_timezone_set('Asia/Jakarta');
 $info = getdate();
 $date = $info['mday'];
 $month = $info['mon'];
 $year = $info['year'];
 $hour = $info['hours'];
 $min = $info['minutes'];
 $sec = $info['seconds'];
 $now = $year."-".str_pad($month,2,"0",STR_PAD_LEFT)."-".str_pad($date,2,"0",STR_PAD_LEFT)." ".str_pad($hour,2,"0",STR_PAD_LEFT).":".str_pad($min,2,"0",STR_PAD_LEFT).":".str_pad($sec,2,"0",STR_PAD_LEFT);

 $queryFilter = " where pembelian_detail.barang_id = '".intval($_POST['barang_id'])."'";
 if(isset($_POST['cari']) && $_POST['cari'] !== "")
  { $queryFilter .= " and rak.nama_rak like '%".str_replace("'", "\'", $_POST['cari'])."%'";
  }
 $queryFilter .= " and (ifnull(barang_masuk_detail.jumlah, 0) > ifnull(barang_masuk_detail.terjual, 0) or barang_masuk_detail.id in (select barang_masuk_detail_id from penjualan_detail_ditandai where penjualan_detail_id in (select id from penjualan_detail where penjualan_id = ".intval($penjualan_id).")))";

 $nhalaman = 1;
 $halaman = 1;
 if(isset($_POST['halaman']) && $_POST['halaman'] !== "")
  { $halaman = $_POST['halaman'];
  }

 $nListView = 0;
 $query = "select count(*) as jlh from barang_masuk_detail left join barang_masuk on barang_masuk_detail.barang_masuk_id = barang_masuk.id left join pembelian_detail on barang_masuk_detail.pembelian_detail_id = pembelian_detail.id left join barang on pembelian_detail.barang_id = barang.id left join satuan on barang.satuan_id = satuan.id left join rak on barang_masuk_detail.rak_id = rak.id left join gudang on rak.gudang_id = gudang.id".$queryFilter;
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

 echo "<input type='hidden' id='txthalamanbarangmasukdetail' value='".$halaman."'>
       <input type='hidden' id='txtnhalamanbarangmasukdetail' value='".$nhalaman."'>
       <select style='display:none;' id='temp-preview-halaman-barang-masuk-detail'>".$option_halaman."</select>";

 echo "<table class='table table-bordered table-hover' style='margin-top:5px; margin-bottom:5px;'>
        <thead>
         <tr>
          <th style='padding:2px 4px 2px 4px;'>Gudang</th>
          <th style='padding:2px 4px 2px 4px;'>Tanggal</th>
          <th style='padding:2px 4px 2px 4px;'>No. Pembelian</th>
          <th style='padding:2px 4px 2px 4px;'>Harga</th>
          <th style='padding:2px 4px 2px 4px;'>Rak</th>
          <th style='padding:2px 4px 2px 4px; text-align:center; width:150px; min-width:150px; max-width:150px;'>Jumlah</th>
          <th style='padding:2px 4px 2px 4px; text-align:center; width:150px; min-width:150px; max-width:150px;'>Tandai</th>
         </tr>
        </thead>
        <tbody>";

 $dataRows = array();
 $DataEdit = "";
 $limit = $halaman * $_POST['maxRecord'];
 $start = $limit - $_POST['maxRecord'];
 $query = "select barang_masuk_detail.id, gudang.nama as gudang, barang_masuk_detail.barang_masuk_id, barang_masuk.tanggal, concat(pembelian.kode, right(year(pembelian.tanggal), 2), lpad(month(pembelian.tanggal), 2, '0'), lpad(day(pembelian.tanggal), 2, '0'), '-MIE-', lpad(pembelian.nomor, if(3 > length(pembelian.nomor), 3, length(pembelian.nomor)), '0') ) as nomor_pembelian, ifnull(pembelian_detail.dpp, 0) / ifnull(pembelian_detail.jumlah, 0) as harga, barang_masuk.sumber, rak.nama_rak, rak.karantina, pembelian_detail.barang_id, barang.kode, barang.nama, barang.merek, barang.model, barang.tipe, barang.jenis, satuan.satuan, barang_masuk_detail.dikirim, (ifnull(barang_masuk_detail.jumlah, 0) - ifnull(barang_masuk_detail.terjual, 0)) as tersedia from barang_masuk_detail left join barang_masuk on barang_masuk_detail.barang_masuk_id = barang_masuk.id left join pembelian_detail on barang_masuk_detail.pembelian_detail_id = pembelian_detail.id left join pembelian on pembelian_detail.pembelian_id = pembelian.id left join barang on pembelian_detail.barang_id = barang.id left join satuan on barang.satuan_id = satuan.id left join rak on barang_masuk_detail.rak_id = rak.id left join gudang on rak.gudang_id = gudang.id".$queryFilter." order by barang_masuk.tanggal desc, barang_masuk.id desc limit ".$_POST['maxRecord']." offset ".$start;
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $array_push = array();

    $barang_masuk_detail_id = $row['id'];
    
    $other_cart = 0;
    $search = array_filter($detail_other, function($var) use($barang_masuk_detail_id) {
     return ($var['barang_masuk_detail_id'] == $barang_masuk_detail_id);
    });
    foreach($search as $key => $value)
     { $other_cart += $value['jumlah'] * 1;
     }
    
    $selected_cart = 0;
    $search = array_filter($detail_selected, function($var) use($barang_masuk_detail_id) {
     return ($var['barang_masuk_detail_id'] == $barang_masuk_detail_id);
    });
    foreach($search as $key => $value)
     { $selected_cart += $value['jumlah'] * 1;
     }

    $row['tersedia'] = $row['tersedia'] - $other_cart + $selected_cart;
    $row['selected_cart'] = $selected_cart;

    foreach($row as $field => $value)
     { if(!is_numeric($field))
        { if($field == "tersedia")
           { $value = number_format($value, 2, ",", ".");
           }
          if(isset($row[$field]) && $row[$field] !== "")
           { $array_push[$field] = $row[$field];
           }
          else
           { $array_push[$field] = null;
           }
          $DataEdit .= "<textarea class='textarea_barang_masuk_detail-".$field."'>".$value."</textarea>";
        }
     }
    array_push($dataRows, $array_push);
  }

 for($i=0; $i<count($dataRows); $i++)
  { $selected_cart = "";
    if($dataRows[$i]['selected_cart'] > 0)
     { $selected_cart = number_format($dataRows[$i]['selected_cart'], 2, ",", ".");
     }

    $readOnly = "";
    if($dataRows[$i]['karantina'] == "1")
     { $readOnly = " readOnly";
     }
    echo "<tr>
           <td style='padding:2px 4px 2px 4px;'>".$dataRows[$i]['gudang']."</td>
           <td style='padding:2px 4px 2px 4px;'>".date('d-m-Y', strtotime($dataRows[$i]['tanggal']))."</td>
           <td style='padding:2px 4px 2px 4px;'>".$dataRows[$i]['nomor_pembelian']."</td>
           <td style='padding:2px 4px 2px 4px; text-align:right'>".formatAngka($dataRows[$i]['harga'])."</td>
           <td style='padding:2px 4px 2px 4px;'>".$dataRows[$i]['nama_rak']."</td>
           <td style='padding:2px 4px 2px 4px; text-align:right;'>".number_format($dataRows[$i]['tersedia'], 2, ",", ".")."</td>
           <td style='padding:2px 4px 2px 4px;'>
            <input type='text' autocomplete='new-password' class='form-control tandai' onkeypress='return hanyaAngka(this);' onkeyup='addTandai(this);' onchange='addTandai(this);' onfocus='this.select();' onfocusout='fnomor2(this);' style='text-align:right;' value='".$selected_cart."'".$readOnly.">
           </td>
          </tr>";
  }

 echo "  </tbody>
        </table>Menampilkan ".count($dataRows)." dari ".$nListView." record";

 //Tampilan ListView---------------------------------------------------------------------------------------------------------------------------------------------

 echo "<div style='display:none;'>".$DataEdit."</div>";

?>