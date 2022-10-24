function SoloLetras(e){
    key=e.keyCode || e.which;
    teclado=String.fromCharCode(key).toLowerCase();
    letras = " áéíóúabcdefghijklmnñopqrstuvwxyzü"
    especiales = [13,127];
    teclado_especial = false;
    for(var i in especiales){
      if(key==especiales[i]){
        teclado_especial = true;
        break;
      }
    }
    if(letras.indexOf(teclado)==-1 && !teclado_especial){
      alert("Solo letras");
      return false;
    }

}

function Direccion(event){
  key=event.keyCode || event.which;
  teclado=String.fromCharCode(key).toLowerCase();
  letras = " áéíóúabcdefghijklmnñopqrstuvwxyzü0123456789"
  especiales = [13,44,45,46,95];
  teclado_especial = false;

  for(var i in especiales){
    if(key==especiales[i]){
      teclado_especial = true;
      break;
    }
  }
  if(letras.indexOf(teclado)==-1 && !teclado_especial){
    alert("Solo letras y números");
    return false;
  }
}


function Correo(el){
  key=el.keyCode || el.which;
  teclado=String.fromCharCode(key).toLowerCase();
  letras = " áéíóúabcdefghijklmnñopqrstuvwxyzü0123456789"
  especiales = [13,44,45,46,64];
  teclado_especial = false;
  for(var i in especiales){
    if(key==especiales[i]){
      teclado_especial = true;
      break;
    }
  }
  if(letras.indexOf(teclado)==-1 && !teclado_especial){
    alert("Sin carácteres especiales");
    return false;
  }
}


