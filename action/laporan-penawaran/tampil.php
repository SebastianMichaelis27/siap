<?php
 include("../bjksadkhrej121lkjkjk.php");

 function konversiKeHari($nilai)
  { return $nilai * 60 * 60 * 24;
  }

 function ambilBulan($periode, $start_date, $end_date)
  { $start = $start_date;
    if(count($periode) > 0)
     { $start = intval(strtotime($periode[count($periode) - 1]['sampai'])) + konversiKeHari(1);
     }
    $end = intval(strtotime(date('Y-m-t', $start)));
    if($end > $end_date)
     { $end = $end_date;
     }
    array_push($periode, array(
     "dari" => date('Y-m-d', $start),
     "sampai" => date('Y-m-d', $end),
     "label" => date('d/m', $i),
     "penawaran" => 0,
     "penjualan" => 0,
    ));
    if($end < $end_date)
     { $periode = ambilBulan($periode, $start_date, $end_date);
     }
    return $periode;
  }

 function ambilTahun($periode, $start_date, $end_date)
  { $start = $start_date;
    if(count($periode) > 0)
     { $tahun_selanjutnya = intval(date('Y', strtotime($periode[count($periode) - 1]['sampai']))) + 1;
       $start = intval(strtotime(date($tahun_selanjutnya.'-01-01', $start)));
     }
    $end = intval(strtotime(date('Y-12-31', $start)));
    if($end > $end_date)
     { $end = $end_date;
     }
    array_push($periode, array(
     "dari" => date('Y-m-d', $start),
     "sampai" => date('Y-m-d', $end),
     "label" => date('Y', $i),
     "penawaran" => 0,
     "penjualan" => 0,
    ));
    if($end < $end_date)
     { $periode = ambilTahun($periode, $start_date, $end_date);
     }
    return $periode;
  }

 $dari = intval(strtotime(date('Y-m-d')));
 if(isset($_POST['dari_tanggal']) && $_POST['dari_tanggal'] !== "")
  { $dari = intval(strtotime(date('Y-m-d', strtotime($_POST['dari_tanggal']))));
  }

 $sampai = intval(strtotime(date('Y-m-d')));
 if(isset($_POST['sampai_tanggal']) && $_POST['sampai_tanggal'] !== "")
  { $sampai = intval(strtotime(date('Y-m-d', strtotime($_POST['sampai_tanggal']))));
  }

 $periode = array();
 if(isset($_POST['periode_grafik']) && $_POST['periode_grafik'] == "Hari")
  { for($i=$dari; $i<=$sampai; $i=$i+konversiKeHari(1))
     { array_push($periode, array(
        "dari" => date('Y-m-d', $i),
        "sampai" => date('Y-m-d', $i),
        "label" => date('d/m', $i),
        "penawaran" => 0,
        "penjualan" => 0,
       ));
     }
  }
 else if(isset($_POST['periode_grafik']) && $_POST['periode_grafik'] == "Minggu")
  { $start = $dari;
    $end = $dari;
    for($i=$dari; $i<=$sampai; $i=$i+konversiKeHari(1))
     { //ketika ketemu hari sabtu atau ketika tanggal terakhir
       if(date('D', $i) == "Sat" || $i>=$sampai)
        { $end = $i;
          array_push($periode, array(
           "dari" => date('Y-m-d', $start),
           "sampai" => date('Y-m-d', $end),
           "label" => date('d/m', $i),
           "penawaran" => 0,
           "penjualan" => 0,
          ));
          $start = $end + konversiKeHari(1);
        }
     }
  }
 else if(isset($_POST['periode_grafik']) && $_POST['periode_grafik'] == "Bulan")
  { $periode = ambilBulan($periode, $dari, $sampai);
  }
 else if(isset($_POST['periode_grafik']) && $_POST['periode_grafik'] == "Tahun")
  { $periode = ambilTahun($periode, $dari, $sampai);
  }

 $filter = "";
 if(isset($_POST['dari_tanggal']) && $_POST['dari_tanggal'] !== "")
  { if($filter !== "")
     { $filter .= " and";
     }
    $filter .= " penawaran.tanggal >= '".date('Y-m-d', strtotime($_POST['dari_tanggal']))."'";
  }
 if(isset($_POST['sampai_tanggal']) && $_POST['sampai_tanggal'] !== "")
  { if($filter !== "")
     { $filter .= " and";
     }
    $filter .= " penawaran.tanggal <= '".date('Y-m-d', strtotime($_POST['sampai_tanggal']))."'";
  }
 if(isset($_POST['cabang_id_']) && $_POST['cabang_id_'] !== "")
  { if($filter !== "")
     { $filter .= " and";
     }
    $filter .= " penawaran.gudang_id in (select id from gudang where cabang_id = ".intval($_POST['cabang_id_']).")";
  }
 if(isset($_POST['karyawan_id']) && $_POST['karyawan_id'] !== "")
  { $data = array();
    try
     { $data = json_decode($_POST['karyawan_id'], true);
     }
    catch(Exception $ex) {}
    $filter2 = "";
    foreach($data as $key => $value)
     { if($filter2 !== "")
        { $filter2 .= " or";
        }
       $filter2 .= " penawaran.karyawan_id = ".intval($value);
     }
    if($filter2 !== "")
     { $filter .= " and (".$filter2.")";
     }
  }
 if(isset($_POST['jenis_customer_id']) && $_POST['jenis_customer_id'] !== "")
  { $data = array();
    try
     { $data = json_decode($_POST['jenis_customer_id'], true);
     }
    catch(Exception $ex) {}
    $filter2 = "";
    foreach($data as $key => $value)
     { if($filter2 !== "")
        { $filter2 .= " or";
        }
       $filter2 .= " customer.jenis_customer_id = ".intval($value);
     }
    if($filter2 !== "")
     { $filter .= " and (".$filter2.")";
     }
  }

 $dataRows = array();
 $query = "select penawaran.tanggal, penawaran.batas_waktu, penawaran.approved_at, penawaran.rejected_at, penawaran.jumlah_terjual from penawaran left join customer on penawaran.customer_id = customer.id where".$filter;
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { array_push($dataRows, array(
     "tanggal" => intval(strtotime($row['tanggal'])),
     "batas_waktu" => intval(strtotime($row['tanggal'])) + konversiKeHari(intval($row['batas_waktu'])),
     "approved_at" => $row['approved_at'],
     "rejected_at" => $row['rejected_at'],
     "jumlah_terjual" => $row['jumlah_terjual'] * 1,
    ));
  }

 for($i=0; $i<count($periode); $i++)
  { $from = intval(strtotime($periode[$i]['dari']));
    $to = intval(strtotime($periode[$i]['sampai']));
    $penawaran = count(array_values(array_filter($dataRows, function($var) use($from, $to) {
     return ($var['tanggal'] >= $from && $var['tanggal'] <= $to);
    })));
    $penjualan = count(array_values(array_filter($dataRows, function($var) use($from, $to) {
     return ($var['tanggal'] >= $from && $var['tanggal'] <= $to && $var['jumlah_terjual'] > 0);
    })));
    $periode[$i]['penawaran'] = $penawaran;
    $periode[$i]['penjualan'] = $penjualan;
  }

?>
<style>
 #form-cetak table thead tr th, #form-cetak table tbody tr th, #form-cetak table tbody tr td
  { border : 1px solid black;
    padding : 5px 10px;
  }
</style>
<style media='print'>
 @page
  { margin-top: 2mm;
    margin-bottom: 2mm;
    margin-left: 5mm;
    margin-right: 5mm;
  }
 .main-footer, .btn-danger, .box-default, .btn
  { display:none;
  }
</style>

<div style='background:white; padding:10px;'>
 <div style='text-align:right;'><button type='button' class='btn btn-danger' onclick='print();'><i class='fa fa-print'></i></button></div>
 <canvas id='myChart'></canvas>
</div>

<textarea style='display:none;' id='label'><?= json_encode(array_column($periode, 'label')) ?></textarea>
<textarea style='display:none;' id='penawaran'><?= json_encode(array_column($periode, 'penawaran')) ?></textarea>
<textarea style='display:none;' id='penjualan'><?= json_encode(array_column($periode, 'penjualan')) ?></textarea>

<script>

 var label = [];
 try
  { label = JSON.parse(document.getElementById('label').value);
  }
 catch(error) {}

 var penawaran = [];
 try
  { penawaran = JSON.parse(document.getElementById('penawaran').value);
  }
 catch(error) {}

 var penjualan = [];
 try
  { penjualan = JSON.parse(document.getElementById('penjualan').value);
  }
 catch(error) {}
 console.log(penjualan);
 
 var canvas = document.getElementById('myChart');
 var data = {
  labels: label,
  datasets: [
   { label: 'Penawaran',
     data: penawaran,
     fill: false,
     lineTension: 0.1,
     backgroundColor: '#d9cb0078',
     borderWidth: 1,
     borderColor: '##aa9f0478;',
     borderCapStyle: 'round',
     borderJoinStyle: 'round',
     pointBorderColor: 'rgba(75,192,192,1)',
     pointBackgroundColor: '#fff',
     pointBorderWidth: 1,
     pointHoverRadius: 5,
     pointHoverBackgroundColor: 'rgba(75,192,192,1)',
     pointHoverBorderColor: 'rgba(220,220,220,1)',
     pointHoverBorderWidth: 2,
     pointRadius: 3,
     pointHitRadius: 20,
     pointStyle: 'circle',
   },
   { label: 'Penjualan',
     data: penjualan,
     fill: false,
     lineTension: 0.1,
     backgroundColor: '#37ce0078',
     borderWidth: 1,
     borderColor: '#30ae0278',
     borderCapStyle: 'round',
     borderJoinStyle: 'round',
     pointBorderColor: 'rgba(75,192,192,1)',
     pointBackgroundColor: '#fff',
     pointBorderWidth: 1,
     pointHoverRadius: 5,
     pointHoverBackgroundColor: 'rgba(75,192,192,1)',
     pointHoverBorderColor: 'rgba(220,220,220,1)',
     pointHoverBorderWidth: 2,
     pointRadius: 3,
     pointHitRadius: 20,
     pointStyle: 'circle',
   }
  ]
 };
 var myBarChart = Chart.Bar(canvas,{
  data:data,
  options:{
    tooltips: {
        callbacks: {
          label: function(tooltipItem, data) {
            var value = data.datasets[0].data[tooltipItem.index];
            value = value.toString();
            value = value.split(/(?=(?:...)*$)/);
            value = value.join('.');
            return value;
          }
        }
    },
    scales: {
        xAxes: [{
          ticks: {}
        }],
        yAxes: [{
          ticks: {
            beginAtZero: true,
            //stepSize: 500000,

            // Return an empty string to draw the tick line but hide the tick label
            // Return `null` or `undefined` to hide the tick line entirely
            userCallback: function(value, index, values) {
             // Convert the number to a string and splite the string every 3 charaters from the end
             value = value.toString();
             value = value.split(/(?=(?:...)*$)/);
                
             // Convert the array to a string and format the output
             value = value.join('.');
             return value;
            }
          }
        }]
    },
  }
 });

</script>