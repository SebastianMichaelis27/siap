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
 $list_jenis_customer = "<option></option>";
 $query = "select * from jenis_customer order by jenis_customer asc";
 $execute = mysqli_query($koneksi, $query);
 while($row = mysqli_fetch_array($execute))
  { $list_jenis_customer .= "<option value='".$row['id']."'>".$row['jenis_customer']."</option>";
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
  
</style>

<section class='content'>
 <div class='row'>
  <div class='col-md-12'>
   <div class='box box-danger'>
    <div class='box-header with-border'>
     <h3 class='box-title'>Katalog</h3>
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
       <div style='display:inline-block; min-width:180px; float:left;'>
        <select class='form-control' style='text-align:center;' onchange='tampilListView()' id='jenis_customer'>
         <?= $list_jenis_customer ?>
        </select>
       </div>
       <input type='text' class='form-control' placeholder='Cari..' style='max-width:250px; height:35px; float:left;' onkeyup='tampilListView();' onchange='tampilListView();' id='cari'>
       <span style='float:right; padding-top:10px;' id='jlh-halaman'>Jumlah Halaman :</span>
      </div>
     </div>
     <div id='tabelku' class='responsiveku'><input type='hidden' id='txthalaman' value='1'></div>
    </div>
   </div>
  </div>
 </div>
</section>

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

<div id='div-result' style='display:none'></div>

<script>

 $('#jenis_customer').select2({ placeholder : 'Jenis Customer', allowClear : false });
 $('#preview-halaman').select2({ placeholder : 'Pilih', allowClear : false });

 function tampilListView()
  { if(document.getElementById('jenis_customer').value !== '')
     { var formdata = new FormData();
       formdata.append('username', '<?= $_POST['username'] ?>');
       formdata.append('users_level_id', '<?= $_POST['users_level_id'] ?>');
       formdata.append('cabang_id', '<?= $_POST['cabang_id'] ?>');
       formdata.append('token', '<?= $_POST['token'] ?>');
       formdata.append('Nama_Tabel', 'barang');
       formdata.append('maxRecord', 20);
       formdata.append('halaman', document.getElementById('txthalaman').value);
       formdata.append('jenis_customer', document.getElementById('jenis_customer').value);
       formdata.append('cari', document.getElementById('cari').value);
       var ajax = new XMLHttpRequest();
       ajax.addEventListener('load', responseTampilListView, false);
       ajax.open('POST', '<?= $_POST['url'] ?>/action/<?= $_POST['form'] ?>/tampil.php');
       ajax.send(formdata);
     }
    
  }

 function responseTampilListView()
  { $('#tabelku').html(event.srcElement.response);
    document.getElementById('preview-halaman').innerHTML = document.getElementById('temp-preview-halaman').innerHTML;
    document.getElementById('jlh-halaman').innerHTML = 'Jumlah Halaman : ' + formatnomor(document.getElementById('txtnhalaman').value);
  }

 tampilListView();

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
  { document.getElementById('cari').value = '';
    tampilListView();
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