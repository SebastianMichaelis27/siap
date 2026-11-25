<?php
 include("../bjksadkhrej121lkjkjk.php");

 /*
 penjualan_detail_ditandai_id;
 barang_masuk_detail_id;
 jumlah;
 */

 date_default_timezone_set('Asia/Jakarta');
 $info = getdate();
 $date = $info['mday'];
 $month = $info['mon'];
 $year = $info['year'];
 $hour = $info['hours'];
 $min = $info['minutes'];
 $sec = $info['seconds'];
 $now = $year."-".str_pad($month,2,"0",STR_PAD_LEFT)."-".str_pad($date,2,"0",STR_PAD_LEFT)." ".str_pad($hour,2,"0",STR_PAD_LEFT).":".str_pad($min,2,"0",STR_PAD_LEFT).":".str_pad($sec,2,"0",STR_PAD_LEFT);

 $is_commit = 1;
 mysqli_autocommit($koneksi, FALSE);

 $pindah_rak = array();
 if(isset($_POST['pindah_rak']) && $_POST['pindah_rak'] !== "")
  { $pindah_rak = json_decode($_POST['pindah_rak'], true);
  }

 $grouped_by_barang_masuk_detail_id = array_group_by($pindah_rak, function($person) {
  return $person['barang_masuk_detail_id'];
 });

 $barang_masuk_id = "";
 $pembelian_detail_id = "";
 $query = "select * from barang_masuk_detail where id = ".intval($_POST['barang_masuk_detail_id']);
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $barang_masuk_id = $row['barang_masuk_id'];
    $pembelian_detail_id = $row['pembelian_detail_id'];
  }

 $total_jumlah = 0;
 foreach($pindah_rak as $key => $value)
  { $total_jumlah += $value['jumlah'];
  }

 //turunkan jumlah pada barang_masuk_detail yang lama
 $query = "update barang_masuk_detail set jumlah = jumlah - ".$total_jumlah." where id = ".intval($_POST['barang_masuk_detail_id']);
 $execute = mysqli_query($koneksi, $query);
 if(!$execute)
  { $is_commit = 0;
  }

 //cek rak yang sama
 $arrayBarangMasukDetailId = array(intval($_POST['barang_masuk_detail_id']));
 $query = "select id from barang_masuk_detail where pembelian_detail_id = '".$pembelian_detail_id."' and rak_id = '".intval($_POST['rak_id'])."'";
 $execute = mysqli_query($koneksi, $query);
 if(mysqli_num_rows($execute) > 0)
  { while($row = mysqli_fetch_array($execute))
     { $barang_masuk_detail_id = $row['id'];
       array_push($arrayBarangMasukDetailId, $barang_masuk_detail_id);
       $query1 = "update barang_masuk_detail set jumlah = jumlah + ".$total_jumlah." where id = '".$barang_masuk_detail_id."'";
       $execute1 = mysqli_query($koneksi, $query1);
       if(!$execute1)
        { $is_commit = 0;
        }
       $is_commit = paketUpdatePenjualanDetailDitandai($koneksi, $is_commit, $pindah_rak, $barang_masuk_detail_id);
     }
  }
 else
  { //buat barang_masuk_detail yang baru"
    $query1 = "insert into barang_masuk_detail(barang_masuk_id, pembelian_detail_id, rak_id, jumlah) values('".$barang_masuk_id."', '".$pembelian_detail_id."', '".intval($_POST['rak_id'])."', '".$total_jumlah."')";
    $execute1 = mysqli_query($koneksi, $query1);
    if($execute1)
     { $barang_masuk_detail_id = mysqli_insert_id($koneksi);
       array_push($arrayBarangMasukDetailId, $barang_masuk_detail_id);
       $is_commit = paketUpdatePenjualanDetailDitandai($koneksi, $is_commit, $pindah_rak, $barang_masuk_detail_id);
     }
    else
     { $is_commit = 0;
     }
  }

 $barang_masuk_detail_id_list = implode(',', $arrayBarangMasukDetailId);

 //hapus data pada tabel barang_masuk_detail yang jumlah nya 0
 $query = "delete from barang_masuk_detail where ifnull(jumlah, 0) = 0 and id in (".$barang_masuk_detail_id_list.")";
 $execute = mysqli_query($koneksi, $query);
 if(!$execute)
  { $is_commit = 0;
  }

 //hapus data pada tabel penjualan_detail_ditandai yang jumlah nya 0
 $query = "delete from penjualan_detail_ditandai where ifnull(jumlah, 0) = 0 and barang_masuk_detail_id in (".$barang_masuk_detail_id_list.")";
 $execute = mysqli_query($koneksi, $query);
 if(!$execute)
  { $is_commit = 0;
  }

 $query = "select penjualan_detail_id from penjualan_detail_ditandai where barang_masuk_detail_id in (".$barang_masuk_detail_id_list.") group by penjualan_detail_id";
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { //set jumlah_ditandai pada tabel penjualan_detail
    $query1 = "update penjualan_detail set jumlah_ditandai = (select sum(ifnull(jumlah, 0)) from penjualan_detail_ditandai where penjualan_detail_id = '".$row['penjualan_detail_id']."') where id = '".$row['penjualan_detail_id']."'";
    $execute1 = mysqli_query($koneksi, $query1);
    if(!$execute1)
     { $is_commit = 0;
     }
    //set ditandai pada tabel penjualan_detail
    $is_commit = setDetail($koneksi, $is_commit, "penjualan_detail", "penjualan_detail_ditandai", $row['penjualan_detail_id']);
  }

 //set detail pada tabel penjualan
 $query = "select id from penjualan where id in (select penjualan_id from penjualan_detail where id in (select penjualan_detail_id from penjualan_detail_ditandai where barang_masuk_detail_id in (".$barang_masuk_detail_id_list.") group by penjualan_detail_id))";
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $is_commit = setDetail($koneksi, $is_commit, "penjualan", "penjualan_detail", $row['id']);
  }

 foreach($arrayBarangMasukDetailId as $key => $value)
  { //set terjual pada tabel barang_masuk_detail
    $query = "update barang_masuk_detail set terjual = (select sum(ifnull(jumlah, 0)) from penjualan_detail_ditandai where barang_masuk_detail_id = '".$value."') where id = '".$value."'";
    $execute = mysqli_query($koneksi, $query);
    if(!$execute)
     { $is_commit = 0;
     }
  }

 //set detail pada tabel barang_masuk
 $query = "select id from barang_masuk where id in (select barang_masuk_id from barang_masuk_detail where id in (".$barang_masuk_detail_id_list."))";
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $is_commit = setDetail($koneksi, $is_commit, "barang_masuk", "barang_masuk_detail", $row['id']);
  }

 //cek kapasitas
 $query = "select * from barang_masuk_detail where ifnull(jumlah, 0) < 0 and id in (".$barang_masuk_detail_id_list.") limit 1";
 $execute = mysqli_query($koneksi, $query);
 if(mysqli_num_rows($execute) > 0)
  { $is_commit = 0;
    echo "\nJumlah yang dipindahkan melebihi jumlah yang tersedia!";
  }
 $query = "select concat(penjualan.kode, ' ', lpad(penjualan.nomor, if(3 > length(penjualan.nomor), 3, length(penjualan.nomor)), '0'), '/', right(penjualan.tahun, 2)) as nomor_penjualan from penjualan_detail_ditandai left join penjualan_detail on penjualan_detail_ditandai.penjualan_detail_id = penjualan_detail.id left join penjualan on penjualan_detail.penjualan_id = penjualan.id where ifnull(penjualan_detail_ditandai.jumlah, 0) < 0 and penjualan_detail_ditandai.barang_masuk_detail_id in (".$barang_masuk_detail_id_list.")";
 $execute = mysqli_query($koneksi, $query);
 if(mysqli_num_rows($execute) > 0)
  { $is_commit = 0;
    while($row = mysqli_fetch_array($execute))
     { echo "\nJumlah yang dipindahkan melebihi jumlah yang tersedia (Nomor Penjualan : ".$row['nomor_penjualan'].")!";
     }
  }
 

 function paketUpdatePenjualanDetailDitandai($koneksi, $is_commit, $pindah_rak, $barang_masuk_detail_id)
  {
    foreach($pindah_rak as $key => $value)
     { //turunkan jumlah pada penjualan_detail_ditandai
       $query2 = "update penjualan_detail_ditandai set jumlah = jumlah - ".$value['jumlah']." where id = '".$value['penjualan_detail_ditandai_id']."'";
       $execute2 = mysqli_query($koneksi, $query2);
       if(!$execute2)
        { $is_commit = 0;
        }

       //cari penjualan_detail_id 
       $penjualan_detail_id = "";
       $query2 = "select penjualan_detail_id from penjualan_detail_ditandai where id = '".$value['penjualan_detail_ditandai_id']."'";
       $execute2 = mysqli_query($koneksi, $query2);
       while($row2 = mysqli_fetch_array($execute2))
        { $penjualan_detail_id = $row2['penjualan_detail_id'];
        }

       if(isset($penjualan_detail_id) && $penjualan_detail_id !== "")
        { //cek penjualan_detail_ditandai yang sama
          $query2 = "select id from penjualan_detail_ditandai where penjualan_detail_id = '".$penjualan_detail_id."' and barang_masuk_detail_id = '".$barang_masuk_detail_id."'";
          $execute2 = mysqli_query($koneksi, $query2);
          if(mysqli_num_rows($execute2) > 0)
           { while($row2 = mysqli_fetch_array($execute2))
              { $query3 = "update penjualan_detail_ditandai set jumlah = jumlah + ".$value['jumlah']." where id = '".$row2['id']."'";
                $execute3 = mysqli_query($koneksi, $query3);
                if(!$execute3)
                 { $is_commit = 0;
                 }
              }
           }
          else
           { //insert penjualan_detail_ditandai yang baru
             $query3 = "insert into penjualan_detail_ditandai(penjualan_detail_id, barang_masuk_detail_id, jumlah) values('".$penjualan_detail_id."', '".$barang_masuk_detail_id."', '".$value['jumlah']."')";
             $execute3 = mysqli_query($koneksi, $query3);
             if(!$execute3)
              { $is_commit = 0;
              }
           }
        }

     }

    return $is_commit;
  }

 if($is_commit == 1)
  { mysqli_commit($koneksi);
    echo "1";
  }
 else
  { mysqli_rollback($koneksi);
  }

?>