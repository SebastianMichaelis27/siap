<?php
 include("../bjksadkhrej121lkjkjk.php");
 $list_jam = "";
 for($i=0; $i<=23; $i++)
  { $list_jam .= "<option>".str_pad($i, 2, "0", STR_PAD_LEFT)."</option>";
  }
 $list_menit = "";
 for($i=0; $i<=59; $i++)
  { $list_menit .= "<option>".str_pad($i, 2, "0", STR_PAD_LEFT)."</option>";
  }
?>

<section class='content'>
 <input type='hidden' id='edit-id'>
 <input type='hidden' id='edit-id-shift-jam-kerja'>
 <span id='filterKu' style='display:none;'>[]</span>
 <div class='box box-default'>
  <div class='box-header with-border'>
   <h3 class='box-title'>Jam Kerja</h3>
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
         <label>Jam Kerja *</label>
        </div>
        <div class='col-md-8'>
         <input type='text' autocomplete='new-password' class='form-control fieldku' id='jam_kerja'>
         <div class='error' id='error-jam_kerja'></div>
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
     <h3 class='box-title'>List Jam Kerja</h3>
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

<div class='modal' id='popUpShiftJamKerja'>
 <div class='modal-dialog'>
  <div class='modal-content'>
   <div class='modal-header'>
    <button type='button' class='close' onclick="hideModal('popUpShiftJamKerja');">&times</button>
    <h4 class='modal-title'>Shift Jam Kerja</h4>
   </div>
   <div class='modal-body'>

    <div id='form-input-shift-jam-kerja'>
     <div class='row'>
      <div class='col-md-12'>
       <div class='row'>
        <div class='col-md-4' style='padding-top:7px;'>
         <label>Nama Shift *</label>
        </div>
        <div class='col-md-8'>
         <input type='text' class='form-control fieldku2' id='shift-jam-kerja-shift'>
         <div class='error' id='error-shift-jam-kerja-shift'></div>
        </div>
       </div>
       <div class='row' style='margin-top:5px;'>
        <div class='col-md-4' style='padding-top:7px;'>
         <label>Jam Kerja *</label>
        </div>
        <div class='col-md-8'>
         <div style='display:grid; grid-template-columns:50px 10px 50px 50px 50px 10px 50px; gap:5px;'>
          <select class='form-control waktu' style='width:100%;' id='masuk_jam'>
           <?= $list_jam ?>
          </select>
          <div style='text-align:center; padding-top:7px;'>:</div>
          <select class='form-control waktu' style='width:100%;' id='masuk_menit'>
           <?= $list_menit ?>
          </select>
          <div style='text-align:center; padding-top:7px;'>s/d</div>
          <select class='form-control waktu' style='width:100%;' id='pulang_jam'>
           <?= $list_jam ?>
          </select>
          <div style='text-align:center; padding-top:7px;'>:</div>
          <select class='form-control waktu' style='width:100%;' id='pulang_menit'>
           <?= $list_menit ?>
          </select>
         </div>
         <div class='error' id='error-shift-jam-kerja-jam_masuk'></div>
        </div>
       </div>
       <div class='row' style='margin-top:5px;'>
        <div class='col-md-4' style='padding-top:7px;'>
         <label>Hari *</label>
        </div>
        <div class='col-md-8'>
         <div style='display:grid; grid-template-columns:1fr 1fr 1fr 1fr; gap:5px;'>
          <div>
           <input type='checkbox' id='senin'>
           <label for='senin' style='font-weight:normal; user-select:none; cursor:pointer;'>Senin</label>
          </div>
          <div>
           <input type='checkbox' id='selasa'>
           <label for='selasa' style='font-weight:normal; user-select:none; cursor:pointer;'>Selasa</label>
          </div>
          <div>
           <input type='checkbox' id='rabu'>
           <label for='rabu' style='font-weight:normal; user-select:none; cursor:pointer;'>Rabu</label>
          </div>
          <div>
           <input type='checkbox' id='kamis'>
           <label for='kamis' style='font-weight:normal; user-select:none; cursor:pointer;'>Kamis</label>
          </div>
          <div>
           <input type='checkbox' id='jumat'>
           <label for='jumat' style='font-weight:normal; user-select:none; cursor:pointer;'>Jumat</label>
          </div>
          <div>
           <input type='checkbox' id='sabtu'>
           <label for='sabtu' style='font-weight:normal; user-select:none; cursor:pointer;'>Sabtu</label>
          </div>
          <div>
           <input type='checkbox' id='minggu'>
           <label for='minggu' style='font-weight:normal; user-select:none; cursor:pointer;'>Minggu</label>
          </div>
         </div>
         <div class='error' id='error-shift-jam-kerja-hari'></div>
        </div>
       </div>
      </div>
     </div>
     <div class='row' style='margin-top:10px;'>
      <div class='col-md-12'>
       <input type='button' class='btn btn-default' value='&laquo' style='float:left; height:35px;' onclick='previousPageShiftJamKerja()'>
       <div style='display:inline-block; max-width:80px; float:left;'>
        <select class='form-control halaman' style='text-align:center; width:100%;' onchange='goToPageShiftJamKerja(this.value);' id='preview-halaman-shift-jam-kerja'>
         <option value='1' selected>1</option>
        </select>
       </div>
       <input type='button' class='btn btn-default' value='&raquo' style='float:left; height:35px;' onclick='nextPageShiftJamKerja()'>
       <button type='button' class='btn btn-default' style='float:left; height:35px;' onclick='refreshShiftJamKerja();'><i class='fa fa-refresh'></i></button>
       <input type='text' class='form-control' autocomplete='new-password' placeholder='Cari..' style='max-width:250px; height:35px; float:left;' onkeyup='tampilShiftJamKerja();' onchange='tampilShiftJamKerja();' id='txtcarishiftjamkerja'>
       <span style='float:right; padding-top:10px;' id='jlh-halaman-shift-jam-kerja'>Jumlah Halaman :</span>
      </div>
     </div>
     <div id='tabelkushiftjamkerja' class='responsiveku'><input type='hidden' id='txthalamanshiftjamkerja' value='1'></div>
    </div>
    <div id='form-hapus-shift-jam-kerja'>
     <h4>Yakin Menghapus Data Jam Kerja?</h4>
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

 $('.waktu').select2({ placeholder : 'Pilih', allowClear : false });

 var Nama_Tabel = 'jam_kerja';
 var FieldTidakBolehRangkap = [
  {field : 'jam_kerja'},
 ];
 var FieldRequired = [
  {field : 'jam_kerja', label : 'Jam Kerja'},
 ];
 var maxRecord = 10;

 tampilListView();

 function validasi()
  { var data = {};
    var a = document.getElementsByClassName('fieldku');
    for(var loop=0; loop<a.length; loop++)
     { if(a[loop].value !== '')
        { data[a[loop].id] = a[loop].value;
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

 //Shift Jam Kerja---------------------------------------------------------------------------------------------------------------------------------------

 function showPopUpShiftJamKerja(jenis)
  { if(jenis == 'input')
     { document.getElementById('form-input-shift-jam-kerja').style['display'] = 'block';
       document.getElementById('form-hapus-shift-jam-kerja').style['display'] = 'none';
       document.getElementById('popUpShiftJamKerja').querySelector('.modal-footer .btn-default').innerHTML = "<i class='fa fa-close'></i> Tutup";
       document.getElementById('popUpShiftJamKerja').querySelector('.modal-footer .btn-default').setAttribute("onclick", "hideModal('popUpShiftJamKerja');");
       document.getElementById('popUpShiftJamKerja').querySelector('.modal-header .close').setAttribute("onclick", "hideModal('popUpShiftJamKerja');");
       document.getElementById('popUpShiftJamKerja').querySelector('.modal-footer .btn-primary').innerHTML = "<i class='fa fa-save'></i> Simpan";
       document.getElementById('popUpShiftJamKerja').querySelector('.modal-footer .btn-primary').setAttribute("onclick", "validasiShiftJamKerja();");
     }
    else if(jenis == 'edit')
     { document.getElementById('form-input-shift-jam-kerja').style['display'] = 'block';
       document.getElementById('form-hapus-shift-jam-kerja').style['display'] = 'none';
       document.getElementById('popUpShiftJamKerja').querySelector('.modal-footer .btn-default').innerHTML = "<i class='fa fa-close'></i> Batal";
       document.getElementById('popUpShiftJamKerja').querySelector('.modal-footer .btn-default').setAttribute("onclick", "clearShiftJamKerja(); showPopUpShiftJamKerja('input');");
       document.getElementById('popUpShiftJamKerja').querySelector('.modal-header .close').setAttribute("onclick", "clearShiftJamKerja(); showPopUpShiftJamKerja('input');");
       document.getElementById('popUpShiftJamKerja').querySelector('.modal-footer .btn-primary').innerHTML = "<i class='fa fa-save'></i> Simpan";
       document.getElementById('popUpShiftJamKerja').querySelector('.modal-footer .btn-primary').setAttribute("onclick", "validasiShiftJamKerja();");
     }
    else if(jenis == 'hapus')
     { document.getElementById('form-input-shift-jam-kerja').style['display'] = 'none';
       document.getElementById('form-hapus-shift-jam-kerja').style['display'] = 'block';
       document.getElementById('popUpShiftJamKerja').querySelector('.modal-footer .btn-default').innerHTML = "<i class='fa fa-close'></i> Batal";
       document.getElementById('popUpShiftJamKerja').querySelector('.modal-footer .btn-default').setAttribute("onclick", "clearShiftJamKerja(); showPopUpShiftJamKerja('input');");
       document.getElementById('popUpShiftJamKerja').querySelector('.modal-header .close').setAttribute("onclick", "clearShiftJamKerja(); showPopUpShiftJamKerja('input');");
       document.getElementById('popUpShiftJamKerja').querySelector('.modal-footer .btn-primary').innerHTML = "<i class='fa fa-trash'></i> Hapus";
       document.getElementById('popUpShiftJamKerja').querySelector('.modal-footer .btn-primary').setAttribute("onclick", "hapusShiftJamKerja();");
     }
    showModal('popUpShiftJamKerja');
  }

 var FieldRequiredShiftJamKerja = [
  {field : 'shift-jam-kerja-shift', label : 'Shift'},
 ];

 function pilihShiftJamKerja(element)
  { var list = document.getElementsByClassName(element.className);
    list = [].slice.call(list);
    var position = list.indexOf(element);
    document.getElementById('edit-id').value = document.getElementsByClassName('textarea_edit-id')[position].value;
    document.getElementById('popUpShiftJamKerja').querySelector('.modal-title').innerHTML = document.getElementsByClassName('textarea_edit-jam_kerja')[position].value;
    document.getElementsByClassName('loader')[0].style['display'] = 'block';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'block';
    tampilShiftJamKerja();
  }

 function tampilShiftJamKerja()
  { var formdata = new FormData();
    formdata.append('username', '<?= $_POST['username'] ?>');
    formdata.append('users_level_id', '<?= $_POST['users_level_id'] ?>');
    formdata.append('cabang_id', '<?= $_POST['cabang_id'] ?>');
    formdata.append('token', '<?= $_POST['token'] ?>');
    formdata.append('maxRecord', maxRecord);
    formdata.append('id', document.getElementById('edit-id').value);
    var ajax = new XMLHttpRequest();
    ajax.addEventListener('load', responseTampilShiftJamKerja, false);
    ajax.open('POST', '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/tampil-shift-jam-kerja.php');
    ajax.send(formdata);
  }

 function responseTampilShiftJamKerja()
  { document.getElementsByClassName('loader')[0].style['display'] = 'none';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'none';
    $('#tabelkushiftjamkerja').html(event.srcElement.response);
    document.getElementById('jlh-halaman-shift-jam-kerja').innerHTML = 'Jumlah Halaman : ' + document.getElementById('txtnhalamanshiftjamkerja').value;
    document.getElementById('preview-halaman-shift-jam-kerja').innerHTML = document.getElementById('temp-preview-halaman-shift-jam-kerja').innerHTML;
    showPopUpShiftJamKerja('input');
  }

 function nextPageShiftJamKerja()
  { var hal = document.getElementById('txthalamanshiftjamkerja').value;
    hal++;
    document.getElementById('txthalamanshiftjamkerja').value = hal;
    tampilShiftJamKerja();
  }

 function previousPageShiftJamKerja()
  { var hal = document.getElementById('txthalamanshiftjamkerja').value;
    hal--;
    document.getElementById('txthalamanshiftjamkerja').value = hal;
    tampilShiftJamKerjas();
  }

 function goToPageShiftJamKerja(value)
  { document.getElementById('txthalamanshiftjamkerja').value = value;
    tampilShiftJamKerja();
  }

 function refreshShiftJamKerja()
  { document.getElementById('txtcarishiftjamkerja').value = '';
    clearShiftJamKerja();
    tampilShiftJamKerja();
  }

 function clearShiftJamKerja()
  { document.getElementById('edit-id-shift-jam-kerja').value = '';
    var a = document.getElementsByClassName('fieldku2');
    for(var i=0; i<a.length; i++)
     { a[i].value = '';
       document.getElementById('error-' + a[i].id).innerHTML = '';
     }
    document.getElementById('senin').checked = false;
    document.getElementById('selasa').checked = false;
    document.getElementById('rabu').checked = false;
    document.getElementById('kamis').checked = false;
    document.getElementById('jumat').checked = false;
    document.getElementById('sabtu').checked = false;
    document.getElementById('minggu').checked = false;
    document.getElementById('error-shift-jam-kerja-jam_masuk').innerHTML = '';
    document.getElementById('error-shift-jam-kerja-hari').innerHTML = '';
    document.getElementById('masuk_jam').value = '00';
    document.getElementById('masuk_menit').value = '00';
    document.getElementById('pulang_jam').value = '00';
    document.getElementById('pulang_menit').value = '00';
    $('.waktu').trigger('change');
  }

 function validasiShiftJamKerja()
  { var data = {};
    data.jam_kerja_id = document.getElementById('edit-id').value;
    data.jam_masuk = document.getElementById('masuk_jam').value + ':' + document.getElementById('masuk_menit').value + ':00';
    data.jam_pulang = document.getElementById('pulang_jam').value + ':' + document.getElementById('pulang_menit').value + ':00';
    if(document.getElementById('senin').checked == true)
     { data.senin = 1;
     }
    else
     { data.senin = 0;
     }
    if(document.getElementById('selasa').checked == true)
     { data.selasa = 1;
     }
    else
     { data.selasa = 0;
     }
    if(document.getElementById('rabu').checked == true)
     { data.rabu = 1;
     }
    else
     { data.rabu = 0;
     }
    if(document.getElementById('kamis').checked == true)
     { data.kamis = 1;
     }
    else
     { data.kamis = 0;
     }
    if(document.getElementById('jumat').checked == true)
     { data.jumat = 1;
     }
    else
     { data.jumat = 0;
     }
    if(document.getElementById('sabtu').checked == true)
     { data.sabtu = 1;
     }
    else
     { data.sabtu = 0;
     }
    if(document.getElementById('minggu').checked == true)
     { data.minggu = 1;
     }
    else
     { data.minggu = 0;
     }
    var a = document.getElementsByClassName('fieldku2');
    for(var loop=0; loop<a.length; loop++)
     { if(a[loop].value !== '')
        { if(a[loop].id.toString().replaceAll('shift-jam-kerja-', '') == 'tanggal')
           { data[a[loop].id.toString().replaceAll('shift-jam-kerja-', '')] = normalisasi_tanggal(a[loop].value);
           }
          else if(a[loop].id.toString().replaceAll('shift-jam-kerja-', '') == 'nominal')
           { data[a[loop].id.toString().replaceAll('shift-jam-kerja-', '')] = normal(a[loop].value);
           }
          else
           { data[a[loop].id.toString().replaceAll('shift-jam-kerja-', '')] = a[loop].value;
           }
        }
       else
        { data[a[loop].id] = null;
        }
     }
    var error = 0;
    for(var loop=0; loop<FieldRequiredShiftJamKerja.length; loop++)
     { if(document.getElementById(FieldRequiredShiftJamKerja[loop].field).value == '')
        { error++;
          document.getElementById('error-' + FieldRequiredShiftJamKerja[loop].field).innerHTML = '<b>' + FieldRequiredShiftJamKerja[loop].label + '</b> wajib diisi';
        }
       else
        { document.getElementById('error-' + FieldRequiredShiftJamKerja[loop].field).innerHTML = '';
        }
     }
    if(document.getElementById('masuk_jam').value == '' || document.getElementById('masuk_menit').value == '' || document.getElementById('pulang_jam').value == '' || document.getElementById('pulang_menit').value == '')
     { error++;
       document.getElementById('error-shift-jam-kerja-jam_masuk').innerHTML = '<b>Jam Kerja</b> wajib diisi';
     }
    else
     { document.getElementById('error-shift-jam-kerja-jam_masuk').innerHTML = '';
     }
    if(error < 1)
     { simpanShiftJamKerja(data)
     }
  }

 function simpanShiftJamKerja(data)
  { document.getElementsByClassName('loader')[0].style['display'] = 'block';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'block';
    if(document.getElementById('edit-id-shift-jam-kerja').value == '')
     { var formdata = new FormData();
       formdata.append('username', '<?= $_POST['username'] ?>');
       formdata.append('users_level_id', '<?= $_POST['users_level_id'] ?>');
       formdata.append('cabang_id', '<?= $_POST['cabang_id'] ?>');
       formdata.append('token', '<?= $_POST['token'] ?>');
       formdata.append('Nama_Tabel', 'shift_jam_kerja');
       formdata.append('data', JSON.stringify(data));
       var ajax = new XMLHttpRequest();
       ajax.addEventListener('load', responseSimpanShiftJamKerja, false);
       ajax.open('POST', '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/simpan-shift-jam-kerja.php');
       ajax.send(formdata);
     }
    else
     { var formdata = new FormData();
       formdata.append('username', '<?= $_POST['username'] ?>');
       formdata.append('users_level_id', '<?= $_POST['users_level_id'] ?>');
       formdata.append('cabang_id', '<?= $_POST['cabang_id'] ?>');
       formdata.append('token', '<?= $_POST['token'] ?>');
       formdata.append('Nama_Tabel', 'shift_jam_kerja');
       formdata.append('data', JSON.stringify(data));
       formdata.append('id', document.getElementById('edit-id-shift-jam-kerja').value);
       var ajax = new XMLHttpRequest();
       ajax.addEventListener('load', responseSimpanShiftJamKerja, false);
       ajax.open('POST', '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/ubah-shift-jam-kerja.php');
       ajax.send(formdata);
     }
  }

 function responseSimpanShiftJamKerja()
  { document.getElementsByClassName('loader')[0].style['display'] = 'none';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'none';
    $('#div-result').html(event.srcElement.response);
    if(event.srcElement.response !== "1")
     { alert(event.srcElement.response);
     }
    else
     { clearShiftJamKerja();
       tampilShiftJamKerja();
       tampilListView();
       showPopUpShiftJamKerja('input');
     }
  }

 function editShiftJamKerja(element)
  { clearShiftJamKerja();
    var list = document.getElementsByClassName(element.className);
    list = [].slice.call(list);
    var position = list.indexOf(element);
    document.getElementById('edit-id-shift-jam-kerja').value = document.getElementsByClassName('textarea_shift-jam-kerja-id')[position].value;
    var a = document.getElementsByClassName('fieldku2');
    for(var i=0; i<a.length; i++)
     { document.getElementById(a[i].id).value = document.getElementsByClassName('textarea_' + a[i].id)[position].value;
     }
    document.getElementById('masuk_jam').value = document.getElementsByClassName('textarea_shift-masuk_jam')[position].value;
    document.getElementById('masuk_menit').value = document.getElementsByClassName('textarea_shift-masuk_menit')[position].value;
    document.getElementById('pulang_jam').value = document.getElementsByClassName('textarea_shift-pulang_jam')[position].value;
    document.getElementById('pulang_menit').value = document.getElementsByClassName('textarea_shift-pulang_menit')[position].value;
    if(document.getElementsByClassName('textarea_shift-jam-kerja-senin')[position].value == '1')
     { document.getElementById('senin').checked = true;
     }
    if(document.getElementsByClassName('textarea_shift-jam-kerja-selasa')[position].value == '1')
     { document.getElementById('selasa').checked = true;
     }
    if(document.getElementsByClassName('textarea_shift-jam-kerja-rabu')[position].value == '1')
     { document.getElementById('rabu').checked = true;
     }
    if(document.getElementsByClassName('textarea_shift-jam-kerja-kamis')[position].value == '1')
     { document.getElementById('kamis').checked = true;
     }
    if(document.getElementsByClassName('textarea_shift-jam-kerja-jumat')[position].value == '1')
     { document.getElementById('jumat').checked = true;
     }
    if(document.getElementsByClassName('textarea_shift-jam-kerja-sabtu')[position].value == '1')
     { document.getElementById('sabtu').checked = true;
     }
    if(document.getElementsByClassName('textarea_shift-jam-kerja-minggu')[position].value == '1')
     { document.getElementById('minggu').checked = true;
     }
    $('.waktu').trigger('change');
    showPopUpShiftJamKerja('edit');
  }

 function konfirmasiHapusShiftJamKerja(element)
  { var list = document.getElementsByClassName(element.className);
    list = [].slice.call(list);
    var position = list.indexOf(element);
    document.getElementById('edit-id-shift-jam-kerja').value = document.getElementsByClassName('textarea_shift-jam-kerja-id')[position].value;
    showPopUpShiftJamKerja('hapus');
  }

 function hapusShiftJamKerja()
  { document.getElementsByClassName('loader')[0].style['display'] = 'block';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'block';
    var formdata = new FormData();
    formdata.append('username', '<?= $_POST['username'] ?>');
    formdata.append('users_level_id', '<?= $_POST['users_level_id'] ?>');
    formdata.append('cabang_id', '<?= $_POST['cabang_id'] ?>');
    formdata.append('token', '<?= $_POST['token'] ?>');
    formdata.append('Nama_Tabel', 'shift_jam_kerja');
    formdata.append('id', document.getElementById('edit-id-shift-jam-kerja').value);
    var ajax = new XMLHttpRequest();
    ajax.addEventListener('load', responseSimpanShiftJamKerja, false);
    ajax.open('POST', '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/hapus-shift-jam-kerja.php');
    ajax.send(formdata);
  }

 //Shift Jam Kerja---------------------------------------------------------------------------------------------------------------------------------------

</script>