<?php
 include("../bjksadkhrej121lkjkjk.php");

 $now = date('Y-m-d');
 $masa_lampau = date('Y-m-d', strtotime('-7 day', strtotime($now)));

 $list_cabang = "<option></option>";
 $query = "select * from cabang order by nama asc";
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $list_cabang .= "<option value='".$row['id']."'>".$row['nama']."</option>";
  }

 $list_karyawan = "<option></option>";
 $query = "select * from karyawan order by nama asc";
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $list_karyawan .= "<option value='".$row['id']."'>".$row['nama']."</option>";
  }

 $list_jenis_customer = "<option></option>";
 $query = "select * from jenis_customer order by jenis_customer asc";
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $list_jenis_customer .= "<option value='".$row['id']."'>".$row['jenis_customer']."</option>";
  }
?>

<section class='content'>
 <input type='hidden' id='edit-id'>
 <span id='filterKu' style='display:none;'>[]</span>
 <div class='box box-default'>
  <div class='box-header with-border'>
   <h3 class='box-title'>Laporan Penjualan</h3>
   <div class='box-tools pull-right'>
    <button type='button' class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-minus'></i></button>
   </div>
  </div>
  <div class='box-body'>
   <div class='row'>
    <div class='col-md-6'>
     <div class='row' id='row-cabang_id'>
      <div class='col-md-3' style='padding-top:7px;'>
       <label>Cabang *</label>
      </div>
      <div class='col-md-9'>
       <select class='form-control' style='width:100%;' id='cabang_id' onchange='tampilListView();'>
        <?= $list_cabang ?>
       </select>
       <div style='color:red' class='error' id='error-cabang_id'></div>
      </div>
     </div>
     <div class='row' style='margin-top:5px;'>
      <div class='col-md-3' style='padding-top:7px;'>
       <label>Tanggal *</label>
      </div>
      <div class='col-md-8'>
       <div style='display:grid; grid-template-columns:1fr auto 1fr; gap:5px; align-items:center;'>
        <input type='text' autocomplete='new-password' class='form-control tanggal' onchange='setTglSampai(this); tampilListView();' id='dari_tanggal' value='<?= date('d-m-Y', strtotime($masa_lampau)) ?>'>
        <div>s/d</div>
        <input type='text' autocomplete='new-password' class='form-control tanggal' onchange='setTglSampai(this); tampilListView();' id='sampai_tanggal' value='<?= date('d-m-Y', strtotime($now)) ?>'>
       </div>
       <div style='color:red' class='error' id='error-tanggal'></div>
      </div>
     </div>
     <div class='row' style='margin-top:5px;'>
      <div class='col-md-3' style='padding-top:7px;'>
       <label>Customer</label>
      </div>
      <div class='col-md-9'>
       <select class='form-control' style='width:100%;' id='customer_id' onchange='tampilListView();'>
        <option></option>
       </select>
       <div style='color:red' class='error' id='error-customer_id'></div>
      </div>
     </div>
     <div class='row' style='margin-top:5px;'>
      <div class='col-md-3' style='padding-top:7px;'>
       <label>Jenis Customer</label>
      </div>
      <div class='col-md-9'>
       <select class='form-control' style='width:100%;' id='jenis_customer_id' onchange='tampilListView();'>
        <?= $list_jenis_customer ?>
       </select>
       <div style='color:red' class='error' id='error-jenis_customer_id'></div>
      </div>
     </div>
    </div>
    <div class='col-md-6'>
     <div class='row'>
      <div class='col-md-3' style='padding-top:7px;'>
       <label>Sales</label>
      </div>
      <div class='col-md-9'>
       <select class='form-control' style='width:100%;' id='karyawan_id' onchange='tampilListView();'>
        <?= $list_karyawan ?>
       </select>
       <div style='color:red' class='error' id='error-karyawan_id'></div>
      </div>
     </div>
     <div class='row' style='margin-top:5px;'>
      <div class='col-md-3' style='padding-top:7px;'>
       <label>Merek</label>
      </div>
      <div class='col-md-9'>
       <input type='text' autocomplete='new-password' class='form-control fieldku' onkeyup='timeSearch();' onchange='timeSearch();' id='merek'>
       <div style='color:red' class='error' id='error-merek'></div>
      </div>
     </div>
     <div class='row' style='margin-top:5px;'>
      <div class='col-md-3' style='padding-top:7px;'>
       <label>Tipe</label>
      </div>
      <div class='col-md-9'>
       <input type='text' autocomplete='new-password' class='form-control fieldku' onkeyup='timeSearch();' onchange='timeSearch();' id='tipe'>
       <div style='color:red' class='error' id='error-tipe'></div>
      </div>
     </div>
     <div class='row' style='margin-top:5px;'>
      <div class='col-md-3' style='padding-top:7px;'>
       <label>Kapasitas</label>
      </div>
      <div class='col-md-9'>
       <div style='display:grid; grid-template-columns:70px auto; gap:5px; align-items:center;'>
        <input type='text' autocomplete='new-password' class='form-control fieldku' onkeypress='return hanyaAngka(this);' onkeyup='fnomor(this); timeSearch();' onchange='fnomor(this);' onfocus='this.select();' style='text-align:right;' id='kapasitas_pk'>
        <div>PK</div>
       </div>
       <div style='color:red' class='error' id='error-kapasitas_pk'></div>
      </div>
     </div>
    </div>
   </div>
  </div>
 </div>
 <div id='form-cetak'></div>
</section>

<div id='div-result' style='display:none'></div>

<script>

 $('.tanggal').datepicker({ autoclose : true, todayHighlight : true, format : 'dd-mm-yyyy' });
 $('#cabang_id').select2({ placeholder : '', allowClear : true });
 $('#karyawan_id').select2({ placeholder : '', allowClear : true });
 $('#jenis_customer_id').select2({ placeholder : '', allowClear : true });
 makeSelect2Search('customer_id', '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/get-customer.php', { username: '<?= $_POST['username'] ?>', users_level_id: '<?= $_POST['users_level_id'] ?>', cabang_id: '<?= $_POST['cabang_id'] ?>', token: '<?= $_POST['token'] ?>' });

 if('<?= $_POST['cabang_id'] ?>' !== '')
  { document.getElementById('cabang_id').value = '<?= $_POST['cabang_id'] ?>';
    document.getElementById('row-cabang_id').style['display'] = 'none';
  }

 var tik = 0;
 function timeSearch()
  { tik++;
    setTimeout(function() {
     tik--;
     if(tik == 0)
      { tampilListView();
      }
    }, 1000);
  }

 function tampilListView()
  { if('<?= $_POST['cabang_id'] ?>' !== '')
     { document.getElementById('cabang_id').value = '<?= $_POST['cabang_id'] ?>';
     }
    var error = 0;
    document.getElementById('error-tanggal').innerHTML = '';
    document.getElementById('error-cabang_id').innerHTML = '';
    if(document.getElementById('dari_tanggal').value == '')
     { error++;
       document.getElementById('error-tanggal').innerHTML = '<b>Tanggal</b> wajib diisi!'
     }
    if(document.getElementById('sampai_tanggal').value == '')
     { error++;
       document.getElementById('error-tanggal').innerHTML = '<b>Tanggal</b> wajib diisi!'
     }
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
       formdata.append('dari_tanggal', document.getElementById('dari_tanggal').value);
       formdata.append('sampai_tanggal', document.getElementById('sampai_tanggal').value);
       formdata.append('cabang_id_', document.getElementById('cabang_id').value);
       formdata.append('karyawan_id', document.getElementById('karyawan_id').value);
       formdata.append('customer_id', document.getElementById('customer_id').value);
       formdata.append('jenis_customer_id', document.getElementById('jenis_customer_id').value);
       formdata.append('merek', document.getElementById('merek').value);
       formdata.append('tipe', document.getElementById('tipe').value);
       formdata.append('kapasitas_pk', normal(document.getElementById('kapasitas_pk').value));
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

</script>