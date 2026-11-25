<?php

 include("../bjksadkhrej121lkjkjk.php");

 $queryFilter = "";
 if(isset($_POST['cabang_id_']) && $_POST['cabang_id_'] !== "")
  { if($queryFilter !== "")
     { $queryFilter .= " and ";
     }
    else
     { $queryFilter .= " where ";
     }
    $queryFilter .= " cabang_id = ".intval($_POST['cabang_id_']);
  }
 if(isset($_POST['dari']) && $_POST['dari'] !== "")
  { if($queryFilter !== "")
     { $queryFilter .= " and ";
     }
    else
     { $queryFilter .= " where ";
     }
    $queryFilter .= " tanggal >= '".date('Y-m-d', strtotime($_POST['dari']))."'";
  }
 if(isset($_POST['sampai']) && $_POST['sampai'] !== "")
  { if($queryFilter !== "")
     { $queryFilter .= " and ";
     }
    else
     { $queryFilter .= " where ";
     }
    $queryFilter .= " tanggal <= '".date('Y-m-d', strtotime($_POST['sampai']))."'";
  }
 if($queryFilter !== "")
  { $queryFilter .= " and ";
  }
 else
  { $queryFilter .= " where ";
  }
 $queryFilter .= " id in (select penjualan_id from penjualan_detail where ifnull(pesanan_detail_id, '') <> '')";

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
         <th style='padding:2px 4px 2px 4px;'>Tanggal</th>
         <th style='padding:2px 4px 2px 4px;'>Nomor Pesanan</th>
         <th style='padding:2px 4px 2px 4px;'>Nomor Penjualan</th>
         <th style='padding:2px 4px 2px 4px;'>Customer</th>
         <th style='padding:2px 4px 2px 4px; text-align:center; width:150px; max-width:150px; min-width:150px;'>Total</th>
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

 $filter_pesanan_detail = "";

 $dataRows = array();
 $pesanan_detail_id = array();
 $DataEdit = "";
 $limit = $halaman * $_POST['maxRecord'];
 $start = $limit - $_POST['maxRecord'];
 $query = "select ".$_POST['Nama_Tabel'].".*, concat(".$_POST['Nama_Tabel'].".kode, right(year(".$_POST['Nama_Tabel'].".tanggal), 2), lpad(month(".$_POST['Nama_Tabel'].".tanggal), 2, '0'), lpad(day(".$_POST['Nama_Tabel'].".tanggal), 2, '0'), '-MIE-', lpad(".$_POST['Nama_Tabel'].".nomor, if(3 > length(".$_POST['Nama_Tabel'].".nomor), 3, length(".$_POST['Nama_Tabel'].".nomor)), '0') ) as nomor_penjualan from ".$_POST['Nama_Tabel'].$queryFilter." order by id desc limit ".$_POST['maxRecord']." offset ".$start;
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $array_push = array();
    $array_push['nomor_penjualan'] = $row['nomor_penjualan'];
    $array_push['diskon_faktur'] = $row['diskon'];
    $array_push['nominal_ppn'] = $row['ppn'];
    $array_push['total_order'] = $row['total'];
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
    $DataEdit .= "<textarea class='textarea_edit-nomor_penjualan'>".$array_push['nomor_penjualan']."</textarea>";
    $detail = array();
    if(isset($row['detail']) && strval($row['detail']) !== "")
     { $detail = json_decode($row['detail'], true);
     }
    if(!is_array($detail))
     { $detail = array();
     }
    $array_push['pesanan_detail_id'] = array_column($detail ?? array(), 'pesanan_detail_id');
    $pesanan_detail_id = array_values(array_unique(array_merge($pesanan_detail_id, array_column($detail ?? array(), 'pesanan_detail_id'))));

    $array_push['detail'] = $detail;
    array_push($dataRows, $array_push);
    foreach($detail as $key => $value)
     { if(strval(strpos($filter_pesanan_detail, "pesanan_detail.id = '".$value['pesanan_detail_id']."'")) == "")
        { if($filter_pesanan_detail !== "")
           { $filter_pesanan_detail .= " or";
           }
          $filter_pesanan_detail .= " pesanan_detail.id = '".$value['pesanan_detail_id']."'";
        }
     }

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

 $dataPesananDetail = array();
 if(count($pesanan_detail_id) > 0)
  { $placeholders = implode(',', array_fill(0, count($pesanan_detail_id), '?'));
    $types = str_repeat('i', count($pesanan_detail_id));

    $execute = $koneksi->prepare("select pesanan_detail.id as pesanan_detail_id, concat(pesanan.kode, '/', lpad(pesanan.nomor, if(3 > length(pesanan.nomor), 3, length(pesanan.nomor)), '0'), '/MIE/', to_roman(month(tanggal)), '/', pesanan.tahun) as nomor_pesanan from pesanan_detail left join pesanan on pesanan_detail.pesanan_id = pesanan.id where pesanan_detail.id in (".$placeholders.")");
    $execute->bind_param($types, ...$pesanan_detail_id);
    $execute->execute();
    $result = $execute->get_result();
    $dataPesananDetail = $result->fetch_all(MYSQLI_ASSOC);
  }

 $arrayPesananDetail = array();
 if($filter_pesanan_detail !== "")
  { $query = "select pesanan_detail.id, concat(pesanan.kode, ' ', lpad(pesanan.nomor, if(3 > length(pesanan.nomor), 3, length(pesanan.nomor)), '0'), '/', right(pesanan.tahun, 2)) as nomor_pesanan, pesanan.nomor_po, pesanan.tahun from pesanan_detail left join pesanan on pesanan_detail.pesanan_id = pesanan.id where".$filter_pesanan_detail;
    $execute = mysqli_query($koneksi, $query);
    while($row = mysqli_fetch_array($execute))
     { array_push($arrayPesananDetail, array(
        "id" => $row['id'],
        "nomor_pesanan" => $row['nomor_pesanan'],
        "nomor_po" => $row['nomor_po'],
       ));
     }
  }

 for($i=0; $i<count($dataRows); $i++)
  { $nomor_pesanan = '';
    foreach($dataRows[$i]['pesanan_detail_id'] as $key => $value)
     { $index = array_search($value, array_column($dataPesananDetail, 'pesanan_detail_id'));
       if(strval($index) !== "")
        { if($nomor_pesanan !== "")
           { $nomor_pesanan .= "<br>";
           }
          $nomor_pesanan .= $dataPesananDetail[$index]['nomor_pesanan'];
        }
     }

    echo "<tr>
           <td style='padding:2px 4px 2px 4px;'>".$dataRows[$i]['tanggal']."</td>
           <td style='padding:2px 4px 2px 4px;'>".$nomor_pesanan."</td>
           <td style='padding:2px 4px 2px 4px;'>".$dataRows[$i]['nomor_penjualan']."</td>
           <td style='padding:2px 4px 2px 4px;'>".$dataRows[$i]['nama_customer']."</td>
           <td style='padding:2px 4px 2px 4px; text-align:right;'>".$dataRows[$i]['total']."</td>
           </td>
          </tr>";

  }

 echo " </table>Menampilkan ".count($dataRows)." dari ".$nListView." record";

 echo "<div style='display:none;'>".$DataEdit."</div>";

?>