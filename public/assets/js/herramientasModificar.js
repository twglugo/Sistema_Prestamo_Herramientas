document.addEventListener('DOMContentLoaded', function () {
    const stockInput = document.getElementById('cantidadTotal');
    const disponibleInput = document.getElementById('cantidadDisponible');
    const mensajeError = document.getElementById('mensaje-error');

    const stockInicial = parseInt(stockInput.value);
    const disponibleInicial = parseInt(disponibleInput.value);
    const usados = stockInicial - disponibleInicial;

    stockInput.addEventListener('input', function () {
        const nuevoStock = parseInt(stockInput.value);

        if (isNaN(nuevoStock)) {
            mensajeError.textContent = '';
            return;
        }

        if (nuevoStock < usados) {
            mensajeError.textContent = `No puedes establecer un stock menor a ${usados} porque hay ${usados} herramientas prestadas.`;
            stockInput.value = usados;
            disponibleInput.value = usados  - usados; 
        } else {
            mensajeError.textContent = '';
            const diferencia = nuevoStock - stockInicial;
            disponibleInput.value = disponibleInicial + diferencia;
        }
    });
});
