<?php
 include("../bjksadkhrej121lkjkjk.php");

 $list_cabang = "<option></option>";
 $query = "select * from cabang order by nama asc";
 if(isset($_POST['cabang_id']) && $_POST['cabang_id'] !== "")
  { $query = "select * from cabang where cabang_id = '".intval($_POST['cabang_id'])."' order by nama asc";
  }
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $list_cabang .= "<option value='".$row['id']."'>".$row['nama']."</option>";
  }
?>

<style>
 #popUpAddKirim .modal-dialog
  { width : 100%;
    max-width : 900px;
  }
 #popUpBarangMasukDetail .modal-dialog
  { width : 100%;
    max-width : 900px;
  }
</style>

<a id='link-cetak' target='#blank'></a>
<section class='content'>
 <input type='hidden' id='edit-id'>
 <input type='hidden' id='position-barang'>
 <span id='filterKu' style='display:none;'>[]</span>
 <div class='box box-default'>
  <div class='box-header with-border'>
   <h3 class='box-title'>Pengiriman</h3>
   <div class='box-tools pull-right'>
    <button type='button' class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-minus'></i></button>
   </div>
  </div>
  <div class='box-body'>
   <div class='row'>
    <div class='col-md-12'>
     <div class='row'>
      <div class='col-md-6'>
       <div class='row' style='margin-bottom:5px;'>
        <div class='col-md-4' style='padding-top:7px;'>
         <label>Cabang *</label>
        </div>
        <div class='col-md-8'>
         <select class='form-control fieldku' style='width:100%;' onchange='changeGudang();' id='cabang_id'>
          <?= $list_cabang ?>
         </select>
         <div class='error' id='error-cabang_id'></div>
        </div>
       </div>
       <div class='row' style='margin-top:5px;'>
        <div class='col-md-4' style='padding-top:7px;'>
         <label>Tanggal *</label>
        </div>
        <div class='col-md-8'>
         <div style='display:grid; grid-template-columns:1fr auto; gap:5px;'>
          <input type='text' class='form-control fieldku tanggal' autocomplete='new-password' style='background-color:white;' readonly id='tanggal'>
          <button type='button' class='btn btn-default' style='width:40px;' onclick="document.getElementById('tanggal').value = '';"><i class='fa fa-close'></i></button>
         </div>
         <div class='error' id='error-tanggal'></div>
        </div>
       </div>
       <div class='row' style='margin-top:5px;'>
        <div class='col-md-4' style='padding-top:7px;'>
         <label>Jenis Pengiriman *</label>
        </div>
        <div class='col-md-8'>
         <select class='form-control fieldku' id='jenis_pengiriman'>
          <option></option>
          <option value='Diantar'>Diantar</option>
          <option value='Diambil'>Diambil Customer</option>
         </select>
         <div class='error' id='error-jenis_pengiriman'></div>
        </div>
       </div>
      </div>
      <div class='col-md-6'>
       <div class='row'>
        <div class='col-md-4' style='padding-top:7px;'>
         <label>Nomor SO *</label>
        </div>
        <div class='col-md-8'>
         <div style='display:grid; grid-template-columns:1fr auto; gap:5px;' id='div-nomor_so'>
          <div style='min-height:34px; border:1px solid silver; background:#eeeeee;'>
           <div style='padding:6px 10px 6px 10px;' id='nomor_so'></div>
          </div>
          <button type='button' class='btn btn-warning' onclick='addSO();' id='btn-add-so'><i class='fa fa-search'></i></button>
         </div>
         <input type='hidden' class='fieldku' id='penjualan_id'>
         <div style='color:red;' class='error' id='error-penjualan_id'></div>
        </div>
       </div>
       <div class='row' style='margin-top:5px;'>
        <div class='col-md-4' style='padding-top:7px;'>
         <label>Customer</label>
        </div>
        <div class='col-md-8'>
         <div style='min-height:34px; border:1px solid silver; background:#eeeeee;'>
          <div style='padding:6px 10px 6px 10px;' id='customer'></div>
         </div>
         <div style='color:red;' class='error' id='error-customer'></div>
        </div>
       </div>
      </div>
     </div>
     <div class='row' style='margin-top:15px;'>
      <div class='col-md-12'>
       <div class='responsiveku'>
        <div id='div-item'></div>
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
     <h3 class='box-title'>List Pengiriman</h3>
    </div>
    <div class='box-body'>
     <div class='row'>
      <div class='col-md-12'>
       <input type='button' class='btn btn-default' value='&laquo' style='float:left; height:35px;' onclick='previousPage()'>
       <div style='display:inline-block; max-width:80px; float:left;'>
        <select class='form-control halaman' style='text-align:center; height:35px;' onchange='goToPage(this.value);' id='preview-halaman'>
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

<div class='modal' id='popUpPenjualan'>
 <div class='modal-dialog'>
  <div class='modal-content'>
   <div class='modal-header'>
    <button type='button' class='close' onclick="hideModal('popUpPenjualan');">&times</button>
    <h4 class='modal-title'>Penjualan</h4>
   </div>
   <div class='modal-body'>
    <div class='row'>
     <div class='col-md-12'>
      <input type='button' class='btn btn-default' value='&laquo' style='float:left; height:35px;' onclick='previousPagePenjualan()'>
      <div style='display:inline-block; max-width:80px; float:left;'>
       <select class='form-control' style='text-align:center; height:35px;' onchange='goToPagePenjualan(this.value);' id='preview-halaman-penjualan'>
        <option value='1' selected>1</option>
       </select>
      </div>
      <input type='button' class='btn btn-default' value='&raquo' style='float:left; height:35px;' onclick='nextPagePenjualan()'>
      <button type='button' class='btn btn-default' style='float:left; height:35px;' onclick='refreshPenjualan();'><i class='fa fa-refresh'></i></button>
      <input type='text' class='form-control' style='width:100%; max-width:200px; float:left; height:35px;' placeholder='Cari..' onchange='tampilPenjualan();' onkeyup='tampilPenjualan();' id='txtcaripenjualan'>
      <span style='float:right; padding-top:10px;' id='jlh-halaman-penjualan'>Jumlah Halaman :</span>
     </div>
    </div>
    <div id='tabelkupenjualan' class='responsiveku'><input type='hidden' id='txthalamanpenjualan' value='1'></div>
   </div>
   <div class='modal-footer'>
    <button type='button' class='btn btn-default' onclick="hideModal('popUpPenjualan');"><i class='fa fa-close'></i> Tutup</button>
   </div>
  </div>
 </div>
</div>

<div class='modal' id='popUpBarangMasukDetail'>
 <div class='modal-dialog'>
  <div class='modal-content'>
   <div class='modal-header'>
    <button type='button' class='close' onclick="hideModal('popUpBarangMasukDetail');">&times</button>
    <h4 class='modal-title'>Tandai Barang</h4>
   </div>
   <div class='modal-body'>
    <div class='tab-container' style='width:100%;'>
     <div class='tab-buttons'>
      <button type='button' class='tab-button active' onclick="document.getElementById('popUpBarangMasukDetail').querySelector('.modal-footer').querySelector('.btn-primary').style['display'] = 'none'; openTab(this);"><i class='fa fa-bookmark-o'></i> Tandai Barang</button>
      <button type='button' class='tab-button' onclick="document.getElementsByClassName('loader')[0].style['display'] = 'block'; document.getElementsByClassName('loader-block')[0].style['display'] = 'block'; tampilPenjualanDetailDitandai(); openTab(this);"><i class='fa fa-bookmark'></i> Telah Ditandai</button>
     </div>
     <div class='tab-content active'>
      <div class='row'>
       <div class='col-md-12'>
        <input type='button' class='btn btn-default' value='&laquo' style='float:left; height:35px;' onclick='previousPageBarangMasukDetail()'>
        <div style='display:inline-block; max-width:80px; float:left;'>
         <select class='form-control halaman' style='text-align:center; width:100%;' onchange='goToPageBarangMasukDetail(this.value);' id='preview-halaman-barang-masuk-detail'>
          <option value='1' selected>1</option>
         </select>
        </div>
        <input type='button' class='btn btn-default' value='&raquo' style='float:left; height:35px;' onclick='nextPageBarangMasukDetail()'>
        <button type='button' class='btn btn-default' style='float:left; height:35px;' onclick='refreshBarangMasukDetail();'><i class='fa fa-refresh'></i></button>
        <input type='text' class='form-control' style='max-width:200px; float:left;' placeholder='Cari..' onkeyup='tampilBarangMasukDetail();' onchange='BarangMasukDetail();' id='txtcaribarangmasukdetail'>
        <span style='float:right; padding-top:10px;' id='jlh-halaman-barang-masuk-detail'>Jumlah Halaman :</span>
       </div>
      </div>
      <div id='tabelkubarangmasukdetail' class='responsiveku'><input type='hidden' id='txthalamanbarangmasukdetail' value='1'></div>
     </div>
     <div class='tab-content'>
      <div class='row'>
       <div class='col-md-12'>
        <input type='button' class='btn btn-default' value='&laquo' style='float:left; height:35px;' onclick='previousPagePenjualanDetailDitandai()'>
        <div style='display:inline-block; max-width:80px; float:left;'>
         <select class='form-control halaman' style='text-align:center; width:100%;' onchange='goToPagePenjualanDetailDitandai(this.value);' id='preview-halaman-penjualan-detail-ditandai'>
          <option value='1' selected>1</option>
         </select>
        </div>
        <input type='button' class='btn btn-default' value='&raquo' style='float:left; height:35px;' onclick='nextPagePenjualanDetailDitandai()'>
        <button type='button' class='btn btn-default' style='float:left; height:35px;' onclick='refreshPenjualanDetailDitandai();'><i class='fa fa-refresh'></i></button>
        <input type='text' class='form-control' autocomplete='new-password' placeholder='Cari..' style='max-width:250px; height:35px; float:left;' onkeyup='tampilPenjualanDetailDitandai();' onchange='tampilPenjualanDetailDitandai();' id='txtcaripenjualandetailditandai'>
        <span style='float:right; padding-top:10px;' id='jlh-halaman-penjualan-detail-ditandai'>Jumlah Halaman :</span>
       </div>
      </div>
      <div id='tabelkupenjualandetailditandai' class='responsiveku'><input type='hidden' id='txthalamanpenjualandetailditandai' value='1'></div>
     </div>
    </div>
   </div>
   <div class='modal-footer'>
    <button type='button' class='btn btn-default' onclick="telah_ditandai = []; hideModal('popUpBarangMasukDetail');"><i class='fa fa-close'></i> Tutup</button>
    <button type='button' class='btn btn-primary' style='display:none;' onclick='simpanPenjualanDetailDitandai();'><i class='fa fa-save'></i> Simpan</button>
   </div>
  </div>
 </div>
</div>

<div class='modal' id='popUpAddKirim'>
 <div class='modal-dialog'>
  <div class='modal-content'>
   <div class='modal-header'>
    <button type='button' class='close' onclick="hideModal('popUpAddKirim');">&times</button>
    <h4 class='modal-title'>Kirim</h4>
   </div>
   <div class='modal-body'>
    <div class='row'>
     <div class='col-md-12'>
      <input type='button' class='btn btn-default' value='&laquo' style='float:left; height:35px;' onclick='previousPageAddKirim()'>
      <div style='display:inline-block; max-width:80px; float:left;'>
       <select class='form-control' style='text-align:center; height:35px;' onchange='goToPageAddKirim(this.value);' id='preview-halaman-add-kirim'>
        <option value='1' selected>1</option>
       </select>
      </div>
      <input type='button' class='btn btn-default' value='&raquo' style='float:left; height:35px;' onclick='nextPageAddKirim()'>
      <button type='button' class='btn btn-default' style='float:left; height:35px;' onclick='refreshAddKirim();'><i class='fa fa-refresh'></i></button>
      <input type='text' class='form-control' style='width:100%; max-width:200px; float:left; height:35px;' placeholder='Cari..' onchange='tampilAddKirim();' onkeyup='tampilAddKirim();' id='txtcariaddkirim'>
      <span style='float:right; padding-top:10px;' id='jlh-halaman-add-kirim'>Jumlah Halaman :</span>
     </div>
    </div>
    <div id='tabelkuaddkirim' class='responsiveku'><input type='hidden' id='txthalamanaddkirim' value='1'></div>
   </div>
   <div class='modal-footer'>
    <button type='button' class='btn btn-default' onclick="hideModal('popUpAddKirim');"><i class='fa fa-close'></i> Tutup</button>
   </div>
  </div>
 </div>
</div>

<div id='div-result' style='display:none'></div>

<script>

 var Nama_Tabel = 'pengiriman';
 var FieldTidakBolehRangkap = [];
 var FieldRequired = [
  {field : 'cabang_id', label : 'Cabang'},
  {field : 'tanggal', label : 'Tanggal'},
  {field : 'penjualan_id', label : 'Nomor SO'},
  {field : 'jenis_pengiriman', label : 'Jenis Pengiriman'},
 ];
 var maxRecord = 10;

 $('.tanggal').datepicker({ autoclose : true, todayHighlight : true, format : 'dd-mm-yyyy' });
 $('#cabang_id').select2({ placeholder : '', allowClear : true });
 $('#jenis_pengiriman').select2({ placeholder : '', allowClear : true });
 tampilListView();
 clearDetail();

 function changeGudang()
  { tampilListView();
  }

 function validasi()
  { var data = {};
    var a = document.getElementsByClassName('fieldku');
    for(var loop=0; loop<a.length; loop++)
     { if(a[loop].value !== '')
        { if(a[loop].id == 'tanggal')
           { data[a[loop].id] = normalisasi_tanggal(a[loop].value);
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
     { var detail = [];
       var a = document.getElementsByClassName('ditandai');
       for(var i=0; i<a.length; i++)
        { try
           { detail = detail.concat(JSON.parse(a[i].value));
           }
          catch(err) { }
        }
       var DataTidakBolehRangkap = [];
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
       simpan(data, DataTidakBolehRangkap, detail);
     }
  }

 function simpan(data, DataTidakBolehRangkap, detail)
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
       formdata.append('detail', JSON.stringify(detail));
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
       formdata.append('detail', JSON.stringify(detail));
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
    formdata.append('cabng_id', document.getElementById('cabang_id').value);
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
    document.getElementById('nomor_so').innerHTML = '';
    document.getElementById('customer').innerHTML = '';
    document.getElementsByClassName('box-title')[0].innerHTML = 'Pengiriman';
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
    setViewBtnSO();
    clearDetail();
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
    document.getElementsByClassName('box-title')[0].innerHTML = 'Pengiriman : ' + document.getElementsByClassName('textarea_edit-nomor_pengiriman')[position].value;
    var a = document.getElementsByClassName('fieldku');
    for(var loop=0; loop<a.length; loop++)
     { document.getElementById(a[loop].id).value = document.getElementsByClassName('textarea_edit-' + a[loop].id)[position].value;
       try
        { $('#' + document.getElementById(a[loop].id).id).trigger('change');
        }
       catch(er) { }
     }
    document.getElementById('penjualan_id').value = document.getElementsByClassName('textarea_edit-penjualan_id')[position].value;
    document.getElementById('nomor_so').innerHTML = document.getElementsByClassName('textarea_edit-nomor_penjualan')[position].value;
    document.getElementById('customer').innerHTML = document.getElementsByClassName('textarea_edit-customer')[position].value;

    clearDetail();
    var a = document.getElementsByClassName('edit_detail')[position].querySelectorAll('.edit_penjualan_detail-id');
    for(var i=0; i<a.length; i++)
     { var id = document.getElementsByClassName('edit_detail')[position].querySelectorAll('.edit_penjualan_detail-id')[i].value;
       var barang_id = document.getElementsByClassName('edit_detail')[position].querySelectorAll('.edit_penjualan_detail-barang_id')[i].value;
       var nama_produk = document.getElementsByClassName('edit_detail')[position].querySelectorAll('.edit_penjualan_detail-nama_produk')[i].value;
       var jumlah = document.getElementsByClassName('edit_detail')[position].querySelectorAll('.edit_penjualan_detail-jumlah')[i].value;
       var telah_dikirim = document.getElementsByClassName('edit_detail')[position].querySelectorAll('.edit_penjualan_detail-telah_dikirim')[i].value;
       var jumlah_ditandai = document.getElementsByClassName('edit_detail')[position].querySelectorAll('.edit_penjualan_detail-jumlah_ditandai')[i].value;
       var ditandai = document.getElementsByClassName('edit_detail')[position].querySelectorAll('.edit_penjualan_detail-ditandai')[i].value;
       var kirim = document.getElementsByClassName('edit_detail')[position].querySelectorAll('.edit_penjualan_detail-kirim')[i].value;
       addDetail(id, barang_id, nama_produk, jumlah, jumlah_ditandai, ditandai, telah_dikirim, kirim);
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

 function printDotMatrix(element)
  { var list = document.getElementsByClassName(element.className);
    list = [].slice.call(list);
    var position = list.indexOf(element);
    document.getElementsByClassName('loader')[0].style['display'] = 'block';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'block';
    var formdata = new FormData();
    formdata.append('data', document.getElementsByClassName('cetak-dot-matrix')[position].value);
    var ajax = new XMLHttpRequest();
    ajax.addEventListener('load', responsePrintDotMatrix, false);
    ajax.open('POST', 'http://localhost/index.php');
    ajax.send(formdata);
  }

 function responsePrintDotMatrix()
  { document.getElementsByClassName('loader')[0].style['display'] = 'none';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'none';
  }

 function clearDetail()
  { document.getElementById('div-item').innerHTML = `
     <table class='table table-bordered' style='margin-top:5px;' id='table-detail'>
      <thead>
       <tr>
        <th style='text-align:center; width:50px; min-width:50px; max-width:50px;'>No.</th>
        <th>Nama Barang</th>
        <th style='text-align:center; width:100px; min-width:100px; max-width:100px;'>Jumlah</th>
        <th style='text-align:center; width:100px; min-width:100px; max-width:100px;'>Ditandai</th>
        <th style='text-align:center; width:100px; min-width:100px; max-width:100px;'>Telah Dikirim</th>
        <th style='text-align:center; width:100px; min-width:100px; max-width:100px;'>Kirim</th>
       </tr>
      </thead>
      <tbody></tbody>
     </table>`;
  }

 //Penjualan------------------------------------------------------------------------------------------------------------

 function addSO()
  { if(document.getElementById('cabang_id').value == '')
     { document.getElementById('error-cabang_id').innerHTML = '<b>Gudang</b> wajib diisi!';
     }
    else
     { document.getElementById('error-cabang_id').innerHTML = '';
       document.getElementsByClassName('loader')[0].style['display'] = 'block';
       document.getElementsByClassName('loader-block')[0].style['display'] = 'block';
       tampilPenjualan();
     }
  }

 function tampilPenjualan()
  { var formdata = new FormData();
    formdata.append('username', '<?= $_POST['username'] ?>');
    formdata.append('users_level_id', '<?= $_POST['users_level_id'] ?>');
    formdata.append('cabang_id', '<?= $_POST['cabang_id'] ?>');
    formdata.append('token', '<?= $_POST['token'] ?>');
    formdata.append('Nama_Tabel', 'penjualan');
    formdata.append('maxRecord', maxRecord);
    formdata.append('cabng_id', document.getElementById('cabang_id').value);
    formdata.append('halaman', document.getElementById('txthalamanpenjualan').value);
    formdata.append('cari', document.getElementById('txtcaripenjualan').value);
    var ajax = new XMLHttpRequest();
    ajax.addEventListener('load', responseTampilPenjualan, false);
    ajax.open('POST', '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/tampil-penjualan.php');
    ajax.send(formdata);
  }

 function responseTampilPenjualan()
  { document.getElementsByClassName('loader')[0].style['display'] = 'none';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'none';
    $('#tabelkupenjualan').html(event.srcElement.response);
    /*document.getElementById('preview-halaman-penjualan').innerHTML = document.getElementById('temp-preview-halaman-penjualan').innerHTML;
    document.getElementById('jlh-halaman-penjualan').innerHTML = 'Jumlah Halaman : ' + formatnomor(document.getElementById('txtnhalamanpenjualan').value);*/
    showModal('popUpPenjualan');
    $('#preview-halaman-penjualan').select2({ placeholder : 'Pilih', allowClear : false });
  }

 function refreshPenjualan()
  { document.getElementById('txtcaripenjualan').value = '';
    tampilPenjualan();
  }

 function nextPagePenjualan()
  { var hal = document.getElementById('txthalamanpenjualan').value;
    hal++;
    document.getElementById('txthalamanpenjualan').value = hal;
    tampilPenjualan();
  }

 function previousPagePenjualan()
  { var hal = document.getElementById('txthalamanpenjualan').value;
    hal--;
    document.getElementById('txthalamanpenjualan').value = hal;
    tampilPenjualan();
  }

 function goToPagePenjualan(value)
  { document.getElementById('txthalamanpenjualan').value = value;
    tampilPenjualan();
  }

 function setViewBtnSO()
  { if(document.getElementById('penjualan_id').value !== '')
     { document.getElementById('btn-add-so').style['display'] = 'none';
       document.getElementById('div-nomor_so').style['grid-template-columns'] = '1fr';
       document.getElementById('div-nomor_so').style['gap'] = '0px';
     }
    else
     { document.getElementById('btn-add-so').style['display'] = 'inline-block';
       document.getElementById('div-nomor_so').style['grid-template-columns'] = '1fr auto';
       document.getElementById('div-nomor_so').style['gap'] = '5px';
     }
  }

 function pilihSO(element)
  { var list = document.getElementsByClassName(element.className);
    list = [].slice.call(list);
    var position = list.indexOf(element);
    document.getElementById('penjualan_id').value = document.getElementsByClassName('textarea_penjualan-id')[position].value;
    document.getElementById('nomor_so').innerHTML = document.getElementsByClassName('textarea_penjualan-nomor_penjualan')[position].value;
    document.getElementById('customer').innerHTML = document.getElementsByClassName('textarea_penjualan-nama_customer')[position].value;
    var a = document.getElementsByClassName('div-detail_barang')[position];
    for(var i=0; i<a.querySelectorAll('.detail_barang-id').length; i++)
     { var id = a.querySelectorAll('.detail_barang-id')[i].value;
       var barang_id = a.querySelectorAll('.detail_barang-barang_id')[i].value;
       var jumlah = a.querySelectorAll('.detail_barang-jumlah')[i].value;
       var telah_dikirim = a.querySelectorAll('.detail_barang-dikirim')[i].value;
       var jumlah_ditandai = a.querySelectorAll('.detail_barang-jumlah_ditandai')[i].value;
       var ditandai = a.querySelectorAll('.detail_barang-ditandai')[i].value;
       var nama_produk = a.querySelectorAll('.detail_barang-kode')[i].value + ' - ' + a.querySelectorAll('.detail_barang-nama')[i].value;
       if(a.querySelectorAll('.detail_barang-merek')[i].value !== '')
        { nama_produk += ' ' + a.querySelectorAll('.detail_barang-merek')[i].value;
        }
       if(a.querySelectorAll('.detail_barang-model')[i].value !== '')
        { nama_produk += ' ' + a.querySelectorAll('.detail_barang-model')[i].value;
        }
       if(a.querySelectorAll('.detail_barang-tipe')[i].value !== '')
        { nama_produk += ' ' + a.querySelectorAll('.detail_barang-tipe')[i].value;
        }
       if(a.querySelectorAll('.detail_barang-jenis')[i].value !== '')
        { nama_produk += ' ' + a.querySelectorAll('.detail_barang-jenis')[i].value;
        }
       if(a.querySelectorAll('.detail_barang-kapasitas_pk')[i].value !== '')
        { nama_produk += ' ' + a.querySelectorAll('.detail_barang-kapasitas_pk')[i].value + ' PK';
        }
       if(a.querySelectorAll('.detail_barang-btuh')[i].value !== '')
        { nama_produk += ' (' + a.querySelectorAll('.detail_barang-btuh')[i].value + ' BTU/h)';
        }
       if(a.querySelectorAll('.detail_barang-ukuran')[i].value !== '')
        { nama_produk += ' ' + a.querySelectorAll('.detail_barang-ukuran')[i].value;
          if(a.querySelectorAll('.detail_barang-satuan')[i].value !== '')
           { nama_produk += ' ' + a.querySelectorAll('.detail_barang-satuan')[i].value;
           }
        }
       var kirim = '';
       addDetail(id, barang_id, nama_produk, jumlah, jumlah_ditandai, ditandai, telah_dikirim, kirim);
     }
    setViewBtnSO();
    document.getElementById('btnfilter').innerHTML = "<i class='fa fa-close'></i> Batal";
    document.getElementById('btnfilter').setAttribute('onclick', 'clearField();');
    document.getElementById('error-penjualan_id').innerHTML = '';
  }

 function addDetail(id, barang_id, nama_produk, jumlah, jumlah_ditandai, ditandai, telah_dikirim, kirim)
  { if(barang_id == '')
     { return;
     }
    var nBarang = document.getElementsByClassName('barang_id-' + barang_id);
    if(nBarang.length == 0)
     { var table = document.getElementById('table-detail');
       var n = table.rows.length;
       var row = table.insertRow(n);
       row.className = 'row-detail';
       var cell1 = row.insertCell(0);
       var cell2 = row.insertCell(1);
       var cell3 = row.insertCell(2);
       var cell4 = row.insertCell(3);
       var cell5 = row.insertCell(4);
       var cell6 = row.insertCell(5);
       cell1.style['text-align'] = 'right';
       cell3.style['text-align'] = 'right';
       cell4.style['text-align'] = 'right';
       cell5.style['text-align'] = 'right';
       cell6.style['text-align'] = 'right';
       cell3.className = 'jumlah';
       cell5.className = 'telah-dikirim';
       cell2.innerHTML = "<input type='hidden' class='detail_id' value='" + id + "'><input type='hidden' class='barang_id barang_id-" + barang_id + "' value='" + barang_id + "'><span class='nama_produk'>" + nama_produk + "</span>";
       cell3.innerHTML = jumlah;
       cell4.innerHTML = "<div style='min-height:34px; border:1px solid silver;' class='div_ditandai' onclick='tandaiBarang(this);'><div style='padding:6px 10px 6px 10px;'>" + jumlah_ditandai + "</div></div><textarea class='ditandai' style='display:none;'>" + ditandai + "</textarea>";
       cell5.innerHTML = telah_dikirim;
       cell6.innerHTML = "<div style='min-height:34px; border:1px solid silver;' class='div_kirim-barang' onclick='kirimBarang(this);'><div style='padding:6px 10px 6px 10px;'>" + kirim + "</div></div>";
       setNomorUrut();
       hideModal('popUpPenjualan');
     }
  }

 function setNomorUrut()
  { var a = document.querySelectorAll('.row-detail');
    for(var i=0; i<a.length; i++)
     { a[i].querySelector('td').innerHTML = (i + 1);
     }
  }

 //Penjualan------------------------------------------------------------------------------------------------------------


 //Barang Masuk Detail--------------------------------------------------------------------------------------------------

 function tandaiBarang(element)
  { var list = document.getElementsByClassName(element.className);
    list = [].slice.call(list);
    var position = list.indexOf(element);
    document.getElementById('position-barang').value = position;
    document.getElementById('popUpBarangMasukDetail').querySelector('.modal-title').innerHTML = document.getElementsByClassName('nama_produk')[position].innerHTML;
    document.getElementsByClassName('loader')[0].style['display'] = 'block';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'block';
    tampilBarangMasukDetail();
  }

 function tampilBarangMasukDetail()
  { var detail_other = [];
    var detail_selected = [];
    var a = document.getElementsByClassName('barang_id');
    for(var i=0; i<a.length; i++)
     { if(a[i].value == document.getElementsByClassName('barang_id')[document.getElementById('position-barang').value].value)
        { try
           { if(i == document.getElementById('position-barang').value)
              { detail_selected = detail_selected.concat(JSON.parse(document.getElementsByClassName('ditandai')[i].value));
              }
             else
              { detail_other = detail_other.concat(JSON.parse(document.getElementsByClassName('ditandai')[i].value));
              }
           }
          catch(err) {}
        }
     }

    var formdata = new FormData();
    formdata.append('username', '<?= $_POST['username'] ?>');
    formdata.append('users_level_id', '<?= $_POST['users_level_id'] ?>');
    formdata.append('cabang_id', '<?= $_POST['cabang_id'] ?>');
    formdata.append('token', '<?= $_POST['token'] ?>');
    formdata.append('maxRecord', maxRecord);
    formdata.append('halaman', document.getElementById('txthalamanbarangmasukdetail').value);
    formdata.append('cari', document.getElementById('txtcaribarangmasukdetail').value);
    formdata.append('id', document.getElementsByClassName('detail_id')[document.getElementById('position-barang').value].value);
    formdata.append('barang_id', document.getElementsByClassName('barang_id')[document.getElementById('position-barang').value].value);
    formdata.append('cabng_id', document.getElementById('cabang_id').value);
    formdata.append('detail_other', JSON.stringify(detail_other));
    formdata.append('detail_selected', JSON.stringify(detail_selected));
    formdata.append('penjualan_id', document.getElementById('penjualan_id').value);
    var ajax = new XMLHttpRequest();
    ajax.addEventListener('load', responseTampilBarangMasukDetail, false);
    ajax.open('POST', '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/tampil-barang-masuk-detail.php');
    ajax.send(formdata);
  }

 function responseTampilBarangMasukDetail()
  { document.getElementsByClassName('loader')[0].style['display'] = 'none';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'none';
    $('#tabelkubarangmasukdetail').html(event.srcElement.response);
    document.getElementById('jlh-halaman-barang-masuk-detail').innerHTML = 'Jumlah Halaman : ' + document.getElementById('txtnhalamanbarangmasukdetail').value;
    document.getElementById('preview-halaman-barang-masuk-detail').innerHTML = document.getElementById('temp-preview-halaman-barang-masuk-detail').innerHTML;

    //Menampilkan popUpBarangMasukDetail auto select tab1
    showModal('popUpBarangMasukDetail');
    var tabs = document.getElementById('popUpBarangMasukDetail').querySelector('.nav-tabs').querySelectorAll('li');
    tabs[1].classList.remove('active');
    tabs[0].classList.add('active');
    var tabs = document.getElementById('popUpBarangMasukDetail').querySelector('.tab-content').querySelectorAll('.tab-pane');
    tabs[1].classList.remove('active');
    tabs[0].classList.add('active');

    setButtonSimpanBarangDitandai();
  }

 function nextPageBarangMasukDetail()
  { var hal = document.getElementById('txthalamanbarangmasukdetail').value;
    hal++;
    document.getElementById('txthalamanbarangmasukdetail').value = hal;
    tampilBarangMasukDetail();
  }

 function previousPageBarangMasukDetail()
  { var hal = document.getElementById('txthalamanbarangmasukdetail').value;
    hal--;
    document.getElementById('txthalamanbarangmasukdetail').value = hal;
    tampilBarangMasukDetail();
  }

 function goToPageBarangMasukDetail(value)
  { document.getElementById('txthalamanbarangmasukdetail').value = value;
    tampilBarangMasukDetail();
  }

 function refreshBarangMasukDetail()
  { document.getElementById('txtcaribarangmasukdetail').value = '';
    tampilBarangMasukDetail();
  }

 function addTandai(element)
  { fnomor(element);
    var list = document.getElementsByClassName(element.className);
    list = [].slice.call(list);
    var position = list.indexOf(element);

    //tarik data barang ditandai kedalam variabel array detail
    var barang_masuk_detail_id = document.getElementsByClassName('textarea_barang_masuk_detail-id')[position].value;
    var detail = [];
    try
     { detail = JSON.parse(document.getElementsByClassName('ditandai')[document.getElementById('position-barang').value].value);
     }
    catch(err) { }
    
    //hapus data barang ditandai yang sebelumnya sebelum diinput data yang baru
    detail = detail.filter(function (detail) { return detail.barang_masuk_detail_id * 1 !== barang_masuk_detail_id * 1 });

    //validasi agar jumlah barang yang ditandai tidak melebihi jumlah barang yang tersedia
    var jumlah = normal(element.value) * 1;
    var tersedia = normal(document.getElementsByClassName('textarea_barang_masuk_detail-tersedia')[position].value) * 1;
    if(jumlah > tersedia)
     { jumlah = tersedia;
       element.value = formatnomor2(jumlah.toString().replaceAll('.', ','));
     }

    //validasi agar jumlah barang yang ditandai tidak melebihi jumlah barang yang dijual
    var jumlah_lainnya = 0;
    for(var i=0; i<detail.length; i++)
     { jumlah_lainnya += detail[i].jumlah * 1;
     }
    var jumlah_dijual = normal(document.getElementsByClassName('jumlah')[document.getElementById('position-barang').value].innerHTML) * 1;
    if(jumlah_lainnya + jumlah > jumlah_dijual)
     { jumlah = jumlah_dijual - jumlah_lainnya;
       element.value = formatnomor2(jumlah.toString().replaceAll('.', ','));
     }

    //masukkan data barang yang ditandai apabila jumlah ditandai > 0
    var valueToPush = {};
    valueToPush.penjualan_detail_id = document.getElementsByClassName('detail_id')[document.getElementById('position-barang').value].value;
    valueToPush.barang_masuk_detail_id = barang_masuk_detail_id;
    valueToPush.jumlah = jumlah;
    valueToPush.barang_masuk_id = document.getElementsByClassName('textarea_barang_masuk_detail-barang_masuk_id')[position].value;
    valueToPush.tanggal_barang_masuk = document.getElementsByClassName('textarea_barang_masuk_detail-tanggal')[position].value;
    valueToPush.sumber_barang_masuk = document.getElementsByClassName('textarea_barang_masuk_detail-sumber')[position].value;
    valueToPush.nama_rak = document.getElementsByClassName('textarea_barang_masuk_detail-nama_rak')[position].value;
    valueToPush.dikirim = document.getElementsByClassName('textarea_barang_masuk_detail-dikirim')[position].value * 1;
    valueToPush.add_kirim = null;
    detail.push(valueToPush);

    //hitung total barang yang ditandai
    var total = 0;
    for(var i=0; i<detail.length; i++)
     { total += detail[i].jumlah * 1;
     }

    document.querySelectorAll('.div_ditandai')[document.getElementById('position-barang').value].querySelector('div').innerHTML = formatnomor2(total.toString().replaceAll('.', ','));
    document.getElementsByClassName('ditandai')[document.getElementById('position-barang').value].value = JSON.stringify(detail);
    hitungTotalDikirim();

  }

 //Barang Masuk Detail--------------------------------------------------------------------------------------------------
 
 //Penjualan Detail Ditandai--------------------------------------------------------------------------------------------

 var telah_ditandai = [];

 function tampilPenjualanDetailDitandai()
  { var formdata = new FormData();
    formdata.append('username', '<?= $_POST['username'] ?>');
    formdata.append('users_level_id', '<?= $_POST['users_level_id'] ?>');
    formdata.append('cabang_id', '<?= $_POST['cabang_id'] ?>');
    formdata.append('token', '<?= $_POST['token'] ?>');
    formdata.append('maxRecord', maxRecord);
    formdata.append('halaman', document.getElementById('txthalamanpenjualandetailditandai').value);
    formdata.append('cabng_id', document.getElementById('cabang_id').value);
    formdata.append('cari', document.getElementById('txtcaripenjualandetailditandai').value);
    formdata.append('penjualan_id', document.getElementById('penjualan_id').value);
    formdata.append('telah_ditandai', JSON.stringify(telah_ditandai));
    var ajax = new XMLHttpRequest();
    ajax.addEventListener('load', responseTampilPenjualanDetailDitandai, false);
    ajax.open('POST', '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/tampil-penjualan-detail-ditandai.php');
    ajax.send(formdata);
  }

 function responseTampilPenjualanDetailDitandai()
  { document.getElementsByClassName('loader')[0].style['display'] = 'none';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'none';
    $('#tabelkupenjualandetailditandai').html(event.srcElement.response);
    document.getElementById('jlh-halaman-penjualan-detail-ditandai').innerHTML = 'Jumlah Halaman : ' + document.getElementById('txtnhalamanpenjualandetailditandai').value;
    document.getElementById('preview-halaman-penjualan-detail-ditandai').innerHTML = document.getElementById('temp-preview-halaman-penjualan-detail-ditandai').innerHTML;
    setButtonSimpanBarangDitandai();
  }

 function nextPagePenjualanDetailDitandai()
  { var hal = document.getElementById('txthalamanpenjualandetailditandai').value;
    hal++;
    document.getElementById('txthalamanpenjualandetailditandai').value = hal;
    tampilPenjualanDetailDitandai();
  }

 function previousPagePenjualanDetailDitandai()
  { var hal = document.getElementById('txthalamanpenjualandetailditandai').value;
    hal--;
    document.getElementById('txthalamanpenjualandetailditandai').value = hal;
    tampilPenjualanDetailDitandai();
  }

 function goToPagePenjualanDetailDitandai(value)
  { document.getElementById('txthalamanpenjualandetailditandai').value = value;
    tampilPenjualanDetailDitandai();
  }

 function refreshPenjualanDetailDitandai()
  { document.getElementById('txtcaripenjualandetailditandai').value = '';
    tampilPenjualanDetailDitandai();
  }

 function changeTelahDitandai(element)
  { fnomor(element);
    var list = document.getElementsByClassName(element.className);
    list = [].slice.call(list);
    var position = list.indexOf(element);

    var penjualan_detail_ditandai_id = document.getElementsByClassName('textarea_penjualan_detail_ditandai-id')[position].value * 1;
    var penjualan_detail_id = document.getElementsByClassName('textarea_penjualan_detail_ditandai-penjualan_detail_id')[position].value * 1;
    var penjualan_id = document.getElementsByClassName('textarea_penjualan_detail_ditandai-penjualan_id')[position].value * 1;
    var jumlah_sebelumnya = normal(document.getElementsByClassName('textarea_penjualan_detail_ditandai-jumlah')[position].value) * 1;
    var jumlah = normal(element.value) * 1;

    //hapus data pada array telah_ditandai berdasarkan penjualan_detail_ditandai_id, sebelum data diinput kembali (jika jumlah yg baru diinput berbeda dengan nilai sebelumnya)
    telah_ditandai = telah_ditandai.filter(function (telah_ditandai) { return telah_ditandai.id !== penjualan_detail_ditandai_id });

    //jika jumlah yang baru diinput berbeda dengan jumlah sebelumnya, maka input jumlah ke dalam array telah_ditandai
    if(jumlah !== jumlah_sebelumnya)
     { var valueToPush = {};
       valueToPush.id = penjualan_detail_ditandai_id;
       valueToPush.penjualan_detail_id = penjualan_detail_id;
       valueToPush.penjualan_id = penjualan_id;
       valueToPush.jumlah = jumlah;
       telah_ditandai.push(valueToPush);
     }

    setButtonSimpanBarangDitandai();

  }

 function setButtonSimpanBarangDitandai()
  { var tabs = document.querySelectorAll('#popUpBarangMasukDetail .tab-buttons button');
    if(tabs[1].className.search('active') >= 0 && telah_ditandai.length > 0)
     { document.querySelector('#popUpBarangMasukDetail .modal-footer .btn-primary').style['display'] = 'inline-block';
     }
    else
     { document.querySelector('#popUpBarangMasukDetail .modal-footer .btn-primary').style['display'] = 'none';
     }
  }

 function simpanPenjualanDetailDitandai()
  { document.getElementsByClassName('loader')[0].style['display'] = 'block';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'block';
    var formdata = new FormData();
    formdata.append('username', '<?= $_POST['username'] ?>');
    formdata.append('users_level_id', '<?= $_POST['users_level_id'] ?>');
    formdata.append('cabang_id', '<?= $_POST['cabang_id'] ?>');
    formdata.append('token', '<?= $_POST['token'] ?>');
    formdata.append('maxRecord', maxRecord);
    formdata.append('telah_ditandai', JSON.stringify(telah_ditandai));
    var ajax = new XMLHttpRequest();
    ajax.addEventListener('load', responseSimpanPenjualanDetailDitandai, false);
    ajax.open('POST', '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/simpan-penjualan-detail-ditandai.php');
    ajax.send(formdata);
  }

 function responseSimpanPenjualanDetailDitandai()
  { telah_ditandai = [];
    tampilPenjualanDetailDitandai();
  }

 //Penjualan Detail Ditandai--------------------------------------------------------------------------------------------

 function kirimBarang(element)
  { var list = document.getElementsByClassName(element.className);
    list = [].slice.call(list);
    var position = list.indexOf(element);
    document.getElementById('position-barang').value = position;
    document.getElementsByClassName('loader')[0].style['display'] = 'block';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'block';
    tampilAddKirim();
  }

 function tampilAddKirim()
  { var formdata = new FormData();
    formdata.append('username', '<?= $_POST['username'] ?>');
    formdata.append('users_level_id', '<?= $_POST['users_level_id'] ?>');
    formdata.append('cabang_id', '<?= $_POST['cabang_id'] ?>');
    formdata.append('token', '<?= $_POST['token'] ?>');
    formdata.append('telah_ditandai', document.getElementsByClassName('ditandai')[document.getElementById('position-barang').value].value);
    formdata.append('halaman', document.getElementById('txthalamanaddkirim').value);
    formdata.append('cari', document.getElementById('txtcariaddkirim').value);
    formdata.append('maxRecord', maxRecord);
    var ajax = new XMLHttpRequest();
    ajax.addEventListener('load', responseTampilAddKirim, false);
    ajax.open('POST', '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/tampil-add-kirim.php');
    ajax.send(formdata);
  }

 function responseTampilAddKirim()
  { document.getElementsByClassName('loader')[0].style['display'] = 'none';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'none';
    $('#tabelkuaddkirim').html(event.srcElement.response);
    showModal('popUpAddKirim');
    document.getElementById('preview-halaman-add-kirim').innerHTML = document.getElementById('temp-preview-halaman-add-kirim').innerHTML;
    $('#preview-halaman-add-kirim').select2({ placeholder : '', allowClear : false });
  }

 function nextPageAddKirim()
  { var hal = document.getElementById('txthalamanaddkirim').value;
    hal++;
    document.getElementById('txthalamanaddkirim').value = hal;
    tampilAddKirim();
  }

 function previousPageAddKirim()
  { var hal = document.getElementById('txthalamanaddkirim').value;
    hal--;
    document.getElementById('txthalamanaddkirim').value = hal;
    tampilAddKirim();
  }

 function goToPageAddKirim(value)
  { document.getElementById('txthalamanaddkirim').value = value;
    tampilAddKirim();
  }

 function refreshAddKirim()
  { document.getElementById('txtcariaddkirim').value = '';
    tampilAddKirim();
  }

 function addKirim(element)
  { fnomor(element);
    var list = document.getElementsByClassName(element.className);
    list = [].slice.call(list);
    var position = list.indexOf(element);

    var penjualan_detail_id = document.getElementsByClassName('textarea_add_kirim-penjualan_detail_id')[position].value;
    var barang_masuk_detail_id = document.getElementsByClassName('textarea_add_kirim-barang_masuk_detail_id')[position].value;
    var jumlah = normal(document.getElementsByClassName('textarea_add_kirim-jumlah')[position].value) * 1;
    var telah_dikirim = normal(document.getElementsByClassName('textarea_add_kirim-dikirim')[position].value) * 1;
    var kirim = normal(element.value) * 1;

    //tarik data ditandai ke dalam variabel ditandai
    var ditandai = [];
    try
     { ditandai = JSON.parse(document.getElementsByClassName('ditandai')[document.getElementById('position-barang').value].value);
     }
    catch(err) { }

    //cari index variabel ditandai berdasarkan barang_masuk_detail_id
    var index = ditandai.findIndex(function(item) {
     return (item.penjualan_detail_id.toString() === penjualan_detail_id.toString() && item.barang_masuk_detail_id.toString() === barang_masuk_detail_id.toString());
    });

    //cek agar jumlah kirim tidak melebihi jumlah yang tersedia
    if(kirim > jumlah - telah_dikirim)
     { kirim = jumlah - telah_dikirim;
       element.value = formatnomor2(kirim.toString().replaceAll('.', ','));
     }

    //ubah add_kirim sesuai dengan jumlah kirim yang di ketik
    ditandai[index].add_kirim = kirim;

    document.getElementsByClassName('ditandai')[document.getElementById('position-barang').value].value = JSON.stringify(ditandai);
    hitungTotalDikirim();
  }

 function hitungTotalDikirim()
  { var penjualan_detail_id = document.getElementsByClassName('detail_id')[document.getElementById('position-barang').value].value;
    var total = 0;
    //tarik data ditandai kedalam variabel
    var ditandai = [];
    try
     { ditandai = JSON.parse(document.getElementsByClassName('ditandai')[document.getElementById('position-barang').value].value);
     }
    catch(err) { }
    //filter data ditandai berdasarkan penjualan_detail_id
    var temp = ditandai.filter(function(item) {
     return (item.penjualan_detail_id.toString() === penjualan_detail_id.toString());
    });
    //hitung total barang yang akan dikirim
    for(i=0; i<temp.length; i++)
     { total += temp[i].add_kirim * 1;
     }
    document.querySelectorAll('.div_kirim-barang')[document.getElementById('position-barang').value].querySelector('div').innerHTML = formatnomor2(total.toString().replaceAll('.', ','));
  }

 function cetak(element)
  { var list = document.getElementsByClassName(element.className);
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
    ajax.open('POST', '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/cetak.php');
    ajax.send(formdata);
  }

 function responseCetak()
  { document.getElementsByClassName('loader')[0].style['display'] = 'none';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'none';
    document.getElementById('link-cetak').href = event.srcElement.response;
    document.getElementById('link-cetak').click();
  }

</script>