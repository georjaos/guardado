<html>
    <?php $this->load->view('head/nav'); ?>
    <head>
        <title>Secuencia</title>
        <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
        <script src="<?php echo base_url(); ?>assets/jquery.dataTables.js"></script>
        <script src="<?php echo base_url(); ?>assets/dataTables.bootstrap.js"></script>
        <script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css"> 
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
        <!--hoja de estilos para los procesos.-->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style_secuenciaProcesos.css">
        <!--archivo .js donde hace los llamados al controlador y las validaciones-->
        <script src="<?php echo base_url(); ?>assets/js/secuenciaProcesos.js"></script>
    </head>
    <body>
        <div class="container box">
            <h1 align="center">Secuencia de los procesos </h1>
            <button type="button" class="btn btn-primary" id="btnAddRol" onclick="location.href = '<?php echo base_url(); ?>ProcesoController'"><span class="glyphicon glyphicon-menu-left"></span> Volver</button>
            <br />
            <ul class="list-unstyled" id="listaProcesos">

            </ul>
            <input type="hidden" name="page_order_list" id="page_order_list" />
        </div>
        
        <!-- Modal procesos paralelos-->
    <div class="modal fade" id="modalProcesosP" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header" style="padding:10px 10px;" id="superiorParalelos">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4><span class="glyphicon glyphicon-menu-hamburger"></span> Procesos paralelos</h4>
                </div>
                <div class="modal-body" style="padding:20px 40px;">
                    <form role="form">
                        <div class="form-group">
                            <table id="tablaProcesosParalelos" class="table table-striped table-bordered">
                                <thead>
                                    <tr>             
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Prioridad</th>
                                        <th>Accion</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>              
                                        <th>Nombre</th>
                                        <th>Descripcion</th>
                                        <th>Prioridad</th>
                                        <th>Accion</th>
                                    </tr>
                                </tfoot>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <div class="form-group">
                            <h4>Lista de procesos</h4>
                            <table id="tablaProcesos" class="table table-striped table-bordered">
                                <thead>
                                    <tr>             
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Prioridad</th>
                                        <th>Accion</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>              
                                        <th>Nombre</th>
                                        <th>Descripcion</th>
                                        <th>Prioridad</th>
                                        <th>Accion</th>
                                    </tr>
                                </tfoot>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
                <div class="modal-footer" id="inferiorNuevoProceso">
                    <button type="button"  name ="bntOKParalelos" class="btn btn-success btn-default pull-right" data-dismiss="modal"><span class="glyphicon glyphicon-ok"></span> Aceptar</button>
                    
                </div>
            </div>

        </div>
    </div>
        
    </body>
</html>




