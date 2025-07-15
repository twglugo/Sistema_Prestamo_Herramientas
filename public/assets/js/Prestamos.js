function toggleFechaDevolucion() {
    const estado = document.getElementById('estado').value;
    const campoFecha = document.getElementById('campoFechaDevolucion');
    campoFecha.style.display = estado === 'Devuelto' ? 'block' : 'none';
}



document.addEventListener('DOMContentLoaded', function () {
    const herramientaSelect = document.getElementById('herramienta');
    const cantidadInput = document.getElementById('cantidad');
    const mensajeError = document.getElementById('mensaje-error');
    const fechaInput = document.getElementById('fechaPrestamo');
    const errorFecha = document.getElementById('error-fecha');

    
    herramientaSelect.addEventListener('change', function () {
        const selectedOption = herramientaSelect.options[herramientaSelect.selectedIndex];
        const disponible = parseInt(selectedOption.getAttribute('data-disponible'), 10);

        if (!isNaN(disponible)) {
            cantidadInput.max = disponible;
            cantidadInput.value = '';
            mensajeError.textContent = '';
        }
    });

    cantidadInput.addEventListener('input', function () {
        const selectedOption = herramientaSelect.options[herramientaSelect.selectedIndex];
        const disponible = parseInt(selectedOption.getAttribute('data-disponible'), 10);
        const cantidad = parseInt(cantidadInput.value, 10);

        if (isNaN(cantidad) || cantidad < 1) {
            mensajeError.textContent = 'La cantidad debe ser un número positivo mayor que 0.';
            cantidadInput.value = '';
            return;
        }

        if (cantidad > disponible) {
            mensajeError.textContent = `No puede solicitar más de ${disponible} unidades disponibles.`;
            cantidadInput.value = disponible;
        } else {
            mensajeError.textContent = '';
        }
    });

    
    fechaInput.addEventListener('change', function () {
        const fechaSeleccionada = new Date(fechaInput.value);
        const hoy = new Date();

        fechaSeleccionada.setHours(0, 0, 0, 0);
        hoy.setHours(0, 0, 0, 0);

        if (fechaSeleccionada > hoy) {
            errorFecha.textContent = 'La fecha no puede ser posterior a hoy.';
            fechaInput.value = '';
        } else {
            errorFecha.textContent = '';
        }
    });
});



