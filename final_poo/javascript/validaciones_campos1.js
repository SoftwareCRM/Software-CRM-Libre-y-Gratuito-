function SoloLetras(e){
    key=e.keyCode || e.which;
    teclado=String.fromCharCode(key).toLowerCase();
    letras = " áéíóúabcdefghijklmnñopqrstuvwxyzü"
    especiales = [8,13,37,38,46,128,129,164,249];
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

function SoloNumeros(evt){
    if(window.event){
    keynum = evt.keyCode;
    }
    else{
    keynum = evt.which;
    }

    if((keynum > 47 && keynum < 58) || keynum == 8 || keynum== 13 || keynum == 46){
    return true;
    } else {
    alert("Ingresar solo números positivos");
    return false;
    }
}

function RIF(ev){
    key=ev.keyCode || ev.which;
    teclado=String.fromCharCode(key).toLowerCase();
    letras = " abcdefghijklmnñopqrstuvwxyz0123456789"
    especiales = [8,13,38,45,46,128,129,164,249];
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
  especiales = [13,44,45,46,64,95];
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

function Telefono(evento){
    key=evento.keyCode || evento.which;
    teclado=String.fromCharCode(key).toLowerCase();
    letras = " 0123456789"
    especiales = [44,45,46];
    teclado_especial = false;
    for(var i in especiales){
      if(key==especiales[i]){
        teclado_especial = true;
        break;
      }
    }
    if(letras.indexOf(teclado)==-1 && !teclado_especial){
      alert("Solo números");
      return false;
    }
}

function Pie(even){
  key=even.keyCode || even.which;
  teclado=String.fromCharCode(key).toLowerCase();
  letras = " áéíóúabcdefghijklmnñopqrstuvwxyzü0123456789¡¿!?"
  especiales = [33,44,45,46,63,168,173];
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
  especiales = [44,45,46,64];
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


