<?php
 include("../bjksadkhrej121lkjkjk.php");

 $now = date('Y-m-d');
 $dari = $_POST['dari'] ?? date('Y-m-d', strtotime('-7 day', strtotime($now)));
 $sampai = $_POST['sampai'] ?? $now;
 $periode = $_POST['periode'] ?? "harian";


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

 for($i=0; $i<count($dataPeriode); $i++)
  { $dataPeriode[$i]['periode'] = date('d-m-y', strtotime($dataPeriode[$i]['sampai']));

    $filter = " tanggal >= ? and tanggal <= ?";
    $types = "ss";
    $params = [];
    $params[] = $dataPeriode[$i]['dari'];
    $params[] = $dataPeriode[$i]['sampai'];

    //Pembelian----------------------------------------------------------------------------------------------------------
    $execute = $koneksi->prepare("select ifnull(count(*), 0) as jumlah, ifnull(sum(ifnull(total, 0)), 0) as total from pembelian where ".$filter);
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
    $execute = $koneksi->prepare("select ifnull(count(*), 0) as jumlah, ifnull(sum(ifnull(total, 0)), 0) as total from penawaran where ".$filter);
    if(count($params) > 0)
     { $execute->bind_param($types, ...$params);
     }
    $execute->execute();
    $result = $execute->get_result();
    $dataPenawaran = $result->fetch_assoc();
    $dataPeriode[$i]['jumlah_penawaran'] = $dataPenawaran['jumlah'] ?? 0;
    $dataPeriode[$i]['total_penawaran'] = $dataPenawaran['total'] ?? 0;
    //Penawaran----------------------------------------------------------------------------------------------------------

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

<script>
 
 var grafik_total = document.getElementById('grafik_total');
 var data_total = {
  labels: <?= json_encode(array_column($dataPeriode, 'periode')) ?>,
  datasets: [
   { label: 'Pembelian',
     data: <?= json_encode(array_column($dataPeriode, 'total_pembelian')) ?>,
     fill: false,
     lineTension: 0.1,
     backgroundColor: '#cdcb20',
     borderWidth: 3,
     borderColor: '#f39c12',
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
   { label: 'Penawaran',
     data: <?= json_encode(array_column($dataPeriode, 'total_penawaran')) ?>,
     fill: false,
     lineTension: 0.1,
     backgroundColor: '#4edcff',
     borderWidth: 3,
     borderColor: '#00c0ef',
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
 var bar_total = Chart.Line(grafik_total,{
  data:data_total,
  options:{
    tooltips: {
        callbacks: {
          label: function(tooltipItem, data) {
            var value = data.datasets[0].data[tooltipItem.index];
            value = value.toString();
            value = value.split(/(?=(?:...)*$)/);
            value = value.join('.');
            return 'Rp. ' + value;
          }
        }
    },
    scales: {
        xAxes: [{
          ticks: {}
        }],
        yAxes: [{
          ticks: {
            //beginAtZero: true,
            //stepSize: 500000,

            // Return an empty string to draw the tick line but hide the tick label
            // Return `null` or `undefined` to hide the tick line entirely
            userCallback: function(value, index, values) {
             // Convert the number to a string and splite the string every 3 charaters from the end
             value = value.toString();
             value = value.split(/(?=(?:...)*$)/);
                
             // Convert the array to a string and format the output
             value = value.join('.');
             return 'Rp' + value;
            }
          }
        }]
      },
  }
 });
 
 var grafik_jumlah = document.getElementById('grafik_jumlah');
 var data_jumlah = {
  labels: <?= json_encode(array_column($dataPeriode, 'periode')) ?>,
  datasets: [
   { label: 'Pembelian',
     data: <?= json_encode(array_column($dataPeriode, 'jumlah_pembelian')) ?>,
     fill: false,
     lineTension: 0.1,
     backgroundColor: '#cdcb20',
     borderWidth: 3,
     borderColor: '#f39c12',
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
   { label: 'Penawaran',
     data: <?= json_encode(array_column($dataPeriode, 'jumlah_penawaran')) ?>,
     fill: false,
     lineTension: 0.1,
     backgroundColor: '#4edcff',
     borderWidth: 3,
     borderColor: '#00c0ef',
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
 var bar_jumlah = Chart.Line(grafik_jumlah,{
  data:data_jumlah,
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
            //beginAtZero: true,
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