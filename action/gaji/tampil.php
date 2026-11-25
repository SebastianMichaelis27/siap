<?php
 include("../bjksadkhrej121lkjkjk.php");

 $format_khusus = [];
 if(isset($_POST['format_khusus']) && is_array($_POST['format_khusus']))
  { $format_khusus = $_POST['format_khusus'];
  }

 $where = "";
 $params = [];
 $types = "";

 $cari = [];
 if(isset($_POST['cari']) && $_POST['cari'] !== "")
  { $cari = json_decode($_POST['cari'], true);
  }
 $group_cari = array_values(array_unique(array_column($cari, 'field_pencarian')));
 foreach($group_cari as $field)
  { $table_field = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['Nama_Tabel']).".".preg_replace('/[^a-zA-Z0-9_]/', '', $field);
    $search = array_values(array_filter($cari, function($var) use($field) {
     return ($var['field_pencarian'] == $field);
    }));
    $filter = "";
    foreach($search as $key => $value)
     { if($filter !== "")
        { $filter .= " or ";
        }
       if($value['jenis_pencarian'] == "mirip")
        { $filter .= $table_field." like ?";
          $types .= "s";
          $params[] = "%".$value['value_pencarian']."%";
        }
       else if($value['jenis_pencarian'] == "sama")
        { $filter .= $table_field." = ?";
          $types .= "s";
          $params[] = $value['value_pencarian'];
        }
       else if($value['jenis_pencarian'] == "sebelum")
        { $filter .= $table_field." < ?";
          $types .= "s";
          $params[] = $value['value_pencarian'];
        }
       else if($value['jenis_pencarian'] == "setelah")
        { $filter .= $table_field." > ?";
          $types .= "s";
          $params[] = $value['value_pencarian'];
        }
       else if($value['jenis_pencarian'] == "berisi" && $value['value_pencarian'] == "berisi")
        { $filter .= "ifnull(".$table_field.", '') <> ''";
        }
       else if($value['jenis_pencarian'] == "berisi" && $value['value_pencarian'] == "tidak_berisi")
        { $filter .= "ifnull(".$table_field.", '') = ''";
        }
       else if($value['jenis_pencarian'] == "periode")
        { $value['value_pencarian'] = date('Y-m-d', strtotime($value['value_pencarian']));
          $value['value_pencarian2'] = date('Y-m-d', strtotime($value['value_pencarian2']));

          $filter .= "(".$table_field." >= ? and ".$table_field." <= ?)";
          $types .= "ss";
          $params[] = $value['value_pencarian'];
          $params[] = $value['value_pencarian2'];
        }
       else if($value['jenis_pencarian'] == "jangkauan")
        { $value['value_pencarian'] = preg_replace('/[^0-9.]/', '', $value['value_pencarian']);
          $value['value_pencarian2'] = preg_replace('/[^0-9.]/', '', $value['value_pencarian2']);

          $filter .= "(".$table_field." >= ? and ".$table_field." <= ?)";
          $types .= "ii";
          $params[] = $value['value_pencarian'];
          $params[] = $value['value_pencarian2'];
        }
     }
    if($filter !== "")
     { $filter = "(".$filter.")";
       if($where == "")
        { $where .= " where ".$filter;
        }
       else
        { $where .= " and ".$filter;
        }
     }
  }

 $order_by = "";
 if(isset($_POST['urutan']) && $_POST['urutan'] !== "")
  { $urutan = json_decode($_POST['urutan'], true);
    foreach($urutan as $key => $value)
     { $table_field = preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['Nama_Tabel']).".".preg_replace('/[^a-zA-Z0-9_]/', '', $value['field_urutan']);
       if($order_by !== "")
        { $order_by .= ", ";
        }
       if($value['jenis_urutan'] == "az")
        { $order_by .= $table_field." asc";
        }
       else
        { $order_by .= $table_field." desc";
        }
     }
  }
 if($order_by == "")
  { $order_by = "id desc";
  }

 $nhalaman = 1;
 $halaman = 1;
 if(isset($_POST['halaman']) && $_POST['halaman'] !== "")
  { $halaman = $_POST['halaman'];
  }

 $nListView = 0;
 $execute = $koneksi->prepare("select count(*) as jlh from ".preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['Nama_Tabel']).$where);
 if(count($params) > 0)
  { $execute->bind_param($types, ...$params);
  }
 $execute->execute();
 $result = $execute->get_result();
 while($row = $result->fetch_assoc())
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

 $dataRows = [];
 $limit = $halaman * $_POST['maxRecord'];
 $start = $limit - $_POST['maxRecord'];
 $execute = $koneksi->prepare("select * from ".preg_replace('/[^a-zA-Z0-9_]/', '', $_POST['Nama_Tabel']).$where." order by ".$order_by." limit ".intval($_POST['maxRecord'])." offset ".$start);
 if(count($params) > 0)
  { $execute->bind_param($types, ...$params);
  }
 $execute->execute();
 $result = $execute->get_result();
 $dataRows = $result->fetch_all(MYSQLI_ASSOC);

 $karyawan_id = array_values(array_unique(array_column($dataRows, 'karyawan_id')));
 $placeholders = implode(',', array_fill(0, count($karyawan_id), '?'));
 $types = str_repeat('i', count($karyawan_id));

 $dataKaryawan = [];
 if(count($karyawan_id) > 0)
  { $execute = $koneksi->prepare("select * from karyawan where id in (".$placeholders.")");
    $execute->bind_param($types, ...$karyawan_id);
    $execute->execute();
    $result = $execute->get_result();
    $dataKaryawan = $result->fetch_all(MYSQLI_ASSOC);
  }

 $list = "";
 $DataEdit = "";
 for($i=0; $i<count($dataRows); $i++)
  { foreach($dataRows[$i] as $key => &$value)
     { if(isset($format_khusus[$key]) && $format_khusus[$key] == "tanggal" && strval($value) !== "")
        { $value = date('d-m-Y', strtotime($value));
        }
       else if(isset($format_khusus[$key]) && $format_khusus[$key] == "nomor" && strval($value) !== "")
        { $value = formatAngka($value);
        }
       else if($key == "uang_makan_per_hari" || $key == "potongan_per_tidak_masuk" || $key == "potongan_per_terlambat_masuk" || $key == "potongan_per_pulang_sebelum_waktunya" || $key == "potongan_per_tidak_absen_masuk" || $key == "potongan_per_tidak_absen_pulang")
        { $value = formatAngka($value);
        }
       $DataEdit .= '<textarea class="textarea_edit-'.$key.'">'.$value.'</textarea>';
     }

    $karyawan = "";
    $index = array_search($dataRows[$i]['karyawan_id'], array_column($dataKaryawan, 'id'));
    if(strval($index) !== "")
     { $karyawan = $dataKaryawan[$index]['nama'];
     }

    $list .= '<tr class="group-hover">
               <td style="text-align:right;">'.(($_POST['maxRecord'] * ($halaman - 1)) + ($i + 1)).'</td>
               <td>'.$dataRows[$i]['tanggal'].'</td>
               <td>'.$karyawan.'</td>
               <td style="text-align:right;">'.$dataRows[$i]['total_gaji'].'</td>
               <td style="text-align:center;">
                <div class="tindakan">
                 <button type="button" class="btn-default btn-view" title="Detail" onclick="view(this);"><i class="fas fa-search"></i></button>
                 <button type="button" class="btn-default btn-edit" title="ubah" onclick="edit(this);"><i class="fas fa-pencil-alt"></i></button>
                 <button type="button" class="btn-default btn-delete" title="Hapus" onclick="konfirmasiHapus(this);"><i class="far fa-trash-alt"></i></button>
                </div>
               </td>
               <td style="text-align:center;">
                <div class="tindakan">
                 <button type="button" class="btn-default btn-cetak" title="Cetak" onclick="cetak(this);"><i class="far fa-file-pdf"></i></button>
                </div>
               </td>
              </tr>';
  }

?>

<table class="table-border">
 <thead>
  <tr>
   <th>No.</th>
   <th>Tanggal</th>
   <th>Karyawan</th>
   <th>Total Gaji</th>
   <th style="width:110px; min-width:110px; max-width:110px; text-align:center;">Tindakan</th>
   <th style="width:40px; min-width:40px; max-width:40px; text-align:center;">Cetak</th>
  </tr>
 </thead>
 <tbody><?= $list ?></tbody>
</table>
<div style="display:none;">
 <textarea id="halaman"><?= $halaman ?></textarea>
 <textarea id="nhalaman"><?= $nhalaman ?></textarea>
 <?= $DataEdit ?>
</div>