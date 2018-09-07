function loguearse() {
        $.post("Login/login_user",
                {
                    "usuario": $("#login_username").val(),
                    "contrasena": $("#login_contrasena").val(),
                });           
}
