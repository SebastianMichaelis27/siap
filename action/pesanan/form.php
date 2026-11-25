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
 #popUpPenawaran .modal-dialog
  { width : 100%;
    max-width : 900px;
  }
</style>
<a id='link-cetak' target='#blank'></a>
<section class='content'>
 <input type='hidden' id='edit-id'>
 <span id='filterKu' style='display:none;'>[]</span>
 <div class='box box-default'>
  <div class='box-header with-border'>
   <h3 class='box-title'>Pesanan</h3>
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
        <div style='display:inline-block; font-weight:bold; position:absolute; top:-10px; background:white;'>Pesanan<span id='nomor_pesanan'></span></div>
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
            <div style='color:red' class='error' id='error-cabang_id'></div>
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
            <div style='color:red' class='error' id='error-tanggal'></div>
           </div>
          </div>
          <div class='row' style='margin-top:5px;'>
           <div class='col-md-4' style='padding-top:7px;'>
            <label>Nomor PO</label>
           </div>
           <div class='col-md-8'>
            <input type='text' autocomplete='new-password' class='form-control fieldku' id='nomor_po'>
            <div style='color:red' class='error' id='error-nomor_po'></div>
           </div>
          </div>
         </div>
         <div class='col-md-6'>
          <div class='row'>
           <div class='col-md-4' style='padding-top:7px;'>
            <label>Batas Waktu *</label>
           </div>
           <div class='col-md-8'>
            <div style='display:grid; grid-template-columns:1fr auto; gap:5px;'>
             <input type='text' class='form-control fieldku batas_waktu' autocomplete='new-password' onkeypress='return hanyaAngka(this);' onkeyup='fnomor(this);' onfocus='this.select();' style='text-align:right;' id='batas_waktu'>
             <div style='padding-top:7px;'>Hari</div>
            </div>
            <div style='color:red' class='error' id='error-batas_waktu'></div>
           </div>
          </div>
          <div class='row' style='margin-top:5px;'>
           <div class='col-md-4' style='padding-top:7px;'>
            <label>Sales *</label>
           </div>
           <div class='col-md-8'>
            <select class='form-control fieldku' style='width:100%;' id='karyawan_id'>
             <option></option>
            </select>
            <div style='color:red' class='error' id='error-karyawan_id'></div>
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
            <div style='color:red' class='error' id='error-customer_id'></div>
            <div style='color:red' class='error' id='error-nama_customer'></div>
           </div>
          </div>
          <div class='row' style='margin-top:5px;'>
           <div class='col-md-4' style='padding-top:7px;'>
            <label>Alamat *</label>
           </div>
           <div class='col-md-8'>
            <input type='text' class='form-control fieldku fieldku2' autocomplete='new-password' id='alamat_customer'>
            <div style='color:red' class='error' id='error-alamat_customer'></div>
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
          <div class='row' style='margin-top:5px;'>
           <div class='col-md-4' style='padding-top:7px;'>
            <label>Credit Limit *</label>
           </div>
           <div class='col-md-8'>
            <input type='text' class='form-control fieldku fieldku2' onkeypress='return hanyaAngka(this);' onkeyup='fnomor(this);' onchange='fnomor(this);' onfocus='this.select();' onfocusout='fnomor2(this);' style='text-align:right;' id='credit_limit_customer'>
            <div style='color:red' class='error' id='error-credit_limit_customer'></div>
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
        <div style='display:inline-block; font-weight:bold; position:absolute; top:-10px; background:white;'>Item</div>
        <div class='row'>
         <div class='col-md-12'>
          <button type='button' class='btn btn-success' onclick='addBarang();'><i class='fa fa-plus'></i> Tambah Barang</button>
          <button type='button' class='btn btn-warning' onclick='addJasa();'><i class='fa fa-plus'></i> Tambah Jasa</button>
          <button type='button' class='btn btn-primary' onclick='addPenawaran();'><i class='fa fa-plus'></i> Tambah Dari Penawaran</button>
          <div class='error' style='color:red;' id='error-detail'></div>
          <div class='responsiveku'>
           <div id='div-item'></div>
          </div>
         </div>
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
     <h3 class='box-title'>List Pesanan</h3>
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
          <div style='color:red' class='error' id='error-customer-jenis_customer_id'></div>
         </div>
        </div>
        <div class='row' style='margin-top:5px;'>
         <div class='col-md-4' style='padding-top:7px;'>
          <label>Nama *</label>
         </div>
         <div class='col-md-8'>
          <input type='text' class='form-control fieldku3' autocomplete='new-password' id='customer-nama'>
          <div style='color:red' class='error' id='error-customer-nama'></div>
         </div>
        </div>
        <div class='row' style='margin-top:5px;'>
         <div class='col-md-4' style='padding-top:7px;'>
          <label>Alamat *</label>
         </div>
         <div class='col-md-8'>
          <input type='text' class='form-control fieldku3' autocomplete='new-password' id='customer-alamat'>
          <div style='color:red' class='error' id='error-customer-alamat'></div>
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
        <div class='row' style='margin-top:5px;'>
         <div class='col-md-4' style='padding-top:7px;'>
          <label>Credit Limit *</label>
         </div>
         <div class='col-md-8'>
          <input type='text' class='form-control fieldku3' onkeypress='return hanyaAngka(this);' onkeyup='fnomor(this);' onchange='fnomor(this);' onfocus='this.select();' onfocusout='fnomor2(this);' style='text-align:right;' id='customer-credit_limit'>
          <div style='color:red' class='error' id='error-customer-credit_limit'></div>
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

<div class='modal' id='popUpPenawaran'>
 <div class='modal-dialog'>
  <div class='modal-content'>
   <div class='modal-header'>
    <button type='button' class='close' onclick="hideModal('popUpPenawaran');">&times</button>
    <h4 class='modal-title'>Pilih Penawaran</h4>
   </div>
   <div class='modal-body'>
    <div class='row'>
     <div class='col-md-12'>
      <input type='button' class='btn btn-default' value='&laquo' style='float:left; height:35px;' onclick='previousPagePenawaran()'>
      <div style='display:inline-block; max-width:80px; float:left;'>
       <select class='form-control halaman' style='text-align:center; width:100%;' onchange='goToPagePenawaran(this.value);' id='preview-halaman-penawaran'>
        <option value='1' selected>1</option>
       </select>
      </div>
      <input type='button' class='btn btn-default' value='&raquo' style='float:left; height:35px;' onclick='nextPagePenawaran()'>
      <button type='button' class='btn btn-default' style='float:left; height:35px;' onclick='refreshPenawaran();'><i class='fa fa-refresh'></i></button>
      <input type='text' class='form-control' autocomplete='new-password' placeholder='Cari..' style='max-width:250px; height:35px; float:left;' onkeyup='tampilPenawaran();' onchange='tampilPenawaran();' id='txtcaripenawaran'>
      <span style='float:right; padding-top:10px;' id='jlh-halaman-penawaran'>Jumlah Halaman :</span>
     </div>
    </div>
    <div id='tabelkupenawaran' class='responsiveku'><input type='hidden' id='txthalamanpenawaran' value='1'></div>
   </div>
   <div class='modal-footer'>
    <button type='button' class='btn btn-default' onclick="hideModal('popUpPenawaran');"><i class='fa fa-close'></i> Batal</button>
   </div>
  </div>
 </div>
</div>

<div id='div-result' style='display:none'></div>

<script>

 var Nama_Tabel = 'pesanan';
 var FieldTidakBolehRangkap = [];
 var FieldRequired = [
  {field : 'cabang_id', label : 'Cabang'},
  {field : 'tanggal', label : 'Tanggal'},
  {field : 'batas_waktu', label : 'Batas Waktu'},
  {field : 'karyawan_id', label : 'Sales'},
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

 clearBarang();
 tampilListView();
 clearNoTelpCustomer();
 clearNoWaCustomer();
 clearEmailCustomer();

 function validasi()
  { var no_telp_customer = [];
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

    var a = document.getElementsByClassName('fieldku');
    for(var loop=0; loop<a.length; loop++)
     { if(a[loop].value !== '')
        { if(a[loop].id == 'tanggal')
           { data[a[loop].id] = normalisasi_tanggal(a[loop].value);
           }
          else if(a[loop].id == 'sub_total' || a[loop].id == 'persen_diskon' || a[loop].id == 'diskon' || a[loop].id == 'dpp' || a[loop].id == 'persen_ppn' || a[loop].id == 'ppn' || a[loop].id == 'total')
           { data[a[loop].id] = normal(a[loop].value) * 1;
           }
          else if(a[loop].id == 'batas_waktu' || a[loop].id == 'credit_limit_customer' || a[loop].id == 'sub_total' || a[loop].id == 'persen_diskon' || a[loop].id == 'diskon' || a[loop].id == 'dpp' || a[loop].id == 'persen_ppn' || a[loop].id == 'ppn' || a[loop].id == 'total')
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
    var detail = [];
    var jumlah = 0;
    var a = document.getElementsByClassName('detail_id');
    for(var i=0; i<a.length; i++)
     { if(normal(document.getElementsByClassName('jumlah')[i].value) * 1 > 0)
        { var valueToPush = {};
          valueToPush.id = document.getElementsByClassName('detail_id')[i].value;
          valueToPush.penawaran_detail_id = document.getElementsByClassName('penawaran_detail_id')[i].value;
          valueToPush.barang_id = document.getElementsByClassName('barang_id')[i].value;
          valueToPush.jasa_id = document.getElementsByClassName('jasa_id')[i].value;
          valueToPush.nama_produk = document.getElementsByClassName('nama_produk')[i].value;
          valueToPush.satuan = document.getElementsByClassName('satuan')[i].value;
          valueToPush.harga = normal(document.getElementsByClassName('harga')[i].value) * 1;
          valueToPush.jenis_ppn = document.getElementsByClassName('jenis_ppn')[i].value;
          valueToPush.harga_sebelum_ppn = normal(document.getElementsByClassName('harga_sebelum_ppn')[i].value) * 1;
          valueToPush.jumlah = normal(document.getElementsByClassName('jumlah')[i].value) * 1;
          valueToPush.sub_total = normal(document.getElementsByClassName('sub_total')[i].value) * 1;
          valueToPush.sub_total_sebelum_ppn = normal(document.getElementsByClassName('sub_total_sebelum_ppn')[i].value) * 1;
          valueToPush.diskon_item = normal(document.getElementsByClassName('diskon_item')[i].value) * 1;
          valueToPush.diskon_item_detail = document.getElementsByClassName('diskon_item_detail')[i].value;
          valueToPush.diskon_faktur = normal(document.getElementsByClassName('diskon_faktur')[i].value) * 1;
          valueToPush.dpp = normal(document.getElementsByClassName('dpp')[i].value) * 1;
          valueToPush.persen_ppn = normal(document.getElementById('persen_ppn').value) * 1;
          valueToPush.nominal_ppn = normal(document.getElementsByClassName('nominal_ppn')[i].value) * 1;
          valueToPush.total = normal(document.getElementsByClassName('total')[i].value) * 1;
          detail.push(valueToPush);
          jumlah += normal(document.getElementsByClassName('jumlah')[i].value) * 1;
        }
     }
    data['detail'] = detail;
    data['jumlah'] = jumlah;
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
    clearBarang();
    clearNoTelpCustomer();
    clearNoWaCustomer();
    clearEmailCustomer();
    document.getElementById('nomor_pesanan').innerHTML = '';
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
    clearBarang();
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

    var a = document.getElementsByClassName('div-detail_barang')[position];
    for(var i=0; i<a.querySelectorAll('.detail_barang-id').length; i++)
     { var id = a.querySelectorAll('.detail_barang-id')[i].value;
       var barang_id = a.querySelectorAll('.detail_barang-barang_id')[i].value;
       var jasa_id = a.querySelectorAll('.detail_barang-jasa_id')[i].value;
       var penawaran_detail_id = a.querySelectorAll('.detail_barang-penawaran_detail_id')[i].value;
       var nomor_penawaran = a.querySelectorAll('.detail_barang-nomor_penawaran')[i].value;
       var nama_produk = a.querySelectorAll('.detail_barang-nama_produk')[i].value;
       var harga = a.querySelectorAll('.detail_barang-harga')[i].value;
       var jenis_ppn = a.querySelectorAll('.detail_barang-jenis_ppn')[i].value;
       var harga_sebelum_ppn = a.querySelectorAll('.detail_barang-harga_sebelum_ppn')[i].value;
       var jumlah = a.querySelectorAll('.detail_barang-jumlah')[i].value;
       var sub_total = a.querySelectorAll('.detail_barang-sub_total')[i].value;
       var sub_total_sebelum_ppn = a.querySelectorAll('.detail_barang-sub_total_sebelum_ppn')[i].value;
       var diskon_item = a.querySelectorAll('.detail_barang-diskon_item')[i].value;
       var diskon_item_detail = a.querySelectorAll('.detail_barang-diskon_item_detail')[i].value;
       var diskon_faktur = a.querySelectorAll('.detail_barang-diskon_faktur')[i].value;
       var dpp = a.querySelectorAll('.detail_barang-dpp')[i].value;
       var nominal_ppn = a.querySelectorAll('.detail_barang-nominal_ppn')[i].value;
       var total = a.querySelectorAll('.detail_barang-total')[i].value;
       var satuan = a.querySelectorAll('.detail_barang-satuan')[i].value;
       addDetail(id, penawaran_detail_id, nomor_penawaran, barang_id, jasa_id, nama_produk, satuan, harga, jenis_ppn, harga_sebelum_ppn, jumlah, satuan, sub_total, sub_total_sebelum_ppn, diskon_item, diskon_item_detail, diskon_faktur, dpp, nominal_ppn, total);
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

    document.getElementById('nomor_pesanan').innerHTML = " : " + document.getElementsByClassName('textarea_edit-nomor_pesanan')[position].value;
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
  {field : 'credit_limit', label : 'Credit Limit'},
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
          else if(a[loop].id.toString().replaceAll('customer-', '') == 'no_telp')
           { data[a[loop].id.toString().replaceAll('customer-', '')] = no_telp;
           }
          else if(a[loop].id.toString().replaceAll('customer-', '') == 'no_wa')
           { data[a[loop].id.toString().replaceAll('customer-', '')] = no_wa;
           }
          else if(a[loop].id.toString().replaceAll('customer-', '') == 'email')
           { data[a[loop].id.toString().replaceAll('customer-', '')] = email;
           }
          else if(a[loop].id.toString().replaceAll('customer-', '') == 'credit_limit')
           { data[a[loop].id.toString().replaceAll('customer-', '')] = normal(a[loop].value);
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

 function addJasa()
  { document.getElementsByClassName('loader')[0].style['display'] = 'block';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'block';
    tampilJasa();
  }

 function tampilJasa()
  { var formdata = new FormData();
    formdata.append('username', '<?= $_POST['username'] ?>');
    formdata.append('users_level_id', '<?= $_POST['users_level_id'] ?>');
    formdata.append('cabang_id', '<?= $_POST['cabang_id'] ?>');
    formdata.append('token', '<?= $_POST['token'] ?>');
    formdata.append('Nama_Tabel', 'jasa');
    formdata.append('maxRecord', maxRecord);
    formdata.append('halaman', document.getElementById('txthalamanjasa').value);
    formdata.append('cari', document.getElementById('txtcarijasa').value);
    var ajax = new XMLHttpRequest();
    ajax.addEventListener('load', responseTampilJasa, false);
    ajax.open('POST', '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/tampil-jasa.php');
    ajax.send(formdata);
  }

 function responseTampilJasa()
  { document.getElementsByClassName('loader')[0].style['display'] = 'none';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'none';
    $('#tabelkujasa').html(event.srcElement.response);
    document.getElementById('preview-halaman-jasa').innerHTML = document.getElementById('temp-preview-halaman-jasa').innerHTML;
    document.getElementById('jlh-halaman-jasa').innerHTML = 'Jumlah Halaman : ' + document.getElementById('txtnhalamanjasa').value;
    showModal('popUpJasa');
  }

 function addBarang()
  { document.getElementsByClassName('loader')[0].style['display'] = 'block';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'block';
    tampilBarang();
  }

 function tampilBarang()
  { var formdata = new FormData();
    formdata.append('username', '<?= $_POST['username'] ?>');
    formdata.append('users_level_id', '<?= $_POST['users_level_id'] ?>');
    formdata.append('cabang_id', '<?= $_POST['cabang_id'] ?>');
    formdata.append('token', '<?= $_POST['token'] ?>');
    formdata.append('Nama_Tabel', 'barang');
    formdata.append('maxRecord', maxRecord);
    formdata.append('halaman', document.getElementById('txthalamanbarang').value);
    formdata.append('cari', document.getElementById('txtcaribarang').value);
    formdata.append('customer_id', document.getElementById('customer_id').value);
    var ajax = new XMLHttpRequest();
    ajax.addEventListener('load', responseTampilBarang, false);
    ajax.open('POST', '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/tampil-barang.php');
    ajax.send(formdata);
  }

 function responseTampilBarang()
  { document.getElementsByClassName('loader')[0].style['display'] = 'none';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'none';
    $('#tabelkubarang').html(event.srcElement.response);
    document.getElementById('preview-halaman-barang').innerHTML = document.getElementById('temp-preview-halaman-barang').innerHTML;
    document.getElementById('jlh-halaman-barang').innerHTML = 'Jumlah Halaman : ' + document.getElementById('txtnhalamanbarang').value;
    showModal('popUpBarang');
  }

 function nextPageBarang()
  { var hal = document.getElementById('txthalamanbarang').value;
    hal++;
    document.getElementById('txthalamanbarang').value = hal;
    tampilBarang();
  }

 function previousPageBarang()
  { var hal = document.getElementById('txthalamanbarang').value;
    hal--;
    document.getElementById('txthalamanbarang').value = hal;
    tampilBarang();
  }

 function goToPageBarang(value)
  { document.getElementById('txthalamanbarang').value = value;
    tampilBarang();
  }

 function refreshBarang()
  { document.getElementById('txtcaribarang').value = '';
    tampilBarang();
  }

 function lihatGambar(element)
  { showModal('popUpViewFoto');
    var list = document.getElementsByClassName(element.className);
    list = [].slice.call(list);
    var position = list.indexOf(element);
    var a = document.getElementsByClassName('list_foto')[position].querySelectorAll('textarea');
    slide_banner = [];
    for(var i=0; i<a.length; i++)
     { var new_element = document.createElement('div');
       new_element.innerHTML = `<div class='item-slide'>
                                 <img src='` + a[i].value + `' draggable='false' style='user-select:none; width:100%;'>
                                </div>`;
       slide_banner.push(new_element.innerHTML);
     }
    resize();
  }

 function clearBarang()
  { document.getElementById('div-item').innerHTML = `
     <table class='table table-bordered' style='margin-top:5px;' id='table-detail'>
      <thead>
       <tr>
        <th style='text-align:center; width:50px; min-width:50px; max-width:50px;'>No.</th>
        <th style='min-width:300px;'>Nama Barang</th>
        <th style='text-align:center; width:160px; min-width:160px; max-width:160px;'>Harga</th>
        <th style='text-align:center; width:150px; min-width:150px; max-width:150px;'>PPN</th>
        <th style='text-align:center; width:100px; min-width:100px; max-width:100px;'>Jumlah</th>
        <th style='text-align:center; width:100px; min-width:100px; max-width:100px;'>Satuan</th>
        <th style='text-align:center; width:160px; min-width:160px; max-width:160px;'>Diskon</th>
        <th style='text-align:center; width:160px; min-width:160px; max-width:160px;'>Total</th>
        <th style='text-align:center; width:60px; min-width:60px; max-width:60px;'>Del</th>
       </tr>
       <tbody>
        <tr class='group-hover'>
         <th colspan='7'>Sub Total</th>
         <td>
          <input type='text' class='form-control fieldku' style='text-align:right;' readOnly id='sub_total'>
         </td>
         <td></td>
        </tr>
        <tr class='group-hover'>
         <td colspan='6'>Diskon</td>
         <td>
          <div style='position:relative;'>
           <input type='text' class='form-control fieldku' id='persen_diskon' onkeypress='return hanyaAngka(this);' onkeyup='hitungDiskon(this);' onchange='hitungDiskon(this);' onfocus='this.select();' onfocusout='fnomor2(this);' style='text-align:right; padding-right:20px;'>
           <div style='position:absolute; top:7px; right:7px;'>%</div>
          </div>
         </td>
         <td>
          <input type='text' class='form-control fieldku' id='diskon' onkeypress='return hanyaAngka(this);' onkeyup='hitungDiskon(this);' onchange='hitungDiskon(this);' onfocus='this.select();' onfocusout='fnomor2(this);' style='text-align:right;'>
         </td>
         <td></td>
        </tr>
        <tr class='group-hover'>
         <th colspan='7'>DPP</th>
         <td>
          <input type='text' class='form-control fieldku' id='dpp' readOnly style='text-align:right;'>
         </td>
         <td></td>
        </tr>
        <tr class='group-hover'>
         <td colspan='6'>PPN</td>
         <td>
          <div style='position:relative;'>
           <input type='text' class='form-control fieldku' id='persen_ppn' onkeypress='return hanyaAngka(this);' onfocus='this.select();' onkeyup='hitungKeseluruhan(this);' onchange='hitungKeseluruhan(this);' onfocusout='fnomor2(this);' style='text-align:right; padding-right:20px;'>
           <div style='position:absolute; top:7px; right:7px;'>%</div>
          </div>
         </td>
         <td>
          <input type='text' class='form-control fieldku' id='ppn' onkeypress='return hanyaAngka(this);' readonly style='text-align:right;'>
         </td>
         <td></td>
        </tr>
        <tr class='group-hover'>
         <th colspan='7'>Total</th>
         <td>
          <input type='text' class='form-control fieldku' id='total' readOnly style='text-align:right;'>
         </td>
         <td></td>
        </tr>
       </tbody>
      </thead>
     </table>
    `;
  }

 function pilihBarang(element)
  { var list = document.getElementsByClassName(element.className);
    list = [].slice.call(list);
    var position = list.indexOf(element);
    var barang_id = document.getElementsByClassName('textarea_barang-id')[position].value;
    var jasa_id = '';
    var nama_produk = document.getElementsByClassName('textarea_barang-kode')[position].value + ' - ' + document.getElementsByClassName('textarea_barang-nama')[position].value;
    if(document.getElementsByClassName('textarea_barang-merek')[position].value !== '')
     { nama_produk += ' ' + document.getElementsByClassName('textarea_barang-merek')[position].value
     }
    if(document.getElementsByClassName('textarea_barang-model')[position].value !== '')
     { nama_produk += ' ' + document.getElementsByClassName('textarea_barang-model')[position].value
     }
    if(document.getElementsByClassName('textarea_barang-tipe')[position].value !== '')
     { nama_produk += ' ' + document.getElementsByClassName('textarea_barang-tipe')[position].value;
     }
    if(document.getElementsByClassName('textarea_barang-jenis')[position].value !== '')
     { nama_produk += ' ' + document.getElementsByClassName('textarea_barang-jenis')[position].value;
     }
    if(document.getElementsByClassName('textarea_barang-kapasitas_pk')[position].value !== '')
     { nama_produk += ' ' + document.getElementsByClassName('textarea_barang-kapasitas_pk')[position].value + ' PK';
     }
    if(document.getElementsByClassName('textarea_barang-kapasitas_pk')[position].value !== '')
     { nama_produk += ' (' + document.getElementsByClassName('textarea_barang-btuh')[position].value + ' BTU/H)';
     }
    if(document.getElementsByClassName('textarea_barang-ukuran')[position].value !== '')
     { nama_produk += ' ' + document.getElementsByClassName('textarea_barang-ukuran')[position].value;
       if(document.getElementsByClassName('textarea_barang-satuan')[position].value !== '')
        { nama_produk += ' ' + document.getElementsByClassName('textarea_barang-satuan')[position].value;
        }
     }
    var satuan = document.getElementsByClassName('textarea_barang-satuan')[position].value;
    var harga = document.getElementsByClassName('textarea_barang-harga_jual')[position].value;
    var diskon_item_detail = document.getElementsByClassName('textarea_barang-diskon_item_detail')[position].value;
    var penawaran_detail_id = '';
    var nomor_penawaran = '';
    addDetail('', penawaran_detail_id, nomor_penawaran, barang_id, jasa_id, nama_produk, satuan, harga, '', '', '', satuan, '', '', '', diskon_item_detail, '', '', '', '');
  }

 function pilihJasa(element)
  { var list = document.getElementsByClassName(element.className);
    list = [].slice.call(list);
    var position = list.indexOf(element);
    var barang_id = '';
    var jasa_id = document.getElementsByClassName('textarea_jasa-id')[position].value;
    var nama_produk = document.getElementsByClassName('textarea_jasa-jasa')[position].value;
    var satuan = '';
    var harga = document.getElementsByClassName('textarea_jasa-harga')[position].value;
    var diskon_item_detail = '';
    var penawaran_detail_id = '';
    var nomor_penawaran = '';
    addDetail('', penawaran_detail_id, nomor_penawaran, barang_id, jasa_id, nama_produk, satuan, harga, '', '', '', satuan, '', '', '', diskon_item_detail, '', '', '', '');
  }

 function addDetail(id, penawaran_detail_id, nomor_penawaran, barang_id, jasa_id, nama_produk, satuan, harga, jenis_ppn, harga_sebelum_ppn, jumlah, satuan, sub_total, sub_total_sebelum_ppn, diskon_item, diskon_item_detail, diskon_faktur, dpp, nominal_ppn, total)
  { //var option_ppn = "<option value='Non PPN'>Non PPN</option><option value='Belum PPN'>Belum PPN</option><option value='Termasuk PPN'>Termasuk PPN</option>";
    var option_ppn = "<option value='Belum PPN'>Belum PPN</option><option value='Termasuk PPN'>Termasuk PPN</option>";
    option_ppn = option_ppn.replaceAll("value='" + jenis_ppn + "'", "value='" + jenis_ppn + "' selected");

    var onclick = " onclick='showDiskonItem(this);'";
    if(jenis_ppn == 'Termasuk PPN')
     { onclick = '';
     }

    var view_diskon_item = '';
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

    var nBarang = null;
    if(barang_id !== '')
     { nBarang = document.getElementsByClassName('barang_id-' + barang_id);
     }
    else
     { nBarang = document.getElementsByClassName('jasa_id-' + jasa_id);
     }
    if(nBarang.length == 0)
     { var newChild = document.createElement('tr');
       newChild.className = 'row-detail group-hover';
       newChild.innerHTML = `
        <td style='text-align:right;'></td>
        <td>
         <input type='hidden' class='detail_id' value='` + id + `'>
         <input type='hidden' class='barang_id barang_id-` + barang_id + `' value='` + barang_id + `'>
         <input type='hidden' class='jasa_id jasa_id-` + jasa_id + `' value='` + jasa_id + `'>
         <input type='text' class='form-control nama_produk' value='` + nama_produk + `'>
         <small>` + nomor_penawaran + `</small>
         <input type='hidden' class='penawaran_detail_id' value='` + penawaran_detail_id + `'>
        </td>
        <td style='text-align:right;'>
         <input type='text' class='form-control harga' onkeypress='return hanyaAngka(this);' onkeyup='hitungKeseluruhan(this);' onchange='hitungKeseluruhan(this);' onfocus='this.select();' onfocusout='fnomor2(this);' style='text-align:right;' value='` + harga + `'>
         <input type='hidden' class='harga_sebelum_ppn' value='` + harga_sebelum_ppn + `'>
        </td>
        <td style='text-align:center;'>
         <select class='form-control jenis_ppn' onchange='changeJenisPPN(this);'>` + option_ppn + `</select>
        </td>
        <td style='text-align:right;'>
         <input type='text' class='form-control jumlah' onkeypress='return hanyaAngka(this);' onkeyup='hitungKeseluruhan(this);' onchange='hitungKeseluruhan(this);' onfocus='this.select();' onfocusout='fnomor2(this);' style='text-align:right;' value='` + jumlah + `'>
        </td>
        <td><input type='text' class='form-control satuan' value='` + satuan + `'></td>
        <td style='text-align:right;'>
         <div class='input-disable'` + onclick + `>
          <div class='view-diskon_item'>` + view_diskon_item + `</div>
         </div>
         <textarea style='display:none;' class='diskon_item_detail'>` + diskon_item_detail + `</textarea>
         <input type='hidden' class='diskon_item' value='` + diskon_item + `'>
         <input type='hidden' class='diskon_faktur' value='` + diskon_faktur + `'>
        </td>
        <td style='text-align:right;'>
         <input type='text' class='form-control sub_total' style='text-align:right;' readOnly value='` + sub_total + `'>
         <input type='hidden' class='sub_total_sebelum_ppn' value='` + sub_total_sebelum_ppn + `'>
         <input type='hidden' class='dpp' value='` + dpp + `'>
         <input type='hidden' class='nominal_ppn' value='` + nominal_ppn + `'>
         <input type='hidden' class='total' value='` + total + `'>
        </td>
        <td style='text-align:center;'>
         <button type='button' class='btn btn-danger btn-drop-detail' onclick='dropDetail(this);'><i class='fa fa-trash'></i></button>
        </td>
       `;
       var parent = document.querySelector('#table-detail tbody');
       parent.insertBefore(newChild, parent.children[document.querySelectorAll('.row-detail').length] || null);
       setNomorUrut();
       hideModal('popUpBarang');
       hideModal('popUpJasa');
     }
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
    document.querySelector('#popUpDiskon .modal-title').innerHTML = document.getElementsByClassName('nama_produk')[position].value;
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
    hitung();
    hideModal('popUpDiskon');
  }

 function setNomorUrut()
  { var a = document.querySelectorAll('.row-detail');
    for(var i=0; i<a.length; i++)
     { a[i].querySelector('td').innerHTML = (i + 1);
     }
    hitung();
  }

 function dropDetail(element)
  { var list = document.getElementsByClassName(element.className);
    list = [].slice.call(list);
    var position = list.indexOf(element);
    var elem = document.getElementsByClassName('row-detail')[position];
    elem.parentNode.removeChild(elem);
    setNomorUrut();
  }

 function changeJenisPPN(element)
  { var list = document.getElementsByClassName(element.className);
    list = [].slice.call(list);
    var position = list.indexOf(element);
    if(document.getElementsByClassName('jenis_ppn')[position].value == 'Non PPN')
     { document.getElementsByClassName('view-diskon_item')[position].parentNode.setAttribute('onclick', 'showDiskonItem(this);');
     }
    else if(document.getElementsByClassName('jenis_ppn')[position].value == 'Belum PPN')
     { document.getElementsByClassName('view-diskon_item')[position].parentNode.setAttribute('onclick', 'showDiskonItem(this);');
     }
    else if(document.getElementsByClassName('jenis_ppn')[position].value == 'Termasuk PPN')
     { document.getElementsByClassName('diskon_item')[position].value = '';
       document.getElementsByClassName('view-diskon_item')[position].innerHTML = '';
       document.getElementsByClassName('view-diskon_item')[position].parentNode.removeAttribute('onclick');
     }
    hitung();
  }

 function hitungDiskon(element)
  { if(is_edit !== 1)
     { fnomor(element);
       if(element.id == 'persen_diskon')
        { is_edit = 1;
          var sub_total = normal(document.getElementById('sub_total').value) * 1;
          var persen_diskon = normal(document.getElementById('persen_diskon').value) * 1;
          var diskon = sub_total * persen_diskon / 100;
          document.getElementById('diskon').value = formatnomor2(diskon.toString().replaceAll('.', ','));
          is_edit = 0;
        }
       if(element.id == 'diskon')
        { is_edit = 1;
          document.getElementById('persen_diskon').value = '';
          is_edit = 0;
        }
       hitung();
     }
  }

 function hitungKeseluruhan(element)
  { fnomor(element);
    hitung();
  }

 function hitungDiskonItem(jumlah, harga_sebelum_ppn, position)
  { var diskon_item = 0;
    var temp_jumlah_harga = harga_sebelum_ppn;
    try
     { var diskon_item_detail = JSON.parse(document.getElementsByClassName('diskon_item_detail')[position].value);
       for(var j=0; j<diskon_item_detail.length; j++)
        { var temp_diskon = 0
          if(diskon_item_detail[j].jenis == '%')
           { temp_diskon = temp_jumlah_harga * diskon_item_detail[j].jumlah / 100;
           }
          else
           { temp_diskon = diskon_item_detail[j].jumlah * 1;
           }
          diskon_item += temp_diskon;
          temp_jumlah_harga -= temp_diskon;
        }
     }
    catch(err) { }
    diskon_item = diskon_item * jumlah;
    return diskon_item;
  }

 function hitung()
  { if(is_edit !== 1)
     { var diskon = normal(document.getElementById('diskon').value) * 1;
       var persen_ppn = normal(document.getElementById('persen_ppn').value) * 1;
       var persen_diskon = normal(document.getElementById('persen_diskon').value) * 1;
       var keseluruhan_sub_total_sebelumnya = normal(document.getElementById('sub_total').value) * 1;
       var a = document.getElementsByClassName('jenis_ppn');

       var dasar_perhitungan_diskon_faktur = 0;
       var ada_diskon_faktur = 0;
       for(var i=0; i<a.length; i++)
        { if(a[i].value == 'Non PPN' || a[i].value == 'Belum PPN')
           { var harga_sebelum_ppn = normal(document.getElementsByClassName('harga')[i].value) * 1;
             var jumlah = normal(document.getElementsByClassName('jumlah')[i].value) * 1;
             var diskon_item = normal(document.getElementsByClassName('diskon_item')[i].value) * 1;
             var sub_total_sebelum_ppn = (harga_sebelum_ppn * jumlah) - diskon_item;
             dasar_perhitungan_diskon_faktur += sub_total_sebelum_ppn;
             ada_diskon_faktur++;
           }
        }
       if(ada_diskon_faktur == 0)
        { is_edit = 1;
          document.getElementById('persen_diskon').value = '';
          document.getElementById('diskon').value = '';
          document.getElementById('persen_diskon').readOnly = true;
          document.getElementById('diskon').readOnly = true;
          is_edit = 0;
        }
       else
        { document.getElementById('persen_diskon').readOnly = false;
          document.getElementById('diskon').readOnly = false;
        }

       for(var i=0; i<a.length; i++)
        { if(a[i].value == 'Non PPN')
           { var harga = normal(document.getElementsByClassName('harga')[i].value) * 1;
             var harga_sebelum_ppn = normal(document.getElementsByClassName('harga')[i].value) * 1;
             var jumlah = normal(document.getElementsByClassName('jumlah')[i].value) * 1;
             
             var diskon_item = hitungDiskonItem(jumlah, harga_sebelum_ppn, i);
             document.getElementsByClassName('diskon_item')[i].value = formatnomor2(diskon_item.toString().replaceAll('.', ','));

             var sub_total = (harga * jumlah) - diskon_item;
             var sub_total_sebelum_ppn = (harga_sebelum_ppn * jumlah) - diskon_item;
             var diskon_faktur = 0;
             if(sub_total_sebelum_ppn > 0 && dasar_perhitungan_diskon_faktur > 0)
              { diskon_faktur = (sub_total_sebelum_ppn / dasar_perhitungan_diskon_faktur) * diskon;
              }
             var dpp = 0;
             var nominal_ppn = 0;
             var total = sub_total - diskon_faktur;

             document.getElementsByClassName('harga_sebelum_ppn')[i].value = formatnomor2(harga_sebelum_ppn.toString().replaceAll('.', ','));
             document.getElementsByClassName('sub_total')[i].value = formatnomor2(sub_total.toString().replaceAll('.', ','));
             document.getElementsByClassName('sub_total_sebelum_ppn')[i].value = formatnomor2(sub_total_sebelum_ppn.toString().replaceAll('.', ','));
             document.getElementsByClassName('diskon_faktur')[i].value = formatnomor2(diskon_faktur.toString().replaceAll('.', ','));
             document.getElementsByClassName('dpp')[i].value = formatnomor2(dpp.toString().replaceAll('.', ','));
             document.getElementsByClassName('nominal_ppn')[i].value = formatnomor2(nominal_ppn.toString().replaceAll('.', ','));
             document.getElementsByClassName('total')[i].value = formatnomor2(total.toString().replaceAll('.', ','));
           }
          else if(a[i].value == 'Belum PPN')
           { var harga = normal(document.getElementsByClassName('harga')[i].value) * 1;
             var harga_sebelum_ppn = normal(document.getElementsByClassName('harga')[i].value) * 1;
             var jumlah = normal(document.getElementsByClassName('jumlah')[i].value) * 1;
             
             var diskon_item = hitungDiskonItem(jumlah, harga_sebelum_ppn, i);
             document.getElementsByClassName('diskon_item')[i].value = formatnomor2(diskon_item.toString().replaceAll('.', ','));
             
             var sub_total = (harga * jumlah) - diskon_item;
             var sub_total_sebelum_ppn = (harga_sebelum_ppn * jumlah) - diskon_item;
             var diskon_faktur = 0;
             if(sub_total_sebelum_ppn > 0 && dasar_perhitungan_diskon_faktur > 0)
              { diskon_faktur = (sub_total_sebelum_ppn / dasar_perhitungan_diskon_faktur) * diskon;
              }
             var dpp = sub_total_sebelum_ppn - diskon_faktur;
             var nominal_ppn = 0;
             if(persen_ppn > 0)
              { nominal_ppn = Math.round((persen_ppn / 100) * dpp);
              }
             var total = dpp + nominal_ppn;

             document.getElementsByClassName('harga_sebelum_ppn')[i].value = formatnomor2(harga_sebelum_ppn.toString().replaceAll('.', ','));
             document.getElementsByClassName('sub_total')[i].value = formatnomor2(sub_total.toString().replaceAll('.', ','));
             document.getElementsByClassName('sub_total_sebelum_ppn')[i].value = formatnomor2(sub_total_sebelum_ppn.toString().replaceAll('.', ','));
             document.getElementsByClassName('diskon_faktur')[i].value = formatnomor2(diskon_faktur.toString().replaceAll('.', ','));
             document.getElementsByClassName('dpp')[i].value = formatnomor2(dpp.toString().replaceAll('.', ','));
             document.getElementsByClassName('nominal_ppn')[i].value = formatnomor2(nominal_ppn.toString().replaceAll('.', ','));
             document.getElementsByClassName('total')[i].value = formatnomor2(total.toString().replaceAll('.', ','));
           }
          else if(a[i].value == 'Termasuk PPN')
           { var harga = normal(document.getElementsByClassName('harga')[i].value) * 1;
             var harga_sebelum_ppn = harga / ((100 + persen_ppn) / 100);
             var jumlah = normal(document.getElementsByClassName('jumlah')[i].value) * 1;
             var diskon_item = 0;
             var sub_total = harga * jumlah;
             var sub_total_sebelum_ppn = harga_sebelum_ppn * jumlah;
             var diskon_faktur = 0;
             var dpp = sub_total_sebelum_ppn;
             var nominal_ppn = Math.round((persen_ppn / 100) * dpp);
             var total = sub_total;

             document.getElementsByClassName('harga_sebelum_ppn')[i].value = formatnomor2(harga_sebelum_ppn.toString().replaceAll('.', ','));
             document.getElementsByClassName('sub_total')[i].value = formatnomor2(sub_total.toString().replaceAll('.', ','));
             document.getElementsByClassName('sub_total_sebelum_ppn')[i].value = formatnomor2(sub_total_sebelum_ppn.toString().replaceAll('.', ','));
             document.getElementsByClassName('diskon_faktur')[i].value = formatnomor2(diskon_faktur.toString().replaceAll('.', ','));
             document.getElementsByClassName('dpp')[i].value = formatnomor2(dpp.toString().replaceAll('.', ','));
             document.getElementsByClassName('nominal_ppn')[i].value = formatnomor2(nominal_ppn.toString().replaceAll('.', ','));
             document.getElementsByClassName('total')[i].value = formatnomor2(total.toString().replaceAll('.', ','));
           }
        }

       var sub_total_keseluruhan = 0;
       var dpp_keseluruhan = 0;
       var ppn_keseluruhan = 0;
       var total_keseluruhan = 0;
       for(var i=0; i<a.length; i++)
        { sub_total_keseluruhan += normal(document.getElementsByClassName('sub_total')[i].value) * 1;
          dpp_keseluruhan += normal(document.getElementsByClassName('dpp')[i].value) * 1;
          ppn_keseluruhan += normal(document.getElementsByClassName('nominal_ppn')[i].value) * 1;
          total_keseluruhan += normal(document.getElementsByClassName('total')[i].value) * 1;
        }
       document.getElementById('sub_total').value = formatnomor2(sub_total_keseluruhan.toString().replaceAll('.', ','));
       document.getElementById('dpp').value = formatnomor2(dpp_keseluruhan.toString().replaceAll('.', ','));
       document.getElementById('ppn').value = formatnomor2(ppn_keseluruhan.toString().replaceAll('.', ','));
       document.getElementById('total').value = formatnomor2(total_keseluruhan.toString().replaceAll('.', ','));

       if(keseluruhan_sub_total_sebelumnya !== sub_total_keseluruhan && persen_diskon > 0)
        { hitungDiskon(document.getElementById('persen_diskon'));
        }
     }
  }

 function cetak(element)
  { var list = document.getElementsByClassName('cetak');
    list = [].slice.call(list);
    var position = list.indexOf(element);
    document.getElementsByClassName('loader')[0].style['display'] = 'block';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'block';
    var formdata = new FormData();
    formdata.append('username', '<?= $_POST['username'] ?>');
    formdata.append('users_level_id', '<?= $_POST['users_level_id'] ?>');
    formdata.append('cabang_id', '<?= $_POST['cabang_id'] ?>');
    formdata.append('token', '<?= $_POST['token'] ?>');
    formdata.append('id', document.getElementsByClassName('textarea_edit-id')[position].value);
    var ajax = new XMLHttpRequest();
    ajax.addEventListener('load', responseCetak, false);
    ajax.open('POST', '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/cetak.php');
    ajax.send(formdata);
  }

 function responseCetak()
  { document.getElementsByClassName('loader')[0].style['display'] = 'none';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'none';
    document.getElementById('link-cetak').href = event.srcElement.response;
    document.getElementById('link-cetak').click();
  }
  
 //Item-----------------------------------------------------------------------------------------------------------------

 //Penawaran------------------------------------------------------------------------------------------------------------

 function addPenawaran()
  { var error = 0;
    document.getElementById('error-cabang_id').innerHTML = '';
    document.getElementById('error-nama_customer').innerHTML = '';
    if(document.getElementById('cabang_id').value == '')
     { error++;
       document.getElementById('error-cabang_id').innerHTML = '<b>Gudang</b> wajib dipilih';
     }
    if(document.getElementById('customer_id').value == '')
     { error++;
       document.getElementById('error-nama_customer').innerHTML = '<b>Customer</b> wajib dipilih';
     }
    if(error == 0)
     { document.getElementsByClassName('loader')[0].style['display'] = 'block';
       document.getElementsByClassName('loader-block')[0].style['display'] = 'block';
       tampilPenawaran();
     }
  }

 function tampilPenawaran()
  { var formdata = new FormData();
    formdata.append('username', '<?= $_POST['username'] ?>');
    formdata.append('users_level_id', '<?= $_POST['users_level_id'] ?>');
    formdata.append('cabang_id', '<?= $_POST['cabang_id'] ?>');
    formdata.append('token', '<?= $_POST['token'] ?>');
    formdata.append('Nama_Tabel', 'penawaran');
    formdata.append('maxRecord', maxRecord);
    formdata.append('halaman', document.getElementById('txthalamanpenawaran').value);
    formdata.append('cari', document.getElementById('txtcaripenawaran').value);
    formdata.append('cabng_id', document.getElementById('cabang_id').value);
    formdata.append('customer_id', document.getElementById('customer_id').value);
    var ajax = new XMLHttpRequest();
    ajax.addEventListener('load', responseTampilPenawaran, false);
    ajax.open('POST', '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/tampil-penawaran.php');
    ajax.send(formdata);
  }

 function responseTampilPenawaran()
  { document.getElementsByClassName('loader')[0].style['display'] = 'none';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'none';
    $('#tabelkupenawaran').html(event.srcElement.response);
    document.getElementById('jlh-halaman-penawaran').innerHTML = 'Jumlah Halaman : ' + document.getElementById('txtnhalamanpenawaran').value;
    document.getElementById('preview-halaman-penawaran').innerHTML = document.getElementById('temp-preview-halaman-penawaran').innerHTML;
    showModal('popUpPenawaran');
  }

 function nextPagePenawaran()
  { var hal = document.getElementById('txthalamanpenawaran').value;
    hal++;
    document.getElementById('txthalamanpenawaran').value = hal;
    tampilPenawaran();
  }

 function previousPagePenawaran()
  { var hal = document.getElementById('txthalamanpenawaran').value;
    hal--;
    document.getElementById('txthalamanpenawaran').value = hal;
    tampilPenawaran();
  }

 function goToPagePenawaran(value)
  { document.getElementById('txthalamanpenawaran').value = value;
    tampilPenawaran();
  }

 function refreshPenawaran()
  { document.getElementById('txtcaripenawaran').value = '';
    tampilPenawaran();
  }

 function pilihPenawaran(element)
  { var list = document.getElementsByClassName(element.className);
    list = [].slice.call(list);
    var position = list.indexOf(element);

    is_edit = 1;
    document.getElementById('persen_diskon').value = document.getElementsByClassName('textarea_penawaran-persen_diskon')[position].value;
    document.getElementById('diskon').value = document.getElementsByClassName('textarea_penawaran-diskon')[position].value;
    document.getElementById('persen_ppn').value = document.getElementsByClassName('textarea_penawaran-persen_ppn')[position].value;

    var nomor_penawaran = document.getElementsByClassName('textarea_penawaran-nomor_penawaran')[position].value;
    var a = document.getElementsByClassName('div_penawaran-detail_barang')[position];
    for(var i=0; i<a.querySelectorAll('.detail_barang-id').length; i++)
     { var id = '';
       var penawaran_detail_id = a.querySelectorAll('.detail_barang-id')[i].value;
       var penawaran_id = a.querySelectorAll('.detail_barang-penawaran_id')[i].value;
       var barang_id = a.querySelectorAll('.detail_barang-barang_id')[i].value;
       var jasa_id = a.querySelectorAll('.detail_barang-jasa_id')[i].value;
       var harga = a.querySelectorAll('.detail_barang-harga')[i].value;
       var jenis_ppn = a.querySelectorAll('.detail_barang-jenis_ppn')[i].value;
       var harga_sebelum_ppn = a.querySelectorAll('.detail_barang-harga_sebelum_ppn')[i].value;
       var jumlah = a.querySelectorAll('.detail_barang-jumlah')[i].value;
       var jumlah_ditandai = '0';
       var ditandai = '[]';
       var sub_total = a.querySelectorAll('.detail_barang-sub_total')[i].value;
       var sub_total_sebelum_ppn = a.querySelectorAll('.detail_barang-sub_total_sebelum_ppn')[i].value;
       var diskon_item = a.querySelectorAll('.detail_barang-diskon_item')[i].value;
       var diskon_item_detail = a.querySelectorAll('.detail_barang-diskon_item_detail')[i].value;
       var diskon_faktur = a.querySelectorAll('.detail_barang-diskon_faktur')[i].value;
       var dpp = a.querySelectorAll('.detail_barang-dpp')[i].value;
       var nominal_ppn = a.querySelectorAll('.detail_barang-nominal_ppn')[i].value;
       var total = a.querySelectorAll('.detail_barang-total')[i].value;
       var nama_produk = a.querySelectorAll('.detail_barang-nama_produk')[i].value;
       var satuan = a.querySelectorAll('.detail_barang-satuan')[i].value;;
       addDetail(id, penawaran_detail_id, nomor_penawaran, barang_id, jasa_id, nama_produk, satuan, harga, jenis_ppn, harga_sebelum_ppn, jumlah, satuan, sub_total, sub_total_sebelum_ppn, diskon_item, diskon_item_detail, diskon_faktur, dpp, nominal_ppn, total)
     }
    document.getElementById('karyawan_id').innerHTML = document.getElementsByClassName('select_penawaran-karyawan_id')[position].innerHTML;
    $('#karyawan_id').trigger('change');
    is_edit = 0;

    hitung();

    hideModal('popUpPenawaran');
  }

 //Penawaran------------------------------------------------------------------------------------------------------------

 //slider---------------------------------------------------------------------------------------------------------------
 var slide_banner = [];

 function resize()
  { if(slide_banner.length > 0)
     { destroySlider('slide_banner');
       initSlider('slide_banner', slide_banner, 0, 1);
     }
  }

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
 //slider---------------------------------------------------------------------------------------------------------------

</script>