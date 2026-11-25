<?php

 include("../bjksadkhrej121lkjkjk.php");
 include("../../design/url.php");

 $queryFilter = " where ifnull(barang_masuk_detail.jumlah, 0) - ifnull(barang_masuk_detail.dikirim, 0) > 0 and barang_masuk_detail.rak_id in (select id from rak where gudang_id = '".intval($_POST['gudang_id'])."')";

 $nhalaman = 1;
 $halaman = 1;
 if(isset($_POST['halaman']) && $_POST['halaman'] !== "")
  { $halaman = $_POST['halaman'];
  }

 $nListView = 0;
 $query = "select count(*) as jlh from barang_masuk_detail left join barang_masuk on barang_masuk_detail.barang_masuk_id = barang_masuk.id left join pembelian_detail on barang_masuk_detail.pembelian_detail_id = pembelian_detail.id left join pembelian on pembelian_detail.pembelian_id = pembelian.id left join barang on pembelian_detail.barang_id = barang.id left join satuan on barang.satuan_id = satuan.id left join rak on barang_masuk_detail.rak_id = rak.id".$queryFilter;
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

 echo "<table class='table table-bordered table-hover' style='margin-top:5px; margin-bottom:5px;'>
        <thead>
         <tr>
          <th style='padding:4px 4px 4px 4px;'>Tanggal Masuk</th>
          <th style='padding:4px 4px 4px 4px;'>Nama Barang</th>
          <th style='padding:4px 4px 4px 4px;'>Rak</th>
          <th style='padding:4px 4px 4px 4px; text-align:center; width:150px; max-width:150px; min-width:150px;'>Jumlah Barang</th>
          <th style='padding:4px 4px 4px 4px; text-align:center; width:150px; max-width:150px; min-width:150px;'>Jumlah Stok</th>
         </tr>
        </thead>
        <tbody>";

 $dataRows = array();
 $DataEdit = "";
 $limit = $halaman * $_POST['maxRecord'];
 $start = $limit - $_POST['maxRecord'];
 $query = "select barang_masuk_detail.id, barang_masuk.tanggal, barang.kode, barang.nama, barang.merek, barang.model, barang.tipe, barang.jenis, satuan.satuan, rak.nama_rak, ifnull(barang_masuk_detail.jumlah, 0) - ifnull(barang_masuk_detail.terjual, 0) as jumlah_stok, ifnull(barang_masuk_detail.jumlah, 0) - ifnull(barang_masuk_detail.dikirim, 0) as jumlah_barang from barang_masuk_detail left join barang_masuk on barang_masuk_detail.barang_masuk_id = barang_masuk.id left join pembelian_detail on barang_masuk_detail.pembelian_detail_id = pembelian_detail.id left join pembelian on pembelian_detail.pembelian_id = pembelian.id left join barang on pembelian_detail.barang_id = barang.id left join satuan on barang.satuan_id = satuan.id left join rak on barang_masuk_detail.rak_id = rak.id".$queryFilter." order by barang_masuk.tanggal desc limit ".$_POST['maxRecord']." offset ".$start;
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $array_push = array();
    foreach($row as $field => $value)
     { if(!is_numeric($field))
        { $value = $row[$field];
          if(isset($row[$field]) && $row[$field] !== "")
           { $array_push[$field] = $value;
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
  { $nama_barang = $dataRows[$i]['kode']." - ".$dataRows[$i]['nama'];
    if(isset($dataRows[$i]['merek']) && $dataRows[$i]['merek'] !== "")
     { $nama_barang .= " ".$dataRows[$i]['merek'];
     }
    if(isset($dataRows[$i]['model']) && $dataRows[$i]['model'] !== "")
     { $nama_barang .= " ".$dataRows[$i]['model'];
     }
    if(isset($dataRows[$i]['tipe']) && $dataRows[$i]['tipe'] !== "")
     { $nama_barang .= " ".$dataRows[$i]['tipe'];
     }
    echo "<tr>
           <td style='padding:4px 4px 4px 4px;'>".$dataRows[$i]['tanggal']."</td>
           <td style='padding:4px 4px 4px 4px;'>".$nama_barang."</td>
           <td style='padding:4px 4px 4px 4px;'>".$dataRows[$i]['nama_rak']."</td>
           <td style='padding:4px 4px 4px 4px; text-align:right; color:blue; cursor:pointer;' class='pilih-barang' onclick='pilihBarang(this);'>".number_format($dataRows[$i]['jumlah_barang'], 2, ",", ".")."</td>
           <td style='padding:4px 4px 4px 4px; text-align:right;'>".number_format($dataRows[$i]['jumlah_stok'], 2, ",", ".")."</td>
          </tr>";
  }

 echo " </tbody></table>Menampilkan ".count($dataRows)." dari ".$nListView." record";

 echo "<div style='display:none;'>".$DataEdit."</div>";

?>