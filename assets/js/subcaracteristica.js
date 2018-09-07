//variable global para hacer referencia a una tabla
var table;
/* 
 * funcion que al momento de cargar la vista subcaracteristica_view carga todas
 * las caracteristicas y subcaracteristcas en la vista.
 * @returns {Boolean} 
 */ 

$(function () { ///esto es jQuejry
    cargarSubcaracteristicas(); ///llamamos a la funcion para que se ejecute al cargar la vista
    cargarCaracteristicasVista();
});

/**
 * Funcion que se encarga de las busquedas por columnnas en la vista 
*/
$(function () {
    var cont = 1;
    var ult;
    $('#tablaSubcaract tfoot th').each(function () {
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

$(function () {
    $("#subcaract_name").keypress(function () {
        $(".error").remove();
    });
});

$(function () {
    $("#caract_relation").click(function () {
        $(".error").remove();
    });
});

$(function () {
    $("#subcaract_descrip").keypress(function () {
        $(".error").remove();
    });
});


/* 
 * funcion que carga las subcaracteristicas en la  la vista 
 * las caracteristicas.
 * @returns {Boolean} 
 */ 
function cargarSubcaracteristicas() {
    table = $('#tablaSubcaract').DataTable({//los datos que me envia el controlador los seteo en la tabla html
        "destroy": true,
        "ajax": {
            "retrieve": true,
            "processing": false, //indicador de proceso
            "serverSide": true,
            "searching": false,
            "method": "POST",
            "url": "SubcaracteristicaController/listarSubcaracteristicas", //donde llamo a la funcion del controlador para que me liste las caracteristicas
            "data": {
            }
        },
        //seteo los datos que me envia el controlador, el nombre de las columnas son tal cual el nombre que se colocaron en el controlador
        "columns": [
            //{"data": "id"},
            {"data": "nombre"},
            {"data": "descripcion"},
            {"data": "caracteristica"},
            {"data": "accion"}
        ]
    });
}

//Abre la ventana modal desde la pagina de gestin de subcaracteristicas
function nuevaSubcaracteristica() {
    $("#modalRegistroSubcaract").modal();
}

//Funcion que renderiza la vista subcaracteristica_view
function subcaracteristicas(){
    location.href ="SubcaracteristicaController";
}


function sub_caracteristica(id_caract) {
    $("#modalRegistroSubcaract").modal();
    $("#caract_relation").val(id_caract);
}

//Realiza la función de registrar una subcaracteristica
function register_Subcaracteristica() {
    if (validarDatos()) {
        $.post("SubcaracteristicaController/registrarSubcaracteristica",
                {
                    "nombreControlador": $("#subcaract_name").val(),
                    "descripcionControlador": $("#subcaract_descrip").val(),
                    "id_caractControlador": $("#caract_relation").val()
                },
                function (data) {

                    if (data == "exist") {
                        $.alert({
                            type: 'orange',
                            icon: 'glyphicon glyphicon-warning',
                            title: 'Advertencia!',
                            content: 'Ya existe una Subcaracteristica con el mismo nombre',
                        });
                    } else {

                        if (data) {
                            $.alert({
                                type: 'green',
                                icon: 'glyphicon glyphicon-ok',
                                title: 'Exito!',
                                content: 'SubCaracteristica Agregada',
                            });

                            $("#subcaract_name").val("");
                            $("#subcaract_descrip").val("");
                            $("#caract_relation").val("0");

                            cargarSubcaracteristicas();
                            $('#modalRegistroSubcaract').modal('hide');

                        } else {
                            $.alert({
                                type: 'red',
                                icon: 'glyphicon glyphicon-ok',
                                title: 'Error!',
                                content: 'Subcaracteristica NO Registrada',
                            });
                            $('#modalRegistroSubcaract').modal('hide');
                        }
                    }

                }, "json");

    } else {
        $.alert({
            type: 'red',
            title: 'Error!',
            content: 'Diligencie todos los campos',
        });
    }
}


/* 
 * funcion que valida los datos en las ventanas modales, retornando una bandera de tipo boolean 
 * @returns {Boolean} 
 */ 

function validarDatos() {

    var band = true;
    if ($("#subcaract_name").val() == "") {
        $("#subcaract_name").focus().before("<span class='error'>Ingrese un nombre.</span>");
        $(".error").fadeIn();
        band = false;
    }

    if ($("#subcaract_descrip").val() == "") {
        $("#subcaract_descrip").focus().before("<span class='error'>Ingrese la descripción.</span>");
        $(".error").fadeIn();
        band = false;
    }

    if ($("#caract_relation").val() == "0") {
        $("#caract_relation").focus().before("<span class='error'> Seleccione una Caracteristica. </span>");
        $(".error").fadeIn();
        band = false;
    }

    return band;
}

/* 
 * funcion que carga las caracteristicas en la vista 
 * las caracteristicas.
 * @returns {Boolean} 
 */ 
function cargarCaracteristicasVista() {
    $.post("SubcaracteristicaController/cargarCaracteristicas",
            function (data) {
                var html = "";
                html += '<select id="caract_relation" class="form-control">';
                html += '<option value="0">Seleccione...</option>'
                for (var i = 0; i < data.length; i++) {
                    html += '<option value="' + data[i].id + '">' + data[i].nombre + '</option>';
                }
                html += "</select> ";
                $("#caracteristica").html(html);
            }, "json");
}



function verSubcaracteristica(id_sub) {
    $.post("SubcaracteristicaController/consultarSubcaracId", ///consulta los datos del proceso por ID
            {
                "id_sub": id_sub
            },
            function (data) {
                $("#subcaract_name_view").val(data.nombre); //setea los Txt con los datos de la BD
                $("#subcaract_descrip_view").val(data.descripcion);
                $("#caracteristica_view").val(data.encargado);

                ///carga la modal
                $("#modalVerSubcaract").modal();
            }, "json");

}



function actualizarSubcaracteristica(id_sub) {
    idS = id_sub;
    $.post("SubcaracteristicaController/consultarSubcaracId", ///consulta los datos del proceso por ID
            {
                "id_sub": id_sub
            },
            function (data) {
                $("#subcaract_name_edit").val(data.nombre); //setea los Txt con los datos de la BD
                $("#subcaract_descrip_edit").val(data.descripcion);
                $("#caracteristica_edit").val(data.encargado);

                ///carga la modal
                $("#modalActualizarSubcaract").modal();
            }, "json");

}

function ActualizarR() {
    $.post("SubcaracteristicaController/actualizarSubcaracteristica",
            {
                "nombre": $("#subcaract_name_edit").val(),
                "descripcion": $("#subcaract_descrip_edit").val(),
                "caracteristica": $("#caracteristica_edit").val(),
                "id_sub": idS
            },
            function (data) {

                if (data) {
                    $.alert({
                        type: 'green',
                        icon: 'glyphicon glyphicon-ok',
                        title: 'Exito!',
                        content: 'Subcaracteristica Actualizada',
                    });

                    $("#subcaract_name_edit").val("");
                    $("#subcaract_descrip_edit").val("");
                    $("#caracteristica_edit").val("0");

                    cargarSubcaracteristicas();
                    $('##modalActualizarSubcaract').modal('hide');

                } else {
                    $.alert({
                        type: 'red',
                        icon: 'glyphicon glyphicon-ok',
                        title: 'Error!',
                        content: 'No se actualizo la subcaracteristica',
                    });
                    $('##modalActualizarSubcaract').modal('hide');
                    cargarRoles();
                }
            }, "json");
}
/*
 * funcion que se comunica con el controlador enviandolo el identificador de la subcaracteristica
 * para poder eliminar los datos de la base de datos.
 * retorna un resultado JSON de si el valor fue eliminado.
 */
function eliminarSubcaracteristica(id_sub) {

    $.confirm({
        type: 'orange',
        icon: 'glyphicon glyphicon-warning-sign',
        title: 'Advertencia!',
        content: 'Desea eliminar esta subcaracteristica?',
        buttons: {
            aceptar: function () {
                $.post("SubcaracteristicaController/eliminarSubcaracteristica",
                        {
                            "id_sub": id_sub
                        },
                        function (data) {
                            cargarSubcaracteristicas();
                        }, "json");

            },
            cancelar: function () {
            }
        }
    });
}

/* 
 * funcion que valida que en una cadena no se encuentren caracteres especiales
 * @returns {Boolean} 
 */ 
function isValid_txt(str) {
    return !/[~`!#$%\^&*+=\-\[\]\\';,/{}|\\":<>\?]/g.test(str);
}

/* 
 * funcion que valida que en una cadena de caracteres solo sean de letras
 * @returns {Boolean} 
 */ 
function onlyLetters(l) {
    var valid1 = "/^[a-zA-Z]+$/";
    if ((/^[a-zA-Z]+$/.test(l))) {
        return false;
    } else {
        return true;
    }
}

