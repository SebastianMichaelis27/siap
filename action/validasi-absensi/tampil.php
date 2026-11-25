<?php

 include("../bjksadkhrej121lkjkjk.php");

 $queryFilter = " where status = '".intval($_POST['status_verifikasi'])."'";

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

 echo "<input type='hidden' class='halaman' value='".$halaman."'>
       <input type='hidden' class='nhalaman' value='".$nhalaman."'>";

 $descTable = array();
 $query = "desc ".$_POST['Nama_Tabel'];
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { array_push($descTable, array(
     "Field" => $row['Field'],
     "Type" => $row['Type'],
    ));
  }

 $filter_karyawan = "";

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
       $DataEdit .= "<textarea class='textarea_edit-".$descTable[$i]['Field']."'>".$array_push[$descTable[$i]['Field']]."</textarea>";
     }
    array_push($dataRows, $array_push);
    if(strval(strpos($filter_karyawan, " karyawan.id = '".$row['karyawan_id']."'")) == "")
     { if($filter_karyawan !== "")
        { $filter_karyawan .= " or";
        }
       $filter_karyawan .= " karyawan.id = '".$row['karyawan_id']."'";
     }
  }

 $arrayKaryawan = array();
 if($filter_karyawan !== "")
  { $query = "select karyawan.id, karyawan.nik, karyawan.nama, cabang.nama as cabang from karyawan left join cabang on karyawan.cabang_id = cabang.id where".$filter_karyawan;
    $execute = mysqli_query($koneksi, $query);
    while($row = mysqli_fetch_array($execute))
     { array_push($arrayKaryawan, array(
        "id" => $row['id'],
        "nik" => $row['nik'],
        "nama" => $row['nama'],
        "cabang" => $row['cabang'],
       ));
     }
  }

 $status = array();
 $status[0] = "Belum Diverifikasi";
 $status[1] = "Verifikasi Diterima";
 $status[2] = "Verifikasi Ditolak";

 for($i=0; $i<count($dataRows); $i++)
  { $nik = "";
    $nama = "";
    $cabang = "";
    $index = array_search($dataRows[$i]['karyawan_id'], array_column($arrayKaryawan, 'id'));
    if(strval($index) !== "")
     { $nik = $arrayKaryawan[$index]['nik'];
       $nama = $arrayKaryawan[$index]['nama'];
       $cabang = $arrayKaryawan[$index]['cabang'];
     }
    echo "<div class='konfirmasi-validasi' style='background:white; margin-top:5px; margin-bottom:15px; padding:10px;' onclick='konfirmasiValidasi(this);'>
           <div style='display:grid; grid-template-columns:100px 1fr; gap:10px;'>
            <div style='height:100px; background-image:url(\"gambar/absensi/".$dataRows[$i]['id'].".png\"); background-size:cover; background-position:center center; border-radius:50%;'></div>
            <div style='display:grid; grid-template-columns:auto auto 1fr; column-gap:10px;'>
             <div><b>NIK</b></div>
             <div>:</div>
             <div>".$nik."</div>
             <div><b>Nama</b></div>
             <div>:</div>
             <div>".$nama."</div>
             <div><b>Cabang</b></div>
             <div>:</div>
             <div>".$cabang."</div>
             <div><b>".$dataRows[$i]['jenis_absen']."</b></div>
             <div>:</div>
             <div>".$dataRows[$i]['tanggal_waktu']."</div>
             <div><b>Status</b></div>
             <div>:</div>
             <div>".$status[$dataRows[$i]['status']]."</div>
            </div>
           </div>
           <div style='display:none;'>
            <textarea class='temp-id'>".$dataRows[$i]['id']."</textarea>
            <textarea class='temp-nik'>".$nik."</textarea>
            <textarea class='temp-nama'>".$nama."</textarea>
            <textarea class='temp-foto'>gambar/absensi/".$dataRows[$i]['id'].".png</textarea>
            <textarea class='temp-jenis_absensi'>".$dataRows[$i]['jenis_absen']."</textarea>
            <textarea class='temp-tanggal_waktu'>".$dataRows[$i]['tanggal_waktu']."</textarea>
            <textarea class='temp-status'>".intval($dataRows[$i]['status'])."</textarea>
            <textarea class='temp-keterangan'>".$dataRows[$i]['keterangan']."</textarea>
           </div>
          </div>";
  }

 echo "<div style='display:none;'>".$DataEdit."</div>";

?>
<center>
 <div class='loading'>
  <div></div>
  <div>Loading</div>
 </div>
</center>