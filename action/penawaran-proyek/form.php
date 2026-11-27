<?php
 include("../bjksadkhrej121lkjkjk.php");
 $list_cabang = "<option></option>";
 $query = "select * from cabang order by nama asc";
 if(isset($_POST['cabang_id']) && $_POST['cabang_id'] !== "")
  { $query = "select * from cabang where cabang_id = '".intval($_POST['cabang_id'])."' order by nama asc";
  }
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
 $karyawan_id = "";
 $hide_karyawan = "";
 $query = "select karyawan_id from users where username = '".$username."'";
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { if(strval($row['karyawan_id']) !== "")
     { $karyawan_id = $row['karyawan_id'];
       $hide_karyawan = " display:none;";
     }
  }
 $list_kata_pengantar = "<option></option>";
 $query = "select * from kata_pengantar order by id asc";
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $list_kata_pengantar .= "<option value='".$row['id']."'>".$row['tipe']."</option>";
  }
 $list_catatan_penawaran = "<option></option>";
 $query = "select * from catatan_penawaran order by id asc";
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $list_catatan_penawaran .= "<option value='".$row['id']."'>".$row['judul']."</option>";
  }
 $list_tanda_tangan = "<option></option>";
 $query = "select * from tanda_tangan order by tanda_tangan asc";
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $list_tanda_tangan .= "<option value='".$row['id']."'>".$row['tanda_tangan']."</option>";
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
 .kelompok-item
  { margin-top : 30px;
  }
 .group-border
  { border : 1px solid silver;
    padding : 15px;
  }
 .group-title
  { display : grid;
    grid-template-columns : auto 1fr auto;
    align-items : center;
    gap : 5px;
    position : absolute;
    top : -17px;
    background : white;
  }
 .group-body
  { margin-top : 10px;
  }
 @media only screen and (min-width : 500px)
  { .group-title
     { grid-template-columns : auto 300px auto;
     }
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
<a id='link-cetak' target='#blank'></a>
<section class='content'>
 <input type='hidden' id='edit-id'>
 <span id='filterKu' style='display:none;'>[]</span>
 <div class='box box-default'>
  <div class='box-header with-border'>
   <h3 class='box-title'>Penawaran</h3>
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
        <div style='display:inline-block; font-weight:bold; position:absolute; top:-10px; background:white;'>Penawaran<span id='nomor_penawaran'></span></div>
        <div class='row'>
         <div class='col-md-6'>
          <div class='row' style='margin-bottom:5px;'>
           <div class='col-md-4' style='padding-top:7px;'>
            <label>Cabang *</label>
           </div>
           <div class='col-md-8'>
            <select class='form-control fieldku' style='width:100%;' onchange='tampilListView();' id='cabang_id'>
             <?= $list_cabang ?>
            </select>
            <div class='error' id='error-cabang_id'></div>
           </div>
          </div>
          <div id='div-nomor'></div>
          <div class='row' style='margin-top:5px;'>
           <div class='col-md-4' style='padding-top:7px;'>
            <label>Tanggal *</label>
           </div>
           <div class='col-md-8'>
            <div style='display:grid; grid-template-columns:1fr auto; gap:5px;'>
             <input type='text' class='form-control fieldku tanggal' autocomplete='new-password' style='background-color:white;' readonly id='tanggal'>
             <button type='button' class='btn btn-default' style='width:40px;' onclick="document.getElementById('tanggal').value = '';"><i class='fa fa-close'></i></button>
            </div>
            <div class='error' id='error-tanggal'></div>
           </div>
          </div>
          <div class='row' style='margin-top:5px;'>
           <div class='col-md-4' style='padding-top:7px;'>
            <label>Kata Pengantar *</label>
           </div>
           <div class='col-md-8'>
            <select class='form-control fieldku' style='width:100%;' id='kata_pengantar_id'>
             <?= $list_kata_pengantar ?>
            </select>
            <div class='error' id='error-kata_pengantar_id'></div>
           </div>
          </div>
         </div>
         <div class='col-md-6'>
          <div class='row'>
           <div class='col-md-4' style='padding-top:7px;'>
            <label>Catatan</label>
           </div>
           <div class='col-md-8'>
            <select class='form-control fieldku' style='width:100%;' id='catatan_penawaran_id'>
             <?= $list_catatan_penawaran ?>
            </select>
            <div class='error' id='error-catatan_penawaran_id'></div>
           </div>
          </div>
          <div class='row' style='margin-top:5px;'>
           <div class='col-md-4' style='padding-top:7px;'>
            <label>Tanda Tangan *</label>
           </div>
           <div class='col-md-8'>
            <select class='form-control fieldku' style='width:100%;' id='tanda_tangan_id'>
             <?= $list_tanda_tangan ?>
            </select>
            <div class='error' id='error-tanda_tangan_id'></div>
           </div>
          </div>
          <div class='row' style='margin-top:5px;'>
           <div class='col-md-4' style='padding-top:7px;'>
            <label>Batas Waktu *</label>
           </div>
           <div class='col-md-8'>
            <div style='display:grid; grid-template-columns:1fr auto; gap:5px;'>
             <input type='text' class='form-control fieldku batas_waktu' autocomplete='new-password' onkeypress='return hanyaAngka(this);' onkeyup='fnomor(this);' onfocus='this.select();' style='text-align:right;' id='batas_waktu'>
             <div style='padding-top:7px;'>Hari</div>
            </div>
            <div class='error' id='error-batas_waktu'></div>
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
        <div style='display:inline-block; font-weight:bold; position:absolute; top:-10px; background:white;'>Customer</div>
        <div class='row'>
         <div class='col-md-6'>
          <div class='row'>
           <div class='col-md-4' style='padding-top:7px;'>
            <label>Nama *</label>
           </div>
           <div class='col-md-8'>
            <div style='display:grid; grid-template-columns:1fr auto; gap:5px;'>
             <input type='text' class='form-control fieldku fieldku2' autocomplete='new-password' readonly id='nama_customer'>
             <button type='button' class='btn btn-warning' style='width:40px;' onclick='cariCustomer();'><i class='fa fa-search'></i></button>
            </div>
            <input type='hidden' class='fieldku' autocomplete='new-password' id='customer_id'>
            <div class='error' id='error-customer_id'></div>
            <div class='error' id='error-nama_customer'></div>
           </div>
          </div>
          <div class='row' style='margin-top:5px;'>
           <div class='col-md-4' style='padding-top:7px;'>
            <label>Alamat *</label>
           </div>
           <div class='col-md-8'>
            <input type='text' class='form-control fieldku fieldku2' autocomplete='new-password' id='alamat_customer'>
            <div class='error' id='error-alamat_customer'></div>
           </div>
          </div>
          <div class='row' style='margin-top:5px;'>
           <div class='col-md-4' style='padding-top:7px;'>
            <label>No Telp</label>
           </div>
           <div class='col-md-8'>
            <div id="list-no_telp_customer" style="display:grid; grid-template-rows:1fr; gap:5px;"></div>
           </div>
          </div>
         </div>
         <div class='col-md-6'>
          <div class='row'>
           <div class='col-md-4' style='padding-top:7px;'>
            <label>No Wa</label>
           </div>
           <div class='col-md-8'>
            <div id="list-no_wa_customer" style="display:grid; grid-template-rows:1fr; gap:5px;"></div>
           </div>
          </div>
          <div class='row' style='margin-top:5px;'>
           <div class='col-md-4' style='padding-top:7px;'>
            <label>Email</label>
           </div>
           <div class='col-md-8'>
            <div id="list-email_customer" style="display:grid; grid-template-rows:1fr; gap:5px;"></div>
           </div>
          </div>
         </div>
        </div>
       </div>
      </div>
     </div>
     <div id='list-kelompok'>
      <div class='row kelompok-item'>
       <div class='col-md-12'>
        <div class='group-border'>
         <div class='group-title'>
          <div><span class='group-number'>I</span>.<input type='hidden' class='nomor_kelompok'></div>
          <div>
           <input type='text' class='form-control nama_kelompok' style='width:100%;' placeholder='Kelompok Item Pekerjaan'>
           <div class='error'></div>
          </div>
          <div style='display:grid; grid-template-columns:auto auto; gap:5px;'>
           <button type='button' class='btn btn-success btn-add-kelompok' onclick='addKelompokItem();'><i class='fa fa-plus'></i></button>
           <button type='button' class='btn btn-danger btn-hapus-kelompok' onclick='hapusKelompokItem(this);'><i class='fa fa-trash'></i></button>
          </div>
         </div>
         <div class='group-body'>
          <button type='button' class='btn btn-success btn-add-item' onclick='addItem(this);'><i class='fa fa-plus'></i> Item</button>
          <div class='responsiveku'>
           <table class='table table-bordered'>
            <thead>
             <tr>
              <th style='width:70px; min-width:70px; max-width:70px; text-align:center;'>No.</th>
              <th style='min-width:300px;'>Uraian Pekerjaan</th>
              <th style='width:70px; min-width:70px; max-width:70px; text-align:center;'>Qty</th>
              <th style='width:150px; min-width:150px; max-width:150px;'>Satuan</th>
              <th style='width:120px; min-width:120px; max-width:120px; text-align:center;'>Harga</th>
              <th style='width:120px; min-width:120px; max-width:120px; text-align:center;'>Total</th>
              <th style='width:55px; min-width:55px; max-width:55px; text-align:center;'>Del</th>
             </tr>
            </thead>
            <tbody></tbody>
           </table>
          </div>
         </div>
        </div>
       </div>
      </div>
     </div>
     <div class='row' style='margin-top:5px;'>
      <div class='col-md-2 col-md-offset-8' style='padding-top:7px;'>
       <label>Total</label>
      </div>
      <div class='col-md-2'>
       <input type='text' class='form-control fieldku' autocomplete='new-password' style='text-align:right;' readonly id='total'>
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
     <h3 class='box-title'>List Penawaran</h3>
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

<div class='modal' id='popUpCustomer'>
 <div class='modal-dialog'>
  <div class='modal-content'>
   <div class='modal-header'>
    <button type='button' class='close' onclick="hideModal('popUpCustomer');">&times</button>
    <h4 class='modal-title'>Pilih Customer</h4>
   </div>
   <div class='modal-body'>

    <div class='tab-container'>
     <div class='tab-buttons'>
      <button type='button' class='tab-button active' onclick='openTab(this);'><i class='fa fa-list'></i> List</a></button>
      <button type='button' class='tab-button' onclick='openTab(this);'><i class='fa fa-plus'></i> New</a></button>
     </div>
     <div class='tab-content active'>
      <div class='row'>
       <div class='col-md-12'>
        <input type='button' class='btn btn-default' value='&laquo' style='float:left; height:35px;' onclick='previousPageCustomer()'>
        <div style='display:inline-block; max-width:80px; float:left;'>
         <select class='form-control' style='text-align:center; width:100%;' onchange='goToPageCustomer(this.value);' id='preview-halaman-customer'>
          <option value='1' selected>1</option>
         </select>
        </div>
        <input type='button' class='btn btn-default' value='&raquo' style='float:left; height:35px;' onclick='nextPageCustomer()'>
        <button type='button' class='btn btn-default' style='float:left; height:35px;' onclick='refreshCustomer();'><i class='fa fa-refresh'></i></button>
        <input type='text' class='form-control' placeholder='Cari..' style='height:35px; max-width:200px; float:left;' id='cari-customer' onkeyup='tampilCustomer();' onchange='tampilCustomer();'>
        <span style='float:right; padding-top:10px;' id='jlh-halaman-customer'>Jumlah Halaman :</span>
       </div>
      </div>
      <div id='tabelkucustomer' class='responsiveku'><input type='hidden' id='txthalamancustomer' value='1'></div>
     </div>
     <div class='tab-content active'>
      <div class='row'>
       <div class='col-md-12'>
        <div class='row' style='margin-top:5px;'>
         <div class='col-md-4' style='padding-top:7px;'>
          <label>Jenis Customer *</label>
         </div>
         <div class='col-md-8'>
          <select class='form-control fieldku3' style='width:100%;' id='customer-jenis_customer_id'>
           <?= $list_jenis_customer ?>
          </select>
          <div class='error' id='error-customer-jenis_customer_id'></div>
         </div>
        </div>
        <div class='row' style='margin-top:5px;'>
         <div class='col-md-4' style='padding-top:7px;'>
          <label>Nama *</label>
         </div>
         <div class='col-md-8'>
          <input type='text' class='form-control fieldku3' autocomplete='new-password' id='customer-nama'>
          <div class='error' id='error-customer-nama'></div>
         </div>
        </div>
        <div class='row' style='margin-top:5px;'>
         <div class='col-md-4' style='padding-top:7px;'>
          <label>Alamat *</label>
         </div>
         <div class='col-md-8'>
          <input type='text' class='form-control fieldku3' autocomplete='new-password' id='customer-alamat'>
          <div class='error' id='error-customer-alamat'></div>
         </div>
        </div>
        <div class='row' style='margin-top:5px;'>
         <div class='col-md-4' style='padding-top:7px;'>
          <label>No Telp</label>
         </div>
         <div class='col-md-8'>
          <div id="list-no_telp" style="display:grid; grid-template-rows:1fr; gap:5px;"></div>
         </div>
        </div>
        <div class='row' style='margin-top:5px;'>
         <div class='col-md-4' style='padding-top:7px;'>
          <label>No Wa</label>
         </div>
         <div class='col-md-8'>
          <div id="list-no_wa" style="display:grid; grid-template-rows:1fr; gap:5px;"></div>
         </div>
        </div>
        <div class='row' style='margin-top:5px;'>
         <div class='col-md-4' style='padding-top:7px;'>
          <label>Email</label>
         </div>
         <div class='col-md-8'>
          <div id="list-email" style="display:grid; grid-template-rows:1fr; gap:5px;"></div>
         </div>
        </div>
       </div>
      </div>
     </div>
    </div>
   </div>
   <div class='modal-footer'>
    <button type='button' class='btn btn-default' onclick="hideModal('popUpCustomer');"><i class='fa fa-close'></i> Batal</button>
    <button type='button' class='btn btn-primary' onclick='validasiCustomer();'><i class='fa fa-save'></i> Simpan</button>
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

<div class='modal' id='popUpJasa'>
 <div class='modal-dialog'>
  <div class='modal-content'>
   <div class='modal-header'>
    <button type='button' class='close' onclick="hideModal('popUpJasa');">&times</button>
    <h4 class='modal-title'>Pilih Jasa</h4>
   </div>
   <div class='modal-body'>
    <div class='row'>
     <div class='col-md-12'>
      <input type='button' class='btn btn-default' value='&laquo' style='float:left; height:35px;' onclick='previousPageJasa()'>
      <div style='display:inline-block; max-width:80px; float:left;'>
       <select class='form-control halaman' style='text-align:center; width:100%;' onchange='goToPageJasa(this.value);' id='preview-halaman-jasa'>
        <option value='1' selected>1</option>
       </select>
      </div>
      <input type='button' class='btn btn-default' value='&raquo' style='float:left; height:35px;' onclick='nextPageJasa()'>
      <button type='button' class='btn btn-default' style='float:left; height:35px;' onclick='refreshJasa();'><i class='fa fa-refresh'></i></button>
      <input type='text' class='form-control' autocomplete='new-password' placeholder='Cari..' style='max-width:250px; height:35px; float:left;' onkeyup='tampilJasa();' onchange='tampilJasa();' id='txtcarijasa'>
      <span style='float:right; padding-top:10px;' id='jlh-halaman-jasa'>Jumlah Halaman :</span>
     </div>
    </div>
    <div id='tabelkujasa' class='responsiveku'><input type='hidden' id='txthalamanjasa' value='1'></div>
   </div>
   <div class='modal-footer'>
    <button type='button' class='btn btn-default' onclick="hideModal('popUpJasa');"><i class='fa fa-close'></i> Batal</button>
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

<div id='div-result' style='display:none'></div>

<script>

 var Nama_Tabel = 'penawaran_proyek';
 var FieldTidakBolehRangkap = [];
 var FieldRequired = [
  {field : 'cabang_id', label : 'Cabang'},
  {field : 'tanggal', label : 'Tanggal'},
  {field : 'kata_pengantar_id', label : 'Kata Pengantar'},
  {field : 'tanda_tangan_id', label : 'Tanda Tangan'},
  {field : 'batas_waktu', label : 'Batas Waktu'},
  {field : 'customer_id', label : 'Customer'},
  {field : 'nama_customer', label : 'Nama Customer'},
  {field : 'alamat_customer', label : 'Alamat Customer'},
 ];
 var maxRecord = 10;
 var is_edit = 0;

 $('.tanggal').datepicker({ autoclose : true, todayHighlight : true, format : 'dd-mm-yyyy' });
 $('#cabang_id').select2({ placeholder : '', allowClear : true });
 $('#customer-jenis_customer_id').select2({ placeholder : '', allowClear : true });

 makeSelect2Search('karyawan_id', '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/get-karyawan.php', { username: '<?= $_POST['username'] ?>', users_level_id: '<?= $_POST['users_level_id'] ?>', cabang_id: '<?= $_POST['cabang_id'] ?>', token: '<?= $_POST['token'] ?>' });

 tampilListView();
 clearNoTelpCustomer();
 clearNoWaCustomer();
 clearEmailCustomer();

 function validasi()
  { var error = 0;

    var no_telp_customer = [];
    try
     { var a = document.querySelectorAll('#list-no_telp_customer > div > input');
       for(var i=0; i<a.length; i++)
        { if(a[i].value !== '')
           { var valueToPush = {};
             valueToPush.no_telp_customer = a[i].value;
             no_telp_customer.push(valueToPush);
           }
        }
     }
    catch(er) { }

    var no_wa_customer = [];
    try
     { var a = document.querySelectorAll('#list-no_wa_customer > div > input');
       for(var i=0; i<a.length; i++)
        { if(a[i].value !== '')
           { var valueToPush = {};
             valueToPush.no_wa_customer = a[i].value;
             no_wa_customer.push(valueToPush);
           }
        }
     }
    catch(er) { }

    var email_customer = [];
    try
     { var a = document.querySelectorAll('#list-email_customer > div > input');
       for(var i=0; i<a.length; i++)
        { if(a[i].value !== '')
           { var valueToPush = {};
             valueToPush.email_customer = a[i].value;
             email_customer.push(valueToPush);
           }
        }
     }
    catch(er) { }

    var data = {};
    if(no_telp_customer.length > 0)
     { data['no_telp_customer'] = no_telp_customer;
     }
    else
     { data['no_telp_customer'] = null;
     }
    if(no_wa_customer.length > 0)
     { data['no_wa_customer'] = no_wa_customer;
     }
    else
     { data['no_wa_customer'] = null;
     }
    if(email_customer.length > 0)
     { data['email_customer'] = email_customer;
     }
    else
     { data['email_customer'] = null;
     }

    var detail = [];
    var a = document.querySelectorAll('.uraian');
    for(var i=0; i<a.length; i++)
     { if(a[i].value == '')
        { error++;
          document.querySelectorAll('.uraian')[i].parentNode.querySelector('.error').innerHTML = 'Wajib diisi!';
        }
       else
        { document.querySelectorAll('.uraian')[i].parentNode.querySelector('.error').innerHTML = '';
        }
       if(document.querySelectorAll('.qty')[i].value == '')
        { error++;
          document.querySelectorAll('.qty')[i].parentNode.querySelector('.error').innerHTML = 'Wajib diisi!';
        }
       else
        { document.querySelectorAll('.qty')[i].parentNode.querySelector('.error').innerHTML = '';
        }
       if(document.querySelectorAll('.satuan')[i].value == '')
        { error++;
          document.querySelectorAll('.satuan')[i].parentNode.querySelector('.error').innerHTML = 'Wajib diisi!';
        }
       else
        { document.querySelectorAll('.satuan')[i].parentNode.querySelector('.error').innerHTML = '';
        }
       if(document.querySelectorAll('.harga')[i].value == '')
        { error++;
          document.querySelectorAll('.harga')[i].parentNode.querySelector('.error').innerHTML = 'Wajib diisi!';
        }
       else
        { document.querySelectorAll('.harga')[i].parentNode.querySelector('.error').innerHTML = '';
        }
       var valueToPush = {};
       valueToPush.id = document.querySelectorAll('.id')[i].value;
       valueToPush.nomor_kelompok = a[i].parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.querySelector('.nomor_kelompok').value;
       valueToPush.nama_kelompok = a[i].parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode.querySelector('.nama_kelompok').value;
       valueToPush.uraian = document.querySelectorAll('.uraian')[i].value;
       valueToPush.jumlah = normal(document.querySelectorAll('.qty')[i].value) * 1;
       valueToPush.satuan = document.querySelectorAll('.satuan')[i].value;
       valueToPush.harga = normal(document.querySelectorAll('.harga')[i].value) * 1;
       valueToPush.total = normal(document.querySelectorAll('.total')[i].value) * 1;
       detail.push(valueToPush);
     }
    data['detail'] = detail;

    var a = document.getElementsByClassName('fieldku');
    for(var loop=0; loop<a.length; loop++)
     { if(a[loop].value !== '')
        { if(a[loop].id == 'tanggal')
           { data[a[loop].id] = normalisasi_tanggal(a[loop].value);
           }
          else if(a[loop].id == 'sub_total' || a[loop].id == 'persen_diskon' || a[loop].id == 'diskon' || a[loop].id == 'dpp' || a[loop].id == 'persen_ppn' || a[loop].id == 'ppn' || a[loop].id == 'total')
           { data[a[loop].id] = normal(a[loop].value) * 1;
           }
          else if(a[loop].id == 'batas_waktu' || a[loop].id == 'sub_total' || a[loop].id == 'persen_diskon' || a[loop].id == 'diskon' || a[loop].id == 'dpp' || a[loop].id == 'persen_ppn' || a[loop].id == 'ppn' || a[loop].id == 'total')
           { data[a[loop].id] = normal(a[loop].value);
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
    formdata.append('cabng_id', document.getElementById('cabang_id').value);
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
    clearNoTelpCustomer();
    clearNoWaCustomer();
    clearEmailCustomer();
    clearKelompokItem();
    document.getElementById('nomor_penawaran').innerHTML = '';
    document.getElementById('div-nomor').innerHTML = '';
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
  { is_edit = 1;
    var list = document.getElementsByClassName(label.className);
    list = [].slice.call(list);
    var position = list.indexOf(label);
    document.getElementById('edit-id').value = document.getElementsByClassName('textarea_edit-id')[position].value;
    var a = document.getElementsByClassName('fieldku');
    for(var loop=0; loop<a.length; loop++)
     { if(a[loop].id == 'karyawan_id')
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

    clearNoTelpCustomer();
    var a = document.querySelectorAll('.detail-no_telp_customer')[position].querySelectorAll('.detail-no_telp_customer-no_telp_customer');
    for(var i=0; i<a.length; i++)
     { if(i > 0)
        { tambahNoTelpCustomer();
        }
       document.querySelectorAll('#list-no_telp_customer input')[i].value = a[i].value;
     }

    clearNoWaCustomer();
    var a = document.querySelectorAll('.detail-no_wa_customer')[position].querySelectorAll('.detail-no_wa_customer-no_wa_customer');
    for(var i=0; i<a.length; i++)
     { if(i > 0)
        { tambahNoWaCustomer();
        }
       document.querySelectorAll('#list-no_wa_customer input')[i].value = a[i].value;
     }

    clearEmailCustomer();
    var a = document.querySelectorAll('.detail-email_customer')[position].querySelectorAll('.detail-email_customer-email_customer');
    for(var i=0; i<a.length; i++)
     { if(i > 0)
        { tambahEmailCustomer();
        }
       document.querySelectorAll('#list-email_customer input')[i].value = a[i].value;
     }

    clearKelompokItem();
    var a = document.querySelectorAll('.div-detail_kelompok')[position].querySelectorAll('.detail_kelompok-nama_kelompok');
    for(var i=0; i<a.length; i++)
     { if(i > 0)
        { addKelompokItem();
        }
       document.querySelectorAll('.nama_kelompok')[i].value = document.querySelectorAll('.div-detail_kelompok')[position].querySelectorAll('.detail_kelompok-nama_kelompok')[i].value;
       var b = document.querySelectorAll('.div-detail_kelompok')[position].querySelectorAll('.detail_kelompok-detail_barang')[i].querySelectorAll('.detail_barang-id');
       for(var j=0; j<b.length; j++)
        { addItem(document.querySelectorAll('.kelompok-item')[i].querySelector('.btn-add-item'));
          document.querySelectorAll('.kelompok-item')[i].querySelectorAll('.uraian')[j].value = document.querySelectorAll('.div-detail_kelompok')[position].querySelectorAll('.detail_kelompok-detail_barang')[i].querySelectorAll('.detail_barang-uraian')[j].value;
          document.querySelectorAll('.kelompok-item')[i].querySelectorAll('.qty')[j].value = document.querySelectorAll('.div-detail_kelompok')[position].querySelectorAll('.detail_kelompok-detail_barang')[i].querySelectorAll('.detail_barang-jumlah')[j].value;
          document.querySelectorAll('.kelompok-item')[i].querySelectorAll('.satuan')[j].value = document.querySelectorAll('.div-detail_kelompok')[position].querySelectorAll('.detail_kelompok-detail_barang')[i].querySelectorAll('.detail_barang-satuan')[j].value;
          document.querySelectorAll('.kelompok-item')[i].querySelectorAll('.harga')[j].value = document.querySelectorAll('.div-detail_kelompok')[position].querySelectorAll('.detail_kelompok-detail_barang')[i].querySelectorAll('.detail_barang-harga')[j].value;
          document.querySelectorAll('.kelompok-item')[i].querySelectorAll('.total')[j].value = document.querySelectorAll('.div-detail_kelompok')[position].querySelectorAll('.detail_kelompok-detail_barang')[i].querySelectorAll('.detail_barang-total')[j].value;
        }
     }

    document.getElementById('div-nomor').innerHTML = `
     <div class='row' style='margin-top:5px;'>
      <div class='col-md-4' style='padding-top:7px;'>
       <label>Nomor *</label>
      </div>
      <div class='col-md-8'>
       <input type='number' class='form-control fieldku' autocomplete='new-password' onkeypress='return hanyaAngka(this);' id='nomor' value='` + document.getElementsByClassName('textarea_edit-nomor')[position].value + `'>
       <div style='color:red' class='error-nomor' id='error-nomor'></div>
      </div>
     </div>
    `;

    document.getElementById('nomor_penawaran').innerHTML = " : " + document.getElementsByClassName('textarea_edit-nomor_penawaran')[position].value;
    document.getElementById('btnfilter').innerHTML = "<i class='fa fa-close'></i> Batal";
    document.getElementById('btnfilter').setAttribute('onclick', 'clearField();');
    document.body.scrollTop = 0; // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
    is_edit = 0;
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

 //No Telp Customer-----------------------------------------------------------------------------------------------------

 function clearNoTelpCustomer()
  { document.querySelector('#list-no_telp_customer').innerHTML = `
     <div style="display:grid; grid-template-columns:1fr 40px 40px; gap:5px;">
      <input type="text" class="form-control" onkeypress="return hanyaAngka2(this);">
      <button type="button" class="btn btn-danger" onclick="hapusNoTelpCustomer(this);"><i class="fa fa-trash"></i></button>
      <button type="button" class="btn btn-success" onclick="tambahNoTelpCustomer();"><i class="fa fa-plus"></i></button>
     </div>
    `;
    setActionNoTelpCustomer();
  }

 function tambahNoTelpCustomer()
  { var a = document.querySelector('#list-no_telp_customer > div');
    const new_child = a.cloneNode(true);
    new_child.querySelector('input').value = '';
    document.querySelector('#list-no_telp_customer').appendChild(new_child);
    setActionNoTelpCustomer();
  }

 function hapusNoTelpCustomer(element)
  { var a = document.querySelectorAll('#list-no_telp_customer > div');
    if(a.length > 1)
     { element.parentNode.remove();
     }
    else
     { a[i].querySelector('input').value = '';
     }
    setActionNoTelpCustomer();
  }

 function setActionNoTelpCustomer()
  { var a = document.querySelectorAll('#list-no_telp_customer > div');
    for(var i=0; i<a.length; i++)
     { if(i == 0)
        { if(a.length == 1)
           { a[i].style['grid-template-columns'] = '1fr 40px';
             a[i].querySelector('.btn-success').style['display'] = 'inline-block';
             a[i].querySelector('.btn-danger').style['display'] = 'none';
           }
          else
           { a[i].style['grid-template-columns'] = '1fr 40px';
             a[i].querySelector('.btn-success').style['display'] = 'none';
             a[i].querySelector('.btn-danger').style['display'] = 'inline-block';
           }
        }
       else if(i == a.length - 1)
        { a[i].style['grid-template-columns'] = '1fr 40px 40px';
          a[i].querySelector('.btn-success').style['display'] = 'inline-block';
          a[i].querySelector('.btn-danger').style['display'] = 'inline-block';
        }
       else
        { a[i].style['grid-template-columns'] = '1fr 40px';
          a[i].querySelector('.btn-success').style['display'] = 'none';
          a[i].querySelector('.btn-danger').style['display'] = 'inline-block';
        }
     }
  }

 //No Telp Customer-----------------------------------------------------------------------------------------------------

 //No Wa Customer-------------------------------------------------------------------------------------------------------

 function clearNoWaCustomer()
  { document.querySelector('#list-no_wa_customer').innerHTML = `
     <div style="display:grid; grid-template-columns:1fr 40px 40px; gap:5px;">
      <input type="text" class="form-control" onkeypress="return hanyaAngka2(this);">
      <button type="button" class="btn btn-danger" onclick="hapusNoWaCustomer(this);"><i class="fa fa-trash"></i></button>
      <button type="button" class="btn btn-success" onclick="tambahNoWaCustomer();"><i class="fa fa-plus"></i></button>
     </div>
    `;
    setActionNoWaCustomer();
  }

 function tambahNoWaCustomer()
  { var a = document.querySelector('#list-no_wa_customer > div');
    const new_child = a.cloneNode(true);
    new_child.querySelector('input').value = '';
    document.querySelector('#list-no_wa_customer').appendChild(new_child);
    setActionNoWaCustomer();
  }

 function hapusNoWaCustomer(element)
  { var a = document.querySelectorAll('#list-no_wa_customer > div');
    if(a.length > 1)
     { element.parentNode.remove();
     }
    else
     { a[i].querySelector('input').value = '';
     }
    setActionNoWaCustomer();
  }

 function setActionNoWaCustomer()
  { var a = document.querySelectorAll('#list-no_wa_customer > div');
    for(var i=0; i<a.length; i++)
     { if(i == 0)
        { if(a.length == 1)
           { a[i].style['grid-template-columns'] = '1fr 40px';
             a[i].querySelector('.btn-success').style['display'] = 'inline-block';
             a[i].querySelector('.btn-danger').style['display'] = 'none';
           }
          else
           { a[i].style['grid-template-columns'] = '1fr 40px';
             a[i].querySelector('.btn-success').style['display'] = 'none';
             a[i].querySelector('.btn-danger').style['display'] = 'inline-block';
           }
        }
       else if(i == a.length - 1)
        { a[i].style['grid-template-columns'] = '1fr 40px 40px';
          a[i].querySelector('.btn-success').style['display'] = 'inline-block';
          a[i].querySelector('.btn-danger').style['display'] = 'inline-block';
        }
       else
        { a[i].style['grid-template-columns'] = '1fr 40px';
          a[i].querySelector('.btn-success').style['display'] = 'none';
          a[i].querySelector('.btn-danger').style['display'] = 'inline-block';
        }
     }
  }

 //No Wa Customer-------------------------------------------------------------------------------------------------------

 //Email Customer-------------------------------------------------------------------------------------------------------

 function clearEmailCustomer()
  { document.querySelector('#list-email_customer').innerHTML = `
     <div style="display:grid; grid-template-columns:1fr 40px 40px; gap:5px;">
      <input type="text" class="form-control">
      <button type="button" class="btn btn-danger" onclick="hapusEmailCustomer(this);"><i class="fa fa-trash"></i></button>
      <button type="button" class="btn btn-success" onclick="tambahEmailCustomer();"><i class="fa fa-plus"></i></button>
     </div>
    `;
    setActionEmailCustomer();
  }

 function tambahEmailCustomer()
  { var a = document.querySelector('#list-email_customer > div');
    const new_child = a.cloneNode(true);
    new_child.querySelector('input').value = '';
    document.querySelector('#list-email_customer').appendChild(new_child);
    setActionEmailCustomer();
  }

 function hapusEmailCustomer(element)
  { var a = document.querySelectorAll('#list-email_customer > div');
    if(a.length > 1)
     { element.parentNode.remove();
     }
    else
     { a[i].querySelector('input').value = '';
     }
    setActionEmailCustomer();
  }

 function setActionEmailCustomer()
  { var a = document.querySelectorAll('#list-email_customer > div');
    for(var i=0; i<a.length; i++)
     { if(i == 0)
        { if(a.length == 1)
           { a[i].style['grid-template-columns'] = '1fr 40px';
             a[i].querySelector('.btn-success').style['display'] = 'inline-block';
             a[i].querySelector('.btn-danger').style['display'] = 'none';
           }
          else
           { a[i].style['grid-template-columns'] = '1fr 40px';
             a[i].querySelector('.btn-success').style['display'] = 'none';
             a[i].querySelector('.btn-danger').style['display'] = 'inline-block';
           }
        }
       else if(i == a.length - 1)
        { a[i].style['grid-template-columns'] = '1fr 40px 40px';
          a[i].querySelector('.btn-success').style['display'] = 'inline-block';
          a[i].querySelector('.btn-danger').style['display'] = 'inline-block';
        }
       else
        { a[i].style['grid-template-columns'] = '1fr 40px';
          a[i].querySelector('.btn-success').style['display'] = 'none';
          a[i].querySelector('.btn-danger').style['display'] = 'inline-block';
        }
     }
  }

 //Email Customer-------------------------------------------------------------------------------------------------------

 //Customer-------------------------------------------------------------------------------------------------------------

 function cariCustomer()
  { document.getElementById('error-cabang_id').innerHTML = '';
    document.getElementsByClassName('loader')[0].style['display'] = 'block';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'block';
    tampilCustomer();
  }

 function tampilCustomer()
  { var formdata = new FormData();
    formdata.append('username', '<?= $_POST['username'] ?>');
    formdata.append('users_level_id', '<?= $_POST['users_level_id'] ?>');
    formdata.append('cabang_id', '<?= $_POST['cabang_id'] ?>');
    formdata.append('token', '<?= $_POST['token'] ?>');
    formdata.append('Nama_Tabel', 'customer');
    formdata.append('maxRecord', maxRecord);
    formdata.append('halaman', document.getElementById('txthalamancustomer').value);
    formdata.append('cari', document.getElementById('cari-customer').value);
    var ajax = new XMLHttpRequest();
    ajax.addEventListener('load', responseTampilCustomer, false);
    ajax.open('POST', '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/tampil-customer.php');
    ajax.send(formdata);
  }

 function responseTampilCustomer()
  { document.getElementsByClassName('loader')[0].style['display'] = 'none';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'none';
    $('#tabelkucustomer').html(event.srcElement.response);
    document.getElementById('preview-halaman-customer').innerHTML = document.getElementById('temp-preview-halaman-customer').innerHTML;
    document.getElementById('jlh-halaman-customer').innerHTML = 'Jumlah Halaman : ' + document.getElementById('txtnhalamancustomer').value;
    $('#preview-halaman-customer').select2({ placeholder : 'Pilih', allowClear : false });
    document.querySelector('#popUpCustomer .tab-button').click();
    clearTab2();
    showModal('popUpCustomer');
  }

 function nextPageCustomer()
  { var hal = document.getElementById('txthalamancustomer').value;
    hal++;
    document.getElementById('txthalamancustomer').value = hal;
    tampilCustomer();
  }

 function previousPageCustomer()
  { var hal = document.getElementById('txthalamancustomer').value;
    hal--;
    document.getElementById('txthalamancustomer').value = hal;
    tampilCustomer();
  }

 function goToPageCustomer(value)
  { document.getElementById('txthalamancustomer').value = value;
    tampilCustomer();
  }

 function refreshCustomer()
  { document.getElementById('cari-customer').value = '';
    tampilCustomer();
  }

 function pilihCustomer(element)
  { var list = document.getElementsByClassName(element.className);
    list = [].slice.call(list);
    var position = list.indexOf(element);
    document.getElementById('customer_id').value = document.getElementsByClassName('textarea_customer-id')[position].value;
    var a = document.getElementsByClassName('fieldku2');
    for(var loop=0; loop<a.length; loop++)
     { document.getElementById(a[loop].id).value = document.getElementsByClassName('textarea_customer-' + a[loop].id.toString().replaceAll('_customer', ''))[position].value;
       try
        { $('#' + document.getElementById(a[loop].id).id).trigger('change');
        }
       catch(er) { }
     }

    clearNoTelpCustomer();
    var a = document.querySelectorAll('.detail-no_telp')[position].querySelectorAll('.detail-no_telp-no_telp');
    for(var i=0; i<a.length; i++)
     { if(i > 0)
        { tambahNoTelpCustomer();
        }
       document.querySelectorAll('#list-no_telp_customer input')[i].value = a[i].value;
     }

    clearNoWaCustomer();
    var a = document.querySelectorAll('.detail-no_wa')[position].querySelectorAll('.detail-no_wa-no_wa');
    for(var i=0; i<a.length; i++)
     { if(i > 0)
        { tambahNoWaCustomer();
        }
       document.querySelectorAll('#list-no_wa_customer input')[i].value = a[i].value;
     }

    clearEmailCustomer();
    var a = document.querySelectorAll('.detail-email')[position].querySelectorAll('.detail-email-email');
    for(var i=0; i<a.length; i++)
     { if(i > 0)
        { tambahEmailCustomer();
        }
       document.querySelectorAll('#list-email_customer input')[i].value = a[i].value;
     }
     
    hideModal('popUpCustomer');
  }

 function clickTab1()
  { document.querySelector('#popUpCustomer .modal-footer .btn-primary').style['display'] = 'none';
  }

 function clickTab2()
  { document.querySelector('#popUpCustomer .modal-footer .btn-primary').style['display'] = 'inline-block';
  }

 function clearTab2()
  { var a = document.getElementsByClassName('fieldku3');
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
  }

 var FieldTidakBolehRangkapCustomer = [
  {field : 'jenis_customer_id'},
  {field : 'nama'},
 ];
 var FieldRequiredCustomer = [
  {field : 'jenis_customer_id', label : 'Jenis Customer'},
  {field : 'nama', label : 'Nama Customer'},
  {field : 'alamat', label : 'Alamat'},
 ];

 clearNoTelp();
 clearNoWa();
 clearEmail();

 function validasiCustomer()
  { var no_telp = [];
    try
     { var a = document.querySelectorAll('#list-no_telp > div > input');
       for(var i=0; i<a.length; i++)
        { if(a[i].value !== '')
           { var valueToPush = {};
             valueToPush.no_telp = a[i].value;
             no_telp.push(valueToPush);
           }
        }
     }
    catch(er) { }

    var no_wa = [];
    try
     { var a = document.querySelectorAll('#list-no_wa > div > input');
       for(var i=0; i<a.length; i++)
        { if(a[i].value !== '')
           { var valueToPush = {};
             valueToPush.no_wa = a[i].value;
             no_wa.push(valueToPush);
           }
        }
     }
    catch(er) { }

    var email = [];
    try
     { var a = document.querySelectorAll('#list-email > div > input');
       for(var i=0; i<a.length; i++)
        { if(a[i].value !== '')
           { var valueToPush = {};
             valueToPush.email = a[i].value;
             email.push(valueToPush);
           }
        }
     }
    catch(er) { }

    var data = {};
    if(no_telp.length > 0)
     { data['no_telp'] = no_telp;
     }
    else
     { data['no_telp'] = null;
     }
    if(no_wa.length > 0)
     { data['no_wa'] = no_wa;
     }
    else
     { data['no_wa'] = null;
     }
    if(email.length > 0)
     { data['email'] = email;
     }
    else
     { data['email'] = null;
     }

    var a = document.getElementsByClassName('fieldku3');
    for(var loop=0; loop<a.length; loop++)
     { if(a[loop].value !== '')
        { if(a[loop].id.toString().replaceAll('customer-', '') == 'tanggal')
           { data[a[loop].id.toString().replaceAll('customer-', '')] = normalisasi_tanggal(a[loop].value);
           }
          else
           { data[a[loop].id.toString().replaceAll('customer-', '')] = a[loop].value;
           }
        }
       else
        { data[a[loop].id.toString().replaceAll('customer-', '')] = null;
        }
     }
    var error = 0;
    for(var loop=0; loop<FieldRequiredCustomer.length; loop++)
     { if(document.getElementById('customer-' + FieldRequiredCustomer[loop].field).value == '')
        { error++;
          document.getElementById('error-customer-' + FieldRequiredCustomer[loop].field).innerHTML = '<b>' + FieldRequiredCustomer[loop].label + '</b> wajib diisi';
        }
       else
        { document.getElementById('error-customer-' + FieldRequiredCustomer[loop].field).innerHTML = '';
        }
     }
    if(error == 0)
     { document.getElementsByClassName('loader')[0].style['display'] = 'block';
       document.getElementsByClassName('loader-block')[0].style['display'] = 'block';
       var DataTidakBolehRangkap = [];
       for(var loop=0; loop<FieldTidakBolehRangkapCustomer.length; loop++)
        { var valueToPush = {};
          valueToPush.field = FieldTidakBolehRangkapCustomer[loop].field;
          if(document.getElementById('customer-' + FieldTidakBolehRangkapCustomer[loop].field).value !== "")
           { valueToPush.value = document.getElementById('customer-' + FieldTidakBolehRangkapCustomer[loop].field).value;
           }
          else
           { valueToPush.value = null;
           }
          DataTidakBolehRangkap.push(valueToPush);
        }
       var formdata = new FormData();
       formdata.append('username', '<?= $_POST['username'] ?>');
       formdata.append('users_level_id', '<?= $_POST['users_level_id'] ?>');
       formdata.append('cabang_id', '<?= $_POST['cabang_id'] ?>');
       formdata.append('token', '<?= $_POST['token'] ?>');
       formdata.append('Nama_Tabel', 'customer');
       formdata.append('DataTidakBolehRangkap', JSON.stringify(DataTidakBolehRangkap));
       formdata.append('data', JSON.stringify(data));
       var ajax = new XMLHttpRequest();
       ajax.addEventListener('load', responseSimpanCustomer, false);
       ajax.open('POST', '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/simpan-customer.php');
       ajax.send(formdata);
     }
  }

 function responseSimpanCustomer()
  { document.getElementsByClassName('loader')[0].style['display'] = 'none';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'none';
    $('#div-result').html(event.srcElement.response);
    try
     { var data = JSON.parse(event.srcElement.response);
       if(data.status == "1")
        { document.getElementById('customer_id').value = data.id;
          var a = document.getElementsByClassName('fieldku2');
          for(var loop=0; loop<a.length; loop++)
           { a[loop].value = document.getElementById('customer-' + a[loop].id.toString().replaceAll('_customer', '')).value;
             $("#" + a[loop].id.toString().replaceAll('_customer', '')).trigger('change');
           }

          clearNoTelpCustomer();
          var a = document.querySelectorAll('#list-no_telp input');
          for(var i=0; i<a.length; i++)
           { if(i > 0)
              { tambahNoTelpCustomer();
              }
             document.querySelectorAll('#list-no_telp_customer input')[i].value = a[i].value;
           }

          clearNoWaCustomer();
          var a = document.querySelectorAll('#list-no_wa input');
          for(var i=0; i<a.length; i++)
           { if(i > 0)
              { tambahNoWaCustomer();
              }
             document.querySelectorAll('#list-no_wa_customer input')[i].value = a[i].value;
           }
           
          clearEmailCustomer();
          var a = document.querySelectorAll('#list-email input');
          for(var i=0; i<a.length; i++)
           { if(i > 0)
              { tambahEmailCustomer();
              }
             document.querySelectorAll('#list-email_customer input')[i].value = a[i].value;
           }

          clearFieldCustomer();
          hideModal('popUpCustomer');
        }
       else
        { alert(data.msg);
        }
     }
    catch(err)
     { alert(event.srcElement.response);
     }
  }

 function clearFieldCustomer()
  { var a = document.getElementsByClassName('fieldku3');
    for(var loop=0; loop<a.length; loop++)
     { if(a[loop].id == 'customer-no_telp' || a[loop].id == 'customer-no_wa' || a[loop].id == 'customer-email')
        { a[loop].innerHTML = '';
        }
       else
        { a[loop].value = '';
        }
       try
        { $('#' + a[loop].id).trigger('change');
        }
       catch(er) { }
     }
    var a = document.getElementsByClassName('error');
    for(var loop=0; loop<a.length; loop++)
     { a[loop].innerHTML = '';
     }
    clearNoTelp();
    clearNoWa();
    clearEmail();
  }
 //Customer-------------------------------------------------------------------------------------------------------------

 //No Telp--------------------------------------------------------------------------------------------------------------

 function clearNoTelp()
  { document.querySelector('#list-no_telp').innerHTML = `
     <div style="display:grid; grid-template-columns:1fr 40px 40px; gap:5px;">
      <input type="text" class="form-control" onkeypress="return hanyaAngka2(this);">
      <button type="button" class="btn btn-danger" onclick="hapusNoTelp(this);"><i class="fa fa-trash"></i></button>
      <button type="button" class="btn btn-success" onclick="tambahNoTelp();"><i class="fa fa-plus"></i></button>
     </div>
    `;
    setActionNoTelp();
  }

 function tambahNoTelp()
  { var a = document.querySelector('#list-no_telp > div');
    const new_child = a.cloneNode(true);
    new_child.querySelector('input').value = '';
    document.querySelector('#list-no_telp').appendChild(new_child);
    setActionNoTelp();
  }

 function hapusNoTelp(element)
  { var a = document.querySelectorAll('#list-no_telp > div');
    if(a.length > 1)
     { element.parentNode.remove();
     }
    else
     { a[i].querySelector('input').value = '';
     }
    setActionNoTelp();
  }

 function setActionNoTelp()
  { var a = document.querySelectorAll('#list-no_telp > div');
    for(var i=0; i<a.length; i++)
     { if(i == 0)
        { if(a.length == 1)
           { a[i].style['grid-template-columns'] = '1fr 40px';
             a[i].querySelector('.btn-success').style['display'] = 'inline-block';
             a[i].querySelector('.btn-danger').style['display'] = 'none';
           }
          else
           { a[i].style['grid-template-columns'] = '1fr 40px';
             a[i].querySelector('.btn-success').style['display'] = 'none';
             a[i].querySelector('.btn-danger').style['display'] = 'inline-block';
           }
        }
       else if(i == a.length - 1)
        { a[i].style['grid-template-columns'] = '1fr 40px 40px';
          a[i].querySelector('.btn-success').style['display'] = 'inline-block';
          a[i].querySelector('.btn-danger').style['display'] = 'inline-block';
        }
       else
        { a[i].style['grid-template-columns'] = '1fr 40px';
          a[i].querySelector('.btn-success').style['display'] = 'none';
          a[i].querySelector('.btn-danger').style['display'] = 'inline-block';
        }
     }
  }

 //No Telp--------------------------------------------------------------------------------------------------------------

 //No Wa----------------------------------------------------------------------------------------------------------------

 function clearNoWa()
  { document.querySelector('#list-no_wa').innerHTML = `
     <div style="display:grid; grid-template-columns:1fr 40px 40px; gap:5px;">
      <input type="text" class="form-control" onkeypress="return hanyaAngka2(this);">
      <button type="button" class="btn btn-danger" onclick="hapusNoWa(this);"><i class="fa fa-trash"></i></button>
      <button type="button" class="btn btn-success" onclick="tambahNoWa();"><i class="fa fa-plus"></i></button>
     </div>
    `;
    setActionNoWa();
  }

 function tambahNoWa()
  { var a = document.querySelector('#list-no_wa > div');
    const new_child = a.cloneNode(true);
    new_child.querySelector('input').value = '';
    document.querySelector('#list-no_wa').appendChild(new_child);
    setActionNoWa();
  }

 function hapusNoWa(element)
  { var a = document.querySelectorAll('#list-no_wa > div');
    if(a.length > 1)
     { element.parentNode.remove();
     }
    else
     { a[i].querySelector('input').value = '';
     }
    setActionNoWa();
  }

 function setActionNoWa()
  { var a = document.querySelectorAll('#list-no_wa > div');
    for(var i=0; i<a.length; i++)
     { if(i == 0)
        { if(a.length == 1)
           { a[i].style['grid-template-columns'] = '1fr 40px';
             a[i].querySelector('.btn-success').style['display'] = 'inline-block';
             a[i].querySelector('.btn-danger').style['display'] = 'none';
           }
          else
           { a[i].style['grid-template-columns'] = '1fr 40px';
             a[i].querySelector('.btn-success').style['display'] = 'none';
             a[i].querySelector('.btn-danger').style['display'] = 'inline-block';
           }
        }
       else if(i == a.length - 1)
        { a[i].style['grid-template-columns'] = '1fr 40px 40px';
          a[i].querySelector('.btn-success').style['display'] = 'inline-block';
          a[i].querySelector('.btn-danger').style['display'] = 'inline-block';
        }
       else
        { a[i].style['grid-template-columns'] = '1fr 40px';
          a[i].querySelector('.btn-success').style['display'] = 'none';
          a[i].querySelector('.btn-danger').style['display'] = 'inline-block';
        }
     }
  }

 //No Wa----------------------------------------------------------------------------------------------------------------

 //Email----------------------------------------------------------------------------------------------------------------

 function clearEmail()
  { document.querySelector('#list-email').innerHTML = `
     <div style="display:grid; grid-template-columns:1fr 40px 40px; gap:5px;">
      <input type="text" class="form-control">
      <button type="button" class="btn btn-danger" onclick="hapusEmail(this);"><i class="fa fa-trash"></i></button>
      <button type="button" class="btn btn-success" onclick="tambahEmail();"><i class="fa fa-plus"></i></button>
     </div>
    `;
    setActionEmail();
  }

 function tambahEmail()
  { var a = document.querySelector('#list-email > div');
    const new_child = a.cloneNode(true);
    new_child.querySelector('input').value = '';
    document.querySelector('#list-email').appendChild(new_child);
    setActionEmail();
  }

 function hapusEmail(element)
  { var a = document.querySelectorAll('#list-email > div');
    if(a.length > 1)
     { element.parentNode.remove();
     }
    else
     { a[i].querySelector('input').value = '';
     }
    setActionEmail();
  }

 function setActionEmail()
  { var a = document.querySelectorAll('#list-email > div');
    for(var i=0; i<a.length; i++)
     { if(i == 0)
        { if(a.length == 1)
           { a[i].style['grid-template-columns'] = '1fr 40px';
             a[i].querySelector('.btn-success').style['display'] = 'inline-block';
             a[i].querySelector('.btn-danger').style['display'] = 'none';
           }
          else
           { a[i].style['grid-template-columns'] = '1fr 40px';
             a[i].querySelector('.btn-success').style['display'] = 'none';
             a[i].querySelector('.btn-danger').style['display'] = 'inline-block';
           }
        }
       else if(i == a.length - 1)
        { a[i].style['grid-template-columns'] = '1fr 40px 40px';
          a[i].querySelector('.btn-success').style['display'] = 'inline-block';
          a[i].querySelector('.btn-danger').style['display'] = 'inline-block';
        }
       else
        { a[i].style['grid-template-columns'] = '1fr 40px';
          a[i].querySelector('.btn-success').style['display'] = 'none';
          a[i].querySelector('.btn-danger').style['display'] = 'inline-block';
        }
     }
  }

 //Email----------------------------------------------------------------------------------------------------------------

 //Item-----------------------------------------------------------------------------------------------------------------
 function addItem(element)
  { var tbody = element.parentNode.querySelector('table tbody');
    var tr = document.createElement('tr');
    tr.innerHTML = `
     <td style='text-align:right;'></td>
     <td>
      <input type='hidden' class='id'>
      <input type='text' class='form-control uraian'>
      <div class='error'></div>
     </td>
     <td>
      <input type='text' class='form-control qty' onkeypress='return hanyaAngka(this);' onkeyup='hitungSubTotal(this);' onchange='hitungSubTotal(this);' onfocus='this.select();' style='text-align:right;'>
      <div class='error'></div>
     </td>
     <td>
      <input type='text' class='form-control satuan'>
      <div class='error'></div>
     </td>
     <td>
      <input type='text' class='form-control harga' onkeypress='return hanyaAngka(this);' onkeyup='hitungSubTotal(this);' onchange='hitungSubTotal(this);' onfocus='this.select();' style='text-align:right;'>
      <div class='error'></div>
     </td>
     <td><input type='text' class='form-control total' readonly style='text-align:right;'></td>
     <td style='text-align:center;'><button type='button' class='btn btn-danger' title='Hapus Item' onclick='hapusItem(this);'><i class='fa fa-trash'></i></button></td>
    `;
    tbody.appendChild(tr);
    setNoItem(tbody);
  }

 function setNoItem(tbody)
  { var a = tbody.querySelectorAll('tr');
    for(var i=0; i<a.length; i++)
     { a[i].querySelector('td').innerHTML = (i + 1);
     }
  }

 function hapusItem(element)
  { var tbody = element.parentNode.parentNode.parentNode;
    element.parentNode.parentNode.remove();
    setNoItem(tbody);
    hitungTotal();
  }

 function hitungSubTotal(element)
  { fnomor(element);
    var parent = element.parentNode.parentNode;
    var qty = normal(parent.querySelector('.qty').value) * 1;
    var harga = normal(parent.querySelector('.harga').value) * 1;
    var sub_total = qty * harga;
    parent.querySelector('.total').value = formatnomor(sub_total.toFixed(2).toString().replaceAll('.', ',').replaceAll('-', ''));
    hitungTotal();
  }

 function hitungTotal()
  { var total = 0;
    var a = document.querySelectorAll('.kelompok-item .total');
    for(var i=0; i<a.length; i++)
     { total += normal(a[i].value) * 1;
     }
    document.getElementById('total').value = formatnomor(total.toFixed(2).toString().replaceAll('.', ',').replaceAll('-', ''));
  }
 //Item-----------------------------------------------------------------------------------------------------------------

 //Kelompok Item--------------------------------------------------------------------------------------------------------

 var kelompok_item = document.querySelector('.kelompok-item').innerHTML;

 function clearKelompokItem()
  { document.getElementById('list-kelompok').innerHTML = '';
    addKelompokItem();
  }

 function addKelompokItem()
  { var new_element = document.createElement('div');
    new_element.className = 'row kelompok-item';
    new_element.innerHTML = kelompok_item;
    document.querySelector('#list-kelompok').appendChild(new_element);
    setNoKelompok();
  }

 function hapusKelompokItem(element)
  { if(document.querySelectorAll('.group-number').length > 1)
     { element.parentNode.parentNode.parentNode.parentNode.parentNode.remove();
       setNoKelompok();
     }
  }

 function setNoKelompok()
  { var a = document.querySelectorAll('.group-number');
    for(var i=0; i<a.length; i++)
     { a[i].innerHTML = angkaKeRomawi(i + 1);
       a[i].parentNode.querySelector('.nomor_kelompok').value = i + 1;
       if(i < a.length - 1)
        { a[i].parentNode.parentNode.querySelector('.btn-add-kelompok').style['display'] = 'none';
          a[i].parentNode.parentNode.querySelector('.btn-hapus-kelompok').style['display'] = 'block';
        }
       else
        { a[i].parentNode.parentNode.querySelector('.btn-add-kelompok').style['display'] = 'block';
        }
     }
    if(document.querySelectorAll('.group-number').length == 1)
     { document.querySelector('.btn-hapus-kelompok').style['display'] = 'none';
     }
    else
     { document.querySelector('.btn-hapus-kelompok').style['display'] = 'block';
     }
  }
 setNoKelompok();

 function angkaKeRomawi(angka)
  { if(!Number.isInteger(angka) || angka < 1)
     { return;
     }
    const romawi = [
     { nilai: 1000, simbol: "M" },
     { nilai: 900, simbol: "CM" },
     { nilai: 500, simbol: "D" },
     { nilai: 400, simbol: "CD" },
     { nilai: 100, simbol: "C" },
     { nilai: 90, simbol: "XC" },
     { nilai: 50, simbol: "L" },
     { nilai: 40, simbol: "XL" },
     { nilai: 10, simbol: "X" },
     { nilai: 9, simbol: "IX" },
     { nilai: 5, simbol: "V" },
     { nilai: 4, simbol: "IV" },
     { nilai: 1, simbol: "I" }
    ];
    let hasil = "";
    for(let item of romawi)
     { while (angka >= item.nilai)
        { hasil += item.simbol;
          angka -= item.nilai;
        }
     }
    return hasil;
  }

 //Kelompok Item--------------------------------------------------------------------------------------------------------

</script>