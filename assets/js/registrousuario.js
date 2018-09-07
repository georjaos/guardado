/* 
 * funcion que al momento de cargar la vista usario_view carga todos 
 * los tipos de usuario en la vista
 * @returns {Boolean} 
 */ 
$(function () {
    listarTipoUsuarioVista();
});

$(function () {
    $("#nombreid").keypress(function () {
        $(".error").remove();
    });
});

$(function () {
    $("#apellidosid").keypress(function () {
        $(".error").remove();
    });
});

$(function () {
    $("#emailid").keypress(function () {
        $(".error").remove();
    });
});

$(function () {
    $("#loginid").keypress(function () {
        $(".error").remove();
    });
});

$(function () {
    $("#contrasenaid").keypress(function () {
        $(".error").remove();
    });
});

$(function () {
    $("#tipousuario").click(function () {
        $(".error").remove();
    });
});


/* 
 * funcion que valida que en una cadena de caracteres solo sean de letras
 * @returns {Boolean} 
 */ 
function onlyLetters(l) {
    //var valid1 = "/^ [a-zA-Z]+$/";
    var valid1 = "/[^A-Za-z ñÑáéíóú]/";
    //if ((/^[a-zA-Z]+$/.test(l))) {
    if ((/[^A-Za-z ñÑáéíóú]+$/.test(l))) {
        return false;
    }
    else {
        return true;
    }
}

/* 
 * funcion que valida que en una cadena no se encuentren caracteres especiales
 * @returns {Boolean} 
 */ 

function isValidInput(str) {
    return !/[~`!#$%\^&*+=\-\[\]\\';,/{}|\\":<>\?]/g.test(str);
}

/* 
 * funcion que valida el formato para registrar un correo.
 * @returns {Boolean} 
 */ 

function emailValidate(str) {
    return !/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/g.test(str);
}

/* 
 * funcion que valida los datos del formulario, retornando una bandera de tipo boolean 
 * @returns {Boolean} 
 */ 
function validarDatos() {

    var band = true;

    if ($("#nombreid").val() == "") {
        $("#nombreid").focus().before("<span class='error'>Ingrese Nombre del usuario. </span>");
        $(".error").fadeIn();
        band = false;
    } else if (!isValidInput($("#nombreid").val())) {
        $("#nombreid").focus().before("<span class='error'>Caracteres no válidos.</span>");
        $(".error").fadeIn();
        band = false;
    } else if ($("#nombreid").val().length > 20) {
        $("#nombreid").focus().before("<span class='error'>Solo se permite 20 Caracteres.</span>");
        $(".error").fadeIn();
        band = false;
    }

    if ($("#apellidosid").val() == "") {
        $("#apellidosid").focus().before("<span class='error'>Ingrese apellidos.</span>");
        $(".error").fadeIn();
        band = false;
    } else if (!isValidInput($("#apellidosid").val())) {
        $("#apellidosid").focus().before("<span class='error'>Caracteres no válidos.</span>");
        $(".error").fadeIn();
        band = false;

    } else if ($("#apellidosid").val().length > 20) {
        $("#apellidosid").focus().before("<span class='error'>Solo se permite 20 Caracteres.</span>");
        $(".error").fadeIn();
        band = false;
    }

    if ($("#emailid").val() == "") {
        $("#emailid").focus().before("<span class='error'>Ingrese direccion de correo electronico.</span>");
        $(".error").fadeIn();
        band = false;
    }
    else if (emailValidate($("#emailid").val())) {
        $("#emailid").focus().before("<span class='error'>Formato NO valido. </span>");
        $(".error").fadeIn();
        band = false;
    }
    else if ($("#emailid").val().length > 40) {
        $("#emailid").focus().before("<span class='error'>Solo se permite 40 Caracteres.</span>");
        $(".error").fadeIn();
        band = false;
    }
    if ($("#loginid").val() == "") {
        $("#loginid").focus().before("<span class='error'>Ingrese un usuario.</span>");
        $(".error").fadeIn();
        band = false;

    } else if ($("#loginid").val().length > 20) {
        $("#loginid").focus().before("<span class='error'>Solo se permite 20 Caracteres.</span>");
        $(".error").fadeIn();
        band = false;
    } else if (!isValidInput($("#loginid").val())) {
        $("#loginid").focus().before("<span class='error'>Caracteres no válidos.</span>");
        $(".error").fadeIn();
        band = false;
    }

    if ($("#contrasenaid").val() == "") {
        $("#contrasenaid").focus().before("<span class='error'>Ingrese contraseña.</span>");
        $(".error").fadeIn();
        band = false;
    } else if ($("#contrasenaid").val().length > 40) {
        $("#contrasenaid").focus().before("<span class='error'>Solo se permiten 40 caracteres</span>");
        $(".error").fadeIn();
        band = false;
    }

    if ($("#tipousuario").val() == "0") {
        $("#tipousuario").focus().before("<span class='error'>Seleccione un tipo de usuario.</span>");
        $(".error").fadeIn();
        band = false;
    }
    return band;
}

/* 
 * funcion que registra un usuario.
 * envia los datos de un nuevo usuario al UsuarioController para registralos en la base de datos
 * @returns {Boolean} 
 */ 
function registrar_user() {

    if (validarDatos()) {
        $.post("UsuarioController/register_user",
            {
                "user_name": $("#nombreid").val(),
                "user_apellido": $("#apellidosid").val(),
                "user_email": $("#emailid").val(),
                "user_login": $("#loginid").val(),
                "user_password": $("#contrasenaid").val(),
                "user_tipousuario": $("#tipousuario").val()
            },
            function (data) {

                if (data === "exist_email") {
                    $.alert({
                        type: 'orange',
                        icon: 'glyphicon glyphicon-warning',
                        title: 'Advertencia!',
                        content: 'CORREO ya registrado',
                    });
                }

                else if (data === "exist_login") {
                    $.alert({
                        type: 'orange',
                        icon: 'glyphicon glyphicon-warning',
                        title: 'Advertencia!',
                        content: 'LOGIN ya registrado',
                    });
                }

                else {
                    if (data) {
                        $.alert({
                            type: 'green',
                            icon: 'glyphicon glyphicon-ok',
                            title: 'Exito!',
                            content: 'Usuario Registrado. Gracias por Registrarse.',
                        });

                        $("#nombreid").val("");
                        $("#apellidosid").val("");
                        $("#emailid").val("");
                        $("#loginid").val("");
                        $("#contrasenaid").val("");
                        $("#tipousuario").val("0"); 
                        window.location.href = "/levantamientorequisitos/Login";   
                    } else {
                        $.alert({
                            type: 'red',
                            icon: 'glyphicon glyphicon-ok',
                            title: 'Error!',
                            content: 'No se pudo realizar el Registro...',
                        });
                    }
                }
            }, "json");
    } else {
        $.alert({
            type: 'red',
            title: 'Error!',
            content: 'Todos los campos son obligatorios',
        });
    }
}


/* 
 * funcion que lista los tipos de usuario.
 * Envia los datos de tipos de usarios para que sean mostrados en la vista.
 * @returns {Boolean} 
 */ 
function listarTipoUsuarioVista(){
    $.post("UsuarioController/listarTipoUsuario",
        function (data) {
            var html = "";
            html += '<select id="tipousuario" class="form-control">';
            html += '<option value="0">Seleccione...</option>'
            for (var i = 0; i < data.length; i++) {
                html += '<option value="' + data[i].id_tipousu + '">' + data[i].nombre_tipousu + '</option>';
            }
            html += "</select> ";
            $("#usu").html(html);
        }, "json");
}