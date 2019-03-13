<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.5">
    <title>Banner de ActiveBox.com</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <!-- Custom styles for this template -->
    <link href="css/estilos.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Company name</a>
        <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
        <ul class="navbar-nav px-3">
            <li class="nav-item text-nowrap">
                <a class="nav-link" href="index.php">Sign out</a>
            </li>
        </ul>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 d-none d-md-block bg-light sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="usuarios.php">
                                <span data-feather="home"></span>
                                Usuarios <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="banner.php">
                                <span data-feather="file"></span>
                                Banner
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4" id="main">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Usuarios</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group mr-2">
                            <button type="button" class="btn btn-sm btn-outline-danger cancelar">Cancelar</button>
                            <button type="button" class="btn btn-sm btn-outline-success" id="nuevo_registro">Nuevo</button>
                        </div>
                    </div>
                </div>
                <h2>banner</h2>
                <div class="table-responsive view" id="show_data">
                    <table class="table table-striped table-sm" id="list-banner">
                        <thead>
                            <tr>
                                <th>Titulo 1</th>
                                <th>Titulo 2</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>


                <div id="insert_data" class="view">
                    <form action="#" id="form_data">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="titulo1">Titulo 1</label>
                                    <input type="text" id="titulo1" name="titulo1" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="titulo2">Titulo 2</label>
                                    <input type="text" id="titulo2" name="titulo2" class="form-control">
                                </div>
                            </div>
                        <div class="row">
                            <div class="col">
                                <button type="button" class="btn btn-success" id="guardar_datos">Guardar</button>
                            </div>
                            <div class="box">
                                <span class="alert alert-danger" id="error" style='display:none;'></span>
                            </div>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script>
        //cambia vista
        function change_view(vista = 'show_data') {
            $("#main").find(".view").each(function() {
                // $(this).addClass("d-none");
                $(this).slideUp('fast');
                let id = $(this).attr("id");
                if (vista == id) {
                    $(this).slideDown(300);
                    // $(this).removeClass("d-none");
                }
            });
        }

        function consultar() {
            let obj = {
                "accion": "consultar_banner"
            };
            $.post("includes/_funciones.php", obj, function(respuesta) {
                let template = ``;
                $.each(respuesta, function(i, e) {
                    template +=
                        `
          <tr>
          <td>${e.titulo1}</td>
          <td>${e.titulo2}</td>
          <td>
          <a href="#" data-id="${e.id}" class="editar_banner">Editar</a>
          <a href="#" data-id="${e.id}" class="eliminar_banner">Eliminar</a>
          </td>
          </tr>
          `;
                });
                $("#list-banner tbody").html(template);
            }, "JSON");
        }

        //form change
        $("#nuevo_registro").click(function() {
            change_view('insert_data');
            $("#h2-title").text("insertar titulo");
        });

        //insertar 
        $("#guardar_datos").click(function() {
            let Titulo1 = $("#inputTitulo1").val();
            let Titulo2 = $("#inputTitulo2").val();
            let obj = {
                "accion": "insertar_banner",
                "titulo1": Titulo1,
                "titulo2": Titulo2,
            }
            $("#form_data").find("input").each(function() {
                $(this).removeClass("has-error");
                if ($(this).val() != "") {
                    obj[$(this).prop("name")] = $(this).val();
                } else {
                    $(this).addClass("has-error");
                    return false;
                }
            });
            //boton change insertar to edit
            if ($(this).data("editar") == 1) {
                obj["accion"] = "editar_banner";
                obj["id"] = $(this).data('id');
            }
            $.post("includes/_funciones.php", obj, function(r) {
                if (r == 0) {
                    $("#error").html("Campos vacios").fadeIn();
                }
                if (r == 1) {
                    alert("banner Insertado");
                    location.reload();
                }
            });
        });


        //eliminar banner
        $("#main").on("click", ".eliminar_banner", function(e) {
            e.preventDefault();
            let confirmacion = confirm('¿Desea eliminar este texto?');
            if (confirmacion) {
                let id = $(this).data('id'),
                    obj = {
                        "accion": "eliminar_banner",
                        "id": id
                    };
                $.post("includes/_funciones.php", obj, function(respuesta) {
                    alert(respuesta);
                    consultar();
                });
            }else{
                alert("Error al insertar");           
            }
        });

        //editar banner
        $("#list-banner").on("click", ".editar_banner", function(e) {
            e.preventDefault();
            let id = $(this).data('id'),
                obj = {
                    "accion": "consultar_banner",
                    "id": id
                };
            $("#form_data")[0].reset();
            change_view('insert_data');
            $("#h2-title").text("Editar Banner");
            $("#guardar_datos").text("Editar").data("editar", 1).data("id", id);

            $.post("includes/_funciones.php", obj, function(r) {
                $("#inputTitulo1").val(r.Titulo1);
                $("#inputTitulo2").val(r.Titulo2);
            }, "JSON");
        });

        $(document).ready(function() {
            consultar();
            change_view();
        });

        $("#main").find(".cancelar").click(function() {
            change_view();
            $("#form_data")[0].reset();
            $("#form_data").find("input").each(function() {
                $(this).removeClass("has-error");
            });
            $("#error").hide();
            $("#success").hide();
            $("#h2-title").text("Consultar Banner");
        });
    </script>
</body>

</html> 