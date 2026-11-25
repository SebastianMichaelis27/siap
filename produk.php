<?php
 include("action/akjja012j19210239.php");
 include("design/url.php");
 mysqli_set_charset($koneksi, "utf8mb4");

 $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
 $currentUrl = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

 function formatAngka($angka)
  { return rtrim(rtrim(number_format($angka ?? 0, 2, ',', '.'), '0'), ',');
  }

 $barang_id = $_GET['barang_id'] ?? '';
 $jenis_customer_id = $_GET['jenis_customer_id'] ?? '';

 $lokasi_folder = "gambar/";
 if(!is_dir($lokasi_folder))
  { mkdir($lokasi_folder, 0755);
  }
 $lokasi_folder .= "barang/";
 if(!is_dir($lokasi_folder))
  { mkdir($lokasi_folder, 0755);
  }

 $sql = $koneksi->prepare("select barang.*, satuan.satuan from barang left join satuan on barang.satuan_id = satuan.id where lower(hex(aes_encrypt(barang.id, '89y8iulM11mmNNggq8176'))) = ?");
 $sql->bind_param("s", $barang_id);
 $sql->execute();
 $result = $sql->get_result();
 $barang = $result->fetch_assoc();
 $barang_id = $barang['id'] ?? '';

 $sql = $koneksi->prepare("select * from jenis_customer where lower(hex(aes_encrypt(id, '89y8iulM11mmNNggq8176'))) = ?");
 $sql->bind_param("s", $jenis_customer_id);
 $sql->execute();
 $result = $sql->get_result();
 $jenis_customer = $result->fetch_assoc();
 $jenis_customer_id = $jenis_customer['id'] ?? '';

 if($barang_id == '' || $jenis_customer_id == '')
  { exit;
  }

 $thumbnail = '';
 $list_foto = '';
 if($barang_id !== '')
  { $lokasi_folder .= $barang_id."/";
    if(!is_dir($lokasi_folder))
     { mkdir($lokasi_folder, 0755);
     }
    $scan = scandir($lokasi_folder);
    $scan = array_values(array_filter($scan, function($var) {
     return ($var !== '.' && $var !== '..');
    }));
    foreach($scan as $file)
     { $list_foto .= $url.'/'.$lokasi_folder.$file;
       if($thumbnail == '')
        { $thumbnail = $url.'/'.str_replace("barang/", "barang-thumbnail/", $lokasi_folder).$file;
        }
     }
  }

 if($thumbnail == '')
  { $thumbnail = $url.'/dist/img/thumbnail.jpg';
  }

 if($list_foto == '')
  { $list_foto = $url.'/dist/img/no_image.jpg';
  }

 $diskon_jenis_customer = array();
 if(isset($barang['diskon_jenis_customer']) && $barang['diskon_jenis_customer'] !== "")
  { $barang['diskon_jenis_customer'] = str_replace('}]"', '}]', str_replace('"[{', '[{', $barang['diskon_jenis_customer']));
    $diskon_jenis_customer = json_decode($barang['diskon_jenis_customer'], true);
    $diskon_jenis_customer = array_column($diskon_jenis_customer, 'diskon', 'jenis_customer_id');
  }
 $diskon = $diskon_jenis_customer[$jenis_customer_id] ?? 0;
 $harga = $barang['harga_jual'] - $diskon;

 $nama_barang = $barang['nama'];
 if($barang['merek'] ?? '' !== '')
  { $nama_barang .= " ".$barang['merek'];
  }
 if($barang['model'] ?? '' !== '')
  { $nama_barang .= " ".$barang['model'];
  }
 if($barang['tipe'] ?? '' !== '')
  { $nama_barang .= " ".$barang['tipe'];
  }
 if($barang['jenis'] ?? '' !== '')
  { $nama_barang .= " ".$barang['jenis'];
  }
 if($barang['kapasitas_pk'] ?? '' !== '')
  { $nama_barang .= " ".formatAngka($barang['kapasitas_pk'])." PK";
  }
 if($barang['btuh'] ?? '' !== '')
  { $nama_barang .= " ".formatAngka($barang['btuh'])." BTU/H";
  }
 if($barang['ukuran'] ?? '' !== '')
  { $nama_barang .= " ".formatAngka($barang['ukuran']);
    if($barang['satuan'] ?? '' !== '')
     { $nama_barang .= " ".$barang['satuan'];
     }
  }

?>
<!DOCTYPE html>
<html>
<head>
 <meta charset="utf-8">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <title>Persediaan</title>
 <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
 <link rel="icon" href="<?= $url ?>/dist/img/favicon.png">

 <meta name="description" content="<?= $nama_barang ?>">

 <!-- Open Graph (Social Media) -->
 <meta property="og:title" content="<?= $nama_barang ?>">
 <meta property="og:description" content="Rp <?= formatAngka($harga) ?>">
 <meta property="og:type" content="website">
 <meta property="og:url" content="<?= $currentUrl ?>">
 <meta property="og:image" content="<?= $thumbnail ?>">
 <meta property="og:image:type" content="image/png">

 <link rel="stylesheet" href="<?= $url ?>/bower_components/font-awesome/css/font-awesome.min.css">
 <link rel="stylesheet" href="<?= $url ?>/style/style-modal.css">
 <link rel="stylesheet" href="<?= $url ?>/style/style-loading.css">
 <style>
  body
   { font-family : 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
     padding : 20px;
     margin : 0px;
     background-color : #d8d8d8;
   }
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
  .item-slide img
   { border-radius : 5px;
   }
  .title-slide
   { position : absolute;
     bottom : 0px;
     background : rgba(0,0,0,0.4);
     padding : 2px 10px;
     width : calc(100% - 20px);
     color : white;
     cursor : pointer;
     user-select : none;
     display : grid;
     grid-template-columns : 1fr auto;
     font-weight : normal;
     border-bottom-left-radius : 5px;
     border-bottom-right-radius : 5px;
   }
  .prev
   { left : 10px;
   }
  .next
   { right : 10px;
   }

  #parent-content
   { display : grid;
     grid-template-columns : 1fr 500px 500px 1fr;
     gap : 10px;
   }
  .deskripsi
   { display : grid;
     grid-template-columns : auto 1fr;
     align-items : stretch;
     padding : 2px 4px;
   }
  .info .deskripsi div
   { padding : 10px;
   }
  .info .deskripsi div:nth-child(2n+1)
   { font-size : 15px;
     font-weight : bold;
   }
  .info .deskripsi div:nth-child(4n+1), .info .deskripsi div:nth-child(4n+2)
   { background-color : #bdead3;
   }
  .info .deskripsi div:nth-child(4n+3), .info .deskripsi div:nth-child(4n+4)
   { background-color : #ecf8ff;
   }

  .harga-sebelum-diskon
   { text-decoration : line-through;
     opacity : 0.5;
   }

  #popUpViewPhoto
   { background-color : rgba(0, 0, 0, 0.86);
   }
  #popUpViewPhoto .modal-content
   { border : 0px;
     background-color : transparent;
   }
  #popUpViewPhoto .btn-tutup
   { float : right;
     margin : 10px 0px;
     color : white;
     padding : 5px;
     border : 1px solid white;
     cursor : pointer;
     user-select : none;
     border-radius : 5px;
   }
  #popUpViewPhoto .modal-dialog
   { width : 100%;
     max-width : 900px;
     margin-left : auto;
     margin-right : auto;
   }

 </style>
</head>
<body>

 <div id="parent-content">
  <div></div>
  <div>
   <div id="slide_banner"><?= $list_foto ?></div>
  </div>
  <div class="info">
   <div class="deskripsi">
    <div>KODE</div>
    <div><?= $barang['kode'] ?></div>
    <div>NAMA BARANG</div>
    <div><?= $barang['nama'] ?></div>
    <div>MEREK</div>
    <div><?= $barang['merek'] ?></div>
    <div>MODEL</div>
    <div><?= $barang['model'] ?></div>
    <div>TIPE</div>
    <div><?= $barang['tipe'] ?></div>
    <div>JENIS</div>
    <div><?= $barang['jenis'] ?></div>
    <div>KAPASITAS</div>
    <div><?= isset($barang['kapasitas_pk']) && $barang['kapasitas_pk'] !== "" ? $barang['kapasitas_pk']." PK" : "" ?></div>
    <div>BTU/H</div>
    <div><?= isset($barang['btuh']) && $barang['btuh'] !== "" ? formatAngka($barang['btuh']) : "" ?></div>
    <div>UKURAN</div>
    <div><?= formatAngka($barang['ukuran']) ?> <?= $barang['satuan'] ?></div>
    <div>HARGA</div>
    <div>
     <?php if($diskon > 0) { ?>
      <div class="harga-sebelum-diskon">Rp. <?= formatAngka($barang['harga_jual']) ?></div>
     <?php } ?>
     <div>Rp. <?= formatAngka($harga ?? 0) ?></div>
    </div>
   </div>
  </div>
  <div></div>
 </div>

 <div class="modal" id="popUpViewPhoto" onclick="hideModal('popUpViewPhoto');">
  <div class="modal-dialog">
   <div class="modal-content">
    <div class="modal-body">
     <div class="btn-tutup">&times; Tutup</div>
     <img src="<?= $url ?>/dist/img/no_image.jpg" style="width:100%;" onclick="event.stopPropagation();">
    </div>
   </div>
  </div>
 </div>

 <script>

  function showModal(id)
   { document.querySelector('body').style['overflow-y'] = 'hidden';
     document.getElementById(id).style.display = 'block';
     document.getElementById(id).querySelector('.modal-content').classList.add('show');
   }

  function hideModal(id)
   { document.querySelector('body').style['overflow-y'] = 'auto';
     document.getElementById(id).querySelector('.modal-content').classList.remove('show');
     document.getElementById(id).style.display = 'none';
   }

  function viewImage(element)
   { var img = element.parentNode.parentNode.querySelector('.item-slide img');
     document.querySelector('#popUpViewPhoto img').src = img.src;
     showModal('popUpViewPhoto');
   }

  //slider---------------------------------------------------------------------------------------------------------------
  var slide_banner = [];
  slide_banner.push(document.getElementById('slide_banner').innerHTML);

  function resize()
   { if(window.innerWidth >= 1000)
      { document.getElementById('parent-content').style['grid-template-columns'] = '1fr 500px 500px 1fr';
      }
     else if(window.innerWidth >= 900)
      { document.getElementById('parent-content').style['grid-template-columns'] = '1fr 450px 450px 1fr';
      }
     else if(window.innerWidth >= 800)
      { document.getElementById('parent-content').style['grid-template-columns'] = '1fr 400px 400px 1fr';
      }
     else if(window.innerWidth >= 700)
      { document.getElementById('parent-content').style['grid-template-columns'] = '1fr 350px 350px 1fr';
      }
     else
      { document.getElementById('parent-content').style['grid-template-columns'] = '1fr';
      }
     if(slide_banner.length > 0)
      { destroySlider('slide_banner');
        initSlider('slide_banner', slide_banner, 0, 1);
      }
   }

  window.addEventListener('resize', function() {
   resize();
  });

  resize();

  function initSlider(sliderId, items, gap, visibleCount = 1)
   { 
     document.getElementById(sliderId).innerHTML = '';
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
                       <div style="position:relative;">
                        <div>
                         <div class="item-slide">
                          <img src="${items[i]}" draggable="false" style="user-select:none; width:` + document.getElementById(sliderId).offsetWidth + `px;">
                         </div>
                        </div>
                        <div class="title-slide">
                         <div class="page">${i + 1}/${items.length}</div>
                         <div onclick="viewImage(this);"><i class="fa fa-search-plus"></i></div>
                        </div>
                       </div>
                      </div>`);
       }
      for(let i=0; i<items.length; i++)
       { slides.push(`<div class="slide">
                       <div style="position:relative;">
                        <div>
                         <div class="item-slide">
                          <img src="${items[i]}" draggable="false" style="user-select:none; width:` + document.getElementById(sliderId).offsetWidth + `px;">
                         </div>
                        </div>
                        <div class="title-slide">
                         <div class="page">${i + 1}/${items.length}</div>
                         <div onclick="viewImage(this);"><i class="fa fa-search-plus"></i></div>
                        </div>
                       </div>
                      </div>`);
       }
      for(let i = 0; i < visibleCount; i++)
       { slides.push(`<div class="slide">
                       <div style="position:relative;">
                        <div>
                         <div class="item-slide">
                          <img src="${items[i]}" draggable="false" style="user-select:none; width:` + document.getElementById(sliderId).offsetWidth + `px;">
                         </div>
                        </div>
                        <div class="title-slide">
                         <div class="page">${i + 1}/${items.length}</div>
                         <div onclick="viewImage(this);"><i class="fa fa-search-plus"></i></div>
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
 
</body>
</html>