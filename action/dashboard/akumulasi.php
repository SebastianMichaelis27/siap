<?php
 include("../bjksadkhrej121lkjkjk.php");

 $now = date('Y-m-d');
 $dari = $_POST['dari'] ?? date('Y-m-d', strtotime('-7 day', strtotime($now)));
 $sampai = $_POST['sampai'] ?? $now;
 $periode = $_POST['periode'] ?? "harian";
 $cabang_id_ = $_POST['cabang_id_'] ?? null;


 $dataPeriode = array();
 if($periode == "harian")
  { $satu_hari = 86400;
    $start = intval(strtotime($dari));
    $end = intval(strtotime($sampai));
    for($i=$start; $i<=$end; $i+=$satu_hari)
     { array_push($dataPeriode, array(
        "dari" => date('Y-m-d', $i),
        "sampai" => date('Y-m-d', $i),
       ));
     }
  }
 else if($periode == "mingguan")
  { $start = intval(strtotime($dari));
    $end = intval(strtotime($sampai));
    $dataPeriode = getPeriodeMinggu($dataPeriode, $start, $end);
  }
 else if($periode == "bulanan")
  { $tanggal = intval(strtotime($dari));
    $batas = intval(strtotime($sampai));
    $dataPeriode = getPeriodeBulan($dataPeriode, $tanggal, $batas);
  }
 else if($periode == "tahunan")
  { $tanggal = intval(strtotime($dari));
    $batas = intval(strtotime($sampai));
    $dataPeriode = getPeriodeTahun($dataPeriode, $tanggal, $batas);
  }

 function getPeriodeTahun($dataPeriode, $tanggal, $batas)
  { $tahun_berjalan = intval(date('Y', $tanggal));
    $tahun_batas = (date('Y', $batas));
    if($tahun_berjalan < $tahun_batas)
     { array_push($dataPeriode, array(
        "dari" => date('Y-m-d', $tanggal),
        "sampai" => $tahun_berjalan."-12-31",
       ));
       $tanggal = intval(strtotime(($tahun_berjalan + 1)."-01-01"));
       $dataPeriode = getPeriodeTahun($dataPeriode, $tanggal, $batas);
     }
    else
     { array_push($dataPeriode, array(
        "dari" => date('Y-m-d', $tanggal),
        "sampai" => date('Y-m-d', $batas),
       ));
     }
    return $dataPeriode;
  }

 function getPeriodeBulan($dataPeriode, $tanggal, $batas)
  { $tanggal_tertinggi = date('t', $tanggal);
    $tanggal_tertinggi = intval(strtotime(date('Y-m-', $tanggal).$tanggal_tertinggi));
    if($tanggal_tertinggi < $batas)
     { array_push($dataPeriode, array(
        "dari" => date('Y-m-d', $tanggal),
        "sampai" => date('Y-m-d', $tanggal_tertinggi),
       ));
       $tanggal = $tanggal_tertinggi + 86400;
       $dataPeriode = getPeriodeBulan($dataPeriode, $tanggal, $batas);
     }
    else
     { array_push($dataPeriode, array(
        "dari" => date('Y-m-d', $tanggal),
        "sampai" => date('Y-m-d', $batas),
       ));
     }
    return $dataPeriode;
  }

 function getPeriodeMinggu($dataPeriode, $tanggal, $end, $dari = null)
  { if($dari == null)
     { $dari = date('Y-m-d', $tanggal);
     }
    if($tanggal <= $end)
     { if(date('D', $tanggal) == "Sun")
        { array_push($dataPeriode, array(
           "dari" => $dari,
           "sampai" => date('Y-m-d', $tanggal),
          ));
          $dari = date('Y-m-d', $tanggal + 86400);
          $tanggal += 86400 * 7;
          $dataPeriode = getPeriodeMinggu($dataPeriode, $tanggal, $end, $dari);
        }
       else
        { $tanggal += 86400;
          $dataPeriode = getPeriodeMinggu($dataPeriode, $tanggal, $end, $dari);
        }
     }
    else if(intval(strtotime($dari)) <= $end)
     { array_push($dataPeriode, array(
        "dari" => $dari,
        "sampai" => date('Y-m-d', $end),
       ));
     }
    return $dataPeriode;
  }

 $jumlah_pembelian = 0;
 $jumlah_penawaran = 0;
 $jumlah_tanggapan = 0;
 $jumlah_pesanan = 0;
 $jumlah_penjualan = 0;
 $total_pembelian = 0;
 $total_penawaran = 0;
 $total_tanggapan = 0;
 $total_pesanan = 0;
 $total_penjualan = 0;
 for($i=0; $i<count($dataPeriode); $i++)
  { $dataPeriode[$i]['periode'] = date('d-m-y', strtotime($dataPeriode[$i]['sampai']));

    $types = "ss";

    $filter = [];
    $filter[] = "tanggal >= ?";
    $filter[] = "tanggal <= ?";

    $params = [];
    $params[] = $dataPeriode[$i]['dari'];
    $params[] = $dataPeriode[$i]['sampai'];

    if(isset($cabang_id_) && $cabang_id_ !== "")
     { $types .= "i";
       $filter[] = "cabang_id = ?";
       $params[] = $cabang_id_;
     }

    //Pembelian----------------------------------------------------------------------------------------------------------
    $execute = $koneksi->prepare("select ifnull(count(*), 0) as jumlah, ifnull(sum(ifnull(total, 0)), 0) as total from pembelian where ".implode(" and ", $filter));
    if(count($params) > 0)
     { $execute->bind_param($types, ...$params);
     }
    $execute->execute();
    $result = $execute->get_result();
    $dataPembelian = $result->fetch_assoc();
    $dataPeriode[$i]['jumlah_pembelian'] = $dataPembelian['jumlah'] ?? 0;
    $dataPeriode[$i]['total_pembelian'] = $dataPembelian['total'] ?? 0;
    //Pembelian----------------------------------------------------------------------------------------------------------

    //Penawaran----------------------------------------------------------------------------------------------------------
    $execute = $koneksi->prepare("select ifnull(count(*), 0) as jumlah, ifnull(sum(ifnull(total, 0)), 0) as total from penawaran where ".implode(" and ", $filter));
    if(count($params) > 0)
     { $execute->bind_param($types, ...$params);
     }
    $execute->execute();
    $result = $execute->get_result();
    $dataPenawaran = $result->fetch_assoc();
    $dataPeriode[$i]['jumlah_penawaran'] = $dataPenawaran['jumlah'] ?? 0;
    $dataPeriode[$i]['total_penawaran'] = $dataPenawaran['total'] ?? 0;
    //Penawaran----------------------------------------------------------------------------------------------------------

    //Tanggapan----------------------------------------------------------------------------------------------------------
    $execute = $koneksi->prepare("select ifnull(count(*), 0) as jumlah, ifnull(sum(ifnull(penjualan_detail.total, 0)), 0) as total from penjualan_detail left join penjualan on penjualan_detail.penjualan_id = penjualan.id where penjualan_detail.pesanan_detail_id is not null and ".implode(" and ", array_map(fn($item) => "penjualan.".$item, $filter))." group by penjualan_detail.penjualan_id");
    if(count($params) > 0)
     { $execute->bind_param($types, ...$params);
     }
    $execute->execute();
    $result = $execute->get_result();
    $dataTanggapan = $result->fetch_assoc();
    $dataPeriode[$i]['jumlah_tanggapan'] = $dataTanggapan['jumlah'] ?? 0;
    $dataPeriode[$i]['total_tanggapan'] = $dataTanggapan['total'] ?? 0;
    //Tanggapan----------------------------------------------------------------------------------------------------------

    //Pesanan------------------------------------------------------------------------------------------------------------
    $execute = $koneksi->prepare("select ifnull(count(*), 0) as jumlah, ifnull(sum(ifnull(total, 0)), 0) as total from pesanan where ".implode(" and ", $filter));
    if(count($params) > 0)
     { $execute->bind_param($types, ...$params);
     }
    $execute->execute();
    $result = $execute->get_result();
    $dataPesanan = $result->fetch_assoc();
    $dataPeriode[$i]['jumlah_pesanan'] = $dataPesanan['jumlah'] ?? 0;
    $dataPeriode[$i]['total_pesanan'] = $dataPesanan['total'] ?? 0;
    //Pesanan------------------------------------------------------------------------------------------------------------

    //Penjualan----------------------------------------------------------------------------------------------------------
    $execute = $koneksi->prepare("select ifnull(count(*), 0) as jumlah, ifnull(sum(ifnull(total, 0)), 0) as total from penjualan where ".implode(" and ", $filter));
    if(count($params) > 0)
     { $execute->bind_param($types, ...$params);
     }
    $execute->execute();
    $result = $execute->get_result();
    $dataPesanan = $result->fetch_assoc();
    $dataPeriode[$i]['jumlah_penjualan'] = $dataPesanan['jumlah'] ?? 0;
    $dataPeriode[$i]['total_penjualan'] = $dataPesanan['total'] ?? 0;
    //Penjualan----------------------------------------------------------------------------------------------------------

    $jumlah_pembelian += $dataPeriode[$i]['jumlah_pembelian'];
    $jumlah_penawaran += $dataPeriode[$i]['jumlah_penawaran'];
    $jumlah_tanggapan += $dataPeriode[$i]['jumlah_tanggapan'];
    $jumlah_pesanan += $dataPeriode[$i]['jumlah_pesanan'];
    $jumlah_penjualan += $dataPeriode[$i]['jumlah_penjualan'];
    $total_pembelian += $dataPeriode[$i]['total_pembelian'];
    $total_penawaran += $dataPeriode[$i]['total_penawaran'];
    $total_tanggapan += $dataPeriode[$i]['total_tanggapan'];
    $total_pesanan += $dataPeriode[$i]['total_pesanan'];
    $total_penjualan += $dataPeriode[$i]['total_penjualan'];

  }

 if(count($dataPeriode) > 31)
  { $dataPeriode = array_slice($dataPeriode, -31);
  }

?>

<div class='col-md-6'>
 <div style='background:white; border:1px solid silver;'>
  <canvas id='grafik_total'></canvas>
 </div>
</div>

<div class='col-md-6'>
 <div style='background:white; border:1px solid silver;'>
  <canvas id='grafik_jumlah'></canvas>
 </div>
</div>

<div style='display:none;'>
 <textarea id='temp-jumlah_pembelian'><?= formatAngka($jumlah_pembelian); ?> Transaksi</textarea>
 <textarea id='temp-jumlah_penawaran'><?= formatAngka($jumlah_penawaran); ?> Transaksi</textarea>
 <textarea id='temp-jumlah_tanggapan'><?= formatAngka($jumlah_tanggapan); ?> Transaksi</textarea>
 <textarea id='temp-jumlah_pesanan'><?= formatAngka($jumlah_pesanan); ?> Transaksi</textarea>
 <textarea id='temp-jumlah_penjualan'><?= formatAngka($jumlah_penjualan); ?> Transaksi</textarea>
 <textarea id='temp-total_pembelian'>Rp<?= formatAngka($total_pembelian); ?></textarea>
 <textarea id='temp-total_penawaran'>Rp<?= formatAngka($total_penawaran); ?></textarea>
 <textarea id='temp-total_tanggapan'>Rp<?= formatAngka($total_tanggapan); ?></textarea>
 <textarea id='temp-total_pesanan'>Rp<?= formatAngka($total_pesanan); ?></textarea>
 <textarea id='temp-total_penjualan'>Rp<?= formatAngka($total_penjualan); ?></textarea>
</div>

<script>

 document.getElementById('jumlah_pembelian').innerHTML = document.getElementById('temp-jumlah_pembelian').value;
 document.getElementById('jumlah_penawaran').innerHTML = document.getElementById('temp-jumlah_penawaran').value;
 document.getElementById('jumlah_tanggapan').innerHTML = document.getElementById('temp-jumlah_tanggapan').value;
 document.getElementById('jumlah_pesanan').innerHTML = document.getElementById('temp-jumlah_pesanan').value;
 document.getElementById('jumlah_penjualan').innerHTML = document.getElementById('temp-jumlah_penjualan').value;
 document.getElementById('total_pembelian').innerHTML = document.getElementById('temp-total_pembelian').value;
 document.getElementById('total_penawaran').innerHTML = document.getElementById('temp-total_penawaran').value;
 document.getElementById('total_tanggapan').innerHTML = document.getElementById('temp-total_tanggapan').value;
 document.getElementById('total_pesanan').innerHTML = document.getElementById('temp-total_pesanan').value;
 document.getElementById('total_penjualan').innerHTML = document.getElementById('temp-total_penjualan').value;
 
 var grafik_total = document.getElementById('grafik_total');
 var data_total = {
  labels: <?= json_encode(array_column($dataPeriode, 'periode')) ?>,
  datasets: [
   { label: 'Pembelian',
     data: <?= json_encode(array_column($dataPeriode, 'total_pembelian')) ?>,
     backgroundColor: '#f39c12',
     borderWidth: 1
   },
   { label: 'Penawaran',
     data: <?= json_encode(array_column($dataPeriode, 'total_penawaran')) ?>,
     backgroundColor: '#00c0ef',
     borderWidth: 1
   },
   { label: 'Tanggapan',
     data: <?= json_encode(array_column($dataPeriode, 'total_tanggapan')) ?>,
     backgroundColor: '#5379c0',
     borderWidth: 1
   },
   { label: 'Pesanan',
     data: <?= json_encode(array_column($dataPeriode, 'total_pesanan')) ?>,
     backgroundColor: '#00a65a',
     borderWidth: 1
   },
   { label: 'Penjualan',
     data: <?= json_encode(array_column($dataPeriode, 'total_penjualan')) ?>,
     backgroundColor: '#dd4b39',
     borderWidth: 1
   }
  ]
 };
 var bar_total = new Chart(grafik_total, {
  type: 'bar',
  data: data_total,
  options: {
   tooltips: {
    callbacks: {
     label: function(tooltipItem, data) {
      var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
      value = value.toString().split(/(?=(?:...)*$)/).join('.');
      return 'Rp. ' + value;
     }
    }
   },
   scales: {
    yAxes: [{
     ticks: {
      userCallback: function(value) {
       value = value.toString().split(/(?=(?:...)*$)/).join('.');
       return 'Rp' + value;
      }
     }
    }]
   }
  }
 });
 
 var grafik_jumlah = document.getElementById('grafik_jumlah');
 var data_jumlah = {
  labels: <?= json_encode(array_column($dataPeriode, 'periode')) ?>,
  datasets: [
   { label: 'Pembelian',
     data: <?= json_encode(array_column($dataPeriode, 'jumlah_pembelian')) ?>,
     backgroundColor: '#f39c12',
     borderWidth: 1
   },
   { label: 'Penawaran',
     data: <?= json_encode(array_column($dataPeriode, 'jumlah_penawaran')) ?>,
     backgroundColor: '#00c0ef',
     borderWidth: 1
   },
   { label: 'Tanggapan',
     data: <?= json_encode(array_column($dataPeriode, 'jumlah_tanggapan')) ?>,
     backgroundColor: '#5379c0',
     borderWidth: 1
   },
   { label: 'Pesanan',
     data: <?= json_encode(array_column($dataPeriode, 'jumlah_pesanan')) ?>,
     backgroundColor: '#00a65a',
     borderWidth: 1
   },
   { label: 'Penjualan',
     data: <?= json_encode(array_column($dataPeriode, 'jumlah_penjualan')) ?>,
     backgroundColor: '#dd4b39',
     borderWidth: 1
   }
  ]
 };
 var bar_jumlah = new Chart(grafik_jumlah, {
  type: 'bar',
  data: data_jumlah,
  options: {
   tooltips: {
    callbacks: {
     label: function(tooltipItem, data) {
      var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
      value = value.toString().split(/(?=(?:...)*$)/).join('.');
      return value;
     }
    }
   },
   scales: {
    yAxes: [{
     ticks: {
      userCallback: function(value) {
       value = value.toString().split(/(?=(?:...)*$)/).join('.');
       return value;
      }
     }
    }]
   }
  }
 });

</script>