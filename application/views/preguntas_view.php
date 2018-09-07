<?php $this->load->view('head/headers'); ?>
<?php $this->load->view('head/nav'); ?>

<meta charset="utf-8">
<script src="assets/js/preguntas.js"></script>
<link rel="stylesheet" href="assets/css/style_preguntas.css">

<div id="preguntas">
    <h2 style="margin-bottom: 40px;">PREGUNTAS</h2>
   
   
    <table id="tablaPreguntas" class="table table-striped table-bordered">
        <thead>
            <tr>             
                <th>Pregunta</th>
                <th>SubCaracteristica Asociada</th>
                <th>Accion </th>
            </tr>
        </thead>
        <tfoot>
            <tr>              
                <th>Pregunta</th>
                <th>SubCaracteristica Asociada</th>
                <th>Accion </th>
            </tr>
        </tfoot>
        <tbody>

        </tbody>
    </table>
    
    <!--Modal "Ver informacion de las preguntas" -->
  <div class="modal fade" id="modalVerPregunta" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="padding:35px 50px;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4><span class="glyphicon glyphicon-plus"></span> Infomación de las Preguntas</h4>
                </div>
                <div class="modal-body" style="padding:40px 50px;">
                    <form role="form">
                        <div class="form-group">
                            <label for="usrname"><span class="glyphicon glyphicon-comment"></span> Pregunta</label>
                            <input type="text" class="form-control" id="pregunta_name_view" placeholder="" readonly="readonly">
                        </div>
                        <div class="form-group">
                            <label for="encargado"><span class="glyphicon glyphicon-user"></span> Caracteristica </label>
                            <input type="text" class="form-control" id="caracteristica_view" placeholder="" readonly="readonly">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>                   
                </div>
            </div>
        </div>
    </div> 
    
    <!-- Modal ACTUALIZAR PREGUNTAS-->
    <div class="modal fade" id="modalActualizarPreguntas" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="padding:35px 50px;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4><span class="glyphicon glyphicon-plus"></span> Actualizar Pregunta</h4>
                </div>
                <div class="modal-body" style="padding:40px 50px;">
                    <form role="form">
                        <div class="form-group">
                            <label for="usrname"><span class="glyphicon glyphicon-comment"></span> Pregunta </label>
                            <input type="text" class="form-control" id="pregunta_name_edit" placeholder="Escriba su pregunta...">
                        </div>
                        <div id="caracteristica_edit">
                            <label for="encargado"><span class="glyphicon glyphicon-user"></span> Caracteristica </label>
                             <select id="caract_edit_value" class="form-control">
                                <option value="0">Seleccione...</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                    <button type="button" class="btn btn-primary btn-default pull-rigth" onclick="actualizarPre()" data-dismiss="modal"><span class="glyphicon glyphicon-ok"></span> Actualizar</button>
                </div>
            </div>
        </div>
    </div>
    
</div>