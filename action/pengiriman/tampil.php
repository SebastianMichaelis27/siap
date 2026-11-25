<?php

 include("../bjksadkhrej121lkjkjk.php");

 $execute = $koneksi->prepare("select nama from karyawan where id in (select karyawan_id from users where username = ?)");
 $execute->bind_param("s", $_POST['username']);
 $execute->execute();
 $result = $execute->get_result();
 $dataUsers = $result->fetch_assoc();

 $queryFilter = " where pengiriman.cabang_id = '".intval($_POST['cabng_id'])."'";
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

 echo "<table class='table table-bordered table-hover' style='margin-top:5px; margin-bottom:5px;'>
        <thead>
         <tr>
          <th style='padding:2px 4px 2px 4px; width:100px; min-width:100px; max-width:100px;'>Tanggal</th>
          <th style='padding:2px 4px 2px 4px; width:150px; min-width:150px; max-width:150px;'>No DO</th>
          <th style='padding:2px 4px 2px 4px; width:150px; min-width:150px; max-width:150px;'>No SO</th>
          <th style='padding:2px 4px 2px 4px; min-width:200px;'>Customer</th>
          <th style='padding:2px 4px 2px 4px; min-width:200px;'>Alamat</th>
          <th style='padding:2px 4px 2px 4px; text-align:center; width:150px; max-width:150px; min-width:150px;'>Act</th>
          <th style='padding:2px 4px 2px 4px; text-align:center; width:100px; max-width:100px; min-width:100px;'>Print</th>
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

 $filter_penjualan = "";

 $dataRows = array();
 $pengiriman_detail_id = array();
 $DataEdit = "";
 $limit = $halaman * $_POST['maxRecord'];
 $start = $limit - $_POST['maxRecord'];
 $query = "select ".$_POST['Nama_Tabel'].".*, concat(".$_POST['Nama_Tabel'].".kode, right(year(".$_POST['Nama_Tabel'].".tanggal), 2), lpad(month(".$_POST['Nama_Tabel'].".tanggal), 2, '0'), lpad(day(".$_POST['Nama_Tabel'].".tanggal), 2, '0'), '-MIE-', lpad(".$_POST['Nama_Tabel'].".nomor, if(3 > length(".$_POST['Nama_Tabel'].".nomor), 3, length(".$_POST['Nama_Tabel'].".nomor)), '0') ) as nomor_pengiriman from ".$_POST['Nama_Tabel'].$queryFilter." order by pengiriman.tanggal desc, pengiriman.id desc limit ".$_POST['maxRecord']." offset ".$start;
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $array_push = array();
    $array_push['nomor_pengiriman'] = $row['nomor_pengiriman'];
    $pengiriman_detail = array();
    if(isset($row['detail']) && $row['detail'] !== "")
     { $pengiriman_detail = json_decode($row['detail'], true);
     }
    $array_push['pengiriman_detail_id'] = array_values(array_unique(array_column($pengiriman_detail, 'id')));
    $pengiriman_detail_id = array_merge($pengiriman_detail_id, $array_push['pengiriman_detail_id']);
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
    $DataEdit .= "<textarea class='textarea_edit-nomor_pengiriman'>".$row['nomor_pengiriman']."</textarea>";
    array_push($dataRows, $array_push);
    if(strval(strpos($filter_penjualan, "penjualan.id = '".$row['penjualan_id']."'")) == "")
     { if($filter_penjualan !== "")
        { $filter_penjualan .= " or ";
        }
       $filter_penjualan .= " penjualan.id = '".$row['penjualan_id']."'";
     }
  }

 $dataPesanan = array();
 $pengiriman_detail_id = array_values(array_unique($pengiriman_detail_id));
 if(count($pengiriman_detail_id) > 0)
  { $placeholders = implode(',', array_fill(0, count($pengiriman_detail_id), '?'));
    $types = str_repeat('i', count($pengiriman_detail_id));

    $execute = $koneksi->prepare("select pengiriman_detail.id as pengiriman_detail_id, pesanan.nomor_po from pengiriman_detail left join penjualan_detail_ditandai on pengiriman_detail.penjualan_detail_ditandai_id = penjualan_detail_ditandai.id left join penjualan_detail on penjualan_detail_ditandai.penjualan_detail_id = penjualan_detail.id left join pesanan_detail on penjualan_detail.pesanan_detail_id = pesanan_detail.id left join pesanan on pesanan_detail.pesanan_id = pesanan.id where pengiriman_detail.id in (".$placeholders.")");
    $execute->bind_param($types, ...$pengiriman_detail_id);
    $execute->execute();
    $result = $execute->get_result();
    $dataPesanan = $result->fetch_all(MYSQLI_ASSOC);
  }
 $dataPesanan = array_column($dataPesanan, 'nomor_po', 'pengiriman_detail_id');

 $filter_barang = "";
 $filter_barang_masuk_detail = "";
 $arrayPenjualan = array();
 $dataBarang = array();
 if($filter_penjualan !== "")
  { $query = "select penjualan.id, penjualan.no_telp_customer, penjualan.no_wa_customer, concat(penjualan.kode, right(year(penjualan.tanggal), 2), lpad(month(penjualan.tanggal), 2, '0'), lpad(day(penjualan.tanggal), 2, '0'), '-MIE-', lpad(penjualan.nomor, if(3 > length(penjualan.nomor), 3, length(penjualan.nomor)), '0') ) as nomor_penjualan, penjualan.nama_customer, penjualan.alamat_customer, penjualan.detail, penjualan.dibayar from penjualan where".$filter_penjualan;
    $execute = mysqli_query($koneksi, $query);
    while($row = mysqli_fetch_array($execute))
     { $detail = array();
       if(isset($row['detail']) && $row['detail'] !== "")
        { $detail = json_decode($row['detail'], true);
        }
       foreach($detail as $index => $value)
        { $cek = array_search($row['id']." - ".$value['barang_id'], array_column($dataBarang, 'key'));
          if(strval($cek) == "")
           { array_push($dataBarang, array(
              "key" => $row['id']." - ".$value['barang_id'],
              "penjualan_id" => $row['id'],
              "barang_id" => $value['barang_id'],
              "nama_produk" => $value['nama_produk'],
             ));
           }
          if(strval(strpos($filter_barang, "barang.id = '".$value['barang_id']."'")) == "")
           { if($filter_barang !== "")
              { $filter_barang .= " or";
              }
             $filter_barang .= " barang.id = '".$value['barang_id']."'";
           }
          foreach($value['ditandai'] as $index_ditandai => $value_ditandai)
           { if(strval(strpos($filter_barang_masuk_detail, "barang_masuk_detail.id = '".$value_ditandai['barang_masuk_detail_id']."'")) == "")
              { if($filter_barang_masuk_detail !== "")
                 { $filter_barang_masuk_detail .= " or";
                 }
                $filter_barang_masuk_detail .= " barang_masuk_detail.id = '".$value_ditandai['barang_masuk_detail_id']."'";
              }
           }
        }

       $no_telp = array();
       if(isset($row['no_telp_customer']) && $row['no_telp_customer'] !== "")
        { $no_telp_customer = json_decode($row['no_telp_customer'], true);
          $no_telp = array_merge($no_telp, array_column($no_telp_customer, 'no_telp_customer'));
        }
       if(isset($row['no_wa_customer']) && $row['no_wa_customer'] !== "")
        { $no_wa_customer = json_decode($row['no_wa_customer'], true);
          $no_telp = array_merge($no_telp, array_column($no_wa_customer, 'no_wa_customer'));
        }

       array_push($arrayPenjualan, array(
        "id" => $row['id'],
        "nomor_penjualan" => $row['nomor_penjualan'],
        "nama_customer" => $row['nama_customer'],
        "alamat_customer" => $row['alamat_customer'],
        "no_telp" => $no_telp,
        "detail" => $detail,
        "dibayar" => $row['dibayar'] * 1,
       ));
     }
  }

 $arrayBarangMasukDetail = array();
 if($filter_barang_masuk_detail !== "")
  { $query = "select barang_masuk_detail.id, barang_masuk_detail.barang_masuk_id, barang_masuk.tanggal as tanggal_barang_masuk, barang_masuk.sumber as sumber_barang_masuk, rak.nama_rak from barang_masuk_detail left join barang_masuk on barang_masuk_detail.barang_masuk_id = barang_masuk.id left join rak on barang_masuk_detail.rak_id = rak.id";
    $execute = mysqli_query($koneksi, $query);
    while($row = mysqli_fetch_array($execute))
     { $tanggal_barang_masuk = "";
       if(isset($row['tanggal_barang_masuk']) && $row['tanggal_barang_masuk'] !== "")
        { $tanggal_barang_masuk = date('d-m-Y', strtotime($row['tanggal_barang_masuk']));
        }
       array_push($arrayBarangMasukDetail, array(
        "id" => $row['id'],
        "barang_masuk_id" => $row['barang_masuk_id'],
        "tanggal_barang_masuk" => $tanggal_barang_masuk,
        "sumber_barang_masuk" => $row['sumber_barang_masuk'],
        "nama_rak" => $row['nama_rak'],
       ));
     }
  }

 $arrayBarang = array();
 if($filter_barang !== "")
  { $query = "select barang.id, barang.kode, barang.nama, barang.merek, barang.model, barang.tipe, barang.jenis, satuan.satuan from barang left join satuan on barang.satuan_id = satuan.id where".$filter_barang;
    $execute = mysqli_query($koneksi, $query);
    while($row = mysqli_fetch_array($execute))
     { array_push($arrayBarang, array(
        "id" => $row['id'],
        "unit" => $row['satuan'],
       ));
     }
  }

 for($i=0; $i<count($dataRows); $i++)
  { $pengiriman_detail = array();
    if(isset($dataRows[$i]['detail']) && $dataRows[$i]['detail'] !== "")
     { $pengiriman_detail = json_decode($dataRows[$i]['detail'], true);
     }

    $no_po = array();
    foreach($pengiriman_detail as $key => $value)
     { array_push($no_po, $dataPesanan[$value['id']]);
     }
    $no_po = array_values(array_unique($no_po));
    $nomor_po = implode(", ", $no_po);

    $penjualan_id = "";
    $nomor_penjualan = "";
    $customer = "";
    $alamat_customer = "";
    $detail = array();
    $no_telp = array();
    $dibayar = 0;
    $index = array_search($dataRows[$i]['penjualan_id'], array_column($arrayPenjualan, 'id'));
    if(strval($index) !== "")
     { $penjualan_id = $arrayPenjualan[$index]['id'];
       $nomor_penjualan = $arrayPenjualan[$index]['nomor_penjualan'];
       $customer = $arrayPenjualan[$index]['nama_customer'];
       $alamat_customer = $arrayPenjualan[$index]['alamat_customer'];
       $detail = $arrayPenjualan[$index]['detail'];
       $dibayar = $arrayPenjualan[$index]['dibayar'];
       $no_telp = $arrayPenjualan[$index]['no_telp'];
     }
    $no_hp = implode(", ", $no_telp);
    $alamat = splitText($alamat_customer, 70);
    if($dibayar > 0)
     { $dp = splitText("Sudah DP Rp. ".formatAngka($dibayar), 133);;
     }
    echo "<tr>
           <td style='padding:2px 4px 2px 4px;'>".$dataRows[$i]['tanggal']."</td>
           <td style='padding:2px 4px 2px 4px;'>".$dataRows[$i]['nomor_pengiriman']."</td>
           <td style='padding:2px 4px 2px 4px;'>".$nomor_penjualan."</td>
           <td style='padding:2px 4px 2px 4px;'>".$customer."</td>
           <td style='padding:2px 4px 2px 4px;'>".$alamat_customer."</td>
           <td style='padding:2px 4px 2px 4px; text-align:center;'>
            <button type='button' class='btn btn-default view' title='View' onclick='view(this);'><i class='fa fa-search'></i></button>
            <button type='button' class='btn btn-default edit' title='Edit' onclick='edit(this);'><i class='fa fa-edit'></i></button>
            <button type='button' class='btn btn-default hapus' title='Hapus' onclick='konfirmasiHapus(this);'><i class='fa fa-trash'></i></button>
           </td>
           <td style='padding:2px 4px 2px 4px; text-align:center;'>
            <button type='button' class='btn btn-danger cetak' title='Cetak' onclick='cetak(this);'><i class='fa fa-file-pdf-o'></i></button>
            <button type='button' class='btn btn-success dot-matrix' onclick='printDotMatrix(this);'><i class='fa fa-print'></i></button>
           </td>
          </tr>";
    $detail_barang = "";
    $no = 0;
    $DataEdit .= "<textarea class='textarea_edit-penjualan_id'>".$penjualan_id."</textarea>
                  <textarea class='textarea_edit-nomor_penjualan'>".$nomor_penjualan."</textarea>
                  <textarea class='textarea_edit-customer'>".$customer."</textarea>
                  <div class='edit_detail'>";
    foreach($detail as $key => $value)
     { $no++;
       $nama_produk = "";
       $unit = "";
       $index = array_search($value['barang_id'], array_column($arrayBarang, 'id'));
       if(strval($index) !== "")
        { $unit = $arrayBarang[$index]['unit'];
        }
       $index = array_search($dataRows[$i]['penjualan_id']." - ".$value['barang_id'], array_column($dataBarang, 'key'));
       if(strval($index) !== "")
        { $nama_produk = $dataBarang[$index]['nama_produk'];
        }
       $kirim = 0;
       for($j=0; $j<count($value['ditandai']); $j++)
        { $value['ditandai'][$j]['barang_masuk_id'] = null;
          $value['ditandai'][$j]['tanggal_barang_masuk'] = null;
          $value['ditandai'][$j]['sumber_barang_masuk'] = null;
          $value['ditandai'][$j]['nama_rak'] = null;
          $value['ditandai'][$j]['add_kirim'] = null;
          $index = array_search($value['ditandai'][$j]['barang_masuk_detail_id'], array_column($arrayBarangMasukDetail, 'id'));
          if(strval($index) !== "")
           { $value['ditandai'][$j]['barang_masuk_id'] = $arrayBarangMasukDetail[$index]['barang_masuk_id'];
             $value['ditandai'][$j]['tanggal_barang_masuk'] = $arrayBarangMasukDetail[$index]['tanggal_barang_masuk'];
             $value['ditandai'][$j]['sumber_barang_masuk'] = $arrayBarangMasukDetail[$index]['sumber_barang_masuk'];
             $value['ditandai'][$j]['nama_rak'] = $arrayBarangMasukDetail[$index]['nama_rak'];
           }
          $index = array_search($value['ditandai'][$j]['id'], array_column($pengiriman_detail, 'penjualan_detail_ditandai_id'));
          if(strval($index) !== "")
           { $value['ditandai'][$j]['dikirim'] -= $pengiriman_detail[$index]['jumlah'] * 1;
             $value['ditandai'][$j]['add_kirim'] = $pengiriman_detail[$index]['jumlah'] * 1;
           }
          $kirim += $value['ditandai'][$j]['add_kirim'] * 1;
        }

       $detail_barang .= addDetailBarang("", $no, $nama_produk, formatAngka($value['jumlah']), $unit, "");

       $DataEdit .= "<textarea class='edit_penjualan_detail-id'>".$value['id']."</textarea>
                     <textarea class='edit_penjualan_detail-barang_id'>".$value['barang_id']."</textarea>
                     <textarea class='edit_penjualan_detail-nama_produk'>".$nama_produk."</textarea>
                     <textarea class='edit_penjualan_detail-jumlah'>".number_format($value['jumlah'], 2, ",", ".")."</textarea>
                     <textarea class='edit_penjualan_detail-telah_dikirim'>".number_format($value['jumlah_dikirim'] - $kirim, 2, ",", ".")."</textarea>
                     <textarea class='edit_penjualan_detail-jumlah_ditandai'>".number_format($value['jumlah_ditandai'], 2, ",", ".")."</textarea>
                     <textarea class='edit_penjualan_detail-ditandai'>".json_encode($value['ditandai'])."</textarea>
                     <textarea class='edit_penjualan_detail-kirim'>".number_format($kirim, 2, ",", ".")."</textarea>";
     }
    $DataEdit .= "</div>";

    $invoice_dot_matrix = "";
    $invoice_dot_matrix .= "+".str_pad("", 52, "-", STR_PAD_LEFT)."+";
    $invoice_dot_matrix .= str_pad("", 32, " ", STR_PAD_LEFT);

    $invoice_dot_matrix .= "\n";
    $invoice_dot_matrix .= str_pad("| PT FREEN COOL TEKNIK", 53, " ", STR_PAD_RIGHT)."|";
    $invoice_dot_matrix .= str_pad("", 32, " ", STR_PAD_LEFT);

    $invoice_dot_matrix .= "\n";
    $invoice_dot_matrix .= "| Jl. Perhubungan Villa Pendopo Indah Lau Dendang    |";
    $invoice_dot_matrix .= str_pad("", 32, " ", STR_PAD_LEFT);
    $invoice_dot_matrix .= "DELIVERY ORDER";

    $invoice_dot_matrix .= "\n";
    $invoice_dot_matrix .= "+".str_pad("", 52, "-", STR_PAD_LEFT)."+";
    $invoice_dot_matrix .= str_pad("", 32, " ", STR_PAD_LEFT);
    $invoice_dot_matrix .= "+".str_pad("", 49, "-", STR_PAD_LEFT)."+";

    $invoice_dot_matrix .= "\n";
    $invoice_dot_matrix .= "+".str_pad("", 82, "-", STR_PAD_LEFT)."+";
    $invoice_dot_matrix .= str_pad("", 2, " ", STR_PAD_LEFT);
    $invoice_dot_matrix .= "| Do No : ".str_pad(substr($dataRows[$i]['nomor_pengiriman'] ?? '', 0, 39), 39, " ", STR_PAD_RIGHT)." |";

    $invoice_dot_matrix .= "\n";
    $invoice_dot_matrix .= "| Ship To : ".str_pad(substr($customer ?? '', 0, 70), 70, " ", STR_PAD_RIGHT)." |";
    $invoice_dot_matrix .= str_pad("", 2, " ", STR_PAD_LEFT);
    $invoice_dot_matrix .= "| Date  : ".str_pad(format_tanggal(date('Y-m-d')), 39, " ", STR_PAD_RIGHT)." |";

    $invoice_dot_matrix .= "\n";
    $invoice_dot_matrix .= "|           ".str_pad(substr($no_hp ?? '', 0, 70), 70, " ", STR_PAD_RIGHT)." |";
    $invoice_dot_matrix .= str_pad("", 2, " ", STR_PAD_LEFT);
    $invoice_dot_matrix .= "| Po No : ".str_pad(substr($nomor_po, 0, 39), 39, " ", STR_PAD_RIGHT)." |";

    $invoice_dot_matrix .= "\n";
    $invoice_dot_matrix .= "|           ".str_pad(substr($alamat[0] ?? '', 0, 70), 70, " ", STR_PAD_RIGHT)." |";
    $invoice_dot_matrix .= str_pad("", 2, " ", STR_PAD_LEFT);
    $invoice_dot_matrix .= "| Terms : ".str_pad("", 39, " ", STR_PAD_RIGHT)." |";

    if(isset($alamat[1]) && $alamat[1] !== "")
     { $invoice_dot_matrix .= "\n";
       $invoice_dot_matrix .= "|           ".str_pad(substr($alamat[1] ?? '', 0, 70), 70, " ", STR_PAD_RIGHT)." |";
       $invoice_dot_matrix .= str_pad("", 2, " ", STR_PAD_LEFT);
       $invoice_dot_matrix .= "|".str_pad("", 49, " ", STR_PAD_RIGHT)."|";
     }

    if(isset($alamat[2]) && $alamat[2] !== "")
     { $invoice_dot_matrix .= "\n";
       $invoice_dot_matrix .= "|           ".str_pad(substr($alamat[2] ?? '', 0, 70), 70, " ", STR_PAD_RIGHT)." |";
       $invoice_dot_matrix .= str_pad("", 2, " ", STR_PAD_LEFT);
       $invoice_dot_matrix .= "|".str_pad("", 49, " ", STR_PAD_RIGHT)."|";
     }

    $invoice_dot_matrix .= "\n";
    $invoice_dot_matrix .= "+".str_pad("", 82, "-", STR_PAD_LEFT)."+";
    $invoice_dot_matrix .= str_pad("", 2, " ", STR_PAD_LEFT);
    $invoice_dot_matrix .= "+".str_pad("", 49, "-", STR_PAD_RIGHT)."+";

    $invoice_dot_matrix .= "\n";
    $invoice_dot_matrix .= "+".str_pad("", 135, "-", STR_PAD_RIGHT)."+";

    $invoice_dot_matrix .= "\n";
    $invoice_dot_matrix .= "|   No   |                    Item Description                     |     Qty    |          Unit          |             Ket              |";

    $invoice_dot_matrix .= "\n";
    $invoice_dot_matrix .= "+".str_pad("", 135, "-", STR_PAD_RIGHT)."+";

    $invoice_dot_matrix .= $detail_barang;

    $invoice_dot_matrix .= "\n";
    $invoice_dot_matrix .= "+".str_pad("", 135, "-", STR_PAD_RIGHT)."+";

    $invoice_dot_matrix .= "\n";
    $invoice_dot_matrix .= "\n";
    $invoice_dot_matrix .= "Description";

    $invoice_dot_matrix .= "\n";
    $invoice_dot_matrix .= "+".str_pad("", 135, "-", STR_PAD_RIGHT)."+";

    $invoice_dot_matrix .= "\n";
    $invoice_dot_matrix .= "| ".str_pad(substr($dp[0] ?? '', 0, 133), 133, " ", STR_PAD_RIGHT)." |";

    if(isset($dp[1]) && $dp[1] !== "")
     { $invoice_dot_matrix .= "\n";
       $invoice_dot_matrix .= "| ".str_pad(substr($dp[1] ?? '', 0, 133), 133, " ", STR_PAD_RIGHT)." |";
     }

    if(isset($dp[1]) && $dp[1] !== "")
     { $invoice_dot_matrix .= "\n";
       $invoice_dot_matrix .= "| ".str_pad(substr($dp[1] ?? '', 0, 133), 133, " ", STR_PAD_RIGHT)." |";
     }

    if(isset($dp[2]) && $dp[2] !== "")
     { $invoice_dot_matrix .= "\n";
       $invoice_dot_matrix .= "| ".str_pad(substr($dp[2] ?? '', 0, 133), 133, " ", STR_PAD_RIGHT)." |";
     }

    if(isset($dp[3]) && $dp[3] !== "")
     { $invoice_dot_matrix .= "\n";
       $invoice_dot_matrix .= "| ".str_pad(substr($dp[3] ?? '', 0, 133), 133, " ", STR_PAD_RIGHT)." |";
     }

    $invoice_dot_matrix .= "\n";
    $invoice_dot_matrix .= "+".str_pad("", 135, "-", STR_PAD_RIGHT)."+";

    $invoice_dot_matrix .= "\n";
    $invoice_dot_matrix .= "\n";
    $invoice_dot_matrix .= str_pad("Doc Prepared By", 46, " ", STR_PAD_RIGHT);
    $invoice_dot_matrix .= str_pad((isset($dataRows[$i]['jenis_pengiriman']) && $dataRows[$i]['jenis_pengiriman'] == "Diambil" ? "" : "Ship By"), 46, " ", STR_PAD_RIGHT);
    $invoice_dot_matrix .= str_pad("Received By", 45, " ", STR_PAD_RIGHT);

    $invoice_dot_matrix .= "\n";
    $invoice_dot_matrix .= "\n";
    $invoice_dot_matrix .= "\n";
    $invoice_dot_matrix .= "\n";
    $invoice_dot_matrix .= str_pad(substr($dataUsers['nama'] ?? '', 0, 45), 45, " ", STR_PAD_RIGHT)." ";
    $invoice_dot_matrix .= str_pad((isset($dataRows[$i]['jenis_pengiriman']) && $dataRows[$i]['jenis_pengiriman'] == "Diambil" ? "" : "__________________"), 45, " ", STR_PAD_RIGHT)." ";
    $invoice_dot_matrix .= str_pad("__________________", 45, " ", STR_PAD_RIGHT);

    $invoice_dot_matrix .= "\n";
    $invoice_dot_matrix .= str_pad(substr("Date : ".format_tanggal2(date('Y-m-d')), 0, 45), 45, " ", STR_PAD_RIGHT)." ";
    $invoice_dot_matrix .= str_pad((isset($dataRows[$i]['jenis_pengiriman']) && $dataRows[$i]['jenis_pengiriman'] == "Diambil" ? "" : substr("Date : ".format_tanggal2(date('Y-m-d')), 0, 45)), 45, " ", STR_PAD_RIGHT)." ";
    $invoice_dot_matrix .= str_pad(substr("Date : ", 0, 45), 45, " ", STR_PAD_RIGHT)." ";

    $DataEdit .= "<textarea class='cetak-dot-matrix'>".$invoice_dot_matrix."</textarea>";
  }

 function addDetailBarang($text, $no, $item_description, $qty, $unit, $ket)
  { $l_no = 6;
    $l_item_description = 55;
    $l_qty = 10;
    $l_unit = 22;
    $l_ket = 28;

    $no = trim($no ?? '');
    $item_description = trim($item_description ?? '');
    $qty = trim($qty ?? '');
    $unit = trim($unit ?? '');
    $ket = trim($ket ?? '');

    $p_no = str_pad(substr($no, 0, $l_no), $l_no, " ", STR_PAD_LEFT);
    $no = substr($no, $l_no, strlen($no) - 1);

    $p_item_description = str_pad(substr($item_description, 0, $l_item_description), $l_item_description, " ", STR_PAD_RIGHT);
    $item_description = substr($item_description, $l_item_description, strlen($item_description) - 1);

    $p_qty = str_pad(substr($qty, 0, $l_qty), $l_qty, " ", STR_PAD_LEFT);
    $qty = substr($qty, $l_qty, strlen($qty) - 1);

    $p_unit = str_pad(substr($unit, 0, $l_unit), $l_unit, " ", STR_PAD_RIGHT);
    $unit = substr($unit, $l_unit, strlen($unit) - 1);

    $p_ket = str_pad(substr($ket, 0, $l_ket), $l_ket, " ", STR_PAD_LEFT);
    $ket = substr($ket, $l_ket, strlen($ket) - 1);

    $text .= "\n";
    $text .= "| ".$p_no." | ".$p_item_description." | ".$p_qty." | ".$p_unit." | ".$p_ket." |";

    $no = trim($no ?? '');
    $item_description = trim($item_description ?? '');
    $qty = trim($qty ?? '');
    $unit = trim($unit ?? '');
    $ket = trim($ket ?? '');

    if(strlen($no) > 0 || strlen($item_description) > 0 || strlen($qty) || strlen($unit) || strlen($ket))
     { $text = addDetailBarang($text, $no, $item_description, $qty, $unit, $ket);
     }
    else
     { //$text .= "\n";
       //$text .= "+-----+--------------------------------+------+---------+---------------+-------------+-------------+---------------+-------+-----------+";
     }
    
    return $text;
  }

 echo "  </tbody>
        </table>Menampilkan ".count($dataRows)." dari ".$nListView." record";

 echo "<div style='display:none;'>".$DataEdit."</div>";

?>