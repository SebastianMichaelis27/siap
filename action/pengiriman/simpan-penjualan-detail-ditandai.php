<?php

 include("../bjksadkhrej121lkjkjk.php");

 $is_commit = 1;
 mysqli_autocommit($koneksi, FALSE);

 date_default_timezone_set('Asia/Jakarta');
 $info = getdate();
 $date = $info['mday'];
 $month = $info['mon'];
 $year = $info['year'];
 $hour = $info['hours'];
 $min = $info['minutes'];
 $sec = $info['seconds'];
 $now = $year."-".str_pad($month,2,"0",STR_PAD_LEFT)."-".str_pad($date,2,"0",STR_PAD_LEFT)." ".str_pad($hour,2,"0",STR_PAD_LEFT).":".str_pad($min,2,"0",STR_PAD_LEFT).":".str_pad($sec,2,"0",STR_PAD_LEFT);
 $tahun = date('Y', strtotime($now));

 $telah_ditandai = array();
 if(isset($_POST['telah_ditandai']) && $_POST['telah_ditandai'])
  { $telah_ditandai = json_decode($_POST['telah_ditandai'], true);
  }

 foreach($telah_ditandai as $key => $value)
  { $query = "update penjualan_detail_ditandai set jumlah = ".$value['jumlah']." where id = ".$value['id']." and ifnull(dikirim, 0) <= ".$value['jumlah'];
    $execute = mysqli_query($koneksi, $query);
    if(!$execute)
     { $is_commit = 0;
     }

    //hapus penjualan_detail_ditandai yang jumlahnya 0
    $query = "delete from penjualan_detail_ditandai where ifnull(jumlah, 0) = 0 and id = ".$value['id'];
    $execute = mysqli_query($koneksi, $query);
    if(!$execute)
     { $is_commit = 0;
     }

    //update jumlah_ditandai pada tabel penjualan_detail
    $query = "update penjualan_detail set jumlah_ditandai = (select sum(ifnull(jumlah, 0)) from penjualan_detail_ditandai where penjualan_detail_id = ".$value['penjualan_detail_id'].") where id = ".$value['penjualan_detail_id'];
    $execute = mysqli_query($koneksi, $query);
    if(!$execute)
     { $is_commit = 0;
     }

    $query = "select * from penjualan_detail where id = ".$value['penjualan_detail_id']." and ifnull(jumlah_ditandai, 0) > ifnull(jumlah, 0)";
    $execute = mysqli_query($koneksi, $query);
    if(mysqli_num_rows($execute) > 0)
     { $is_commit = 0;
     }

    //set ditandai pada tabel penjualan_detail
    $is_commit = setDetail($koneksi, $is_commit, "penjualan_detail", "penjualan_detail_ditandai", $value['penjualan_detail_id']);

    //set detail pada tabel penjualan
    $is_commit = setDetail($koneksi, $is_commit, "penjualan", "penjualan_detail", $value['penjualan_id']);

    //set terjual pada tabel barang_masuk_detail
    $query2 = "select id from barang_masuk_detail where id in (select barang_masuk_detail_id from penjualan_detail_ditandai where penjualan_detail_id in (select id from penjualan_detail where penjualan_id = '".$value['penjualan_id']."'))";
    $execute2 = mysqli_query($koneksi, $query2);
    while($row2 = mysqli_fetch_array($execute2))
     { $query3 = "update barang_masuk_detail set terjual = (select sum(ifnull(jumlah, 0)) from penjualan_detail_ditandai where barang_masuk_detail_id = '".$row2['id']."') where id = '".$row2['id']."'";
       $execute3 = mysqli_query($koneksi, $query3);
       if(!$execute3)
        { $is_commit = 0;
        }
     }
    //set detail pada tabel barang_masuk
    $query2 = "select id from barang_masuk where id in (select barang_masuk_id from barang_masuk_detail where id in (select barang_masuk_detail_id from penjualan_detail_ditandai where penjualan_detail_id in (select id from penjualan_detail where penjualan_id = '".$value['penjualan_id']."')))";
    $execute2 = mysqli_query($koneksi, $query2);
    while($row2 = mysqli_fetch_array($execute2))
     { $is_commit = setDetail($koneksi, $is_commit, "barang_masuk", "barang_masuk_detail", $row2['id']);
     }

    if($is_commit == 1)
     { mysqli_commit($koneksi);
     }
    else
     { mysqli_rollback($koneksi);
     }

  }

?>