<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
<nav class="navbar navbar-light  bg-info">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">MerliNN</a>
        </div>
        <ul class="nav navbar-nav">
            <li class="active"><a href="<?php echo base_url(); ?>ProcesoController">Procesos</a></li>
            <!--<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="<?php echo base_url(); ?>ProcesoController">Procesos<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="#"></a></li>
                </ul>
            </li>-->
            <li><a href="<?php echo base_url(); ?>RolController">Roles</a></li>
            <li><a href="<?php echo base_url(); ?>NormativaController">Normativas</a></li>
            <li><a href="<?php echo base_url(); ?>InterfazController">Interfaces</a></li>
            <li><a href="<?php echo base_url(); ?>CaracteristicaController">RNF</a></li>
                        <li><a href="<?php echo base_url(); ?>ReporteController/generarPDF">Generar Reporte PDF</a></li>          

        </ul>
        <ul class="nav navbar-nav navbar-right" style="margin-right: 0px;">
            <li><a href="#"><span class="glyphicon glyphicon-user"></span> <?php echo $username; ?></a></li>
            <li><a href="#" onclick="cerrarSesion()"><span class="glyphicon glyphicon-log-out"></span> Salir</a></li>
        </ul>
    </div>
</nav>

<script>
    function cerrarSesion() {
        $.ajax({
            url: "<?php echo base_url();?>Login/cerrar",
            type: "POST",
            dataType: "json",
            data: {
            },
            beforeSend: function () {
                $("#loader").show();
            },
            success: function (data) {
                $("#loader").hide();
                window.location.href = "<?php echo base_url();?>";
            },
            error: function (response) {
                $("#loader").hide();
            }
        });
    }

    function reporteCont() {        
        $.post("ReporteController/generarPDF");
        $.alert({
                        type: 'green',
                        icon: 'glyphicon glyphicon-warning',
                        title: 'Exito!',
                        content: 'Reporte PDF Creado exitosamente',
                    });

            /*function (data) {
                if (data === "exito") {
                    $.alert({
                        type: 'orange',
                        icon: 'glyphicon glyphicon-warning',
                        title: 'Advertencia!',
                        content: 'Reporte PDF Creado exitosamente',
                    });
                } else {
                        $.alert({
                            type: 'red',
                            icon: 'glyphicon glyphicon-ok',
                            title: 'Error!',
                            content: 'No se pudo realizar el Registro...',
                        });
                    }
    },"json");*/
}
</script>

