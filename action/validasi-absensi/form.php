<?php
 include("../bjksadkhrej121lkjkjk.php");
 $foto_kelas = "dist/img/no_image.png";
?>

<style>
 .btn-add
  { background : #277c02;
    width : 50px;
    height : 50px;
    border-radius : 50%;
    color : white;
    font-size : 20px;
    border : 0px;
    position : fixed;
    bottom : 60px;
    right : 10px;
  }
 .btn-add:active
  { background : #1f5f02;
  }

 .loading
  { position : relative;
    display : none;
  }

 .loading div:nth-child(1)
  { border : 5px solid white;
    border-radius : 50%;
    border-top : 5px solid #3498db;
    width : 70px;
    height : 70px;
    -webkit-animation : spin 2s linear infinite;
    animation : spin 2s linear infinite;
  }

 .loading div:nth-child(2)
  { position : absolute;
    top : 25px;
    text-align : center;
    width : 70px;
    -webkit-animation : fade 1.5s linear infinite;
  }

 @keyframes fade
  { 0%
     { opacity : 1;
     }
    100%
     { opacity : 0;
     }
  }

 /* Safari */
 @-webkit-keyframes fade
  { 0%
     { -webkit-opacity : 1;
     }
    100%
     { -webkit-opacity : 0;
     }
  }

</style>

<input type='hidden' id='absensi_id'>
<section class='content'>
 <div class='row'>
  <div class='col-md-offset-3 col-md-6'>

   <div class='row' id='row-filter'>
    <div class='col-md-12'>
     <select class='form-control' onchange='resetFormListView();' id='status_verifikasi'>
      <option value='0'>Belum Diverifikasi</option>
      <option value='1'>Verifikasi Diterima</option>
      <option value='2'>Verifikasi Ditolak</option>
     </select>
    </div>
   </div>

   <div class='row' style='margin-top:5px;'>
    <div class='col-md-12'>
     <div style='height:100px; overflow-x:hidden; overflow-y:visible;' onscroll='listviewScroll(this);' id='form-listview'>
      <input type='hidden' value='1' id='txthalaman'>
      <input type='hidden' value='1' id='txtnhalaman'>
      <center>
       <div class='loading'>
        <div></div>
        <div>Loading</div>
       </div>
      </center>
     </div>
    </div>
   </div>

  </div>
 </div>
</section>

<div class='modal' id='popUpValidasi'>
 <div class='modal-dialog'>
  <div class='modal-content'>
   <div class='modal-header'>
    <button type='button' class='close' onclick="hideModal('popUpValidasi');">&times</button>
    <h4 class='modal-title'>Verifikasi Absensi</h4>
   </div>
   <div class='modal-body'>
    <div class='row'>
     <div class='col-md-3' style='padding-top:7px;'>
      <label>NIK *</label>
     </div>
     <div class='col-md-9'>
      <div style='min-height:34px; border:1px solid silver; background:#eeeeee;'>
       <div style='padding:6px 10px 6px 10px;' id='nik'></div>
      </div>
     </div>
    </div>
    <div class='row' style='margin-top:5px;'>
     <div class='col-md-3' style='padding-top:7px;'>
      <label>Nama *</label>
     </div>
     <div class='col-md-9'>
      <div style='min-height:34px; border:1px solid silver; background:#eeeeee;'>
       <div style='padding:6px 10px 6px 10px;' id='nama'></div>
      </div>
     </div>
    </div>
    <div class='row' style='margin-top:5px;'>
     <div class='col-md-3' style='padding-top:7px;'>
      <label>Foto *</label>
     </div>
     <div class='col-md-9'>
      <img style='width:100%;' id='foto'>
     </div>
    </div>
    <div class='row' style='margin-top:5px;'>
     <div class='col-md-3' style='padding-top:7px;'>
      <label id='jenis_absensi'>Masuk/Pulang</label>
     </div>
     <div class='col-md-9'>
      <div style='min-height:34px; border:1px solid silver; background:#eeeeee;'>
       <div style='padding:6px 10px 6px 10px;' id='tanggal_waktu'></div>
      </div>
     </div>
    </div>
    <div class='row' style='margin-top:5px;'>
     <div class='col-md-3' style='padding-top:7px;'>
      <label>Verifikasi *</label>
     </div>
     <div class='col-md-9'>
      <select class='form-control select2' onchange='setViewKeterangan();' id='status'>
       <option></option>
       <option value='1'>Terima</option>
       <option value='2'>Tolak</option>
      </select>
      <div class='error' style='color:red;' id='error-status'></div>
     </div>
    </div>
    <div class='row' style='margin-top:5px;' id='row-keterangan'>
     <div class='col-md-3' style='padding-top:7px;'>
      <label>Keterangan *</label>
     </div>
     <div class='col-md-9'>
      <input type='text' class='form-control' id='keterangan'>
      <div class='error' style='color:red;' id='error-keterangan'></div>
     </div>
    </div>
   </div>
   <div class='modal-footer'>
    <button type='button' class='btn btn-default' onclick="hideModal('popUpValidasi');"><i class='fa fa-close'></i> Batal</button>
    <button type='button' onclick='verifikasi()' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
   </div>
  </div>
 </div>
</div>

<script>

 var Nama_Tabel = 'absensi';
 var maxRecord = 5;

 $('.select2').select2({ placeholder : '', allowClear : true });

 function tampilListView()
  { document.getElementById('form-listview').querySelector('.loading').style['display'] = 'inline-block';
    var formdata = new FormData();
    formdata.append('username', '<?= $_POST['username'] ?>');
    formdata.append('users_level_id', '<?= $_POST['users_level_id'] ?>');
    formdata.append('cabang_id', '<?= $_POST['cabang_id'] ?>');
    formdata.append('token', '<?= $_POST['token'] ?>');
    formdata.append('Nama_Tabel', Nama_Tabel);
    formdata.append('maxRecord', maxRecord);
    formdata.append('halaman', document.getElementById('txthalaman').value);
    formdata.append('status_verifikasi', document.getElementById('status_verifikasi').value);
    var ajax = new XMLHttpRequest();
    ajax.addEventListener('load', responseTampilListView, false);
    ajax.open('POST', '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/tampil.php');
    ajax.send(formdata);
  }

 function responseTampilListView()
  { document.getElementById('form-listview').querySelector('.loading').style['display'] = 'none';
    var halaman = document.getElementById('txthalaman').value * 1;
    var nhalaman = document.getElementById('txtnhalaman').value * 1;
    if(halaman <= nhalaman)
     { var element_remove = document.getElementsByClassName('listview-page-' + halaman);
       for(var i=0; i<element_remove.length; i++)
        { element_remove[i].parentNode.removeChild(element_remove[i]);
        }
       var result = document.createElement('div');
       result.id = 'listview-page-' + halaman;
       result.className = 'listview-page-' + halaman;
       result.innerHTML = event.srcElement.response;
       document.getElementById('form-listview').appendChild(result);
       var a = document.getElementsByClassName('halaman');
       document.getElementById('txthalaman').value = a[a.length - 1].value;
       var b = document.getElementsByClassName('nhalaman');
       document.getElementById('txtnhalaman').value = b[b.length - 1].value;
     }
  }

 tampilListView();

 function setHeightListView()
  { document.getElementById('form-listview').style['height'] = (document.getElementsByClassName('content-wrapper')[0].clientHeight - document.getElementById('row-filter').clientHeight - 5) + 'px';
  }

 setHeightListView();

 function listviewScroll(element)
  { var halaman = document.getElementById('txthalaman').value * 1;
    var nhalaman = document.getElementById('txtnhalaman').value * 1;
    if((element.scrollTop + element.clientHeight) >= element.scrollHeight && document.getElementById('form-listview').querySelector('.loading').style['display'] !== 'inline-block')
     { if(halaman <= nhalaman)
        { setTimeout(function()
           { var halaman = document.getElementById('txthalaman').value * 1;
             halaman++;
             document.getElementById('txthalaman').value = halaman;
             tampilListView();
             element.scrollTop = element.scrollHeight;
           },
          500);
        }
       else
        { document.getElementById('txthalaman').value = nhalaman;
        }
     }
  }

 function konfirmasiValidasi(element)
  { var list = document.getElementsByClassName(element.className);
    list = [].slice.call(list);
    var position = list.indexOf(element);
    document.getElementById('absensi_id').value = element.querySelector('.temp-id').value;
    document.getElementById('nik').innerHTML = element.querySelector('.temp-nik').value;
    document.getElementById('nama').innerHTML = element.querySelector('.temp-nama').value;
    document.getElementById('foto').src = element.querySelector('.temp-foto').value;
    document.getElementById('jenis_absensi').innerHTML = element.querySelector('.temp-jenis_absensi').value;
    document.getElementById('tanggal_waktu').innerHTML = element.querySelector('.temp-tanggal_waktu').value;
    document.getElementById('status').value = '';
    if(element.querySelector('.temp-status').value !== '')
     { document.getElementById('status').value = element.querySelector('.temp-status').value;
     }
    $('#status').trigger('change');
    setViewKeterangan();
    showModal('popUpValidasi');
  }

 function setViewKeterangan()
  { if(document.getElementById('status').value == '2')
     { document.getElementById('row-keterangan').style['display'] = 'block';
     }
    else
     { document.getElementById('row-keterangan').style['display'] = 'none';
       document.getElementById('keterangan').value = '';
       document.getElementById('error-keterangan').innerHTML = '';
     }
  }

 function verifikasi()
  { var error = 0;
    document.getElementById('error-status').innerHTML = '';
    document.getElementById('error-keterangan').innerHTML = '';
    if(document.getElementById('status').value == '')
     { error++;
       document.getElementById('error-status').innerHTML = '<b>Status Verifikasi</b> wajib diisi!';
     }
    else
     { if(document.getElementById('status').value == '2' && document.getElementById('keterangan').value == '')
        { error++;
          document.getElementById('error-keterangan').innerHTML = '<b>Keterangan</b> wajib diisi!';
        }
     }
    if(error == 0)
     { document.getElementsByClassName('loader')[0].style['display'] = 'block';
       document.getElementsByClassName('loader-block')[0].style['display'] = 'block';
       var formdata = new FormData();
       formdata.append('username', '<?= $_POST['username'] ?>');
       formdata.append('users_level_id', '<?= $_POST['users_level_id'] ?>');
       formdata.append('cabang_id', '<?= $_POST['cabang_id'] ?>');
       formdata.append('token', '<?= $_POST['token'] ?>');
       formdata.append('id', document.getElementById('absensi_id').value);
       formdata.append('status', document.getElementById('status').value);
       var ajax = new XMLHttpRequest();
       ajax.addEventListener('load', responseVerifikasi, false);
       ajax.open('POST', '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/simpan.php');
       ajax.send(formdata);
     }
  }

 function responseVerifikasi()
  { document.getElementsByClassName('loader')[0].style['display'] = 'none';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'none';
    if(event.srcElement.response == '1')
     { var halaman = document.getElementById('txthalaman').value;
       resetFormListView();
       hideModal('popUpValidasi');
     }
  }

 function resetFormListView()
  { document.getElementById('form-listview').innerHTML = `
     <input type='hidden' value='1' id='txthalaman'>
     <input type='hidden' value='1' id='txtnhalaman'>
     <center>
      <div class='loading'>
       <div></div>
       <div>Loading</div>
      </div>
     </center>
    `;
    tampilListView();
  }

</script>