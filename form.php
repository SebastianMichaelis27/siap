<?php include("design/header.php"); ?>

<div id='form'></div>

<?php include("design/footer.php"); ?>

<script>

 function loadForm()
  { document.getElementsByClassName('loader')[0].style['display'] = 'block';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'block';
    var formdata = new FormData();
    formdata.append('username', '<?= $_SESSION['username'] ?>');
    formdata.append('users_level_id', '<?= $_SESSION['users_level_id'] ?>');
    formdata.append('cabang_id', '<?= $_SESSION['cabang_id'] ?>');
    formdata.append('token', '<?= $_SESSION['token'] ?>');
    formdata.append('form', '<?= $_GET['form'] ?>');
    formdata.append('url', '<?= $url ?>');
    var ajax = new XMLHttpRequest();
    ajax.addEventListener('load', responseLoadFormInput, false);
    ajax.open('POST', '<?= $url ?>/action/<?= $_GET['form'] ?>/form.php', false);
    ajax.send(formdata);
  }

 function responseLoadFormInput(event)
  { document.getElementsByClassName('loader')[0].style['display'] = 'none';
    document.getElementsByClassName('loader-block')[0].style['display'] = 'none';
    $('#form').html(event.srcElement.response);
  }

 loadForm();

 function makeSelect2Search(id, url, add_params, allowClear = true)
  { $('#' + id).select2({
     minimumInputLength : 1,
     placeholder : '',
     allowClear : allowClear,
     ajax : {
      dataType : 'json',
      url : url,
      delay : 800,
      data : function(params) {
       var rtrn = { search: params.term };
       for(var key in add_params)
        { rtrn[key] = add_params[key];
        }
       return rtrn;
      },
      processResults: function (data, page) {
       return { results: data };
      },
     },
    });
  }

</script>