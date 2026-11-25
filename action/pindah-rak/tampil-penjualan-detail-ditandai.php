<?php

 include("../bjksadkhrej121lkjkjk.php");
 include("../../design/url.php");

 $pindah_rak = array();
 if(isset($_POST['pindah_rak']) && $_POST['pindah_rak'] !== "")
  { $pindah_rak = json_decode($_POST['pindah_rak'], true);
  }

 $queryFilter = " where penjualan_detail_ditandai.barang_masuk_detail_id = '".intval($_POST['barang_masuk_detail_id'])."' and ifnull(penjualan_detail_ditandai.jumlah, 0) > ifnull(penjualan_detail_ditandai.dikirim, 0)";

 $nhalaman = 1;
 $halaman = 1;
 if(isset($_POST['halaman']) && $_POST['halaman'] !== "")
  { $halaman = $_POST['halaman'];
  }

 $nListView = 0;
 $tersedia = $_POST['jumlah_barang'] * 1;
 $query = "select count(*) as jlh, ifnull(sum(ifnull(penjualan_detail_ditandai.jumlah, 0) - ifnull(penjualan_detail_ditandai.dikirim, 0)), 0) as tersedia from penjualan_detail_ditandai left join penjualan_detail on penjualan_detail_ditandai.penjualan_detail_id = penjualan_detail.id left join penjualan on penjualan_detail.penjualan_id = penjualan.id left join customer on penjualan.customer_id = customer.id".$queryFilter;
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $nListView = $row['jlh'];
    $tersedia -= $row['tersedia'];
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

 echo "<input type='hidden' id='txthalamanpenjualandetailditandai' value='".$halaman."'>
       <input type='hidden' id='txtnhalamanpenjualandetailditandai' value='".$nhalaman."'>
       <select style='display:none;' id='temp-preview-halaman-penjualan-detail-ditandai'>".$option_halaman."</select>";

 echo "<table class='table table-bordered table-hover' style='margin-top:5px; margin-bottom:5px;'>
        <thead>
         <tr>
          <th style='padding:4px 4px 4px 4px; width:100px; min-width:100px; max-width:100px;'>Tanggal Penjualan</th>
          <th style='padding:4px 4px 4px 4px;'>Nomor Penjualan</th>
          <th style='padding:4px 4px 4px 4px;'>Customer</th>
          <th style='padding:4px 4px 4px 4px; text-align:center; width:150px; min-width:150px; max-width:150px;'>Tersedia</th>
          <th style='padding:4px 4px 4px 4px; text-align:center; width:150px; min-width:150px; max-width:150px;'>Pindahkan</th>
         </tr>
        </thead>
        <tbody>";

 $dataRows = array();
 $DataEdit = "";
 $limit = $halaman * $_POST['maxRecord'];
 $start = $limit - $_POST['maxRecord'];
 $query = "select penjualan_detail_ditandai.id, penjualan.tanggal, concat(penjualan.kode, ' ', lpad(penjualan.nomor, if(3 > length(penjualan.nomor), 3, length(penjualan.nomor)), '0'), '/', right(penjualan.tahun, 2)) as nomor_penjualan, customer.nama, ifnull(penjualan_detail_ditandai.jumlah, 0) - ifnull(penjualan_detail_ditandai.dikirim, 0) as tersedia from penjualan_detail_ditandai left join penjualan_detail on penjualan_detail_ditandai.penjualan_detail_id = penjualan_detail.id left join penjualan on penjualan_detail.penjualan_id = penjualan.id left join customer on penjualan.customer_id = customer.id".$queryFilter." order by penjualan.tanggal desc limit ".$_POST['maxRecord']." offset ".$start;
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $array_push = array();
    foreach($row as $field => $value)
     { if(!is_numeric($field))
        { $value = $row[$field];
          if($field == "jumlah_barang" || $field == "jumlah_stok" || $field == "tersedia")
           { $value = number_format($value, 2, ",", ".");
           }
          if($field == "tanggal")
           { $value = date('d-m-Y', strtotime($value));
           }
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
  { $jumlah = "";
    $index = array_search(intval($dataRows[$i]['id'])." - ".intval($_POST['barang_masuk_detail_id']), array_column($pindah_rak, 'key'));
    if(strval($index) !== "")
     { if($pindah_rak[$index]['jumlah'] > 0)
        { $jumlah = number_format($pindah_rak[$index]['jumlah'], 2, ",", ".");
        }
     }
    echo "<tr>
           <td style='padding:4px 4px 4px 4px;'>".$dataRows[$i]['tanggal']."</td>
           <td style='padding:4px 4px 4px 4px;'>".$dataRows[$i]['nomor_penjualan']."</td>
           <td style='padding:4px 4px 4px 4px;'>".$dataRows[$i]['nama']."</td>
           <td style='padding:4px 4px 4px 4px; text-align:right;'>".$dataRows[$i]['tersedia']."</td>
           <td style='padding:4px 4px 4px 4px;'>
            <input type='text' class='form-control pindahkan' onkeypress='return hanyaAngka(this);' onkeyup='setPindahkan(this, ".intval($dataRows[$i]['id']).", ".intval($_POST['barang_masuk_detail_id']).");' onchange='setPindahkan(this, ".intval($dataRows[$i]['id']).", ".intval($_POST['barang_masuk_detail_id']).");' onfocus='this.select();' onfocusout='fnomor2(this);' style='text-align:right;' value='".$jumlah."'>
           </td>
          </tr>";
  }

 if($tersedia > 0)
  { $jumlah = "";
    $index = array_search("0 - ".intval($_POST['barang_masuk_detail_id']), array_column($pindah_rak, 'key'));
    if(strval($index) !== "")
     { if($pindah_rak[$index]['jumlah'] > 0)
        { $jumlah = number_format($pindah_rak[$index]['jumlah'], 2, ",", ".");
        }
     }
    echo "<tr>
           <td style='padding:4px 4px 4px 4px;' colspan='3'>Belum Terjual</td>
           <td style='padding:4px 4px 4px 4px; text-align:right;'>".number_format($tersedia, 2, ",", ".")."</td>
           <td style='padding:4px 4px 4px 4px;'>
            <input type='text' class='form-control pindahkan' onkeypress='return hanyaAngka(this);' onkeyup='setPindahkan(this, null, ".intval($_POST['barang_masuk_detail_id']).");' onchange='setPindahkan(this, null, ".intval($_POST['barang_masuk_detail_id']).");' onfocus='this.select();' onfocusout='fnomor2(this);' style='text-align:right;' value='".$jumlah."'>
           </td>
          </tr>";
  }

 echo " </tbody></table>Menampilkan ".count($dataRows)." dari ".$nListView." record";

 echo "<div style='display:none;'>".$DataEdit."</div>";

?>