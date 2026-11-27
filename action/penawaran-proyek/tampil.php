<?php

 include("../bjksadkhrej121lkjkjk.php");

 $lokasi_folder = "../export/";
 if(!is_dir($lokasi_folder))
  { mkdir($lokasi_folder, 0755);
  }
 $lokasi_folder .= $username."/";
 if(!is_dir($lokasi_folder))
  { mkdir($lokasi_folder, 0755);
  }
 $lokasi_folder .= "penawaran/";
 if(!is_dir($lokasi_folder))
  { mkdir($lokasi_folder, 0755);
  }
 deleteDirectory($lokasi_folder);

 $queryFilter = " where cabang_id = '".intval($_POST['cabng_id'])."'";
 if(isset($_POST['filter']) && ($_POST['filter'] !== "" || $_POST['filter'] !== "[]"))
  { $filter = json_decode($_POST['filter'], true);
    for($i=0; $i<count($filter); $i++)
     { if($filter[$i]['field'] == "penawaran.tanggal")
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
         <th style='padding:2px 4px 2px 4px; min-width:100px;'>Tanggal</th>
         <th style='padding:2px 4px 2px 4px; min-width:100px;'>No. Penawaran</th>
         <th style='padding:2px 4px 2px 4px; min-width:200px;'>Customer</th>
         <th style='padding:2px 4px 2px 4px; min-width:200px;'>Alamat Customer</th>
         <th style='padding:2px 4px 2px 4px; text-align:center; width:150px; max-width:150px; min-width:150px;'>Total</th>
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

 $dataRows = array();
 $DataEdit = "";
 $limit = $halaman * $_POST['maxRecord'];
 $start = $limit - $_POST['maxRecord'];
 $query = "select ".$_POST['Nama_Tabel'].".*, concat(".$_POST['Nama_Tabel'].".kode, '/', lpad(".$_POST['Nama_Tabel'].".nomor, if(3 > length(".$_POST['Nama_Tabel'].".nomor), 3, length(".$_POST['Nama_Tabel'].".nomor)), '0'), '/MIE/', to_roman(month(tanggal)), '/', ".$_POST['Nama_Tabel'].".tahun) as nomor_penawaran from ".$_POST['Nama_Tabel'].$queryFilter." order by ".$_POST['Nama_Tabel'].".tanggal desc, ".$_POST['Nama_Tabel'].".id desc limit ".$_POST['maxRecord']." offset ".$start;
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $array_push = array();
    $array_push['nomor_penawaran'] = $row['nomor_penawaran'];
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
    $DataEdit .= "<textarea class='textarea_edit-nomor_penawaran'>".$array_push['nomor_penawaran']."</textarea>";
    $detail = array();
    if(isset($row['detail']) && $row['detail'] !== "")
     { $detail = json_decode($row['detail'], true);
     }
    $kelompok = array();
    for($i=0; $i<count($detail); $i++)
     { $index = array_search($detail[$i]['no_kelompok'], array_column($kelompok, 'no_kelompok'));
       if(strval($index) == "")
        { array_push($kelompok, array(
           "no_kelompok" => $detail[$i]['no_kelompok'],
           "nama_kelompok" => $detail[$i]['nama_kelompok'],
           "detail" => array(),
          ));
          $index = count($kelompok) - 1;
        }
       array_push($kelompok[$index]['detail'], array(
        "id" => $detail[$i]['id'],
        "penawaran_proyek_id" => $detail[$i]['penawaran_proyek_id'],
        "uraian" => $detail[$i]['uraian'],
        "jumlah" => $detail[$i]['jumlah'],
        "satuan" => $detail[$i]['satuan'],
        "harga" => $detail[$i]['harga'],
        "total" => $detail[$i]['total'],
       ));
     }
    $array_push['detail'] = $kelompok;
    array_push($dataRows, $array_push);

    $no_telp_customer = array();
    if(isset($row['no_telp_customer']) && $row['no_telp_customer'] !== "")
     { $no_telp_customer = json_decode($row['no_telp_customer'], true);
     }
    $DataEdit .= "<div class='detail-no_telp_customer'>";
    foreach($no_telp_customer as $key => $value)
     { foreach($value as $key2 => $value2)
        { $DataEdit .= '<textarea class="detail-no_telp_customer-'.$key2.'">'.$value2.'</textarea>';
        }
     }
    $DataEdit .= "</div>";

    $no_wa_customer = array();
    if(isset($row['no_wa_customer']) && $row['no_wa_customer'] !== "")
     { $no_wa_customer = json_decode($row['no_wa_customer'], true);
     }
    $DataEdit .= "<div class='detail-no_wa_customer'>";
    foreach($no_wa_customer as $key => $value)
     { foreach($value as $key2 => $value2)
        { $DataEdit .= '<textarea class="detail-no_wa_customer-'.$key2.'">'.$value2.'</textarea>';
        }
     }
    $DataEdit .= "</div>";

    $email_customer = array();
    if(isset($row['email_customer']) && $row['email_customer'] !== "")
     { $email_customer = json_decode($row['email_customer'], true);
     }
    $DataEdit .= "<div class='detail-email_customer'>";
    foreach($email_customer as $key => $value)
     { foreach($value as $key2 => $value2)
        { $DataEdit .= '<textarea class="detail-email_customer-'.$key2.'">'.$value2.'</textarea>';
        }
     }
    $DataEdit .= "</div>";
  }

 for($i=0; $i<count($dataRows); $i++)
  { echo "<tr>
           <td style='padding:2px 4px 2px 4px;'>".$dataRows[$i]['tanggal']."</td>
           <td style='padding:2px 4px 2px 4px;'>".$dataRows[$i]['nomor_penawaran']."</td>
           <td style='padding:2px 4px 2px 4px;'>".$dataRows[$i]['nama_customer']."</td>
           <td style='padding:2px 4px 2px 4px;'>".$dataRows[$i]['alamat_customer']."</td>
           <td style='padding:2px 4px 2px 4px; text-align:right;'>".$dataRows[$i]['total']."</td>
           <td style='padding:2px 4px 2px 4px; text-align:center;'>
            <button type='button' class='btn btn-default view' title='View' onclick='view(this);'><i class='fa fa-search'></i></button>
            <button type='button' class='btn btn-default edit' title='Edit' onclick='edit(this);'><i class='fa fa-edit'></i></button>
            <button type='button' class='btn btn-default hapus' title='Hapus' onclick='konfirmasiHapus(this);'><i class='fa fa-trash'></i></button>
           </td>
           <td style='padding:2px 4px 2px 4px; text-align:center;'>
            <button type='button' class='btn btn-danger cetak' title='Cetak' onclick='cetak(this);'><i class='fa fa-file-pdf-o'></i></button>
           </td>
          </tr>";
    $DataEdit .= "<div class='div-detail_kelompok'>";
    for($j=0; $j<count($dataRows[$i]['detail']); $j++)
     { $DataEdit .= "<textarea class='detail_kelompok-nama_kelompok'>".$dataRows[$i]['detail'][$j]['nama_kelompok']."</textarea>
                     <div class='detail_kelompok-detail_barang'>";
       for($k=0; $k<count($dataRows[$i]['detail'][$j]['detail']); $k++)
        { $DataEdit .= "<textarea class='detail_barang-id'>".$dataRows[$i]['detail'][$j]['detail'][$k]['id']."</textarea>
                        <textarea class='detail_barang-uraian'>".$dataRows[$i]['detail'][$j]['detail'][$k]['uraian']."</textarea>
                        <textarea class='detail_barang-jumlah'>".formatAngka($dataRows[$i]['detail'][$j]['detail'][$k]['jumlah'])."</textarea>
                        <textarea class='detail_barang-satuan'>".$dataRows[$i]['detail'][$j]['detail'][$k]['satuan']."</textarea>
                        <textarea class='detail_barang-harga'>".formatAngka($dataRows[$i]['detail'][$j]['detail'][$k]['harga'])."</textarea>
                        <textarea class='detail_barang-total'>".formatAngka($dataRows[$i]['detail'][$j]['detail'][$k]['total'])."</textarea>";
        }
       $DataEdit .= "</div>";
     }
    $DataEdit .= "</div>";
  }

 echo " </table>Menampilkan ".count($dataRows)." dari ".$nListView." record";

 echo "<div style='display:none;'>".$DataEdit."</div>";

?>