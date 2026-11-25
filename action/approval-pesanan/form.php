<?php
 include("../bjksadkhrej121lkjkjk.php");
?>

<style>
 #popUpKonfirmasi .modal-dialog
  { width : 100%;
    max-width : 900px;
  }
 #popUpKonfirmasi .table > tbody + tbody
  { border : none;
  }
</style>

<section class='content'>
 <input type='hidden' id='edit-id'>
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
       <div style='display:inline-block; float:left;'>
        <select class='form-control' onchange='tampilListView();' id='jenis_list'>
         <option value='Menunggu Konfrimasi'>Menunggu Konfrimasi</option>
         <option value='Diterima'>Diterima</option>
         <option value='Ditolak'>Ditolak</option>
        </select>
       </div>
      </div>
     </div>
     <div id='tabelku' class='responsiveku'><input type='hidden' id='txthalaman' value='1'></div>
    </div>
   </div>
  </div>
 </div>
</section>

<div class='modal' id='popUpKonfirmasi'>
 <div class='modal-dialog'>
  <div class='modal-content'>
   <div class='modal-header'>
    <button type='button' class='close' onclick="hideModal('popUpKonfirmasi');">&times</button>
    <h4 class='modal-title'>Konfirmasi</h4>
   </div>
   <div class='modal-body'></div>
   <div class='modal-footer'>
    <button type='button' class='btn btn-default' onclick="hideModal('popUpKonfirmasi');"><i class='fa fa-close'></i> Batal</button>
    <button type='button' onclick='tolak()' class='btn btn-danger'><i class='fa fa-close'></i> Tolak</button>
    <button type='button' onclick='terima()' class='btn btn-success'><i class='fa fa-check'></i> Terima</button>
   </div>
  </div>
 </div>
</div>

<div id='div-result' style='display:none'></div>

<script>

 var Nama_Tabel = 'pesanan';
 var maxRecord = 20;
 
 tampilListView();

 function tampilListView()
  { var formdata = new FormData();
    formdata.append('username', '<?= $_POST['username'] ?>');
    formdata.append('users_level_id', '<?= $_POST['users_level_id'] ?>');
    formdata.append('cabang_id', '<?= $_POST['cabang_id'] ?>');
    formdata.append('token', '<?= $_POST['token'] ?>');
    formdata.append('Nama_Tabel', Nama_Tabel);
    formdata.append('maxRecord', maxRecord);
    formdata.append('halaman', document.getElementById('txthalaman').value);
    formdata.append('jenis_list', document.getElementById('jenis_list').value);
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

 function refresh()
  { tampilListView();
  }

 function konfirmasi(element)
  { var list = document.getElementsByClassName(element.className);
    list = [].slice.call(list);
    var position = list.indexOf(element);

    var list_item = '';
    var a = document.getElementsByClassName('div-detail_barang')[position];
    for(var i=0; i<a.querySelectorAll('.detail_barang-id').length; i++)
     { var id = a.querySelectorAll('.detail_barang-id')[i].value;
       var barang_id = a.querySelectorAll('.detail_barang-barang_id')[i].value;
       var nama_produk = a.querySelectorAll('.detail_barang-kode')[i].value + ' - ' + a.querySelectorAll('.detail_barang-nama')[i].value;
       if(a.querySelectorAll('.detail_barang-merek')[i].value !== '')
        { nama_produk += ' ' + a.querySelectorAll('.detail_barang-merek')[i].value;
        }
       if(a.querySelectorAll('.detail_barang-model')[i].value !== '')
        { nama_produk += ' ' + a.querySelectorAll('.detail_barang-model')[i].value;
        }
       if(a.querySelectorAll('.detail_barang-tipe')[i].value !== '')
        { nama_produk += ' ' + a.querySelectorAll('.detail_barang-tipe')[i].value;
        }
       if(a.querySelectorAll('.detail_barang-jenis')[i].value !== '')
        { nama_produk += ' ' + a.querySelectorAll('.detail_barang-jenis')[i].value;
        }
       if(a.querySelectorAll('.detail_barang-kapasitas_pk')[i].value !== '')
        { nama_produk += ' ' + a.querySelectorAll('.detail_barang-kapasitas_pk')[i].value + ' PK';
        }
       if(a.querySelectorAll('.detail_barang-btuh')[i].value !== '')
        { nama_produk += ' (' + a.querySelectorAll('.detail_barang-btuh')[i].value + ' BTU/H)';
        }
       var harga = a.querySelectorAll('.detail_barang-harga')[i].value;
       var jenis_ppn = a.querySelectorAll('.detail_barang-jenis_ppn')[i].value;
       var harga_sebelum_ppn = a.querySelectorAll('.detail_barang-harga_sebelum_ppn')[i].value;
       var jumlah = a.querySelectorAll('.detail_barang-jumlah')[i].value;
       var satuan = a.querySelectorAll('.detail_barang-satuan')[i].value;
       var sub_total = a.querySelectorAll('.detail_barang-sub_total')[i].value;
       var sub_total_sebelum_ppn = a.querySelectorAll('.detail_barang-sub_total_sebelum_ppn')[i].value;
       var diskon_item = a.querySelectorAll('.detail_barang-diskon_item')[i].value;
       var diskon_item_detail = '';
       try
        { var dis_item_detail = JSON.parse(a.querySelectorAll('.detail_barang-diskon_item_detail')[i].value);
          for(var j=0; j<dis_item_detail.length; j++)
           { var item_diskon = '';
             if(dis_item_detail[j].jenis == '%')
              { item_diskon = dis_item_detail[j].jumlah + dis_item_detail[j].jenis;
              }
             else
              { item_diskon = dis_item_detail[j].jenis + formatnomor2(dis_item_detail[j].jumlah.toString().replaceAll('.', ','));
              }
             if(diskon_item_detail !== '')
              { diskon_item_detail += ' + ';
              }
             diskon_item_detail += item_diskon;
           }
        }
       catch(err) {}
       var diskon_faktur = a.querySelectorAll('.detail_barang-diskon_faktur')[i].value;
       var nominal_ppn = a.querySelectorAll('.detail_barang-nominal_ppn')[i].value;
       var total = a.querySelectorAll('.detail_barang-total')[i].value;
       var diskon = '';
       if(normal(diskon_item) * 1 > 0)
        { diskon += diskon_item;
        }
       if(normal(diskon_faktur) * 1 > 0)
        { if(diskon == '')
           { diskon += '0 + ';
           }
          else
           { diskon += ' + ';
           }
          diskon += diskon_faktur;
        }
       var dpp = a.querySelectorAll('.detail_barang-dpp')[i].value;
       var nominal_ppn = a.querySelectorAll('.detail_barang-nominal_ppn')[i].value;
       var total = a.querySelectorAll('.detail_barang-total')[i].value;
       list_item += `<tbody class='group-hover'>
                      <tr>
                       <td rowspan='2' style='text-align:right; border:1px solid black;'>` + (i + 1) + `</td>
                       <td rowspan='2' style='border:1px solid black;'>` + nama_produk + `</td>
                       <td rowspan='2' style='text-align:right; border:1px solid black;'>` + jumlah + `</td>
                       <td rowspan='2' style='border:1px solid black;'>` + satuan + `</td>
                       <td rowspan='2' style='text-align:right; border:1px solid black;'>` + harga_sebelum_ppn + `</td>
                       <td style='text-align:center; border:1px solid black;'>` + diskon_item_detail + `</td>
                       <td rowspan='2' style='text-align:right; border:1px solid black;'>` + nominal_ppn + `</td>
                       <td rowspan='2' style='text-align:right; border:1px solid black;'>` + total + `</td>
                      </tr>
                      <tr>
                       <td style='text-align:center; border:1px solid black;'>` + diskon + `</td>
                      </tr>
                     </tbody>`;
     }


    showModal('popUpKonfirmasi');

    document.querySelector('#popUpKonfirmasi .modal-footer .btn-success').style['display'] = 'inline-block';
    if(document.getElementsByClassName('textarea_edit-approved_at')[position].value !== '')
     { document.querySelector('#popUpKonfirmasi .modal-footer .btn-success').style['display'] = 'none';
     }
    document.querySelector('#popUpKonfirmasi .modal-footer .btn-danger').style['display'] = 'inline-block';
    if(document.getElementsByClassName('textarea_edit-rejected_at')[position].value !== '')
     { document.querySelector('#popUpKonfirmasi .modal-footer .btn-danger').style['display'] = 'none';
     }

    document.getElementById('edit-id').value = document.getElementsByClassName('textarea_edit-id')[position].value;
    document.querySelector('#popUpKonfirmasi .modal-body').innerHTML = `
     <div style='display:grid; grid-template-columns:auto auto 1fr; column-gap:10px;'>
      <div><b>Nomor</b></div>
      <div>:</div>
      <div>` + document.getElementsByClassName('textarea_edit-nomor_pesanan')[position].value + `</div>
      <div><b>Nama Customer</b></div>
      <div>:</div>
      <div>` + document.getElementsByClassName('textarea_edit-nama_customer')[position].value + `</div>
     </div>
     <div class='responsiveku'>
     <table class='table' border='1'>
      <thead>
       <tr>
        <th style='border:1px solid black;'>No</th>
        <th style='border:1px solid black;'>Item</th>
        <th style='border:1px solid black;'>Qty</th>
        <th style='border:1px solid black;'>Unit</th>
        <th style='border:1px solid black;'>Price</th>
        <th style='border:1px solid black;'>Discount</th>
        <th style='border:1px solid black;'>PPN</th>
        <th style='border:1px solid black;'>Amount</th>
       </tr>
      </thead>
      ` + list_item + `
     </table>
     </div>
    `;
  }

 function terima()
  { document.getElementsByClassName('loader')[0].style['display'] = 'block';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'block';
    var formdata = new FormData();
    formdata.append('username', '<?= $_POST['username'] ?>');
    formdata.append('users_level_id', '<?= $_POST['users_level_id'] ?>');
    formdata.append('cabang_id', '<?= $_POST['cabang_id'] ?>');
    formdata.append('token', '<?= $_POST['token'] ?>');
    formdata.append('id', document.getElementById('edit-id').value);
    var ajax = new XMLHttpRequest();
    ajax.addEventListener('load', responseTerima, false);
    ajax.open('POST', '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/terima.php');
    ajax.send(formdata);
  }

 function responseTerima()
  { document.getElementsByClassName('loader')[0].style['display'] = 'none';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'none';
    if(event.srcElement.response == '1')
     { hideModal('popUpKonfirmasi');
       tampilListView();
     }
    else
     { alert(event.srcElement.response);
     }
  }

 function tolak()
  { document.getElementsByClassName('loader')[0].style['display'] = 'block';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'block';
    var formdata = new FormData();
    formdata.append('username', '<?= $_POST['username'] ?>');
    formdata.append('users_level_id', '<?= $_POST['users_level_id'] ?>');
    formdata.append('cabang_id', '<?= $_POST['cabang_id'] ?>');
    formdata.append('token', '<?= $_POST['token'] ?>');
    formdata.append('id', document.getElementById('edit-id').value);
    var ajax = new XMLHttpRequest();
    ajax.addEventListener('load', responseTerima, false);
    ajax.open('POST', '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/tolak.php');
    ajax.send(formdata);
  }

</script>