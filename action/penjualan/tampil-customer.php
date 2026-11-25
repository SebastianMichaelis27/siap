<?php

 include("../bjksadkhrej121lkjkjk.php");

 $queryFilter = "";
 if(isset($_POST['cari']) && $_POST['cari'] !== "")
  { $queryFilter = " where nama like '%".str_replace("'", "\'", $_POST['cari'])."%'";
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

 echo "<input type='hidden' id='txthalamancustomer' value='".$halaman."'>
       <input type='hidden' id='txtnhalamancustomer' value='".$nhalaman."'>
       <select style='display:none;' id='temp-preview-halaman-customer'>".$option_halaman."</select>";

 echo "<table class='table table-bordered table-hover' style='margin-top:5px; margin-bottom:5px;'>
        <thead>
         <tr>
          <th style='padding:4px 4px 4px 4px;'>Jenis Customer</th>
          <th style='padding:4px 4px 4px 4px;'>Nama</th>
          <th style='padding:4px 4px 4px 4px;'>Alamat</th>
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

 $filter_jenis_customer = "";

 $dataRows = array();
 $DataEdit = "";
 $limit = $halaman * $_POST['maxRecord'];
 $start = $limit - $_POST['maxRecord'];
 $query = "select * from ".$_POST['Nama_Tabel'].$queryFilter." order by id desc limit ".$_POST['maxRecord']." offset ".$start;
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
       $DataEdit .= "<textarea class='textarea_customer-".$descTable[$i]['Field']."'>".$array_push[$descTable[$i]['Field']]."</textarea>";
     }
    array_push($dataRows, $array_push);
    if(strval(strpos($filter_jenis_customer, "id = '".$row['jenis_customer_id']."'")) == "")
     { if($filter_jenis_customer !== "")
        { $filter_jenis_customer .= " or";
        }
       $filter_jenis_customer .= " id = '".$row['jenis_customer_id']."'";
     }

    $no_telp = array();
    if(isset($row['no_telp']) && $row['no_telp'] !== "")
     { $no_telp = json_decode($row['no_telp'], true);
     }
    $DataEdit .= "<div class='detail-no_telp'>";
    foreach($no_telp as $key => $value)
     { foreach($value as $key2 => $value2)
        { $DataEdit .= '<textarea class="detail-no_telp-'.$key2.'">'.$value2.'</textarea>';
        }
     }
    $DataEdit .= "</div>";

    $no_wa = array();
    if(isset($row['no_wa']) && $row['no_wa'] !== "")
     { $no_wa = json_decode($row['no_wa'], true);
     }
    $DataEdit .= "<div class='detail-no_wa'>";
    foreach($no_wa as $key => $value)
     { foreach($value as $key2 => $value2)
        { $DataEdit .= '<textarea class="detail-no_wa-'.$key2.'">'.$value2.'</textarea>';
        }
     }
    $DataEdit .= "</div>";

    $email = array();
    if(isset($row['email']) && $row['email'] !== "")
     { $email = json_decode($row['email'], true);
     }
    $DataEdit .= "<div class='detail-email'>";
    foreach($email as $key => $value)
     { foreach($value as $key2 => $value2)
        { $DataEdit .= '<textarea class="detail-email-'.$key2.'">'.$value2.'</textarea>';
        }
     }
    $DataEdit .= "</div>";
  }

 $arrayJenisCustomer = array();
 if($filter_jenis_customer !== "")
  { $query = "select * from jenis_customer where".$filter_jenis_customer;
    $execute = mysqli_query($koneksi, $query);
    while($row = mysqli_fetch_array($execute))
     { array_push($arrayJenisCustomer, array(
        "id" => $row['id'],
        "jenis_customer" => $row['jenis_customer'],
       ));
     }
  }

 for($i=0; $i<count($dataRows); $i++)
  { $jenis_customer = "";
    $index = array_search($dataRows[$i]['jenis_customer_id'], array_column($arrayJenisCustomer, 'id'));
    if(strval($index) !== "")
     { $jenis_customer = $arrayJenisCustomer[$index]['jenis_customer'];
     }
    echo "<tr style='cursor:pointer;' class='pilih-customer' onclick='pilihCustomer(this);'>
           <td style='padding:4px 4px 4px 4px;'>".$jenis_customer."</td>
           <td style='padding:4px 4px 4px 4px;'>".$dataRows[$i]['nama']."</td>
           <td style='padding:4px 4px 4px 4px;'>".$dataRows[$i]['alamat']."</td>
          </tr>";
  }

 echo "  </tbody>
        </table>Menampilkan ".count($dataRows)." dari ".$nListView." record";

 echo "<div style='display:none;'>".$DataEdit."</div>";

?>