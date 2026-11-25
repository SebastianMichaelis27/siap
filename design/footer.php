   <div class='modal fade' id='modalUbahPassword' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
     <div class='modal-dialog'>
      <div class='modal-content'>
       <div class='modal-header'>
        <button type='button' class='close' aria-hidden='true' data-dismiss='modal'>&times</button>
        <h4 class='modal-title'>Ubah Password</h4>
       </div>
       <div class='modal-body'>
        <label>Password Lama</label>
        <input type='password' autocomplete='new-password' class='form-control' id='password-lama'>
        <label>Password Baru</label>
        <input type='password' autocomplete='new-password' class='form-control' id='password-baru'>
        <label>Ulangi Password Baru</label>
        <input type='password' autocomplete='new-password' class='form-control' id='ulangi-password-baru'>
       </div>
       <div class='modal-footer'>
        <button type='button' class='btn btn-default' data-dismiss='modal'>Tidak</button>
        <button type='button' onclick='ubahPassword()' class='btn btn-primary'>Ya</button>
       </div>
      </div>
     </div>
    </div>
   </div>
   <footer class='main-footer'>
    <div class='pull-right hidden-xs'><b>&copy</b> 2025</div>
    <strong>Developed by <a href='https://www.smartsolutiondevelopment.com' target='blank'>PT Smart Solution Development Indonesia</a></strong>
   </footer>
   <div class='control-sidebar-bg'></div>
  </div>
 </form>
 <div id='div-load-pemberitahuan' style='display:none;'></div>
 <div id='div-ubah-password' style='display:none;'></div>

 <?php
  
 ?>

 <script>

  function loadMenu()
   { document.getElementsByClassName('loader')[0].style['display'] = 'block';
     document.getElementsByClassName('loader-block')[0].style['display'] = 'block';
     var formdata = new FormData();
     formdata.append('username', '<?= $_SESSION['username'] ?>');
     formdata.append('token', '<?= $_SESSION['token'] ?>');
     formdata.append('users_level_id', '<?= $_SESSION['users_level_id'] ?>');
     formdata.append('last_actual_link', '<?= $_GET['form'] ?>');
     var ajax = new XMLHttpRequest();
     ajax.addEventListener('load', responseLoadMenu, false);
     ajax.open('POST', '<?= $url ?>/action/index/menu.php');
     ajax.send(formdata);
   }

  function responseLoadMenu()
   { $('#menu-utama').html(event.srcElement.response);
     document.getElementsByClassName('loader')[0].style['display'] = 'none';
     document.getElementsByClassName('loader-block')[0].style['display'] = 'none';
   }

  loadMenu();
  
  function ubahPassword()
   { var pesan = '';
     if(document.getElementById('password-lama').value == '')
      { pesan += '*Password Lama* tidak tidak boleh kosong!\n';
      }
     if(document.getElementById('password-baru').value == '')
      { pesan += '*Password Baru* tidak tidak boleh kosong!\n';
      }
     if(document.getElementById('password-baru').value !== document.getElementById('ulangi-password-baru').value)
      { pesan += '*Ulangi Password* tidak sama dengan *Password Baru*!\n';
      }
     if(pesan !== '')
      { alert(pesan);
      }
     else
      { var formdata = new FormData();
        formdata.append('username', '<?= $_SESSION['username'] ?>');
        formdata.append('token', '<?= $_SESSION['token'] ?>');
        formdata.append('password_lama', document.getElementById('password-lama').value);
        formdata.append('password_baru', document.getElementById('password-baru').value);
        var ajax = new XMLHttpRequest();
        ajax.addEventListener('load', responseUbahPassword, false);
        ajax.open('POST', '<?= $url ?>/action/index/ubah-password.php');
        ajax.send(formdata);
      }
   }

  function responseUbahPassword(event)
   { $('#div-ubah-password').html(event.srcElement.response);
   }

  function loadPemberitahuan()
   { var formdata = new FormData();
     formdata.append('username', '<?= $_SESSION['username'] ?>');
     formdata.append('token', '<?= $_SESSION['token'] ?>');
     formdata.append('cabang_id', '<?= $_SESSION['cabang_id'] ?>');
     var ajax = new XMLHttpRequest();
     ajax.addEventListener('load', responseLoadPemberitahuan, false);
     ajax.open('POST', '<?= $url ?>/action/index/load-pemberitahuan.php');
     ajax.send(formdata);
   }

  //loadPemberitahuan();

  function responseLoadPemberitahuan()
   { $('#div-load-pemberitahuan').html(event.srcElement.response);
     setTimeout(function(){ loadPemberitahuan(); }, 60000);
   }

  function showModal(id)
   { document.getElementById(id).style.display = 'block';
     document.querySelector('body').style['overflow-y'] = 'hidden';
   }

  function hideModal(id)
   { document.getElementById(id).style.display = 'none';
     document.querySelector('body').style['overflow-y'] = 'auto';
   }

  function openTab(element)
   { var parent = element.parentNode.parentNode;
     var list = parent.querySelectorAll('.tab-button');
     list = [].slice.call(list);
     var position = list.indexOf(element);
     parent.querySelectorAll('.tab-button').forEach(btn => {
      btn.classList.remove('active');
     });
     parent.querySelectorAll('.tab-button')[position].classList.add('active');
     parent.querySelectorAll('.tab-content').forEach(tab => {
      tab.classList.remove('active');
     });
     parent.querySelectorAll('.tab-content')[position].classList.add('active');
   }

  function auto_grow(element)
   { element.style.height = "5px";
     element.style.height = (element.scrollHeight)+"px";
   }

  function setTglSampai(label)
   { if(document.getElementById(label.id.toString().replaceAll('dari', 'sampai')).value == '')
      { document.getElementById(label.id.toString().replaceAll('dari', 'sampai')).value = label.value;
      }
     else
      { if(normalisasi_tanggal(label.value) > normalisasi_tanggal(document.getElementById(label.id.toString().replaceAll('dari', 'sampai')).value))
         { document.getElementById(label.id.toString().replaceAll('dari', 'sampai')).value = label.value;
         }
      }
   }

  function setTglDari(label)
   { if(normalisasi_tanggal(document.getElementById(label.id.toString().replaceAll('sampai', 'dari')).value) > normalisasi_tanggal(label.value) || document.getElementById(label.id.toString().replaceAll('sampai', 'dari')).value == '')
      { document.getElementById(label.id.toString().replaceAll('sampai', 'dari')).value = label.value;
      }
   }

 </script>

</body>
</html>