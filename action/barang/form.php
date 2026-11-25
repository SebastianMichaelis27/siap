<?php
 include("../bjksadkhrej121lkjkjk.php");
 $list_satuan = "<option></option>";
 $query = "select * from satuan order by satuan asc";
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $list_satuan .= "<option value='".$row['id']."'>".$row['satuan']."</option>";
  }
 $list_kategori = "";
 $query = "select * from kategori order by kategori asc";
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $list_kategori .= "<option value='".$row['id']."'>".$row['kategori']."</option>";
  }
 $list_jenis_customer = "<option></option>";
 $query = "select * from jenis_customer order by jenis_customer asc";
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $list_jenis_customer .= "<option value='".$row['id']."'>".$row['jenis_customer']."</option>";
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
    grid-template-columns : auto 1fr auto;
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
</style>
<div id='style'></div>
<select style='display:none;' id='temp-jenis_customer'><?= $list_jenis_customer ?></select>
<section class='content'>
 <input type='hidden' id='edit-id'>
 <span id='filterKu' style='display:none;'>[]</span>
 <div class='box box-default'>
  <div class='box-header with-border'>
   <h3 class='box-title'>Barang</h3>
   <div class='box-tools pull-right'>
    <button type='button' class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-minus'></i></button>
   </div>
  </div>
  <div class='box-body'>
   <div class='row'>
    <div class='col-md-12'>
     <div style='border:1px solid silver; padding:15px;'>
      <div style='display:inline-block; font-weight:bold; position:absolute; top:-10px; background:white;'>Data Barang</div>
      <div class='row'>
       <div class='col-md-6'>
        <div class='row'>
         <div class='col-md-4' style='padding-top:7px;'>
          <label>Kode Barang *</label>
         </div>
         <div class='col-md-8'>
          <input type='text' autocomplete='new-password' class='form-control fieldku' id='kode'>
          <div style='color:red' class='error' id='error-kode'></div>
         </div>
        </div>
        <div class='row' style='margin-top:5px;'>
         <div class='col-md-4' style='padding-top:7px;'>
          <label>Nama Barang *</label>
         </div>
         <div class='col-md-8'>
          <input type='text' autocomplete='new-password' class='form-control fieldku' id='nama'>
          <div style='color:red' class='error' id='error-nama'></div>
         </div>
        </div>
        <div class='row' style='margin-top:5px;'>
         <div class='col-md-4' style='padding-top:7px;'>
          <label>Kategori</label>
         </div>
         <div class='col-md-8'>
          <select class='form-control fieldku' autocomplete='new-password' style='width:100%;' multiple id='kategori'>
           <?= $list_kategori ?>
          </select>
          <div style='color:red' class='error' id='error-kategori'></div>
         </div>
        </div>
        <div class='row' style='margin-top:5px;'>
         <div class='col-md-4' style='padding-top:7px;'>
          <label>Merek *</label>
         </div>
         <div class='col-md-8'>
          <input type='text' autocomplete='new-password' class='form-control fieldku' id='merek'>
          <div style='color:red' class='error' id='error-merek'></div>
         </div>
        </div>
        <div class='row' style='margin-top:5px;'>
         <div class='col-md-4' style='padding-top:7px;'>
          <label>Model</label>
         </div>
         <div class='col-md-8'>
          <input type='text' autocomplete='new-password' class='form-control fieldku' id='model'>
          <div style='color:red' class='error' id='error-model'></div>
         </div>
        </div>
        <div class='row' style='margin-top:5px;'>
         <div class='col-md-4' style='padding-top:7px;'>
          <label>Tipe</label>
         </div>
         <div class='col-md-8'>
          <input type='text' autocomplete='new-password' class='form-control fieldku' id='tipe'>
          <div style='color:red' class='error' id='error-tipe'></div>
         </div>
        </div>
        <div class='row' style='margin-top:5px;'>
         <div class='col-md-4' style='padding-top:7px;'>
          <label>Jenis</label>
         </div>
         <div class='col-md-8'>
          <input type='text' autocomplete='new-password' class='form-control fieldku' id='jenis'>
          <div style='color:red' class='error' id='error-jenis'></div>
         </div>
        </div>
       </div>
       <div class='col-md-6'>
        <div class='row'>
         <div class='col-md-4' style='padding-top:7px;'>
          <label>Kapasitas</label>
         </div>
         <div class='col-md-8'>
          <div style='display:grid; grid-template-columns:1fr auto; gap:5px; align-items:center;'>
           <input type='text' autocomplete='new-password' class='form-control fieldku' onkeypress='return hanyaAngka(this);' onkeyup='fnomor(this);' onchange='fnomor(this);' onfocus='this.select();' style='text-align:right;' id='kapasitas_pk'>
           <div>PK</div>
          </div>
          <div style='color:red' class='error' id='error-kapasitas_pk'></div>
         </div>
        </div>
        <div class='row' style='margin-top:5px;'>
         <div class='col-md-4' style='padding-top:7px;'>
          <label>BTU/H</label>
         </div>
         <div class='col-md-8'>
          <input type='text' autocomplete='new-password' class='form-control fieldku' onkeypress='return hanyaAngka(this);' onkeyup='fnomor(this);' onchange='fnomor(this);' onfocus='this.select();' style='text-align:right;' id='btuh'>
          <div style='color:red' class='error' id='error-btuh'></div>
         </div>
        </div>
        <div class='row' style='margin-top:5px;'>
         <div class='col-md-4' style='padding-top:7px;'>
          <label>Ukuran</label>
         </div>
         <div class='col-md-8'>
          <input type='text' autocomplete='new-password' class='form-control fieldku' onkeypress='return hanyaAngka(this);' onkeyup='fnomor(this);' onchange='fnomor(this);' onfocus='this.select();' onfocusout='fnomor2(this);' style='text-align:right;' id='ukuran'>
          <div style='color:red' class='error' id='error-ukuran'></div>
         </div>
        </div>
        <div class='row' style='margin-top:5px;'>
         <div class='col-md-4' style='padding-top:7px;'>
          <label>Satuan</label>
         </div>
         <div class='col-md-8'>
          <select class='form-control fieldku' style='width:100%;' id='satuan_id'>
           <?= $list_satuan ?>
          </select>
          <div style='color:red' class='error' id='error-satuan_id'></div>
         </div>
        </div>
        <div class='row' style='margin-top:5px;'>
         <div class='col-md-4' style='padding-top:7px;'>
          <label>Harga Beli</label>
         </div>
         <div class='col-md-8'>
          <input type='text' autocomplete='new-password' class='form-control fieldku' onkeypress='return hanyaAngka(this);' onkeyup='fnomor(this);' onchange='fnomor(this);' onfocus='this.select();' onfocusout='fnomor2(this);' style='text-align:right;' id='harga_beli'>
          <div style='color:red' class='error' id='error-harga_beli'></div>
         </div>
        </div>
        <div class='row' style='margin-top:5px;'>
         <div class='col-md-4' style='padding-top:7px;'>
          <label>Harga Jual *</label>
         </div>
         <div class='col-md-8'>
          <input type='text' autocomplete='new-password' class='form-control fieldku' onkeypress='return hanyaAngka(this);' onkeyup='fnomor(this);' onchange='fnomor(this);' onfocus='this.select();' onfocusout='fnomor2(this);' style='text-align:right;' id='harga_jual'>
          <div style='color:red' class='error' id='error-harga_jual'></div>
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
      <div style='display:inline-block; font-weight:bold; position:absolute; top:-10px; background:white;'>Data PO</div>
      <div class='row'>
       <div class='col-md-6'>
        <div class='row' style='margin-top:5px;'>
         <div class='col-md-4' style='padding-top:7px;'>
          <label>Unit *</label>
         </div>
         <div class='col-md-8'>
          <input type='text' autocomplete='new-password' class='form-control fieldku' id='unit'>
          <div style='color:red' class='error' id='error-unit'></div>
         </div>
        </div>
        <div class='row' style='margin-top:5px;'>
         <div class='col-md-4' style='padding-top:7px;'>
          <label>Cap</label>
         </div>
         <div class='col-md-8'>
          <input type='text' autocomplete='new-password' class='form-control fieldku' id='cap'>
          <div style='color:red' class='error' id='error-cap'></div>
         </div>
        </div>
       </div>
       <div class='col-md-6'>
        <div class='row'>
         <div class='col-md-4' style='padding-top:7px;'>
          <label>Description</label>
         </div>
         <div class='col-md-8'>
          <input type='text' autocomplete='new-password' class='form-control fieldku' id='description'>
          <div style='color:red' class='error' id='error-description'></div>
         </div>
        </div>
       </div>
      </div>
     </div>
    </div>
   </div>
   <div class='row' style='margin-top:10px;'>
    <div class='col-md-4'>
     <button type='button' class='btn btn-success' onclick='tampilPopUpFoto();'>
      <i class='fa fa-camera'></i> Ambil Foto Barang
     </button>
     <div id='slide_banner' style='margin-top:5px;'></div>
    </div>
    <div class='col-md-8'>
     <button type='button' class='btn btn-success' onclick="addDiskonJenisCustomer('', '')"><i class='fa fa-plus'></i> Tambahkan Diskon</button>
     <div id='div-diskon_jenis_customer'></div>
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
     <h3 class='box-title'>List Barang</h3>
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

<div class='modal' id='popUpFoto'>
 <div class='modal-dialog'>
  <div class='modal-content'>
   <div class='modal-header'>
    <button type='button' class='close' onclick='tutupPopUpFoto();'>&times</button>
    <h4 class='modal-title'>Upload Picture</h4>
   </div>
   <div class='modal-body'>
    <div class='image-editor'>
     <input type='file' class='cropit-image-input'> Minimal lebar foto <b>500px</b> dan minimal tinggi foto <b>500px</b>
     <div class='cropit-preview'></div>
     <div class='image-size-label'>
      Resize image
     </div>
     <input type='range' class='cropit-image-zoom-input'>
     <button class='btn btn-default rotate-ccw'><i class='fa fa-mail-reply'></i></button>
     <button class='btn btn-default rotate-cw'><i class='fa fa-mail-forward'></i></button>
    </div>
   </div>
   <div class='modal-footer'>
    <button type='button' onclick='tutupPopUpFoto();' class='btn btn-default'><i class='fa fa-close'></i> Tutup</button>
    <button type='button' class='btn btn-primary export'><i class='fa fa-check'></i> Selesai</button>
   </div>
  </div>
 </div>
</div>

<div class='modal' onclick="hideModal('popUpViewFoto');" style='padding-bottom:50px; background-color:rgba(0, 0, 0, 0.9);' id='popUpViewFoto'>
 <div class='modal-dialog'>
  <div class='modal-content'>
   <img src='' id='view-foto' style='width:100%; user-select:none;'>
  </div>
 </div>
</div>

<div class='modal' id='popUpDiskon'>
 <div class='modal-dialog'>
  <div class='modal-content'>
   <div class='modal-header'>
    <button type='button' class='close' onclick="hideModal('popUpDiskon');">&times</button>
    <h4 class='modal-title'>Detail Diskon</h4>
   </div>
   <div class='modal-body'>
    <input type='hidden' id='position_item'>
    <button type='button' class='btn btn-success' style='margin-bottom:10px;' onclick='tambahDiskon();'><i class='fa fa-plus'></i> Tambah Diskon</button>
    <div id='list_diskon'></div>
   </div>
   <div class='modal-footer'>
    <button type='button' class='btn btn-default' onclick="hideModal('popUpDiskon');"><i class='fa fa-close'></i> Tutup</button>
    <button type='button' class='btn btn-primary' onclick="setDiskon();"><i class='fa fa-save'></i> Simpan</button>
   </div>
  </div>
 </div>
</div>

<div id='div-result' style='display:none;'></div>

<script src='bower_components/crop-image/dist/jquery.cropit.js'></script>
<script src='bower_components/ckeditor/ckeditor.js'></script>

<script>

 var slide_banner = [];
 var hapus_foto = [];
 var Nama_Tabel = 'barang';
 var FieldTidakBolehRangkap = [
  {field : 'nama'},
  {field : 'merek'},
  {field : 'model'},
  {field : 'tipe'},
 ];
 var FieldRequired = [
  {field : 'kode', label : 'Kode Barang'},
  {field : 'nama', label : 'Nama Barang'},
  {field : 'merek', label : 'Merek'},
  {field : 'unit', label : 'Unit'},
  {field : 'harga_jual', label : 'Harga Jual'},
 ];
 var maxRecord = 10;
 var index_foto = 0;

 $('#form-input').html(event.srcElement.response);
 $('#kategori').select2({ placeholder : '', allowClear : false });
 tampilListView();
 clearDiskonJenisCustomer();

 function validasi()
  { var error = 0;
    var diskon = [];
    var a = document.getElementsByClassName('jenis_customer_id');
    for(var i=0; i<a.length; i++)
     { if(a[i].value == '')
        { error++;
          document.getElementsByClassName('error-jenis_customer_id')[i].innerHTML = 'Wajib diisi!';
        }
       else
        { document.getElementsByClassName('error-jenis_customer_id')[i].innerHTML = '';
        }
       if(document.getElementsByClassName('diskon_item_detail')[i].value == '')
        { error++;
          document.getElementsByClassName('error-diskon')[i].innerHTML = 'Wajib diisi!';
        }
       else
        { document.getElementsByClassName('error-diskon')[i].innerHTML = '';
        }

       var diskn = 0;
       var temp_harga_jual = normal(document.getElementById('harga_jual').value) * 1;
       try
        { var diskon_item_detail = JSON.parse(document.getElementsByClassName('diskon_item_detail')[i].value);
          for(var j=0; j<diskon_item_detail.length; j++)
           { var temp_diskon = 0
             if(diskon_item_detail[j].jenis == '%')
              { temp_diskon = temp_harga_jual * diskon_item_detail[j].jumlah / 100;
              }
             else
              { temp_diskon = diskon_item_detail[j].jumlah * 1;
              }
             diskn += temp_diskon;
             temp_harga_jual -= temp_diskon;
           }
        }
       catch(err) { }

       var valueToPush = {};
       valueToPush.jenis_customer_id = a[i].value;
       valueToPush.diskon = diskn;
       valueToPush.diskon_item_detail = document.getElementsByClassName('diskon_item_detail')[i].value;
       diskon.push(valueToPush);
     }

    var kategori = [];
    try
     { var a = $('#kategori').val();
       for(i=0; i<a.length; i++)
        { if(a[i] !== '')
           { var valueToPush = {};
             valueToPush.kategori_id = a[i];
             kategori.push(valueToPush);
           }
        }
     }
    catch(er) { }
    var data = {};
    var a = document.getElementsByClassName('fieldku');
    for(var loop=0; loop<a.length; loop++)
     { if(a[loop].value !== '')
        { if(a[loop].id == 'kapasitas_pk' || a[loop].id == 'btuh' || a[loop].id == 'ukuran' || a[loop].id == 'harga_beli' || a[loop].id == 'harga_jual')
           { data[a[loop].id] = normal(a[loop].value) * 1;
           }
          else if(a[loop].id == 'kategori')
           { data[a[loop].id] = kategori;
           }
          else
           { data[a[loop].id] = a[loop].value;
           }
        }
       else
        { data[a[loop].id] = null;
        }
     }
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
       simpan(data, DataTidakBolehRangkap, diskon);
     }
  }

 function simpan(data, DataTidakBolehRangkap, diskon)
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
       formdata.append('diskon', JSON.stringify(diskon));
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
       formdata.append('diskon', JSON.stringify(diskon));
       formdata.append('hapus_foto', JSON.stringify(hapus_foto));
       formdata.append('id', document.getElementById('edit-id').value);
       var ajax = new XMLHttpRequest();
       ajax.addEventListener('load', responseSimpan, false);
       ajax.open('POST', '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/ubah.php');
       ajax.send(formdata);
     }
  }

 function responseSimpan()
  { hapus_foto = [];
    try
     { var result = JSON.parse(event.srcElement.response);
       if(result.status == 1)
        { document.getElementById('edit-id').value = result.id;
          index_foto = 0;
          uploadFoto();
        }
       else
        { document.getElementsByClassName('loader')[0].style['display'] = 'none';
          document.getElementsByClassName('loader-block')[0].style['display'] = 'none';
          alert(result.pesan);
        }
     }
    catch(err)
     { document.getElementsByClassName('loader')[0].style['display'] = 'none';
       document.getElementsByClassName('loader-block')[0].style['display'] = 'none';
     }
  }

 function uploadFoto()
  { if(index_foto < slide_banner.length)
     { var element = document.createElement('div');
       element.innerHTML = slide_banner[index_foto];
       src = element.querySelector('img').src;
       index_foto++;
       try
        { var formdata = new FormData();
          formdata.append('username', '<?= $_POST['username'] ?>');
          formdata.append('users_level_id', '<?= $_POST['users_level_id'] ?>');
          formdata.append('cabang_id', '<?= $_POST['cabang_id'] ?>');
          formdata.append('token', '<?= $_POST['token'] ?>');
          formdata.append('foto', dataURLtoFile(src));
          formdata.append('id', document.getElementById('edit-id').value);
          var ajax = new XMLHttpRequest();
          ajax.addEventListener('load', uploadFoto, false);
          ajax.open('POST', '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/upload.php');
          ajax.send(formdata);
        }
       catch(err)
        { uploadFoto();
        }
     }
    else
     { document.getElementsByClassName('loader')[0].style['display'] = 'none';
       document.getElementsByClassName('loader-block')[0].style['display'] = 'none';
       clearField();
       tampilListView();
       tutupPopUpHapus();
     }
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
    slide_banner = [];
    hapus_foto = [];
    resize();
    document.getElementById('slide_banner').innerHTML = '';
    clearDiskonJenisCustomer();
  }

 function filter()
  { if(document.getElementById('edit-id').value == '')
     { var kategori = [];
       try
        { var a = $('#kategori').val();
          for(i=0; i<a.length; i++)
           { if(a[i] !== '')
              { var valueToPush = {};
                valueToPush.kategori_id = a[i];
                kategori.push(valueToPush);
              }
           }
        }
       catch(er) { }
       var data = [];
       var a = document.getElementsByClassName('fieldku');
       for(var loop=0; loop<a.length; loop++)
        { if(a[loop].value !== '')
           { var valueToPush = {};
             valueToPush.field = Nama_Tabel + '.' + a[loop].id;
             if(a[loop].id == 'kapasitas_pk' || a[loop].id == 'btuh' || a[loop].id == 'harga_beli' || a[loop].id == 'harga_jual')
              { valueToPush.value = normal(a[loop].value) * 1;
              }
             else if(a[loop].id == 'kategori')
              { valueToPush.value = JSON.stringify(kategori);
              }
             else
              { valueToPush.value = a[loop].value;
              }
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
  { slide_banner = [];
    hapus_foto = [];
    resize();
    document.getElementById('slide_banner').innerHTML = '';
    var list = document.getElementsByClassName(label.className);
    list = [].slice.call(list);
    var position = list.indexOf(label);
    document.getElementById('edit-id').value = document.getElementsByClassName('textarea_edit-id')[position].value;
    var a = document.getElementsByClassName('fieldku');
    for(var loop=0; loop<a.length; loop++)
     { if(a[loop].id == 'kategori')
        { var data = [];
          var add = [];
          try
           { data = JSON.parse(document.getElementsByClassName('textarea_edit-' + a[loop].id)[position].value);
             for(i=0; i<data.length; i++)
              { add.push(data[i].kategori_id);
              }
           }
          catch(err) {}
          $("#" + a[loop].id).val(add);
        }
       else
        { document.getElementById(a[loop].id).value = document.getElementsByClassName('textarea_edit-' + a[loop].id)[position].value;
        }
       try
        { $('#' + document.getElementById(a[loop].id).id).trigger('change');
        }
       catch(er) { }
     }
    
    try
     { slide_banner = [];
       var foto = JSON.parse(document.getElementsByClassName('textarea_edit-file')[position].value);
       for(var i=0; i<foto.length; i++)
        { var new_element = document.createElement('div');
          new_element.innerHTML = `<div class='item-slide'>
                                    <img src='<?= $_POST['url'] ?>/gambar/barang/` + document.getElementsByClassName('textarea_edit-id')[position].value + `/` + foto[i] + `' draggable='false' style='user-select:none; width:100%;'>
                                   </div>`;
          slide_banner.push(new_element.innerHTML);
        }
       resize();
     }
    catch(er) { }

    clearDiskonJenisCustomer();
    var a = document.getElementsByClassName('div_diskon')[position].querySelectorAll('.div_diskon-jenis_customer_id');
    for(var i=0; i<a.length; i++)
     { var jenis_customer_id = a[i].value;
       var diskon_item_detail = document.getElementsByClassName('div_diskon')[position].querySelectorAll('.div_diskon-diskon_item_detail')[i].value;
       addDiskonJenisCustomer(jenis_customer_id, diskon_item_detail);
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

 function tampilPopUpFoto()
  { document.getElementById('style').innerHTML = '<style> .modal-dialog { width : 100%; max-width : 600px; } </style>';
    showModal('popUpFoto');
    scaleElement();
  }

 function tutupPopUpFoto()
  { document.getElementById('style').innerHTML = '';
    hideModal("popUpFoto");
  }

 window.addEventListener('popstate', function (event) {
  hideModal('popUpViewFoto');
 });

 function viewFoto(element)
  { var src = element.parentElement.parentElement.querySelector('img').src;
    document.getElementById('view-foto').src = src;
    showModal('popUpViewFoto');
  }

 function hapusFoto(element)
  { var list = document.getElementsByClassName('hapus-foto');
    list = [].slice.call(list);
    var position = list.indexOf(element);
    var src = element.parentElement.parentElement.querySelector('img').src;
    try { var a = dataURLtoFile(src); } catch(err)
     { hapus_foto.push(src);
     }
    slide_banner.splice(position - 1, 1);
    resize();
    if(slide_banner.length == 0)
     { document.getElementById('slide_banner').innerHTML = '';
     }
  }

 function scaleElement()
  { var width_body = 598;
    var modalBody = document.querySelector('#popUpFoto .modal-body');
    var preview = document.querySelector('.cropit-preview');
    if(!modalBody || !preview) return;
    var modalWidth = modalBody.offsetWidth;
    if(modalWidth < width_body)
     { var skala = modalWidth / width_body;
       // Hitung tinggi aktual setelah di-scale
       var height_asli = preview.offsetHeight;
       var height_scaled = height_asli * skala;
       // Terapkan transform dan sesuaikan tinggi container agar layout tetap rapat
       preview.style.transform = 'scale(' + skala + ')';
       preview.style.transformOrigin = 'top left';
       preview.style.border = '2px solid silver';
       preview.style.marginBottom = (height_scaled - height_asli) + 'px'; // kompensasi tinggi visual
     }
    else
     { preview.style.transform = 'unset';
       preview.style.transformOrigin = 'unset';
       preview.style.border = '1px solid silver';
       preview.style.marginBottom = '0';
     }
  }

 $(function() {
  $('.image-editor').cropit({width: 500, height: 500});
   $('.rotate-cw').click(function() {
   $('.image-editor').cropit('rotateCW');
  });
  $('.rotate-ccw').click(function() {
   $('.image-editor').cropit('rotateCCW');
  });
  $('.export').click(function() {
   var imageData = $('.image-editor').cropit('export');
   var new_element = document.createElement('div');
   new_element.innerHTML = `<div class='item-slide'>
                             <img src='` + imageData + `' draggable='false' style='user-select:none; width:100%;'>
                            </div>`;
   slide_banner.push(new_element.innerHTML);
   resize();
   tutupPopUpFoto();
  });
 });

 function dataURLtoFile(dataurl, filename)
  { var arr = dataurl.split(','), mime = arr[0].match(/:(.*?);/)[1], bstr = atob(arr[1]),  n = bstr.length,  u8arr = new Uint8Array(n);
    while(n--)
     { u8arr[n] = bstr.charCodeAt(n);
     } 
    return new File([u8arr], filename, {type:mime});
  }

 function clearDiskonJenisCustomer()
  { document.getElementById('div-diskon_jenis_customer').innerHTML = `
     <table class='table table-bordered' style='margin-top:5px;' id='table-diskon'>
      <thead>
       <tr>
        <th style='text-align:center; width:50px; min-width:50px; max-width:50px;'>No.</th>
        <th style='min-width:200px;'>Jenis Customer</th>
        <th style='text-align:center; width:160px; min-width:160px; max-width:160px;'>Diskon</th>
        <th style='text-align:center; width:60px; min-width:60px; max-width:60px;'>Del</th>
       </tr>
       <tbody></tbody>
      </thead>
     </table>
    `;
  }

 function addDiskonJenisCustomer(jenis_customer_id, diskon_item_detail)
  { var view_diskon_item = '';
    try
     { var temp = JSON.parse(diskon_item_detail);
       for(var i=0; i<temp.length; i++)
        { var item_diskon = temp[i].jumlah + '%';
          if(temp[i].jenis == 'Rp')
           { item_diskon = 'Rp' + formatnomor(temp[i].jumlah.toString().replaceAll('.', ','));
           }
          if(view_diskon_item !== '')
           { view_diskon_item += ' + ';
           }
          view_diskon_item += item_diskon;
        }
     }
    catch(err) { }

    var new_element = document.createElement('tr');
    new_element.innerHTML = `<td style='text-align:right;'></td>
                             <td>
                              <select class='form-control jenis_customer_id' onchange='cekRangkap(this);'>
                               ` + document.getElementById('temp-jenis_customer').innerHTML.toString().replaceAll('value="'+ jenis_customer_id + '"', 'value="'+ jenis_customer_id + '" selected') + `
                              </select>
                              <div style='color:red;' class='error-jenis_customer_id'></div>
                             </td>
                             <td>
                              <div class='input-disable' onclick='showDiskonItem(this);'>
                               <div class='view-diskon_item'>` + view_diskon_item + `</div>
                              </div>
                              <textarea style='display:none;' class='diskon'></textarea>
                              <textarea style='display:none;' class='diskon_item_detail'>` + diskon_item_detail + `</textarea>
                              <div style='color:red;' class='error-diskon'></div>
                             </td>
                             <td>
                              <button type='button' class='btn btn-danger hapus-diskon' onclick='hapusDiskonJenisCustomer(this);'><i class='fa fa-trash'></i></button>
                             </td>`;
    document.querySelector('#table-diskon tbody').appendChild(new_element);
    $('.jenis_customer_id').select2({ placeholder : '', allowClear : true });
    setNomorUrut();
  }

 function setListDiskon()
  { document.getElementById('list_diskon').innerHTML = `<div class='row row-diskon'>
     <div class='col-md-2' style='padding-top:7px;'>
      <label>Diskon</label>
     </div>
     <div class='col-md-10'>
      <div style='display:grid; grid-template-columns:auto 1fr auto; gap:5px;'>
       <select class='form-control'>
        <option value='%'>%</option>
        <option value='Rp'>Rp</option>
       </select>
       <input type='text' class='form-control' onkeypress='return hanyaAngka(this);' onkeyup='fnomor(this);' onchange='fnomor(this);' onfocus='this.select();'>
       <button type='button' class='btn btn-danger' onclick='hapusDiskon(this);'><i class='fa fa-trash'></i></button>
      </div>
     </div>
    </div>`;
  }

 function showDiskonItem(element)
  { var list = document.getElementsByClassName(element.className);
    list = [].slice.call(list);
    var position = list.indexOf(element);
    document.getElementById('position_item').value = position;
    document.querySelector('#popUpDiskon .modal-title').innerHTML = 'Diskon : ' + getTextSelected(document.getElementsByClassName('jenis_customer_id')[position]);
    setListDiskon();
    try
     { var a = JSON.parse(document.getElementsByClassName('diskon_item_detail')[position].value);
       for(var i=0; i<a.length; i++)
        { if(i > 0)
           { tambahDiskon();
           }
          document.querySelectorAll('.row-diskon input[type="text"]')[i].value = formatnomor(a[i].jumlah.toString().replaceAll('.', ','));
          document.querySelectorAll('.row-diskon select')[i].value = a[i].jenis;
        }
     }
    catch(err) {}
    showModal('popUpDiskon');
  }

 function tambahDiskon()
  { var new_element = document.querySelector('.row-diskon').cloneNode(true);
    new_element.style['margin-top'] = '5px';
    new_element.querySelector('input[type="text"]').value = '';
    new_element.querySelector('select').value = '%';
    document.querySelector('#popUpDiskon .modal-body #list_diskon').appendChild(new_element);
  }

 function hapusDiskon(element)
  { if(document.querySelectorAll('.row-diskon').length > 1)
     { element.parentNode.parentNode.parentNode.remove();
     }
    else
     { document.querySelector('.row-diskon input[type="text"]').value = '';
       document.querySelector('.row-diskon select').value = '%';
     }
  }

 function setDiskon(element)
  { var diskon = [];
    var a = document.querySelectorAll('.row-diskon');
    document.getElementsByClassName('view-diskon_item')[document.getElementById('position_item').value].textContent = '';
    for(var i=0; i<a.length; i++)
     { if(document.querySelectorAll('.row-diskon input[type="text"]')[i].value !== '')
        { if(document.querySelectorAll('.row-diskon select')[i].value == '%' && normal(document.querySelectorAll('.row-diskon input[type="text"]')[i].value) * 1 > 100)
           { document.querySelectorAll('.row-diskon input[type="text"]')[i].value = '100';
           }
          var valueToPush = {};
          valueToPush.jenis = document.querySelectorAll('.row-diskon select')[i].value;
          valueToPush.jumlah = normal(document.querySelectorAll('.row-diskon input[type="text"]')[i].value) * 1;
          diskon.push(valueToPush);

          var item_diskon = document.querySelectorAll('.row-diskon input[type="text"]')[i].value + '%';
          if(document.querySelectorAll('.row-diskon select')[i].value == 'Rp')
           { item_diskon = 'Rp' + document.querySelectorAll('.row-diskon input[type="text"]')[i].value;
           }

          if(document.getElementsByClassName('view-diskon_item')[document.getElementById('position_item').value].textContent !== '')
           { document.getElementsByClassName('view-diskon_item')[document.getElementById('position_item').value].textContent += ' + ';
           }
          document.getElementsByClassName('view-diskon_item')[document.getElementById('position_item').value].textContent += item_diskon;
        }
     }
    document.getElementsByClassName('diskon_item_detail')[document.getElementById('position_item').value].value = JSON.stringify(diskon);
    hideModal('popUpDiskon');
  }

 function cekRangkap(element)
  { var list = document.getElementsByClassName(element.className);
    list = [].slice.call(list);
    var position = list.indexOf(element);
    var a = document.getElementsByClassName(element.className);
    for(var i=0; i<a.length; i++)
     { if(i !== position && a[i].value == element.value)
        { element.value = '';
          $('.jenis_customer_id').trigger('change');
        }
     }
  }

 function setNomorUrut()
  { var a = document.querySelectorAll('#table-diskon tbody tr');
    for(var i=0; i<a.length; i++)
     { a[i].querySelector('td').innerHTML = (i + 1);
     }
  }

 function hapusDiskonJenisCustomer(element)
  { var list = document.getElementsByClassName(element.className);
    list = [].slice.call(list);
    var position = list.indexOf(element);
    var elem = document.querySelectorAll('#table-diskon tbody tr')[position];
    elem.parentNode.removeChild(elem);
    setNomorUrut();
  }

 //slider-------------------------------------------------------------------------------------------------------------------
 var item_slide = document.querySelectorAll('#slide_banner .item-slide');
 for(var i=0; i<item_slide.length; i++)
  { slide_banner.push(item_slide[i].innerHTML);
  }

 function resize()
  { if(slide_banner.length > 0)
     { destroySlider('slide_banner');
       initSlider('slide_banner', slide_banner, 0, 1);
     }
  }
 resize();

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
                        <div style='text-align:center;' onclick='viewFoto(this);'><i class='fa fa-search'></i></div>
                        <div style='text-align:right;' class='hapus-foto' onclick='hapusFoto(this);'><i class='fa fa-trash'></i></div>
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
                        <div style='text-align:center;' onclick='viewFoto(this);'><i class='fa fa-search'></i></div>
                        <div style='text-align:right;' class='hapus-foto' onclick='hapusFoto(this);'><i class='fa fa-trash'></i></div>
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
                        <div style='text-align:center;' onclick='viewFoto(this);'><i class='fa fa-search'></i></div>
                        <div style='text-align:right;' class='hapus-foto' onclick='hapusFoto(this);'><i class='fa fa-trash'></i></div>
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