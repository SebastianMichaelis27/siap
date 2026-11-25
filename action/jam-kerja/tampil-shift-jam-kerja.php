<?php

 include("../bjksadkhrej121lkjkjk.php");

 $queryFilter = "";
 if(isset($_POST['filter']) && ($_POST['filter'] !== "" || $_POST['filter'] !== "[]"))
  { $filter = json_decode($_POST['filter'], true);
    for($i=0; $i<count($filter); $i++)
     { if($queryFilter !== "")
        { $queryFilter .= " and";
        }
       $queryFilter .= " concat(".str_replace("'", "\'", $filter[$i]['field']).") like '%".str_replace("'", "\'", trim($filter[$i]['value']))."%'";
     }
  }
 if($queryFilter !== "")
  { $queryFilter .= " where ".$queryFilter;
  }

 $nhalaman = 1;
 $halaman = 1;
 if(isset($_POST['halaman']) && $_POST['halaman'] !== "")
  { $halaman = $_POST['halaman'];
  }

 $nListView = 0;
 $query = "select count(*) as jlh from shift_jam_kerja".$queryFilter;
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

 echo "<input type='hidden' id='txthalamanshiftjamkerja' value='".$halaman."'>
       <input type='hidden' id='txtnhalamanshiftjamkerja' value='".$nhalaman."'>
       <select style='display:none;' id='temp-preview-halaman-shift-jam-kerja'>".$option_halaman."</select>";

 echo "<table class='table table-bordered' style='margin-top:5px; margin-bottom:5px;'>
        <tr>
         <th style='padding:2px 4px 2px 4px;'>Shift</th>
         <th style='padding:2px 4px 2px 4px; text-align:center; width:100px; max-width:100px; min-width:100px;'>Act</th>
        </tr>";

 $descTable = array();
 $query = "desc shift_jam_kerja";
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
 $query = "select * from shift_jam_kerja".$queryFilter." order by id desc limit ".$_POST['maxRecord']." offset ".$start;
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
       $DataEdit .= "<textarea class='textarea_shift-jam-kerja-".$descTable[$i]['Field']."'>".$array_push[$descTable[$i]['Field']]."</textarea>";
     }
    $DataEdit .= "<textarea class='textarea_shift-masuk_jam'>".date('H', strtotime($row['jam_masuk']))."</textarea>
                  <textarea class='textarea_shift-masuk_menit'>".date('i', strtotime($row['jam_masuk']))."</textarea>
                  <textarea class='textarea_shift-pulang_jam'>".date('H', strtotime($row['jam_pulang']))."</textarea>
                  <textarea class='textarea_shift-pulang_menit'>".date('i', strtotime($row['jam_pulang']))."</textarea>";
    array_push($dataRows, $array_push);
  }

 for($i=0; $i<count($dataRows); $i++)
  { echo "<tr>
           <td style='padding:2px 4px 2px 4px;'>".$dataRows[$i]['shift']."</td>
           <td style='padding:2px 4px 2px 4px; text-align:center;'>
            <button type='button' class='btn btn-default edit-shift-jam-kerja' title='Edit' onclick='editShiftJamKerja(this);'><i class='fa fa-edit'></i></button>
            <button type='button' class='btn btn-default hapus-shift-jam-kerja' title='Hapus' onclick='konfirmasiHapusShiftJamKerja(this);'><i class='fa fa-trash'></i></button>
           </td>
          </tr>";
  }

 echo " </table>Menampilkan ".count($dataRows)." dari ".$nListView." record";

 //Tampilan ListView---------------------------------------------------------------------------------------------------------------------------------------------

 echo "<div style='display:none;'>".$DataEdit."</div>";

?>