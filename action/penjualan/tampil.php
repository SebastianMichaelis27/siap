<?php

 //─ │ ┌ ┐ └ ┘ ├ ┤ ┬ ┴ ┼

 include("../bjksadkhrej121lkjkjk.php");

 $queryFilter = " where cabang_id = '".intval($_POST['cabng_id'])."'";
 if(isset($_POST['filter']) && ($_POST['filter'] !== "" || $_POST['filter'] !== "[]"))
  { $filter = json_decode($_POST['filter'], true);
    for($i=0; $i<count($filter); $i++)
     { if($filter[$i]['field'] == "penjualan.tanggal")
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
         <th style='padding:2px 4px 2px 4px;'>Tanggal</th>
         <th style='padding:2px 4px 2px 4px;'>Nomor Penjualan</th>
         <th style='padding:2px 4px 2px 4px;'>Customer</th>
         <th style='padding:2px 4px 2px 4px;'>Alamat Customer</th>
         <th style='padding:2px 4px 2px 4px; text-align:center; width:150px; max-width:150px; min-width:150px;'>Total</th>
         <th style='padding:2px 4px 2px 4px; text-align:center; width:150px; max-width:150px; min-width:150px;'>Dibayar</th>
         <th style='padding:2px 4px 2px 4px; text-align:center; width:150px; max-width:150px; min-width:150px;'>Act</th>
         <th style='padding:2px 4px 2px 4px; text-align:center; width:100px; max-width:100px; min-width:100px;'>Print</th>
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

 $filter_barang = "";
 $filter_pesanan_detail = "";
 $filter_karyawan = "";

 $dataRows = array();
 $pesanan_detail_id = array();
 $DataEdit = "";
 $limit = $halaman * $_POST['maxRecord'];
 $start = $limit - $_POST['maxRecord'];
 $query = "select ".$_POST['Nama_Tabel'].".*, concat(".$_POST['Nama_Tabel'].".kode, right(year(".$_POST['Nama_Tabel'].".tanggal), 2), lpad(month(".$_POST['Nama_Tabel'].".tanggal), 2, '0'), lpad(day(".$_POST['Nama_Tabel'].".tanggal), 2, '0'), '-MIE-', lpad(".$_POST['Nama_Tabel'].".nomor, if(3 > length(".$_POST['Nama_Tabel'].".nomor), 3, length(".$_POST['Nama_Tabel'].".nomor)), '0') ) as nomor_penjualan from ".$_POST['Nama_Tabel'].$queryFilter." order by penjualan.tanggal desc, penjualan.id desc limit ".$_POST['maxRecord']." offset ".$start;
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
    $array_push['detail'] = $detail;

    $termin = array();
    if(isset($row['termin']) && strval($row['termin']) !== "")
     { $termin = json_decode($row['termin'], true);
     }
    if(!is_array($termin))
     { $termin = array();
     }
    $array_push['termin'] = $termin;
    
    $array_push['pesanan_detail_id'] = array_column($detail ?? array(), 'pesanan_detail_id');
    $pesanan_detail_id = array_values(array_unique(array_merge($pesanan_detail_id, array_column($detail ?? array(), 'pesanan_detail_id'))));

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
     }
    if(strval(strpos($filter_karyawan, "id = '".$row['karyawan_id']."'")) == "")
     { if($filter_karyawan !== "")
        { $filter_karyawan .= " or";
        }
       $filter_karyawan .= " id = '".$row['karyawan_id']."'";
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

 $dataPenjualanPembayaran = array();
 $penjualan_id = array_values(array_unique(array_column($dataRows, 'id')));
 if(count($penjualan_id) > 0)
  { $placeholders = implode(',', array_fill(0, count($penjualan_id), '?'));
    $types = str_repeat('i', count($penjualan_id));
    $execute = $koneksi->prepare("select * from penjualan_pembayaran where penjualan_id in (".$placeholders.")");
    $execute->bind_param($types, ...$penjualan_id);
    $execute->execute();
    $result = $execute->get_result();
    $dataPenjualanPembayaran = $result->fetch_all(MYSQLI_ASSOC);
  }

 $dataKaryawan = array();
 $karyawan_id = array_values(array_unique(array_column($dataRows, 'karyawan_id')));
 if(count($karyawan_id) > 0)
  { $placeholders = implode(',', array_fill(0, count($karyawan_id), '?'));
    $types = str_repeat('i', count($karyawan_id));
    $execute = $koneksi->prepare("select id, nik, nama from karyawan where id in (".$placeholders.")");
    $execute->bind_param($types, ...$karyawan_id);
    $execute->execute();
    $result = $execute->get_result();
    $dataKaryawan = $result->fetch_all(MYSQLI_ASSOC);
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

 $arrayBarang = array();
 if($filter_barang !== "")
  { $query = "select barang.*, satuan.satuan from barang left join satuan on barang.satuan_id = satuan.id where".$filter_barang;
    $execute = mysqli_query($koneksi, $query);
    while($row = mysqli_fetch_array($execute))
     { $data_push = array();
       foreach($row as $key => $value)
        { if($key !== 0 && intval($key) == 0)
           { $data_push[$key] = $value;
           }
        }
       array_push($arrayBarang, $data_push);
     }
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

 $dataBank = array();
 $bank_id = array_values(array_unique(array_column($dataRows, 'bank_id')));
 if(count($bank_id) > 0)
  { $placeholders = implode(',', array_fill(0, count($bank_id), '?'));
    $types = str_repeat('i', count($bank_id));

    $execute = $koneksi->prepare("select * from bank where id in (".$placeholders.")");
    $execute->bind_param($types, ...$bank_id);
    $execute->execute();
    $result = $execute->get_result();
    $dataBank = $result->fetch_all(MYSQLI_ASSOC);
  }

 $execute = $koneksi->prepare("select nama from karyawan where id in (select karyawan_id from users where username = ?)");
 $execute->bind_param("s", $_POST['username']);
 $execute->execute();
 $result = $execute->get_result();
 $dataUsers = $result->fetch_assoc();

 for($i=0; $i<count($dataRows); $i++)
  { $penjualan_id = $dataRows[$i]['id'];
    $tanggal = date('Y-m-d', strtotime($dataRows[$i]['tanggal']));
    $dataPembayaran = array_values(array_filter($dataPenjualanPembayaran, function($var) use($penjualan_id, $tanggal) {
     return ($var['penjualan_id'] == $penjualan_id && $var['tanggal'] <= $tanggal);
    }));
    $dibayar = 0;
    for($j=0; $j<count($dataPembayaran); $j++)
     { $dibayar += $dataPembayaran[$j]['nominal'];
     }
    if($dataRows[$i]['total'] > $dibayar)
     { $DataEdit .= "<textarea class='textarea_edit-jenis_pembayaran'>Kredit</textarea>";
     }
    else
     { $DataEdit .= "<textarea class='textarea_edit-jenis_pembayaran'>Lunas</textarea>";
     }
    $DataEdit .= "<textarea class='textarea_edit-metode_pembayaran_id'>".($dataPembayaran[0]['metode_pembayaran_id'] ?? '')."</textarea>";

    $nomor_pesanan = '';
    foreach($dataRows[$i]['pesanan_detail_id'] as $key => $value)
     { $index = array_search($value, array_column($dataPesananDetail, 'pesanan_detail_id'));
       if(strval($index) !== "")
        { if($nomor_pesanan !== "")
           { $nomor_pesanan .= ", ";
           }
          $nomor_pesanan .= $dataPesananDetail[$index]['nomor_pesanan'];
        }
     }

    $salesman = "";
    $index = array_search($dataRows[$i]['karyawan_id'], array_column($dataKaryawan, 'id'));
    if(strval($index) !== "")
     { $salesman = $dataKaryawan[$index]['nama'];
     }

    $index = array_search($dataRows[$i]['bank_id'], array_column($dataBank, 'id'));
    if(strval($index) !== "")
     { $payment[0] = substr($dataBank[$index]['nama_bank'], 0, 67);
       $payment[1] = substr("A/C : ".$dataBank[$index]['nomor_rekening'], 0, 67);
       $payment[2] = substr("AN  : ".$dataBank[$index]['nama_rekening'], 0, 67);
     }

    $btn_print = "";
    if(strval($dataRows[$i]['approved_at']) == "" && strval($dataRows[$i]['rejected_at']) == "")
     { $btn_print = "<button type='button' class='btn btn-warning cetak' title='Menunggu Konfirmasi'><i class='fa fa-clock-o'></i></button><div class='dot-matrix'></div>";
     }
    else if(strval($dataRows[$i]['rejected_at']) !== "")
     { $btn_print = "<button type='button' class='btn btn-default cetak' title='Ditolak'><i class='fa fa-close'></i></button><div class='dot-matrix'></div>";
       echo "ada woi";
     }
    else
     { $btn_print = "<button type='button' class='btn btn-danger cetak' title='Cetak' onclick='cetak(this);'><i class='fa fa-file-pdf-o'></i></button>
                     <button type='button' class='btn btn-success dot-matrix' onclick='printDotMatrix(this);'><i class='fa fa-print'></i></button>";
     }
    echo "<tr>
           <td style='padding:2px 4px 2px 4px;'>".$dataRows[$i]['tanggal']."</td>
           <td style='padding:2px 4px 2px 4px;'>".$dataRows[$i]['nomor_penjualan']."</td>
           <td style='padding:2px 4px 2px 4px;'>".$dataRows[$i]['nama_customer']."</td>
           <td style='padding:2px 4px 2px 4px;'>".$dataRows[$i]['alamat_customer']."</td>
           <td style='padding:2px 4px 2px 4px; text-align:right;'>".$dataRows[$i]['total']."</td>
           <td style='padding:2px 4px 2px 4px; text-align:right; color:blue; text-decoration:underline; cursor:pointer; user-select:none;' class='pilih-pembayaran' onclick='pilihPembayaran(this);'>
            ".$dataRows[$i]['dibayar']."
           </td>
           <td style='padding:2px 4px 2px 4px; text-align:center;'>
            <button type='button' class='btn btn-default view' title='View' onclick='view(this);'><i class='fa fa-search'></i></button>
            <button type='button' class='btn btn-default edit' title='Edit' onclick='edit(this);'><i class='fa fa-edit'></i></button>
            <button type='button' class='btn btn-default hapus' title='Hapus' onclick='konfirmasiHapus(this);'><i class='fa fa-trash'></i></button>
           </td>
           <td style='padding:2px 4px 2px 4px; text-align:center;'>".$btn_print."</td>
          </tr>";

    $DataEdit .= "<div class='div-termin'>";
    foreach($dataRows[$i]['termin'] as $key => $data)
     { $DataEdit .= "<textarea class='termin-tanggal'>".(isset($data['tanggal']) && $data['tanggal'] !== "" ? date('d-m-Y', strtotime($data['tanggal'])) : "")."</textarea>
                     <textarea class='termin-nominal'>".number_format($data['nominal'] ?? 0, 2, ",", ".")."</textarea>";
     }
    $DataEdit .= "</div>";


    $detail_barang = '';
    $no = 0;
    $sub_total = 0;
    $DataEdit .= "<div class='div-detail_barang'>";
    foreach($dataRows[$i]['detail'] as $key => $data)
     { $no++;
       $kode = "";
       $nama = "";
       $merek = "";
       $model = "";
       $tipe = "";
       $jenis = "";
       $kapasitas_pk = "";
       $btuh = "";
       $unit = "";
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
          $unit = $arrayBarang[$index]['satuan'];
        }
       $nomor_po = "";
       $index = array_search($data['pesanan_detail_id'], array_column($arrayPesananDetail, 'id'));
       if(strval($index) !== "")
        { $nomor_po = $arrayPesananDetail[$index]['nomor_po'];
        }
       $DataEdit .= "<textarea class='detail_barang-nomor_po'>".$nomor_po."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-kode'>".$kode."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-nama'>".$nama."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-merek'>".$merek."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-model'>".$model."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-tipe'>".$tipe."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-jenis'>".$jenis."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-kapasitas_pk'>".$kapasitas_pk."</textarea>";
       $DataEdit .= "<textarea class='detail_barang-btuh'>".$btuh."</textarea>";
       foreach($data as $key => $value)
        { if(is_array($value))
           { $value = json_encode($value);
           }
          if(intval($key) == 0 && strval($key) !== "0" )
           { if(is_numeric($value) && $key !== "id" && strval(strpos($key, "id_")) == "" && strval(strpos($key, "_id")) == "")
              { $value = number_format($value, 2, ",", ".");
              }
             $DataEdit .= "<textarea class='detail_barang-".$key."'>".$value."</textarea>";
           }
        }

       $amount = ($data['jumlah'] * $data['harga']) - $data['diskon_item'] + $data['nominal_ppn'];
       $sub_total += $amount;

       $detail_barang .= addDetailBarang("", $no, $data['nama_produk'], formatAngka($data['jumlah']), $unit, formatAngka($data['harga']), formatAngka($data['diskon_item']), formatAngka($data['nominal_ppn']), formatAngka($amount), "", "");
     }
    $DataEdit .= "</div>";

    $list_karayawan = "";
    $index = array_search($dataRows[$i]['karyawan_id'], array_column($dataKaryawan, 'id'));
    if(strval($index) !== "")
     { $list_karayawan .= "<option value='".$dataRows[$i]['karyawan_id']."' selected>".$dataKaryawan[$index]['nik']." - ".$dataKaryawan[$index]['nama']."</option>";
     }
    $DataEdit .= "<select class='select_edit-karyawan_id'>".$list_karayawan."</select>";

    $pick_up_by = splitText("Pick Up By : ".$dataRows[$i]['nama_customer'], 75);

    $terbilang_ = terbilang($dataRows[$i]['total_order']);
    if($terbilang_ !== "")
     { $terbilang_ .= " Rupiah";
     }
    $terbilang = splitText($terbilang_, 67);

    $invoice_dot_matrix = "";
    $invoice_dot_matrix .= "+".str_pad("", 52, "-", STR_PAD_LEFT)."+";
    $invoice_dot_matrix .= str_pad("", 32, " ", STR_PAD_LEFT);
    $invoice_dot_matrix .= "Proforma Invoice";

    $invoice_dot_matrix .= "\n";
    $invoice_dot_matrix .= str_pad("| PT FREEN COOL TEKNIK", 53, " ", STR_PAD_RIGHT)."|";
    $invoice_dot_matrix .= str_pad("", 32, " ", STR_PAD_LEFT);
    $invoice_dot_matrix .= "+".str_pad("", 49, "-", STR_PAD_LEFT)."+";

    $invoice_dot_matrix .= "\n";
    $invoice_dot_matrix .= "+".str_pad("", 52, "-", STR_PAD_LEFT)."+";
    $invoice_dot_matrix .= str_pad("", 32, " ", STR_PAD_LEFT);
    $invoice_dot_matrix .= "| Invoice Number : ".str_pad(substr($dataRows[$i]['nomor_penjualan'], 0, 30), 30, " ", STR_PAD_RIGHT)." |";

    $invoice_dot_matrix .= "\n";
    $invoice_dot_matrix .= str_pad("| Jl. Perhubungan Komplek Villa Pendopo Indah", 53, " ", STR_PAD_RIGHT)."|";
    $invoice_dot_matrix .= str_pad("", 32, " ", STR_PAD_LEFT);
    $invoice_dot_matrix .= "| Po No          : ".str_pad(substr($nomor_pesanan, 0, 30), 30, " ", STR_PAD_RIGHT)." |";

    $invoice_dot_matrix .= "\n";
    $invoice_dot_matrix .= "+".str_pad("", 52, "-", STR_PAD_LEFT)."+";
    $invoice_dot_matrix .= str_pad("", 32, " ", STR_PAD_LEFT);
    $invoice_dot_matrix .= "+".str_pad("", 49, "-", STR_PAD_LEFT)."+";

    $invoice_dot_matrix .= "\n";
    $invoice_dot_matrix .= "+".str_pad("", 77, "-", STR_PAD_LEFT)."+";
    $invoice_dot_matrix .= str_pad("", 7, " ", STR_PAD_LEFT);
    $invoice_dot_matrix .= "| Invoice Date     Ship Date                      |";

    $invoice_dot_matrix .= "\n";
    $invoice_dot_matrix .= "| ".str_pad($pick_up_by[0] ?? '', 75, " ", STR_PAD_RIGHT)." |";
    $invoice_dot_matrix .= str_pad("", 7, " ", STR_PAD_LEFT);
    $invoice_dot_matrix .= "| ".str_pad(format_tanggal2($dataRows[$i]['tanggal']), 16, " ", STR_PAD_RIGHT)." ".str_pad(format_tanggal2(date('Y-m-d')), 30, " ", STR_PAD_RIGHT)." |";

    $invoice_dot_matrix .= "\n";
    $invoice_dot_matrix .= "| ".str_pad($pick_up_by[1] ?? '', 75, " ", STR_PAD_RIGHT)." |";
    $invoice_dot_matrix .= str_pad("", 7, " ", STR_PAD_LEFT);
    $invoice_dot_matrix .= "| Terms            Salesman                       |";

    $invoice_dot_matrix .= "\n";
    $invoice_dot_matrix .= "| ".str_pad($pick_up_by[2] ?? '', 75, " ", STR_PAD_RIGHT)." |";
    $invoice_dot_matrix .= str_pad("", 7, " ", STR_PAD_LEFT);
    $invoice_dot_matrix .= "|                  ".str_pad(substr($salesman, 0, 30), 30, " ", STR_PAD_RIGHT)." |";

    $invoice_dot_matrix .= "\n";
    $invoice_dot_matrix .= "+".str_pad("", 77, "-", STR_PAD_LEFT)."+";
    $invoice_dot_matrix .= str_pad("", 7, " ", STR_PAD_LEFT);
    $invoice_dot_matrix .= "+".str_pad("", 49, "-", STR_PAD_LEFT)."+";

    $invoice_dot_matrix .= "\n";
    $invoice_dot_matrix .= "+-----+----------------------------------------------------+------+---------+---------------+-------------+-------------+---------------+";

    $invoice_dot_matrix .= "\n";
    $invoice_dot_matrix .= "| No  | Item Description                                   | Qty  | Unit    |     Price     |    Disc     |     Tax     |     Amount    |";

    $invoice_dot_matrix .= "\n";
    $invoice_dot_matrix .= "+-----+----------------------------------------------------+------+---------+---------------+-------------+-------------+---------------+";

    $invoice_dot_matrix .= $detail_barang;

    $invoice_dot_matrix .= "\n";
    $invoice_dot_matrix .= "+-----+----------------------------------------------------+------+---------+---------------+-------------+-------------+---------------+";

    $invoice_dot_matrix .= "\n";
    $invoice_dot_matrix .= "        +---------------------------------------------------------------------+";
    $invoice_dot_matrix .= str_pad("", 7, " ", STR_PAD_LEFT);
    $invoice_dot_matrix .= "+-------------------------------------------------+";

    $invoice_dot_matrix .= "\n";
    $invoice_dot_matrix .= "Say     | ".str_pad($terbilang[0] ?? '', 67, " ", STR_PAD_RIGHT)." |";
    $invoice_dot_matrix .= str_pad("", 7, " ", STR_PAD_LEFT);
    $invoice_dot_matrix .= "| Sub Total      : ".str_pad(substr(formatAngka($sub_total), 0, 30), 30, " ", STR_PAD_LEFT)." |";

    $invoice_dot_matrix .= "\n";
    $invoice_dot_matrix .= "        | ".str_pad($terbilang[1] ?? '', 67, " ", STR_PAD_RIGHT)." |";
    $invoice_dot_matrix .= str_pad("", 7, " ", STR_PAD_LEFT);
    $invoice_dot_matrix .= "| Diskon         : ".str_pad(substr(formatAngka($dataRows[$i]['diskon_faktur']), 0, 30), 30, " ", STR_PAD_LEFT)." |";

    $invoice_dot_matrix .= "\n";
    $invoice_dot_matrix .= "        | ".str_pad($terbilang[2] ?? '', 67, " ", STR_PAD_RIGHT)." |";
    $invoice_dot_matrix .= str_pad("", 7, " ", STR_PAD_LEFT);
    $invoice_dot_matrix .= "| PPN            : ".str_pad(substr(formatAngka($dataRows[$i]['nominal_ppn']), 0, 30), 30, " ", STR_PAD_LEFT)." |";

    $invoice_dot_matrix .= "\n";
    $invoice_dot_matrix .= "        +---------------------------------------------------------------------+";
    $invoice_dot_matrix .= str_pad("", 7, " ", STR_PAD_LEFT);
    $invoice_dot_matrix .= "+-------------------------------------------------+";

    $invoice_dot_matrix .= "\n";
    $invoice_dot_matrix .= "Payment | ".str_pad($payment[0] ?? '', 67, " ", STR_PAD_RIGHT)." |";
    $invoice_dot_matrix .= str_pad("", 7, " ", STR_PAD_LEFT);
    $invoice_dot_matrix .= "| Total Order    : ".str_pad(substr(formatAngka($dataRows[$i]['total_order']), 0, 30), 30, " ", STR_PAD_LEFT)." |";

    $invoice_dot_matrix .= "\n";
    $invoice_dot_matrix .= "        | ".str_pad($payment[1] ?? '', 67, " ", STR_PAD_RIGHT)." |";
    $invoice_dot_matrix .= str_pad("", 7, " ", STR_PAD_LEFT);
    $invoice_dot_matrix .= "+-------------------------------------------------+";

    $invoice_dot_matrix .= "\n";
    $invoice_dot_matrix .= "        | ".str_pad($payment[2] ?? '', 67, " ", STR_PAD_RIGHT)." |";

    $invoice_dot_matrix .= "\n";
    $invoice_dot_matrix .= "        +---------------------------------------------------------------------+";

    $invoice_dot_matrix .= "\n";
    $invoice_dot_matrix .= str_pad("Doc Prepared By", 46, " ", STR_PAD_RIGHT);
    $invoice_dot_matrix .= str_pad("Ship By", 46, " ", STR_PAD_RIGHT);
    $invoice_dot_matrix .= str_pad("Received By", 45, " ", STR_PAD_RIGHT);

    $invoice_dot_matrix .= "\n";
    $invoice_dot_matrix .= "\n";
    $invoice_dot_matrix .= "\n";
    $invoice_dot_matrix .= str_pad(substr($dataUsers['nama'] ?? '', 0, 45), 45, " ", STR_PAD_RIGHT)." ";
    $invoice_dot_matrix .= str_pad("__________________", 45, " ", STR_PAD_RIGHT)." ";
    $invoice_dot_matrix .= str_pad("__________________", 45, " ", STR_PAD_RIGHT);

    $invoice_dot_matrix .= "\n";
    $invoice_dot_matrix .= str_pad(substr("Date : ".format_tanggal2(date('Y-m-d')), 0, 45), 45, " ", STR_PAD_RIGHT)." ";
    $invoice_dot_matrix .= str_pad(substr("Date : ".format_tanggal2(date('Y-m-d')), 0, 45), 45, " ", STR_PAD_RIGHT)." ";
    $invoice_dot_matrix .= str_pad(substr("Date : ", 0, 45), 45, " ", STR_PAD_RIGHT)." ";

    //echo "<pre>".$invoice_dot_matrix."</pre>";
    $DataEdit .= "<textarea class='cetak-dot-matrix'>".$invoice_dot_matrix."</textarea>";

  }

 function addDetailBarang($text, $no, $item_description, $qty, $unit, $price, $disc, $tax, $amount, $dept, $proyek)
  { $l_no = 3;
    $l_item_description = 50;
    $l_qty = 4;
    $l_unit = 7;
    $l_price = 13;
    $l_disc = 11;
    $l_tax = 11;
    $l_amount = 13;

    $no = trim($no ?? '');
    $item_description = trim($item_description ?? '');
    $qty = trim($qty ?? '');
    $unit = trim($unit ?? '');
    $price = trim($price ?? '');
    $disc = trim($disc ?? '');
    $tax = trim($tax ?? '');
    $amount = trim($amount ?? '');
    $dept = trim($dept ?? '');
    $proyek = trim($proyek ?? '');

    $p_no = str_pad(substr($no, 0, $l_no), $l_no, " ", STR_PAD_LEFT);
    $no = substr($no, $l_no, strlen($no) - 1);

    $p_item_description = str_pad(substr($item_description, 0, $l_item_description), $l_item_description, " ", STR_PAD_RIGHT);
    $item_description = substr($item_description, $l_item_description, strlen($item_description) - 1);

    $p_qty = str_pad(substr($qty, 0, $l_qty), $l_qty, " ", STR_PAD_LEFT);
    $qty = substr($qty, $l_qty, strlen($qty) - 1);

    $p_unit = str_pad(substr($unit, 0, $l_unit), $l_unit, " ", STR_PAD_RIGHT);
    $unit = substr($unit, $l_unit, strlen($unit) - 1);

    $p_price = str_pad(substr($price, 0, $l_price), $l_price, " ", STR_PAD_LEFT);
    $price = substr($price, $l_price, strlen($price) - 1);

    $p_disc = str_pad(substr($disc, 0, $l_disc), $l_disc, " ", STR_PAD_LEFT);
    $disc = substr($disc, $l_disc, strlen($disc) - 1);

    $p_tax = str_pad(substr($tax, 0, $l_tax), $l_tax, " ", STR_PAD_LEFT);
    $tax = substr($tax, $l_tax, strlen($tax) - 1);

    $p_amount = str_pad(substr($amount, 0, $l_amount), $l_amount, " ", STR_PAD_LEFT);
    $amount = substr($amount, $l_amount, strlen($amount) - 1);

    $text .= "\n";
    $text .= "| ".$p_no." | ".$p_item_description." | ".$p_qty." | ".$p_unit." | ".$p_price." | ".$p_disc." | ".$p_tax." | ".$p_amount." |";

    $no = trim($no ?? '');
    $item_description = trim($item_description ?? '');
    $qty = trim($qty ?? '');
    $unit = trim($unit ?? '');
    $price = trim($price ?? '');
    $disc = trim($disc ?? '');
    $tax = trim($tax ?? '');
    $amount = trim($amount ?? '');
    $dept = trim($dept ?? '');
    $proyek = trim($proyek ?? '');

    if(strlen($no) > 0 || strlen($item_description) > 0 || strlen($qty) || strlen($unit) || strlen($price) || strlen($disc) || strlen($tax) || strlen($amount) || strlen($dept) || strlen($proyek))
     { $text = addDetailBarang($text, $no, $item_description, $qty, $unit, $price, $disc, $tax, $amount, $dept, $proyek);
     }
    else
     { //$text .= "\n";
       //$text .= "+-----+--------------------------------+------+---------+---------------+-------------+-------------+---------------+-------+-----------+";
     }
    
    return $text;
  }

 echo " </table>Menampilkan ".count($dataRows)." dari ".$nListView." record";

 echo "<div style='display:none;'>".$DataEdit."</div>";

?>