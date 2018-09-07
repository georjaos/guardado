
/*
 * archivo que sirve para comunicar la vista con el controlador a traves de AJAX mediante javascript 
 */
//variable global de la tabla para poder acceder a diferentes funciones
var table;
//ide de la caracteristica global que sirve para ser usada en diferentes funciones
var ID_CARACT = 0;
$(function () {
    cargarCaracteristicas();
});

$(function () {
    var cont = 1;
    var ult;
    $('#tabla_caracteristica tfoot th').each(function () {
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
 * para agregar una nueva caracteristica, se abre una modal que 
 * tiene el formulario del registro de los datos de la caracteristica
 */
function nuevaCaracteristica() {
    $("#addCaracteristica").modal();
}
function vista_cliente_caracteristicas(){
    $("#btnCaracteristica").hide();
}

/*
 * funcion que procesa los nuevos datos del formulario de caracteristica para enviarlos al controlador
 * retornando un JSON resultado de si los datos fueron registrados o no 
 */
function guardarCaracteristica() {
    //valodamos los datos antes de enviarlos al controlador
    if (validarDatosCaracteristica()) {
        $.ajax({
            url: "CaracteristicaController/insertarCaracteristica", //url donde esta la funcion del controlador
            type: "POST",
            dataType: "json",
            data: {
                //parametros enviados al controlador
                "nombre": $("#name_caracteristica").val(),
                "descripcion": $("#descrip_caracteristica").val()
            },
            beforeSend: function () {

            },
            success: function (data) {
                //resultado enviado desde el controlador
                if (data == "exist") {
                    $.alert({
                        type: 'red',
                        icon: 'glyphicon glyphicon-remove',
                        title: 'Error!',
                        content: 'Ya existe una caracteristica con el mismo nombre',
                    });
                } else {
                    if (data) {
                        $.alert({
                            type: 'green',
                            icon: 'glyphicon glyphicon-ok',
                            title: 'OK!',
                            content: 'Caracteristica guardada',
                        });
                        //cargamos los nuevos datos en la vista mediante una tabla
                        cargarCaracteristicas();
                    } else {
                        $.alert({
                            type: 'red',
                            icon: 'glyphicon glyphicon-remove',
                            title: 'Error!',
                            content: 'No se guardo la caracteristica',
                        });
                    }
                    $('#addCaracteristica').modal('hide');
                }

            },
            error: function (response) {

            }
        });
    }
}
/*
 *funcion que envia los datos del formulario de la vista caracteristica para ser actualizados
 *en la base de datos y retornando un resultado JSON de si los datos fueron actualizados.  
 */
function actualizarCaracteristica() {
    //validamos los datos antes de enviarlos al controlador
    if (validarDatosCaracteristica_edit()) {
        $.ajax({
            url: "CaracteristicaController/actualizarCaracteristica", //url del controlador donde enviamos la peticion
            type: "POST",
            dataType: "json",
            data: {
                //parametros enviados al controlador a traves de AJAX
                "nombre": $("#name_caracteristica_edit").val(),
                "descripcion": $("#descrip_caracteristica_edit").val(),
                "id": ID_CARACT
            },
            beforeSend: function () {

            },
            success: function (data) {

                //resultado enviado por el controlador
                if (data) {
                    $.alert({
                        type: 'green',
                        icon: 'glyphicon glyphicon-ok',
                        title: 'OK!',
                        content: 'Caracteristica guardada',
                    });
                    cargarCaracteristicas();
                } else {
                    $.alert({
                        type: 'red',
                        icon: 'glyphicon glyphicon-remove',
                        title: 'Error!',
                        content: 'No se guardo la caracteristica',
                    });
                }
                $('#caracteristica_edit').modal('hide');
            },
            error: function (response) {
            }
        });
    }
}

/*
 * funcion que envia el identificador de la caracteristica al controlador para 
 * poder eliminar la caracteristica de la base de datos.
 * retorna un JSON de con la repsuesta del controlador de si elimino el registro o no.
 */
function deleteCaracteristica(id) {
    //mensaje de confirmacion antes de eliminar la caracteristica
    $.confirm({
        type: 'orange',
        icon: 'glyphicon glyphicon-warning-sign',
        title: 'Advertencia!',
        content: 'Desea eliminar la Caracteristica ?',
        buttons: {
            aceptar: function () {
                $.ajax({
                    url: "CaracteristicaController/eliminarCaracteristica",//url del controlador para eliminar la caracteristica
                    type: "POST",
                    dataType: "json",
                    data: {
                        //parametro enviado por medio de POST
                        "id": id
                    },
                    beforeSend: function () {

                    },
                    success: function (data) {
                        //resultado enviado desde el controlador
                        if (data) {
                            $.alert({
                                type: 'green',
                                icon: 'glyphicon glyphicon-ok',
                                title: 'OK!',
                                content: 'Caracteristica Actualizada',
                            });
                            cargarCaracteristicas();
                        } else {
                            $.alert({
                                type: 'red',
                                icon: 'glyphicon glyphicon-remove',
                                title: 'Error!',
                                content: 'No se actualizo la Caracteristica',
                            });
                        }
                    },
                    error: function (response) {
                    }
                });
            },
            cancelar: function () {

            }
        }
    });
}
/*
 * funcion eu muestra en una modal la informacion de la caracteristica
 */
function viewCaracteristica(data) {
    $("#name_caracteristica_view").val(data.nombre);
    $("#descrip_caracteristica_view").val(data.descripcion);
    $("#caracteristica_view").modal();
}

/*
 * funcion que abre la modal donde muestra los datos de la caracteristica para luego ser editados
 */
function editCaracteristica(data) {
    $("#name_caracteristica_edit").val(data.nombre);
    $("#descrip_caracteristica_edit").val(data.descripcion);
    ID_CARACT = data.id;
    $("#caracteristica_edit").modal();
}
/*
 * funcion que envia una peticion al controlador por medio de AJAX para poder consultar los datos
 * de las caracteristicas.
 * retornando un JSON con el resutado de la busqueda y poder mostrarlos en la vista por medio d euna tabla
 */
function cargarCaracteristicas() {

    table = $('#tabla_caracteristica').DataTable({//los datos que me envia el controlador los muestro en la tabla html
        "destroy": true,
        "ajax": {
            "retrieve": true,
            "processing": false, //indicador de proceso
            "serverSide": true,
            "searching": false,
            "method": "POST",
            "url": "CaracteristicaController/listarCaracteristicas", //donde llamo a la funcion del controlador para que me liste las caracteristicas
            "data": {
            }
        },
        //seteo los datos que me envia el controlador a una tabla. el nombre de las columnas son tal cual el nombre que se colocaron en el controlador
        "columns": [
            //{"data": "id"},
            {"data": "nombre"},
            {"data": "descrip"},
            {"data": "accion"}
        ],
        "order": [[0, "asc"]]
    });
}
/*
 * funcion que valida los datos de la caracteristica antes de enviar los datos de la caracteristica al controlador
 */
function validarDatosCaracteristica() {
    var band = true;
    if ($("#name_caracteristica").val() == "") {
        $("#name_caracteristica").focus().before("<span class='errorCaract'>Ingrese el nombre de la caracteristica</span>");
        $(".errorCaract").fadeIn();
        band = false;
    }

    if ($("#descrip_caracteristica").val() == "") {
        $("#descrip_caracteristica").focus().before("<span class='errorCaract'>Ingrese la descripción de la caracteristica</span>");
        $(".errorCaract").fadeIn();
        band = false;
    }

    if (!isValid_txt($("#name_caracteristica").val())) {
        $("#name_caracteristica").focus().before("<span class='errorCaract'>Caracteres no válidos</span>");
        $(".errorCaract").fadeIn();
        band = false;
    }
    return band;
}
/*
 *valida los datos del formulario de editar caracteristica antes de enviarlo al controlador
 */
function validarDatosCaracteristica_edit() {
    var band = true;
    if ($("#name_caracteristica_edit").val() == "") {
        $("#name_caracteristica_edit").focus().before("<span class='errorCaract'>Ingrese el nombre de la caracteristica</span>");
        $(".errorCaract").fadeIn();
        band = false;
    }

    if ($("#descrip_caracteristica_edit").val() == "") {
        $("#descrip_caracteristica_edit").focus().before("<span class='errorCaract'>Ingrese la descripción de la caracteristica</span>");
        $(".errorCaract").fadeIn();
        band = false;
    }

    if (!isValid_txt_caract($("#name_caracteristica_edit").val())) {
        $("#name_caracteristica_edit").focus().before("<span class='errorCaract'>Caracteres no válidos</span>");
        $(".errorCaract").fadeIn();
        band = false;
    }
    return band;
}
/*
 * eventos al presionar una tecla en los campos de los formularios
 */
$(function () {
    $("#name_caracteristica").keypress(function () {
        $(".errorCaract").remove();
    });

    $("#descrip_caracteristica").keypress(function () {
        $(".errorCaract").remove();
    });

    $("#name_caracteristica_edit").keypress(function () {
        $(".errorCaract").remove();
    });

    $("#descrip_caracteristica_edit").keypress(function () {
        $(".errorCaract").remove();
    });
});
/*
 * valida los caracteres de una cadena de texto no sean especiales
 */
function isValid_txt_caract(str) {
    return !/[~`!#$%\^&*+=\-\[\]\\';/{}|\\":<>\?]/g.test(str);
}

