<?php $this->load->view('head/headers'); ?>
<?php $this->load->view('head/nav'); ?>

<meta charset="utf-8">
<script src="assets/js/interface.js"></script>
<link rel="stylesheet" href="assets/css/style_interfaces.css">


<div id="interfaces">
    <h2 style="margin-bottom: 40px;">GESTIÓN DE INTERFACES</h2>
   
    <table id="tablaInterface" class="table table-striped table-bordered">
        <thead>
            <tr>             
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Tipo</th>
                <th>Detalle Tipo</th>
                <th>Proceso Relacionado</th>
                <th>Accion </th>
            </tr>
        </thead>
        <tfoot>
            <tr>              
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Tipo</th>
                <th>Detalle Tipo</th>
                <th>Proceso Relacionado</th>
                <th>Accion </th>
            </tr>
        </tfoot>
        <tbody>

        </tbody>
    </table>


<!--Modal "Ver informacion de la interfaz" -->
  <div class="modal fade" id="modalVerInterfaz" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="padding:35px 50px;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4><span class="glyphicon glyphicon-plus"></span> Infomación de Interfaces</h4>
                </div>
                <div class="modal-body" style="padding:40px 50px;">
                    <form role="form">
                        <div class="form-group">
                            <label for="usrname"><span class="glyphicon glyphicon-comment"></span> Nombre Interfaz</label>
                            <input type="text" class="form-control" id="interfaz_name_view" placeholder="" readonly="readonly">
                        </div>
                        <div class="form-group">
                            <label for="descripcion"><span class="glyphicon glyphicon-flag"></span> Descripción</label>
                            <input type="text" class="form-control" id="descripcion_view" placeholder="" readonly="readonly">
                        </div>

                        <div class="form-group">
                            <label for="encargado"><span class="glyphicon glyphicon-user"></span> Tipo </label>
                            <input type="text" class="form-control" id="tipo_view" placeholder="" readonly="readonly">
                        </div>

                        <div class="form-group">
                            <label for="encargado"><span class="glyphicon glyphicon-user"></span> Detalle Tipo </label>
                            <input type="text" class="form-control" id="detalle_view" placeholder="" readonly="readonly">
                        </div>

                        <div class="form-group">
                            <label for="encargado"><span class="glyphicon glyphicon-user"></span> Proceso </label>
                            <input type="text" class="form-control" id="proceso_view" placeholder="" readonly="readonly">
                        </div>

                        <div class="form-group">
                            <label for="encargado"><span class="glyphicon glyphicon-user"></span> Descripción Proceso </label>
                            <input type="text" class="form-control" id="descripcionp_view" placeholder="" readonly="readonly">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>                   
                </div>
            </div>
        </div>
    </div> 



<!-- Modal ACTUALIZAR INTERFAZ-->
    <div class="modal fade" id="modalActualizarInterfaz" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="padding:35px 50px;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4><span class="glyphicon glyphicon-plus"></span> Actualización de Interfaces</h4>
                </div>
                <div class="modal-body" style="padding:40px 50px;">
                    <form role="form">
                        <div class="form-group">
                            <label for="usrname"><span class="glyphicon glyphicon-comment"></span> Nombre Interfaz</label>
                            <input type="text" class="form-control" id="interfaz_name_edit" placeholder="Nombre de la Interfaz">
                        </div>
                        <div class="form-group">
                            <label for="descripcion"><span class="glyphicon glyphicon-flag"></span> Descripción </label>
                            <input type="text" class="form-control" id="descripcion_edit" placeholder="Descripcion">
                        </div>

                        <div class="form-group">
                            <label for="prioridad"><span class="glyphicon glyphicon-triangle-top"></span> Tipo</label><span id="require">*</span><span id="error"></span>
                            <!--<input type="text" class="form-control" id="prioridad" placeholder="prioridad">-->
                            <select id="tipo_edit" class="form-control">
                                <option value="0">Seleccione...</option>
                                <option value="1">Automática</option>
                                <option value="2">Semiautomática</option>
                                <option value="3">Manual</option>
                            </select> 
                        </div>

                        <div class="form-group">
                            <label for="encargado"><span class="glyphicon glyphicon-user"></span> Detalle Tipo</label>
                            <input type="text" class="form-control" id="detalleTipo_edit" placeholder="Detalle Tipo">
                        </div>

                        <div id="proceso_edit">
                            <label for="encargado"><span class="glyphicon glyphicon-user"></span> Nombre del Proceso</label>
                             <select id="pro_edit_value" class="form-control">
                                <option value="0">Seleccione...</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                    <button type="button" class="btn btn-primary btn-default pull-rigth" onclick="actualizarInt()" data-dismiss="modal"><span class="glyphicon glyphicon-ok"></span> Actualizar</button>
                </div>
            </div>
        </div>
    </div> 

</div>