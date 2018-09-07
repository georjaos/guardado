
<head> 
<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

<!--script necesario para mostar los dialogos de confirmacion mediante JQuery -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>
<!--hoja de estilos para el formulario de registro.-->
<link rel="stylesheet" href="assets/css/style_registrousu.css">
<!--archivo .js donde hace los llamados al controlador y las validaciones-->
<script src="assets/js/registrousuario.js"></script>
</head>

<body>
    <!--Formulario de registro -->
    <div id="info_usuario">
        <h3 style="text-align: center;">Registrar Usuario</h3>
            <div class="form-group">
                <label for="nombre"><span class="glyphicon glyphicon-comment"></span> Nombre</label><span id="require">*</span><span id="error"></span>
                <input type="text" class="form-control" id="nombreid"  name="user_name" placeholder="" >
            </div>

            <div id="error_nombre" style="margin-top:20px">
            </div>
            
            <div class="form-group">
                <label for="apellidos"><span class="glyphicon glyphicon-comment"></span>Apellidos</label><span id="require">*</span><span id="error"></span>
                <input type="text" class="form-control" id="apellidosid" name="user_apellido" placeholder="" >
            </div>

            <div id="error_apellidos" style="margin-top:20px">
            </div>
            
            <div class="form-group">
                <label for="email"><span class="glyphicon glyphicon-envelope"></span> Email</label><span id="require">*</span><span id="error"></span>
                <input type="email" class="form-control" id="emailid" name="user_email" placeholder="Ej: usuario@example.com" >
            </div>

            <div id="error_email" style="margin-top:20px"> 
            </div>
            
            <div class="form-group">
                <label for="login"><span class="glyphicon glyphicon-user"></span> Login</label><span id="require">*</span><span id="error"></span>
                <input type="text" class="form-control" id="loginid"  name="user_login" placeholder="Ej: usuario123"  >
            </div>

            <div id="error_login" style="margin-top:20px">
            </div>

            <div class="form-group">
                <label for="contrasena"><span class="glyphicon glyphicon-lock"></span> Contraseña</label><span id="require">*</span><span id="error"></span>
                <input type="password" class="form-control" id="contrasenaid"  name="user_password" placeholder="Ej: ********" >
            </div>

            <div id="error_contrasena" style="margin-top:20px">
            </div>

            <div class="form-group">
                <label for="tipousu"><span class="glyphicon glyphicon-user"></span> Tipo Usuario</label><span id="require">*</span><span id="error"></span>
                <!--<input type="text" class="form-control" id="tipousuid"  name="user_tipousuario" maxlength="20">-->
                <div id="usu">
                <select id="tipousuario" class="form-control" >
                                <option value="0">Seleccione...</option>                               
                            </select> 
                </div>
                
            </div>                            
            <div class="" style="margin-left: 40%; margin-top: 30px;">     
                <!-- boton que registra la informacion se hace mediante javascript mediante el metodo registrar_user()-->           
                <button type="onSubmit" class="btn btn-primary" name="register" " id="btn_registrarusu" onclick="registrar_user()"><span class="glyphicon glyphicon-log-in"></span> Registrar </button>                          
            </div>            
        <button type="submit" class=" btn btn btn-link"  id="btn_cancelarregistro" onclick="volver()" ><span class="glyphicon glyphicon-arrow-left" ></span> Volver</button>                                    
    </div>
    
</body>

<!--Metodo javascript que accede a la vista de login -->
<script>
 function volver(){
     window.location.href = "/levantamientorequisitos";
 }
</script>

<!--Estilos al fomulario este es css.-->
<style>
    #info_usuario{
        width: 70%;
        margin-left: auto;
        margin-right: auto;
        border: 1px solid #D0D0D0;
        border-radius: 3px;
        padding-top: 1%;
        padding-left: 10%;
        padding-right: 10%;
        padding-bottom: 2%;
        margin-top: 40px;
    }
</style>