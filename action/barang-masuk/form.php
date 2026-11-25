<?php
 include("../bjksadkhrej121lkjkjk.php");
 $list_gudang = "<option></option>";
 $query = "select * from gudang order by nama asc";
 if(isset($_POST['cabang_id']) && $_POST['cabang_id'] !== "")
  { $query = "select * from gudang where cabang_id = '".intval($_POST['cabang_id'])."' order by nama asc";
  }
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $list_gudang .= "<option value='".$row['id']."'>".$row['nama']."</option>";
  }
?>

<style>
 .slider
  { position : relative;
    overflow : hidden;
    border-radius : 10px;
    touch-action : pan-y;
  }
 .slide
  { flex-shrink : 0;
    color : white;
    font-size : 1.5rem;
    display : flex;
    /*align-items : center;
    justify-content : center;
    height : 120px;*/
    cursor : grab;
  }
 .kontainer-slide
  { position : relative;
  }
 .kontainer-slide:hover .nav
  { opacity : 1;
  }
 .kontainer-slide .nav
  { position : absolute;
    top : 50%;
    transform : translateY(-50%);
    font-size : 2rem;
    background : rgba(0,0,0,0.4);
    color : white;
    border : none;
    padding : 5px;
    cursor : pointer;
    z-index : 10;
    opacity : 0;
    transition : opacity ease 0.5s;
  }
 .title-slide
  { position : absolute;
    bottom : 0px;
    background : rgba(0,0,0,0.4);
    padding : 2px 10px;
    width : 100%;
    color : white;
    cursor : pointer;
    user-select : none;
    display : grid;
    grid-template-columns : 1fr;
    font-weight : normal;
  }
 .prev
  { left : 10px;
  }
 .next
  { right : 10px;
  }

 .box-foto
  { position : relative;
    display : inline-block;
    border : 1px solid silver;
  }
 .box-foto img
  { width : 100%;
  }
 .box-foto  .box-button
  { position : absolute;
    bottom : 0px;
    right : 0px;
    opacity : 0;
    transition : opacity 0.5s;
  }
 .box-foto:hover .box-button
  { opacity : 1;
  }
 .image-editor
  { text-align : center;
  }
 .cropit-preview, .cropit-image-input
  { left : 0px;
    right : 0px;
    margin-left : auto;
    margin-right : auto;
  }
 .cropit-preview
  { background-color: #f8f8f8;
    background-size : cover;
    border : 1px solid #ccc;
    border-radius : 3px;
    margin-top : 7px;
    width : 250px;
    height : 250px;
  }
 .cropit-preview-image-container
  { cursor: move;
  }
 #popUpBarang .modal-dialog
  { width : 100%;
    max-width : 900px;
    line-height : 0.88 !important;
  }
 .kontainer
  { display : grid;
    grid-template-columns : 1fr;
    gap : 10px;
    margin-top : 10px;
  }
 .kontainer .row
  { margin-left : 0px;
    margin-right : 0px;
    padding-top : 5px;
    padding-bottom : 5px;
  }
 .kontainer .row:nth-child(odd)
  { background-color : #e9e9e9;
  }
 .kontainer .row:nth-child(even)
  { background-color : #f9f9f9;
  }
 .kontainer .produk
  { border : 1px solid silver;
    padding : 10px;
  }
 .kontainer .produk:hover
  { background-color : #ecffeb;
    border-radius : 5px;
  }
 .kontainer .produk .detail
  { display : grid;
    grid-template-columns : 1fr;
    gap : 5px;
  }
 @media only screen and (min-width : 800px)
  { .kontainer
     { grid-template-columns : 1fr 1fr;
     }
  }
 @media only screen and (min-width: 450px) and (max-width: 499px)
  { .kontainer .produk .detail
     { grid-template-columns : 1fr 1fr;
     }
  }
 @media only screen and (min-width: 500px) and (max-width: 799px)
  { .kontainer .produk .detail
     { grid-template-columns : 3fr 4fr;
     }
  }
 @media only screen and (min-width: 700px)
  { .kontainer .produk .detail
     { grid-template-columns : 1fr 1fr;
     }
  }
</style>

<section class='content'>
 <input type='hidden' id='edit-id'>
 <input type='hidden' id='edit-detail'>
 <input type='hidden' id='position-barang'>
 <span id='filterKu' style='display:none;'>[]</span>
 <div class='box box-default'>
  <div class='box-header with-border'>
   <h3 class='box-title'>Barang Masuk</h3>
   <div class='box-tools pull-right'>
    <button type='button' class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-minus'></i></button>
   </div>
  </div>
  <div class='box-body'>
   <div class='row'>
    <div class='col-md-12'>
     <div class='row'>
      <div class='col-md-12'>
       <div style='border:1px solid silver; padding:15px;'>
        <div style='display:inline-block; font-weight:bold; position:absolute; top:-10px; background:white;'>Barang Masuk<span id='nomor_pembelian'></span></div>
        <div class='row'>
         <div class='col-md-6'>
          <div class='row'>
           <div class='col-md-4' style='padding-top:7px;'>
            <label>Gudang *</label>
           </div>
           <div class='col-md-8'>
            <select class='form-control fieldku select2' style='width:100%;' onchange='tampilListView();' id='gudang_id'>
             <?= $list_gudang ?>
            </select>
            <div style='color:red' class='error' id='error-gudang_id'></div>
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
            <div style='color:red' class='error' id='error-tanggal'></div>
           </div>
          </div>
         </div>
         <div class='col-md-6'>
          <div class='row'>
           <div class='col-md-4' style='padding-top:7px;'>
            <label>Sumber Masuk Barang *</label>
           </div>
           <div class='col-md-8'>
            <select class='form-control fieldku select2' style='width:100%;' onchange='clearBarang();' id='sumber'>
             <option></option>
             <option value='Pembelian'>Pembelian</option>
             <!--<option value='Retur Penjualan'>Retur Penjualan</option>
             <option value='Mutasi'>Mutasi</option>-->
            </select>
            <div style='color:red' class='error' id='error-sumber'></div>
           </div>
          </div>
         </div>
        </div>
       </div>
      </div>
     </div>
     <div class='row' style='margin-top:15px;'>
      <div class='col-md-12'>
       <div style='border:1px solid silver; padding:15px;'>
        <div style='display:inline-block; font-weight:bold; position:absolute; top:-10px; background:white;'>Detail Barang</div>
        <div class='row'>
         <div class='col-md-12'>
          <button type='button' class='btn btn-success' onclick='addBarang();'><i class='fa fa-plus'></i> Add</button>
          <div class='error' style='color:red;' id='error-detail'></div>
          <div class='responsiveku'>
           <div id='div-item'></div>
          </div>
         </div>
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
     <h3 class='box-title'>List Barang Masuk</h3>
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

<div class='modal' id='popUpBarang'>
 <div class='modal-dialog'>
  <div class='modal-content'>
   <div class='modal-header'>
    <button type='button' class='close' onclick="hideModal('popUpBarang');">&times</button>
    <h4 class='modal-title'>Pilih Barang</h4>
   </div>
   <div class='modal-body'>
    <div class='row'>
     <div class='col-md-12'>
      <input type='button' class='btn btn-default' value='&laquo' style='float:left; height:35px;' onclick='previousPageBarang()'>
      <div style='display:inline-block; max-width:80px; float:left;'>
       <select class='form-control halaman' style='text-align:center; width:100%;' onchange='goToPageBarang(this.value);' id='preview-halaman-barang'>
        <option value='1' selected>1</option>
       </select>
      </div>
      <input type='button' class='btn btn-default' value='&raquo' style='float:left; height:35px;' onclick='nextPageBarang()'>
      <button type='button' class='btn btn-default' style='float:left; height:35px;' onclick='refreshBarang();'><i class='fa fa-refresh'></i></button>
      <input type='text' class='form-control' autocomplete='new-password' placeholder='Cari..' style='max-width:250px; height:35px; float:left;' onkeyup='tampilBarang();' onchange='tampilBarang();' id='txtcaribarang'>
      <span style='float:right; padding-top:10px;' id='jlh-halaman-barang'>Jumlah Halaman :</span>
     </div>
    </div>
    <div id='tabelkubarang' class='responsiveku'><input type='hidden' id='txthalamanbarang' value='1'></div>
   </div>
   <div class='modal-footer'>
    <button type='button' class='btn btn-default' onclick="hideModal('popUpBarang');"><i class='fa fa-close'></i> Batal</button>
   </div>
  </div>
 </div>
</div>

<div class='modal' id='popUpPembelianDetail'>
 <div class='modal-dialog'>
  <div class='modal-content'>
   <div class='modal-header'>
    <button type='button' class='close' onclick="hideModal('popUpPembelianDetail');">&times</button>
    <h4 class='modal-title'>Pilih Barang</h4>
   </div>
   <div class='modal-body'>
    <div class='row'>
     <div class='col-md-12'>
      <input type='button' class='btn btn-default' value='&laquo' style='float:left; height:35px;' onclick='previousPagePembelianDetail()'>
      <div style='display:inline-block; max-width:80px; float:left;'>
       <select class='form-control halaman' style='text-align:center; width:100%;' onchange='goToPagePembelianDetail(this.value);' id='preview-halaman-pembelian-detail'>
        <option value='1' selected>1</option>
       </select>
      </div>
      <input type='button' class='btn btn-default' value='&raquo' style='float:left; height:35px;' onclick='nextPagePembelianDetail()'>
      <button type='button' class='btn btn-default' style='float:left; height:35px;' onclick='refreshPembelianDetail();'><i class='fa fa-refresh'></i></button>
      <input type='text' class='form-control' autocomplete='new-password' placeholder='Cari..' style='max-width:250px; height:35px; float:left;' onkeyup='tampilPembelianDetail();' onchange='tampilPembelianDetail();' id='txtcaripembeliandetail'>
      <span style='float:right; padding-top:10px;' id='jlh-halaman-pembelian-detail'>Jumlah Halaman :</span>
     </div>
    </div>
    <div id='tabelkupembeliandetail' class='responsiveku'><input type='hidden' id='txthalamanpembeliandetail' value='1'></div>
   </div>
   <div class='modal-footer'>
    <button type='button' class='btn btn-default' onclick="hideModal('popUpPembelianDetail');"><i class='fa fa-close'></i> Tutup</button>
   </div>
  </div>
 </div>
</div>

<div class='modal' style='padding-bottom:50px; background-color:rgba(0, 0, 0, 0.9);' id='popUpViewFoto'>
 <div class='modal-dialog' style='max-width:520px;'>
  <div style='text-align:right;'>
   <i class='fa fa-close' style='font-size:30px; margin-bottom:5px;' onclick="hideModal('popUpViewFoto');"></i>
  </div>
  <div class='modal-content' style='width:calc(100% - 20px); text-align:center;'>
   <div>
    <div id='slide_banner'></div>
   </div>
  </div>
 </div>
</div>

<div id='div-result' style='display:none'></div>

<script>

 var Nama_Tabel = 'barang_masuk';
 var FieldTidakBolehRangkap = [];
 var FieldRequired = [
  {field : 'gudang_id', label : 'Gudang'},
  {field : 'tanggal', label : 'Tanggal'},
 ];
 var maxRecord = 10;

 $('#form-input').html(event.srcElement.response);
 $('.tanggal').datepicker({ autoclose : true, todayHighlight : true, format : 'dd-mm-yyyy' });
 $('.select2').select2({ placeholder : '', allowClear : true });
 tampilListView();
 clearBarang();

 function validasi()
  { var detail = [];
    var a = document.getElementsByClassName('rak');
    for(var i=0; i<a.length; i++)
     { try
        { var new_array = JSON.parse(document.getElementsByClassName('barang_masuk_detail')[i].value);
          new_array.forEach(item => {
           item.rak_id = a[i].value;
          });
          detail = detail.concat(new_array);
        }
       catch(err) {}
     }
    var data = {};
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
    formdata.append('halaman', document.getElementById('txthalaman').value);
    formdata.append('filter', document.getElementById('filterKu').innerHTML);
    formdata.append('gudang_id', document.getElementById('gudang_id').value);
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
    document.getElementById('edit-detail').value = '';
    var a = document.getElementsByClassName('fieldku');
    for(var loop=0; loop<a.length; loop++)
     { if(a[loop].id !== 'gudang_id')
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
    document.getElementById('edit-detail').value = document.getElementsByClassName('textarea_edit-detail')[position].value;
    var a = document.getElementsByClassName('fieldku');
    for(var loop=0; loop<a.length; loop++)
     { document.getElementById(a[loop].id).value = document.getElementsByClassName('textarea_edit-' + a[loop].id)[position].value;
       try
        { $('#' + document.getElementById(a[loop].id).id).trigger('change');
        }
       catch(er) { }
     }
    clearBarang();
    var a = document.getElementsByClassName('div-detail')[position].querySelectorAll('.div-detail-barang_id');
    for(var i=0; i<a.length; i++)
     { var barang_id = document.getElementsByClassName('div-detail')[position].querySelectorAll('.div-detail-barang_id')[i].value;
       var kode = document.getElementsByClassName('div-detail')[position].querySelectorAll('.div-detail-kode')[i].value;
       var nama = document.getElementsByClassName('div-detail')[position].querySelectorAll('.div-detail-nama')[i].value;
       var merek = document.getElementsByClassName('div-detail')[position].querySelectorAll('.div-detail-merek')[i].value;
       var model = document.getElementsByClassName('div-detail')[position].querySelectorAll('.div-detail-model')[i].value;
       var tipe = document.getElementsByClassName('div-detail')[position].querySelectorAll('.div-detail-tipe')[i].value;
       var jenis = document.getElementsByClassName('div-detail')[position].querySelectorAll('.div-detail-jenis')[i].value;
       var kapasitas_pk = document.getElementsByClassName('div-detail')[position].querySelectorAll('.div-detail-kapasitas_pk')[i].value;
       var btuh = document.getElementsByClassName('div-detail')[position].querySelectorAll('.div-detail-btuh')[i].value;
       var ukuran = document.getElementsByClassName('div-detail')[position].querySelectorAll('.div-detail-ukuran')[i].value;
       var satuan = document.getElementsByClassName('div-detail')[position].querySelectorAll('.div-detail-satuan')[i].value;
       var rak = document.getElementsByClassName('div-detail')[position].querySelectorAll('.div-detail-rak')[i].innerHTML;
       var jumlah = document.getElementsByClassName('div-detail')[position].querySelectorAll('.div-detail-jumlah')[i].value;
       var barang_masuk_detail = document.getElementsByClassName('div-detail')[position].querySelectorAll('.div-detail-barang_masuk_detail')[i].value;
       var barang_nama = kode + ' - ' + nama;
       if(merek !== '')
        { barang_nama += ' ' + merek;
        }
       if(model !== '')
        { barang_nama += ' ' + model;
        }
       if(tipe !== '')
        { barang_nama += ' ' + tipe;
        }
       if(jenis !== '')
        { barang_nama += ' ' + jenis;
        }
       if(kapasitas_pk !== '')
        { barang_nama += ' ' + kapasitas_pk + ' PK';
        }
       if(btuh !== '')
        { barang_nama += ' (' + btuh + ' BTU/h)';
        }
       if(ukuran !== '')
        { barang_nama += ' ' + ukuran;
          if(satuan !== '')
           { barang_nama += ' ' + satuan;
           }
        }
       addDetail(barang_id, barang_nama, rak, jumlah, barang_masuk_detail)
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

 //Barang-------------------------------------------------------------------------------------------------------------------

 function clearBarang()
  { document.getElementById('div-item').innerHTML = `
     <table class='table table-bordered' style='margin-top:5px;' id='table-detail'>
      <thead>
       <tr>
        <th style='text-align:center; width:50px; min-width:50px; max-width:50px;'>No.</th>
        <th style='min-width:100px; max-width:200px;'>Nama Barang</th>
        <th style='min-width:100px; max-width:200px;'>Nama Rak</th>
        <th style='text-align:center; width:170px; min-width:170px; max-width:170px;'>Jumlah</th>
        <th style='text-align:center; width:60px; min-width:60px; max-width:60px;'>Del</th>
       </tr>
       <tbody></tbody>
      </thead>
     </table>
    `;
  }

 function addBarang()
  { document.getElementById('error-sumber').innerHTML = '';
    document.getElementById('error-gudang_id').innerHTML = '';
    var error = 0;
    if(document.getElementById('gudang_id').value == '')
     { error++;
       document.getElementById('error-gudang_id').innerHTML = '<b>Gudang</b> wajib diisi';
     }
    if(document.getElementById('sumber').value == '')
     { error++;
       document.getElementById('error-sumber').innerHTML = '<b>Sumber Masuk Barang</b> wajib diisi';
     }
    if(error == 0)
     { document.getElementsByClassName('loader')[0].style['display'] = 'block';
       document.getElementsByClassName('loader-block')[0].style['display'] = 'block';
       if(document.getElementById('sumber').value == 'Pembelian')
        { tampilBarang();
        }
     }
  }

 function tampilBarang()
  { var formdata = new FormData();
    formdata.append('username', '<?= $_POST['username'] ?>');
    formdata.append('users_level_id', '<?= $_POST['users_level_id'] ?>');
    formdata.append('cabang_id', '<?= $_POST['cabang_id'] ?>');
    formdata.append('token', '<?= $_POST['token'] ?>');
    formdata.append('Nama_Tabel', 'barang');
    formdata.append('maxRecord', maxRecord);
    formdata.append('halaman', document.getElementById('txthalamanbarang').value);
    formdata.append('cari', document.getElementById('txtcaribarang').value);
    var ajax = new XMLHttpRequest();
    ajax.addEventListener('load', responseTampilBarang, false);
    ajax.open('POST', '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/tampil-barang.php');
    ajax.send(formdata);
  }

 function responseTampilBarang()
  { document.getElementsByClassName('loader')[0].style['display'] = 'none';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'none';
    $('#tabelkubarang').html(event.srcElement.response);
    document.getElementById('preview-halaman-barang').innerHTML = document.getElementById('temp-preview-halaman-barang').innerHTML;
    document.getElementById('jlh-halaman-barang').innerHTML = 'Jumlah Halaman : ' + formatnomor(document.getElementById('txtnhalamanbarang').value);
    showModal('popUpBarang');
  }

 function nextPageBarang()
  { var hal = document.getElementById('txthalamanbarang').value;
    hal++;
    document.getElementById('txthalamanbarang').value = hal;
    tampilBarang();
  }

 function previousPageBarang()
  { var hal = document.getElementById('txthalamanbarang').value;
    hal--;
    document.getElementById('txthalamanbarang').value = hal;
    tampilBarang();
  }

 function goToPageBarang(value)
  { document.getElementById('txthalamanbarang').value = value;
    tampilBarang();
  }

 function refreshBarang()
  { document.getElementById('txtcaribarang').value = '';
    tampilBarang();
  }

 function lihatGambar(element)
  { showModal('popUpViewFoto');
    var list = document.getElementsByClassName(element.className);
    list = [].slice.call(list);
    var position = list.indexOf(element);
    var a = document.getElementsByClassName('list_foto')[position].querySelectorAll('textarea');
    slide_banner = [];
    for(var i=0; i<a.length; i++)
     { var new_element = document.createElement('div');
       new_element.innerHTML = `<div class='item-slide'>
                                 <img src='` + a[i].value + `' draggable='false' style='user-select:none; width:100%;'>
                                </div>`;
       slide_banner.push(new_element.innerHTML);
     }
    resize();
  }

 function pilihBarang(element)
  { var list = document.getElementsByClassName(element.className);
    list = [].slice.call(list);
    var position = list.indexOf(element);
    var barang_id = document.getElementsByClassName('textarea_barang-id')[position].value;
    var nama_produk = document.getElementsByClassName('textarea_barang-kode')[position].value + ' - ' + document.getElementsByClassName('textarea_barang-nama')[position].value;
    if(document.getElementsByClassName('textarea_barang-merek')[position].value !== '')
     { nama_produk += ' ' + document.getElementsByClassName('textarea_barang-merek')[position].value
     }
    if(document.getElementsByClassName('textarea_barang-model')[position].value !== '')
     { nama_produk += ' ' + document.getElementsByClassName('textarea_barang-model')[position].value
     }
    if(document.getElementsByClassName('textarea_barang-tipe')[position].value !== '')
     { nama_produk += ' ' + document.getElementsByClassName('textarea_barang-tipe')[position].value;
     }
    if(document.getElementsByClassName('textarea_barang-jenis')[position].value !== '')
     { nama_produk += ' ' + document.getElementsByClassName('textarea_barang-jenis')[position].value;
     }
    if(document.getElementsByClassName('textarea_barang-kapasitas_pk')[position].value !== '')
     { nama_produk += ' ' + document.getElementsByClassName('textarea_barang-kapasitas_pk')[position].value + ' PK';
     }
    if(document.getElementsByClassName('textarea_barang-kapasitas_pk')[position].value !== '')
     { nama_produk += ' (' + document.getElementsByClassName('textarea_barang-btuh')[position].value + 'BTU/H)';
     }
    if(document.getElementsByClassName('textarea_barang-ukuran')[position].value !== '')
     { nama_produk += ' ' + document.getElementsByClassName('textarea_barang-ukuran')[position].value;
       if(document.getElementsByClassName('textarea_barang-satuan')[position].value !== '')
        { nama_produk += ' ' + document.getElementsByClassName('textarea_barang-satuan')[position].value;
        }
     }
    addDetail(barang_id, nama_produk, '', '', '', '', '[]');
  }

 function addDetail(barang_id, barang_nama, rak, jumlah, barang_masuk_detail)
  { var table = document.getElementById('table-detail');
    var row = table.insertRow(table.rows.length);
    row.className = 'row-detail';
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);
    var cell5 = row.insertCell(4);
    cell1.style['text-align'] = 'right';
    cell5.style['text-align'] = 'center';
    cell2.innerHTML = "<input type='hidden' class='barang_id' value='" + barang_id + "'><span class='barang_nama'>" + barang_nama + "</span>";
    cell3.innerHTML = "<select class='form-control rak' style='width:100%;' onchange='validasiRak(this);'><option></option>" + rak + "</select>";
    cell4.innerHTML = "<div style='min-height:34px; border:1px solid silver; background:#eeeeee;' class='add-jumlah' onclick='addJumlah(this);'><div style='padding:6px 10px 6px 10px; text-align:right;'>" + jumlah + "</div></div><textarea class='barang_masuk_detail' style='display:none;'>" + barang_masuk_detail + "</textarea>";
    cell5.innerHTML = "<button type='button' class='btn btn-danger btn-drop-detail' onclick='dropDetail(this);'><i class='fa fa-trash'></i></button>";
    $('.rak').select2({
     minimumInputLength : 1,
     placeholder : '',
     allowClear : true,
     ajax : {
      dataType : 'json',
      url : '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/get-rak.php',
      delay : 800,
      data : function(params) {
       return { search: params.term, username: '<?= $_POST['username'] ?>', users_level_id: '<?= $_POST['users_level_id'] ?>', cabang_id: '<?= $_POST['cabang_id'] ?>', token: '<?= $_POST['token'] ?>', gudang_id: document.getElementById('gudang_id').value }
      },
      processResults: function (data, page) {
       return { results: data };
      },
     },
    });
    setNomorUrut();
    hideModal('popUpBarang');
  }

 function setNomorUrut()
  { var a = document.querySelectorAll('.row-detail');
    for(var i=0; i<a.length; i++)
     { a[i].querySelector('td').innerHTML = (i + 1);
     }
  }

 function dropDetail(element)
  { var list = document.getElementsByClassName(element.className);
    list = [].slice.call(list);
    var position = list.indexOf(element);
    var elem = document.getElementsByClassName('row-detail')[position];
    elem.parentNode.removeChild(elem);
    setNomorUrut();
  }

 function validasiRak(element)
  { if(element.value !== '')
     { var list = document.getElementsByClassName(element.className);
       list = [].slice.call(list);
       var position = list.indexOf(element);
       var data = [];
       var a = document.getElementsByClassName('barang_id');
       for(var i=0; i<a.length; i++)
        { if(i !== position && document.getElementsByClassName('barang_id')[i].value == document.getElementsByClassName('barang_id')[position].value && document.getElementsByClassName('rak')[i].value == document.getElementsByClassName('rak')[position].value)
           { alert('Rak ini sudah digunakan untuk jenis Barang yang sama!');
             document.getElementsByClassName('rak')[position].value = '';
             $('.rak').trigger('change');
           }
        }
     }
  }

 //Barang-------------------------------------------------------------------------------------------------------------------

 //Pembelian Detail---------------------------------------------------------------------------------------------------------

 function addJumlah(element)
  { var list = document.getElementsByClassName(element.className);
    list = [].slice.call(list);
    var position = list.indexOf(element);
    document.querySelector('#popUpPembelianDetail .modal-header .modal-title').innerHTML = document.getElementsByClassName('barang_nama')[position].innerHTML + '<br><small>' + document.getElementsByClassName('add-jumlah')[position].querySelector('div').innerHTML + '</small>';
    document.getElementById('position-barang').value = position;
    document.getElementsByClassName('loader')[0].style['display'] = 'block';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'block';
    tampilPembelianDetail();
  }

 function tampilPembelianDetail()
  { var detail_other = [];
    var detail_selected = [];
    var a = document.getElementsByClassName('barang_id');
    for(var i=0; i<a.length; i++)
     { if(a[i].value == document.getElementsByClassName('barang_id')[document.getElementById('position-barang').value].value)
        { try
           { if(i == document.getElementById('position-barang').value)
              { detail_selected = detail_selected.concat(JSON.parse(document.getElementsByClassName('barang_masuk_detail')[i].value));
              }
             else
              { detail_other = detail_other.concat(JSON.parse(document.getElementsByClassName('barang_masuk_detail')[i].value));
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
    formdata.append('maxRecord', 10);
    formdata.append('gudang_id', document.getElementById('gudang_id').value);
    formdata.append('halaman', document.getElementById('txthalamanpembeliandetail').value);
    formdata.append('cari', document.getElementById('txtcaripembeliandetail').value);
    formdata.append('id', document.getElementById('edit-id').value);
    formdata.append('gudang_id', document.getElementById('gudang_id').value);
    formdata.append('barang_id', document.getElementsByClassName('barang_id')[document.getElementById('position-barang').value].value);
    formdata.append('detail_other', JSON.stringify(detail_other));
    formdata.append('detail_selected', JSON.stringify(detail_selected));
    formdata.append('detail_saved', document.getElementById('edit-detail').value);
    var ajax = new XMLHttpRequest();
    ajax.addEventListener('load', responseTampilPembelianDetail, false);
    ajax.open('POST', '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/tampil-pembelian-detail.php');
    ajax.send(formdata);
  }

 function responseTampilPembelianDetail()
  { document.getElementsByClassName('loader')[0].style['display'] = 'none';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'none';
    $('#tabelkupembeliandetail').html(event.srcElement.response);
    document.getElementById('preview-halaman-pembelian-detail').innerHTML = document.getElementById('temp-preview-halaman-pembelian-detail').innerHTML;
    document.getElementById('jlh-halaman-pembelian-detail').innerHTML = 'Jumlah Halaman : ' + formatnomor(document.getElementById('txtnhalamanpembeliandetail').value);
    showModal('popUpPembelianDetail');
  }

 function nextPagePembelianDetail()
  { var hal = document.getElementById('txthalamanpembeliandetail').value;
    hal++;
    document.getElementById('txthalamanpembeliandetail').value = hal;
    tampilPembelianDetail();
  }

 function previousPagePembelianDetail()
  { var hal = document.getElementById('txthalamanpembeliandetail').value;
    hal--;
    document.getElementById('txthalamanpembeliandetail').value = hal;
    tampilPembelianDetail();
  }

 function goToPagePembelianDetail(value)
  { document.getElementById('txthalamanpembeliandetail').value = value;
    tampilPembelianDetail();
  }

 function refreshPembelianDetail()
  { document.getElementById('txtcaripembeliandetail').value = '';
    tampilPembelianDetail();
  }

 function changeJumlah(element)
  { fnomor(element);
    var list = document.getElementsByClassName(element.className);
    list = [].slice.call(list);
    var position = list.indexOf(element);
    var pembelian_detail_id = document.getElementsByClassName('textarea_pembelian_detail-id')[position].value;
    var tersedia = normal(document.getElementsByClassName('textarea_pembelian_detail-tersedia')[position].value) * 1;
    var jumlah = normal(element.value) * 1;
    if(jumlah > tersedia)
     { jumlah = tersedia;
       element.value = formatnomor2(jumlah.toString().replaceAll('.', ','));
     }

    var detail = [];
    try
     { detail = JSON.parse(document.getElementsByClassName('barang_masuk_detail')[document.getElementById('position-barang').value].value);
     }
    catch(err) { }
    var detail = detail.filter(function (detail) { return detail.pembelian_detail_id !== pembelian_detail_id });

    if(jumlah > 0)
     { var valueToPush = {};
       valueToPush.pembelian_detail_id = pembelian_detail_id;
       valueToPush.jumlah = jumlah;
       detail.push(valueToPush);
     }

    var total = 0;
    for(var i=0; i<detail.length; i++)
     { total += detail[i].jumlah * 1;
     }

    document.getElementsByClassName('barang_masuk_detail')[document.getElementById('position-barang').value].value = JSON.stringify(detail);
    document.getElementsByClassName('add-jumlah')[document.getElementById('position-barang').value].querySelector('div').innerHTML = formatnomor2(total.toString().replaceAll('.', ','));
    document.querySelector('#popUpPembelianDetail .modal-header .modal-title small').innerHTML = formatnomor2(total.toString().replaceAll('.', ','));
  }

 //Pembelian Detail---------------------------------------------------------------------------------------------------------
 //slider-------------------------------------------------------------------------------------------------------------------
 var slide_banner = [];

 function resize()
  { if(slide_banner.length > 0)
     { destroySlider('slide_banner');
       initSlider('slide_banner', slide_banner, 0, 1);
     }
  }

 function initSlider(sliderId, items, gap, visibleCount = 1)
  { document.getElementById(sliderId).innerHTML = '';
    document.getElementById(sliderId).style.removeProperty('width');

    requestAnimationFrame(() => { //Ini dijamin berjalan setelah perubahan DOM di-render

     document.getElementById(sliderId).style['width'] = document.getElementById(sliderId).offsetWidth + 'px';
     document.getElementById(sliderId).style['overflow'] = 'hidden';

     const slider = document.createElement('div');
     slider.className = 'kontainer-slide';
     document.getElementById(sliderId).appendChild(slider);

     slider.innerHTML = `
      <div class="slides" style='display:flex; transition:transform 0.3s ease; will-change:transform; gap:` + gap + `px;'></div>
      <button type="button" class="nav prev">&#10094;</button>
      <button type="button" class="nav next">&#10095;</button>
     `;

     const slidesContainer = slider.querySelector('.slides');

     const slides = [];
     for(let i = items.length - visibleCount; i < items.length; i++)
      { slides.push(`<div class="slide">
                      <div style='position:relative;'>
                       ${items[i]}
                       <div class='title-slide'>
                        <div class='page'>${i + 1}/${items.length}</div>
                       </div>
                      </div>
                     </div>`);
      }
     for(let i=0; i<items.length; i++)
      { slides.push(`<div class="slide">
                      <div style='position:relative;'>
                       ${items[i]}
                       <div class='title-slide'>
                        <div class='page'>${i + 1}/${items.length}</div>
                       </div>
                      </div>
                     </div>`);
      }
     for(let i = 0; i < visibleCount; i++)
      { slides.push(`<div class="slide">
                      <div style='position:relative;'>
                       ${items[i]}
                       <div class='title-slide'>
                        <div class='page'>${i + 1}/${items.length}</div>
                       </div>
                      </div>
                     </div>`);
      }

     slidesContainer.innerHTML = slides.join('');
     const allSlides = slidesContainer.querySelectorAll('.slide');

     allSlides.forEach(slide => {
      slide.style.flexShrink = '0';
     });

     var wdth = (slider.querySelector('.slides').offsetWidth / visibleCount) - (gap / 2);
     var slide = slider.querySelectorAll('.slide');
     for(var i=0; i<slide.length; i++)
      { slide[i].style['width'] = wdth + 'px';
      }

     let index = visibleCount;
     let sliderWidth = slider.offsetWidth;
     let slideWidth = 0;
     let slideStep = 0;
     let isDragging = false;
     let startX = 0;
     let currentTranslate = 0;
     let prevTranslate = 0;
     let autoSlide;

     function setPosition()
      { slidesContainer.style.transform = `translateX(${-index * slideStep}px)`;
        currentTranslate = -index * slideStep;
        prevTranslate = currentTranslate;
      }

     function updateDimensions()
      { sliderWidth = slider.offsetWidth;
        slideWidth = (sliderWidth - gap * (visibleCount - 1)) / visibleCount;
        slideStep = slideWidth + gap;

        allSlides.forEach(slide => {
         slide.style.minWidth = slideWidth + 'px';
        });

        setPosition();
      }

     function nextSlide()
      { index++;
        slidesContainer.style.transition = 'transform 0.3s ease';
        setPosition();
        if(index >= allSlides.length - visibleCount)
         { setTimeout(() => {
            slidesContainer.style.transition = 'none';
            index = visibleCount;
            requestAnimationFrame(setPosition);
           }, 300);
         }
      }

     function prevSlide()
      { index--;
        slidesContainer.style.transition = 'transform 0.3s ease';
        setPosition();
        if(index < visibleCount)
         { if(index === visibleCount - 1)
            { setTimeout(() => {
               slidesContainer.style.transition = 'none';
               index = items.length + visibleCount - 1;
               requestAnimationFrame(setPosition);
              }, 300);
            }
           else
            { slidesContainer.style.transition = 'none';
              index = items.length + visibleCount - 1;
              requestAnimationFrame(setPosition);
            }
         }
      }

     function startAutoSlide()
      { /*autoSlide = setInterval(() => {
         nextSlide();
        }, 5000);*/
      }

     function stopAutoSlide()
      { clearInterval(autoSlide);
      }

     // Touch & Mouse Events
     slider.addEventListener('touchstart', (e) => {
      isDragging = true;
      startX = e.touches[0].clientX;
      slidesContainer.style.transition = 'none';
      stopAutoSlide();
     });

     slider.addEventListener('touchmove', (e) => {
      if(!isDragging) return;
      const deltaX = e.touches[0].clientX - startX;
      currentTranslate = prevTranslate + deltaX;
      slidesContainer.style.transform = `translateX(${currentTranslate}px)`;
     });

     slider.addEventListener('touchend', () => {
      isDragging = false;
      const movedBy = currentTranslate - prevTranslate;
      const threshold = slideStep * 0.1;
      if(movedBy < -threshold) nextSlide();
      else if(movedBy > threshold) prevSlide();
      else
       { slidesContainer.style.transition = 'transform 0.3s ease';
         setPosition();
       }
      startAutoSlide();
     });

     let mouseDown = false;

     slider.addEventListener('mousedown', (e) => {
      isDragging = true;
      mouseDown = true;
      startX = e.clientX;
      slidesContainer.style.transition = 'none';
      stopAutoSlide();
     });

     slider.addEventListener('mousemove', (e) => {
      if(!isDragging || !mouseDown) return;
      const deltaX = e.clientX - startX;
      currentTranslate = prevTranslate + deltaX;
      slidesContainer.style.transform = `translateX(${currentTranslate}px)`;
     });

     slider.addEventListener('mouseup', () => {
      if(!mouseDown) return;
      isDragging = false;
      mouseDown = false;
      const movedBy = currentTranslate - prevTranslate;
      const threshold = slideStep * 0.1;
      if(movedBy < -threshold) nextSlide();
      else if(movedBy > threshold) prevSlide();
      else
       { slidesContainer.style.transition = 'transform 0.3s ease';
         setPosition();
       }
      startAutoSlide();
     });

     slider.addEventListener('mouseleave', () => {
      if(isDragging && mouseDown)
       { isDragging = false;
         mouseDown = false;
         const movedBy = currentTranslate - prevTranslate;
         const threshold = slideStep * 0.1;
         if (movedBy < -threshold) nextSlide();
         else if (movedBy > threshold) prevSlide();
         else {
           slidesContainer.style.transition = 'transform 0.3s ease';
           setPosition();
         }
         startAutoSlide();
       }
     });

     slider.querySelector('.prev').addEventListener('click', () => {
      stopAutoSlide();
      prevSlide();
      startAutoSlide();
     });

     slider.querySelector('.next').addEventListener('click', () => {
      stopAutoSlide();
      nextSlide();
      startAutoSlide();
     });

     //window.addEventListener('resize', updateDimensions);
     updateDimensions();
     startAutoSlide();
     setPosition();

    });

  }

 function destroySlider(sliderId)
  { document.getElementById(sliderId).innerHTML = '';
    document.getElementById(sliderId).style.removeProperty('width');
    document.getElementById(sliderId).style.removeProperty('overflow');
  }
 //slider-------------------------------------------------------------------------------------------------------------------

</script>