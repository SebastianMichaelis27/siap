<?php
 include("design/url.php");
 if(isset($_POST['btn_login']))
  { $_SESSION['username'] = $_POST['username'];
    $_SESSION['token'] = $_POST['token'];
    $_SESSION['users_level_id'] = $_POST['users_level_id'];
    $_SESSION['cabang_id'] = $_POST['cabang_id'];
    header('Location: dashboard');
  }
 if(isset($_SESSION['username']) && $_SESSION['username'] !== "")
  { header('Location: dashboard');
  }
?>
<html>
<head>
 <meta charset='utf-8'>
 <meta http-equiv='X-UA-Compatible' content='IE=edge'>
 <title>Login</title>
 <meta name='viewport' content='width=device-width, inital-scale=1.0'>
 <link href='dist/img/favicon.png' rel='icon'>
 <link rel='stylesheet' href='style/style-loading.css'>
 <link rel='stylesheet' href='style/style-login.css'>
 <style>
  body
   { background-color : #064381;
   }
  #login
   { max-width : 250px;
     width : 100%;
     height : 420px;
     background : #ffffff;
     position : absolute;
     margin-left : auto;
     margin-right : auto;
     margin-top : auto;
     margin-bottom : auto;
     padding : 20px 20px 20px 20px;
     left : 0;
     right : 0;
     top : 0;
     bottom : 0;
     border-radius : 5px;
     box-shadow : 1px 1px 10px;
     color : black;
   }
  #login img
   { margin-bottom : 12px;
   }
  #login input[type="text"], #login input[type="password"]
   { height : 30px;
     width : 100%;
     margin-bottom : 10px;
     padding-left : 5px;
     padding-right : 5px;
     text-align : center;
   }
  #login input[type="submit"], #login input[type="button"]
   { height : 35px;
     width : 100%;
     background : #0457a7;
     border : 0px solid #bf0a0a;
     color : white;
     font-weight : bold;
     font-size : 18px;
     margin-top : 5px;
     padding : 10px 0px 35px 0px;
     border-radius : 5px;
   }
  #login input[type="submit"]:active, #login input[type="button"]:active
   { background : #064381;
   }
  input[type="text"], select, input[type="password"]
   { width : 150px;
     height : 25px;
     padding : 0px 5px 0px 5px;
     margin-top : 5px;
   }
  input[type='text'], input[type='password']
   { width : 100%;
     text-align : left;
     padding : 1vmin;
     margin-top : 5px;
     border-radius : 0px;
     border : 1px solid silver;
   }
 </style>
</head>
<body>

 <div class='loader'></div>
 <div class='loader-block'></div>

 <div id='login'>
  <img id='img-logo' src='dist/img/logo.png' onload='onLoadLogo();' style='width:100%;'>
  <div id='form-input'>
   <input type='text' autocomplete='new-password' id='username' autofocus  placeholder='Username'>
   <input type='password' autocomplete='new-password' id='password' placeholder='Password' onkeypress='loginEvent(event)'>
   <input type='button' id='btnlogin' onclick='login();' value='L O G I N'>
  </div>
 <div>
 <div id='div-result' style='display:none;'></div>

 <script>
  function loginEvent(evt)
   { var charCode = (evt.which) ? evt.which : event.keyCode;
     if(charCode == "13")
      { document.getElementById('btnlogin').click();
      }
   }

  function login()
   { document.getElementsByClassName('loader')[0].style['display'] = 'block';
     document.getElementsByClassName('loader-block')[0].style['display'] = 'block';
     var formdata = new FormData();
     formdata.append('username', document.getElementById('username').value);
     formdata.append('password', document.getElementById('password').value);
     var ajax = new XMLHttpRequest();
     ajax.addEventListener('load', responseLogin, false);
     ajax.open('POST', '<?= $url ?>/action/index/login.php');
     ajax.send(formdata);
   }

  function responseLogin()
   { try
      { var data = JSON.parse(event.srcElement.response);
        if(data.status == "1")
         { document.getElementById('div-result').innerHTML = `
            <form method='post'>
             <input type='hidden' name='username' id='result-username' value='` + data.username + `'>
             <input type='hidden' name='token' id='result-token' value='` + data.token + `'>
             <input type='hidden' name='users_level_id' id='result-users_level_id' value='` + data.users_level_id + `'>
             <input type='hidden' name='cabang_id' id='result-users_level_id' value='` + data.cabang_id + `'>
             <button type='submit' name='btn_login' id='btn_login'></button>
            </form>
           `;
           document.getElementById('btn_login').click();
         }
        else
         { alert(data.pesan);
         }
      }
     catch(err) { console.log(err); }
     document.getElementsByClassName('loader')[0].style['display'] = 'none';
     document.getElementsByClassName('loader-block')[0].style['display'] = 'none';
   }

 </script>

</body>
</html>