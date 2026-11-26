<?php
 include("../bjksadkhrej121lkjkjk.php");
 $list_cabang = "<option></option>";
 $query = "select * from cabang order by nama asc";
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $list_cabang .= "<option value='".$row['id']."'>".$row['nama']."</option>";
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
   <h3 class='box-title'>Laporan Penawaran</h3>
   <div class='box-tools pull-right'>
    <button type='button' class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-minus'></i></button>
   </div>
  </div>
  <div class='box-body'>
   <div class='row'>
    <div class='col-md-6'>
     <div class='row'>
      <div class='col-md-3' style='padding-top:7px;'>
       <label>Tanggal *</label>
      </div>
      <div class='col-md-9'>
       <div style='display:grid; grid-template-columns:1fr auto 1fr auto; gap:5px; align-items:center;'>
        <input type='text' class='form-control tanggal' id='dari_tanggal'>
        <div>s/d</div>
        <input type='text' class='form-control tanggal' id='sampai_tanggal'>
        <button type='button' class='btn btn-default' onclick="document.getElementById('dari_tanggal').value = ''; document.getElementById('sampai_tanggal').value = '';"><i class='fa fa-close'></i></button>
       </div>
       <div class='error' id='error-tanggal'></div>
      </div>
     </div>
     <div class='row' style='margin-top:5px;'>
      <div class='col-md-3' style='padding-top:7px;'>
       <label>Periode Grafik *</label>
      </div>
      <div class='col-md-9'>
       <select class='form-control' style='width:100%;' id='periode_grafik'>
        <option></option>
        <option value='Hari'>Hari</option>
        <option value='Minggu'>Minggu</option>
        <option value='Bulan'>Bulan</option>
        <option value='Tahun'>Tahun</option>
       </select>
       <div class='error' id='error-periode_grafik'></div>
      </div>
     </div>
     <div class='row' id='row-cabang_id' style='margin-top:5px;'>
      <div class='col-md-3' style='padding-top:7px;'>
       <label>Cabang</label>
      </div>
      <div class='col-md-9'>
       <select class='form-control' style='width:100%;' id='cabang_id'>
        <?= $list_cabang ?>
       </select>
       <div class='error' id='error-cabang_id'></div>
      </div>
     </div>
    </div>
    <div class='col-md-6'>
     <div class='row'>
      <div class='col-md-3' style='padding-top:7px;'>
       <label>Sales</label>
      </div>
      <div class='col-md-9'>
       <select class='form-control' style='width:100%;' autocomplete='new-password' multiple id='karyawan_id'>
        <option></option>
       </select>
       <div class='error' id='error-karyawan_id'></div>
      </div>
     </div>
     <div class='row' style='margin-top:5px;'>
      <div class='col-md-3' style='padding-top:7px;'>
       <label>Jenis Customer</label>
      </div>
      <div class='col-md-9'>
       <select class='form-control' style='width:100%;' autocomplete='new-password' multiple id='jenis_customer_id'>
        <?= $list_jenis_customer ?>
       </select>
       <div class='error' id='error-jenis_customer_id'></div>
      </div>
     </div>
    </div>
   </div>
  </div>
  <div class='box-footer'>
   <div class='row' style='margin-top:5px;'>
    <div class='col-md-12'>
     <button class='btn btn-default pull-right' type='button' onclick='tampilListView();' id='btnfilter'><i class='fa fa-search'></i> Cari</button>
    </div>
   </div>
  </div>
 </div>
 <div id='form-cetak'></div>
</section>

<div id='div-result' style='display:none'></div>
<script type='text/javascript' src='bower_components/chartjs/dist/Chart.js'></script>

<script>

 makeSelect2Search('karyawan_id', '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/get-karyawan.php', { username: '<?= $_POST['username'] ?>', users_level_id: '<?= $_POST['users_level_id'] ?>', cabang_id: '<?= $_POST['cabang_id'] ?>', token: '<?= $_POST['token'] ?>' });
 $('#jenis_customer_id').select2({ placeholder : '', allowClear : false });

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
    var karyawan_id = [];
    try
     { var a = $('#karyawan_id').val();
       for(i=0; i<a.length; i++)
        { if(a[i] !== '')
           { karyawan_id.push(a[i]);
           }
        }
     }
    catch(er) { }
    var jenis_customer_id = [];
    try
     { var a = $('#jenis_customer_id').val();
       for(i=0; i<a.length; i++)
        { if(a[i] !== '')
           { jenis_customer_id.push(a[i]);
           }
        }
     }
    catch(er) { }
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
    if(document.getElementById('periode_grafik').value == '')
     { error++;
       document.getElementById('error-periode_grafik').innerHTML = '<b>Periode Grafik</b> wajib diisi!'
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
       formdata.append('periode_grafik', document.getElementById('periode_grafik').value);
       formdata.append('cabang_id_', document.getElementById('cabang_id').value);
       formdata.append('karyawan_id', JSON.stringify(karyawan_id));
       formdata.append('jenis_customer_id', JSON.stringify(jenis_customer_id));
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
  }

</script>