<?php $this->load->view('head/headers'); ?>
<?php $this->load->view('head/nav'); ?>

<link rel="stylesheet" href="assets/css/style_caracteristicas.css">
<script src="assets/js/caracteristicas.js"></script>
<script src="assets/js/preguntas.js"></script>
<script src="assets/js/subcaracteristica.js"></script>
<meta charset="utf-8">


    



<div id="info_caracteristica">
    <h2 style="text-align: center; margin-top: 50px;">REQUISITOS NO FUNCIONALES</h2>
 <?php if ($this->session->userdata('tipo')==3 || $this->session->userdata('tipo')==2) {
            echo '<div id="btns_accion">
                    
                    <button type="button" class="btn btn-default" id="btnSubcaracteristicas" onclick="subcaracteristicas();"> <i class="fa fa-sitemap"></i> SubCaracteristicas</button>
                    <button type="button" class="btn btn-danger" id="btnPreguntas" onclick="preguntas();"> <i class="fa fa-question-circle"></i> Preguntas</button>
                 </div>';
       }
       else{
           echo '<div id="btns_accion">
                    <button type="button" class="btn btn-primary" id="btnCaracteristica" onclick="nuevaCaracteristica();"><span class="glyphicon glyphicon-plus"></span> Nueva Caracteristica</button>
                    <button type="button" class="btn btn-default" id="btnSubcaracteristicas" onclick="subcaracteristicas();"> <i class="fa fa-sitemap"></i> SubCaracteristicas</button>
                    <button type="button" class="btn btn-danger" id="btnPreguntas" onclick="preguntas();"> <i class="fa fa-question-circle"></i> Preguntas</button>
                 </div>';
       }
        
    ?>
    

    <table id="tabla_caracteristica" class="table table-striped table-bordered">
        <thead>
            <tr>             
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Accion </th>
            </tr>
        </thead>
        <tfoot>
            <tr>              
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Accion </th>
            </tr>
        </tfoot>
        <tbody>

        </tbody>
    </table>
</div>

<!--Modal NUEVA CARACTERISTICA -->
<div class="modal fade" id="addCaracteristica" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="padding:10px 20px;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4><span class="glyphicon glyphicon-plus"></span> Nueva Caracteristica</h4>
            </div>
            <div class="modal-body" style="padding:10px 20px;">
                <form role="form">
                    <div class="form-group">
                        <label for="usrname"><span class=""></span> Nombre Caracteristica</label><span id="require">*</span>
                        <input type="text" class="form-control" id="name_caracteristica" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="descripcion"><span class=""></span> Descripción Caracteristica</label><span id="require">*</span>   
                        <textarea placeholder=""  class="form-control " id ="descrip_caracteristica"rows='5'></textarea> 
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>                   
                <button type="submit" class="btn btn-primary btn-default pull-right" onclick="guardarCaracteristica()"><span class="glyphicon glyphicon-ok"></span> Registrar</button>
            </div>
        </div>
    </div>
</div> 

<!--Modal EDITAR CARACTERISTICA -->
<div class="modal fade" id="caracteristica_edit" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="padding:10px 20px;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4><span class="glyphicon glyphicon-pencil"></span> Actualizar Caracteristica</h4>
            </div>
            <div class="modal-body" style="padding:10px 20px;">
                <form role="form">
                    <div class="form-group">
                        <label for="usrname"><span class=""></span> Nombre Caracteristica</label><span id="require">*</span>
                        <input type="text" class="form-control" id="name_caracteristica_edit" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="descripcion"><span class=""></span> Descripción Caracteristica</label><span id="require">*</span>   
                        <textarea placeholder=""  class="form-control " id ="descrip_caracteristica_edit"rows='5'></textarea> 
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cerrar</button>                   
                <button type="submit" class="btn btn-primary btn-default pull-right" onclick="actualizarCaracteristica()"><span class="glyphicon glyphicon-ok"></span> Actualizar</button>
            </div>
        </div>
    </div>
</div> 


<!--Modal VER CARACTERISTICA -->
<div class="modal fade" id="caracteristica_view" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="padding:10px 20px;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4><span class="glyphicon glyphicon-plus"></span> Informacion de la Caracteristica</h4>
            </div>
            <div class="modal-body" style="padding:10px 20px;">
                <form role="form">
                    <div class="form-group">
                        <label for="usrname"><span class=""></span> Nombre Caracteristica</label><span id="require">*</span>
                        <input type="text" class="form-control" id="name_caracteristica_view" placeholder="" readonly="readonly">
                    </div>
                    <div class="form-group">
                        <label for="descripcion"><span class=""></span> Descripción Caracteristica</label><span id="require">*</span>   
                        <textarea placeholder=""  class="form-control " id ="descrip_caracteristica_view"rows='5' readonly="readonly"></textarea> 
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cerrar</button>                   
            </div>
        </div>
    </div>

</div> 

<!--Modal Registrar pregunta-->

<div class="modal fade" id="modalAgregarPregunta" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="padding:10px 20px;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4><span class="glyphicon glyphicon-plus"></span> Agregar Pregunta</h4>
            </div>
            <div class="modal-body" style="padding:40px 50px;">
                <form role="form">
                    <div class="form-group">
                        <label for="usrname"><span class="glyphicon glyphicon-comment"></span> Pregunta</label><span id="require">*</span><span id="error"></span>
                        <input type="text" class="form-control" id="pregunta_name" placeholder="Escriba su pregunta...">
                    </div>
                    <label for="sub_caract">Seleccione una subcaracteristica</label><span id="require">*</span><span id="error"></span>
                    <div id="sub_caracteristicas_lst">
                        <select id="sub_caract" class="form-control">
                            <option value="0">Seleccione...</option>
                        </select>
                    </div>

<!--button type="submit" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-ok"></span> Registrar</button-->
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                <button type="submit" class="btn btn-primary btn-default pull-rigth" onclick="add_pregunta();" ><span class="glyphicon glyphicon-ok"></span> Aceptar</button>

            </div>
        </div>

    </div>
</div>


<!--Modal para registrar una subcaracteristica-->

<div class="modal fade" id="modalRegistroSubcaract" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="padding:35px 50px;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4><span class="glyphicon glyphicon-plus"></span> Registro de Subcaracteristicas</h4>
            </div>
            <div class="modal-body" style="padding:40px 50px;">
                <form role="form">
                    <div class="form-group">
                        <label for="usrname"><span class="glyphicon glyphicon-comment"></span> Nombre</label><span id="require">*</span><span id="error"></span>
                        <input type="text" class="form-control" id="subcaract_name" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="descripcion"><span class="glyphicon glyphicon-sort-by-order"></span> Descripción</label><span id="require">*</span><span id="error"></span>
                        <textarea placeholder="Descripción "  class="form-control" id ="subcaract_descrip" ></textarea> 
                    </div>
                    <div class="form-group">
                        <label for="encargado"><span class="glyphicon glyphicon-flag"></span>Caracteristica Relacionada</label><span id="require">*</span><span id="error"></span>
                        <div id="caracteristica">
                            <select id="caract_relation" class="form-control">
                                <option value="0">Seleccione...</option>                                
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                <button type="submit" class="btn btn-primary btn-default pull-rigth" onclick = "register_Subcaracteristica();" id="add_subcaract"><span class="glyphicon glyphicon-ok"></span> Registrar </button>                    
            </div>
        </div>
    </div>
</div>