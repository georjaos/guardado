/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//creamos una variable global de la tabla procesos para ser utilizada en cualquier momento
var table;

//varibale global del idnetificador del proceso para ser utilizada en diferentes funciones
var idproc;

///funcion al iniciar la vista ejecuta X codigo, como si fuera un constructor
$(function () { ///esto es del framework jquery

    cargarProcesos(); ///llamamos a la funcion para que se muestre los datos del proceso en la tabla al cargar la vista
    listarRoles(); //listamos los datos de los roles al cargar la vista
    
    //evento al hacer click en la prioridad del proceso
    $("#prioridad").click(function () {

        if ($("#proceso_name").val() == "") {

            $("#proceso_name").focus().before("<span class='error'>Ingrese el nombre del proceso</span>");
            $(".error").fadeIn();
        }
    });
    
    //evento al hacer click en la descripcion del proceso
    $("#descrip").click(function () {

        if ($("#prioridad").val() == "0") {

            $("#prioridad").focus().before("<span class='error'>Seleccione la prioridad del proceso</span>");
            $(".error").fadeIn();
        }
    });

    //evento al hacer click en el rol del proceso
    $("#rol").click(function () {

        if ($("#descrip").val() == "") {

            $("#descrip").focus().before("<span class='error'>Ingrese la descripción del proceso</span>");
            $(".error").fadeIn();
        }
    });

});

/*
 * realiza la busqueda de los datos de los procesos en a tabla
 */
$(function () {
    var ult;
    var cont = 1;
    $('#tablaProcesos tfoot th').each(function () {
        var title = $(this).text();
        ult = this;
        $(this).html('<input type="text" placeholder="Buscar" class="form-control txt_find" id="txt' + cont + '"/>');
        cont++;
    });
    $(ult).html('<p id="txt_acc"></p>');

    table.columns().every(function () {
        var that = this;

        $('input', this.footer()).on('keyup change', function () {
            that
                    .search(this.value)
                    .draw();
        });
    });

});

//eventos al presionar una tecla en cada campo del formulario
$(function () {
    $("#proceso_name").keypress(function () {
        $(".error").remove();
    });
});

$(function () {
    $("#prioridad").click(function () {
        $(".error").remove();
    });
});

$(function () {
    $("#descrip").keypress(function () {
        $(".error").remove();
    });
});

$(function () {
    $("#rol").click(function () {
        $(".error").remove();
    });
});
//fin eventos


/*
 * funcion que invoca al controlador, el cual devuelve un JSON con los datos de los procesos.
 * posteriormente recorremos el JSON y mostramos los datos en una tabla
 *
 */
function cargarProcesos() {

    table = $('#tablaProcesos').DataTable({//los datos que me envia el controlador se llenan el la tabla
        "order": [[0, "asc"]], //los ordenamos de mayor a menor por el numero de la secuencia
        "destroy": true,
        "ajax": {
            "retrieve": true,
            "processing": false, //indicador de proceso
            "serverSide": true,
            "searching": false,
            "method": "POST",
            "url": "ProcesoController/listarProcesos", //llamamos a la funcion del controlador para que me liste los proceos
            "data": {
            }
        },
        //llenamos los datos de los proceos que envia el controlador, 
        //el nombre de las columnas son tal cual el nombre que se colocaron en el controlador
        "columns": [
            {"data": "secuencia"},
            {"data": "nombre"},
            {"data": "desc"},
            {"data": "prioridad"},
            {"data": "role"},
            {"data": "accion"}
        ]
    });
}

/**
 * funcion que nos permite abiri una modal para diligenciar el formulario de registrar un proceso
 */
function nuevoProceso() {
    $("#modalRegistroProcesos").modal();
}

/**
 * function que nos redirecciona a secuenciar procesos
 */
function secuencia(){
    location.href ="ProcesoController/secuencia";
}

/*
 * function que realiza una peticion al controlador, a la cual le enviamos como parametros por medio de AJAX 
 * los valores de registrar un nuevo proceso
 */
function registrarProceso() {

    if (validarDatos()) {
        $.post("ProcesoController/registrarProceso", //direccion url donde se encutra el controlador y el nombre de la funcion a la que deseamos llamar
                {   
                    //valores enviador por POST al controlador
                    "nombre": $("#proceso_name").val(),
                    "descripcion": $("#descrip").val(),
                    "prioridad": $("#prioridad").val(),
                    "role": $("#rol").val(),
                    "secuencia": $("#secuencia").val()
                },
                function (data) {
                    //el resultado que nos envia el controlador codificado en JSON
                    if (data == "exist") {
                        $.alert({
                            type: 'orange',
                            icon: 'glyphicon glyphicon-warning',
                            title: 'Advertencia!',
                            content: 'Ya existe un Proceso con el mismo nombre y la misma descripción',
                        });
                    } else {

                        if (data) {
                            $.alert({
                                type: 'green',
                                icon: 'glyphicon glyphicon-ok',
                                title: 'Exito!',
                                content: 'Proceso Registrado',
                            });

                            $("#proceso_name").val("");
                            $("#descrip").val("");
                            $("#prioridad").val("0");
                            $("#rol").val("0");
                            $("#secuencia").val(1);
                            //si se actualizaron los datos, refescamos la tabla con los nuevos datos
                            cargarProcesos();
                            $('#modalRegistroProcesos').modal('hide');

                        } else {
                            $.alert({
                                type: 'red',
                                icon: 'glyphicon glyphicon-remove',
                                title: 'Error!',
                                content: 'Proceso NO Registrado',
                            });
                            $('#modalRegistroProcesos').modal('hide');
                        }
                    }

                }, "json"); //parseamos el resultado que nos envia el controlador
    } else {

        $.alert({
            type: 'red',
            icon: 'glyphicon glyphicon-remove',
            title: 'Error!',
            content: 'Diligencie todos los campos obligatorios',
        });
    }
}

/*
 * function la cual recibe como parametro de entrada el identificador del proceso, y que hace una peticion al controlador
 * del proceso, al cual le enviamos como parametros por AJAX que seran actualizados en la base de datos, y 
 * finalmente nos enviara como resultados los datos atualizados
 */
function actualizarProceso(id_proceso) {


    idP = id_proceso;
    $.post("ProcesoController/consultarProcesoId", ///consulta los datos del proceso por ID en el controlador
            {
                "id_pro": id_proceso
            },
            function (data) {
                //seteamos los Txt con los datos que nos envia el controlador desde la base de datos
                $("#proceso_name_edit").val(data.nombre);
                $("#prioridad_edit").val(data.prioridad);
                $("#secuencia_edit").val(data.orden_secuencia);
                $("#descrip_edit").val(data.descripcion);
                $("#rol_edit").val(data.id_role);
                //cargamos la modal para visualizar los datos
                $("#modalActualizarProcesos").modal();
            }, "json"); //recibimos los datos por medio de JSON
}

/*
 * function que hace una peticion al controlador para actualizar los datos del proceso,
 * al cual le enviamos los datos a actualia como parametros por medio de AJAX que seran actualizados en la base de datos, y 
 * finalmente nos enviara un resultado si atcualizo los datos o no.
 */
function actualizar() {

    if (validarDatos_edit()) {
        $.post("ProcesoController/actualizarProceso", //llamamos a la funcion del controlador
                {
                    //enviamos los datos al controlador por medio de POST
                    "nombre": $("#proceso_name_edit").val(),
                    "prioridad": $("#prioridad_edit").val(),
                    //"secuencia": $("#secuencia_edit").val(),
                    "descripcion": $("#descrip_edit").val(),
                    "role": $("#rol_edit").val(),
                    "id_pro": idP
                },
                function (data) {
                    //recibimos el resultado del controlador y lo procesamos para mostrar los mensajes a la vista
                    if (data) {
                        $.alert({
                            type: 'green',
                            icon: 'glyphicon glyphicon-ok',
                            title: 'Exito!',
                            content: 'Proceso Actualizado',
                        });

                        $("#proceso_name").val("");
                        $("#descrip").val("");
                        $("#prioridad").val("0");
                        $("#rol").val("0");
                        //si se actualizaron los datos, refescamos la tabla con los nuevos datos
                        cargarProcesos();
                        $('#modalActualizarProcesos').modal('hide');

                    } else {
                        $.alert({
                            type: 'red',
                            icon: 'glyphicon glyphicon-remove',
                            title: 'Error!',
                            content: 'No se actualizo el proceso',
                        });
                        $('#modalActualizarProcesos').modal('hide');
                        cargarProcesos();
                    }
                }, "json");
    } else {

        $.alert({
            type: 'red',
            icon: 'glyphicon glyphicon-remove',
            title: 'Error!',
            content: 'Diligencie todos los campos obligatorios',
        });
    }
}
/*
 * funcion que recibe como parametro el identificador del proceso y que mediante AJAX hace una peticion al controlador
 * enviandole como parametro el identificador y retornando como resultado un JSON con los datos del proceso.
 */
function verProceso(id_proceso) {
    $.post("ProcesoController/consultarProcesoId", ///consulta los datos del proceso al controldor
            {   
                //parametro enviado por POST
                "id_pro": id_proceso
            },
            function (data) {
                //el JSON enviado por el controlador como respuesta
                var prioridad = "";
                if (data.prioridad == 1) {
                    prioridad = "Alta";
                }
                if (data.prioridad == 2) {
                    prioridad = "Media";
                }
                if (data.prioridad == 3) {
                    prioridad = "Baja";
                }
                $("#proceso_name_view").val(data.nombre); //setea los Txt con los datos de la BD
                $("#prioridad_view").val(prioridad);
                $("#secuencia_view").val(data.orden_secuencia);
                $("#descrip_view").val(data.descripcion);
                $("#rol_view").val(data.rol);
                
                //cargo los nuevos datos actualizados a la vista
                cargarInterfaz_proceso(id_proceso);
                cargarPoliticas(id_proceso);
                cargarRespuestasTopreguntas(id_proceso);
                ///carga la modal
                $("#modalVerProceso").modal();
            }, "json");

}

/*
 * funcion que envia una peticion al controlador por medio de AJAX y que envia como parametro
 * el identificador del proceso y retornando como resultado un JSON.
 */
function eliminar(id_proceso) {    
    
    //mensaje de confirmacion,obtenido del framwork jquey
    $.confirm({
        type: 'orange',
        icon: 'glyphicon glyphicon-warning-sign',
        title: 'Advertencia!',
        content: 'Desea eliminar el Proceso ?',
        buttons: {
            aceptar: function () {                
                $.post("ProcesoController/eliminarProceso", //url donde se encuentra la funcion a la cual hacemos la peticion
                        {
                            //parametro que se envia por medio de POST
                            "id_pro": id_proceso                            
                        },
                        function (data) {                            
                            //el resultado que envia el controlador            
                            //cargamos los procesos con los nuevos datos
                            cargarProcesos();
                        }, "json");

            },            
            cancelar: function () {

            }
        }
    });
}
/*
 * funcion que sirve para valodar los caracteres especiales de una cadena
 */
function isValid_txt(str) {
    return !/[~`!#$%\^&*+=\-\[\]\\';,/{}|\\":<>\?]/g.test(str);
}

/*
 * funcion que valida los datos del formulario, retornando una bandera de tipo boolean
 * @returns {Boolean}
 */
function validarDatos() {
    var band = true;
    if ($("#proceso_name").val() == "") {
        $("#proceso_name").focus().before("<span class='error'>Ingrese el nombre del proceso</span>");
        $(".error").fadeIn();
        band = false;
    }

    if ($("#proceso_name").val().length > 50) {
        $("#proceso_name").focus().before("<span class='error'>Excede el numero de caracteres permitidos</span>");
        $(".error").fadeIn();
        band = false;
    }

    if (!isValid_txt($("#proceso_name").val())) {
        $("#proceso_name").focus().before("<span class='error'>Caracteres no válidos</span>");
        $(".error").fadeIn();
        band = false;
    }

    if ($("#prioridad").val() == "0") {

        $("#prioridad").focus().before("<span class='error'>Seleccione la prioridad del proceso</span>");
        $(".error").fadeIn();
        band = false;
    }

    if ($("#descrip").val() == "") {

        $("#descrip").focus().before("<span class='error'>Ingrese la descripción del proceso</span>");
        $(".error").fadeIn();
        band = false;
    }

    if ($("#descrip").val().length > 250) {

        $("#descrip").focus().before("<span class='error'>Excede el numero de caracteres permitidos</span>");
        $(".error").fadeIn();
        band = false;
    }

    if ($("#secuencia").val() == "") {

        $("#secuencia").focus().before("<span class='error'>Ingrese la secuencia del proceso</span>");
        $(".error").fadeIn();
        band = false;
    }

    if ($("#rol").val() == "0") {

        $("#rol").focus().before("<span class='error'>Seleccione el rol del proceso</span>");
        $(".error").fadeIn();
        band = false;
    }

    return band;
}
/*
 * funcion que validad los datos al editarlos en el formulario, retornando una bandera de tipo boolean
 * @returns {Boolean}
 */
function validarDatos_edit() {
    var band = true;
    if ($("#proceso_name_edit").val() == "") {
        $("#proceso_name_edit").focus().before("<span class='error'>Ingrese el nombre del proceso</span>");
        $(".error").fadeIn();
        band = false;
    }

    if ($("#proceso_name_edit").val().length > 50) {
        $("#proceso_name_edit").focus().before("<span class='error'>Excede el numero de caracteres permitidos</span>");
        $(".error").fadeIn();
        band = false;
    }

    if (!isValid_txt($("#proceso_name_edit").val())) {
        $("#proceso_name_edit").focus().before("<span class='error'>Caracteres no válidos</span>");
        $(".error").fadeIn();
        band = false;
    }

    if ($("#prioridad_edit").val() == "0") {

        $("#prioridad_edit").focus().before("<span class='error'>Seleccione la prioridad del proceso</span>");
        $(".error").fadeIn();
        band = false;
    }

    if ($("#descrip_edit").val() == "") {

        $("#descrip_edit").focus().before("<span class='error'>Ingrese la descripción del proceso</span>");
        $(".error").fadeIn();
        band = false;
    }

    if ($("#descrip_edit").val().length > 250) {

        $("#descrip_edit").focus().before("<span class='error'>Excede el numero de caracteres permitidos</span>");
        $(".error").fadeIn();
        band = false;
    }

    if ($("#rol_edit").val() == "0") {

        $("#rol_edit").focus().before("<span class='error'>Seleccione el rol del proceso</span>");
        $(".error").fadeIn();
        band = false;
    }

    return band;
}
/*
 * function que verifica una cadena de texto no tenga caracteres especiales
 */
function onlyLetters(l) {
    var valid1 = "/^[a-zA-Z]+$/";
    if ((/^[a-zA-Z]+$/.test(l))) {
        return false;
    } else {
        return true;
    }
}
/*
 * funcion que lista los roles de todos los procesos, para ser mostrados en la vista procesos 
 * 
 */
function listarRoles() {
    $.post("ProcesoController/listaRoles", //url del controlador que muestrala lista de los controladores
            function (data) {
                //resultado retornado desde el controlador
                var html = "";
                html += '<select id="rol" class="form-control">';
                html += '<option value="0">Seleccione...</option>'
                for (var i = 0; i < data.length; i++) {
                    html += '<option value="' + data[i].idrole + '">' + data[i].nombre + '</option>';
                }
                html += "</select> ";

                ////cargar roles de editar
                var html_rol = "";
                html_rol += '<label for="prioridad"><span class="glyphicon glyphicon-user " id ="iconoRol"></span> Rol del Proceso</label><span id="require">*</span><span id="error"></span>';
                html_rol += '<select id="rol_edit" class="form-control">';
                html_rol += '<option value="0">Seleccione...</option>'
                for (var i = 0; i < data.length; i++) {
                    html_rol += '<option value="' + data[i].idrole + '">' + data[i].nombre + '</option>';
                }
                html_rol += "</select> ";

                $("#roles").html(html);
                $("#roles_edit").html(html_rol);

            }, "json");
}

/*
 * funcion que abre una modal para registrar los datos del nuevo rol
 */
function nuevoRol() {
    //modalRegistroRol
    $('#modalRegistroProcesos').modal('hide');
    $("#modalRegistroRol").modal();

}
/*
 * funcion que cierra la modal de registrar un nuevo rol
 */
function cancelar_reg_rol() {
    $('#modalRegistroProcesos').modal();
    $("#modalRegistroRol").modal('hide');
}

/*
 * funcion que envia los datos de un nuevo rol al controlador del rol para registrarlos en la base de datos
 */
function registrarRol() {
    //valida los datos antes de enviarlos al controlador
    if (validarDatos_role()) {
        $.post("RolController/registrarRol",//url del metodo en la clase controlador para registrar un nuevo rol
                {
                    //datos enviados por AJAX a traves de POST
                    "nombre": $("#rol_name").val(),
                    "descripcion": $("#descripcion_role").val(),
                    "encargado": $("#encargado_role").val()
                },
                function (data) {
                //rerultado enviaod desde la clase controlador para mostrarlo en la vista
                    if (data) {

                        $.alert({
                            type: 'green',
                            icon: 'glyphicon glyphicon-ok',
                            title: 'Exito!',
                            content: 'Rol registrado',
                        });

                        $("#rol_name").val("");
                        $("#descripcion_role").val("");
                        $("#encargado_role").val("");
                        //lista los nuevos roles
                        listarRoles();

                        $('#modalRegistroProcesos').modal();
                        $('#modalRegistroRol').modal('hide');
                    } else {

                        $.alert({
                            type: 'red',
                            icon: 'glyphicon glyphicon-ok',
                            title: 'Exito!',
                            content: 'No se registro el Rol',
                        });

                        $('#modalRegistroProcesos').modal();
                        $('#modalRegistroRol').modal('hide');
                    }

                }, "json");

    } else {
        $.alert({
            type: 'red',
            icon: 'glyphicon glyphicon-ok',
            title: 'Error!',
            content: 'Diligencie los campos obligatorios',
        });
    }
}
/*
 * valoda los datos del formulario de agregar un rol antes de enviarlos al controlador
 */
function validarDatos_role() {

    var band = true;
    if ($("#rol_name").val() == "") {
        $("#rol_name").focus().before("<span class='error'>Ingrese el nombre del rol</span>");
        $(".error").fadeIn();
        band = false;
    }
    if (!isValid_txt($("#rol_name").val())) {
        $("#rol_name").focus().before("<span class='error'>Caracteres no válidos</span>");
        $(".error").fadeIn();
        band = false;
    }

    if ($("#descripcion_role").val() == "") {

        $("#descripcion_role").focus().before("<span class='error'>Ingrese la descripción del rol</span>");
        $(".error").fadeIn();
        band = false;
    }

    if ($("#encargado_role").val() == "") {
        $("#encargado_role").focus().before("<span class='error'>Ingrese el nombre del encargado</span>");
        $(".error").fadeIn();
        band = false;
    }

    if (!isValid_txt($("#encargado_role").val())) {

        $("#encargado_role").focus().before("<span class='error'>Caracteres no válidos</span>");
        $(".error").fadeIn();
        band = false;
    }

    return band;
}

/*
 * funcion que envia el identificador del proceso al controlador de interfaces para recibir la informacion
 * de las interfaces relacionadas y mostrarlos en la vista mediante una tabla 
 */
function cargarInterfaz_proceso(id_pro) {
    $.post("InterfazController/listarInterfazProceso",//url de la funcion que se encuenyra en el controlador
            {
                "id_pro": id_pro//parametro enviado por POST
            },
            function (data) {
                //resultado enviado desde el controlador
                if (!data) {
                    $("#tbl_interfaz").hide();
                } else {
                    var html = '';
                    html += '<h4 style="text-align:center;">Interfaces</h4>';
                    html += '<table class="table table-striped table-bordered">';
                    html += '<thead>';
                    html += '<tr>';
                    html += '<th>Nombre</th>';
                    html += '<th>Descripción</th>';
                    html += '<th>Tipo</th>';
                    html += '<th>Detalle</th>';
                    html += '</tr>';
                    html += '</thead>';
                    html += '<tbody>';
                    for (var i = 0; i < data.length; i++) {

                        var tipo = "";
                        if (data[i].tipo == 1) {
                            tipo = "Automatica";
                        }
                        if (data[i].tipo == 2) {
                            tipo = "Semiautomatica";
                        }
                        if (data[i].tipo == 3) {
                            tipo = "Manual";
                        }
                        html += '<tr>';
                        html += '<td>' + data[i].nombre + '</td>';
                        html += '<td>' + data[i].descripcion + '</td>';
                        html += '<td>' + tipo + '</td>';
                        html += '<td>' + data[i].detalle_tipo + '</td>';
                        html += '</tr>';
                    }
                    html += '</tbody>';
                    html += '</table>';
                    $("#tbl_interfaz").html(html);
                    $("#tbl_interfaz").show();
                }
            }, "json");
}

/*
 * funcion que envia el identificador del proceso al controlador de normativas para recibir la informacion
 * de las politicas relacionadas y mostrarlos en la vista mediante una tabla 
 */
function cargarPoliticas(id_pro) {
    $.post("NormativaController/getNormativaProceso",
            {
                "id_pro": id_pro
            },
            function (data) {

                if (!data) {
                    $("#info_norma").hide();
                } else {

                    var html = '';
                    html += "<h4 style='text-align:center; margin-top:20px;'>Políticas</h4>"
                    for (var i = 0; i < data.length; i++) {
                        html += '<div class="panel panel-default" style="marging-bottom:10px;">';
                        html += '<div class="panel-body" style="padding: 1%;">';
                        html += '<p><strong>' + data[i].nombre + '</strong></p>';
                        html += '<p style="word-wrap: break-word">' + data[i].descripcion + '</p>';
                        html += '</div>';
                        html += '</div>';
                    }
                    $("#info_norma").html(html);
                    $("#info_norma").show();
                }

            }, "json");
}
/*
 * funcion que envia el identificador del proceso al controlador de preguntas y que 
 * recibe como ressultado un JSON desde el controlador con la informacion de las preguntas y respuestas
 */
function cargarRespuestasTopreguntas(id_pro) {
    $.post("DefinirRNFController/respuestaToPreguntas",//url del controlador preguntas
            {
                //parametro enviado al controlador por AJAX
                "id_proc": id_pro
            },
            function (data) {
                //resultado enviado desde el controlador
                if (!data) {
                    $("#preguntas_respuestas").hide();
                } else {

                    var html = '';
                    html+='<p style="font-size:16px; color:blue;">Respuestas a preguntas '+data.respuestas+'/'+data.preguntas+'</p>'
                    $("#preguntas_respuestas").html(html);
                    $("#preguntas_respuestas").show();
                }

            }, "json");
}



