document.addEventListener('DOMContentLoaded', function () {
    const inputStock = document.getElementById('cantidadTotal');
    const inputDisponible = document.getElementById('cantidadDisponible');
    const inputNombre = document.querySelector('input[name="nombre"]');
    const inputDescripcion = document.querySelector('input[name="descripcion"]');
    const btnGuardar = document.querySelector('button[type="submit"]');
    const mensajeError = document.getElementById('mensaje-error');

    function validarCampos() {
        const nombre = inputNombre.value.trim();
        const descripcion = inputDescripcion.value.trim();
        const stock = inputStock.value.trim();
        const disponible = inputDisponible.value.trim();
        const validos = nombre !== '' && descripcion !== '' && stock !== '' && disponible !== '' && !isNaN(stock) && parseInt(stock, 10) > 0;
        btnGuardar.disabled = !validos;
    }

    inputStock.addEventListener('input', function () {
        const stock = parseInt(inputStock.value, 10);
        if (!isNaN(stock) && stock > 0) {
            inputDisponible.value = stock;
            mensajeError.textContent = '';
        } else {
            inputDisponible.value = '';
            mensajeError.textContent = 'El stock debe ser un número mayor que 0.';
            inputStock.value = '';
        }
        validarCampos();
    });

    [inputNombre, inputDescripcion, inputStock].forEach(function (campo) {
        campo.addEventListener('input', validarCampos);
    });

    validarCampos();
});
