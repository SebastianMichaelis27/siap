<?php

 include("../bjksadkhrej121lkjkjk.php");

 $queryFilter = " where penjualan_id = '".intval($_POST['id'])."'";
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
 $query = "select count(*) as jlh from penjualan_pembayaran".$queryFilter;
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

 echo "<input type='hidden' id='txthalamanpembayaran' value='".$halaman."'>
       <input type='hidden' id='txtnhalamanpembayaran' value='".$nhalaman."'>
       <select style='display:none;' id='temp-preview-halaman-pembayaran'>".$option_halaman."</select>";

 echo "<table class='table table-bordered' style='margin-top:5px; margin-bottom:5px;'>
        <tr>
         <th style='padding:2px 4px 2px 4px; width:100px;'>Tanggal</th>
         <th style='padding:2px 4px 2px 4px;'>Created By</th>
         <th style='padding:2px 4px 2px 4px; text-align:right;'>Nominal</th>
         <th style='padding:2px 4px 2px 4px;'>Metode Pembayaran</th>
         <th style='padding:2px 4px 2px 4px; text-align:center; width:150px;'>Act</th>
        </tr>";

 $descTable = array();
 $query = "desc penjualan_pembayaran";
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { array_push($descTable, array(
     "Field" => $row['Field'],
     "Type" => $row['Type'],
    ));
  }

 $filter_barang = "";
 $filter_penawaran_detail = "";

 $dataRows = array();
 $DataEdit = "";
 $limit = $halaman * $_POST['maxRecord'];
 $start = $limit - $_POST['maxRecord'];
 $query = "select * from penjualan_pembayaran".$queryFilter." order by tanggal asc limit ".$_POST['maxRecord']." offset ".$start;
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $array_push = array();
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
       $DataEdit .= "<textarea class='textarea_pembayaran-".$descTable[$i]['Field']."'>".$array_push[$descTable[$i]['Field']]."</textarea>";
     }
    array_push($dataRows, $array_push);
  }

 $metode_pembayaran_id = array_values(array_unique(array_column($dataRows, 'metode_pembayaran_id')));
 if(count($metode_pembayaran_id) > 0)
  { $placeholders = implode(',', array_fill(0, count($metode_pembayaran_id), '?'));
    $types = str_repeat('i', count($metode_pembayaran_id));

    $execute = $koneksi->prepare("select * from metode_pembayaran where id in (".$placeholders.")");
    $execute->bind_param($types, ...$metode_pembayaran_id);
    $execute->execute();
    $result = $execute->get_result();
    $dataMetodePembayaran = $result->fetch_all(MYSQLI_ASSOC);
    $dataMetodePembayaran = array_column($dataMetodePembayaran, 'metode_pembayaran', 'id');
  }

 for($i=0; $i<count($dataRows); $i++)
  { echo "<tr>
           <td style='padding:2px 4px 2px 4px;'>".$dataRows[$i]['tanggal']."</td>
           <td style='padding:2px 4px 2px 4px;'>".$dataRows[$i]['created_by']."</td>
           <td style='padding:2px 4px 2px 4px; text-align:right;'>".$dataRows[$i]['nominal']."</td>
           <td style='padding:2px 4px 2px 4px;'>".($dataMetodePembayaran[$dataRows[$i]['metode_pembayaran_id']] ?? '')."</td>
           <td style='padding:2px 4px 2px 4px; text-align:center;'>
            <button type='button' class='btn btn-default edit-pembayaran' title='Edit' onclick='editPembayaran(this);'><i class='fa fa-edit'></i></button>
            <button type='button' class='btn btn-default hapus-pembayaran' title='Hapus' onclick='konfirmasiHapusPembayaran(this);'><i class='fa fa-trash'></i></button>
            <button type='button' class='btn btn-danger cetak-kwitansi' title='Kwitansi' onclick='cetakKwitansi(this);'><i class='fa fa-file-pdf-o'></i></button>
           </td>
          </tr>";
  }

 echo " </table>Menampilkan ".count($dataRows)." dari ".$nListView." record";

 echo "<div style='display:none;'>".$DataEdit."</div>";

?>