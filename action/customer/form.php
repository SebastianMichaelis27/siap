<?php
 include("../bjksadkhrej121lkjkjk.php");
 $list_jenis_customer = "<option></option>";
 $query = "select * from jenis_customer order by jenis_customer asc";
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $list_jenis_customer .= "<option value='".$row['id']."'>".$row['jenis_customer']."</option>";
  }
?>

<style>
 #btnpilih
  { width : 100%;
    padding : 15px;
    background-color : #ED313A;
    border : 0px;
    color : white;
    font-weight : bold;
    z-index : 100;
  }
 #btnpilih:active
  { background-color : #BF161F;
  }
 #btnbatal
  { width : 100%;
    padding : 15px;
    background-color : #bdbdbd;
    border : 0px;
    color : white;
    font-weight : bold;
    z-index : 100;
  }
 #btnbatal:active
  { background-color : #8b8b8b;
  }
</style>

<section class='content'>
 <input type='hidden' id='edit-id'>
 <span id='filterKu' style='display:none;'>[]</span>
 <div class='box box-default'>
  <div class='box-header with-border'>
   <h3 class='box-title'>Customer</h3>
   <div class='box-tools pull-right'>
    <button type='button' class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-minus'></i></button>
   </div>
  </div>
  <div class='box-body'>
   <div class='row'>
    <div class='col-md-12'>
     <div class='row'>
      <div class='col-md-6'>
       <div class='row'>
        <div class='col-md-4' style='padding-top:7px;'>
         <label>Jenis Customer *</label>
        </div>
        <div class='col-md-8'>
         <select class='form-control fieldku' style='width:100%;' id='jenis_customer_id'>
          <?= $list_jenis_customer ?>
         </select>
         <div style='color:red' class='error' id='error-jenis_customer_id'></div>
        </div>
       </div>
       <div class='row' style='margin-top:5px;'>
        <div class='col-md-4' style='padding-top:7px;'>
         <label>Nama *</label>
        </div>
        <div class='col-md-8'>
         <input type='text' class='form-control fieldku' autocomplete='new-password' id='nama'>
         <div style='color:red' class='error' id='error-nama'></div>
        </div>
       </div>
       <div class='row' style='margin-top:5px;'>
        <div class='col-md-4' style='padding-top:7px;'>
         <label>Alamat *</label>
        </div>
        <div class='col-md-8'>
         <input type='text' class='form-control fieldku' autocomplete='new-password' id='alamat'>
         <div style='color:red' class='error' id='error-alamat'></div>
        </div>
       </div>
       <div class='row' style='margin-top:5px;'>
        <div class='col-md-4' style='padding-top:7px;'>
         <label>No Telp</label>
        </div>
        <div class='col-md-8'>
         <div id="list-no_telp" style="display:grid; grid-template-rows:1fr; gap:5px;"></div>
        </div>
       </div>
      </div>
      <div class='col-md-6'>
       <div class='row'>
        <div class='col-md-4' style='padding-top:7px;'>
         <label>No Wa</label>
        </div>
        <div class='col-md-8'>
         <div id="list-no_wa" style="display:grid; grid-template-rows:1fr; gap:5px;"></div>
        </div>
       </div>
       <div class='row' style='margin-top:5px;'>
        <div class='col-md-4' style='padding-top:7px;'>
         <label>Email</label>
        </div>
        <div class='col-md-8'>
         <div id="list-email" style="display:grid; grid-template-rows:1fr; gap:5px;"></div>
        </div>
       </div>
       <div class='row' style='margin-top:5px;'>
        <div class='col-md-4' style='padding-top:7px;'>
         <label>Kredit Limit *</label>
        </div>
        <div class='col-md-8'>
         <input type='text' class='form-control fieldku' onkeypress='return hanyaAngka(this);' onkeyup='fnomor(this);' onchange='fnomor(this);' onfocus='this.select();' onfocusout='fnomor2(this);' style='text-align:right;' id='credit_limit'>
         <div style='color:red' class='error' id='error-credit_limit'></div>
        </div>
       </div>
       <div class='row' style='margin-top:5px;'>
        <div class='col-md-4' style='padding-top:7px;'>
         <label>Lokasi</label>
        </div>
        <div class='col-md-8'>
         <div style='display:grid; grid-template-columns:auto 1fr; gap:5px'>
          <button type='button' class='btn btn-danger' onclick='cariLokasiSaya();'><i class='fa fa-map-marker'></i> Ambil Lokasi</button>
          <input type='text' class='form-control fieldku' readonly style='background:white;' id='lokasi'>
         </div>
         <div style='color:red' class='error' id='error-lokasi'></div>
        </div>
       </div>
      </div>
     </div>
    </div>
   </div>
  </div>
  <div class='box-footer'>
   <div class='row' style='margin-top:5px;'>
    <div class='col-md-12'>
     <button class='btn btn-primary pull-right' type='button' onclick='validasi();' id='btnsimpan'><i class='fa fa-save'></i> Simpan</button>
     <button class='btn btn-default pull-right' type='button' onclick='filter();' id='btnfilter'><i class='fa fa-search'></i> Cari</button>
    </div>
   </div>
  </div>
 </div>
 <div class='row'>
  <div class='col-md-12'>
   <div class='box box-danger'>
    <div class='box-header with-border'>
     <h3 class='box-title'>List Customer</h3>
    </div>
    <div class='box-body'>
     <div class='row'>
      <div class='col-md-12'>
       <input type='button' class='btn btn-default' value='&laquo' style='float:left; height:35px;' onclick='previousPage()'>
       <div style='display:inline-block; max-width:80px; float:left;'>
        <select class='form-control halaman' style='text-align:center;' onchange='goToPage(this.value);' id='preview-halaman'>
         <option value='1' selected>1</option>
        </select>
       </div>
       <input type='button' class='btn btn-default' value='&raquo' style='float:left; height:35px;' onclick='nextPage()'>
       <button type='button' class='btn btn-default' style='float:left; height:35px;' onclick='refresh();'><i class='fa fa-refresh'></i></button>
       <span style='float:right; padding-top:10px;' id='jlh-halaman'>Jumlah Halaman :</span>
      </div>
     </div>
     <div id='tabelku' class='responsiveku'><input type='hidden' id='txthalaman' value='1'></div>
    </div>
   </div>
  </div>
 </div>
</section>

<div class='modal' id='popUpHapus'>
 <div class='modal-dialog'>
  <div class='modal-content'>
   <div class='modal-header'>
    <button type='button' class='close' onclick='tutupPopUpHapus();'>&times</button>
    <h4 class='modal-title'>Konfirmasi</h4>
   </div>
   <div class='modal-body'>
    <h4>Anda Yakin Ingin Menghapus Data?</h4>
   </div>
   <div class='modal-footer'>
    <button type='button' class='btn btn-default' onclick='tutupPopUpHapus();'><i class='fa fa-close'></i> Tidak</button>
    <button type='button' onclick='hapus()' class='btn btn-primary'><i class='fa fa-trash'></i> Hapus</button>
   </div>
  </div>
 </div>
</div>

<div class='modal' id='popUpLokasi'>
 <div class='modal-dialog' style='margin:0px 0px;'>
  <div class='modal-content'>
   <div class='modal-body'>
    <div style='width:100%; height:100%;' id='mapku'></div>
    <div style='display:grid; grid-template-columns:1fr 1fr; border-top:1px solid darkgray;'>
     <button type='button' id='btnbatal' onclick="hideModal('popUpLokasi');">Batal</button>
     <button type='button' id='btnpilih' onclick='pilihLokasi();'>Pilih Lokasi</button>
    </div>
   </div>
  </div>
 </div>
</div>

<div id='div-result' style='display:none'></div>

<link rel='stylesheet' href='https://unpkg.com/leaflet@1.7.1/dist/leaflet.css' integrity='sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==' crossorigin=''/>
<script src='https://unpkg.com/leaflet@1.7.1/dist/leaflet.js' integrity='sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==' crossorigin=''></script>

<script>

 var Nama_Tabel = 'customer';
 var FieldTidakBolehRangkap = [
  {field : 'jenis_customer_id'},
  {field : 'nama'},
 ];
 var FieldRequired = [
  {field : 'jenis_customer_id', label : 'Jenis Customer'},
  {field : 'nama', label : 'Nama Customer'},
  {field : 'alamat', label : 'Alamat'},
  {field : 'credit_limit', label : 'Credit Limit'},
 ];
 var maxRecord = 10;

 makeSelect2Search('no_telp', '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/get-no-telp.php', { username: '<?= $_POST['username'] ?>', users_level_id: '<?= $_POST['users_level_id'] ?>', cabang_id: '<?= $_POST['cabang_id'] ?>', token: '<?= $_POST['token'] ?>' });
 makeSelect2Search('no_wa', '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/get-no-telp.php', { username: '<?= $_POST['username'] ?>', users_level_id: '<?= $_POST['users_level_id'] ?>', cabang_id: '<?= $_POST['cabang_id'] ?>', token: '<?= $_POST['token'] ?>' });
 makeSelect2Search('email', '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/get-email.php', { username: '<?= $_POST['username'] ?>', users_level_id: '<?= $_POST['users_level_id'] ?>', cabang_id: '<?= $_POST['cabang_id'] ?>', token: '<?= $_POST['token'] ?>' });

 tampilListView();
 clearNoTelp();
 clearNoWa();
 clearEmail();

 function validasi()
  { var no_telp = [];
    try
     { var a = document.querySelectorAll('#list-no_telp > div > input');
       for(var i=0; i<a.length; i++)
        { if(a[i].value !== '')
           { var valueToPush = {};
             valueToPush.no_telp = a[i].value;
             no_telp.push(valueToPush);
           }
        }
     }
    catch(er) { }

    var no_wa = [];
    try
     { var a = document.querySelectorAll('#list-no_wa > div > input');
       for(var i=0; i<a.length; i++)
        { if(a[i].value !== '')
           { var valueToPush = {};
             valueToPush.no_wa = a[i].value;
             no_wa.push(valueToPush);
           }
        }
     }
    catch(er) { }

    var email = [];
    try
     { var a = document.querySelectorAll('#list-email > div > input');
       for(var i=0; i<a.length; i++)
        { if(a[i].value !== '')
           { var valueToPush = {};
             valueToPush.email = a[i].value;
             email.push(valueToPush);
           }
        }
     }
    catch(er) { }

    var data = {};
    if(no_telp.length > 0)
     { data['no_telp'] = no_telp;
     }
    else
     { data['no_telp'] = null;
     }
    if(no_wa.length > 0)
     { data['no_wa'] = no_wa;
     }
    else
     { data['no_wa'] = null;
     }
    if(email.length > 0)
     { data['email'] = email;
     }
    else
     { data['email'] = null;
     }

    var a = document.getElementsByClassName('fieldku');
    for(var loop=0; loop<a.length; loop++)
     { if(a[loop].value !== '')
        { if(a[loop].id == 'credit_limit')
           { data[a[loop].id] = normal(a[loop].value);
           }
          else
           { data[a[loop].id] = a[loop].value;
           }
        }
       else
        { data[a[loop].id] = null;
        }
     }
    var error = 0;
    for(var loop=0; loop<FieldRequired.length; loop++)
     { if(document.getElementById(FieldRequired[loop].field).value == '')
        { error++;
          document.getElementById('error-' + FieldRequired[loop].field).innerHTML = '<b>' + FieldRequired[loop].label + '</b> wajib diisi';
        }
       else
        { document.getElementById('error-' + FieldRequired[loop].field).innerHTML = '';
        }
     }
    if(error < 1)
     { var DataTidakBolehRangkap = [];
       for(var loop=0; loop<FieldTidakBolehRangkap.length; loop++)
        { var valueToPush = {};
          valueToPush.field = FieldTidakBolehRangkap[loop].field;
          if(document.getElementById(FieldTidakBolehRangkap[loop].field).value !== "")
           { valueToPush.value = document.getElementById(FieldTidakBolehRangkap[loop].field).value;
           }
          else
           { valueToPush.value = null;
           }
          DataTidakBolehRangkap.push(valueToPush);
        }
       simpan(data, DataTidakBolehRangkap);
     }
  }

 function simpan(data, DataTidakBolehRangkap)
  { document.getElementsByClassName('loader')[0].style['display'] = 'block';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'block';
    if(document.getElementById('edit-id').value == '')
     { var formdata = new FormData();
       formdata.append('username', '<?= $_POST['username'] ?>');
       formdata.append('users_level_id', '<?= $_POST['users_level_id'] ?>');
       formdata.append('cabang_id', '<?= $_POST['cabang_id'] ?>');
       formdata.append('token', '<?= $_POST['token'] ?>');
       formdata.append('Nama_Tabel', Nama_Tabel);
       formdata.append('DataTidakBolehRangkap', JSON.stringify(DataTidakBolehRangkap));
       formdata.append('data', JSON.stringify(data));
       var ajax = new XMLHttpRequest();
       ajax.addEventListener('load', responseSimpan, false);
       ajax.open('POST', '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/simpan.php');
       ajax.send(formdata);
     }
    else
     { var formdata = new FormData();
       formdata.append('username', '<?= $_POST['username'] ?>');
       formdata.append('users_level_id', '<?= $_POST['users_level_id'] ?>');
       formdata.append('cabang_id', '<?= $_POST['cabang_id'] ?>');
       formdata.append('token', '<?= $_POST['token'] ?>');
       formdata.append('Nama_Tabel', Nama_Tabel);
       formdata.append('DataTidakBolehRangkap', JSON.stringify(DataTidakBolehRangkap));
       formdata.append('data', JSON.stringify(data));
       formdata.append('id', document.getElementById('edit-id').value);
       var ajax = new XMLHttpRequest();
       ajax.addEventListener('load', responseSimpan, false);
       ajax.open('POST', '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/ubah.php');
       ajax.send(formdata);
     }
  }

 function responseSimpan()
  { $('#div-result').html(event.srcElement.response);
    if(event.srcElement.response !== "1")
     { alert(event.srcElement.response);
     }
    else
     { clearField();
       tampilListView();
       tutupPopUpHapus();
     }
    document.getElementsByClassName('loader')[0].style['display'] = 'none';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'none';
  }

 function tampilListView()
  { var formdata = new FormData();
    formdata.append('username', '<?= $_POST['username'] ?>');
    formdata.append('users_level_id', '<?= $_POST['users_level_id'] ?>');
    formdata.append('cabang_id', '<?= $_POST['cabang_id'] ?>');
    formdata.append('token', '<?= $_POST['token'] ?>');
    formdata.append('Nama_Tabel', Nama_Tabel);
    formdata.append('maxRecord', maxRecord);
    formdata.append('halaman', document.getElementById('txthalaman').value);
    formdata.append('filter', document.getElementById('filterKu').innerHTML);
    var ajax = new XMLHttpRequest();
    ajax.addEventListener('load', responseTampilListView, false);
    ajax.open('POST', '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/tampil.php');
    ajax.send(formdata);
  }

 function responseTampilListView()
  { $('#tabelku').html(event.srcElement.response);
    document.getElementById('preview-halaman').innerHTML = document.getElementById('temp-preview-halaman').innerHTML;
    document.getElementById('jlh-halaman').innerHTML = 'Jumlah Halaman : ' + formatnomor(document.getElementById('txtnhalaman').value);
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

 function clearField()
  { document.getElementById('btnfilter').innerHTML = "<i class='fa fa-search'></i> Cari";
    document.getElementById('btnfilter').setAttribute('onclick', 'filter();');
    document.getElementById('edit-id').value = '';
    var a = document.getElementsByClassName('fieldku');
    for(var loop=0; loop<a.length; loop++)
     { a[loop].value = '';
       try
        { $('#' + a[loop].id).trigger('change');
        }
       catch(er) { }
     }
    var a = document.getElementsByClassName('error');
    for(var loop=0; loop<a.length; loop++)
     { a[loop].innerHTML = '';
     }
    clearNoTelp();
    clearNoWa();
    clearEmail();
    document.getElementById('btnsimpan').style['display'] = 'block';
  }

 function filter()
  { if(document.getElementById('edit-id').value == '')
     { var data = [];
       var a = document.getElementsByClassName('fieldku');
       for(var loop=0; loop<a.length; loop++)
        { if(a[loop].value !== '')
           { var valueToPush = {};
             valueToPush.field = Nama_Tabel + '.' + a[loop].id;
             valueToPush.value = a[loop].value;
             data.push(valueToPush);
           }
        }
       document.getElementById('filterKu').innerHTML = JSON.stringify(data);
       tampilListView();
     }
    else
     { clearField();
     }
  }

 function refresh()
  { clearField();
    filter();
  }

 function edit(label)
  { var list = document.getElementsByClassName(label.className);
    list = [].slice.call(list);
    var position = list.indexOf(label);
    document.getElementById('edit-id').value = document.getElementsByClassName('textarea_edit-id')[position].value;
    var a = document.getElementsByClassName('fieldku');
    for(var loop=0; loop<a.length; loop++)
     { document.getElementById(a[loop].id).value = document.getElementsByClassName('textarea_edit-' + a[loop].id)[position].value;
       try
        { $('#' + document.getElementById(a[loop].id).id).trigger('change');
        }
       catch(er) { }
     }

    clearNoTelp();
    var a = document.querySelectorAll('.detail-no_telp')[position].querySelectorAll('.detail-no_telp-no_telp');
    for(var i=0; i<a.length; i++)
     { if(i > 0)
        { tambahNoTelp();
        }
       document.querySelectorAll('#list-no_telp input')[i].value = a[i].value;
     }

    clearNoWa();
    var a = document.querySelectorAll('.detail-no_wa')[position].querySelectorAll('.detail-no_wa-no_wa');
    for(var i=0; i<a.length; i++)
     { if(i > 0)
        { tambahNoWa();
        }
       document.querySelectorAll('#list-no_wa input')[i].value = a[i].value;
     }

    clearEmail();
    var a = document.querySelectorAll('.detail-email')[position].querySelectorAll('.detail-email-email');
    for(var i=0; i<a.length; i++)
     { if(i > 0)
        { tambahEmail();
        }
       document.querySelectorAll('#list-email input')[i].value = a[i].value;
     }

    document.getElementById('btnfilter').innerHTML = "<i class='fa fa-close'></i> Batal";
    document.getElementById('btnfilter').setAttribute('onclick', 'clearField();');
    document.body.scrollTop = 0; // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
  }

 function view(label)
  { edit(label);
    document.getElementById('btnsimpan').style['display'] = 'none';
  }

 function konfirmasiHapus(label)
  { var list = document.getElementsByClassName(label.className);
    list = [].slice.call(list);
    var position = list.indexOf(label);
    document.getElementById('edit-id').value = document.getElementsByClassName('textarea_edit-id')[position].value;
    showModal('popUpHapus');
  }

 function hapus()
  { document.getElementsByClassName('loader')[0].style['display'] = 'block';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'block';
    var formdata = new FormData();
    formdata.append('username', '<?= $_POST['username'] ?>');
    formdata.append('users_level_id', '<?= $_POST['users_level_id'] ?>');
    formdata.append('cabang_id', '<?= $_POST['cabang_id'] ?>');
    formdata.append('token', '<?= $_POST['token'] ?>');
    formdata.append('Nama_Tabel', Nama_Tabel);
    formdata.append('id', document.getElementById('edit-id').value);
    var ajax = new XMLHttpRequest();
    ajax.addEventListener('load', responseSimpan, false);
    ajax.open('POST', '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/hapus.php');
    ajax.send(formdata);
  }

 function tutupPopUpHapus()
  { document.getElementById('edit-id').value = '';
    hideModal('popUpHapus');
  }

 //No Telp---------------------------------------------------------------------------------------------------------------

 function clearNoTelp()
  { document.querySelector('#list-no_telp').innerHTML = `
     <div style="display:grid; grid-template-columns:1fr 40px 40px; gap:5px;">
      <input type="text" class="form-control" onkeypress="return hanyaAngka2(this);">
      <button type="button" class="btn btn-danger" onclick="hapusNoTelp(this);"><i class="fa fa-trash"></i></button>
      <button type="button" class="btn btn-success" onclick="tambahNoTelp();"><i class="fa fa-plus"></i></button>
     </div>
    `;
    setActionNoTelp();
  }

 function tambahNoTelp()
  { var a = document.querySelector('#list-no_telp > div');
    const new_child = a.cloneNode(true);
    new_child.querySelector('input').value = '';
    document.querySelector('#list-no_telp').appendChild(new_child);
    setActionNoTelp();
  }

 function hapusNoTelp(element)
  { var a = document.querySelectorAll('#list-no_telp > div');
    if(a.length > 1)
     { element.parentNode.remove();
     }
    else
     { a[i].querySelector('input').value = '';
     }
    setActionNoTelp();
  }

 function setActionNoTelp()
  { var a = document.querySelectorAll('#list-no_telp > div');
    for(var i=0; i<a.length; i++)
     { if(i == 0)
        { if(a.length == 1)
           { a[i].style['grid-template-columns'] = '1fr 40px';
             a[i].querySelector('.btn-success').style['display'] = 'inline-block';
             a[i].querySelector('.btn-danger').style['display'] = 'none';
           }
          else
           { a[i].style['grid-template-columns'] = '1fr 40px';
             a[i].querySelector('.btn-success').style['display'] = 'none';
             a[i].querySelector('.btn-danger').style['display'] = 'inline-block';
           }
        }
       else if(i == a.length - 1)
        { a[i].style['grid-template-columns'] = '1fr 40px 40px';
          a[i].querySelector('.btn-success').style['display'] = 'inline-block';
          a[i].querySelector('.btn-danger').style['display'] = 'inline-block';
        }
       else
        { a[i].style['grid-template-columns'] = '1fr 40px';
          a[i].querySelector('.btn-success').style['display'] = 'none';
          a[i].querySelector('.btn-danger').style['display'] = 'inline-block';
        }
     }
  }

 //No Telp---------------------------------------------------------------------------------------------------------------

 //No Wa-----------------------------------------------------------------------------------------------------------------

 function clearNoWa()
  { document.querySelector('#list-no_wa').innerHTML = `
     <div style="display:grid; grid-template-columns:1fr 40px 40px; gap:5px;">
      <input type="text" class="form-control" onkeypress="return hanyaAngka2(this);">
      <button type="button" class="btn btn-danger" onclick="hapusNoWa(this);"><i class="fa fa-trash"></i></button>
      <button type="button" class="btn btn-success" onclick="tambahNoWa();"><i class="fa fa-plus"></i></button>
     </div>
    `;
    setActionNoWa();
  }

 function tambahNoWa()
  { var a = document.querySelector('#list-no_wa > div');
    const new_child = a.cloneNode(true);
    new_child.querySelector('input').value = '';
    document.querySelector('#list-no_wa').appendChild(new_child);
    setActionNoWa();
  }

 function hapusNoWa(element)
  { var a = document.querySelectorAll('#list-no_wa > div');
    if(a.length > 1)
     { element.parentNode.remove();
     }
    else
     { a[i].querySelector('input').value = '';
     }
    setActionNoWa();
  }

 function setActionNoWa()
  { var a = document.querySelectorAll('#list-no_wa > div');
    for(var i=0; i<a.length; i++)
     { if(i == 0)
        { if(a.length == 1)
           { a[i].style['grid-template-columns'] = '1fr 40px';
             a[i].querySelector('.btn-success').style['display'] = 'inline-block';
             a[i].querySelector('.btn-danger').style['display'] = 'none';
           }
          else
           { a[i].style['grid-template-columns'] = '1fr 40px';
             a[i].querySelector('.btn-success').style['display'] = 'none';
             a[i].querySelector('.btn-danger').style['display'] = 'inline-block';
           }
        }
       else if(i == a.length - 1)
        { a[i].style['grid-template-columns'] = '1fr 40px 40px';
          a[i].querySelector('.btn-success').style['display'] = 'inline-block';
          a[i].querySelector('.btn-danger').style['display'] = 'inline-block';
        }
       else
        { a[i].style['grid-template-columns'] = '1fr 40px';
          a[i].querySelector('.btn-success').style['display'] = 'none';
          a[i].querySelector('.btn-danger').style['display'] = 'inline-block';
        }
     }
  }

 //No Wa-----------------------------------------------------------------------------------------------------------------

 //Email-----------------------------------------------------------------------------------------------------------------

 function clearEmail()
  { document.querySelector('#list-email').innerHTML = `
     <div style="display:grid; grid-template-columns:1fr 40px 40px; gap:5px;">
      <input type="text" class="form-control">
      <button type="button" class="btn btn-danger" onclick="hapusEmail(this);"><i class="fa fa-trash"></i></button>
      <button type="button" class="btn btn-success" onclick="tambahEmail();"><i class="fa fa-plus"></i></button>
     </div>
    `;
    setActionEmail();
  }

 function tambahEmail()
  { var a = document.querySelector('#list-email > div');
    const new_child = a.cloneNode(true);
    new_child.querySelector('input').value = '';
    document.querySelector('#list-email').appendChild(new_child);
    setActionEmail();
  }

 function hapusEmail(element)
  { var a = document.querySelectorAll('#list-email > div');
    if(a.length > 1)
     { element.parentNode.remove();
     }
    else
     { a[i].querySelector('input').value = '';
     }
    setActionEmail();
  }

 function setActionEmail()
  { var a = document.querySelectorAll('#list-email > div');
    for(var i=0; i<a.length; i++)
     { if(i == 0)
        { if(a.length == 1)
           { a[i].style['grid-template-columns'] = '1fr 40px';
             a[i].querySelector('.btn-success').style['display'] = 'inline-block';
             a[i].querySelector('.btn-danger').style['display'] = 'none';
           }
          else
           { a[i].style['grid-template-columns'] = '1fr 40px';
             a[i].querySelector('.btn-success').style['display'] = 'none';
             a[i].querySelector('.btn-danger').style['display'] = 'inline-block';
           }
        }
       else if(i == a.length - 1)
        { a[i].style['grid-template-columns'] = '1fr 40px 40px';
          a[i].querySelector('.btn-success').style['display'] = 'inline-block';
          a[i].querySelector('.btn-danger').style['display'] = 'inline-block';
        }
       else
        { a[i].style['grid-template-columns'] = '1fr 40px';
          a[i].querySelector('.btn-success').style['display'] = 'none';
          a[i].querySelector('.btn-danger').style['display'] = 'inline-block';
        }
     }
  }

 //Email-----------------------------------------------------------------------------------------------------------------

 //Map-------------------------------------------------------------------------------------------------------------------

 var lat_awal = '3.609890181277039';
 var lon_awal = '98.74290840879662';
 let marker = null;
 var mapOptions = {
  center: [lat_awal, lon_awal],
  zoom: 17,
  maxZoom: 18
 }
 var iconOptions = {
  iconUrl: 'pictures/icon/logo.png',
  iconSize: [50, 50]
 }
 var markerOptions = {
  title: "Lokasi Saya",
  clickable: true,
  draggable: false,
 }
 var map = null;

 function cariLokasiSaya()
  { document.getElementsByClassName('loader')[0].style['display'] = 'block';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'block';
    if(document.getElementById('lokasi').value == '')
     { if("geolocation" in navigator)
        { navigator.geolocation.getCurrentPosition(
           (position) => {
            document.getElementsByClassName('loader')[0].style['display'] = 'none';
            document.getElementsByClassName('loader-block')[0].style['display'] = 'none';
            lat_awal = position.coords.latitude;
            lon_awal = position.coords.longitude;
            tampilPopMap();
           },
           (error) => {
            document.getElementsByClassName('loader')[0].style['display'] = 'none';
            document.getElementsByClassName('loader-block')[0].style['display'] = 'none';
            tampilPopMap();
            // Handle errors
            /*switch (error.code) {
             case error.PERMISSION_DENIED:
              alert("Harap memberikan izin lokasi pada browser yang anda gunakan");
              break;
             case error.POSITION_UNAVAILABLE:
              alert("Informasi lokasi tidak tersedia");
              break;
             case error.TIMEOUT:
              alert("Silahkan coba lagi");
              break;
             default:
              alert("Gagal. Terjadi kesalahan yang tidak diketahui");
            }*/
           }
          );
        }
       else
        { document.getElementsByClassName('loader')[0].style['display'] = 'none';
          document.getElementsByClassName('loader-block')[0].style['display'] = 'none';
          alert("Browser ini tidak mendukung untuk pencarian lokasi");
          tampilPopMap();
        }
     }
    else
     { document.getElementsByClassName('loader')[0].style['display'] = 'none';
       document.getElementsByClassName('loader-block')[0].style['display'] = 'none';
       var lokasi = document.getElementById('lokasi').value.toString().split(',');
       lat_awal = lokasi[0];
       lon_awal = lokasi[1];
       tampilPopMap();
     }
    
  }

 function tampilPopMap()
  { showModal('popUpLokasi');
    setSizePopUpMap();
  }

 function setSizePopUpMap()
  { document.getElementById('popUpLokasi').querySelector('.modal-dialog').style['width'] = window.innerWidth + 'px';
    document.getElementById('popUpLokasi').querySelector('.modal-dialog .modal-body').style['height'] = (window.innerHeight - document.getElementById('btnpilih').offsetHeight - 1) + 'px';
    document.getElementById('popUpLokasi').querySelector('.modal-dialog .modal-body').style['padding'] = '0px';
    jalankan();
  }

 function jalankan()
  { try
     { map = new L.map('mapku', mapOptions);

       var layer = new L.TileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
       map.addLayer(layer);

       marker = L.marker([lat_awal, lon_awal], markerOptions);
       marker.bindPopup("Lokasi").openPopup();
       marker.addTo(map);

       map.on('click', function(e) {
        //alert("Lat, Lon : " + e.latlng.lat + ", " + e.latlng.lng)
       });

       map.on("drag", function(e) {
        marker.setLatLng(new L.LatLng(map.getCenter().lat, map.getCenter().lng));
       });
     }
    catch(err) { }
    map.panTo(new L.LatLng(lat_awal, lon_awal));
    marker.setLatLng(new L.LatLng(map.getCenter().lat, map.getCenter().lng));
  }

 function pilihLokasi()
  { hideModal('popUpLokasi');
    var lokasi = marker._latlng.lat + ',' + marker._latlng.lng;
    document.getElementById('lokasi').value = lokasi;
  }

 //Map-------------------------------------------------------------------------------------------------------------------

</script>