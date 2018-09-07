<?php $this->load->view('head/headers'); ?>
<?php $this->load->view('head/nav'); ?>

<meta charset="utf-8">
<script src="assets/js/normativa.js"></script>
<link rel="stylesheet" href="assets/css/style_normativa.css">


<div id="normativas">
    <h2 style="margin-bottom: 40px; text-align: center;">NORMATIVAS DE LOS PROCESOS</h2>
    
    <!--tabla para mostrar la informacion de las normativas-->
    <table id="tablaNormativa" class="table table-striped table-bordered">
        <thead>
            <tr>             
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Proceso</th>
                <th>Accion </th>
            </tr>
        </thead>
        <tfoot>
            <tr>              
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Proceso Relacionado</th>
                <th>Acción </th>
            </tr>
        </tfoot>
        <tbody>

        </tbody>
    </table>
</div>


<!--Modal "Ver informacion de normativa" -->
  <div class="modal fade" id="modalVerNormativa" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="padding:35px 50px;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4><span class="glyphicon glyphicon-plus"></span> Infomación de la Normativa</h4>
                </div>
                <div class="modal-body" style="padding:40px 50px;">
                    <form role="form">
                        <div class="form-group">
                            <label for="nombre"><span class="glyphicon glyphicon-comment"></span> Nombre Normativa</label>
                            <input type="text" class="form-control" id="norma_name_view" placeholder="" readonly="readonly">
                        </div>
                        <div class="form-group">
                            <label for="descripcion"><span class="glyphicon glyphicon-flag"></span> Descripción</label>
                            <input type="text" class="form-control" id="norma_descripcion_view" placeholder="" readonly="readonly">
                        </div>                                              

                        <div class="form-group">
                            <label for="proceso"><span class="glyphicon glyphicon-user"></span> Proceso </label>
                            <input type="text" class="form-control" id="norma_proceso_view" placeholder="" readonly="readonly">
                        </div>

                        <div class="form-group">
                            <label for="proceso"><span class="glyphicon glyphicon-user"></span> Descripción Proceso </label>
                            <input type="text" class="form-control" id="norma_descripcionp_view" placeholder="" readonly="readonly">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>                   
                </div>
            </div>
        </div>
    </div> 



<!--Modal "Actualizar informacion de normativa" -->
    <div class="modal fade" id="modalActualizarNormativa" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="padding:35px 50px;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4><span class="glyphicon glyphicon-plus"></span> Actualizar Normativa</h4>
                </div>
                <div class="modal-body" style="padding:40px 50px;">
                    <form role="form">
                        <div class="form-group">
                            <label for="name"><span class="glyphicon glyphicon-comment"></span> Nombre Normativa</label>
                            <input type="text" class="form-control" id="norma_name_edit" placeholder="Nombre de la Interfaz">
                        </div>
                        <div class="form-group">
                            <label for="descripcion"><span class="glyphicon glyphicon-flag"></span> Descripción </label>
                            <input type="text" class="form-control" id="norma_descripcion_edit" placeholder="Descripcion">
                        </div>

                        <div id="norma_proceso_edit">
                            <label for="encargado"><span class="glyphicon glyphicon-user"></span> Nombre del Proceso</label>
                             <select id="norma_pro_edit_value" class="form-control">
                                <option value="0">Seleccione...</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                    <button type="button" class="btn btn-primary btn-default pull-rigth" onclick="actualizarNormativa()" ><span class="glyphicon glyphicon-ok"></span> Actualizar</button>
                </div>
            </div>
        </div>
    </div> 

</div>
