<?php

 include("../bjksadkhrej121lkjkjk.php");

 $telah_ditandai = array();
 if(isset($_POST['telah_ditandai']) && $_POST['telah_ditandai'] !== "")
  { $telah_ditandai = json_decode($_POST['telah_ditandai'], true);
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

 $queryFilter = " where ifnull(penjualan_detail.penjualan_id, '') <> '".intval($_POST['penjualan_id'])."' and ifnull(penjualan_detail_ditandai.jumlah, 0) > ifnull(penjualan_detail_ditandai.dikirim, 0)";
 if(isset($_POST['cari']) && $_POST['cari'] !== "")
  { $queryFilter .= " and (concat(penjualan.kode, ' ', lpad(penjualan.nomor, if(3 > length(penjualan.nomor), 3, length(penjualan.nomor)), '0'), '/', right(penjualan.tahun, 2)) like '%".str_replace("'", "\'", $_POST['cari'])."%' or customer.nama like '%".str_replace("'", "\'", $_POST['cari'])."%' or rak.nama_rak like '%".str_replace("'", "\'", $_POST['cari'])."%')";
  }

 $nhalaman = 1;
 $halaman = 1;
 if(isset($_POST['halaman']) && $_POST['halaman'] !== "")
  { $halaman = $_POST['halaman'];
  }

 $nListView = 0;
 $query = "select count(*) as jlh from penjualan_detail_ditandai left join penjualan_detail on penjualan_detail_ditandai.penjualan_detail_id = penjualan_detail.id left join penjualan on penjualan_detail.penjualan_id = penjualan.id left join customer on penjualan.customer_id = customer.id left join barang_masuk_detail on penjualan_detail_ditandai.barang_masuk_detail_id = barang_masuk_detail.id left join rak on barang_masuk_detail.rak_id = rak.id left join gudang on rak.gudang_id = gudang.id".$queryFilter;
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

 echo "<input type='hidden' id='txthalamanpenjualandetailditandai' value='".$halaman."'>
       <input type='hidden' id='txtnhalamanpenjualandetailditandai' value='".$nhalaman."'>
       <select style='display:none;' id='temp-preview-halaman-penjualan-detail-ditandai'>".$option_halaman."</select>";

 echo "<table class='table table-bordered table-hover' style='margin-top:5px; margin-bottom:5px;'>
        <thead>
         <tr>
          <th style='padding:2px 4px 2px 4px;'>Gudang</th>
          <th style='padding:2px 4px 2px 4px;'>Tanggal</th>
          <th style='padding:2px 4px 2px 4px;'>No. Penjualan</th>
          <th style='padding:2px 4px 2px 4px;'>Customer</th>
          <th style='padding:2px 4px 2px 4px;'>Rak</th>
          <th style='padding:2px 4px 2px 4px; width:120px; min-width:120px; max-width:120px; text-align:center;'>Ditandai</th>
          <th style='padding:2px 4px 2px 4px;'>Dikirim</th>
         </tr>
        </thead>
        <tbody>";

 $dataRows = array();
 $DataEdit = "";
 $limit = $halaman * $_POST['maxRecord'];
 $start = $limit - $_POST['maxRecord'];
 $query = "select penjualan_detail_ditandai.id, gudang.nama as gudang, penjualan_detail_ditandai.penjualan_detail_id, penjualan_detail.penjualan_id, penjualan.tanggal, concat(penjualan.kode, ' ', lpad(penjualan.nomor, if(3 > length(penjualan.nomor), 3, length(penjualan.nomor)), '0'), '/', right(penjualan.tahun, 2)) as nomor_penjualan, customer.nama, rak.nama_rak, penjualan_detail_ditandai.jumlah, penjualan_detail_ditandai.dikirim from penjualan_detail_ditandai left join penjualan_detail on penjualan_detail_ditandai.penjualan_detail_id = penjualan_detail.id left join penjualan on penjualan_detail.penjualan_id = penjualan.id left join customer on penjualan.customer_id = customer.id left join barang_masuk_detail on penjualan_detail_ditandai.barang_masuk_detail_id = barang_masuk_detail.id left join rak on barang_masuk_detail.rak_id = rak.id left join gudang on rak.gudang_id = gudang.id".$queryFilter." limit ".$_POST['maxRecord']." offset ".$start;
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $array_push = array();
    foreach($row as $field => $value)
     { if(!is_numeric($field))
        { if($field == "jumlah" || $field == "dikirim")
           { $value = number_format(isset($value) ? $value : 0, 2, ",", ".");
           }
          if(isset($row[$field]) && $row[$field] !== "")
           { if($field == "tanggal")
              { $value = date('d-m-Y', strtotime($value));
              }
             $array_push[$field] = $value;
           }
          else
           { $array_push[$field] = null;
           }
          $DataEdit .= "<textarea class='textarea_penjualan_detail_ditandai-".$field."'>".$value."</textarea>";
        }
     }
    array_push($dataRows, $array_push);
  }

 for($i=0; $i<count($dataRows); $i++)
  { $index = array_search($dataRows[$i]['id'], array_column($telah_ditandai, 'id'));
    if(strval($index) !== "")
     { $dataRows[$i]['jumlah'] = number_format($telah_ditandai[$index]['jumlah'], 2, ",", ".");
     }
    echo "<tr>
           <td style='padding:2px 4px 2px 4px;'>".$dataRows[$i]['gudang']."</td>
           <td style='padding:2px 4px 2px 4px;'>".$dataRows[$i]['tanggal']."</td>
           <td style='padding:2px 4px 2px 4px;'>".$dataRows[$i]['nomor_penjualan']."</td>
           <td style='padding:2px 4px 2px 4px;'>".$dataRows[$i]['nama']."</td>
           <td style='padding:2px 4px 2px 4px;'>".$dataRows[$i]['nama_rak']."</td>
           <td style='padding:2px 4px 2px 4px;'>
            <input type='text' autocomplete='new-password' class='form-control telah-ditandai' onkeypress='return hanyaAngka(this);' onkeyup='changeTelahDitandai(this);' onchange='changeTelahDitandai(this);' onfocus='this.select();' onfocusout='fnomor2(this);' style='text-align:right;' value='".$dataRows[$i]['jumlah']."'>
           </td>
           <td style='padding:2px 4px 2px 4px; text-align:right;'>".$dataRows[$i]['dikirim']."</td>
          </tr>";
  }

 echo "  </tbody>
        </table>Menampilkan ".count($dataRows)." dari ".$nListView." record";

 //Tampilan ListView---------------------------------------------------------------------------------------------------------------------------------------------

 echo "<div style='display:none;'>".$DataEdit."</div>";

?>