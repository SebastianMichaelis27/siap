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

<section class='content'>
 <input type='hidden' id='edit-id'>
 <span id='filterKu' style='display:none;'>[]</span>
 <div class='box box-default'>
  <div class='box-header with-border'>
   <h3 class='box-title'>Laporan Stok</h3>
   <div class='box-tools pull-right'>
    <button type='button' class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-minus'></i></button>
   </div>
  </div>
  <div class='box-body'>
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
       <div class='error' id='error-gudang_id'></div>
      </div>
     </div>
    </div>
    <div class='col-md-6'>
     <div class='row'>
      <div class='col-md-4' style='padding-top:7px;'>
       <label>Nama Barang</label>
      </div>
      <div class='col-md-8'>
       <input type='text' class='form-control' onkeyup='tampilListView();' onchange='tampilListView();' id='nama_barang'>
       <div class='error' id='error-nama_barang'></div>
      </div>
     </div>
    </div>
   </div>
  </div>
 </div>
 <div id='form-cetak'></div>
</section>

<div class='modal' id='popUpDetail'>
 <div class='modal-dialog'>
  <div class='modal-content'>
   <div class='modal-header'>
    <button type='button' class='close' onclick="hideModal('popUpDetail');">&times</button>
    <h4 class='modal-title'>Detail</h4>
   </div>
   <div class='modal-body'></div>
   <div class='modal-footer'>
    <button type='button' class='btn btn-default'  onclick="hideModal('popUpDetail');"><i class='fa fa-close'></i> Tutup</button>
   </div>
  </div>
 </div>
</div>

<div id='div-result' style='display:none'></div>

<script>

 $('.select2').select2({ placeholder : '', allowClear : true });

 function tampilListView()
  { document.getElementsByClassName('loader')[0].style['display'] = 'block';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'block';
    var formdata = new FormData();
    formdata.append('username', '<?= $_POST['username'] ?>');
    formdata.append('users_level_id', '<?= $_POST['users_level_id'] ?>');
    formdata.append('cabang_id', '<?= $_POST['cabang_id'] ?>');
    formdata.append('token', '<?= $_POST['token'] ?>');
    formdata.append('gudang_id', document.getElementById('gudang_id').value);
    formdata.append('nama_barang', document.getElementById('nama_barang').value);
    var ajax = new XMLHttpRequest();
    ajax.addEventListener('load', responseTampilListView, false);
    ajax.open('POST', '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/tampil.php');
    ajax.send(formdata);
  }

 function responseTampilListView()
  { document.getElementsByClassName('loader')[0].style['display'] = 'none';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'none';
    $('#form-cetak').html(event.srcElement.response);
  }

 function showDetail(element)
  { document.querySelector('#popUpDetail .modal-title').innerHTML = element.querySelector('.kode_barang').textContent + ' - ' + element.querySelector('.nama_barang').textContent;

    var data = [];
    try
     { data = JSON.parse(document.getElementById('temp-detail_barang').value);
     }
    catch(err) {}
    data = data.filter(function (data) { return data.barang_id == element.querySelector('.barang_id').value });

    var list = '';
    for(var i=0; i<data.length; i++)
     { list += `<tr>
                 <td>` + data[i]['tanggal'] + `</td>
                 <td>` + data[i]['sumber'] + `</td>
                 <td>` + data[i]['nama_rak'] + `</td>
                 <td style='text-align:right;'>` + data[i]['digudang'] + `</td>
                 <td style='text-align:right;'>` + data[i]['stok'] + `</td>
                 <td>` + element.querySelector('.satuan_barang').textContent + `</td>
                </tr>`;
     }

    document.querySelector('#popUpDetail .modal-body').innerHTML = `
     <table class='table table-bordered'>
      <thead>
       <tr>
        <th>Tanggal</th>
        <th>Sumber</th>
        <th>Rak</th>
        <th>Qty Digudang</th>
        <th>Qty Stok</th>
        <th>Satuan</th>
       </tr>
      </thead>
      <tbody>` + list + `</tbody>
     </table>
    `;
    showModal('popUpDetail');
  }

</script>