<?php

 function paketUpdate($koneksi, $pengiriman_id, $is_commit)
  { 
    //update dikirim pada tabel penjualan_detail_ditandai
    $query2 = "select id from penjualan_detail_ditandai where id in (select penjualan_detail_ditandai_id from pengiriman_detail where pengiriman_id = '".$pengiriman_id."')";
    $execute2 = mysqli_query($koneksi, $query2);
    while($row2 = mysqli_fetch_array($execute2))
     { $query3 = "update penjualan_detail_ditandai set dikirim = (select sum(ifnull(jumlah, 0)) from pengiriman_detail where penjualan_detail_ditandai_id = '".$row2['id']."') where id = '".$row2['id']."'";
       $execute3 = mysqli_query($koneksi, $query3);
       if(!$execute3)
        { $is_commit = 0;
        }
     }

    //update jumlah_dikirim, ditandai pada tabel penjualan_detail
    $query2 = "select id from penjualan_detail where id in (select penjualan_detail_id from penjualan_detail_ditandai where id in (select penjualan_detail_ditandai_id from pengiriman_detail where pengiriman_id = '".$pengiriman_id."'))";
    $execute2 = mysqli_query($koneksi, $query2);
    while($row2 = mysqli_fetch_array($execute2))
     { $query3 = "update penjualan_detail set jumlah_dikirim = (select sum(ifnull(dikirim, 0)) from penjualan_detail_ditandai where penjualan_detail_id = '".$row2['id']."') where id = '".$row2['id']."'";
       $execute3 = mysqli_query($koneksi, $query3);
       if(!$execute3)
        { $is_commit = 0;
        }
       $is_commit = setDetail($koneksi, $is_commit, 'penjualan_detail', 'penjualan_detail_ditandai', $row2['id']);
     }

    //update terjual, dikirim pada tabel barang_masuk_detail
    $query2 = "select id from barang_masuk_detail where id in (select barang_masuk_detail_id from penjualan_detail_ditandai where id in (select penjualan_detail_ditandai_id from pengiriman_detail where pengiriman_id = '".$pengiriman_id."'))";
    $execute2 = mysqli_query($koneksi, $query2);
    while($row2 = mysqli_fetch_array($execute2))
     {  $query3 = "update barang_masuk_detail set terjual = (select sum(ifnull(jumlah, 0)) from penjualan_detail_ditandai where barang_masuk_detail_id = '".$row2['id']."'), dikirim = (select sum(ifnull(dikirim, 0)) from penjualan_detail_ditandai where barang_masuk_detail_id = '".$row2['id']."') where id = '".$row2['id']."'";
       $execute3 = mysqli_query($koneksi, $query3);
       if(!$execute3)
        { $is_commit = 0;
        }
     }

    //update detail pada tabel penjualan
    $query2 = "select id from penjualan where id in (select penjualan_id from penjualan_detail where id in (select penjualan_detail_id from penjualan_detail_ditandai where id in (select penjualan_detail_ditandai_id from pengiriman_detail where pengiriman_id = '".$pengiriman_id."')))";
    $execute2 = mysqli_query($koneksi, $query2);
    while($row2 = mysqli_fetch_array($execute2))
     { $is_commit = setDetail($koneksi, $is_commit, 'penjualan', 'penjualan_detail', $row2['id']);
     }

    //set detail pada tabel barang_masuk
    $query2 = "select id from barang_masuk where id in (select barang_masuk_id from barang_masuk_detail where id in (select barang_masuk_detail_id from penjualan_detail_ditandai where id in (select penjualan_detail_ditandai_id from pengiriman_detail where pengiriman_id = '".$pengiriman_id."')))";
    $execute2 = mysqli_query($koneksi, $query2);
    while($row2 = mysqli_fetch_array($execute2))
     { $is_commit = setDetail($koneksi, $is_commit, 'barang_masuk', 'barang_masuk_detail', $row2['id']);
     }

    //update jumlah_ditandai pada tabel penjualan_detail
    $query2 = "select id from penjualan_detail where id in (select penjualan_detail_id from penjualan_detail_ditandai where id in (select penjualan_detail_ditandai_id from pengiriman_detail where pengiriman_id = '".$pengiriman_id."'))";
    $execute2 = mysqli_query($koneksi, $query2);
    while($row2 = mysqli_fetch_array($execute2))
     { $query3 = "update penjualan_detail set jumlah_ditandai = (select sum(ifnull(jumlah, 0)) from penjualan_detail_ditandai where penjualan_detail_id = '".$row2['id']."') where id = '".$row2['id']."'";
       $execute3 = mysqli_query($koneksi, $query3);
       if(!$execute3)
        { $is_commit = 0;
        }
     }

    return $is_commit;
  }

?>