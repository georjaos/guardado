<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>

<!--Este es el nuevo login -->
<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
<body>
	
	<div class="limiter">
            
		<div class="container-login100">
                    
			<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-50">
                                        
					<span class="login100-form-title p-b-33">
						Inicio de sesión
					</span>
                                        <div id="error">
            
                                        </div>

					<div class="wrap-input100 validate-input" data-validate = "Se requiere un email valido: ex@abc.xyz">
						<input class="input100" type="text" id="login_username" name="user_login" placeholder="Email ó usuario">
                                                
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
					</div>

					<div class="wrap-input100 rs1 validate-input" data-validate="Contraseña requerida ">
						<input class="input100" type="password"  id="login_password" name="user_password" placeholder="Contraseña">
						<span class="focus-input100-1"></span>
						<span class="focus-input100-2"></span>
					</div>

					<div class="container-login100-form-btn m-t-20">
                                            <button class="login100-form-btn" type="submit" onclick="login_user()">
							Ingresar
						</button>
					</div>

					<div class="text-center p-t-45 p-b-4">
						<span class="txt1">
							Olvido
						</span>

						<a href="#" class="txt2 hov1">
							Usuario / Contraseña?
						</a>
					</div>

					<div class="text-center">
						<span class="txt1">
							Crear una cuenta?
						</span>

						<a href="<?php echo base_url(); ?>UsuarioController" class="txt2 hov1">
							Registrarse
						</a>
					</div>
				
			</div>
		</div>
	</div>
	

</body>

<script>

    function login_user() {
        $.ajax({
            url: "http://localhost/levantamientorequisitos/Login/login_user",
            type: "POST",
            dataType: "json",
            data: {
                "user": $("#login_username").val(),
                "pwd": $("#login_password").val()
            },
            beforeSend: function () {
                $("#loader").show();
            },
            success: function (data) {
                $("#loader").hide();

                if (data == "no-exist") {
                    
                    $("#error").html('<div class="alert alert-danger"><strong>Error!</strong> Usuario no registrado.</div>');

                } else {
                    if (data == "no-user") {
                        
                        $("#error").html('<div class="alert alert-danger"><strong>Error!</strong> Nombre de usuario incorrecto.</div>');

                    } else {
                        if (data == "no-pass") {
                            
                            $("#error").html('<div class="alert alert-danger"><strong>Error!</strong> Contraseña incorrecta.</div>');

                        } else {
                            if (data) {
                                window.location.href = "/levantamientorequisitos/ProcesoController";
                            } else {
                                $("#error").html('<div class="alert alert-danger"><strong>Error!</strong> Debe iniciar sesión.</div>');

                            }
                        }
                    }
                }

            },
            error: function (response) {
                $("#loader").hide();
            }
        });
    }
    function comer(){
        alert("comiendo");
    }
</script>



