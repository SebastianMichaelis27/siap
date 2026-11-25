function hanyaAngka(evt)
 { var charCode = (evt.which) ? evt.which : event.keyCode;
   if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode !== 44)
    { return false;
    }
   else
    { return true;
    }
 }

function hanyaAngka2(evt)
 { var charCode = (evt.which) ? evt.which : event.keyCode;
   if (charCode > 31 && (charCode < 48 || charCode > 57))
    { return false;
    }
   else
    { return true;
    }
 }

function hanyaAngka3(evt)
 { var charCode = (evt.which) ? evt.which : event.keyCode;
   if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode !== 44 && charCode !== 45)
    { return false;
    }
   else
    { return true;
    }
 }

function fnomor(obj)
 { obj.value = formatnomor(obj.value);
 }

function fnomor2(obj)
 { if(obj.value !== '')
    { obj.value = formatnomor2(obj.value);
    }
 }

function normal(x)
 { x = String(x);
   var result = '';
   var koma = 0;
   for(i=1; i<=x.length; i++)
    { if(x.substring((i - 1), i) == ",")
       { koma = koma + 1;
       }
      if(koma <= 1 && (x.substring((i - 1), i) == "0" || x.substring((i - 1), i) == "1" || x.substring((i - 1), i) == "2" || x.substring((i - 1), i) == "3" || x.substring((i - 1), i) == "4" || x.substring((i - 1), i) == "5" || x.substring((i - 1), i) == "6" || x.substring((i - 1), i) == "7" || x.substring((i - 1), i) == "8" || x.substring((i - 1), i) == "9" || x.substring((i - 1), i) == "," || x.substring((i - 1), i) == "-"))
       { if(x.substring((i - 1), i) == ",")
          { if(i == 1)
             { result = '0.' + result;
             }
            else
             { result = result + '.';
             }
          }
         else if(x.substring((i - 1), i) == "-")
          { if(i == 1)
             { result = result + x.substring((i - 1), i);
             }
          }
         else
          { result = result + x.substring((i - 1), i);
          }
       }
    }
   return result;
 }

function formatnomor(x)
 { x = normal(x);
   var bilangan_bulat = '';
   var bilangan_desimal = '';
   var koma = 0;
   for(i=1; i<=x.length; i++)
    { if(x.substring((i - 1), i) == ".")
       { koma = koma + 1;
       }
      if(koma < 1)
       { bilangan_bulat = bilangan_bulat + x.substring((i - 1), i);
       }
      else
       { if(x.substring((i - 1), i) == ".")
          { bilangan_desimal = bilangan_desimal + ',';
          }
         else
          { bilangan_desimal = bilangan_desimal + x.substring((i - 1), i);
          }
       }
    }
   if(bilangan_desimal.toString().length > 2)
    { bilangan_desimal = bilangan_desimal.substring(0, 3);
    }
   return bilangan_bulat.replaceAll(/\B(?=(\d{3})+(?!\d))/g, ".") + bilangan_desimal;
 }

function formatnomor2(x)
 { x = normal(x);
   var bilangan_bulat = '';
   var bilangan_desimal = '';
   var koma = 0;
   for(i=1; i<=x.length; i++)
    { if(x.substring((i - 1), i) == ".")
       { koma = koma + 1;
       }
      if(koma < 1)
       { bilangan_bulat = bilangan_bulat + x.substring((i - 1), i);
       }
      else
       { if(x.substring((i - 1), i) == ".")
          { bilangan_desimal = bilangan_desimal + ',';
          }
         else
          { bilangan_desimal = bilangan_desimal + x.substring((i - 1), i);
          }
       }
    }
   if(bilangan_desimal.toString().length > 2)
    { bilangan_desimal = bilangan_desimal.substring(0, 3);
    }
   if(bilangan_desimal.toString().length == 2)
    { bilangan_desimal = bilangan_desimal.toString() + '0';
    }
   if(bilangan_desimal.toString().length < 2)
    { bilangan_desimal = ',00';
    }
   return bilangan_bulat.replaceAll(/\B(?=(\d{3})+(?!\d))/g, ".") + bilangan_desimal;
 }

function ValidateEmail(mail) 
 { if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail + ''))
    { return true;
    }
   else
    { return false;
    }
 }

function normalisasi_tanggal(tanggal)
 { return tanggal.substr(6, 4) + '-' + tanggal.substr(3, 2) + '-' + tanggal.substr(0, 2);
 }

function getTextSelected(element)
 { return element.options[element.selectedIndex].text;
 }

function showCloseDate(id)
 { if(document.getElementById(id).value == '')
    { document.getElementById('close-' + id).style['display'] = 'none';
    }
   else
    { document.getElementById('close-' + id).style['display'] = 'inline-block';
    }
 }

function removeDate(id)
 { document.getElementById(id.replaceAll('close-', '')).value = '';
   showCloseDate(id.replaceAll('close-', ''))
 }