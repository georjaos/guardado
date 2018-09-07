/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//Esta clase de JavaScript comunica la vista con el controlador para gestionar las normativas asociadas a cada proceso

var table;
var ID_PROCESO = 0;

//Llama a la funcion para que se ejecute al cargar la vista
$(function () {
    cargarNormativas();
    listaProcesos();
});

//Realiza las busquedas del usuario por columnas
$(function () {
    var c = 1;   
    var ul;
    $('#tablaNormativa tfoot th').each(function () {
        var title = $(this).text();
        ul = this;
        $(this).html('<input type="text" placeholder="Buscar" class="form-control txt_find" id="txt' + c + '"/>');
        c++;
    });
    $(ul).html('<p id="txt_acc"></p>');

    table.columns().every(function () {
        var that = this;

        $('input', this.footer()).on('keyup change', function () {
            that
                    .search(this.value)
                    .draw();
        });
    });

});

//Lista los procesos para seleccionar un proceso en el formulario de edición o agregación
function listaProcesos() {
    $.post("NormativaController/listaProcesos",
            function (data) {
                var html = "";
                html += '<select id="proceso" class="form-control">';
                html += '<option value="0">Seleccione...</option>';
                for (var i = 0; i < data.length; i++) {
                    html += '<option value="' + data[i].idproceso + '">' + data[i].nombre + '</option>';
                }
                html += "</select> ";
                
                var html_pro = "";
                html_pro += '<label for="prioridad"><span class="glyphicon glyphicon-comment " ></span> Nombre del Proceso</label><span id="require">*</span><span id="error"></span>';
                html_pro += '<select id="norma_pro_edit_value" class="form-control">';
                html_pro += '<option value="0">Seleccione...</option>';
                for (var i = 0; i < data.length; i++) {
                    html_pro += '<option value="' + data[i].idproceso + '">' + data[i].nombre + '</option>';
                }
                html_pro += "</select> ";

                $("#proceso").html(html);
                $("#norma_proceso_edit").html(html_pro);

            }, "json");
}

//Carga las normativas en una tabla, setea los datos que envia el controlador en la tabla html
function cargarNormativas() {

    table = $('#tablaNormativa').DataTable({
        "destroy": true,
        "ajax": {
            "retrieve": true,
            "processing": false, 
            "serverSide": true,
            "searching": false,
            "method": "POST",
            "url": "NormativaController/listarNormativas",
            "data": {
            }
        },        
        "columns": [            
            {"data": "nombre"},
            {"data": "descripcion"},
            {"data": "idproceso"},
            {"data": "accion"}
        ]
    });
}

//Recibe el Id normativa y muestra los datos de la descripción
function verDescripNorma(id_norma) {
    $.post("NormativaController/consultarNormativaId",
            {
                "id": id_norma
            },
            function (data) {
                $.alert({
                    type: 'blue',
                    icon: '	glyphicon glyphicon-comment',
                    title: 'Descripción!',
                    content: '<p>' + data.descripcion + '</p>',
                    columnClass: 'col-md-8 col-md-offset-2',
                });
            }, "json");
}


//Recibe el Id de proceso, captura los datos recibidos en la vista (modal) los valida 
//y envia los datos al controlador para insertar la nueva normativa 
//en la tabla normativa en la BD
function agregarNormativa(id_proceso) {
    $("#modalAgragarNormativa").modal();
    $("#norma_name").val("");
    $("#descripNorma").val("");
    $("#add_normativa").click(function () {
        if (validarDatos_norma()) {

            $.post("NormativaController/agregarNormativa",
                    {
                        "id_pro": id_proceso,
                        "nombre": $("#norma_name").val(),
                        "descripcion": $("#descripNorma").val()
                    },
                    function (data) {
                        if (data === "exist") {

                            $.alert({
                                type: 'orange',
                                icon: 'glyphicon glyphicon-warning',
                                title: 'Advertencia!',
                                content: 'Ya existe una normativa con el misma nombre y la misma descripción'
                            });
                        } else {
                            if (data) {
                                $.alert({
                                    type: 'green',
                                    icon: 'glyphicon glyphicon-ok',
                                    title: 'Exito!',
                                    content: 'Nomartiva Registrada'
                                });
                                $("#norma_name").val("");
                                $("#descripNorma").val("");
                                $('#modalAgragarNormativa').modal('hide');
                            } else {
                                $.alert({
                                    type: 'red',
                                    icon: 'glyphicon glyphicon-remove',
                                    title: 'Error!',
                                    content: 'Normativa NO Registrada',
                                });
                                $('#modalAgragarNormativa').modal('hide');
                            }
                        }
                    }, "json");
        } else {
        }
        $("#add_normativa").unbind('click');
    }

    );
}


//Recibe el Id de nomativa, lo envia al controlador, obtiene la norma asociada y setea  los Txt con los datos de la BD
function actualizarNorm(id_norma) {
    idNor = id_norma;
    $.post("NormativaController/consultarNormativaId", 
            {
                "id": id_norma
            },
            function (data) {
                $("#norma_name_edit").val(data.nombre); 
                $("#norma_descripcion_edit").val(data.descripcion);
                $("#norma_pro_edit_value").val(data.idproceso); 

                $("#modalActualizarNormativa").modal();

            }, "json");


}


//Valida los datos obtenidos de la vista (modal) 
//envia los datos al controlador para actualizar la normativa 
//en la tabla normativa en la BD
function actualizarNormativa() {

    if (validarDatosNorma_edit()) {
        $.post("NormativaController/actualizarNormativa",
                {
                    "nombre": $("#norma_name_edit").val(),
                    "descripcion": $("#norma_descripcion_edit").val(),
                    "proceso": $("#norma_pro_edit_value").val(),
                    "id_nor": idNor
                },
                function (data) {
                    if (data) {                        
                        $.alert({
                            type: 'green',
                            icon: 'glyphicon glyphicon-ok',
                            title: 'Exito!',
                            content: 'Normativa Actualizada'
                        });
                        $("#norma_name_edit").val("");
                        $("#norma_descripcion_edit").val("");
                        $("#norma_pro_edit_value").val("0");                        
                        cargarNormativas();
                        $('#modalActualizarNormativa').modal('hide');

                    } else {
                        $.alert({
                            type: 'red',
                            icon: 'glyphicon glyphicon-remove',
                            title: 'Error!',
                            content: 'Error al actualizar Normativa'
                        });

                        $("#norma_name_edit").val("");
                        $("#norma_descripcion_edit").val("");
                        $("#norma_pro_edit_value").val("0");

                        $('#modalActualizarNormativa').modal('hide');
                        cargarNormativas();
                    }
                }, "json");
    } else {        
    }
}

//Recibe el Id de normativa, lo envia al controlador para eliminar la normativa y vuelve a cargar las normativas
function eliminarNormativa(id) {
    $.confirm({
        type: 'orange',
        icon: 'glyphicon glyphicon-warning-sign',
        title: 'Advertencia!',
        content: 'Desea eliminar la normativa?',
        buttons: {
            aceptar: function () {
                $.post("NormativaController/eliminarNormativa",
                        {
                            "id": id
                        },
                        function (data) {
                            if (data) {
                                $.alert({
                                    type: 'green',
                                    icon: 'glyphicon glyphicon-ok',
                                    title: 'Exito!',
                                    content: 'Se elimino la Normativa'
                                });
                                cargarNormativas();
                            } else {
                                $.alert({
                                    type: 'red',
                                    icon: 'glyphicon glyphicon-remove',
                                    title: 'Error!',
                                    content: 'Error al eliminar Normativa'
                                });
                            }
                        }, "json");
            },
            cancelar: function () {

            }
        }
    });
}

//Recibe el Id de normativa, lo envia al controlador y setea los campos Txt de la modal ver para ver datos de la normativa
function verNormativa(idNor) {
    $.post("NormativaController/consultarNormativaId",
            {
                "id": idNor
            },
            function (data) {
                $("#norma_name_view").val(data.nombre);
                $("#norma_descripcion_view").val(data.descripcion);
                $("#norma_proceso_view").val(data.nombreproceso);
                $("#norma_descripcionp_view").val(data.descripcionproceso);

                $("#modalVerNormativa").modal();
            }, "json");
}





/// valida los datos de entrada de la vista normativa, cada campo
function validarDatos_norma() {    
    var band = true;
    if ($("#norma_name").val() === "") {
        $("#norma_name").focus().before("<span class='error'>Ingrese un nombre a la normativa</span>");
        $(".error").fadeIn();
        band = false;
    }
    if ($("#norma_name").val().length > 50) {
        $("#norma_name").focus().before("<span class='error'>Excede el numero de caracteres permitidos</span>");
        $(".error").fadeIn();

        band = false;
    }
    if (!isValid_txt($("#norma_name").val())) {
        $("#norma_name").focus().before("<span class='error'>Caracteres no válidos</span>");
        $(".error").fadeIn();
        band = false;
    }
    if ($("#descripNorma").val() === "") {
        $("#descripNorma").focus().before("<span class='error'>Ingrese una descripción</span>");
        $(".error").fadeIn();
        band = false;
    }
    if ($("#descripNorma").val().length > 200) {
        $("#descripNorma").focus().before("<span class='error'>Excede el numero de caracteres permitidos</span>");
        $(".error").fadeIn();
        band = false;
    }
    return band;
}

/// valida los datos de entrada de la vista de editar la normativa, cada campo
function validarDatosNorma_edit() {
    var band = true;
    if ($("#norma_name_edit").val() === "") {
        $("#norma_name_edit").focus().before("<span class='error'>Ingrese un nombre a la normativa</span>");
        $(".error").fadeIn();
        band = false;
    }
    if ($("#norma_name_edit").val().length > 50) {
        $("#norma_name_edit").focus().before("<span class='error'>Excede el número de caracteres permitidos</span>");
        $(".error").fadeIn();
        band = false;
    }
    if (!isValidTxt($("#norma_name_edit").val())) {
        $("#norma_name_edit").focus().before("<span class='error'>Caracteres noooooooo válidos</span>");
        $(".error").fadeIn();
        band = false;
    }
    if ($("#norma_descripcion_edit").val() === "") {
        $("#norma_descripcion_edit").focus().before("<span class='error'>Ingrese una descripción</span>");
        $(".error").fadeIn();
        band = false;
    }
    if ($("#norma_descripcion_edit").val().length > 200) {
        $("#norma_descripcion_edit").focus().before("<span class='error'>Excede el número de caracteres permitidos</span>");
        $(".error").fadeIn();
        band = false;
    }
    if ($("#norma_pro_edit_value").val() === "0") {
        $("#norma_pro_edit_value").focus().before("<span class='error'>Seleccione el nombre del proceso</span>");
        $(".error").fadeIn();
        band = false;
    }
    return band;
}

// Valida la expresión regular si tiene los caracteres indicados
function isValidTxt(str) {
    return !/[~`!#$%\^&*+=\-\[\]\\';,/{}|\\":<>\?]/g.test(str);
}