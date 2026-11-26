<?php
 include("../bjksadkhrej121lkjkjk.php");

 $list_cabang = "<option></option>";
 $query = "select * from cabang order by nama asc";
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $list_cabang .= "<option value='".$row['id']."'>".$row['nama']."</option>";
  }
 $list_metode_pembayaran = "<option></option>";
 $query = "select * from metode_pembayaran order by metode_pembayaran asc";
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $list_metode_pembayaran .= "<option value='".$row['id']."'>".$row['metode_pembayaran']."</option>";
  }
?>
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
 .terlambat td, .terlambat th
  { color : red;
    font-weight : bold;
  }
</style>

<style>
 #form-cetak table thead tr th, #form-cetak table tbody tr th, #form-cetak table tbody tr td
  { border : 1px solid black;
    padding : 5px 10px;
  }
 .terlambat td, .terlambat th
  { color : red;
    font-weight : bold;
  }
 .cetak-invoice
  { user-select : none;
    cursor : pointer;
  }
 .cetak-invoice:hover
  { color : #006ed0 !important;
    text-decoration : underline;
  }
 .pilih-pembayaran
  { user-select : none;
    cursor : pointer;
    text-align : right;
  }
 .pilih-pembayaran:hover
  { color : green !important;
    text-decoration : underline;
  }
 #popUpPembayaran .modal-header
  { padding : 15px 15px 5px 15px;
  }
</style>

<a id='link-cetak' target='#blank'></a>
<section class='content'>
 <input type='hidden' id='edit-id'>
 <input type='hidden' id='edit-id_pembayaran'>
 <span id='filterKu' style='display:none;'>[]</span>
 <div class='box box-default'>
  <div class='box-header with-border'>
   <h3 class='box-title'>Laporan Piutang Customer</h3>
   <div class='box-tools pull-right'>
    <button type='button' class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-minus'></i></button>
   </div>
  </div>
  <div class='box-body'>
   <div class='row'>
    <div class='col-md-5'>
     <div class='row' id='row-cabang_id'>
      <div class='col-md-3' style='padding-top:7px;'>
       <label>Cabang *</label>
      </div>
      <div class='col-md-9'>
       <select class='form-control' style='width:100%;' id='cabang_id' onchange='tampilListView();'>
        <?= $list_cabang ?>
       </select>
       <div class='error' id='error-cabang_id'></div>
      </div>
     </div>
    </div>
   </div>
  </div>
 </div>
 <div id='form-cetak'></div>
</section>

<div class='modal' id='popUpPembayaran'>
 <div class='modal-dialog'>
  <div class='modal-content'>
   <div class='modal-header'>
    <button type='button' class='close' onclick="hideModal('popUpPembayaran');">&times</button>
    <h4 class='modal-title'>Pilih Pembayaran</h4>
   </div>
   <div class='modal-body'>

    <div id='form-input-pembayaran'>
     <div class='row'>
      <div class='col-md-12'>
       <div class='row'>
        <div class='col-md-4' style='padding-top:7px;'>
         <label>Tanggal *</label>
        </div>
        <div class='col-md-4'>
         <div style='display:grid; grid-template-columns:1fr auto; gap:5px;'>
          <input type='text' class='form-control fieldku4 tanggal' readonly style='background-color:white;' id='pembayaran-tanggal'>
          <button type='button' class='btn btn-default' onclick="document.getElementById('pembayaran-tanggal').value = '';"><i class='fa fa-close'></i></button>
         </div>
         <div class='error' id='error-pembayaran-tanggal'></div>
        </div>
       </div>
       <div class='row' style='margin-top:5px;'>
        <div class='col-md-4' style='padding-top:7px;'>
         <label>Nominal *</label>
        </div>
        <div class='col-md-4'>
         <input type='text' class='form-control fieldku4' onkeypress='return hanyaAngka(this);' onkeyup='fnomor(this);' onchange='fnomor(this);' onfocus='this.select();' onfocusout='fnomor2(this);' style='text-align:right;' id='pembayaran-nominal'>
         <div class='error' id='error-pembayaran-nominal'></div>
        </div>
       </div>
       <div class='row' style='margin-top:5px;'>
        <div class='col-md-4' style='padding-top:7px;'>
         <label>Metode Pembayaran *</label>
        </div>
        <div class='col-md-8'>
         <select class='form-control fieldku4' id='pembayaran-metode_pembayaran_id'>
          <?= $list_metode_pembayaran ?>
         </select>
         <div class='error' id='error-pembayaran-metode_pembayaran_id'></div>
        </div>
       </div>
       <div class='row' style='margin-top:5px;'>
        <div class='col-md-4' style='padding-top:7px;'>
         <label>Keterangan</label>
        </div>
        <div class='col-md-8'>
         <input type='text' class='form-control fieldku4' id='pembayaran-keterangan'>
         <div class='error' id='error-pembayaran-keterangan'></div>
        </div>
       </div>
      </div>
     </div>
     <div class='row' style='margin-top:10px;'>
      <div class='col-md-12'>
       <input type='button' class='btn btn-default' value='&laquo' style='float:left; height:35px;' onclick='previousPagePembayaran()'>
       <div style='display:inline-block; max-width:80px; float:left;'>
        <select class='form-control halaman' style='text-align:center; width:100%;' onchange='goToPagePembayaran(this.value);' id='preview-halaman-pembayaran'>
         <option value='1' selected>1</option>
        </select>
       </div>
       <input type='button' class='btn btn-default' value='&raquo' style='float:left; height:35px;' onclick='nextPagePembayaran()'>
       <button type='button' class='btn btn-default' style='float:left; height:35px;' onclick='refreshPembayaran();'><i class='fa fa-refresh'></i></button>
       <input type='text' class='form-control' autocomplete='new-password' placeholder='Cari..' style='max-width:257px; height:35px; float:left;' onkeyup='tampilPembayaran();' onchange='tampilPembayaran();' id='txtcaripembayaran'>
       <span style='float:right; padding-top:10px;' id='jlh-halaman-pembayaran'>Jumlah Halaman :</span>
      </div>
     </div>
     <div id='tabelkupembayaran' class='responsiveku'><input type='hidden' id='txthalamanpembayaran' value='1'></div>
    </div>
    <div id='form-hapus-pembayaran'>
     <h4>Yakin Menghapus Data Pembayaran?</h4>
    </div>
   </div>
   <div class='modal-footer'>
    <button type='button' class='btn btn-default'><i class='fa fa-close'></i> Tutup</button>
    <button type='button' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
   </div>
  </div>
 </div>
</div>

<div id='div-result' style='display:none'></div>

<script>

 $('#cabang_id').select2({ placeholder : '', allowClear : true });
 $('#pembayaran-metode_pembayaran_id').select2({ placeholder : '', allowClear : true });
 $('.tanggal').datepicker({ autoclose : true, todayHighlight : true, format : 'dd-mm-yyyy' });

 if('<?= $_POST['cabang_id'] ?>' !== '')
  { document.getElementById('cabang_id').value = '<?= $_POST['cabang_id'] ?>';
    document.getElementById('row-cabang_id').style['display'] = 'none';
  }

 function tampilListView()
  { if('<?= $_POST['cabang_id'] ?>' !== '')
     { document.getElementById('cabang_id').value = '<?= $_POST['cabang_id'] ?>';
     }
    var error = 0;
    document.getElementById('error-cabang_id').innerHTML = '';
    if(document.getElementById('cabang_id').value == '')
     { error++;
       document.getElementById('error-cabang_id').innerHTML = '<b>Cabang</b> wajib diisi!'
     }
    if(error == 0)
     { document.getElementsByClassName('loader')[0].style['display'] = 'block';
       document.getElementsByClassName('loader-block')[0].style['display'] = 'block';
       var formdata = new FormData();
       formdata.append('username', '<?= $_POST['username'] ?>');
       formdata.append('users_level_id', '<?= $_POST['users_level_id'] ?>');
       formdata.append('cabang_id', '<?= $_POST['cabang_id'] ?>');
       formdata.append('token', '<?= $_POST['token'] ?>');
       formdata.append('cabang_id_', document.getElementById('cabang_id').value);
       var ajax = new XMLHttpRequest();
       ajax.addEventListener('load', responseTampilListView, false);
       ajax.open('POST', '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/tampil.php');
       ajax.send(formdata);
     }
  }

 function responseTampilListView()
  { document.getElementsByClassName('loader')[0].style['display'] = 'none';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'none';
    $('#form-cetak').html(event.srcElement.response);
    document.getElementById('lebar').style['width'] = (document.querySelector('#lebar table').offsetWidth + 5) + 'px';
  }

 function cetak(element)
  { document.getElementsByClassName('loader')[0].style['display'] = 'block';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'block';
    var list = document.getElementsByClassName(element.className);
    list = [].slice.call(list);
    var position = list.indexOf(element);
    document.getElementsByClassName('loader')[0].style['display'] = 'block';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'block';
    var formdata = new FormData();
    formdata.append('username', '<?= $_POST['username'] ?>');
    formdata.append('users_level_id', '<?= $_POST['users_level_id'] ?>');
    formdata.append('cabang_id', '<?= $_POST['cabang_id'] ?>');
    formdata.append('token', '<?= $_POST['token'] ?>');
    formdata.append('id', document.getElementsByClassName('textarea_edit-id')[position].value);
    var ajax = new XMLHttpRequest();
    ajax.addEventListener('load', responseCetak, false);
    ajax.open('POST', '<?= $_POST['url'] ?>/action/penjualan/cetak.php');
    ajax.send(formdata);
  }

 function responseCetak()
  { document.getElementsByClassName('loader')[0].style['display'] = 'none';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'none';
    document.getElementById('link-cetak').href = event.srcElement.response;
    document.getElementById('link-cetak').click();
  }

 //Pembayaran-----------------------------------------------------------------------------------------------------------

 function showPopUpPembayaran(jenis)
  { if(jenis == 'input')
     { document.getElementById('form-input-pembayaran').style['display'] = 'block';
       document.getElementById('form-hapus-pembayaran').style['display'] = 'none';
       document.getElementById('popUpPembayaran').querySelector('.modal-footer .btn-default').innerHTML = "<i class='fa fa-close'></i> Tutup";
       document.getElementById('popUpPembayaran').querySelector('.modal-footer .btn-default').setAttribute("onclick", "hideModal('popUpPembayaran');");
       document.getElementById('popUpPembayaran').querySelector('.modal-header .close').setAttribute("onclick", "hideModal('popUpPembayaran');");
       document.getElementById('popUpPembayaran').querySelector('.modal-footer .btn-primary').innerHTML = "<i class='fa fa-save'></i> Simpan";
       document.getElementById('popUpPembayaran').querySelector('.modal-footer .btn-primary').setAttribute("onclick", "validasiPembayaran();");
     }
    else if(jenis == 'edit')
     { document.getElementById('form-input-pembayaran').style['display'] = 'block';
       document.getElementById('form-hapus-pembayaran').style['display'] = 'none';
       document.getElementById('popUpPembayaran').querySelector('.modal-footer .btn-default').innerHTML = "<i class='fa fa-close'></i> Batal";
       document.getElementById('popUpPembayaran').querySelector('.modal-footer .btn-default').setAttribute("onclick", "clearPembayaran(); showPopUpPembayaran('input');");
       document.getElementById('popUpPembayaran').querySelector('.modal-header .close').setAttribute("onclick", "clearPembayaran(); showPopUpPembayaran('input');");
       document.getElementById('popUpPembayaran').querySelector('.modal-footer .btn-primary').innerHTML = "<i class='fa fa-save'></i> Simpan";
       document.getElementById('popUpPembayaran').querySelector('.modal-footer .btn-primary').setAttribute("onclick", "validasiPembayaran();");
     }
    else if(jenis == 'hapus')
     { document.getElementById('form-input-pembayaran').style['display'] = 'none';
       document.getElementById('form-hapus-pembayaran').style['display'] = 'block';
       document.getElementById('popUpPembayaran').querySelector('.modal-footer .btn-default').innerHTML = "<i class='fa fa-close'></i> Batal";
       document.getElementById('popUpPembayaran').querySelector('.modal-footer .btn-default').setAttribute("onclick", "clearPembayaran(); showPopUpPembayaran('input');");
       document.getElementById('popUpPembayaran').querySelector('.modal-header .close').setAttribute("onclick", "clearPembayaran(); showPopUpPembayaran('input');");
       document.getElementById('popUpPembayaran').querySelector('.modal-footer .btn-primary').innerHTML = "<i class='fa fa-trash'></i> Hapus";
       document.getElementById('popUpPembayaran').querySelector('.modal-footer .btn-primary').setAttribute("onclick", "hapusPembayaran();");
     }
    showModal('popUpPembayaran');
  }

 var FieldRequiredPembayaran = [
  {field : 'pembayaran-tanggal', label : 'Tanggal'},
  {field : 'pembayaran-nominal', label : 'Nominal'},
  {field : 'pembayaran-metode_pembayaran_id', label : 'Metode Pembayaran'},
 ];

 function pilihPembayaran(element)
  { var list = document.getElementsByClassName(element.className);
    list = [].slice.call(list);
    var position = list.indexOf(element);
    document.getElementById('edit-id').value = document.getElementsByClassName('textarea_edit-id')[position].value;
    document.getElementById('popUpPembayaran').querySelector('.modal-title').innerHTML = document.getElementsByClassName('textarea_edit-nomor_penjualan')[position].value;
    document.getElementsByClassName('loader')[0].style['display'] = 'block';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'block';
    tampilPembayaran();
  }

 function tampilPembayaran()
  { var formdata = new FormData();
    formdata.append('username', '<?= $_POST['username'] ?>');
    formdata.append('users_level_id', '<?= $_POST['users_level_id'] ?>');
    formdata.append('cabang_id', '<?= $_POST['cabang_id'] ?>');
    formdata.append('token', '<?= $_POST['token'] ?>');
    formdata.append('maxRecord', 10);
    formdata.append('id', document.getElementById('edit-id').value);
    var ajax = new XMLHttpRequest();
    ajax.addEventListener('load', responseTampilPembayaran, false);
    ajax.open('POST', '<?= $_POST['url'] ?>/action/penjualan/tampil-pembayaran.php');
    ajax.send(formdata);
  }

 function responseTampilPembayaran()
  { document.getElementsByClassName('loader')[0].style['display'] = 'none';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'none';
    $('#tabelkupembayaran').html(event.srcElement.response);
    document.getElementById('jlh-halaman-pembayaran').innerHTML = 'Jumlah Halaman : ' + document.getElementById('txtnhalamanpembayaran').value;
    document.getElementById('preview-halaman-pembayaran').innerHTML = document.getElementById('temp-preview-halaman-pembayaran').innerHTML;
    showPopUpPembayaran('input');
  }

 function nextPagePembayaran()
  { var hal = document.getElementById('txthalamanpembayaran').value;
    hal++;
    document.getElementById('txthalamanpembayaran').value = hal;
    tampilPembayaran();
  }

 function previousPagePembayaran()
  { var hal = document.getElementById('txthalamanpembayaran').value;
    hal--;
    document.getElementById('txthalamanpembayaran').value = hal;
    tampilPembayarans();
  }

 function goToPagePembayaran(value)
  { document.getElementById('txthalamanpembayaran').value = value;
    tampilPembayaran();
  }

 function refreshPembayaran()
  { document.getElementById('txtcaripembayaran').value = '';
    clearPembayaran();
    tampilPembayaran();
  }

 function clearPembayaran()
  { document.getElementById('edit-id_pembayaran').value = '';
    var a = document.getElementsByClassName('fieldku4');
    for(var i=0; i<a.length; i++)
     { a[i].value = '';
       document.getElementById('error-' + a[i].id).innerHTML = '';
     }
    $('#pembayaran-metode_pembayaran_id').trigger('change');
  }

 function validasiPembayaran()
  { var data = {};
    data.penjualan_id = document.getElementById('edit-id').value;
    var a = document.getElementsByClassName('fieldku4');
    for(var loop=0; loop<a.length; loop++)
     { if(a[loop].value !== '')
        { if(a[loop].id.toString().replaceAll('pembayaran-', '') == 'tanggal')
           { data[a[loop].id.toString().replaceAll('pembayaran-', '')] = normalisasi_tanggal(a[loop].value);
           }
          else if(a[loop].id.toString().replaceAll('pembayaran-', '') == 'nominal')
           { data[a[loop].id.toString().replaceAll('pembayaran-', '')] = normal(a[loop].value);
           }
          else
           { data[a[loop].id.toString().replaceAll('pembayaran-', '')] = a[loop].value;
           }
        }
       else
        { data[a[loop].id.toString().replaceAll('pembayaran-', '')] = null;
        }
     }

    var error = 0;
    for(var loop=0; loop<FieldRequiredPembayaran.length; loop++)
     { if(document.getElementById(FieldRequiredPembayaran[loop].field).value == '')
        { error++;
          document.getElementById('error-' + FieldRequiredPembayaran[loop].field).innerHTML = '<b>' + FieldRequiredPembayaran[loop].label + '</b> wajib diisi';
        }
       else
        { document.getElementById('error-' + FieldRequiredPembayaran[loop].field).innerHTML = '';
        }
     }
    if(error < 1)
     { simpanPembayaran(data)
     }
  }

 function simpanPembayaran(data)
  { document.getElementsByClassName('loader')[0].style['display'] = 'block';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'block';
    if(document.getElementById('edit-id_pembayaran').value == '')
     { var formdata = new FormData();
       formdata.append('username', '<?= $_POST['username'] ?>');
       formdata.append('users_level_id', '<?= $_POST['users_level_id'] ?>');
       formdata.append('cabang_id', '<?= $_POST['cabang_id'] ?>');
       formdata.append('token', '<?= $_POST['token'] ?>');
       formdata.append('Nama_Tabel', 'penjualan_pembayaran');
       formdata.append('data', JSON.stringify(data));
       var ajax = new XMLHttpRequest();
       ajax.addEventListener('load', responseSimpanPembayaran, false);
       ajax.open('POST', '<?= $_POST['url'] ?>/action/penjualan/simpan-pembayaran.php');
       ajax.send(formdata);
     }
    else
     { var formdata = new FormData();
       formdata.append('username', '<?= $_POST['username'] ?>');
       formdata.append('users_level_id', '<?= $_POST['users_level_id'] ?>');
       formdata.append('cabang_id', '<?= $_POST['cabang_id'] ?>');
       formdata.append('token', '<?= $_POST['token'] ?>');
       formdata.append('Nama_Tabel', 'penjualan_pembayaran');
       formdata.append('data', JSON.stringify(data));
       formdata.append('id', document.getElementById('edit-id_pembayaran').value);
       var ajax = new XMLHttpRequest();
       ajax.addEventListener('load', responseSimpanPembayaran, false);
       ajax.open('POST', '<?= $_POST['url'] ?>/action/penjualan/ubah-pembayaran.php');
       ajax.send(formdata);
     }
  }

 function responseSimpanPembayaran()
  { document.getElementsByClassName('loader')[0].style['display'] = 'none';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'none';
    $('#div-result').html(event.srcElement.response);
    if(event.srcElement.response !== "1")
     { alert(event.srcElement.response);
     }
    else
     { clearPembayaran();
       tampilPembayaran();
       tampilListView();
       showPopUpPembayaran('input');
     }
  }

 function editPembayaran(element)
  { var list = document.getElementsByClassName(element.className);
    list = [].slice.call(list);
    var position = list.indexOf(element);
    document.getElementById('edit-id_pembayaran').value = document.getElementsByClassName('textarea_pembayaran-id')[position].value;
    var a = document.getElementsByClassName('fieldku4');
    for(var i=0; i<a.length; i++)
     { document.getElementById(a[i].id).value = document.getElementsByClassName('textarea_' + a[i].id)[position].value;
     }
    $('#pembayaran-metode_pembayaran_id').trigger('change');
    showPopUpPembayaran('edit');
  }

 function konfirmasiHapusPembayaran(element)
  { var list = document.getElementsByClassName(element.className);
    list = [].slice.call(list);
    var position = list.indexOf(element);
    document.getElementById('edit-id_pembayaran').value = document.getElementsByClassName('textarea_pembayaran-id')[position].value;
    showPopUpPembayaran('hapus');
  }

 function hapusPembayaran()
  { document.getElementsByClassName('loader')[0].style['display'] = 'block';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'block';
    var formdata = new FormData();
    formdata.append('username', '<?= $_POST['username'] ?>');
    formdata.append('users_level_id', '<?= $_POST['users_level_id'] ?>');
    formdata.append('cabang_id', '<?= $_POST['cabang_id'] ?>');
    formdata.append('token', '<?= $_POST['token'] ?>');
    formdata.append('Nama_Tabel', 'penjualan_pembayaran');
    formdata.append('id', document.getElementById('edit-id_pembayaran').value);
    var ajax = new XMLHttpRequest();
    ajax.addEventListener('load', responseSimpanPembayaran, false);
    ajax.open('POST', '<?= $_POST['url'] ?>/action/penjualan/hapus-pembayaran.php');
    ajax.send(formdata);
  }

 function cetakKwitansi(element)
  { document.getElementsByClassName('loader')[0].style['display'] = 'block';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'block';
    var list = document.getElementsByClassName(element.className);
    list = [].slice.call(list);
    var position = list.indexOf(element);
    var formdata = new FormData();
    formdata.append('username', '<?= $_POST['username'] ?>');
    formdata.append('users_level_id', '<?= $_POST['users_level_id'] ?>');
    formdata.append('cabang_id', '<?= $_POST['cabang_id'] ?>');
    formdata.append('token', '<?= $_POST['token'] ?>');
    formdata.append('id', document.getElementsByClassName('textarea_pembayaran-id')[position].value);
    var ajax = new XMLHttpRequest();
    ajax.addEventListener('load', responseCetak, false);
    ajax.open('POST', '<?= $_POST['url'] ?>/action/penjualan/cetak-kwitansi.php');
    ajax.send(formdata);
  }

 //Pembayaran-----------------------------------------------------------------------------------------------------------


</script>