document.addEventListener('DOMContentLoaded', function () {
    const inputStock = document.getElementById('cantidadTotal');
    const inputDisponible = document.getElementById('cantidadDisponible');
    const mensajeError = document.getElementById('mensaje-error');

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
    });
});
