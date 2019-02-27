<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Usuarios</title>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

   

      <link href="../css/style.css" rel="stylesheet">
  </head>
  <body>

<?php include("includes/submenu.php") ?>

      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4" id="main">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Usuarios</h1>
        <div class="alert alert-danger" id="infoD" style="display: none;"></div>
        <div class="alert alert-success" id="infoS" style="display: none;"></div>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group mr-2">
            <button type="button" class="btn btn-sm btn-outline-danger cancelar">Cancelar</button>
            <button type="button" class="btn btn-sm btn-outline-success" id="nuevo_registro" >Nuevo</button>
          </div>
        </div>
      </div>

      <div class="table-responsive view" id="show_data">
        <table class="table table-striped table-sm" id="list_usuarios">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Teléfono</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            
          </tbody>
        </table>
      </div>
       <div id="insert_data" class="view">
       <form action="#" id="form_data">
  <div class="row">
  <div class="col">
       <div class="form-group">
       <label for="nombre">Nombre</label>
       <input type="text" id="nombre" name="nombre" class="form-control">
     </div>
       <div class="form-group">
        <label for="correo">Correo</label>
       <input type="email" id="email" name="email" class="form-control">
       </div>
       </div>
  <div class="col">
        <div class="form-group">
        <label for="telefono">Teléfono</label>
       <input type="tel" id="telefono" name="telefono" class="form-control">
       </div>
       <div class="form-group">
        <label for="password">Contraseña</label>
       <input type="password" id="password" name="password" class="form-control">
       </div>
     </div>
     </div>
     <div class="row">
       <div class="col">
         <button type="button" class="btn btn-success " id="guardar_datos">Guardar</button>
       </div>
     </div>
     </div>
       </form>
    </main>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>  
<script>
  //todas las vitas se ocultan
  //pregunto que vista esta visible
  //pregunto cual es la vista que se va mostrar
  
  function change_view(vista ='show_data'){
    $("#main").find(".view").each(function() {
      $(this).slideUp('fast');
      let id=$(this).attr("id");
      if (vista==id) {
        $(this).slideDown(300);
      }
      
    });

  }

  function  consultar(){
    let obj = {
      "action" : "consultar_usuarios"
    };

    $.post('includes/_funciones.php', obj, function(respuesta) {
     let template = ``;
    $.each(r, function(i, e) {
    template += `
            <tr>
          <td>${e.usr_nombre}</td>
          <td>${e.usr_telefono}</td>
          <td>
                <a href="#" data-id="${e.id_usr}" class="editar_registro">Editar</a>
                <a href="#" data-id="${e.id_usr}" class="eliminar_registro">Eliminar</a>
              </td>
            </tr>
          `;
    });
    $("#list_usuarios tbody").html(template);
  }, "JSON");
  }
  $("#nuevo_registro").click(function() {
   change_view('insert_data');
   });

  $("#guardar_datos").click(function(r) {
            let usr_nombre = $("#inputNombre").val();
            let usr_correo = $("#inputCorreo").val();
            let usr_telefono = $("#inputTelefono").val();
            let usr_password = $("#inputPassword").val();
            let obj = {
    "accion": "insertar_usuario",
                "nombre": usr_nombre,
                "mail": usr_correo,
                "tel": usr_telefono,
                "pass": usr_password
   }

   $("#form_data").find("input").each(function(){
    $(this).removeClass("has-error");
   if ($(this).val() != "") {
      obj[$(this).prop("name")] = $(this).val();
   }else{
    $(this).addClass("has-error").focus();
    return false;
   }
  });

   if (mail == "" || pswd == "" || tel == "" || nombre == "") {

    $("#infoD").html("Completa Todos los Campos").show().delay(2000).fadeOut(400);

    }else{

   $.post('includes/_funciones.php', obj, function(a) {

    if (a == "1") {
       $("#infoS").html("usuario Insertado ").show().delay(2000).fadeOut(400); 
       $("#form_data")[0].reset();
     } else {
       $("#infoD").html("error al Insertar").show().delay(2000).fadeOut(400);
     }

   });

   }

});

$(function eliminar_registro(){

  $("#list_usuarios").on("click",".eliminar_registro", function(e){

    e.preventDefault();

    let c = confirm('eliminar_registro');
    if (c) {
       let id = $(this).data('id');
       obj = {
        "action" : "eliminar_registro",
        "registro" : id
       };
       $.post('includes/_funciones.php', obj, function(i) {

       if (i == "1") {
       $("#infoS").html("Usuario Eliminado Correctamente").show().delay(2000).fadeOut(400);
      
       consultar();
     } else {
       $("#infoD").html("Error al Eliminar Usuario").show().delay(2000).fadeOut(400);
      
     }
       });
    }else{
      $("#infoD").html("El Registro No Se a Eliminado").show().delay(2000).fadeOut(400);
      
    }
  });
     });

  $(function  consultar_registro(){
      $("#list_usuarios").on("click",".editar_registro", function(e){
    let id = $(this).data('id');
    let obj = {
      "action" : "consultar_registro",
      "registro" : id
    };

    $.post('includes/_funciones.php', obj, function(r) {

    $("#").html();
  }, "JSON");
  });
  });


    $(function editar_registro(){
  $("#list_usuarios").on("click",".editar_registro", function(k){
    change_view('insert_data');
  });

  $("#list_usuarios").on("click",".editar_registro", function(e){

       let id = $(this).data('id');
       obj = {
        "action" : "editar_registro",
        "registro" : id,
         "nombre" : nombre,
          "tel" : tel,
          "mail" : mail,
          "password" : pswd
       };

       $.post('includes/_funciones.php', obj, function(r) {

       if (r == "1") {
       $("#infoS").html("Cambios Guardados Correctamente").show().delay(2000).fadeOut(400);
       $("#form_data")[0].reset();
      
       consultar();
     } else {
       $("#infoD").html("Error al Guardar Cambios").show().delay(2000).fadeOut(400);
      
     }

       });
     });
  });


  $("#main").find(".cancelar").click(function() {
    change_view();
    $("#form_data")[0].reset();
  });

  $(document).ready(function(){
    consultar();
    change_view();
  }); 


</script>
</body>
</html>  