/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var table;
var ID_PROCESO=0;
$(function () {
    cargarInterfaces();
    listarProcesos();
});

//REALIZAR LAS BUSQUEDA POR COLUMNAS
$(function () {
    var cont = 1;
    var ult;
    $('#tablaInterface tfoot th').each(function () {
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


/*
 * 
 * funcion que invoca al controlador, el cual a traves de un formulario obtiene los datos
 * y los envia al controlador para ser inertados en la base de datos
 */
function agregarInterfaz(proceso) {
    ID_PROCESO=proceso;
    cargarTipoInterfaz();
    //abre la modal para inserta los datos
    $("#modalAgregarInterfaz").modal();
}
/*
 * 
 * funcion que carga el tipo de interfaz en la base de datos, recibiendo como 
 * resultado un JSON enviado desde el controlador.
 */
function cargarTipoInterfaz() {
    $.post("InterfazController/listarTipo_Interfaz", //url de la peticion
            function (data) {
                
                //resultado de los datos enviados desde el controlador
                if (!data) {
                } else {

                    var html = '';
                    html += '<select id="tipoInterfaz_add" class="form-control">';
                    html += '<option value="0">Seleccione...</option>';
                    for (var i = 0; i < data.length; i++) {
                        html += '<option value="' + data[i].id_tipo + '">' + data[i].nombre_interfaz + '</option>';
                    }
                    html += '</select>';
                    $("#tipo_interfaz").html(html);
                }

            }, "json");
}
/*
 * 
 * funcion que envia los datos de una interfaz al controlador para registarlos en la base datos
 * retorna un JSON con el resultado enviado por el controlador de si los 
 * datos fueron insertados en la base de datos.
 */
function add_interfaz(){
    if (validarDatosInterfaz()) {
        $.post("InterfazController/insertarInterfaz", //url de la peticion
                {
                    //datos enviados por POST al controlador
                    "nombre": $("#interfaz_name").val(),
                    "descripcion": $("#descripInterfaz").val(),
                    "tipo": $("#tipoInterfaz_add").val(),
                    "detalleT": $("#descripTipoInterfaz").val(),
                    "proceso": ID_PROCESO

                },
                function (data) {   
                    //Resultado enviado desde el controlador
                    if (data) {
                        $.alert({
                            type: 'green',
                            icon: 'glyphicon glyphicon-ok',
                            title: 'Exito!',
                            content: 'Interfaz agregadao',
                        });

                        $("#interfaz_name").val("");
                        $("#descripInterfaz").val("");
                        $("#tipoInterfaz_add").val("0");
                        $("#descripTipoInterfaz").val("");


                        $('#modalAgregarInterfaz').modal('hide');

                    } else {
                        $.alert({
                            type: 'red',
                            icon: 'glyphicon glyphicon-ok',
                            title: 'Error!',
                            content: 'Interfaz NO Registrada',
                        });
                        $('#modalRegistroRol').modal('hide');
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
 * 
 * funcion que envia los datos de una interfaz al controlador para mostralos en la vista
 * retorna un JSON con el resultado enviado por el controlador de si los 
 * datos fueron enviados
 */

function verInterfaz(id_interfaz) {
    $.post("InterfazController/consultarInterfazId",
            {
                "id": id_interfaz
            },
            function (data) {
                $("#interfaz_name_view").val(data.nombre);
                $("#descripcion_view").val(data.descripcion);
                $("#tipo_view").val(data.tipo);
                $("#detalle_view").val(data.detalle_tipo);
                $("#proceso_view").val(data.nombreproceso);
                $("#descripcionp_view").val(data.descripcionproceso);

                $("#modalVerInterfaz").modal();
            }, "json");
}


/*
 * 
 * funcion que envia los datos de una interfaz al controlador para listar las interfaces
 * retorna un JSON con el resultado enviado por el controlador de si los 
 * datos fueron enviados
 */
function cargarInterfaces() {

    table = $('#tablaInterface').DataTable({//los datos que me envia el controlador los seteo en la tabla html
        "destroy": true,
        "ajax": {
            "retrieve": true,
            "processing": false, //indicador de proceso
            "serverSide": true,
            "searching": false,
            "method": "POST",
            "url": "InterfazController/listarInterfaces", //donde llamo a la funcion del controlador para que me liste los proceos
            "data": {
            }
        },
        //seteo los datos que me envia el controlador, el nombre de las columnas son tal cual el nombre que se colocaron en el controlador
        "columns": [
            //{"data": "id"},
            {"data": "nombre"},
            {"data": "descripcion"},
            {"data": "tipo"},
            {"data": "detalleTipo"},
            {"data": "proceso"},
            {"data": "accion"}
        ]
    });
}
/*
 * funcion que se comunica con el controlador enviandolo el identificado de la interfaz
 * para poder eliminar los datos de la base de datos.
 * retorna un resultado JSON de si el valor fue eliminado.
 */
function eliminarinterfaz(id) {

    $.confirm({
        type: 'orange',
        icon: 'glyphicon glyphicon-warning-sign',
        title: 'Advertencia!',
        content: 'Desea eliminar la interfaz ?',
        buttons: {
            aceptar: function () {
                $.post("InterfazController/eliminarInterface", //url donde se hace la peticion
                        {
                            //parametro enviado por POST
                            "id": id
                        },
                        function (data) {
                            //resultado enviado desde el controlador
                            if (data) {
                                $.alert({
                                    type: 'green',
                                    icon: 'glyphicon glyphicon-ok',
                                    title: 'Exito!',
                                    content: 'se elimino la Interfaz',
                                });
                                cargarInterfaces();
                            } else {
                                $.alert({
                                    type: 'red',
                                    icon: 'glyphicon glyphicon-remove',
                                    title: 'Error!',
                                    content: 'No se elimino la Interfaz',
                                });
                            }
                        }, "json");
            },
            cancelar: function () {

            }
        }
    });
}

function actualizarInterfaz(id_interfaz) {


    idI = id_interfaz;
    $.post("InterfazController/consultarInterfazId", ///consulta los datos del proceso por ID
            {
                "id": id_interfaz
            },
            function (data) {

                $("#interfaz_name_edit").val(data.nombre); //setea los Txt con los datos de la BD
                $("#descripcion_edit").val(data.descripcion);
                $("#tipo_edit").val(data.tipo);
                $("#detalleTipo_edit").val(data.detalle_tipo);
                $("#pro_edit_value").val(data.proceso); //revisar esta parte

                $("#modalActualizarInterfaz").modal();
            }, "json");


}

//actualizar datos
function actualizarInt() {

    if (validarDatosInterfaz_edit()) {
        $.post("InterfazController/actualizarInterfaz",
                {
                    "nombre": $("#interfaz_name_edit").val(),
                    "descripcion": $("#descripcion_edit").val(),
                    "tipo": $("#tipo_edit").val(),
                    "detalleTipo": $("#detalleTipo_edit").val(),
                    "proceso": $("#pro_edit_value").val(),
                    "id_int": idI
                },
                function (data) {

                    if (data) {
                        $.alert({
                            type: 'green',
                            icon: 'glyphicon glyphicon-ok',
                            title: 'Exito!',
                            content: 'Proceso Actualizado',
                        });

                        $("#nombre").val("");
                        $("#descripcion").val("");
                        $("#tipo").val("0");
                        $("#detalleTipo").val("");
                        $("#proceso").val("0");

                        cargarInterfaces();
                        $('#modalActualizarInterfaz').modal('hide');

                    } else {
                        $.alert({
                            type: 'red',
                            icon: 'glyphicon glyphicon-remove',
                            title: 'Error!',
                            content: 'No se actualizo el proceso',
                        });
                        $('#modalActualizarInterfaz').modal('hide');
                        cargarInterfaces();
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

function listarProcesos() {
    $.post("InterfazController/listaProcesos",
            function (data) {
                var html = "";
                html += '<select id="proceso" class="form-control">';
                html += '<option value="0">Seleccione...</option>'
                for (var i = 0; i < data.length; i++) {
                    html += '<option value="' + data[i].idproceso + '">' + data[i].nombre + '</option>';
                }
                html += "</select> ";

                ////cargar procesos de editar
                var html_pro = "";
                html_pro += '<label for="prioridad"><span class="glyphicon glyphicon-comment " ></span> Nombre del Proceso</label><span id="require">*</span><span id="error"></span>';
                html_pro += '<select id="pro_edit_value" class="form-control">';
                html_pro += '<option value="0">Seleccione...</option>'
                for (var i = 0; i < data.length; i++) {
                    html_pro += '<option value="' + data[i].idproceso + '">' + data[i].nombre + '</option>';
                }
                html_pro += "</select> ";

                $("#proceso").html(html);
                $("#proceso_edit").html(html_pro);

            }, "json");
}


/* 
 * funcion que valida los datos en las ventanas modales, retornando una bandera de tipo boolean 
 * @returns {Boolean} 
 */ 
function validarDatosInterfaz() {
    var band = true;
    if ($("#interfaz_name").val() == "") {
        $("#interfaz_name").focus().before("<span class='error'>Ingrese el nombre de la interfaz</span>");
        $(".errorI").fadeIn();
        band = false;
    }

    if ($("#interfaz_name").val().length > 50) {
        $("#interfaz_name").focus().before("<span class='error'>Excede el numero de caracteres permitidos</span>");
        $(".errorI").fadeIn();
        band = false;
    }

    if (!isValid_txt($("#interfaz_name").val())) {
        $("#interfaz_name").focus().before("<span class='error'>Caracteres no válidos</span>");
        $(".errorI").fadeIn();
        band = false;
    }

    if ($("#tipoInterfaz_add").val() == "0") {

        $("#tipoInterfaz_add").focus().before("<span class='error'>Seleccione el tipo de lainterfaz </span>");
        $(".errorI").fadeIn();
        band = false;
    }

    if ($("#descripInterfaz").val() == "") {

        $("#descripInterfaz").focus().before("<span class='error'>Ingrese la descripción de la interfaz</span>");
        $(".errorI").fadeIn();
        band = false;
    }

    if ($("#descripInterfaz").val().length > 2000) {

        $("#descripInterfaz").focus().before("<span class='error'>Excede el numero de caracteres permitidos</span>");
        $(".errorI").fadeIn();
        band = false;
    }

    if ($("#descripTipoInterfaz").val() == "") {

        $("#descripTipoInterfaz").focus().before("<span class='error'>Ingrese la descripción de la interfaz</span>");
        $(".errorI").fadeIn();
        band = false;
    }

    if ($("#descripTipoInterfaz").val().length > 2000) {

        $("#descripTipoInterfaz").focus().before("<span class='error'>Excede el numero de caracteres permitidos</span>");
        $(".errorI").fadeIn();
        band = false;
    }

    return band;
}

/* 
 * funcion que valida los datos cuando se edita una interfaz, retornando una bandera de tipo boolean 
 * @returns {Boolean} 
 */ 
function validarDatosInterfaz_edit() {
    var band = true;
    if ($("#interfaz_name_edit").val() == "") {
        $("#interfaz_name_edit").focus().before("<span class='error'>Ingrese el nombre de la Interfaz</span>");
        $(".error").fadeIn();
        band = false;
    }

    if ($("#interfaz_name_edit").val().length > 50) {
        $("#interfaz_name_edit").focus().before("<span class='error'>Excede el numero de caracteres permitidos</span>");
        $(".error").fadeIn();
        band = false;
    }

    if (!isValid_txt($("#interfaz_name_edit").val())) {
        $("#interfaz_name_edit").focus().before("<span class='error'>Caracteres no válidos</span>");
        $(".error").fadeIn();
        band = false;
    }

    if ($("#descripcion_edit").val() == "") {
        $("#descripcion_edit").focus().before("<span class='error'>Ingrese la descripción del proceso</span>");
        $(".error").fadeIn();
        band = false;
    }

    if ($("#descripcion_edit").val().length > 250) {
        $("#descripcion_edit").focus().before("<span class='error'>Excede el numero de caracteres permitidos</span>");
        $(".error").fadeIn();
        band = false;
    }

    if ($("#tipo_edit").val() == "0") {
        $("#tipo_edit").focus().before("<span class='error'>Seleccione el tipo de interfaz</span>");
        $(".error").fadeIn();
        band = false;
    }

    if ($("#detalleTipo_edit").val() == "") {
        $("#detalleTipo_edit").focus().before("<span class='error'>Ingrese el detalle del tipo de intertaz</span>");
        $(".error").fadeIn();
        band = false;
    }

    if ($("#pro_edit_value").val() == "0") {
        $("#pro_edit_value").focus().before("<span class='error'>Seleccione el nombre del proceso</span>");
        $(".error").fadeIn();
        band = false;
    }

    return band;
}



/* 
 * funcion que valida que en una cadena no se encuentren caracteres especiales
 * @returns {Boolean} 
 */ 
function isValid_txt(str) {
    return !/[~`!#$%\^&*+=\-\[\]\\';,/{}|\\":<>\?]/g.test(str);
}