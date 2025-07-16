document.addEventListener('DOMContentLoaded', function () {
    const stockInput = document.getElementById('cantidadTotal');
    const disponibleInput = document.getElementById('cantidadDisponible');
    const mensajeError = document.getElementById('mensaje-error');
    const nombreInput = document.getElementById('nombre');
    const descripcionInput = document.getElementById('descripcion');
    const btnGuardar = document.getElementById('btnGuardar');

    const stockInicial = parseInt(stockInput.value);
    const disponibleInicial = parseInt(disponibleInput.value);
    const usados = stockInicial - disponibleInicial;

    function validarFormulario() {
        const nombre = nombreInput.value.trim();
        const descripcion = descripcionInput.value.trim();
        const stock = parseInt(stockInput.value);
        let valido = true;

        if (!nombre || !descripcion || isNaN(stock)) {
            valido = false;
        }
        if (stock < usados) {
            valido = false;
        }
        btnGuardar.disabled = !valido;
    }

    stockInput.addEventListener('input', function () {
        const nuevoStock = parseInt(stockInput.value);

        if (isNaN(nuevoStock)) {
            mensajeError.textContent = '';
            disponibleInput.value = disponibleInicial;
            validarFormulario();
            return;
        }

        if (nuevoStock < usados) {
            mensajeError.textContent = `No puedes establecer un stock menor a ${usados} porque hay ${usados} herramientas prestadas.`;
            stockInput.classList.add('error');
            disponibleInput.value = usados - usados;
        } else {
            mensajeError.textContent = '';
            stockInput.classList.remove('error');
            const diferencia = nuevoStock - stockInicial;
            disponibleInput.value = disponibleInicial + diferencia;
        }
        validarFormulario();
    });

    nombreInput.addEventListener('input', validarFormulario);
    descripcionInput.addEventListener('input', validarFormulario);

    // Validar al cargar la página
    validarFormulario();
});
