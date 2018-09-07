/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var proceso_paralelo;
$(document).ready(function () {

    listarProcesos();
    cargarProcesos();
    
    $("#listaProcesos").sortable({
        placeholder: "ui-state-highlight",
        update: function (event, ui)
        {
            var page_id_array = new Array();
            $('#listaProcesos li').each(function () {
                page_id_array.push($(this).attr("id"));
            });
            $.ajax({
                url: "http://localhost/levantamientorequisitos/ProcesoController/actualizarSecuencia",
                method: "POST",
                data: {proceso_id_array: page_id_array},
                success: function (data)
                {
                    listarProcesos();
                    $.alert({
                        type: 'blue',
                        typeAnimated: true,
                        theme: 'material',
                        icon: 'glyphicon glyphicon-ok',
                        title: 'Exito!',
                        content: 'Secuencia actualizada',
                    });
                }
            });
        }
    });
});

function procesosParalelos(proceso){
    proceso_paralelo = proceso;
    cargarProcesosParalelos(proceso_paralelo);
    $("#modalProcesosP").modal();

}
function cargarProcesos() {

    table = $('#tablaProcesos').DataTable({//los datos que me envia el controlador los seteo en la tabla html
        "destroy": true,
        "ajax": {
            "retrieve": true,
            "processing": false, //indicador de proceso
            "serverSide": true,
            "searching": false,
            "method": "POST",
            "url": "http://localhost/levantamientorequisitos/ProcesoController/listarProcesos", //donde llamo a la funcion del controlador para que me liste los proceos
            "data": {
                "paralelos": true, 
            }
        },
        //seteo los datos que me envia el controlador, el nombre de las columnas son tal cual el nombre que se colocaron en el controlador
        "columns": [
            {"data": "nombre"},
            {"data": "desc"},
            {"data": "prioridad"},
            {"data": "accion"}
            
        ]
    });
}

function cargarProcesosParalelos(id_proceso) {
    var id_proceso=id_proceso;
    table = $('#tablaProcesosParalelos').DataTable({//los datos que me envia el controlador los seteo en la tabla html
        "destroy": true,
        "ajax": {
            "retrieve": true,
            "processing": false, //indicador de proceso
            "serverSide": true,
            "searching": false,
            "method": "POST",
            "url": "http://localhost/levantamientorequisitos/ProcesoController/listarProcesosParalelos", //donde llamo a la funcion del controlador para que me liste los proceos
            "data": {
                "paralelos": true, 
                "proceso":id_proceso,
            }
        },
        //seteo los datos que me envia el controlador, el nombre de las columnas son tal cual el nombre que se colocaron en el controlador
        "columns": [
            {"data": "nombre"},
            {"data": "desc"},
            {"data": "prioridad"},
            {"data": "accion"}
            
        ]
    });
}

$(function () {
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

$(function () {
    var cont = 1;
    $('#tablaProcesosParalelos tfoot th').each(function () {
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
function subirProceso(procesoSubir){
    
    $.post("http://localhost/levantamientorequisitos/ProcesoController/establecerParalelo",
            {
                "proceso": proceso_paralelo,
                "paralelo": procesoSubir
            },
            function (data) {
                if (data) {
                    alert('colcio');
                }
            }, "json");
}
function listarProcesos() {

    $.post("http://localhost/levantamientorequisitos/ProcesoController/listaProcesosSecuencia",
    function (data) {
        var html = "";
        for (var i = 0; i < data.length; i++) {
            html += '<li id="' + data[i].idproceso + '">' + '<b>' + '<span class="label label-info">' + data[i].orden_secuencia + '</span> ' + data[i].nombre + '</b>' + '<br/>' + data[i].descripcion +'</br> </li>';
        }
        $("#listaProcesos").html(html);
    }, "json");
}


