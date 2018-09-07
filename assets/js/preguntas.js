/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var table;
var ID_CARACTERISTICA = 0;
$(function () {
    cargarPreguntas();
    listarCaracteristicas();

});

//Busqueda por columnas
$(function () {
    var cont = 1;
    var ult;
    $('#tablaPreguntas tfoot th').each(function () {
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

function cargarPreguntas() {

    table = $('#tablaPreguntas').DataTable({//los datos que me envia el controlador los seteo en la tabla html
        "destroy": true,
        "ajax": {
            "retrieve": true,
            "processing": false, //indicador de proceso
            "serverSide": true,
            "searching": false,
            "method": "POST",
            "url": "PreguntasController/listarPreguntas", //donde llamo a la funcion del controlador para que me liste las preguntas
            "data": {
            }
        },
        //seteo los datos que me envia el controlador, el nombre de las columnas son tal cual el nombre que se colocaron en el controlador
        "columns": [
            //{"data": "id"},
            {"data": "nombre"},
            {"data": "nombreC"},
            {"data": "accion"}
        ]
    });
}
function preguntas(){
    location.href ="PreguntasController";
}

function agregarPregunta(caracteristica) {
    ID_CARACTERISTICA = caracteristica;
    $("#modalAgregarPregunta").modal();
    listarSubCarateristicas_Id(caracteristica);
}


function add_pregunta() {
    if (validarDatos_preguntas()) {
        $.post("PreguntasController/insertarPregunta",
                {
                    "nombre": $("#pregunta_name").val(),
                    "id_caract": $("#sub_caract").val()

                },
                function (data) {

                    if (data) {
                        $.alert({
                            type: 'green',
                            icon: 'glyphicon glyphicon-ok',
                            title: 'Exito!',
                            content: 'Pregunta Agregada',
                        });

                        $("#pregunta_name").val("");

                        $('#modalAgregarPregunta').modal('hide');

                    } else {
                        $.alert({
                            type: 'red',
                            icon: 'glyphicon glyphicon-ok',
                            title: 'Error!',
                            content: 'pregunta NO Registrada',
                        });
                        $('#modalAgregarPregunta').modal('hide');
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

function verPreguntas(id_preguntas) {
    $.post("PreguntasController/consultarPreguntaId",
            {
                "id": id_preguntas
            },
            function (data) {
                $("#pregunta_name_view").val(data.nombre);
                $("#caracteristica_view").val(data.nombrecaracteristica);

                $("#modalVerPregunta").modal();
            }, "json");
}

function eliminarPregunta(id) {

    $.confirm({
        type: 'orange',
        icon: 'glyphicon glyphicon-warning-sign',
        title: 'Advertencia!',
        content: 'Desea eliminar la pregunta ?',
        buttons: {
            aceptar: function () {
                $.post("PreguntasController/eliminarPregunta",
                        {
                            "id": id
                        },
                        function (data) {
                            if (data) {
                                $.alert({
                                    type: 'green',
                                    icon: 'glyphicon glyphicon-ok',
                                    title: 'Exito!',
                                    content: 'se elimino la Pregunta',
                                });
                                cargarPreguntas();
                            } else {
                                $.alert({
                                    type: 'red',
                                    icon: 'glyphicon glyphicon-remove',
                                    title: 'Error!',
                                    content: 'No se elimino la Pregunta',
                                });
                            }
                        }, "json");
            },
            cancelar: function () {

            }
        }
    });
}

function actualizarPregunta(id_pregunta) {


    idP = id_pregunta;
    $.post("PreguntasController/consultarPreguntaId", ///consulta los datos del proceso por ID
            {
                "id": id_pregunta
            },
            function (data) {

                $("#pregunta_name_edit").val(data.nombre); //setea los Txt con los datos de la BD
                $("#caract_edit_value").val(data.id_sub_caracteristica); //revisar esta parte

                $("#modalActualizarPreguntas").modal();
            }, "json");


}

function actualizarPre() {

    if (validarDatos_edit()) {
        $.post("PreguntasController/actualizarPregunta",
                {
                    "nombre": $("#pregunta_name_edit").val(),
                    "id_caract": $("#caract_edit_value").val(),
                    "id_pre": idP
                },
                function (data) {

                    if (data) {
                        $.alert({
                            type: 'green',
                            icon: 'glyphicon glyphicon-ok',
                            title: 'Exito!',
                            content: 'Pregunta Actualizada',
                        });

                        $("#nombre").val("");
                        $("#id_caract").val("0");

                        cargarPreguntas();
                        $('#modalActualizarPreguntas').modal('hide');

                    } else {
                        $.alert({
                            type: 'red',
                            icon: 'glyphicon glyphicon-remove',
                            title: 'Error!',
                            content: 'No se actualizo la pregunta',
                        });
                        $('#modalActualizarPreguntas').modal('hide');
                        cargarPreguntas();
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

function listarCaracteristicas() {
    $.post("PreguntasController/listaCaracteristicas",
            function (data) {
                var html = "";
                html += '<select id="caracteristica" class="form-control">';
                html += '<option value="0">Seleccione...</option>'
                for (var i = 0; i < data.length; i++) {
                    html += '<option value="' + data[i].id + '">' + data[i].nombre + '</option>';
                }
                html += "</select> ";

                ////cargar procesos de editar
                var html_pro = "";
                html_pro += '<label for="prioridad"><span class="glyphicon glyphicon-comment " ></span> SubCaracteristica </label><span id="require">*</span><span id="error"></span>';
                html_pro += '<select id="caract_edit_value" class="form-control">';
                html_pro += '<option value="0">Seleccione...</option>'
                for (var i = 0; i < data.length; i++) {
                    html_pro += '<option value="' + data[i].id_sub + '">' + data[i].nombre + '</option>';
                }
                html_pro += "</select> ";

                $("#caracteristica").html(html);
                $("#caracteristica_edit").html(html_pro);

            }, "json");
}

function isValid_txt(str) {
    return !/[~`!#$%\^&*+=\-\[\]\\'/{}|\\":<>\?]/g.test(str);
}

$(function () {
    $("#sub_caract").click(function () {
        $(".errorCaract").remove();
    });
});

$(function () {
    $("#pregunta_name").keypress(function () {
        $(".errorCaract").remove();
    });
});

function validarDatos_preguntas() {

    var band = true;
    if ($("#pregunta_name").val() == "") {
        $("#pregunta_name").focus().before("<span class='errorCaract'>Ingrese la pregunta</span>");
        $(".errorCaract").fadeIn();
        band = false;
    }
    /*if (!isValid_txt($("#pregunta_name").val())) {
        $("#pregunta_name").focus().before("<span class='errorCaract'>Caracteres no válidos</span>");
        $(".errorCaract").fadeIn();
        band = false;
    }*/
    if($("#sub_caract").val() == "" || $("#sub_caract").val() == "0"){
        $("#sub_caract").focus().before("<span class='errorCaract'>Selecione una subcaracteristica</span>");
        $(".errorCaract").fadeIn();
        band = false;
    }

    return band;
}

function validarDatos_edit() {
    var band = true;
    if ($("#ipregunta_name_edit").val() == "") {
        $("#pregunta_name_edit").focus().before("<span class='error'>Ingrese la pregunta</span>");
        $(".error").fadeIn();
        band = false;
    }

    if ($("#pregunta_name_edit").val().length > 50) {
        $("#pregunta_name_edit").focus().before("<span class='error'>Excede el numero de caracteres permitidos</span>");
        $(".error").fadeIn();
        band = false;
    }

    if (!isValid_txt($("#pregunta_name_edit").val())) {
        $("#pregunta_name_edit").focus().before("<span class='error'>Caracteres no válidos</span>");
        $(".error").fadeIn();
        band = false;
    }

    if ($("#caract_edit_value").val() == "0") {
        $("#caract_edit_value").focus().before("<span class='error'>Seleccione la caracteristica</span>");
        $(".error").fadeIn();
        band = false;
    }

    return band;
}

function listarSubCarateristicas_Id(id_caract) {
        $.post("SubcaracteristicaController/listarSubCarateristicas_Id", {
                "id": id_caract
            },
            function (data) {
                if (!data) {
                    var html = "";
                    html += '<select id="sub_caract" class="form-control">';
                    html += '<option value="0">Seleccione...</option>'
                    html += "</select> ";
                    $("#sub_caracteristicas_lst").html(html);
                } else {
                    var html = "";
                    html += '<select id="sub_caract" class="form-control">';
                    html += '<option value="0">Seleccione...</option>'
                    for (var i = 0; i < data.length; i++) {
                        html += '<option value="' + data[i].id_sub + '">' + data[i].nombre + '</option>';
                    }
                    html += "</select> ";
                    $("#sub_caracteristicas_lst").html(html);
                }
            }, "json");
}