document.addEventListener('DOMContentLoaded', function() {
    var btnGuardar = document.getElementById('btnGuardar');
    var campos = [
        document.getElementById('cedula'),
        document.getElementById('nombre'),
        document.getElementById('apellido'),
        document.getElementById('email')
    ];
    var selectRol = document.getElementById('rol');
    // Detectar el rol desde un atributo data-rol en el select
    var esAdmin = selectRol && selectRol.hasAttribute('data-admin') && selectRol.getAttribute('data-admin') === 'true';

    function validarCampos() {
        var validos = campos.every(function(campo) {
            return campo.value && campo.value.trim() !== '';
        });
        if (esAdmin) {
            validos = validos && selectRol.value !== '';
        }
        btnGuardar.disabled = !validos;
    }

    campos.forEach(function(campo) {
        campo.addEventListener('input', validarCampos);
        campo.addEventListener('change', validarCampos);
    });
    if (esAdmin) {
        selectRol.addEventListener('change', validarCampos);
    }
    validarCampos();
});