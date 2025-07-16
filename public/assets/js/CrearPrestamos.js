document.addEventListener('DOMContentLoaded', function() {
        var selectHerramienta = document.getElementById('herramienta');
        var inputCantidadDisponible = document.getElementById('cantidadDisponible');
        var inputCantidad = document.getElementById('cantidad');
        var mensajeError = document.getElementById('mensaje-error');
        var form = document.getElementById('formPrestamo');
        var btnGuardar = document.getElementById('btnGuardar');

        // Detectar si el campo usuarioCedula es hidden o select
        var campoUsuario = document.getElementById('usuarioCedula');
        var campos = [
            document.getElementById('herramienta'),
            document.getElementById('cantidad'),
            document.getElementById('fechaPrestamo')
        ];
        // Solo agregar usuarioCedula si es select (admin)
        if (campoUsuario && campoUsuario.tagName.toLowerCase() === 'select') {
            campos.unshift(campoUsuario);
        }

        selectHerramienta.addEventListener('change', function() {
            var selected = selectHerramienta.options[selectHerramienta.selectedIndex];
            var disponible = selected.getAttribute('data-disponible');
            inputCantidadDisponible.value = disponible || '';
            inputCantidad.max = disponible || '';
            mensajeError.textContent = '';
        });

        inputCantidad.addEventListener('input', function() {
            var max = parseInt(inputCantidad.max, 10);
            var val = parseInt(inputCantidad.value, 10);
            if (val > max) {
                mensajeError.textContent = 'No puedes solicitar más de ' + max + ' unidades disponibles.';
                inputCantidad.value = max;
            } else {
                mensajeError.textContent = '';
            }
        });
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

    