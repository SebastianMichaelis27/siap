<?php
 include("../bjksadkhrej121lkjkjk.php");
 $list_jabatan = "<option></option>";
 $query = "select * from jabatan";
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $list_jabatan .= "<option value='".$row['id']."'>".$row['jabatan']."</option>";
  }
 $list_jam_kerja = "<option></option>";
 $query = "select * from jam_kerja";
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $list_jam_kerja .= "<option value='".$row['id']."'>".$row['jam_kerja']."</option>";
  }
 $list_cabang = "<option></option>";
 $query = "select * from cabang order by nama asc";
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $list_cabang .= "<option value='".$row['id']."'>".$row['nama']."</option>";
  }
?>

<style>

 .box-foto-profil
  { position : relative;
  }

 .box-foto-profil img
  { width : 100%;
    border-radius : 100%;
  }

 .box-foto-profil button
  { position : absolute;
    bottom : 0px;
    right : 0px;
    opacity : 0;
    transition : opacity 0.5s;
  }

 .box-foto-profil:hover button
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

<section class='content'>
 <input type='hidden' id='edit-id'>
 <span id='filterKu' style='display:none;'>[]</span>
 <div class='box box-default'>
  <div class='box-header with-border'>
   <h3 class='box-title'>Karyawan</h3>
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
        <div class='col-md-5' style='padding-top:7px;'>
         <label>Cabang *</label>
        </div>
        <div class='col-md-7'>
         <select class='form-control fieldku select2' style='width:100%;' onchange='tampilListView();' id='cabang_id'>
          <?= $list_cabang ?>
         </select>
         <div style='color:red' class='error' id='error-cabang_id'></div>
        </div>
       </div>
       <div class='row' style='margin-top:5px;'>
        <div class='col-md-5' style='padding-top:7px;'>
         <label>Nomor Induk Karyawan *</label>
        </div>
        <div class='col-md-7'>
         <input type='text' class='form-control fieldku' autocomplete='new-password' id='nik'>
         <div style='color:red' class='error' id='error-nik'></div>
        </div>
       </div>
       <div class='row' style='margin-top:5px;'>
        <div class='col-md-5' style='padding-top:7px;'>
         <label>Nama *</label>
        </div>
        <div class='col-md-7'>
         <input type='text' class='form-control fieldku' autocomplete='new-password' id='nama'>
         <div style='color:red' class='error' id='error-nama'></div>
        </div>
       </div>
       <div class='row' style='margin-top:5px;'>
        <div class='col-md-5' style='padding-top:7px;'>
         <label>Jabatan</label>
        </div>
        <div class='col-md-7'>
         <select class='form-control fieldku select2' style='width:100%;' id='jabatan_id'>
          <?= $list_jabatan ?>
         </select>
         <div style='color:red' class='error' id='error-jabatan_id'></div>
        </div>
       </div>
       <div class='row' style='margin-top:5px;'>
        <div class='col-md-5' style='padding-top:7px;'>
         <label>No Hp</label>
        </div>
        <div class='col-md-7'>
         <select class='form-control fieldku' style='width:100%;' multiple id='no_hp'></select>
         <div style='color:red' class='error' id='error-no_hp'></div>
        </div>
       </div>
       <div class='row' style='margin-top:5px;'>
        <div class='col-md-5' style='padding-top:7px;'>
         <label>Alamat</label>
        </div>
        <div class='col-md-7'>
         <input type='text' class='form-control fieldku' autocomplete='new-password' id='alamat'>
         <div style='color:red' class='error' id='error-alamat'></div>
        </div>
       </div>
       <div class='row' style='margin-top:5px;'>
        <div class='col-md-5' style='padding-top:7px;'>
         <label>Gaji Per Bulan</label>
        </div>
        <div class='col-md-7'>
         <input type='text' class='form-control fieldku' autocomplete='new-password' onkeypress='return hanyaAngka(this);' onkeyup='fnomor(this);' onchange='fnomor(this);' onfocus='this.select();' onfocusout='fnomor2(this);' style='text-align:right;' id='gaji_per_bulan'>
         <div style='color:red' class='error' id='error-gaji_per_bulan'></div>
        </div>
       </div>
       <div class='row' style='margin-top:5px;'>
        <div class='col-md-5' style='padding-top:7px;'>
         <label>Gaji Per Hari</label>
        </div>
        <div class='col-md-7'>
         <input type='text' class='form-control fieldku' autocomplete='new-password' onkeypress='return hanyaAngka(this);' onkeyup='fnomor(this);' onchange='fnomor(this);' onfocus='this.select();' onfocusout='fnomor2(this);' style='text-align:right;' id='gaji_per_hari'>
         <div style='color:red' class='error' id='error-gaji_per_hari'></div>
        </div>
       </div>
       <div class='row' style='margin-top:5px;'>
        <div class='col-md-5' style='padding-top:7px;'>
         <label>Uang Makan Per Hari</label>
        </div>
        <div class='col-md-7'>
         <input type='text' class='form-control fieldku' autocomplete='new-password' onkeypress='return hanyaAngka(this);' onkeyup='fnomor(this);' onchange='fnomor(this);' onfocus='this.select();' onfocusout='fnomor2(this);' style='text-align:right;' id='uang_makan_per_hari'>
         <div style='color:red' class='error' id='error-uang_makan_per_hari'></div>
        </div>
       </div>
       <div class='row' style='margin-top:5px;'>
        <div class='col-md-5' style='padding-top:7px;'>
         <label>Uang Makan Lembur Per Hari</label>
        </div>
        <div class='col-md-7'>
         <input type='text' class='form-control fieldku' autocomplete='new-password' onkeypress='return hanyaAngka(this);' onkeyup='fnomor(this);' onchange='fnomor(this);' onfocus='this.select();' onfocusout='fnomor2(this);' style='text-align:right;' id='uang_makan_lembur_per_hari'>
         <div style='color:red' class='error' id='error-uang_makan_lembur_per_hari'></div>
        </div>
       </div>
       <div class='row' style='margin-top:5px;'>
        <div class='col-md-5' style='padding-top:7px;'>
         <label>Uang Pulsa Per Bulan</label>
        </div>
        <div class='col-md-7'>
         <input type='text' class='form-control fieldku' autocomplete='new-password' onkeypress='return hanyaAngka(this);' onkeyup='fnomor(this);' onchange='fnomor(this);' onfocus='this.select();' onfocusout='fnomor2(this);' style='text-align:right;' id='uang_pulsa_per_bulan'>
         <div style='color:red' class='error' id='error-uang_pulsa_per_bulan'></div>
        </div>
       </div>
       <div class='row' style='margin-top:5px;'>
        <div class='col-md-5' style='padding-top:7px;'>
         <label>Uang Lembur Per Jam</label>
        </div>
        <div class='col-md-7'>
         <input type='text' class='form-control fieldku' autocomplete='new-password' onkeypress='return hanyaAngka(this);' onkeyup='fnomor(this);' onchange='fnomor(this);' onfocus='this.select();' onfocusout='fnomor2(this);' style='text-align:right;' id='uang_lembur_per_jam'>
         <div style='color:red' class='error' id='error-uang_lembur_per_jam'></div>
        </div>
       </div>
       <div class='row' style='margin-top:5px;'>
        <div class='col-md-5' style='padding-top:7px;'>
         <label>Uang Servis Kendaraan Per Bulan</label>
        </div>
        <div class='col-md-7'>
         <input type='text' class='form-control fieldku' autocomplete='new-password' onkeypress='return hanyaAngka(this);' onkeyup='fnomor(this);' onchange='fnomor(this);' onfocus='this.select();' onfocusout='fnomor2(this);' style='text-align:right;' id='uang_servis_kendaraan_per_bulan'>
         <div style='color:red' class='error' id='error-uang_servis_kendaraan_per_bulan'></div>
        </div>
       </div>
       <div class='row' style='margin-top:5px;'>
        <div class='col-md-5' style='padding-top:7px;'>
         <label>Tunjangan Harian</label>
        </div>
        <div class='col-md-7'>
         <input type='text' class='form-control fieldku' autocomplete='new-password' onkeypress='return hanyaAngka(this);' onkeyup='fnomor(this);' onchange='fnomor(this);' onfocus='this.select();' onfocusout='fnomor2(this);' style='text-align:right;' id='tunjangan_harian'>
         <div style='color:red' class='error' id='error-tunjangan_harian'></div>
        </div>
       </div>
       <div class='row' style='margin-top:5px;'>
        <div class='col-md-5' style='padding-top:7px;'>
         <label>Tunjangan Jabatan Per Bulan</label>
        </div>
        <div class='col-md-7'>
         <input type='text' class='form-control fieldku' autocomplete='new-password' onkeypress='return hanyaAngka(this);' onkeyup='fnomor(this);' onchange='fnomor(this);' onfocus='this.select();' onfocusout='fnomor2(this);' style='text-align:right;' id='tunjangan_jabatan_per_bulan'>
         <div style='color:red' class='error' id='error-tunjangan_jabatan_per_bulan'></div>
        </div>
       </div>
      </div>
      <div class='col-md-6'>
       <div class='row'>
        <div class='col-md-6' style='padding-top:7px;'>
         <label>Tunjangan Kesehatan Per Bulan</label>
        </div>
        <div class='col-md-6'>
         <input type='text' class='form-control fieldku' autocomplete='new-password' onkeypress='return hanyaAngka(this);' onkeyup='fnomor(this);' onchange='fnomor(this);' onfocus='this.select();' onfocusout='fnomor2(this);' style='text-align:right;' id='tunjangan_kesehatan_per_bulan'>
         <div style='color:red' class='error' id='error-tunjangan_kesehatan_per_bulan'></div>
        </div>
       </div>
       <div class='row' style='margin-top:5px;'>
        <div class='col-md-6' style='padding-top:7px;'>
         <label>Tunjangan Transportasi Per Bulan</label>
        </div>
        <div class='col-md-6'>
         <input type='text' class='form-control fieldku' autocomplete='new-password' onkeypress='return hanyaAngka(this);' onkeyup='fnomor(this);' onchange='fnomor(this);' onfocus='this.select();' onfocusout='fnomor2(this);' style='text-align:right;' id='tunjangan_transportasi_per_bulan'>
         <div style='color:red' class='error' id='error-tunjangan_transportasi_per_bulan'></div>
        </div>
       </div>
       <div class='row' style='margin-top:5px;'>
        <div class='col-md-6' style='padding-top:7px;'>
         <label>Potongan Per Tidak Masuk</label>
        </div>
        <div class='col-md-6'>
         <input type='text' class='form-control fieldku' autocomplete='new-password' onkeypress='return hanyaAngka(this);' onkeyup='fnomor(this);' onchange='fnomor(this);' onfocus='this.select();' onfocusout='fnomor2(this);' style='text-align:right;' id='potongan_per_tidak_masuk'>
         <div style='color:red' class='error' id='error-potongan_per_tidak_masuk'></div>
        </div>
       </div>
       <div class='row' style='margin-top:5px;'>
        <div class='col-md-6' style='padding-top:7px;'>
         <label>Potongan Per Izin Cuti</label>
        </div>
        <div class='col-md-6'>
         <input type='text' class='form-control fieldku' autocomplete='new-password' onkeypress='return hanyaAngka(this);' onkeyup='fnomor(this);' onchange='fnomor(this);' onfocus='this.select();' onfocusout='fnomor2(this);' style='text-align:right;' id='potongan_per_izin_cuti'>
         <div style='color:red' class='error' id='error-potongan_per_izin_cuti'></div>
        </div>
       </div>
       <div class='row' style='margin-top:5px;'>
        <div class='col-md-6' style='padding-top:7px;'>
         <label>Potongan Per Terlambat Masuk</label>
        </div>
        <div class='col-md-6'>
         <input type='text' class='form-control fieldku' autocomplete='new-password' onkeypress='return hanyaAngka(this);' onkeyup='fnomor(this);' onchange='fnomor(this);' onfocus='this.select();' onfocusout='fnomor2(this);' style='text-align:right;' id='potongan_per_terlambat_masuk'>
         <div style='color:red' class='error' id='error-potongan_per_terlambat_masuk'></div>
        </div>
       </div>
       <div class='row' style='margin-top:5px;'>
        <div class='col-md-6' style='padding-top:7px;'>
         <label>Potongan Per Pulang Sebelum Waktunya</label>
        </div>
        <div class='col-md-6'>
         <input type='text' class='form-control fieldku' autocomplete='new-password' onkeypress='return hanyaAngka(this);' onkeyup='fnomor(this);' onchange='fnomor(this);' onfocus='this.select();' onfocusout='fnomor2(this);' style='text-align:right;' id='potongan_per_pulang_sebelum_waktunya'>
         <div style='color:red' class='error' id='error-potongan_per_pulang_sebelum_waktunya'></div>
        </div>
       </div>
       <div class='row' style='margin-top:5px;'>
        <div class='col-md-6' style='padding-top:7px;'>
         <label>Potongan Per Tidak Absen Masuk</label>
        </div>
        <div class='col-md-6'>
         <input type='text' class='form-control fieldku' autocomplete='new-password' onkeypress='return hanyaAngka(this);' onkeyup='fnomor(this);' onchange='fnomor(this);' onfocus='this.select();' onfocusout='fnomor2(this);' style='text-align:right;' id='potongan_per_tidak_absen_masuk'>
         <div style='color:red' class='error' id='error-potongan_per_tidak_absen_masuk'></div>
        </div>
       </div>
       <div class='row' style='margin-top:5px;'>
        <div class='col-md-6' style='padding-top:7px;'>
         <label>Potongan Per Tidak Absen Pulang</label>
        </div>
        <div class='col-md-6'>
         <input type='text' class='form-control fieldku' autocomplete='new-password' onkeypress='return hanyaAngka(this);' onkeyup='fnomor(this);' onchange='fnomor(this);' onfocus='this.select();' onfocusout='fnomor2(this);' style='text-align:right;' id='potongan_per_tidak_absen_pulang'>
         <div style='color:red' class='error' id='error-potongan_per_tidak_absen_pulang'></div>
        </div>
       </div>
       <div class='row' style='margin-top:5px;'>
        <div class='col-md-6' style='padding-top:7px;'>
         <label>Tanggal Masuk</label>
        </div>
        <div class='col-md-6'>
         <div style='display:grid; grid-template-columns:1fr auto; gap:5px;'>
          <input type='text' class='form-control fieldku tanggal' autocomplete='new-password' style='background-color:white;' readonly id='tanggal_masuk'>
          <button type='button' class='btn btn-default' onclick="document.getElementById('tanggal_masuk').value = '';"><i class='fa fa-close'></i></button>
         </div>
         <div style='color:red' class='error' id='error-tanggal_masuk'></div>
        </div>
       </div>
       <div class='row' style='margin-top:5px;'>
        <div class='col-md-6' style='padding-top:7px;'>
         <label>Tanggal Gajian Tiap Bulan</label>
        </div>
        <div class='col-md-6'>
         <input type='text' class='form-control fieldku' autocomplete='new-password' id='tanggal_gajian_tiap_bulan'>
         <div style='color:red' class='error' id='error-tanggal_gajian_tiap_bulan'></div>
        </div>
       </div>
       <div class='row' style='margin-top:5px;'>
        <div class='col-md-6' style='padding-top:7px;'>
         <label>Status Aktif</label>
        </div>
        <div class='col-md-6'>
         <select class='form-control fieldku select2' style='width:100%;' id='status_aktif'>
          <option></option>
          <option value='1'>Aktif</option>
          <option value='2'>Tidak Aktif</option>
         </select>
         <div style='color:red' class='error' id='error-status_aktif'></div>
        </div>
       </div>
       <div class='row' style='margin-top:5px;'>
        <div class='col-md-6' style='padding-top:7px;'>
         <label>Utang</label>
        </div>
        <div class='col-md-6'>
         <input type='text' class='form-control fieldku' autocomplete='new-password' id='utang'>
         <div style='color:red' class='error' id='error-utang'></div>
        </div>
       </div>
       <div class='row' style='margin-top:5px;'>
        <div class='col-md-6' style='padding-top:7px;'>
         <label>Password</label>
        </div>
        <div class='col-md-6'>
         <input type='text' class='form-control fieldku' autocomplete='new-password' id='password'>
         <div style='color:red' class='error' id='error-password'></div>
        </div>
       </div>
       <div class='row' style='margin-top:5px;'>
        <div class='col-md-6' style='padding-top:7px;'>
         <label>Jam Kerja</label>
        </div>
        <div class='col-md-6'>
         <select class='form-control fieldku select2' style='width:100%;' id='jam_kerja_id'>
          <?= $list_jam_kerja ?>
         </select>
         <div style='color:red' class='error' id='error-jam_kerja_id'></div>
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
     <h3 class='box-title'>List Karyawan</h3>
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

<div class='modal fade' id='myModal2' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
 <div class='modal-dialog'>
  <div class='modal-content'>
   <div class='modal-header'>
    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times</button>
    <h4 class='modal-title'>Upload Picture</h4>
    <span style='display:none;' id='id_upload'></span>
   </div>
   <div class='modal-body'>
    <div class='image-editor'>
     <input type='file' class='cropit-image-input'>
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
    <button type='button' class='btn btn-default' data-dismiss='modal'>Batal</button>
    <button type='button' class='btn btn-primary export' data-dismiss='modal'>Selesai</button>
   </div>
  </div>
 </div>
</div>

<div id='div-result' style='display:none'></div>

<script src='bower_components/crop-image/dist/jquery.cropit.js'></script>
<script>

 $(function() {
  $('.image-editor').cropit({width: 400, height: 400});
   $('.rotate-cw').click(function() {
   $('.image-editor').cropit('rotateCW');
  });
  $('.rotate-ccw').click(function() {
   $('.image-editor').cropit('rotateCCW');
  });
  $('.export').click(function() {
   var imageData = $('.image-editor').cropit('export');
   uploadFoto(imageData);
  });
 });

 function dataURLtoFile(dataurl, filename)
  { var arr = dataurl.split(','), mime = arr[0].match(/:(.*?);/)[1], bstr = atob(arr[1]),  n = bstr.length,  u8arr = new Uint8Array(n);
    while(n--)
     { u8arr[n] = bstr.charCodeAt(n);
     } 
    return new File([u8arr], filename, {type:mime});
  }

 function uploadFoto(src)
  { document.getElementsByClassName('loader')[0].style['display'] = 'block';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'block';
    var formdata = new FormData();
    formdata.append('username', '<?= $_POST['username'] ?>');
    formdata.append('users_level_id', '<?= $_POST['users_level_id'] ?>');
    formdata.append('cabang_id', '<?= $_POST['cabang_id'] ?>');
    formdata.append('token', '<?= $_POST['token'] ?>');
    formdata.append('id', document.getElementById('id_upload').value);
    formdata.append('file', dataURLtoFile(src));
    var ajax = new XMLHttpRequest();
    ajax.addEventListener("load", responseUploadFoto, false);
    ajax.open('POST', '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/upload-foto.php');
    ajax.send(formdata);
  }

 function responseUploadFoto(event)
  { $('#div-result').html(event.srcElement.response);
    if(event.srcElement.response == '1')
     { $('.cropit-preview-image').attr('src','');
       tampilListView();
     }
    else
     { alert(event.srcElement.response);
     }
    document.getElementsByClassName('loader')[0].style['display'] = 'none';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'none';
  }

 var Nama_Tabel = 'karyawan';
 var FieldTidakBolehRangkap = [
  {field : 'nik'},
 ];
 var FieldRequired = [
  {field : 'nik', label : 'NIK'},
  {field : 'nama', label : 'Nama'},
 ];
 var maxRecord = 10;

 if('<?= $_POST['cabang_id'] ?>' !== '')
  { document.getElementById('cabang_id').value = '<?= $_POST['cabang_id'] ?>';
    document.getElementById('row-cabang_id').style['display'] = 'none';
  }

 $('.select2').select2({ placeholder : 'Pilih', allowClear : true });
 $('.tanggal').datepicker({ autoclose : true, todayHighlight : true, format : 'dd-mm-yyyy' });

 makeSelect2Search('no_hp', '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/get-no-hp.php', { username: '<?= $_POST['username'] ?>', users_level_id: '<?= $_POST['users_level_id'] ?>', cabang_id: '<?= $_POST['cabang_id'] ?>', token: '<?= $_POST['token'] ?>' });

 tampilListView();

 function validasi()
  { var no_hp = [];
    try
     { var a = $('#no_hp').val();
       for(i=0; i<a.length; i++)
        { if(a[i] !== '')
           { var valueToPush = {};
             valueToPush.no_hp = a[i];
             no_hp.push(valueToPush);
           }
        }
     }
    catch(er) { }

    var data = {};
    var a = document.getElementsByClassName('fieldku');
    for(var loop=0; loop<a.length; loop++)
     { if(a[loop].value !== '')
        { if(a[loop].id == 'no_hp')
           { data[a[loop].id] = no_hp;
           }
          else if( a[loop].id == 'gaji_per_bulan' || a[loop].id == 'gaji_per_hari' || a[loop].id == 'uang_makan_per_hari' || a[loop].id == 'uang_makan_lembur_per_hari' || a[loop].id == 'uang_pulsa_per_bulan' || a[loop].id == 'uang_lembur_per_jam' || a[loop].id == 'uang_servis_kendaraan_per_bulan' || a[loop].id == 'tunjangan_harian' || a[loop].id == 'tunjangan_jabatan_per_bulan' || a[loop].id == 'tunjangan_kesehatan_per_bulan' || a[loop].id == 'tunjangan_transportasi_per_bulan' || a[loop].id == 'potongan_per_tidak_masuk' || a[loop].id == 'potongan_per_izin_cuti' || a[loop].id == 'potongan_per_terlambat_masuk' || a[loop].id == 'potongan_per_pulang_sebelum_waktunya' || a[loop].id == 'potongan_per_tidak_absen_masuk' || a[loop].id == 'potongan_per_tidak_absen_pulang')
           { data[a[loop].id] = normal(a[loop].value);
           }
          else if(a[loop].id == 'tanggal_masuk')
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
     { if(a[loop].id == 'no_hp')
        { document.getElementById(a[loop].id).innerHTML = document.getElementsByClassName('select_edit-' + a[loop].id)[position].innerHTML;
        }
       else
        { document.getElementById(a[loop].id).value = document.getElementsByClassName('textarea_edit-' + a[loop].id)[position].value;
        }
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