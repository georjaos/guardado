<?php $this->load->view('head/headers'); ?>
<?php $this->load->view('head/nav'); ?>
<!--<script src="assets/js/rnf.js"></script>-->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style_rnf.css">
<h2 style="text-align: center; margin-top: 50px;">DEFINIR RNF</h2>

<div id="rnf">
    <div class="panel panel-default" style="padding: 0%; overflow-x:auto;">
        <!--nos muestra la informacion de las repuestas de forma dinamica mediante javascript-->
        <div class="panel-body">
            <div id="rnf_sol">

            </div>
        </div>
    </div>
</div>

<script>
    //variable que nos permite visualizar los paneles de las respuestas
    var panel="";
    ///obtenemos el id_del proceso enviado desde el controlador
    var id_proceso =<?php echo $id_proceso; ?>;
    //variable global para utilizarla en direntes metodos
    var IDPREGUNTA = 0;
    //variable global para utilizarla en direntes metodos
    var id_txt_respuesta = 0;
    $(function () {
        $(".panel_respuesta").hide();
        //al cargar la vista, automaticamente carga los datos de las caracteristicas
        getCaracteristicas();
    });
    
    /*
     * funcion que hace la peticion al controlador para poder visualizar los datos de las
     * caracteristicas guardadas en la base de datos
     */
    function getCaracteristicas() {
        
        $.ajax({
            url: "<?php echo base_url(); ?>DefinirRNFController/listarCaracteristicas", //url del controlador al que se le hace la peticion
            type: "POST",
            dataType: "json",
            data: {
                
            },
            beforeSend: function () {
                //$("#loader").show();
            },
            success: function (data) {
                //retorna el resultado enviado por el controlador
                if (!data) {

                } else {
                    showCaracteristicas(data);
                }
            },
            error: function (response) {
                //$("#loader").hide();
            }
        });
    }

    function showCaracteristicas(data) {

        var html = "";
        html += '<ul class="nav nav-tabs">';
        for (var i = 0; i < data.length; i++) {
            if (i == 0) {
                html += '<li class="active"><a data-toggle="tab" href="#tab' + data[i].id + '" onclick="ver_sub_caract(' + data[i].id + ')">' + data[i].nombre + '</a></li>';
                ver_sub_caract(data[i].id);
            } else {
                html += '<li><a data-toggle="tab" href="#tab' + data[i].id + '" onclick="ver_sub_caract(' + data[i].id + ')">' + data[i].nombre + '</a></li>';
            }
        }
        html += '</ul>';

        html += '<div class="tab-content">'
        for (var i = 0; i < data.length; i++) {
            if (i == 0) {
                html += '<div id="tab' + data[i].id + '" class="tab-pane fade in active panel_sub">';
                html += '<div id="sub_caract' + data[i].id + '" class="info_sub"></div>';
                html += '<div id="panel_respuesta' + data[i].id + '" class="panel_respuesta"></div>';
                html += '</div>';
            } else {
                html += '<div id="tab' + data[i].id + '" class="tab-pane fade">';
                html += '<div id="sub_caract' + data[i].id + '" class="info_sub"></div>';
                html += '<div id="panel_respuesta' + data[i].id + '" class="panel_respuesta"></div>';
                html += '</div>';
            }
        }
        html += '</div>';
        $("#rnf_sol").html(html);
        $(".panel_respuesta").hide();
    }

    function ver_sub_caract(id_sub) {

        $.ajax({
            url: "<?php echo base_url(); ?>SubcaracteristicaController/listarSubCarateristicas_Id",
            type: "POST",
            dataType: "json",
            data: {
                "id": id_sub
            },
            beforeSend: function () {
                //$("#loader").show();
            },
            success: function (data) {
                //$("#loader").hide();
                if (!data) {

                } else {
                    show_SubCaracteristicas(data, id_sub);
                }
            },
            error: function (response) {
                //$("#loader").hide();
            }
        });
    }

    function show_SubCaracteristicas(data, id_data) {
        var html = "";
        html += '<p><strong>SubCaracteristicas</strong></p>'
        for (var i = 0; i < data.length; i++) {
            //alert(data[i].nombre);
            html += '<p id="txt_sub" onclick=""><i class="fa fa-thumb-tack"></i> ' + data[i].nombre;
            html += '<div id="info_pregunta' + data[i].id_sub + '" class="info_pregunta"></div>';
            html += '</p>';
            preguntas_sub(data[i].id_sub, id_data);
        }
        $("#sub_caract" + id_data).html(html);

        ///panel respuestas

        panel= "";
        panel += '<div class="info_respuesta">';
        panel += '<p><strong>Respuesta</strong><textarea class="form-control" rows="8" id="txt_respuesta' + id_data + '"></textarea></p>';
        
        <?php if ($this->session->userdata('tipo')==1 || $this->session->userdata('tipo')==2) {
            echo " puedeResponder();";
        }
        ?>
        
        panel += '<button style="margin-left:2%;" type="button" class="btn btn-danger btn-sm" onclick="cancelar_respuesta()">Cancelar</button>';
        panel += '</div>';

        $("#panel_respuesta" + id_data).html(panel);

    }
    function puedeResponder(){
       panel += '<button style="" type="button" class="btn btn-primary btn-sm" onclick="guardar_respuesta()">Guardar</button>'; 
    }
    
    function preguntas_sub(id_sub, id_panel) {
        $.ajax({
            url: "<?php echo base_url(); ?>DefinirRNFController/listarPreguntas_SubCaracteristicas",
            type: "POST",
            dataType: "json",
            data: {
                "id": id_sub,
                "id_proc": id_proceso
            },
            beforeSend: function () {
                //$("#loader").show();
            },
            success: function (data) {
                //$("#loader").hide();
                if (!data) {

                } else {
                    show_preguntas(data, id_sub, id_panel);
                }
            },
            error: function (response) {
                //$("#loader").hide();
            }
        });
    }

    function show_preguntas(data, id_data, id_panel) {

        var html = "";
        for (var i = 0; i < data.length; i++) {

            html += '<p id="txt_pregunta' + data[i].id + '" class="txt_pregunta">' + (i + 1) + '. ' + data[i].nombre + ' ?</p>';
            var btn_response = "<a class='btn_response' href='#' onclick='select_respuesta(" + data[i].id + "," + id_panel + ")'>Respuesta...</a>";
            if (data[i].check == 1) {
                html += '<p><i class="fa fa-check" style="color:green;"></i>' + btn_response + '</p>';
            } else {
                html += '<p>' + btn_response + '</p>';
            }

        }
        $("#info_pregunta" + id_data).html(html);
    }

    function select_respuesta(id_pregunta, id_panel) {
        id_txt_respuesta = id_panel;
        $("#txt_respuesta" + id_panel).val("");
        $(".txt_pregunta").css("color", "#2C2C2C");
        $("#txt_pregunta" + id_pregunta).css("color", "blue");
        IDPREGUNTA = id_pregunta;
        $(".panel_respuesta").show();
        $.ajax({
            url: "<?php echo base_url(); ?>DefinirRNFController/verRespuesta",
            type: "POST",
            dataType: "json",
            data: {
                "id_preg": id_pregunta,
                "id_proc": id_proceso
            },
            beforeSend: function () {
                //$("#loader").show();
            },
            success: function (data) {
                //$("#loader").hide();
                if (!data) {
                    $("#txt_respuesta" + id_panel).val("");
                } else {
                    $("#txt_respuesta" + id_panel).val(data.descripcion);

                }
            },
            error: function (response) {
                //$("#loader").hide();
            }
        });
    }

    function guardar_respuesta() {
        if ($("#txt_respuesta" + id_txt_respuesta).val() == "") {

        } else {
            $.ajax({
                url: "<?php echo base_url(); ?>DefinirRNFController/guardarRespuesta",
                type: "POST",
                dataType: "json",
                data: {
                    "id_preg": IDPREGUNTA,
                    "id_proc": id_proceso,
                    "descrip": $("#txt_respuesta" + id_txt_respuesta).val()
                },
                beforeSend: function () {
                    //$("#loader").show();
                },
                success: function (data) {
                    //$("#loader").hide();
                    if (!data) {

                    } else {
                        $.alert({
                            type: 'green',
                            icon: 'glyphicon glyphicon-ok',
                            title: 'Ok!',
                            content: '<p>Respuesta guardada</p>',
                        });
                    }
                },
                error: function (response) {
                    //$("#loader").hide();
                }
            });
        }
    }

    function cancelar_respuesta() {
        $("#txt_respuesta").val("");
        $(".txt_respuesta").css("color", "#2C2C2C");
        $(".panel_respuesta").hide();
    }
</script>
