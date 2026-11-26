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
?>

<section class='content'>
 <input type='hidden' id='edit-id'>
 <span id='filterKu' style='display:none;'>[]</span>
 <div class='box box-default'>
  <div class='box-header with-border'>
   <h3 class='box-title'>Laporan Pembelian</h3>
   <div class='box-tools pull-right'>
    <button type='button' class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-minus'></i></button>
   </div>
  </div>
  <div class='box-body'>
   <div class='row'>
    <div class='col-md-5'>
     <div class='row'>
      <div class='col-md-3' style='padding-top:7px;'>
       <label>Tanggal *</label>
      </div>
      <div class='col-md-8'>
       <div style='display:grid; grid-template-columns:1fr auto 1fr; gap:5px; align-items:center;'>
        <input type='text' class='form-control tanggal' onchange='setTglSampai(this); tampilListView();' id='dari_tanggal' value='<?= date('d-m-Y', strtotime($masa_lampau)) ?>'>
        <div>s/d</div>
        <input type='text' class='form-control tanggal' onchange='setTglDari(this); tampilListView();' id='sampai_tanggal' value='<?= date('d-m-Y', strtotime($now)) ?>'>
       </div>
       <div class='error' id='error-tanggal'></div>
      </div>
     </div>
    </div>
    <div class='col-md-offset-2 col-md-5'>
     <div class='row' id='row-cabang_id'>
      <div class='col-md-3' style='padding-top:7px;'>
       <label>Cabang *</label>
      </div>
      <div class='col-md-9'>
       <select class='form-control' onchange='tampilListView();' style='width:100%;' id='cabang_id'>
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

<div id='div-result' style='display:none'></div>

<script>

 $('.tanggal').datepicker({ autoclose : true, todayHighlight : true, format : 'dd-mm-yyyy' });
 $('#cabang_id').select2({ placeholder : '', allowClear : true });

 if('<?= $_POST['cabang_id'] ?>' !== '')
  { document.getElementById('cabang_id').value = '<?= $_POST['cabang_id'] ?>';
    document.getElementById('row-cabang_id').style['display'] = 'none';
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