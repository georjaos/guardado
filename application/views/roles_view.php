<?php $this->load->view('head/headers'); ?>
<?php $this->load->view('head/nav'); ?>

<meta charset="utf-8">
<!--hoja de estilos para los roles.-->
<link rel="stylesheet" href="assets/css/style_roles.css">
<!--archivo .js donde hace los llamados al controlador y las validaciones-->
<script src="assets/js/roles.js"></script>

<div id="rol">
    
    <?php if ($this->session->userdata('tipo')!=3) { 
        echo '<h2>GESTIÓN DE ROLES</h2>';
        echo '<button type="button" class="btn btn-primary" id="btnAdd" onclick="nuevoRol();"><span class="glyphicon glyphicon-plus"></span> Nuevo Rol</button>';
        } 
        else{ 
            echo '<h2>ROLES</h2>';
        }
    ?>
    <!-- tabla donde se muestran todos los registros que se traen de la base de datos por medio del controlador-->
    <table id="tablaRol" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>                
                <th>Encargado</th>
                <th>Acción</th>

            </tr>
        </thead>
        <tfoot>
            <tr>              
                <th>Nombre</th>
                <th>Descripción</th>                
                <th>Encargado</th>
                <th>Acción</th>
            </tr>
        </tfoot>
        <tbody>

        </tbody>
    </table>


    <!-- Ventana Modal para registrar la informacion de una Rol-->

    <div class="modal fade" id="modalRegistroRol" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="padding:35px 50px;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4><span class="glyphicon glyphicon-plus"></span> Registro de Roles</h4>
                </div>
                <div class="modal-body" style="padding:40px 50px;">
                    <form role="form">
                        <div class="form-group">
                            <label for="usrname"><span class="glyphicon glyphicon-comment"></span> Nombre del Rol</label><span id="require">*</span><span id="error"></span>
                            <input type="text" class="form-control" id="rol_name" placeholder="Nombre del Rol">
                        </div>
                        <div class="form-group">
                            <label for="descripcion"><span class="glyphicon glyphicon-sort-by-order"></span> Descripción del Rol</label><span id="require">*</span><span id="error"></span>
                            <textarea placeholder="Descripción"  class="form-control" id ="descripcion" ></textarea> 
                        </div>
                        <div class="form-group">
                            <label for="encargado"><span class="glyphicon glyphicon-flag"></span> Encargado</label><span id="require">*</span><span id="error"></span>
                            <input type="text" class="form-control" id="encargado" placeholder="Encargado">
                        </div>


<!--button type="submit" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-ok"></span> Registrar</button-->
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                    <button type="submit" class="btn btn-primary btn-default pull-rigth" onclick="registrarRol();" id="add_rol"><span class="glyphicon glyphicon-ok"></span> Aceptar</button>
                    
                </div>
            </div>

        </div>
    </div>
    
    
    
    <!-- Ventana Modal para mostar datos de relacionados de un rol-->
    <div class="modal fade" id="modalVerRol" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="padding:35px 50px;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4><span class="glyphicon glyphicon-plus"></span> Infomación de roles</h4>
                </div>
                <div class="modal-body" style="padding:40px 50px;">
                    <form role="form">
                        <div class="form-group">
                            <label for="usrname"><span class="glyphicon glyphicon-comment"></span> Nombre del Rol</label>
                            <input type="text" class="form-control" id="rol_name_view" placeholder="Nombre del Rol" readonly="readonly">
                        </div>
                        <div class="form-group">
                            <label for="descripcion"><span class="glyphicon glyphicon-flag"></span> Area del proceso</label>
                            <input type="text" class="form-control" id="descripcion_view" placeholder="Descripcion" readonly="readonly">
                        </div>

                        <div class="form-group">
                            <label for="encargado"><span class="glyphicon glyphicon-user"></span> Encargado del Rol</label>
                            <input type="text" class="form-control" id="encargado_view" placeholder="Encargado" readonly="readonly">
                        </div>

<!--button type="submit" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-ok"></span> Registrar</button-->
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                   <!-- <button type="submit" class="btn btn-primary btn-default pull-rigth" onclick="ActualizarP();" data-dismiss="modal"><span class="glyphicon glyphicon-ok"></span> Actualizar</button>-->

                </div>
            </div>

        </div>
    </div> 
    
    <!-- Ventana Modal para actualizar la informacion de un rol-->
    <div class="modal fade" id="modalActualizarRol" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="padding:35px 50px;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4><span class="glyphicon glyphicon-plus"></span> Actualización de roles</h4>
                </div>
                <div class="modal-body" style="padding:40px 50px;">
                    <form role="form">
                        <div class="form-group">
                            <label for="usrname"><span class="glyphicon glyphicon-comment"></span> Nombre del Rol</label>
                            <input type="text" class="form-control" id="rol_name_edit" placeholder="Nombre del Rol">
                        </div>
                        <div class="form-group">
                            <label for="descripcion"><span class="glyphicon glyphicon-flag"></span> Descripcion del Rol</label>
                            <input type="text" class="form-control" id="descripcion_edit" placeholder="Descripcion">
                        </div>

                        <div class="form-group">
                            <label for="encargado"><span class="glyphicon glyphicon-user"></span> Encargado del Rol</label>
                            <input type="text" class="form-control" id="encargado_edit" placeholder="Encargado">
                        </div>

<!--button type="submit" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-ok"></span> Registrar</button-->
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                    <button type="submit" class="btn btn-primary btn-default pull-rigth" onclick="ActualizarR();" data-dismiss="modal"><span class="glyphicon glyphicon-ok"></span> Actualizar</button>

                </div>
            </div>

        </div>
    </div> 
    
</div>

