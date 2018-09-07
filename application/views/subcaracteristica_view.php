<?php $this->load->view('head/headers'); ?>
<?php $this->load->view('head/nav'); ?>


<meta charset="utf-8">
<!--hoja de estilos para las subcaracteristicas-->
<link rel="stylesheet" href="assets/css/style_subcaracteristica.css">
<!--archivo .js donde hace los llamados al controlador y las validaciones-->
<script src="assets/js/subcaracteristica.js"></script>

<div id="subcaract">
    
    <h2>SUBCARACTERISTICAS</h2>
    <?php if ($this->session->userdata('tipo')==1) {
           echo '<button type="button" class="btn btn-primary" id="btnAdd" onclick="nuevaSubcaracteristica();"><span class="glyphicon glyphicon-plus"></span> Nueva Subcaracteristica</button>';
       }
       else{
           
       }
        
    ?>
    
    <!-- tabla donde se muestran todos los registros que se traen de la base de datos por medio del controlador-->
    <table id="tablaSubcaract" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>                
                <th>Caracteristica Relacionada</th>
                <th>Acción</th>

            </tr>
        </thead>
        <tfoot>
            <tr>              
                <th>Nombre</th>
                <th>Descripción</th>                
                <th>Caracteristica Relacionada</th>
                <th>Acción</th>
            </tr>
        </tfoot>
        <tbody>

        </tbody>
    </table>


    <!-- Ventana Modal para registrar la informacion de una subcaracteristica-->

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
                    <!-- boton que registra la informacion se hace mediante javascript mediante el metodo register_Subcaracteristica()-->      
                    <button type="submit" class="btn btn-primary btn-default pull-rigth" onclick = "register_Subcaracteristica();" id="add_subcaract"><span class="glyphicon glyphicon-ok"></span> Registrar </button>                    
                </div>
            </div>
        </div>
    </div>
    
    
    
    <!-- Ventana Modal para mostar datos de relacionados con la subcaracteristica-->
    <div class="modal fade" id="modalVerSubcaract" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="padding:35px 50px;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4><span class="glyphicon glyphicon-plus"></span> Infomación de la Subcaracteristica</h4>
                </div>
                <div class="modal-body" style="padding:40px 50px;">
                    <form role="form">
                        <div class="form-group">
                            <label for="usrname"><span class="glyphicon glyphicon-comment"></span> Nombre </label>
                            <input type="text" class="form-control" id="subcaract_name_view" readonly="readonly">
                        </div>
                        <div class="form-group">
                            <label for="descripcion"><span class="glyphicon glyphicon-flag"></span> Descripción</label>
                            <input type="text" class="form-control" id="subcaract_descrip_view" readonly="readonly">
                        </div>

                        <div class="form-group">
                            <label for="encargado"><span class="glyphicon glyphicon-user"></span> Caracteristica Relacionada</label>
                            <input type="text" class="form-control" id="caracteristica_view" readonly="readonly">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>                   
                </div>
            </div>
        </div>
    </div> 
    
    <!-- Ventana Modal para actualizar la informacion de las subcaracteristica-->
    <div class="modal fade" id="modalActualizarSubcaract" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="padding:35px 50px;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4><span class="glyphicon glyphicon-plus"></span> Actualización Subcaracteristica</h4>
                </div>
                <div class="modal-body" style="padding:40px 50px;">
                    <form role="form">
                        <div class="form-group">
                            <label for="usrname"><span class="glyphicon glyphicon-comment"></span> Nombre Subcaracteristica</label>
                            <input type="text" class="form-control" id="subcaract_name_edit" >
                        </div>
                        <div class="form-group">
                            <label for="descripcion"><span class="glyphicon glyphicon-flag"></span> Descripcion del Rol</label>
                            <input type="text" class="form-control" id="subcaract_descrip_edit">
                        </div>

                        <div class="form-group">
                            <label for="encargado"><span class="glyphicon glyphicon-user"></span> Caracteristica Relacionada</label>
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
                    <!-- boton que actualiza la informacion se hace mediante javascript mediante el metodo ActualizarSubcaract()-->      
                    <button type="submit" class="btn btn-primary btn-default pull-rigth" onclick="ActualizarSubcaract();" data-dismiss="modal"><span class="glyphicon glyphicon-ok"></span> Actualizar</button>
                </div>
            </div>
        </div>
    </div> 
</div>
