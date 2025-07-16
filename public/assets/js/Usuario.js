document.addEventListener('DOMContentLoaded', function() {
        var btnGuardar = document.getElementById('btnGuardar');
        var campos = [
            document.getElementById('cedula'),
            document.getElementById('nombre'),
            document.getElementById('apellido'),
            document.getElementById('email'),
            document.getElementById('rol')
        ];

        function validarCampos() {
            var validos = campos.every(function(campo) {
                if (campo.type === 'select-one') {
                    return campo.value !== '';
                }
                return campo.value && campo.value.trim() !== '';
            });
            btnGuardar.disabled = !validos;
        }

        campos.forEach(function(campo) {
            campo.addEventListener('input', validarCampos);
            campo.addEventListener('change', validarCampos);
        });
        validarCampos();
    });




    