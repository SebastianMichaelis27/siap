<?php

 include("../bjksadkhrej121lkjkjk.php");
 include("function.php");

 $is_commit = 1;
 mysqli_autocommit($koneksi, FALSE);

 $pengiriman_id = intval($_POST['id']);

 $query2 = "select pengiriman_id as id from pengiriman_detail where pengiriman_id = '".$pengiriman_id."' group by pengiriman_id";
 $execute2 = mysqli_query($koneksi, $query2);
 $all_pengiriman = mysqli_fetch_all($execute2, MYSQLI_ASSOC);

 $query2 = "select id from penjualan_detail where id in (select penjualan_detail_id from penjualan_detail_ditandai where id in (select penjualan_detail_ditandai_id from pengiriman_detail where pengiriman_id = '".$pengiriman_id."'))";
 $execute2 = mysqli_query($koneksi, $query2);
 $all_penjualan_detail = mysqli_fetch_all($execute2, MYSQLI_ASSOC);

 $query2 = "select id from penjualan where id in (select penjualan_id from penjualan_detail where id in (select penjualan_detail_id from penjualan_detail_ditandai where id in (select penjualan_detail_ditandai_id from pengiriman_detail where pengiriman_id = '".$pengiriman_id."')))";
 $execute2 = mysqli_query($koneksi, $query2);
 $all_penjualan = mysqli_fetch_all($execute2, MYSQLI_ASSOC);

 //update jumlah = 0 pada tabel pengiriman_detail
 $query2 = "update pengiriman_detail set jumlah = 0 where pengiriman_id = '".$pengiriman_id."'";
 $execute2 = mysqli_query($koneksi, $query2);
 if(!$execute2)
  { $is_commit = 0;
  }

 $is_commit = paketUpdate($koneksi, $pengiriman_id, $is_commit);

 //hapus data pengiriman_detail yang jumlahnya 0
 $query2 = "delete from pengiriman_detail where pengiriman_id = '".$pengiriman_id."'";
 $execute2 = mysqli_query($koneksi, $query2);
 if(!$execute2)
  { $is_commit = 0;
  }
 //set detail pada tabel pengiriman
 foreach($all_pengiriman as $index_pengiriman => $value_pengiriman)
  { $is_commit = setDetail($koneksi, $is_commit, "pengiriman", "pengiriman_detail", $value_pengiriman['id']);
  }

 //set ditandai pada tabel penjualan_detail
 foreach($all_penjualan_detail as $index_penjualan_detail => $value_penjualan_detail)
  { $is_commit = setDetail($koneksi, $is_commit, "penjualan_detail", "penjualan_detail_ditandai", $value_penjualan_detail['id']);
  }

 //hapus data penjualan_detail yang jumlahnya 0
 $query2 = "delete from penjualan_detail where id in (select penjualan_detail_id from penjualan_detail_ditandai where id in (select penjualan_detail_ditandai_id from pengiriman_detail where pengiriman_id = '".$pengiriman_id."') and ifnull(jumlah, 0) = 0)";
 $execute2 = mysqli_query($koneksi, $query2);
 if(!$execute2)
  { $is_commit = 0;
  }
 //set detail pada tabel penjualan
 foreach($all_penjualan as $index_penjualan => $value_penjualan)
  { $is_commit = setDetail($koneksi, $is_commit, "penjualan", "penjualan_detail", $value_penjualan['id']);
  }

 $query = "delete from ".$_POST['Nama_Tabel']." where id = '".intval($_POST['id'])."'";
 $execute = mysqli_query($koneksi, $query);
 if(!$execute)
  { $is_commit = 0;
  }

 if($is_commit == 1)
  { mysqli_commit($koneksi);
    echo "1";
  }
 else
  { mysqli_rollback($koneksi);
  }

?>