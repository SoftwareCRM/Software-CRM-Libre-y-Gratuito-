// FUNCIONES AVANZADAS SIRVEN CON CSS
function confirmacion(evento) { // ELIMINACION DE UN PRODUCTO
    if(confirm("¿Está seguro que desea eliminar este producto?")){ 
        return true;
    } else {
        evento.preventDefault();
    }
  }

  let linkDelete = document.querySelectorAll(".eliminar_boton");
  for (var i =0; i < linkDelete.length; i++) {
  linkDelete[i].addEventListener('click', confirmacion);
}

// ELIMINACION DE PRODUCTO PARA SIEMPRE
function confirmacion1(evento1) { 
  if(confirm("¿Está seguro que quiere eliminar este producto para siempre?")){
      return true;
  } else {
      evento1.preventDefault();
    }
  }
  
  let linkDeshacer = document.querySelectorAll(".permanente_boton");
  for (var i =0; i < linkDeshacer.length; i++) {
  linkDeshacer[i].addEventListener('click', confirmacion1);
} 

//CONFIRMACION ASCENDER USUARIO
function confirmacion2(evento2) { 
  if(confirm('¿Está seguro que quiere ascender a este usuario de rango?')){
    return true;
  } else {
      evento2.preventDefault();
  }
  }
  
  let linkUsuarioAscenso = document.querySelectorAll(".ascenso_boton_usuario");
  for (var i =0; i < linkUsuarioAscenso.length; i++) {
  linkUsuarioAscenso[i].addEventListener('click', confirmacion2);
}

//CONFIRMACION ELIMINAR FACTURA
function confirmacion3(evento3) { A
  if(confirm("¿Está seguro que quiere eliminar esta factura?")){
      return true;
  } else {
      evento3.preventDefault();
  }
  }
  
  let linkFactura = document.querySelectorAll(".factura");
  for (var i =0; i < linkFactura.length; i++) {
  linkFactura[i].addEventListener('click', confirmacion3);
}

//CONFIRMACION DESCENDER USUARIO
function confirmacion4(evento4) {
  if(confirm('¿Está seguro que quiere descender a este usuario de rango?')){
      return true;
  } else {
      evento4.preventDefault();
  }
  }
  
  let linkUsuarioDescenso = document.querySelectorAll(".descenso");
  for (var i =0; i < linkUsuarioDescenso.length; i++) {
  linkUsuarioDescenso[i].addEventListener('click', confirmacion4);
}

//CONFIRMACION CLIENTE
function confirmacion5(evento5) {
  if(confirm("¿Está seguro que quiere eliminar este cliente para siempre?")){
      return true;
  } else {
      evento5.preventDefault();
    }
  }
  
  let linkDeshacerCliente = document.querySelectorAll(".permanente_cliente_boton");
  for (var i =0; i < linkDeshacerCliente.length; i++) {
  linkDeshacerCliente[i].addEventListener('click', confirmacion5);
} 


// FUNCIONES BASICAS SI Y NO
function pregunta() { // CONFIGURACION DE LOS DATOS DEL PDF
    return confirm('¿Estás seguro que deseas cambiar los datos de la factura?');
}

function preguntaContrasenna() { // CONFIGURACION DE LOS DATOS DEL USUARIO
    return confirm('¿Estás seguro que quieres modificar los datos de su usuario?');
}

function EliminacionProducto() { // ELIMINACION DE PRODUCTO POR USUARIO NORMAL
  return confirm('¿Estás seguro que deseas eliminar este producto?');
}

function EliminacionUsuario() { // ELIMINACION DE USUARIO POR SUPER ADMINISTRADOR
  return confirm('¿Estás seguro que deseas eliminar este usuario?');
}

function EliminarCliente() { // ELIMINACION DE USUARIO POR SUPER ADMINISTRADOR
  return confirm('¿Estás seguro que deseas eliminar a este cliente?');
}


// EVITAR REENVIO DE DATOS.
if (window.history.replaceState) { // verificamos disponibilidad
  window.history.replaceState(null, null, window.location.href);
}



(function () {
  'use strict'


  var forms = document.querySelectorAll('.needs-validation')


  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }

        form.classList.add('was-validated')
      }, false)
    })
})()