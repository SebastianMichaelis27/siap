<?php

 include("../bjksadkhrej121lkjkjk.php");

 $queryFilter = " where users_level_id = '0'";
 if(isset($_POST['users_level_id']) && $_POST['users_level_id'] == "1")
  { $queryFilter = " where users_level_id = '1' or users_level_id = '2' or users_level_id = '3'";
  }
 if(isset($_POST['users_level_id']) && $_POST['users_level_id'] == "2")
  { $queryFilter = " where users_level_id = '3'";
  }

 $filter = "";
 if(isset($_POST['filter']) && ($_POST['filter'] !== "" || $_POST['filter'] !== "[]"))
  { $filter = json_decode($_POST['filter']);
    for($i=0; $i<count($filter); $i++)
     { $queryFilter .= " and concat(".$filter[$i]->field.") like '%".$filter[$i]->value."%'";
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

 //Tampilan ListView---------------------------------------------------------------------------------------------------------------------------------------------

 echo "<input type='hidden' id='txthalaman' value='".$halaman."'>
       <input type='hidden' id='txtnhalaman' value='".$nhalaman."'>
       <select style='display:none;' id='temp-preview-halaman'>".$option_halaman."</select>";

 echo "<table class='table table-bordered' style='margin-top:5px; margin-bottom:5px;'>
        <thead>
         <tr>
          <th style='padding:2px 4px 2px 4px;'>Username</th>
          <th style='padding:2px 4px 2px 4px;'>Level</th>
          <th style='padding:2px 4px 2px 4px;'>Cabang</th>
          <th style='padding:2px 4px 2px 4px;'>Karyawan</th>
          <th style='padding:2px 4px 2px 4px; text-align:center; width:100px;'>Act</th>
         </tr>
        </thead>
        <tbody>";

 $descTable = array();
 $query = "desc ".$_POST['Nama_Tabel'];
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { array_push($descTable, array(
     "Field" => $row['Field'],
     "Type" => $row['Type'],
    ));
  }

 $filter_cabang = "";
 $filter_karyawan = "";
 $dataRows = array();
 $DataEdit = "";
 $limit = $halaman * $_POST['maxRecord'];
 $start = $limit - $_POST['maxRecord'];
 $query = "select username, aes_decrypt(unhex(password), 'Kjsd902Jks97161h1kd') as password, users_level_id, cabang_id, karyawan_id from ".$_POST['Nama_Tabel'].$queryFilter." order by username asc limit ".$_POST['maxRecord']." offset ".$start;
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
       $DataEdit .= "<textarea class='textarea_edit-".$descTable[$i]['Field']."'>".$array_push[$descTable[$i]['Field']]."</textarea>";
     }
    array_push($dataRows, $array_push);
    if(strval(strpos($filter_cabang, "id = '".$row['cabang_id']."'")) == "")
     { if($filter_cabang == "")
        { $filter_cabang .= " id = '".$row['cabang_id']."'";
        }
       else
        { $filter_cabang .= " or id = '".$row['cabang_id']."'";
        }
     }
    if(strval(strpos($filter_karyawan, "id = '".$row['karyawan_id']."'")) == "")
     { if($filter_karyawan == "")
        { $filter_karyawan .= " id = '".$row['karyawan_id']."'";
        }
       else
        { $filter_karyawan .= " or id = '".$row['karyawan_id']."'";
        }
     }
  }

 $arrayUsersLevel = array();
 $query = "select * from users_level";
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { array_push($arrayUsersLevel, array(
     "id" => $row['id'],
     "level" => $row['level'],
    ));
  }

 $arrayCabang = array();
 if($filter_cabang !== "")
  { $query = "select * from cabang where".$filter_cabang;
    $execute = mysqli_query($koneksi, $query);
    while($row = mysqli_fetch_array($execute))
     { array_push($arrayCabang, array(
        "id" => $row['id'],
        "nama" => $row['nama'],
       ));
     }
  }

 $arrayKaryawan = array();
 if($filter_karyawan !== "")
  { $query = "select * from karyawan where".$filter_karyawan;
    $execute = mysqli_query($koneksi, $query);
    while($row = mysqli_fetch_array($execute))
     { array_push($arrayKaryawan, array(
        "id" => $row['id'],
        "nik" => $row['nik'],
        "nama" => $row['nama'],
       ));
     }
  }

 for($i=0; $i<count($dataRows); $i++)
  { $level = "";
    $id = array_search($dataRows[$i]['users_level_id'], array_column($arrayUsersLevel, 'id'));
    if(strval($id) !== "")
     { $level = $arrayUsersLevel[$id]['level'];
     }
    $cabang = "";
    $index = array_search($dataRows[$i]['cabang_id'], array_column($arrayCabang, 'id'));
    if(strval($index) !== "")
     { $cabang = $arrayCabang[$index]['nama'];
     }
    $karyawan = "";
    $index = array_search($dataRows[$i]['karyawan_id'], array_column($arrayKaryawan, 'id'));
    if(strval($index) !== "")
     { $karyawan = $arrayKaryawan[$index]['nama'];
     }
    echo "<tr>
           <td style='padding:2px 4px 2px 4px;'>".$dataRows[$i]['username']."</td>
           <td style='padding:2px 4px 2px 4px;'>".$level."</td>
           <td style='padding:2px 4px 2px 4px;'>".$cabang."</td>
           <td style='padding:2px 4px 2px 4px;'>".$karyawan."</td>
           <td style='padding:2px 4px 2px 4px; text-align:center;'>
            <button type='button' class='btn btn-default edit' title='Edit' onclick='edit(this);'><i class='fa fa-edit'></i></button>
            <button type='button' class='btn btn-default hapus' title='Hapus' onclick='konfirmasiHapus(this);'><i class='fa fa-trash'></i></button>
           </td>
          </tr>";
  }

 echo "  </body>
        </table>
       </div>Menampilkan ".count($dataRows)." dari ".$nListView." record";

 //Tampilan ListView---------------------------------------------------------------------------------------------------------------------------------------------

 echo "<div style='display:none;'>".$DataEdit."</div>";

?>