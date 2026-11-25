<?php

 include("../bjksadkhrej121lkjkjk.php");

 $queryFilter = " where cabang_id = '".intval($_POST['cabng_id'])."' and id in (select penjualan_id from penjualan_detail where ifnull(jumlah, 0) > ifnull(jumlah_dikirim, 0))";
 if(isset($_POST['cari']) && $_POST['cari'] !== "")
  { $queryFilter .= " and (concat(".$_POST['Nama_Tabel'].".kode, ' ', lpad(".$_POST['Nama_Tabel'].".nomor, if(3 > length(".$_POST['Nama_Tabel'].".nomor), 3, length(".$_POST['Nama_Tabel'].".nomor)), '0'), '/', right(".$_POST['Nama_Tabel'].".tahun, 2)) like '%".str_replace("'", "\'", $_POST['cari'])."%' or customer_id in (select id from customer where nama like '%".str_replace("'", "\'", $_POST['cari'])."%'))";
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

 echo "<input type='hidden' id='txthalamanpenjualan' value='".$halaman."'>
       <input type='hidden' id='txtnhalamanpenjualan' value='".$nhalaman."'>
       <select style='display:none;' id='temp-preview-halaman-penjualan'>".$option_halaman."</select>";

 echo "<table class='table table-bordered table-hover' style='margin-top:5px; margin-bottom:5px;'>
        <thead>
         <tr>
          <th style='padding:6px 4px 6px 4px;'>Nomor Penjualan</th>
          <th style='padding:6px 4px 6px 4px;'>Customer</th>
          <th style='padding:6px 4px 6px 4px;'>Alamat Customer</th>
          <th style='padding:6px 4px 6px 4px; text-align:center; width:150px; max-width:150px; min-width:150px;'>Total</th>
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

 $filter_barang = "";
 $filter_pesanan_detail = "";
 $filter_barang_masuk_detail = "";

 $dataRows = array();
 $DataEdit = "";
 $limit = $halaman * $_POST['maxRecord'];
 $start = $limit - $_POST['maxRecord'];
 $query = "select ".$_POST['Nama_Tabel'].".*, concat(".$_POST['Nama_Tabel'].".kode, ' ', lpad(".$_POST['Nama_Tabel'].".nomor, if(3 > length(".$_POST['Nama_Tabel'].".nomor), 3, length(".$_POST['Nama_Tabel'].".nomor)), '0'), '/', right(".$_POST['Nama_Tabel'].".tahun, 2)) as nomor_penjualan from ".$_POST['Nama_Tabel'].$queryFilter." order by id desc limit ".$_POST['maxRecord']." offset ".$start;
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $array_push = array();
    $array_push['nomor_penjualan'] = $row['nomor_penjualan'];
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
       $DataEdit .= "<textarea class='textarea_penjualan-".$descTable[$i]['Field']."'>".$array_push[$descTable[$i]['Field']]."</textarea>";
     }
    $DataEdit .= "<textarea class='textarea_penjualan-nomor_penjualan'>".$array_push['nomor_penjualan']."</textarea>";
    $detail = array();
    if(isset($row['detail']) && $row['detail'] !== "")
     { $detail = json_decode($row['detail'], true);
     }
    $array_push['detail'] = $detail;
    array_push($dataRows, $array_push);
    foreach($detail as $key => $value)
     { if(strval(strpos($filter_barang, "barang.id = '".$value['barang_id']."'")) == "")
        { if($filter_barang !== "")
           { $filter_barang .= " or";
           }
          $filter_barang .= " barang.id = '".$value['barang_id']."'";
        }
       if(strval(strpos($filter_pesanan_detail, "pesanan_detail.id = '".$value['pesanan_detail_id']."'")) == "")
        { if($filter_pesanan_detail !== "")
           { $filter_pesanan_detail .= " or";
           }
          $filter_pesanan_detail .= " pesanan_detail.id = '".$value['pesanan_detail_id']."'";
        }

       foreach($value['ditandai'] as $index => $ditandai)
        { if(strval(strpos($filter_barang_masuk_detail, "barang_masuk_detail.id = '".$ditandai['barang_masuk_detail_id']."'")) == "")
           { if($filter_barang_masuk_detail !== "")
              { $filter_barang_masuk_detail .= " or";
              }
             $filter_barang_masuk_detail .= " barang_masuk_detail.id = '".$ditandai['barang_masuk_detail_id']."'";
           }
        }
     }
  }

 $arrayBarang = array();
 if($filter_barang !== "")
  { $query = "select barang.*, satuan.satuan from barang left join satuan on barang.satuan_id = satuan.id where".$filter_barang;
    $execute = mysqli_query($koneksi, $query);
    while($row = mysqli_fetch_array($execute))
     { array_push($arrayBarang, array(
        "id" => $row['id'],
        "kode" => $row['kode'],
        "nama" => $row['nama'],
        "merek" => $row['merek'],
        "model" => $row['model'],
        "tipe" => $row['tipe'],
        "jenis" => $row['jenis'],
        "kapasitas_pk" => $row['kapasitas_pk'],
        "btuh" => $row['btuh'],
        "ukuran" => $row['ukuran'],
        "satuan" => $row['satuan'],
       ));
     }
  }

 $arrayPesananDetail = array();
 if($filter_pesanan_detail !== "")
  { $query = "select pesanan_detail.id, concat(pesanan.kode, ' ', lpad(pesanan.nomor, if(3 > length(pesanan.nomor), 3, length(pesanan.nomor)), '0'), '/', right(pesanan.tahun, 2)) as nomor_pesanan, pesanan.tahun from pesanan_detail left join pesanan on pesanan_detail.pesanan_id = pesanan.id where".$filter_pesanan_detail;
    $execute = mysqli_query($koneksi, $query);
    while($row = mysqli_fetch_array($execute))
     { array_push($arrayPesananDetail, array(
        "id" => $row['id'],
        "nomor_pesanan" => $row['nomor_pesanan'],
       ));
     }
  }

 $arrayBarangMasukDetail = array();
 if($filter_barang_masuk_detail !== "")
  { $query = "select barang_masuk_detail.id, barang_masuk_detail.barang_masuk_id, barang_masuk.tanggal, barang_masuk.sumber, rak.nama_rak, barang_masuk_detail.dikirim from barang_masuk_detail left join barang_masuk on barang_masuk_detail.barang_masuk_id = barang_masuk.id left join rak on barang_masuk_detail.rak_id = rak.id where".$filter_barang_masuk_detail;
    $execute = mysqli_query($koneksi, $query);
    while($row = mysqli_fetch_array($execute))
     { array_push($arrayBarangMasukDetail, array(
        "id" => $row['id'],
        "barang_masuk_id" => $row['barang_masuk_id'],
        "tanggal" => $row['tanggal'],
        "sumber" => $row['sumber'],
        "nama_rak" => $row['nama_rak'],
        "dikirim" => $row['dikirim'],
       ));
     }
  }

 for($i=0; $i<count($dataRows); $i++)
  { echo "<tr style='cursor:pointer;' class='pilih-so' onclick='pilihSO(this);'>
           <td style='padding:6px 4px 6px 4px;'>".$dataRows[$i]['nomor_penjualan']."</td>
           <td style='padding:6px 4px 6px 4px;'>".$dataRows[$i]['nama_customer']."</td>
           <td style='padding:6px 4px 6px 4px;'>".$dataRows[$i]['alamat_customer']."</td>
           <td style='padding:6px 4px 6px 4px; text-align:right;'>".$dataRows[$i]['total']."</td>
          </tr>";
    $DataEdit .= "<div class='div-detail_barang'>";
    foreach($dataRows[$i]['detail'] as $key => $data)
     { $kode = "";
       $nama = "";
       $merek = "";
       $model = "";
       $tipe = "";
       $jenis = "";
       $kapasitas_pk = "";
       $btuh = "";
       $ukuran = "";
       $satuan = "";
       $index = array_search($data['barang_id'], array_column($arrayBarang, 'id'));
       if(strval($index) !== "")
        { $kode = $arrayBarang[$index]['kode'];
          $nama = $arrayBarang[$index]['nama'];
          $merek = $arrayBarang[$index]['merek'];
          $model = $arrayBarang[$index]['model'];
          $tipe = $arrayBarang[$index]['tipe'];
          $jenis = $arrayBarang[$index]['jenis'];
          $kapasitas_pk = $arrayBarang[$index]['kapasitas_pk'];
          $btuh = $arrayBarang[$index]['btuh'];
          $ukuran = $arrayBarang[$index]['ukuran'];
          $satuan = $arrayBarang[$index]['satuan'];
        }
       $nomor_pesanan = "";
       $index = array_search($data['pesanan_detail_id'], array_column($arrayPesananDetail, 'id'));
       if(strval($index) !== "")
        { $nomor_pesanan = $arrayPesananDetail[$index]['nomor_pesanan'];
        }

       foreach($data['ditandai'] as $index_ditandai => $ditandai)
        { $data['ditandai'][$index_ditandai]['barang_masuk_id'] = null;
          $data['ditandai'][$index_ditandai]['tanggal_barang_masuk'] = null;
          $data['ditandai'][$index_ditandai]['sumber_barang_masuk'] = null;
          $data['ditandai'][$index_ditandai]['nama_rak'] = null;
          //$data['ditandai'][$index_ditandai]['dikirim'] = null;
          $data['ditandai'][$index_ditandai]['add_kirim'] = null;
          $index = array_search($ditandai['barang_masuk_detail_id'], array_column($arrayBarangMasukDetail, 'id'));
          if(strval($index) !== "")
           { $data['ditandai'][$index_ditandai]['barang_masuk_id'] = $arrayBarangMasukDetail[$index]['barang_masuk_id'];
             $data['ditandai'][$index_ditandai]['tanggal_barang_masuk'] = $arrayBarangMasukDetail[$index]['tanggal'];
             $data['ditandai'][$index_ditandai]['sumber_barang_masuk'] = $arrayBarangMasukDetail[$index]['sumber'];
             $data['ditandai'][$index_ditandai]['nama_rak'] = $arrayBarangMasukDetail[$index]['nama_rak'];
             //$data['ditandai'][$index_ditandai]['dikirim'] = $arrayBarangMasukDetail[$index]['dikirim'];
           }
        }

       if($data['harga'] * 1 > 0)
        { $data['harga'] = number_format($data['harga'], 2, ",", ".");
        }
       if($data['jumlah'] * 1 > 0)
        { $data['jumlah'] = number_format($data['jumlah'], 2, ",", ".");
        }
       if($data['jumlah_dikirim'] * 1 > 0)
        { $data['jumlah_dikirim'] = number_format($data['jumlah_dikirim'], 2, ",", ".");
        }
       if($data['jumlah_ditandai'] * 1 > 0)
        { $data['jumlah_ditandai'] = number_format($data['jumlah_ditandai'], 2, ",", ".");
        }
       if($data['diskon_item'] * 1 > 0)
        { $data['diskon_item'] = number_format($data['diskon_item'], 2, ",", ".");
        }
       if($data['diskon_faktur'] * 1 > 0)
        { $data['diskon_faktur'] = number_format($data['diskon_faktur'], 2, ",", ".");
        }
       if($data['total'] * 1 > 0)
        { $data['total'] = number_format($data['total'], 2, ",", ".");
        }
       $DataEdit .= "<textarea class='detail_barang-kode'>".$kode."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-nama'>".$nama."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-merek'>".$merek."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-model'>".$model."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-tipe'>".$tipe."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-jenis'>".$jenis."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-kapasitas_pk'>".$kapasitas_pk."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-btuh'>".$btuh."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-ukuran'>".formatAngka($ukuran)."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-satuan'>".$satuan."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-pesanan_detail_id'>".$data['pesanan_detail_id']."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-nomor_pesanan'>".$nomor_pesanan."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-id'>".$data['id']."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-penjualan_id'>".$data['penjualan_id']."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-barang_id'>".$data['barang_id']."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-harga'>".$data['harga']."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-jumlah'>".$data['jumlah']."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-jumlah_ditandai'>".$data['jumlah_ditandai']."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-ditandai'>".json_encode($data['ditandai'])."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-dikirim'>".$data['jumlah_dikirim']."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-diskon_item'>".$data['diskon_item']."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-diskon_faktur'>".$data['diskon_faktur']."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-total'>".$data['total']."</textarea>";
     }
    $DataEdit .= "</div>";
  }

 echo "  </tbody>
        </table>Menampilkan ".count($dataRows)." dari ".$nListView." record";

 //Tampilan ListView---------------------------------------------------------------------------------------------------------------------------------------------

 echo "<div style='display:none;'>".$DataEdit."</div>";

?>