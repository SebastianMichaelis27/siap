<?php
 include("../bjksadkhrej121lkjkjk.php");
 $list_cabang = "<option></option>";
 $query = "select * from cabang order by nama asc";
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $list_cabang .= "<option value='".$row['id']."'>".$row['nama']."</option>";
  }
?>

<section class='content'>
 <input type='hidden' id='edit-id'>
 <span id='filterKu' style='display:none;'>[]</span>
 <div class='box box-default'>
  <div class='box-header with-border'>
   <h3 class='box-title'>Gudang</h3>
   <div class='box-tools pull-right'>
    <button type='button' class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-minus'></i></button>
   </div>
  </div>
  <div class='box-body'>
   <div class='row'>
    <div class='col-md-12'>
     <div class='row'>
      <div class='col-md-6'>
       <div class='row' style='margin-bottom:5px;' id='row-cabang_id'>
        <div class='col-md-4' style='padding-top:7px;'>
         <label>Cabang *</label>
        </div>
        <div class='col-md-8'>
         <select class='form-control fieldku' style='width:100%;' onchange='tampilListView();' id='cabang_id'>
          <?= $list_cabang ?>
         </select>
         <div style='color:red' class='error' id='error-cabang_id'></div>
        </div>
       </div>
       <div class='row'>
        <div class='col-md-4' style='padding-top:7px;'>
         <label>Nama Gudang *</label>
        </div>
        <div class='col-md-8'>
         <input type='text' autocomplete='new-password' class='form-control fieldku' id='nama'>
         <div style='color:red' class='error' id='error-nama'></div>
        </div>
       </div>
      </div>
      <div class='col-md-6'>
       <div class='row'>
        <div class='col-md-4' style='padding-top:7px;'>
         <label>Alamat</label>
        </div>
        <div class='col-md-8'>
         <input type='text' autocomplete='new-password' class='form-control fieldku' id='alamat'>
         <div style='color:red' class='error' id='error-alamat'></div>
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
     <h3 class='box-title'>List Gudang</h3>
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

<div id='div-result' style='display:none'></div>

<script>

 var Nama_Tabel = 'gudang';
 var FieldTidakBolehRangkap = [
  {field : 'nama'},
 ];
 var FieldRequired = [
  {field : 'cabang_id', label : 'Cabang'},
  {field : 'nama', label : 'Nama Gudang'},
 ];
 var maxRecord = 10;

 $('#cabang_id').select2({ placeholder : '', allowClear : true });
 if('<?= $_POST['cabang_id'] ?>' !== '')
  { document.getElementById('cabang_id').value = '<?= $_POST['cabang_id'] ?>';
    document.getElementById('row-cabang_id').style['display'] = 'none';
  }

 tampilListView();

 function validasi()
  { if('<?= $_POST['cabang_id'] ?>' !== '')
     { document.getElementById('cabang_id').value = '<?= $_POST['cabang_id'] ?>';
     }
    var data = {};
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
    formdata.append('cari_cabang_id', document.getElementById('cabang_id').value);
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
     { if(a[loop].id !== 'cabang_id')
        { a[loop].value = '';
          try
           { $('#' + a[loop].id).trigger('change');
           }
          catch(er) { }
        }
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

</script>