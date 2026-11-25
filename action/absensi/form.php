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

<section class='content'>
 <div class='row'>
  <div class='col-md-offset-3 col-md-6'>

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
</section>

<button type='button' class='btn-add' onclick='showPopUpFoto();'>
 <i class='fa fa-plus'></i>
</button>

<div class='modal' id='popUpFoto'>
 <div class='modal-dialog'>
  <div class='modal-content'>
   <div class='modal-header'>
    <button type='button' class='close' onclick='closePopUpFoto();'>&times</button>
    <h4 class='modal-title'>Konfirmasi</h4>
   </div>
   <div class='modal-body'>
    <div class='row'>
     <div class='col-md-4'>
      <label>Jenis Absensi *</label>
     </div>
     <div class='col-md-8'>
      <select class='form-control fieldku' style='width:100%;' id='jenis_absen'>
       <option></option>
       <option value='Masuk'>Masuk</option>
       <option value='Pulang'>Pulang</option>
      </select>
      <div style='color:red' class='error' id='error-jenis_absen'></div>
     </div>
    </div>
    <div class='row' style='margin-top:5px;'>
     <div class='col-md-4'>
      <label>Foto *</label>
     </div>
     <div class='col-md-8'>
      <video id='video' style='width:100%; max-width:300px;' autoplay></video>
      <canvas id='canvas' style='display:none;'></canvas>
     </div>
    </div>
   </div>
   <div class='modal-footer'>
    <button type='button' class='btn btn-default' onclick='closePopUpFoto();'><i class='fa fa-close'></i> Batal</button>
    <button type='button' onclick='simpan()' class='btn btn-primary'><i class='fa fa-save'></i> Simpan</button>
   </div>
  </div>
 </div>
</div>

<script>

 var Nama_Tabel = 'absensi';
 var maxRecord = 5;

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
  { document.getElementById('form-listview').style['height'] = document.getElementsByClassName('content-wrapper')[0].clientHeight + 'px';
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

 function showPopUpFoto()
  { startCamera();
    showModal('popUpFoto');
  }

 function closePopUpFoto()
  { stopCamera();
    hideModal('popUpFoto');
  }
  
 //Camera---------------------------------------------------------------------------------------------------------------------------------------------

 function startCamera()
  { startStream({ video: true, audio: false });
  }

 var stream = null;

 const startStream = async (constraints) => {
  if('mediaDevices' in navigator && 'getUserMedia' in navigator.mediaDevices)
   { try
      { const permissionStatus = await navigator.permissions.query({ name: 'camera' });
        if(permissionStatus.state === 'denied')
         { alert('Izin Kamera diblokir. Silahkan memberi izin penggunaan Kamera pada browser anda.');
         }
        else
         { stream = await navigator.mediaDevices.getUserMedia(constraints);
           document.querySelector("#video").srcObject = stream;
         }
      }
     catch(error)
      { if (error.name === 'NotAllowedError')
         { alert('Izin Kamera diblokir atau ditolak. Silahkan memberi izin penggunaan Kamera pada browser anda.');
         }
        else if(error.name === 'NotFoundError')
         { alert('Perangkat Kamera tidak ditemukan');
         }
        else
         { console.error('Unexpected error accessing camera :', error);
         }
      }
   }
  else
   { alert('Browser ini tidak mendukung untuk pengambilan gambar! Silahkan gunakan browser lain');
   }
 }

 function stopCamera()
  { try
     { stream.getTracks().forEach(function(track) {
        track.stop();
       });
     }
    catch(err) {}
  }

 function dataURLtoFile(dataurl, filename)
  { var arr = dataurl.split(','), mime = arr[0].match(/:(.*?);/)[1], bstr = atob(arr[1]),  n = bstr.length,  u8arr = new Uint8Array(n);
    while(n--)
     { u8arr[n] = bstr.charCodeAt(n);
     } 
    return new File([u8arr], filename, {type:mime});
  }

 function simpan()
  { console.log();
    var error = 0;
    if(document.getElementById('jenis_absen').value == '')
     { error++;
       document.getElementById('error-jenis_absen').innerHTML = '<b>Jenis Absen</b> wajib diisi!';
     }
    else
     { document.getElementById('error-jenis_absen').innerHTML = '';
     }
    if(stream !== null)
     { if(stream.active == false)
        { error++;
          startCamera();
        }
     }
    else
     { error++;
       startCamera();
     }
    if(error == 0)
     { document.getElementsByClassName('loader')[0].style['display'] = 'block';
       document.getElementsByClassName('loader-block')[0].style['display'] = 'block';
       var canvas = document.getElementById('canvas');     
       var video = document.getElementById('video');
       canvas.width = video.videoWidth;
       canvas.height = video.videoHeight;
       canvas.getContext('2d').drawImage(video, 0, 0, video.videoWidth, video.videoHeight);  
       let image_data_url = canvas.toDataURL('image/jpeg');
       var formdata = new FormData();
       formdata.append('username', '<?= $_POST['username'] ?>');
       formdata.append('users_level_id', '<?= $_POST['users_level_id'] ?>');
       formdata.append('cabang_id', '<?= $_POST['cabang_id'] ?>');
       formdata.append('token', '<?= $_POST['token'] ?>');
       formdata.append('jenis_absen', document.getElementById('jenis_absen').value);
       formdata.append('file', dataURLtoFile(image_data_url));
       var ajax = new XMLHttpRequest();
       ajax.addEventListener("load", responseSimpan, false);
       ajax.open('POST', '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/simpan.php');
       ajax.send(formdata);
     }
  }

 function responseSimpan()
  { document.getElementsByClassName('loader')[0].style['display'] = 'none';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'none';
    if(event.srcElement.response == '1')
     { closePopUpFoto();
       resetFormListView();
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
 //Camera---------------------------------------------------------------------------------------------------------------------------------------------

</script>