<?php $this->load->view('head/headers'); ?>
<?php $this->load->view('head/nav'); ?>

<meta charset="utf-8">

<!--hoja de estilos para los procesos.-->
<link rel="stylesheet" href="assets/css/style_procesos.css">
<!--archivo .js donde hace los llamados al controlador y las validaciones-->
<script src="assets/js/procesos.js"></script>
<script src="assets/js/interface.js"></script>
<script src="assets/js/normativa.js"></script>



<div id="procesos" style="width: 100%; padding: 1%;">

    <!--codigo php que dependiendo del rol del usuario, muestra los botones de agregar proceso y secuenciarlos-->
    <?php
    if ($this->session->userdata('tipo') != 3) {
        echo ' <h2 style="margin-bottom: 20px;">GESTIÓN DE PROCESOS</h2>';
        echo ' <div id="btns_accion style="margin-bottom: 50px;">
                    <button type="button" class="btn btn-primary" id="btnAddOProceso" onclick="nuevoProceso();"><span class="glyphicon glyphicon-plus"></span> Nuevo Proceso</button>  
                    <button type="button"  class="btn btn-info" id="btnSecuencia" onclick="secuencia();"><span class="glyphicon glyphicon-th-list"></span><span class="glyphicon glyphicon-sort"></span> Secuencia de procesos</button>
                </div>';
    } else {
        echo '<h2 style="margin-bottom: 20px;">PROCESOS</h2>';
    }
    ?>

    <!--tabla donde se muestra la informacion de los procesos, la cual permite buscarlos y filtrarlos por cada columna-->
    <div style="overflow-x: auto;">
        <table id="tablaProcesos" class="table table-striped table-bordered">
            <thead>
                <!--titulo de la tabla-->
                <tr>  
                    <th>Secuencia</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Prioridad</th>

                    <th>Rol</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Secuencia</th>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>Prioridad</th>

                    <th>Rol</th>
                    <th>Accion</th>
                </tr>
            </tfoot>
            <!--cuerpo de la tabla-->
            <tbody>

            </tbody>
        </table>
    </div>

    <!-- Modal en la que registramos los datos de los procesos-->
    <div class="modal fade" id="modalRegistroProcesos" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="padding:10px 10px;" id="superiorNuevoProceso">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4><span class="glyphicon glyphicon-plus"></span> Registro de procesos</h4>
                </div>
                <div class="modal-body" style="padding:20px 40px;">
                    <form role="form">
                        <div class="form-group">
                            <label for="usrname"><span class="glyphicon glyphicon-comment"></span> Nombre del proceso</label><span id="require">*</span><span id="error"></span>
                            <input type="text" class="form-control" id="proceso_name" placeholder="Nombre del proceso">
                        </div>
                        <div class="form-group">
                            <label for="prioridad"><span class="glyphicon glyphicon-triangle-top"></span> Prioridad del proceso</label><span id="require">*</span><span id="error"></span>
                            <!--<input type="text" class="form-control" id="prioridad" placeholder="prioridad">-->
                            <select id="prioridad" class="form-control">
                                <option value="0">Seleccione...</option>
                                <option value="1">Alta</option>
                                <option value="2">Media</option>
                                <option value="3">Baja</option>
                            </select> 
                        </div>
                        <div class="form-group">
                            <label for="secuencia"><span class="glyphicon glyphicon-sort-by-order"></span> Secuencia del proceso</label><span id="require">*</span><span id="error"></span>
                            <input type="number" class="form-control" id="secuencia" value="0" min="1">
                        </div>
                        <div class="form-group">
                            <label for="descripcion"><span class="glyphicon glyphicon-flag"></span> Descripción del proceso</label><span id="require">*</span><span id="error"></span>
                            <textarea placeholder="Descripción"  class="form-control " id ="descrip" ></textarea> 
                        </div>

                        <div class="form-group" id="modalprueba">
                            <label for="prioridad"><span class="glyphicon glyphicon-user " id ="iconoRol"></span> Seleccionar Rol</label><span id="require">*</span><span id="error"></span>
                            <!--<input type="text" class="form-control" id="encargado" placeholder="Encargado">-->
                            <div id="roles">
                                <select id="rol" class="form-control">
                                    <option value="0">Seleccione...</option>
                                </select>
                            </div>
                            <br>

                            <!--boton que invoca a una funcion procesos.js la cual crea un nuevo rol del proceso-->
                            <button type="button" class="btn btn-default btn-sm" id="new_role" onclick="nuevoRol()"><span class="glyphicon glyphicon-th-list"></span><span class="glyphicon glyphicon-user"></span> Nuevo Rol</button>


                        </div>
                    </form>
                </div>
                <div class="modal-footer" id="inferiorNuevoProceso">
                    <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                    <!--boton que invoca a una funcion proceso.js la cual crea un nuevo proceso-->
                    <button type="submit" class="btn btn-primary btn-default pull-rigth" onclick="registrarProceso();" id="add_proceso"><span class="glyphicon glyphicon-ok"></span> Aceptar</button>

                </div>
            </div>

        </div>
    </div> 

    <!-- Modal en la cual agregamos datos de la normativa normativa-->
    <div class="modal fade" id="modalAgragarNormativa" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="padding:10px 10px;" id="superiorNuevaNormativa">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4><span class="glyphicon glyphicon-plus"></span> Agregar Normativa</h4>
                </div>
                <div class="modal-body" style="padding:20px 40px;">
                    <form role="form">
                        <input type="hidden" id="id_Proc"/>
                        <div class="form-group">
                            <label for="nameNorma"><span class="glyphicon glyphicon-comment"></span> Nombre normativa</label><span id="error">*</span>
                            <input type="text" class="form-control" id="norma_name" >
                        </div>

                        <div class="form-group">
                            <label for="descripcionNorma"><span class="glyphicon glyphicon-flag"></span> Descripción de la normativa</label><span id="require">*</span><span id="error"></span>
                            <textarea class="form-control " id ="descripNorma" ></textarea> 
                        </div>
                    </form>
                </div>
                <div class="modal-footer" id="inferiorNuevaNorma">
                    <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                    <!--boton que invoca a una funcion en el archivo normativa.js la cual creamos una nueva normativa-->
                    <button type="submit" class="btn btn-primary btn-default pull-rigth"  id="add_normativa"><span class="glyphicon glyphicon-ok"></span> Aceptar</button>

                </div>
            </div>

        </div>
    </div> 


    <!-- Modal agregamos datos de Interfaz-->
    <div class="modal fade" id="modalAgregarInterfaz" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="padding:10px 10px;" id="superiorNuevaInter">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4><span class="glyphicon glyphicon-plus glyphicon glyphicon-random"></span> Agregar interfaz</h4>
                </div>
                <div class="modal-body" style="padding:20px 40px;">
                    <form role="form">
                        <input type="hidden" id="id_Proc"/>
                        <div class="form-group">
                            <label for="nameInterfaz"><span class="glyphicon glyphicon-comment"></span> Nombre</label><span id="require">*</span><span id="errorI"></span>
                            <input type="text" class="form-control" id="interfaz_name" >
                        </div>

                        <div class="form-group">
                            <label for="descripcionInterfaz"><i class="material-icons" >description</i> Descripción </label><span id="errorI"></span>
                            <textarea class="form-control " id ="descripInterfaz" ></textarea> 
                        </div>

                        <div class="form-group">
                            <label for="tipo"><span class="glyphicon glyphicon-th-large"></span> Tipo</label><span id="require">*</span><span id="errorI"></span>
                            <!--<input type="text" class="form-control" id="prioridad" placeholder="prioridad">-->
                            <div id="tipo_interfaz">
                                <select id="tipoInterfaz_add" class="form-control">
                                    <option value="0">Seleccione...</option>
                                </select> 
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="detInterfaz"><span class="glyphicon glyphicon-flag"></span> Detalle del tipo </label><span id="errorI"></span>
                            <textarea class="form-control " id ="descripTipoInterfaz" ></textarea> 
                        </div>
                    </form>
                </div>
                <div class="modal-footer" id="inferiorNuevaInterfaz">
                    <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                    <!--boton que invoca a una funcion en el archivo interfaz.js la cual creamos una nueva interfaz-->
                    <button type="submit" class="btn btn-primary btn-default pull-rigth"  id="add_interfaz" onclick="add_interfaz()"><span class="glyphicon glyphicon-ok"></span> Aceptar</button>

                </div>
            </div>

        </div>
    </div> 

    <!-- Modal en la cual actualizamos los datos del proceso-->
    <div class="modal fade" id="modalActualizarProcesos" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="padding:10px 10px;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4><span class="glyphicon glyphicon-pencil"></span> Actualización de procesos</h4>
                </div>
                <div class="modal-body" style="padding:20px 40px;">
                    <form role="form">
                        <div class="form-group">
                            <label for="usrname"><span class="glyphicon glyphicon-comment"></span> Nombre del proceso</label>
                            <input type="text" class="form-control" id="proceso_name_edit" placeholder="Nombre del proceso">
                        </div>

                        <div class="form-group">
                            <label for="prioridad"><span class="glyphicon glyphicon-triangle-top"></span> Prioridad del proceso</label><span id="require">*</span><span id="error"></span>
                            <!--<input type="text" class="form-control" id="prioridad" placeholder="prioridad">-->
                            <select id="prioridad_edit" class="form-control">
                                <option value="0">Seleccione...</option>
                                <option value="1">Alta</option>
                                <option value="2">Media</option>
                                <option value="3">Baja</option>
                            </select> 
                        </div>

                        <div class="form-group">
                            <label for="prioridad"><span class="glyphicon glyphicon-sort-by-order"></span> Descripcion del proceso</label>                          
                            <textarea placeholder="Descripción"  class="form-control " id ="descrip_edit" ></textarea> 
                        </div>

                        <div id="roles_edit">
                            <select id="rol_edit" class="form-control">
                                <option value="0">Seleccione...</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                    <!--boton que invoca a una funcion en el archivo procesos.js la cual editamos los datos de un proceso-->
                    <button type="button" class="btn btn-primary btn-default pull-rigth" onclick="actualizar();"><span class="glyphicon glyphicon-ok"></span> Actualizar</button>

                </div>
            </div>

        </div>
    </div> 

    <!-- Modal en la cual mostramos los datos de un proceso-->
    <div class="modal fade" id="modalVerProceso" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="padding:10px 10px;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4><span class="glyphicon glyphicon-search"></span> Información de procesos</h4>
                </div>
                <div class="modal-body" style="padding:20px 40px;">
                    <form role="form">
                        <div id="preguntas_respuestas"></div>
                        <div class="form-group">
                            <label for="usrname"><span class="glyphicon glyphicon-comment"></span> Nombre del proceso</label>
                            <input type="text" class="form-control" id="proceso_name_view" placeholder="Nombre del proceso">
                        </div>

                        <div class="form-group">
                            <label for="prioridad"><span class="glyphicon glyphicon-sort-by-order"></span> Prioridad del proceso</label>
                            <input type="text" class="form-control" id="prioridad_view" placeholder="prioridad">
                        </div>

                        <div class="form-group">
                            <label for="prioridad"><span class="glyphicon glyphicon-flag"></span> Secuencia del proceso</label>
                            <input type="text" class="form-control" id="secuencia_view" placeholder="1">
                        </div>

                        <div class="form-group">
                            <label for="prioridad"><span class="glyphicon glyphicon-sort-by-order"></span> Descripcion del proceso</label>
                            <textarea placeholder="Descripción"  class="form-control " id ="descrip_view" ></textarea> 
                        </div>

                        <div class="form-group">
                            <label for="prioridad"><span class="glyphicon glyphicon-user"></span> Rol del proceso</label>
                            <input type="text" class="form-control" id="rol_view" placeholder="Rol">
                        </div>



                        <div id="tbl_interfaz" style="margin-top: 30px;">

                        </div>

                        <div id="info_norma">

                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>                   

                </div>
            </div>

        </div>
    </div> 

    <!--Modal en la que registramos los datos de un nuevo rol-->

    <div class="modal fade" id="modalRegistroRol" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="padding:10px 10px;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4><span class="glyphicon glyphicon-plus"></span> Registro de Roles</h4>
                </div>
                <div class="modal-body" style="padding:20px 40px;">
                    <form role="form">
                        <div class="form-group">
                            <label for="usrname"><span class="glyphicon glyphicon-comment"></span> Nombre del Rol</label><span id="require">*</span><span id="error"></span>
                            <input type="text" class="form-control" id="rol_name" placeholder="Nombre del Rol">
                        </div>
                        <div class="form-group">
                            <label for="descripcion"><span class="glyphicon glyphicon-sort-by-order"></span> Descripción del Rol</label><span id="require">*</span><span id="error"></span>
                            <textarea placeholder="Descripción"  class="form-control" id ="descripcion_role" ></textarea> 
                        </div>
                        <div class="form-group">
                            <label for="encargado"><span class="glyphicon glyphicon-flag"></span> Encargado</label><span id="require">*</span><span id="error"></span>
                            <input type="text" class="form-control" id="encargado_role" placeholder="Encargado">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-default pull-left" onclick="cancelar_reg_rol();"><span class="glyphicon glyphicon-arrow-left"></span> Volver a procesos</button>
                    <!--boton que invoca a una funcion en el archivo procesos.js la cual agregamos los datos de un rol-->
                    <button type="button" class="btn btn-primary btn-default pull-rigth" onclick="registrarRol();" id="add_rol"><span class="glyphicon glyphicon-ok"></span> Aceptar</button>

                </div>
            </div>

        </div>
    </div>

</div>  

<script>
    
    /*
     * funcion a la cual nos permite ir a la vista de ver los requisitos no funcionales, pasando como parametro 
     * en la url el identificador del proceso
     */
    function ir_rnf(id_proceso) {
        window.location.href = "<?php echo base_url(); ?>DefinirRNFController/load_rnf_proceso/" + id_proceso;
    }
</script>
