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
 #popUpPenjualanDetailDitandai .modal-dialog
  { width : 100%;
    max-width : 900px;
  }
</style>

<section class='content'>
 <input type='hidden' id='position'>
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
       <div style='display:inline-block; width:100%; max-width:200px; float:left;'>
        <select class='form-control' style='width:100%;' onchange='tampilListView();' id='gudang_id'>
         <?= $list_gudang ?>
        </select>
       </div>
       <span style='float:right; padding-top:10px;' id='jlh-halaman'>Jumlah Halaman :</span>
      </div>
     </div>
     <div id='tabelku' class='responsiveku'><input type='hidden' id='txthalaman' value='1'></div>
    </div>
   </div>
  </div>
 </div>
</section>

<div class='modal' id='popUpPenjualanDetailDitandai'>
 <div class='modal-dialog'>
  <div class='modal-content'>
   <div class='modal-header'>
    <button type='button' class='close' onclick="hideModal('popUpPenjualanDetailDitandai');">&times</button>
    <h4 class='modal-title'>Pindah Rak</h4>
   </div>
   <div class='modal-body'>
    <div class='row'>
     <div class='col-md-12'>
      <input type='button' class='btn btn-default' value='&laquo' style='float:left; height:35px;' onclick='previousPagePenjualanDetailDitandai()'>
      <div style='display:inline-block; max-width:80px; float:left;'>
       <select class='form-control' style='text-align:center;' onchange='goToPagePenjualanDetailDitandai(this.value);' id='preview-halaman-penjualan-detail-ditandai'>
        <option value='1' selected>1</option>
       </select>
      </div>
      <input type='button' class='btn btn-default' value='&raquo' style='float:left; height:35px;' onclick='nextPagePenjualanDetailDitandai()'>
      <button type='button' class='btn btn-default' style='float:left; height:35px;' onclick='refreshPenjualanDetailDitandai();'><i class='fa fa-refresh'></i></button>
      <span style='float:right; padding-top:10px;' id='jlh-halaman-penjualan-detail-ditandai'>Jumlah Halaman :</span>
     </div>
    </div>
    <div id='tabelkupenjualandetailditandai' class='responsiveku'><input type='hidden' id='txthalamanpenjualandetailditandai' value='1'></div>
    <div class='row' style='margin-top:20px;'>
     <div class='col-md-2' style='padding-top:7px;'>
      <label>Pindahkan Ke Rak</label>
     </div>
     <div class='col-md-10'>
      <select class='form-control' id='rak_id'>
       <option></option>
      </select>
     </div>
    </div>
    <div class='row' style='margin-top:5px;'>
     <div class='col-md-12'>
      <div style='color:red;' id='error-pindah_rak'></div>
     </div>
    </div>
   </div>
   <div class='modal-footer'>
    <button type='button' class='btn btn-default' onclick="hideModal('popUpPenjualanDetailDitandai');"><i class='fa fa-close'></i> Batal</button>
    <button type='button' onclick='simpan()' class='btn btn-primary'><i class='fa fa-share'></i> Pindahkan</button>
   </div>
  </div>
 </div>
</div>

<div id='div-result' style='display:none'></div>

<script>

 var pindah_rak = [];

 $('#gudang_id').select2({ placeholder : 'Pilih Gudang', allowClear : true });
 $('#rak_id').select2({
  minimumInputLength : 1,
  placeholder : '',
  allowClear : false,
  ajax : {
   dataType : 'json',
   url : '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/get-rak.php',
   delay : 800,
   data : function(params) {
    return { search: params.term, username: '<?= $_POST['username'] ?>', users_level_id: '<?= $_POST['users_level_id'] ?>', cabang_id: '<?= $_POST['cabang_id'] ?>', token: '<?= $_POST['token'] ?>', gudang_id: document.getElementById('gudang_id').value };
   },
   processResults: function (data, page) {
    return { results: data };
   },
  },
 });

 tampilListView();

 function tampilListView()
  { document.getElementsByClassName('loader')[0].style['display'] = 'block';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'block';
    var formdata = new FormData();
    formdata.append('username', '<?= $_POST['username'] ?>');
    formdata.append('users_level_id', '<?= $_POST['users_level_id'] ?>');
    formdata.append('cabang_id', '<?= $_POST['cabang_id'] ?>');
    formdata.append('token', '<?= $_POST['token'] ?>');
    formdata.append('maxRecord', 10);
    formdata.append('halaman', document.getElementById('txthalaman').value);
    formdata.append('gudang_id', document.getElementById('gudang_id').value);
    var ajax = new XMLHttpRequest();
    ajax.addEventListener('load', responseTampilListView, false);
    ajax.open('POST', '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/tampil.php');
    ajax.send(formdata);
  }

 function responseTampilListView()
  { document.getElementsByClassName('loader')[0].style['display'] = 'none';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'none';
    $('#tabelku').html(event.srcElement.response);
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
    document.getElementById('position').value = '';
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

 function refresh()
  { tampilListView();
  }

 //Penjualan Detail Ditandai-------------------------------------------------------------------------------------------------------------------------

 function pilihBarang(element)
  { pindah_rak = [];
    document.getElementById('rak_id').value = '';
    $('#rak_id').trigger('change');
    document.getElementById('error-pindah_rak').innerHTML = '';
    var list = document.getElementsByClassName(element.className);
    list = [].slice.call(list);
    var position = list.indexOf(element);
    document.getElementById('position').value = position;
    document.querySelector('#popUpPenjualanDetailDitandai .modal-title').innerHTML = document.getElementsByClassName('textarea_barang_masuk_detail-nama_rak')[position].value;
    document.getElementsByClassName('loader')[0].style['display'] = 'block';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'block';
    tampilListViewPenjualanDetailDitandai();
  }

 function tampilListViewPenjualanDetailDitandai()
  { var formdata = new FormData();
    formdata.append('username', '<?= $_POST['username'] ?>');
    formdata.append('users_level_id', '<?= $_POST['users_level_id'] ?>');
    formdata.append('cabang_id', '<?= $_POST['cabang_id'] ?>');
    formdata.append('token', '<?= $_POST['token'] ?>');
    formdata.append('barang_masuk_detail_id', document.getElementsByClassName('textarea_barang_masuk_detail-id')[document.getElementById('position').value].value);
    formdata.append('jumlah_barang', document.getElementsByClassName('textarea_barang_masuk_detail-jumlah_barang')[document.getElementById('position').value].value);
    formdata.append('maxRecord', 10);
    formdata.append('halaman', document.getElementById('txthalamanpenjualandetailditandai').value);
    formdata.append('pindah_rak', JSON.stringify(pindah_rak));
    var ajax = new XMLHttpRequest();
    ajax.addEventListener('load', responseTampilListViewPenjualanDetailDitandai, false);
    ajax.open('POST', '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/tampil-penjualan-detail-ditandai.php');
    ajax.send(formdata);
  }

 function responseTampilListViewPenjualanDetailDitandai()
  { showModal('popUpPenjualanDetailDitandai');
    document.getElementsByClassName('loader')[0].style['display'] = 'none';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'none';
    $('#tabelkupenjualandetailditandai').html(event.srcElement.response);
    $('#preview-halaman-penjualan-detail-ditandai').select2({ placeholder : 'Pilih', allowClear : false });
    document.getElementById('preview-halaman-penjualan-detail-ditandai').innerHTML = document.getElementById('temp-preview-halaman-penjualan-detail-ditandai').innerHTML;
    document.getElementById('jlh-halaman-penjualan-detail-ditandai').innerHTML = 'Jumlah Halaman : ' + formatnomor(document.getElementById('txtnhalamanpenjualandetailditandai').value);
  }

 function nextPagePenjualanDetailDitandai()
  { var hal = document.getElementById('txthalamanpenjualandetailditandai').value;
    hal++;
    document.getElementById('txthalamanpenjualandetailditandai').value = hal;
    tampilListViewPenjualanDetailDitandai();
  }

 function previousPagePenjualanDetailDitandai()
  { var hal = document.getElementById('txthalamanpenjualandetailditandai').value;
    hal--;
    document.getElementById('txthalamanpenjualandetailditandai').value = hal;
    tampilListViewPenjualanDetailDitandai();
  }

 function goToPagePenjualanDetailDitandai(value)
  { document.getElementById('txthalamanpenjualandetailditandai').value = value;
    tampilListViewPenjualanDetailDitandai();
  }

 function setPindahkan(element, penjualan_detail_ditandai_id, barang_masuk_detail_id)
  { fnomor(element);
    var jumlah = normal(element.value) * 1;

    pindah_rak = pindah_rak.filter(function (pindah_rak) {
     return (pindah_rak.penjualan_detail_ditandai_id * 1 !== penjualan_detail_ditandai_id * 1 || pindah_rak.barang_masuk_detail_id * 1 !== barang_masuk_detail_id * 1);
    });

    if(jumlah > 0)
     { var valueToPush = {};
       valueToPush.key = (penjualan_detail_ditandai_id * 1) + ' - ' + barang_masuk_detail_id;
       valueToPush.penjualan_detail_ditandai_id = penjualan_detail_ditandai_id;
       valueToPush.barang_masuk_detail_id = barang_masuk_detail_id;
       valueToPush.jumlah = jumlah;
       pindah_rak.push(valueToPush);
     }
  }

 function simpan()
  { var cek = pindah_rak.filter(function (pindah_rak) {
     return (pindah_rak.jumlah * 1 > 0);
    });
    if(cek == 0)
     { document.getElementById('error-pindah_rak').innerHTML = '<b>Jumlah Barang</b> yang ingin dipindahkan wajib diisi!';
     }
    else if(document.getElementById('rak_id').value == '')
     { document.getElementById('error-pindah_rak').innerHTML = '<b>Nama Rak</b> wajib diisi!';
     }
    else
     { document.getElementById('error-pindah_rak').innerHTML = '';
       document.getElementsByClassName('loader')[0].style['display'] = 'block';
       document.getElementsByClassName('loader-block')[0].style['display'] = 'block';
       var formdata = new FormData();
       formdata.append('username', '<?= $_POST['username'] ?>');
       formdata.append('users_level_id', '<?= $_POST['users_level_id'] ?>');
       formdata.append('cabang_id', '<?= $_POST['cabang_id'] ?>');
       formdata.append('token', '<?= $_POST['token'] ?>');
       formdata.append('pindah_rak', JSON.stringify(pindah_rak));
       formdata.append('rak_id', document.getElementById('rak_id').value);
       formdata.append('barang_masuk_detail_id', document.getElementsByClassName('textarea_barang_masuk_detail-id')[document.getElementById('position').value].value);
       var ajax = new XMLHttpRequest();
       ajax.addEventListener('load', responseSimpan, false);
       ajax.open('POST', '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/simpan.php');
       ajax.send(formdata);
     }
  }

 function responseSimpan()
  { document.getElementsByClassName('loader')[0].style['display'] = 'none';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'none';
    if(event.srcElement.response == "1")
     { hideModal('popUpPenjualanDetailDitandai');
       tampilListView();
     }
    else
     { alert(event.srcElement.response);
     }
  }

 //Penjualan Detail Ditandai-------------------------------------------------------------------------------------------------------------------------

</script>