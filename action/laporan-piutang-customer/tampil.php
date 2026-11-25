<?php
 include("../bjksadkhrej121lkjkjk.php");

 $cabang_id_ = $_POST['cabang_id_'] ?? null;

 $DataEdit = "";
 $list = "";
 $execute = $koneksi->prepare("select penjualan.*, concat(penjualan.kode, right(year(penjualan.tanggal), 2), lpad(month(penjualan.tanggal), 2, '0'), lpad(day(penjualan.tanggal), 2, '0'), '-MIE-', lpad(penjualan.nomor, if(3 > length(penjualan.nomor), 3, length(penjualan.nomor)), '0') ) as nomor_penjualan from penjualan where ifnull(total, 0) > ifnull(dibayar, 0) and cabang_id = ?");
 $execute->bind_param("i", $cabang_id_);
 $execute->execute();
 $result = $execute->get_result();
 $dataPenjualan = $result->fetch_all(MYSQLI_ASSOC);

 $dataPenjualanTermin = array();
 $penjualan_id = array_values(array_unique(array_column($dataPenjualan, 'id')));
 if(count($penjualan_id) > 0)
  { $placeholders = implode(',', array_fill(0, count($penjualan_id), '?'));
    $types = str_repeat('i', count($penjualan_id));
    $execute = $koneksi->prepare("select * from penjualan_termin where penjualan_id in (".$placeholders.")");
    $execute->bind_param($types, ...$penjualan_id);
    $execute->execute();
    $result = $execute->get_result();
    $dataPenjualanTermin = $result->fetch_all(MYSQLI_ASSOC);
  }

 for($i=0; $i<count($dataPenjualan); $i++)
  { $penjualan_id = $dataPenjualan[$i]['id'];
    $penjualanTermin = array_values(array_filter($dataPenjualanTermin, function($var) use($penjualan_id) {
     return ($var['penjualan_id'] == $penjualan_id && $var['nominal'] > $var['dibayar']);
    }));

    $class = "";
    $keterlambatan = "";
    $batas_pembayaran = "";
    if(isset($penjualanTermin[0]['tanggal']) && $penjualanTermin[0]['tanggal'])
     { $batas_pembayaran = date('d-m-Y', strtotime($penjualanTermin[0]['tanggal']));
       if(intval(strtotime(date('Y-m-d'))) > intval(strtotime($batas_pembayaran)))
        { $class = " class='terlambat'";
          $keterlambatan = intval((intval(strtotime(date('Y-m-d'))) - intval(strtotime($batas_pembayaran))) / (60 * 60 * 24))." Hari";
        }
     }

    $list .= "<tr".$class.">
               <td style='text-align:right;'>".($i + 1)."</td>
               <td>".date('d-m-Y', strtotime($dataPenjualan[$i]['tanggal']))."</td>
               <td class='cetak-invoice' onclick='cetak(this);'>".$dataPenjualan[$i]['nomor_penjualan']."</td>
               <td>".$batas_pembayaran."</td>
               <td>".$keterlambatan."</td>
               <td style='text-align:right;'>".number_format($dataPenjualan[$i]['total'] ?? 0, 2, ",", ".")."</td>
               <td class='pilih-pembayaran' onclick='pilihPembayaran(this);'>".number_format($dataPenjualan[$i]['dibayar'] ?? 0, 2, ",", ".")."</td>
               <td style='text-align:right;'>".number_format($dataPenjualan[$i]['total'] - $dataPenjualan[$i]['dibayar'], 2, ",", ".")."</td>
              </tr>";
    $DataEdit .= "<textarea class='textarea_edit-id'>".$dataPenjualan[$i]['id']."</textarea>
                  <textarea class='textarea_edit-nomor_penjualan'>".$dataPenjualan[$i]['nomor_penjualan']."</textarea>";
  }
?>

<div style='background:white; padding:10px;'>
 <div style='text-align:right;'><button type='button' class='btn btn-danger' onclick='print();'><i class='fa fa-print'></i></button></div>
 <div style='display:grid; grid-template-columns:1fr auto; gap:10px; align-items:end;'>
  <h4><b>LAPORAN PIUTANG CUSTOMER</b></h4>
  <div style='display:grid; grid-template-columns:auto auto auto; font-weight:bold;'>
   <div>TOTAL PIUTANG</div>
   <div style='width:20px; text-align:center;'>:</div>
   <div style='text-align:right;'></div>
  </div>
 </div>
 <div class='responsiveku'>
  <div style='width:200000px;' id='lebar'>
   <table>
    <thead>
     <tr>
      <th style='text-align:center;'>No.</th>
      <th>Tanggal</th>
      <th>No. Invoice</th>
      <th>Batas Pembayaran</th>
      <th>Terlambat</th>
      <th>Total</th>
      <th>Sudah Dibayar</th>
      <th>Piutang</th>
     </tr>
    </thead>
    <tbody>
     <?= $list ?>
    </tbody>
   </table>
  </div>
 </div>
</div>
<div style='display:none;'><?= $DataEdit ?></div>