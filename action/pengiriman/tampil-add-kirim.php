<?php

 include("../bjksadkhrej121lkjkjk.php");

 $telah_ditandai = array();
 if(isset($_POST['telah_ditandai']) && $_POST['telah_ditandai'] !== "")
  { $telah_ditandai = json_decode($_POST['telah_ditandai'], true);
  }

 $telah_ditandai = array_filter($telah_ditandai, function($var) {
  return ($var['jumlah'] * 1 > $var['dikirim'] * 1);
 });

 if(isset($_POST['cari']) && $_POST['cari'] !== "")
  { $cari = $_POST['cari'];
    $telah_ditandai = array_filter($telah_ditandai, function($var) use($cari) {
     return (strval(strpos($var['nama_rak'], $cari)) !== "");
    });
  }

 $nhalaman = 1;
 $halaman = 1;
 if(isset($_POST['halaman']) && $_POST['halaman'] !== "")
  { $halaman = $_POST['halaman'];
  }

 $nListView = count($telah_ditandai);
 
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

 echo "<input type='hidden' id='txthalamanaddkirim' value='".$halaman."'>
       <input type='hidden' id='txtnhalamanaddkirim' value='".$nhalaman."'>
       <select style='display:none;' id='temp-preview-halaman-add-kirim'>".$option_halaman."</select>";

 echo "<table class='table table-bordered' style='margin-top:5px; margin-bottom:5px;'>
        <thead>
         <tr>
          <th style='padding:2px 4px 2px 4px; width:100px; min-width:100px; max-width:100px;'>Tanggal</th>
          <th style='padding:2px 4px 2px 4px;'>Sumber</th>
          <th style='padding:2px 4px 2px 4px;'>Rak</th>
          <th style='padding:2px 4px 2px 4px; text-align:center; width:120px; max-width:120px; min-width:120px;'>Terjual</th>
          <th style='padding:2px 4px 2px 4px; text-align:center; width:120px; max-width:120px; min-width:120px;'>Terkirim</th>
          <th style='padding:2px 4px 2px 4px; text-align:center; width:120px; max-width:120px; min-width:120px;'>Kirim</th>
         </tr>
        </thead>
        <tbody>";

 $no = 0;
 $DataEdit = "";
 $limit = $halaman * $_POST['maxRecord'];
 $start = $limit - $_POST['maxRecord'];
 for($i=$start; $i<$limit; $i++)
  { if(isset($telah_ditandai[$i]))
     { $no++;
       if($telah_ditandai[$i]['add_kirim'] * 1 > 0)
        { $telah_ditandai[$i]['add_kirim'] = number_format($telah_ditandai[$i]['add_kirim'], 2, ",", ".");
        }
       echo "<tr>
              <td>".date('d-m-Y', strtotime($telah_ditandai[$i]['tanggal_barang_masuk']))."</td>
              <td>".$telah_ditandai[$i]['sumber_barang_masuk']."</td>
              <td>".$telah_ditandai[$i]['nama_rak']."</td>
              <td style='text-align:right;'>".number_format(empty($telah_ditandai[$i]['jumlah']) ? 0 : $telah_ditandai[$i]['jumlah'], 2, ",", ".")."</td>
              <td style='text-align:right;'>".number_format(empty($telah_ditandai[$i]['dikirim']) ? 0 : $telah_ditandai[$i]['dikirim'], 2, ",", ".")."</td>
              <td><input type='text' autocomplete='new-password' class='form-control add-kirim' onkeypress='return hanyaAngka(this);' onkeyup='addKirim(this);' onchange='addKirim(this);' onfocus='this.select();' onfocusout='fnomor2(this);' style='text-align:right;' value='".$telah_ditandai[$i]['add_kirim']."'></td>
             </tr>";
       $DataEdit .= "<textarea class='textarea_add_kirim-penjualan_detail_id'>".$telah_ditandai[$i]['penjualan_detail_id']."</textarea>";
       $DataEdit .= "<textarea class='textarea_add_kirim-barang_masuk_detail_id'>".$telah_ditandai[$i]['barang_masuk_detail_id']."</textarea>";
       $DataEdit .= "<textarea class='textarea_add_kirim-jumlah'>".number_format(empty($telah_ditandai[$i]['jumlah']) ? 0 : $telah_ditandai[$i]['jumlah'], 2, ",", ".")."</textarea>";
       $DataEdit .= "<textarea class='textarea_add_kirim-dikirim'>".number_format(empty($telah_ditandai[$i]['dikirim']) ? 0 : $telah_ditandai[$i]['dikirim'], 2, ",", ".")."</textarea>";
     }
  }

 echo " </tbody>
       </table>Menampilkan ".$no." dari ".$nListView." record
       <div style='display:none'>".$DataEdit."</div>";

?>