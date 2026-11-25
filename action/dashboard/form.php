<?php
 include("../bjksadkhrej121lkjkjk.php");

 $now = date('Y-m-d');
 $masa_lampau = date('Y-m-d', strtotime('-7 day', strtotime($now)));

 $list_cabang = "<option></option>";
 $execute = $koneksi->prepare("select * from cabang");
 $execute->execute();
 $result = $execute->get_result();
 while($row = $result->fetch_assoc())
  { $list_cabang .= "<option value='".$row['id']."'>".$row['nama']."</option>";
  }
?>

<style>
 .box-item
  { background-color : white;
    padding : 10px;
    box-shadow : 5px 5px 10px silver;
    margin-top : 10px;
  }
 .box-item hr
  { margin : 10px 0px 10px;
  }
 .box-item span
  { float : right;
  }
 .select2-container--default .select2-selection--single
  { height : 25px;
    padding-top : 2px;
    padding-left : 1px;
    padding-right : 1px;
  }
 .info-box-text
  { text-transform : none;
  }
 #popUpView .select2-container--default .select2-selection--single
  { height : 35px;
  }
 #popUpView .select2-container--default .select2-selection--single .select2-selection__rendered
  { line-height : 35px;
  }
 #popUpView .modal-dialog
  { width : 900px;
  }
</style>

<section class='content'>
 <div class='row'>
  <div class='col-md-12'>
   <div style='clear:both; display:flex; flex-wrap:wrap; gap:10px;'>
    <div style='display:inline-block; font-size:18px;'>Dashboard</div>
    <div style='display:inline-block;'>
     <input type='text' autocomplete='new-password' class='form-control datepicker' id='dari' onchange='setTglSampai(this); akumulasi();' style='max-width:90px; float:left; height:25px;' value='<?= date('d-m-Y', strtotime($masa_lampau)) ?>' onkeypress='return false'>
     <input type='text' autocomplete='new-password' class='form-control datepicker' id='sampai' onchange='setTglDari(this); akumulasi();' style='max-width:90px; float:left; height:25px;' value='<?= date('d-m-Y', strtotime($now)) ?>' onkeypress='return false'>
    </div>
    <div style='display:inline-block;'>
     <select id='periode' class='form-control' onchange='akumulasi();' style='width:200px;'>
      <option value='harian'>Harian</option>
      <option value='mingguan'>Mingguan</option>
      <option value='bulanan'>Bulanan</option>
      <option value='tahunan'>Tahunan</option>
     </select>
    </div>
    <div style='display:inline-block;'>
     <select id='cabang_id' class='form-control select2' onchange='akumulasi();' style='width:200px;'>
      <?= $list_cabang ?>
     </select>
    </div>
   </div>
  </div>
 </div>
 <div class='row' style='margin-top:10px; cursor:pointer;'>
  <div class='col-md-3 col-sm-6 col-xs-12' onclick='showDetail("pembelian")'>
   <div class='info-box'>
    <span class='info-box-icon bg-yellow'><i class='fa fa-shopping-basket'></i></span>
    <div class='info-box-content'>
     <span class='info-box-number'>Pembelian</span>
     <span class='info-box-text' id='total_pembelian'>Rp0</span>
     <span class='info-box-text' id='jumlah_pembelian'>0</span>
    </div>
   </div>
  </div>
  <div class='col-md-3 col-sm-6 col-xs-12' onclick='showDetail("penawaran")'>
   <div class='info-box'>
    <span class='info-box-icon bg-aqua'><i class='fa fa-send-o'></i></span>
    <div class='info-box-content'>
     <span class='info-box-number'>Penawaran</span>
     <span class='info-box-text' id='total_penawaran'>Rp0</span>
     <span class='info-box-text' id='jumlah_penawaran'>0</span>
    </div>
   </div>
  </div>
  <div class='col-md-3 col-sm-6 col-xs-12' onclick='showDetail("tanggapan")'>
   <div class='info-box'>
    <span class='info-box-icon bg-aqua' style='background-color:#5379c0 !important;'><i class='fa fa-handshake-o'></i></span>
    <div class='info-box-content'>
     <span class='info-box-number'>Tanggapan</span>
     <span class='info-box-text' id='total_tanggapan'>Rp0</span>
     <span class='info-box-text' id='jumlah_tanggapan'>0</span>
    </div>
   </div>
  </div>
  <div class='col-md-3 col-sm-6 col-xs-12' onclick='showDetail("pesanan")'>
   <div class='info-box'>
    <span class='info-box-icon bg-green'><i class='fa fa-shopping-cart'></i></span>
    <div class='info-box-content'>
     <span class='info-box-number'>Pesanan</span>
     <span class='info-box-text' id='total_pesanan'>Rp0</span>
     <span class='info-box-text' id='jumlah_pesanan'>0</span>
    </div>
   </div>
  </div>
  <div class='col-md-3 col-sm-6 col-xs-12' onclick='showDetail("penjualan")'>
   <div class='info-box'>
    <span class='info-box-icon bg-red'><i class='fa fa-tag'></i></span>
    <div class='info-box-content'>
     <span class='info-box-number'>Penjualan</span>
     <span class='info-box-text' id='total_penjualan'>Rp0</span>
     <span class='info-box-text' id='jumlah_penjualan'>0</span>
    </div>
   </div>
  </div>
 </div>
 <div class='row' id='grafik' style='margin-top:10px;'></div>
</section>

<div id='div-akumulasi' style='display:block;'></div>

<div class='modal' id='popUpView'>
 <div class='modal-dialog'>
  <div class='modal-content'>
   <div class='modal-header'>
    <button type='button' class='close' onclick='hideModal("popUpView");'>&times</button>
    <h4 class='modal-title'></h4>
   </div>
   <div class='modal-body'>
    <div class='row'>
      <div class='col-md-12'>
       <input type='button' class='btn btn-default' value='&laquo' style='float:left; height:35px;' onclick='previousPage()'>
       <div style='display:inline-block; max-width:80px; float:left;'>
        <select class='form-control halaman' style='text-align:center; height:35px;' onchange='goToPage(this.value);' id='preview-halaman'>
         <option value='1' selected>1</option>
        </select>
       </div>
       <input type='button' class='btn btn-default' value='&raquo' style='float:left; height:35px;' onclick='nextPage()'>
       <span style='float:right; padding-top:10px;' id='jlh-halaman'>Jumlah Halaman :</span>
      </div>
     </div>
     <div id='tabelku' class='responsiveku'><input type='hidden' id='txthalaman' value='1'></div>
   </div>
   <div class='modal-footer'>
    <button type='button' class='btn btn-default' onclick='hideModal("popUpView");'><i class='fa fa-close'></i> Tutup</button>
   </div>
  </div>
 </div>
</div>

<script type="text/javascript" src="bower_components/chartjs/dist/Chart.js"></script>

<script>

 $('.datepicker').datepicker({ autoclose : true, todayHighlight : true, format : 'dd-mm-yyyy' });
 $('.select2').select2({ placeholder : 'Pilih', allowClear : true });
 $('#periode').select2({ allowClear : false });

 function akumulasi()
  { var formdata = new FormData();
    formdata.append('username', '<?= $_POST['username'] ?>');
    formdata.append('users_level_id', '<?= $_POST['users_level_id'] ?>');
    formdata.append('cabang_id', '<?= $_POST['cabang_id'] ?>');
    formdata.append('token', '<?= $_POST['token'] ?>');
    formdata.append('dari', normalisasi_tanggal(document.getElementById('dari').value));
    formdata.append('sampai', normalisasi_tanggal(document.getElementById('sampai').value));
    formdata.append('periode', document.getElementById('periode').value);
    formdata.append('cabang_id_', document.getElementById('cabang_id').value);
    var ajax = new XMLHttpRequest();
    ajax.addEventListener('load', responseAkumulasi, false);
    ajax.open('POST', '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/akumulasi.php');
    ajax.send(formdata);
  }

 function responseAkumulasi()
  { $('#grafik').html(event.srcElement.response);
  }

 akumulasi();

 var Nama_Tabel = '';
 var jenis = '';

 function showDetail(jns)
  { document.getElementsByClassName('loader')[0].style['display'] = 'block';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'block';
    document.getElementById('txthalaman').value = 1;
    jenis = jns;
    Nama_Tabel = jenis;
    document.querySelector('#popUpView .modal-header .modal-title').innerHTML = jenis.charAt(0).toUpperCase() + jenis.slice(1);
    if(jenis == 'tanggapan')
     { Nama_Tabel = 'penjualan';
     }
    tampilListView();
  }

 function tampilListView()
  { var formdata = new FormData();
    formdata.append('username', '<?= $_POST['username'] ?>');
    formdata.append('users_level_id', '<?= $_POST['users_level_id'] ?>');
    formdata.append('cabang_id', '<?= $_POST['cabang_id'] ?>');
    formdata.append('token', '<?= $_POST['token'] ?>');
    formdata.append('Nama_Tabel', Nama_Tabel);
    formdata.append('maxRecord', 10);
    formdata.append('halaman', document.getElementById('txthalaman').value);
    formdata.append('dari', normalisasi_tanggal(document.getElementById('dari').value));
    formdata.append('sampai', normalisasi_tanggal(document.getElementById('sampai').value));
    formdata.append('cabang_id_', document.getElementById('cabang_id').value);
    var ajax = new XMLHttpRequest();
    ajax.addEventListener('load', responseTampilListView, false);
    ajax.open('POST', '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/tampil-' + jenis + '.php');
    ajax.send(formdata);
  }

 function responseTampilListView()
  { document.getElementsByClassName('loader')[0].style['display'] = 'none';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'none';
    $('#tabelku').html(event.srcElement.response);
    document.getElementById('preview-halaman').innerHTML = document.getElementById('temp-preview-halaman').innerHTML;
    document.getElementById('jlh-halaman').innerHTML = 'Jumlah Halaman : ' + formatnomor(document.getElementById('txtnhalaman').value);
    showModal('popUpView');
    $('.halaman').select2({ placeholder : 'Pilih', allowClear : false });
  }

 function nextPage()
  { var hal = document.getElementById('txthalaman').value;
    hal++;
    document.getElementById('txthalaman').value = hal;
    tampilListView();
  }

 function previousPage()
  { var hal = document.getElementById('txthalaman').value;
    hal--;
    document.getElementById('txthalaman').value = hal;
    tampilListView();
  }

 function goToPage(value)
  { document.getElementById('txthalaman').value = value;
    tampilListView();
  }

</script>