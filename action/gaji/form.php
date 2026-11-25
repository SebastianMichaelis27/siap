<?php
 include("../bjksadkhrej121lkjkjk.php");
 $list_karyawan = '<option></option>';
 $execute = $koneksi->prepare("select * from karyawan order by nama asc");
 $execute->execute();
 $result = $execute->get_result();
 while($row = $result->fetch_assoc())
  { $list_karyawan .= '<option value="'.$row['id'].'">'.$row['nama'].'</option>';
  }
?>
<style>
 #list-pencarian
  { display : grid;
    grid-template-columns : 1fr;
    gap : 20px;
    margin-top : 10px;
  }
 .list-urutan
  { display : grid;
    grid-template-columns : 1fr 60px 30px;
    gap : 10px;
    margin-top : 10px;
  }
 label
  { user-select : none;
  }
 .title
  { font-weight : bold;
    padding-bottom : 10px;
    text-align : center;
  }
 .div-absensi
  { display : grid;
    grid-template-columns : repeat(10, auto);
    gap : 10px;
  }
 .div-absensi .form-input input[type="text"], .div-absensi .form-input input[type="password"], .div-absensi .custom-select input[type="text"], .div-absensi .default-input input[type="text"], .div-absensi .default-input input[type="password"], .div-absensi .custom-select input[type="text"]
  { width : 45px;
  }
 @media only screen and (max-width : 883px)
  { .div-absensi
     { grid-template-columns : repeat(8, auto);
     }
  }
 @media only screen and (max-width : 755px)
  { .div-absensi
     { grid-template-columns : repeat(6, auto);
     }
  }
 @media only screen and (max-width : 605px)
  { .div-absensi
     { grid-template-columns : repeat(4, auto);
     }
  }
 @media only screen and (max-width : 336px)
  { .div-absensi
     { grid-template-columns : repeat(2, auto);
     }
  }
 @media only screen and (max-width : 198px)
  { .div-absensi
     { grid-template-columns : repeat(1, auto);
     }
  }
</style>

<div class="box">
 <div class="deretan-button">
  <div style="display:inline-block;">
   <div style="display:grid; grid-template-columns:auto auto auto auto auto; gap:5px; align-items:center;">
    <button type="button" class="btn-default" onclick="previousPage();">&nbsp;&laquo;&nbsp;</button>
    <input type="text" class="input-halaman" onkeypress="return hanyaAngka(this);" id="txthalaman" value="1" onfocusout="goToPage(this);">
    <div>/</div>
    <div id="max-page">1</div>
    <button type="button" class="btn-default" onclick="nextPage();">&nbsp;&raquo;&nbsp;</button>
   </div>
  </div>
  <button type="button" class="btn-default" onclick="segarkan();">Segarkan <i class="fas fa-sync-alt"></i></button>
  <button type="button" class="btn-default btn-pencarian" onclick="pencarian();">Cari <i class="fas fa-search"></i></button>
  <button type="button" class="btn-default btn-urutan" onclick="setUrutan();">Urutkan <i class="fas fa-sort-amount-down-alt"></i></button>
  <button type="button" class="btn-default" onclick="tambahData();">Tambah <i class="fas fa-plus"></i></button>
 </div>
 <div class="allow-scroll-x" id="div-result"></div>
</div>

<input type="hidden" id="edit-id">

<div class="modal" id="popUpInput">
 <div class="modal-dialog">
  <div class="modal-content" style="max-width:900px;">
   <div class="modal-header">
    <div class="modal-title">Tambah Data</div>
    <div class="close" onclick="hideModal('popUpInput');">&times</div>
   </div>
   <div class="modal-body">
    <div class="group-border">
     <div class="title">Data Karyawan</div>
     <div class="dua-kolom">
      <div class="form-input">
       <b>Karyawan *</b>
       <div>
        <select class="field-input" onchange="changeKaryawan();" id="karyawan_id">
         <?= $list_karyawan ?>
        </select>
        <div class="error-input"></div>
       </div>
       <b>Jabatan</b>
       <div>
        <input type="text" class="field-input" autocomplete="new-password" readonly id="jabatan">
        <div class="error-input"></div>
       </div>
      </div>
      <div class="form-input">
       <b>Tanggal *</b>
       <div>
        <input type="text" class="field-input" required autocomplete="new-password" id="tanggal">
        <div class="error-input"></div>
       </div>
       <b>Periode *</b>
       <div>
        <div style="display:grid; grid-template-columns:1fr auto 1fr; gap:10px; align-items:center;">
         <div>
          <input type="text" class="field-input" required autocomplete="new-password" onchange="getAbsensi();" id="dari">
          <div class="error-input"></div>
         </div>
         <div>s/d</div>
         <div>
          <input type="text" class="field-input" required autocomplete="new-password" onchange="getAbsensi();" id="sampai">
          <div class="error-input"></div>
         </div>
        </div>
       </div>
      </div>
     </div>
    </div>

    <div class="group-border">
     <div class="title">Data Absensi</div>
     <div class="div-absensi default-input">
      <b>Hadir *</b>
      <div>
       <input type="text" class="field-input" autocomplete="new-password" onkeypress="return hanyaAngka(this);" onkeyup="changeHadir();" onkeyup="changeHadir();" onfocus="this.select();" required id="hadir">
       <div class="error-input"></div>
      </div>
      <b>Absen *</b>
      <div>
       <input type="text" class="field-input" autocomplete="new-password" onkeypress="return hanyaAngka(this);" onkeyup="changeAbsen();" onkeyup="changeAbsen();" onfocus="this.select();" required id="absen">
       <div class="error-input"></div>
      </div>
      <b>Izin Cuti *</b>
      <div>
       <input type="text" class="field-input" autocomplete="new-password" onkeypress="return hanyaAngka(this);" onkeyup="fnomor(this);" onkeyup="fnomor(this);" onfocus="this.select();" required id="izin_cuti">
       <div class="error-input"></div>
      </div>
      <b>Izin Sakit *</b>
      <div>
       <input type="text" class="field-input" autocomplete="new-password" onkeypress="return hanyaAngka(this);" onkeyup="fnomor(this);" onkeyup="fnomor(this);" onfocus="this.select();" required id="izin_sakit">
       <div class="error-input"></div>
      </div>
      <b>Izin Terlambat *</b>
      <div>
       <input type="text" class="field-input" autocomplete="new-password" onkeypress="return hanyaAngka(this);" onkeyup="fnomor(this);" onkeyup="fnomor(this);" onfocus="this.select();" required id="izin_terlambat_masuk">
       <div class="error-input"></div>
      </div>
      <b>Izin Pulang *</b>
      <div>
       <input type="text" class="field-input" autocomplete="new-password" onkeypress="return hanyaAngka(this);" onkeyup="fnomor(this);" onkeyup="fnomor(this);" onfocus="this.select();" required id="izin_pulang_sebelum_waktunya">
       <div class="error-input"></div>
      </div>
      <b>Terlambat *</b>
      <div>
       <input type="text" class="field-input" autocomplete="new-password" onkeypress="return hanyaAngka(this);" onkeyup="changeTerlambat();" onkeyup="changeTerlambat();" onfocus="this.select();" required id="terlambat_masuk">
       <div class="error-input"></div>
      </div>
      <b>Pulang Duluan *</b>
      <div>
       <input type="text" class="field-input" autocomplete="new-password" onkeypress="return hanyaAngka(this);" onkeyup="changePulangDeluan();" onkeyup="changePulangDeluan();" onfocus="this.select();" required id="pulang_sebelum_waktunya">
       <div class="error-input"></div>
      </div>
      <b>Tidak Absen Masuk *</b>
      <div>
       <input type="text" class="field-input" autocomplete="new-password" onkeypress="return hanyaAngka(this);" onkeyup="changeTidakAbsenMasuk();" onkeyup="changeTidakAbsenMasuk();" onfocus="this.select();" required id="tidak_absen_masuk">
       <div class="error-input"></div>
      </div>
      <b>Tidak Absen Pulang *</b>
      <div>
       <input type="text" class="field-input" autocomplete="new-password" onkeypress="return hanyaAngka(this);" onkeyup="changeTidakAbsenPulang();" onkeyup="changeTidakAbsenPulang();" onfocus="this.select();" required id="tidak_absen_pulang">
       <div class="error-input"></div>
      </div>
     </div>
    </div>

    <div class="group-border">
     <div class="title">Pendapatan</div>
     <div class="dua-kolom">
      <div class="form-input">
       <b>Gaji Pokok</b>
       <div>
        <input type="text" class="field-input" autocomplete="new-password" onkeypress="return hanyaAngka(this);" onkeyup="changePendapatan(this);" onkeyup="changePendapatan(this);" onfocus="this.select();" style="text-align:right;" id="gaji_pokok">
        <div class="error-input"></div>
       </div>
       <b>Uang Makan <small>(<span id="uang_makan_per_hari">0</span> × <span id="jlh_uang_makan">0</span>)</small></b>
       <div>
        <input type="text" class="field-input" autocomplete="new-password" onkeypress="return hanyaAngka(this);" onkeyup="changePendapatan(this);" onkeyup="changePendapatan(this);" onfocus="this.select();" style="text-align:right;" id="uang_makan">
        <div class="error-input"></div>
       </div>
       <b>Uang Lembur</b>
       <div>
        <input type="text" class="field-input" autocomplete="new-password" onkeypress="return hanyaAngka(this);" onkeyup="changePendapatan(this);" onkeyup="changePendapatan(this);" onfocus="this.select();" style="text-align:right;" id="uang_lembur">
        <div class="error-input"></div>
       </div>
      </div>
      <div class="form-input">
       <b>Bonus</b>
       <div>
        <input type="text" class="field-input" autocomplete="new-password" onkeypress="return hanyaAngka(this);" onkeyup="changePendapatan(this);" onkeyup="changePendapatan(this);" onfocus="this.select();" style="text-align:right;" id="bonus">
        <div class="error-input"></div>
       </div>
       <b>THR</b>
       <div>
        <input type="text" class="field-input" autocomplete="new-password" onkeypress="return hanyaAngka(this);" onkeyup="changePendapatan(this);" onkeyup="changePendapatan(this);" onfocus="this.select();" style="text-align:right;" id="tunjangan_hari_raya">
        <div class="error-input"></div>
       </div>
       <b>Total Pendapatan</b>
       <div>
        <input type="text" class="field-input" autocomplete="new-password" readonly style="text-align:right;" onkeypress="return hanyaAngka(this);" id="total_pendapatan">
        <div class="error-input"></div>
       </div>
      </div>
     </div>
    </div>

    <div class="group-border">
     <div class="title">Potongan & Total Gaji</div>
     <div class="dua-kolom">
      <div class="form-input">
       <b>Potongan Absen <small>(<span id="potongan_per_tidak_masuk">0</span> × <span id="jlh_tidak_masuk">0</span>)</small></b>
       <div>
        <input type="text" class="field-input" autocomplete="new-password" onkeypress="return hanyaAngka(this);" onkeyup="changePotongan(this);" onkeyup="changePotongan(this);" onfocus="this.select();" style="text-align:right;" id="potongan_tidak_masuk">
        <div class="error-input"></div>
       </div>
       <b>Denda Terlambat <small>(<span id="potongan_per_terlambat_masuk">0</span> × <span id="jlh_terlambat_masuk">0</span>)</small></b>
       <div>
        <input type="text" class="field-input" autocomplete="new-password" onkeypress="return hanyaAngka(this);" onkeyup="changePotongan(this);" onkeyup="changePotongan(this);" onfocus="this.select();" style="text-align:right;" id="potongan_terlambat_masuk">
        <div class="error-input"></div>
       </div>
       <b>Denda Pulang Duluan <small>(<span id="potongan_per_pulang_sebelum_waktunya">0</span> × <span id="jlh_pulang_sebelum_waktunya">0</span>)</small></b>
       <div>
        <input type="text" class="field-input" autocomplete="new-password" onkeypress="return hanyaAngka(this);" onkeyup="changePotongan(this);" onkeyup="changePotongan(this);" onfocus="this.select();" style="text-align:right;" id="potongan_pulang_sebelum_waktunya">
        <div class="error-input"></div>
       </div>
       <b>Denda Tidak Absen Masuk <small>(<span id="potongan_per_tidak_absen_masuk">0</span> × <span id="jlh_tidak_absen_masuk">0</span>)</small></b>
       <div>
        <input type="text" class="field-input" autocomplete="new-password" onkeypress="return hanyaAngka(this);" onkeyup="changePotongan(this);" onkeyup="changePotongan(this);" onfocus="this.select();" style="text-align:right;" id="potongan_tidak_absen_masuk">
        <div class="error-input"></div>
       </div>
      </div>
      <div class="form-input">
       <b>Denda Tidak Absen Pulang <small>(<span id="potongan_per_tidak_absen_pulang">0</span> × <span id="jlh_tidak_absen_pulang">0</span>)</small></b>
       <div>
        <input type="text" class="field-input" autocomplete="new-password" onkeypress="return hanyaAngka(this);" onkeyup="changePotongan(this);" onkeyup="changePotongan(this);" onfocus="this.select();" style="text-align:right;" id="potongan_tidak_absen_pulang">
        <div class="error-input"></div>
       </div>
       <b>Potongan Utang</b>
       <div>
        <input type="text" class="field-input" autocomplete="new-password" onkeypress="return hanyaAngka(this);" onkeyup="changePotongan(this);" onkeyup="changePotongan(this);" onfocus="this.select();" style="text-align:right;" id="potongan_utang">
        <div class="error-input"></div>
       </div>
       <b>Total Potongan</b>
       <div>
        <input type="text" class="field-input" autocomplete="new-password" readonly style="text-align:right;" onkeypress="return hanyaAngka(this);" id="total_potongan">
        <div class="error-input"></div>
       </div>
       <b>Total Gaji</b>
       <div>
        <input type="text" class="field-input" autocomplete="new-password" readonly style="text-align:right;" onkeypress="return hanyaAngka(this);" id="total_gaji">
        <div class="error-input"></div>
       </div>
      </div>
     </div>
    </div>

   </div>
   <div class="modal-footer">
    <button type="button" class="btn-default" onclick="hideModal('popUpInput');"><i class="fas fa-times"></i> Batal</button>
    <button type="button" class="btn-primary" onclick="validasi();"><i class="fas fa-save"></i> Simpan</button>
   </div>
  </div>
 </div>
</div>

<div class="modal" id="popUpDelete">
 <div class="modal-dialog">
  <div class="modal-content" style="max-width:500px;">
   <div class="modal-header danger">
    <div class="modal-title">Konfirmasi</div>
    <div class="close" onclick="hideModal('popUpDelete');">&times</div>
   </div>
   <div class="modal-body">
    Yakin ingin menghapus data ini?
   </div>
   <div class="modal-footer">
    <button type="button" class="btn-default" onclick="hideModal('popUpDelete');"><i class="fas fa-times"></i> Tidak</button>
    <button type="button" class="btn-danger" onclick="hapus();"><i class="fas fa-trash"></i> Hapus</button>
   </div>
  </div>
 </div>
</div>

<div class="modal" id="popUpPencarian">
 <div class="modal-dialog">
  <div class="modal-content" style="max-width:600px;">
   <div class="modal-header success">
    <div class="modal-title">Pencarian</div>
    <div class="close">&times</div>
   </div>
   <div class="modal-body">
    <div id="form-pencarian">
     <button type="button" class="btn-default" onclick="setPopUpPencarian('tambah');">Tambah Field Pencarian <i class="fas fa-plus"></i></button>
     <div id="list-pencarian"></div>
    </div>
    <div id="form-tambah-pencarian">
     <div class="form-input">
      <b>Field Pencarian</b>
      <div>
       <select id="field_pencarian" onchange="changeFieldPencarian();">
        <option></option>
       </select>
       <div class="error-pencarian"></div>
      </div>
      <b>Jenis Pencarian</b>
      <div>
       <select id="jenis_pencarian">
        <option></option>
        <option value="mirip">Mirip</option>
        <option value="sama">Sama Persis</option>
        <option value="berisi">Berisi / Tidak Berisi</option>
       </select>
       <div class="error-pencarian"></div>
      </div>
     </div>
    </div>
    <textarea id="saved-pencarian" class="hide"></textarea>
   </div>
   <div class="modal-footer">
    <button type="button" class="btn-default"><i class="fas fa-times"></i> Batal</button>
    <button type="button" class="btn-success"><i class="fas fa-search"></i> Cari</button>
   </div>
  </div>
 </div>
</div>

<div class="modal" id="popUpUrutkan">
 <div class="modal-dialog">
  <div class="modal-content" style="max-width:500px;">
   <div class="modal-header brown">
    <div class="modal-title">Urutkan</div>
    <div class="close" onclick="hideModal('popUpUrutkan');">&times</div>
   </div>
   <div class="modal-body">
    <button type="button" class="btn-default" onclick="tambahUrutan();">Tambah Field Urutan <i class="fas fa-plus"></i></button>
    <div id="list-urutan"></div>
    <textarea id="saved-urutan" class="hide"></textarea>
   </div>
   <div class="modal-footer">
    <button type="button" class="btn-default" onclick="hideModal('popUpUrutkan');"><i class="fas fa-times"></i> Batal</button>
    <button type="button" class="btn-brown" onclick="urutkan();"><i class="fas fa-sort-amount-down-alt"></i> Urutkan</button>
   </div>
  </div>
 </div>
</div>

<div class="modal" id="popUpCetak">
 <div class="modal-dialog">
  <div class="modal-content" style="max-width:900px;">
   <div class="modal-header danger">
    <div class="modal-title">Cetak Slip Gaji</div>
    <div class="close" onclick="hideModal('popUpCetak');">&times</div>
   </div>
   <div class="modal-body">
    <iframe style="width:100%; aspect-ratio:210/297; border:none; display:block;" id="slip-gaji"></iframe>
   </div>
   <div class="modal-footer">
    <button type="button" class="btn-default" onclick="hideModal('popUpCetak');"><i class="fas fa-times"></i> Tutup</button>
   </div>
  </div>
 </div>
</div>

<script type="text/javascript">

 var Nama_Tabel = 'gaji';
 var maxRecord = 20;
 var FieldTidakBolehRangkap = {};
 var is_edit = 0;

 var a = document.querySelectorAll('.field-input');
 for(var i=0; i<a.length; i++)
  { var parent = a[i].parentNode;
    if(a[i].parentNode.classList.contains('custom-select') || a[i].parentNode.classList.contains('multiple-select'))
     { parent = a[i].parentNode.parentNode;
     }
    else if(a[i].parentNode.classList.contains('box-input-calender'))
     { parent = a[i].parentNode.parentNode.parentNode;
     }
    if(a[i].id !== 'dari' && a[i].id !== 'sampai')
     { document.querySelector("#field_pencarian").innerHTML += '<option value="' + a[i].id + '">' + parent.previousElementSibling.textContent.toString().replaceAll('*', '').trim() + '</option>';
     }
  }

 setSelectChosen(document.querySelector("#field_pencarian"));
 setSelectChosen(document.querySelector("#jenis_pencarian"));
 setSelectChosen(document.querySelector("#karyawan_id"), '');
 setInputHalaman(document.querySelector("#txthalaman"));
 setDatePicker(document.querySelector("#tanggal"), false);
 setDatePicker(document.querySelector("#dari"));
 setDatePicker(document.querySelector("#sampai"));

 function tampil()
  { if(document.getElementById('saved-pencarian').value == '' || document.getElementById('saved-pencarian').value == '[]')
     { document.querySelector('.btn-pencarian').className = 'btn-default btn-pencarian';
     }
    else
     { document.querySelector('.btn-pencarian').className = 'btn-success btn-pencarian';
     }
    if(document.getElementById('saved-urutan').value == '' || document.getElementById('saved-urutan').value == '[]')
     { document.querySelector('.btn-urutan').className = 'btn-default btn-urutan';
     }
    else
     { document.querySelector('.btn-urutan').className = 'btn-brown btn-urutan';
     }
    var format_khusus = {};
    var a = document.querySelectorAll('.field-input');
    for(var i=0; i<a.length; i++)
     { if(a[i].parentNode.classList.contains('box-input-calender'))
        { format_khusus[a[i].id] = 'tanggal';
        }
       else if(a[i].onkeypress)
        { if(a[i].onkeypress.toString().includes('hanyaAngka'))
           { format_khusus[a[i].id] = 'nomor';
           }
        }
     }
    var formdata = new FormData();
    formdata.append('user_id', document.querySelector('.user-id').value);
    formdata.append('username', document.querySelector('.user-name').value);
    formdata.append('token', document.querySelector('.user-token').value);
    formdata.append('users_level_id', document.querySelector('.user-level_id').value);
    formdata.append('cabang_id', document.querySelector('.user-cabang_id').value);
    formdata.append('halaman', document.querySelector('#txthalaman').value);
    formdata.append('Nama_Tabel', Nama_Tabel);
    formdata.append('maxRecord', maxRecord);
    formdata.append('cari', document.getElementById('saved-pencarian').value);
    formdata.append('urutan', document.getElementById('saved-urutan').value);
    Object.entries(format_khusus).forEach(function([index, item]) {
     formdata.append('format_khusus[' + index + ']', item);
    });
    var ajax = new XMLHttpRequest();
    ajax.addEventListener('load', responseTampil, false);
    ajax.open('POST', '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/tampil.php', true);
    ajax.send(formdata);
  }

 function responseTampil()
  { document.getElementsByClassName('loader')[0].style['display'] = 'none';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'none';
    document.querySelector('#div-result').innerHTML = event.srcElement.response;
    document.getElementById('max-page').innerHTML = document.getElementById('nhalaman').value;
    document.getElementById('txthalaman').value = document.getElementById('halaman').value;
  }

 function nextPage()
  { var hal = document.getElementById('txthalaman').value * 1;
    hal++;
    document.getElementById('txthalaman').value = hal;
    tampil();
  }

 function previousPage()
  { var hal = document.getElementById('txthalaman').value * 1;
    hal--;
    document.getElementById('txthalaman').value = hal;
    tampil();
  }

 function goToPage(element)
  { document.getElementById('txthalaman').value = element.value;
    tampil();
  }

 tampil();

 function clear()
  { document.getElementById('edit-id').value = "";
    var a = document.querySelectorAll('.field-input');
    for(var i=0; i<a.length; i++)
     { a[i].value = '';
       if(a[i].parentNode.classList.contains('custom-select'))
        { setSelectChosen(a[i]);
        }
     }
    var a = document.querySelectorAll('.error-input');
    for(var i=0; i<a.length; i++)
     { a[i].innerHTML = '';
     }
    var a = document.querySelectorAll('.error');
    for(var i=0; i<a.length; i++)
     { a[i].remove();
     }
    var a = document.querySelectorAll('#popUpInput .clear-calender');
    for(var i=0; i<a.length; i++)
     { a[i].click();
     }
    document.getElementById('uang_makan_per_hari').innerHTML = '0';
    document.getElementById('jlh_uang_makan').innerHTML = '0';
    document.getElementById('potongan_per_tidak_masuk').innerHTML = '0';
    document.getElementById('jlh_tidak_masuk').innerHTML = '0';
    document.getElementById('potongan_per_terlambat_masuk').innerHTML = '0';
    document.getElementById('jlh_terlambat_masuk').innerHTML = '0';
    document.getElementById('potongan_per_pulang_sebelum_waktunya').innerHTML = '0';
    document.getElementById('jlh_pulang_sebelum_waktunya').innerHTML = '0';
    document.getElementById('potongan_per_tidak_absen_masuk').innerHTML = '0';
    document.getElementById('jlh_tidak_absen_masuk').innerHTML = '0';
    document.getElementById('potongan_per_tidak_absen_pulang').innerHTML = '0';
    document.getElementById('jlh_tidak_absen_pulang').innerHTML = '0';
  }

 function pencarian()
  { document.getElementById('list-pencarian').innerHTML = '';
    var data = [];
    try
     { data = JSON.parse(document.getElementById('saved-pencarian').value);
       for(var i=0; i<data.length; i++)
        { var label_field_pencarian = data[i].label_field_pencarian;
          var field_pencarian = data[i].field_pencarian;
          var label_jenis_pencarian = data[i].label_jenis_pencarian;
          var jenis_pencarian = data[i].jenis_pencarian;
          var value_pencarian = data[i].value_pencarian;
          var value_pencarian2 = data[i].value_pencarian2;
          tambahPencarian(label_field_pencarian, field_pencarian, label_jenis_pencarian, jenis_pencarian, value_pencarian, value_pencarian2);
        }
     }
    catch(err) {}
    setTimeout(function() { setPopUpPencarian('cari'); }, 0);
  }

 function setPopUpPencarian(jenis)
  { if(jenis == "cari")
     { document.getElementById('form-pencarian').style['display'] = 'block';
       document.getElementById('form-tambah-pencarian').style['display'] = 'none';
       document.querySelector('#popUpPencarian .modal-header .close').setAttribute("onclick", "hideModal('popUpPencarian');");
       document.querySelector('#popUpPencarian .modal-footer .btn-default').setAttribute("onclick", "hideModal('popUpPencarian');");
       document.querySelector('#popUpPencarian .modal-footer .btn-success').innerHTML = '<i class="fas fa-search"></i> Cari';
       document.querySelector('#popUpPencarian .modal-footer .btn-success').setAttribute("onclick", "cari();");
     }
    if(jenis == "tambah")
     { clearSelectChosen(document.querySelector("#field_pencarian"));
       clearSelectChosen(document.querySelector("#jenis_pencarian"));
       document.getElementById('form-pencarian').style['display'] = 'none';
       var a = document.querySelectorAll('.error-pencarian');
       for(var i=0; i<a.length; i++)
        { a[i].innerHTML = '';
        }
       document.getElementById('form-tambah-pencarian').style['display'] = 'block';
       document.querySelector('#popUpPencarian .modal-header .close').setAttribute("onclick", "setPopUpPencarian('cari');");
       document.querySelector('#popUpPencarian .modal-footer .btn-default').setAttribute("onclick", "setPopUpPencarian('cari');");
       document.querySelector('#popUpPencarian .modal-footer .btn-success').innerHTML = '<i class="fas fa-plus"></i> Tambahkan';
       document.querySelector('#popUpPencarian .modal-footer .btn-success').setAttribute("onclick", "validasiTambahPencarian();");
     }
    showModal('popUpPencarian');
  }

 function changeFieldPencarian()
  { if(document.getElementById(document.getElementById('field_pencarian').value).parentNode.classList.contains('custom-select'))
     { document.getElementById('jenis_pencarian').innerHTML = `
        <option></option>
        <option value="sama" selected>Sama Persis</option>
        <option value="berisi">Berisi / Tidak Berisi</option>
       `;
     }
    else if(document.getElementById(document.getElementById('field_pencarian').value).parentNode.classList.contains('box-input-calender'))
     { document.getElementById('jenis_pencarian').innerHTML = `
        <option></option>
        <option value="periode">Periode</option>
        <option value="berisi">Berisi / Tidak Berisi</option>
       `;
     }
    else if(document.getElementById(document.getElementById('field_pencarian').value).onkeypress)
     { if(document.getElementById(document.getElementById('field_pencarian').value).onkeypress.toString().includes('hanyaAngka'))
        { document.getElementById('jenis_pencarian').innerHTML = `
           <option></option>
           <option value="jangkauan">Jangkauan</option>
           <option value="berisi">Berisi / Tidak Berisi</option>
          `;
        }
     }
    else
     { document.getElementById('jenis_pencarian').innerHTML = `
        <option></option>
        <option value="mirip">Mirip</option>
        <option value="sama">Sama Persis</option>
        <option value="berisi">Berisi / Tidak Berisi</option>
       `;
     }
    setSelectChosen(document.querySelector("#jenis_pencarian"));
  }

 function validasiTambahPencarian()
  { var a = document.querySelectorAll('.error-pencarian');
    for(var i=0; i<a.length; i++)
     { a[i].innerHTML = '';
     }
    var error = 0;
    if(document.getElementById('field_pencarian').value == '')
     { error++;
       document.getElementById('field_pencarian').parentNode.parentNode.querySelector('.error-pencarian').innerHTML = 'Wajib diisi!';
     }
    if(document.getElementById('jenis_pencarian').value == '')
     { error++;
       document.getElementById('jenis_pencarian').parentNode.parentNode.querySelector('.error-pencarian').innerHTML = 'Wajib diisi!';
     }
    if(error == 0)
     { tambahPencarian(getTextSelected(document.getElementById('field_pencarian')), document.getElementById('field_pencarian').value, getTextSelected(document.getElementById('jenis_pencarian')), document.getElementById('jenis_pencarian').value);
       setPopUpPencarian('cari');
     }
  }

 function tambahPencarian(label_field_pencarian, field_pencarian, label_jenis_pencarian, jenis_pencarian, value_pencarian = '', value_pencarian2 = '')
  { var cek = document.querySelectorAll('.pencarian-' + field_pencarian);
    var input = '<input type="text" class="value-pencarian" value="' + value_pencarian + '">';
    if(jenis_pencarian == 'berisi')
     { var select_berisi = '';
       var select_tidak_berisi = '';
       if(value_pencarian == 'berisi')
        { select_berisi = ' selected';
        }
       else if(value_pencarian == 'tidak_berisi')
        { select_tidak_berisi = ' selected';
        }
       input = `<select class="value-pencarian">
                 <option></option>
                 <option value='berisi'` + select_berisi + `>Berisi</option>
                 <option value='tidak_berisi'` + select_tidak_berisi + `>Tidak Berisi</option>
                </select>`;
     }
    else if(document.getElementById(field_pencarian).parentNode.classList.contains('custom-select'))
     { input = `<select class="value-pencarian">` + document.getElementById(document.getElementById('field_pencarian').value).innerHTML + `</select>`;
     }
    else if(document.getElementById(field_pencarian).parentNode.classList.contains('box-input-calender'))
     { input = `<div style="display:grid; grid-template-columns:1fr auto 1fr; gap:5px; align-items:center;">
                 <input type="text" class="value-pencarian" value="` + value_pencarian + `">
                 <div>s/d</div>
                 <input type="text" class="value-pencarian2" value="` + value_pencarian2 + `">
                </div>`;
     }
    else if(document.getElementById(field_pencarian).onkeypress)
     { if(document.getElementById(field_pencarian).onkeypress.toString().includes('hanyaAngka'))
        { if(value_pencarian !== '')
           { value_pencarian = formatnomor2(value_pencarian.toString().replaceAll('.', ','));
           }
          if(value_pencarian2 !== '')
           { value_pencarian2 = formatnomor2(value_pencarian2.toString().replaceAll('.', ','));
           }
          input = `<div style="display:grid; grid-template-columns:1fr auto 1fr; gap:5px; align-items:center;">
                    <input type="text" class="value-pencarian" value="` + value_pencarian + `" onkeypress="return hanyaAngka(this);" onkeyup="fnomor(this);" onchange="fnomor(this);" onfocus="this.select();" onfocusout="fnomor2(this);">
                    <div>s/d</div>
                    <input type="text" class="value-pencarian2" value="` + value_pencarian2 + `" onkeypress="return hanyaAngka(this);" onkeyup="fnomor(this);" onchange="fnomor(this);" onfocus="this.select();" onfocusout="fnomor2(this);">
                   </div>`;
        }
     }

    var isi = `<b style="width:140px;">
                <div class="label-jenis_pencarian">` + label_jenis_pencarian + `</div>
                <textarea class="label-field_pencarian" style="display:none">` + label_field_pencarian + `</textarea>
                <textarea class="field-pencarian" style="display:none">` + field_pencarian + `</textarea>
                <textarea class="jenis-pencarian" style="display:none">` + jenis_pencarian + `</textarea>
               </b>
               <div class="dua-kolom right-auto">
                ` + input + `
                <button type="button" class="btn-default" onclick="removePencarian(this);"><i class="fas fa-trash"></i></button>
               </div>`;

    var new_element = null;
    if(cek.length < 1)
     { var new_element = document.createElement('div');
       new_element.className = 'group-border pencarian-' + field_pencarian;
       new_element.innerHTML = `
        <div class="title">` + label_field_pencarian + `</div>
        <div class="form-input">` + isi + `</div>
       `;
       document.getElementById('list-pencarian').appendChild(new_element);
     }
    else
     { var new_element = document.createElement('div');
       new_element.innerHTML = isi;
       while(new_element.firstElementChild)
        { cek[0].querySelector('.form-input').appendChild(new_element.firstElementChild);
        }
     }
     
    if(jenis_pencarian == 'berisi')
     { setSelectChosen(document.querySelectorAll('.value-pencarian')[document.querySelectorAll('.value-pencarian').length - 1]);
     }
    else if(document.getElementById(field_pencarian).parentNode.classList.contains('custom-select'))
     { document.querySelectorAll('.value-pencarian')[document.querySelectorAll('.value-pencarian').length - 1].value = value_pencarian;
       setSelectChosen(document.querySelectorAll('.value-pencarian')[document.querySelectorAll('.value-pencarian').length - 1]);
     }
    else if(document.getElementById(field_pencarian).parentNode.classList.contains('box-input-calender'))
     { setDatePicker(document.querySelectorAll('.value-pencarian')[document.querySelectorAll('.value-pencarian').length - 1]);
       setDatePicker(document.querySelectorAll('.value-pencarian2')[document.querySelectorAll('.value-pencarian2').length - 1]);
     }
    
  }

 function removePencarian(element)
  { var parent = element.parentNode.parentNode;
    element.parentNode.previousElementSibling.remove();
    element.parentNode.remove();
    setTimeout(function(){
     if(parent.children.length < 1)
      { parent.parentNode.remove();
      }
    }, 0);
  }

 function cari()
  { document.getElementById('saved-pencarian').value = '';
    var data = [];
    var a = document.querySelectorAll('.field-pencarian');
    for(var i=0; i<a.length; i++)
     { if(document.querySelectorAll('.value-pencarian')[i].value !== '')
        { var valueToPush = {};
          valueToPush.label_field_pencarian = document.querySelectorAll('.label-field_pencarian')[i].value;
          valueToPush.field_pencarian = document.querySelectorAll('.field-pencarian')[i].value;
          valueToPush.label_jenis_pencarian = document.querySelectorAll('.label-jenis_pencarian')[i].textContent;
          valueToPush.jenis_pencarian = document.querySelectorAll('.jenis-pencarian')[i].value;
          valueToPush.value_pencarian = document.querySelectorAll('.value-pencarian')[i].value;
          valueToPush.value_pencarian2 = valueToPush.value_pencarian;
          if(document.querySelectorAll('.value-pencarian')[i].parentNode.parentNode.parentNode.querySelectorAll('.value-pencarian2').length > 0 && document.querySelectorAll('.value-pencarian')[i].parentNode.parentNode.parentNode.querySelector('.value-pencarian2').value !== '')
           { valueToPush.value_pencarian2 = document.querySelectorAll('.value-pencarian')[i].parentNode.parentNode.parentNode.querySelector('.value-pencarian2').value;
           }

          if(valueToPush.jenis_pencarian == 'jangkauan' && document.getElementById(document.querySelectorAll('.field-pencarian')[i].value).onkeypress)
           { if(document.getElementById(document.querySelectorAll('.field-pencarian')[i].value).onkeypress.toString().includes('hanyaAngka'))
              { valueToPush.value_pencarian = normal(valueToPush.value_pencarian) * 1;
                valueToPush.value_pencarian2 = normal(valueToPush.value_pencarian2) * 1;
              }
           }
          data.push(valueToPush);
        }
     }
    document.getElementById('saved-pencarian').value = JSON.stringify(data);
    document.getElementsByClassName('loader')[0].style['display'] = 'block';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'block';
    tampil();
    hideModal('popUpPencarian');
  }

 function segarkan()
  { document.getElementById('saved-pencarian').value = '';
    document.getElementById('saved-urutan').value = '';
    document.getElementsByClassName('loader')[0].style['display'] = 'block';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'block';
    tampil();
  }

 function setUrutan()
  { document.getElementById('list-urutan').innerHTML = '';
    try
     { var data = JSON.parse(document.getElementById('saved-urutan').value);
       for(var i=0; i<data.length; i++)
        { var field_selected = data[i].field_urutan;
          var jenis_selected = data[i].jenis_urutan;
          tambahUrutan(field_selected, jenis_selected);
        }
     }
    catch(err) {}
    showModal('popUpUrutkan');
  }

 function tambahUrutan(field_selected = '', jenis_selected = '')
  { var list_urutan = '<option></option>';
    var a = document.querySelectorAll('.field-input');
    for(var i=0; i<a.length; i++)
     { var parent = a[i].parentNode;
       if(a[i].parentNode.classList.contains('custom-select') || a[i].parentNode.classList.contains('multiple-select'))
        { parent = a[i].parentNode.parentNode;
        }
       else if(a[i].parentNode.classList.contains('box-input-calender'))
        { parent = a[i].parentNode.parentNode.parentNode;
        }
       list_urutan += '<option value="' + a[i].id + '">' + parent.previousElementSibling.textContent.toString().replaceAll('*', '').trim() + '</option>';
     }
    var new_element = document.createElement('div');
    new_element.className = 'list-urutan';
    new_element.innerHTML = `<select class="field-urutan">` + list_urutan + `</select>
                             <select class="jenis-urutan">
                              <option></option>
                              <option value='az'>AZ</option>
                              <option value='za'>ZA</option>
                             </select>
                             <button type="button" class="btn-default" onclick="removeUrutan(this);"><i class="far fa-trash-alt"></i></button>`;
    document.getElementById('list-urutan').appendChild(new_element);
    document.querySelectorAll('.field-urutan')[document.querySelectorAll('.field-urutan').length - 1].value = field_selected;
    document.querySelectorAll('.jenis-urutan')[document.querySelectorAll('.jenis-urutan').length - 1].value = jenis_selected;
    setSelectChosen(document.querySelectorAll('.field-urutan')[document.querySelectorAll('.field-urutan').length - 1]);
    setSelectChosen(document.querySelectorAll('.jenis-urutan')[document.querySelectorAll('.jenis-urutan').length - 1]);
  }

 function removeUrutan(element)
  { element.parentNode.remove();
  }

 function urutkan()
  { document.getElementById('saved-urutan').value = '';
    var data_urutan = [];
    var a = document.querySelectorAll('select.field-urutan');
    for(var i=0; i<a.length; i++)
     { if(document.querySelectorAll('select.field-urutan')[i].value !== '' && document.querySelectorAll('select.jenis-urutan')[i].value !== '')
        { var valueToPush = {};
          valueToPush.field_urutan = document.querySelectorAll('select.field-urutan')[i].value;
          valueToPush.jenis_urutan = document.querySelectorAll('select.jenis-urutan')[i].value;
          data_urutan.push(valueToPush);
        }
     }
    document.getElementById('saved-urutan').value = JSON.stringify(data_urutan);
    document.getElementsByClassName('loader')[0].style['display'] = 'block';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'block';
    tampil();
    hideModal('popUpUrutkan');
  }

 function tambahData()
  { clear();
    document.querySelector('#popUpInput .modal-title').innerHTML = 'Tambah Data';
    document.querySelector('#popUpInput .modal-footer .btn-default').innerHTML = '<i class="fas fa-times"></i> Batal';
    document.querySelector('#popUpInput .modal-footer .btn-primary').style['display'] = 'inline-block';
    showModal('popUpInput');
  }

 function validasi()
  { var a = document.querySelectorAll('.error');
    for(var i=0; i<a.length; i++)
     { a[i].remove();
     }
    var data = {};
    var error = 0;
    var a = document.querySelectorAll('.field-input');
    for(var i=0; i<a.length; i++)
     { var parent = a[i].parentNode;
       if(a[i].parentNode.classList.contains('custom-select') || a[i].parentNode.classList.contains('multiple-select'))
        { parent = a[i].parentNode.parentNode;
        }
       else if(a[i].parentNode.classList.contains('box-input-calender'))
        { parent = a[i].parentNode.parentNode.parentNode;
        }
       parent.querySelector('.error-input').innerHTML = '';
       if(a[i].required == true && a[i].value == '')
        { error++;
          parent.querySelector('.error-input').innerHTML = 'Wajib diisi!';
        }
       if(a[i].id !== '' && a[i].value !== '')
        { if(a[i].parentNode.classList.contains('box-input-calender'))
           { data[a[i].id] = normalisasi_tanggal(a[i].value);
           }
          else if(a[i].onkeypress)
           { if(a[i].onkeypress.toString().includes('hanyaAngka'))
              { data[a[i].id] = normal(a[i].value) * 1;
              }
             else
              { data[a[i].id] = a[i].value;
              }
           }
          else
           { data[a[i].id] = a[i].value;
           }
        }
       else
        { data[a[i].id] = null;
        }
     }

    data['uang_makan_per_hari'] = normal(document.getElementById('uang_makan_per_hari').textContent) * 1;
    data['potongan_per_tidak_masuk'] = normal(document.getElementById('potongan_per_tidak_masuk').textContent) * 1;
    data['potongan_per_terlambat_masuk'] = normal(document.getElementById('potongan_per_terlambat_masuk').textContent) * 1;
    data['potongan_per_pulang_sebelum_waktunya'] = normal(document.getElementById('potongan_per_pulang_sebelum_waktunya').textContent) * 1;
    data['potongan_per_tidak_absen_masuk'] = normal(document.getElementById('potongan_per_tidak_absen_masuk').textContent) * 1;
    data['potongan_per_tidak_absen_pulang'] = normal(document.getElementById('potongan_per_tidak_absen_pulang').textContent) * 1;

    Object.entries(FieldTidakBolehRangkap).forEach(([key, value]) => {
     FieldTidakBolehRangkap[key] = document.getElementById(key).value;
    });
    if(error == 0)
     { simpan(data, FieldTidakBolehRangkap);
     }
  }

 function simpan(data, DataTidakBolehRangkap)
  { document.getElementsByClassName('loader')[0].style['display'] = 'block';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'block';
    if(document.getElementById('edit-id').value == '')
     { var formdata = new FormData();
       formdata.append('user_id', document.querySelector('.user-id').value);
       formdata.append('username', document.querySelector('.user-name').value);
       formdata.append('token', document.querySelector('.user-token').value);
       formdata.append('users_level_id', document.querySelector('.user-level_id').value);
       formdata.append('cabang_id', document.querySelector('.user-cabang_id').value);
       formdata.append('Nama_Tabel', Nama_Tabel);
       Object.entries(DataTidakBolehRangkap).forEach(function([index, item]) {
        formdata.append('DataTidakBolehRangkap[' + index + ']', item);
       });
       Object.entries(data).forEach(function([index, item]) {
        formdata.append('data[' + index + ']', item);
       });
       var ajax = new XMLHttpRequest();
       ajax.addEventListener('load', responseSimpan, false);
       ajax.open('POST', '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/simpan.php');
       ajax.send(formdata);
     }
    else
     { var formdata = new FormData();
       formdata.append('user_id', document.querySelector('.user-id').value);
       formdata.append('username', document.querySelector('.user-name').value);
       formdata.append('token', document.querySelector('.user-token').value);
       formdata.append('users_level_id', document.querySelector('.user-level_id').value);
       formdata.append('cabang_id', document.querySelector('.user-cabang_id').value);
       formdata.append('Nama_Tabel', Nama_Tabel);
       Object.entries(DataTidakBolehRangkap).forEach(function([index, item]) {
        formdata.append('DataTidakBolehRangkap[' + index + ']', item);
       });
       Object.entries(data).forEach(function([index, item]) {
        formdata.append('data[' + index + ']', item);
       });
       formdata.append('id', document.getElementById('edit-id').value);
       var ajax = new XMLHttpRequest();
       ajax.addEventListener('load', responseSimpan, false);
       ajax.open('POST', '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/ubah.php');
       ajax.send(formdata);
     }
  }

 function responseSimpan()
  { document.getElementsByClassName('loader')[0].style['display'] = 'none';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'none';
    var result = document.createElement('div');
    result.innerHTML = event.srcElement.response;
    var a = result.querySelectorAll('.error');
    if(a.length > 0)
     { for(var i=0; i<a.length; i++)
        { addError(document.querySelector('#popUpInput .modal-body'), a[i].innerHTML);
        }
     }
    if(result.querySelectorAll('.success').length > 0)
     { tampil();
       hideModal('popUpInput');
       hideModal('popUpDelete');
     }
  }

 function view(element)
  { is_edit = 1;
    clear();
    var list = document.getElementsByClassName(element.className);
    list = [].slice.call(list);
    var position = list.indexOf(element);
    document.getElementById('edit-id').value = document.getElementsByClassName('textarea_edit-id')[position].value;
    var a = document.querySelectorAll('.field-input');
    for(var i=0; i<a.length; i++)
     { a[i].value = document.getElementsByClassName('textarea_edit-' + a[i].id)[position].value;
       if(a[i].parentNode.classList.contains('custom-select'))
        { setSelectChosen(a[i]);
        }
       if(a[i].parentNode.classList.contains('box-input-calender'))
        { setDatePicker(a[i]);
        }
     }
    document.querySelector('#popUpInput .modal-title').innerHTML = 'Lihat Data';
    document.querySelector('#popUpInput .modal-footer .btn-default').innerHTML = '<i class="fas fa-times"></i> Tutup';
    document.querySelector('#popUpInput .modal-footer .btn-primary').style['display'] = 'none';
    showModal('popUpInput');
    
    document.getElementById('uang_makan_per_hari').innerHTML = document.getElementsByClassName('textarea_edit-uang_makan_per_hari')[position].value;
    document.getElementById('potongan_per_tidak_masuk').innerHTML = document.getElementsByClassName('textarea_edit-potongan_per_tidak_masuk')[position].value;
    document.getElementById('potongan_per_terlambat_masuk').innerHTML = document.getElementsByClassName('textarea_edit-potongan_per_terlambat_masuk')[position].value;
    document.getElementById('potongan_per_pulang_sebelum_waktunya').innerHTML = document.getElementsByClassName('textarea_edit-potongan_per_pulang_sebelum_waktunya')[position].value;
    document.getElementById('potongan_per_tidak_absen_masuk').innerHTML = document.getElementsByClassName('textarea_edit-potongan_per_tidak_absen_masuk')[position].value;
    document.getElementById('potongan_per_tidak_absen_pulang').innerHTML = document.getElementsByClassName('textarea_edit-potongan_per_tidak_absen_pulang')[position].value;
    changeHadir();
    changeAbsen();
    changeTerlambat();
    changePulangDeluan();
    changeTidakAbsenMasuk();
    changeTidakAbsenPulang();

    is_edit = 0;
  }

 function edit(element)
  { view(element);
    document.querySelector('#popUpInput .modal-title').innerHTML = 'Ubah Data';
    document.querySelector('#popUpInput .modal-footer .btn-default').innerHTML = '<i class="fas fa-times"></i> Batal';
    document.querySelector('#popUpInput .modal-footer .btn-primary').style['display'] = 'inline-block';
  }

 function konfirmasiHapus(element)
  { var list = document.getElementsByClassName(element.className);
    list = [].slice.call(list);
    var position = list.indexOf(element);
    document.getElementById('edit-id').value = document.getElementsByClassName('textarea_edit-id')[position].value;
    showModal('popUpDelete');
  }

 function hapus()
  { document.getElementsByClassName('loader')[0].style['display'] = 'block';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'block';
    var formdata = new FormData();
    formdata.append('user_id', document.querySelector('.user-id').value);
    formdata.append('username', document.querySelector('.user-name').value);
    formdata.append('token', document.querySelector('.user-token').value);
    formdata.append('users_level_id', document.querySelector('.user-level_id').value);
    formdata.append('cabang_id', document.querySelector('.user-cabang_id').value);
    formdata.append('Nama_Tabel', Nama_Tabel);
    formdata.append('id', document.getElementById('edit-id').value);
    var ajax = new XMLHttpRequest();
    ajax.addEventListener('load', responseHapus, false);
    ajax.open('POST', '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/hapus.php');
    ajax.send(formdata);
  }

 function responseHapus()
  { document.getElementsByClassName('loader')[0].style['display'] = 'none';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'none';
    var a = document.querySelectorAll('.error');
    for(var i=0; i<a.length; i++)
     { a[i].remove();
     }
    var a = document.querySelectorAll('#popUpInput .clear-calender');
    for(var i=0; i<a.length; i++)
     { a[i].click();
     }
    var result = document.createElement('div');
    result.innerHTML = event.srcElement.response;
    var a = result.querySelectorAll('.error');
    if(a.length > 0)
     { for(var i=0; i<a.length; i++)
        { addError(document.querySelector('#popUpDelete .modal-body'), a[i].innerHTML);
        }
     }
    if(result.querySelectorAll('.success').length > 0)
     { tampil();
       hideModal('popUpDelete');
     }
  }

 function getAbsensi()
  { if(is_edit == 1)
     { return;
     }
    if(document.getElementById('dari').value !== '' && document.getElementById('sampai').value !== '' && document.getElementById('karyawan_id').value !== '')
     { document.getElementsByClassName('loader')[0].style['display'] = 'block';
       document.getElementsByClassName('loader-block')[0].style['display'] = 'block';
       var formdata = new FormData();
       formdata.append('user_id', document.querySelector('.user-id').value);
       formdata.append('username', document.querySelector('.user-name').value);
       formdata.append('token', document.querySelector('.user-token').value);
       formdata.append('users_level_id', document.querySelector('.user-level_id').value);
       formdata.append('cabang_id', document.querySelector('.user-cabang_id').value);
       formdata.append('dari', normalisasi_tanggal(document.getElementById('dari').value));
       formdata.append('sampai', normalisasi_tanggal(document.getElementById('sampai').value));
       formdata.append('karyawan_id', document.getElementById('karyawan_id').value);
       var ajax = new XMLHttpRequest();
       ajax.addEventListener('load', responseGetAbsensi, false);
       ajax.open('POST', '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/get-absensi.php');
       ajax.send(formdata);
     }
  }

 function responseGetAbsensi()
  { document.getElementsByClassName('loader')[0].style['display'] = 'none';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'none';
    var a = document.createElement('div');
    a.innerHTML = event.srcElement.response;
    document.getElementById('hadir').value = a.querySelector('#hadir').value;
    document.getElementById('absen').value = a.querySelector('#absen').value;
    document.getElementById('izin_cuti').value = a.querySelector('#izin_cuti').value;
    document.getElementById('izin_sakit').value = a.querySelector('#izin_sakit').value;
    document.getElementById('izin_terlambat_masuk').value = a.querySelector('#izin_terlambat_masuk').value;
    document.getElementById('izin_pulang_sebelum_waktunya').value = a.querySelector('#izin_pulang_sebelum_waktunya').value;
    document.getElementById('terlambat_masuk').value = a.querySelector('#terlambat_masuk').value;
    document.getElementById('pulang_sebelum_waktunya').value = a.querySelector('#pulang_sebelum_waktunya').value;
    document.getElementById('tidak_absen_masuk').value = a.querySelector('#tidak_absen_masuk').value;
    document.getElementById('tidak_absen_pulang').value = a.querySelector('#tidak_absen_pulang').value;
    document.getElementById('jabatan').value = a.querySelector('#jabatan').value;
    document.getElementById('gaji_pokok').value = a.querySelector('#gaji_pokok').value;
    document.getElementById('potongan_utang').value = a.querySelector('#utang').value;
    document.getElementById('uang_makan_per_hari').innerHTML = a.querySelector('#uang_makan_per_hari').value;
    document.getElementById('potongan_per_tidak_masuk').innerHTML = a.querySelector('#potongan_per_tidak_masuk').value;
    document.getElementById('potongan_per_terlambat_masuk').innerHTML = a.querySelector('#potongan_per_terlambat_masuk').value;
    document.getElementById('potongan_per_pulang_sebelum_waktunya').innerHTML = a.querySelector('#potongan_per_pulang_sebelum_waktunya').value;
    document.getElementById('potongan_per_tidak_absen_masuk').innerHTML = a.querySelector('#potongan_per_tidak_absen_masuk').value;
    document.getElementById('potongan_per_tidak_absen_pulang').innerHTML = a.querySelector('#potongan_per_tidak_absen_pulang').value;
    document.getElementById('uang_lembur').value = a.querySelector('#uang_lembur').value;
    changeHadir();
    changeAbsen();
    changeTerlambat();
    changePulangDeluan();
    changeTidakAbsenMasuk();
    changeTidakAbsenPulang();
  }

 function changeKaryawan()
  { if(is_edit == 1)
     { return;
     }
    getAbsensi();
  }

 function changePendapatan(element)
  { if(is_edit == 1)
     { return;
     }
    fnomor(element);
    hitungTotalPendapatan();
  }

 function changePotongan(element)
  { if(is_edit == 1)
     { return;
     }
    fnomor(element);
    hitungTotalPotongan();
  }

 function changeHadir()
  { fnomor(document.getElementById('hadir'));
    if(document.getElementById('hadir').value !== '')
     { document.getElementById('jlh_uang_makan').innerHTML = document.getElementById('hadir').value;
     }
    else
     { document.getElementById('jlh_uang_makan').innerHTML = 0;
     }
    if(is_edit == 0)
     { hitungUangMakan();
     }
  }

 function changeAbsen()
  { fnomor(document.getElementById('absen'));
    if(document.getElementById('absen').value !== '')
     { document.getElementById('jlh_tidak_masuk').innerHTML = document.getElementById('absen').value;
     }
    else
     { document.getElementById('jlh_tidak_masuk').innerHTML = 0;
     }
    if(is_edit == 0)
     { hitungPotonganAbsen();
     }
  }

 function changeTerlambat()
  { fnomor(document.getElementById('terlambat_masuk'));
    if(document.getElementById('terlambat_masuk').value !== '')
     { document.getElementById('jlh_terlambat_masuk').innerHTML = document.getElementById('terlambat_masuk').value;
     }
    else
     { document.getElementById('jlh_terlambat_masuk').innerHTML = 0;
     }
    if(is_edit == 0)
     { hitungDendaTerlambat();
     }
  }

 function changePulangDeluan()
  { fnomor(document.getElementById('pulang_sebelum_waktunya'));
    if(document.getElementById('pulang_sebelum_waktunya').value !== '')
     { document.getElementById('jlh_pulang_sebelum_waktunya').innerHTML = document.getElementById('pulang_sebelum_waktunya').value;
     }
    else
     { document.getElementById('jlh_pulang_sebelum_waktunya').innerHTML = 0;
     }
    if(is_edit == 0)
     { hitungDendaPulangDuluan();
     }
  }

 function changeTidakAbsenMasuk()
  { fnomor(document.getElementById('tidak_absen_masuk'));
    if(document.getElementById('tidak_absen_masuk').value !== '')
     { document.getElementById('jlh_tidak_absen_masuk').innerHTML = document.getElementById('tidak_absen_masuk').value;
     }
    else
     { document.getElementById('jlh_tidak_absen_masuk').innerHTML = 0;
     }
    if(is_edit == 0)
     { hitungDendaTidakAbsenMasuk();
     }
  }

 function changeTidakAbsenPulang()
  { fnomor(document.getElementById('tidak_absen_pulang'));
    if(document.getElementById('tidak_absen_pulang').value !== '')
     { document.getElementById('jlh_tidak_absen_pulang').innerHTML = document.getElementById('tidak_absen_pulang').value;
     }
    else
     { document.getElementById('jlh_tidak_absen_pulang').innerHTML = 0;
     }
    if(is_edit == 0)
     { hitungDendaTidakAbsenPulang();
     }
  }

 function hitungUangMakan()
  { if(is_edit == 1)
     { return;
     }
    var a = normal(document.getElementById('uang_makan_per_hari').textContent);
    var b = normal(document.getElementById('jlh_uang_makan').textContent);
    var c = a * b;
    document.getElementById('uang_makan').value = formatnomor(c.toString().replaceAll('.', ','));
    hitungTotalPendapatan();
  }

 function hitungPotonganAbsen()
  { if(is_edit == 1)
     { return;
     }
    var a = normal(document.getElementById('potongan_per_tidak_masuk').textContent);
    var b = normal(document.getElementById('jlh_tidak_masuk').textContent);
    var c = a * b;
    document.getElementById('potongan_tidak_masuk').value = formatnomor(c.toString().replaceAll('.', ','));
    hitungTotalPotongan();
  }

 function hitungDendaTerlambat()
  { if(is_edit == 1)
     { return;
     }
    var a = normal(document.getElementById('potongan_per_terlambat_masuk').textContent);
    var b = normal(document.getElementById('jlh_terlambat_masuk').textContent);
    var c = a * b;
    document.getElementById('potongan_terlambat_masuk').value = formatnomor(c.toString().replaceAll('.', ','));
    hitungTotalPotongan();
  }

 function hitungDendaPulangDuluan()
  { if(is_edit == 1)
     { return;
     }
    var a = normal(document.getElementById('potongan_per_pulang_sebelum_waktunya').textContent);
    var b = normal(document.getElementById('jlh_pulang_sebelum_waktunya').textContent);
    var c = a * b;
    document.getElementById('potongan_pulang_sebelum_waktunya').value = formatnomor(c.toString().replaceAll('.', ','));
    hitungTotalPotongan();
  }

 function hitungDendaTidakAbsenMasuk()
  { if(is_edit == 1)
     { return;
     }
    var a = normal(document.getElementById('potongan_per_tidak_absen_masuk').textContent);
    var b = normal(document.getElementById('jlh_tidak_absen_masuk').textContent);
    var c = a * b;
    document.getElementById('potongan_tidak_absen_masuk').value = formatnomor(c.toString().replaceAll('.', ','));
    hitungTotalPotongan();
  }

 function hitungDendaTidakAbsenPulang()
  { if(is_edit == 1)
     { return;
     }
    var a = normal(document.getElementById('potongan_per_tidak_absen_pulang').textContent);
    var b = normal(document.getElementById('jlh_tidak_absen_pulang').textContent);
    var c = a * b;
    document.getElementById('potongan_tidak_absen_pulang').value = formatnomor(c.toString().replaceAll('.', ','));
    hitungTotalPotongan();
  }

 function hitungTotalPendapatan()
  { if(is_edit == 1)
     { return;
     }
    var a = normal(document.getElementById('gaji_pokok').value) * 1;
    var b = normal(document.getElementById('uang_makan').value) * 1;
    var c = normal(document.getElementById('uang_lembur').value) * 1;
    var d = normal(document.getElementById('bonus').value) * 1;
    var e = normal(document.getElementById('tunjangan_hari_raya').value) * 1;
    var f = a + b + c + d + e;
    document.getElementById('total_pendapatan').value = formatnomor(f.toString().replaceAll('.', ','));
    hitungTotalGaji();
  }

 function hitungTotalPotongan()
  { if(is_edit == 1)
     { return;
     }
    var a = normal(document.getElementById('potongan_tidak_masuk').value) * 1;
    var b = normal(document.getElementById('potongan_terlambat_masuk').value) * 1;
    var c = normal(document.getElementById('potongan_pulang_sebelum_waktunya').value) * 1;
    var d = normal(document.getElementById('potongan_pulang_sebelum_waktunya').value) * 1;
    var e = normal(document.getElementById('potongan_tidak_absen_masuk').value) * 1;
    var f = normal(document.getElementById('potongan_tidak_absen_pulang').value) * 1;
    var g = normal(document.getElementById('potongan_utang').value) * 1;
    var h = a + b + c + d + e + f + g;
    document.getElementById('total_potongan').value = formatnomor(h.toString().replaceAll('.', ','));
    hitungTotalGaji();
  }

 function hitungTotalGaji()
  { if(is_edit == 1)
     { return;
     }
    var a = normal(document.getElementById('total_pendapatan').value) * 1;
    var b = normal(document.getElementById('total_potongan').value) * 1;
    var c = a - b;
    document.getElementById('total_gaji').value = formatnomor(c.toString().replaceAll('.', ','));
  }

 function cetak(element)
  { var list = document.getElementsByClassName(element.className);
    list = [].slice.call(list);
    var position = list.indexOf(element);
    document.getElementsByClassName('loader')[0].style['display'] = 'block';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'block';
    var formdata = new FormData();
    formdata.append('user_id', document.querySelector('.user-id').value);
    formdata.append('username', document.querySelector('.user-name').value);
    formdata.append('token', document.querySelector('.user-token').value);
    formdata.append('users_level_id', document.querySelector('.user-level_id').value);
    formdata.append('cabang_id', document.querySelector('.user-cabang_id').value);
    formdata.append('Nama_Tabel', Nama_Tabel);
    formdata.append('id', document.getElementsByClassName('textarea_edit-id')[position].value);
    var ajax = new XMLHttpRequest();
    ajax.addEventListener('load', responseCetak, false);
    ajax.open('POST', '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/cetak.php');
    ajax.send(formdata);
  }

 function responseCetak()
  { document.getElementsByClassName('loader')[0].style['display'] = 'none';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'none';
    var a = document.createElement('div');
    a.innerHTML = event.srcElement.response;
    document.getElementById('slip-gaji').src = '<?= $_POST['url'] ?>/files/gaji/' + a.querySelector('#nama_file').value;
    showModal('popUpCetak');
  }

</script>