document.addEventListener('DOMContentLoaded', function () {
function toggleFechaDevolucion() {
    const estado = document.getElementById('estado').value;
    const campoFecha = document.getElementById('campoFechaDevolucion');
    campoFecha.style.display = estado === 'Devuelto' ? 'block' : 'none';
}

function obtenerValores() {
    const prestadaSpan = document.getElementById('label-prestada');
    const disponibleSpan = document.getElementById('label-disponible');
    const inputPrestadaFinal = document.getElementById('cantidadPrestadaFinal');
    const inputDisponibleFinal = document.getElementById('cantidadDisponibleFinal');
    const inputIdDetalle = document.getElementById('idDetallePrestamo');
    const prestada = parseInt(prestadaSpan.textContent, 10);
    const disponible = parseInt(disponibleSpan.textContent, 10);
    if (isNaN(prestada) || isNaN(disponible)) {
        alert("Los valores no son válidos.");
        return;
    }
    inputPrestadaFinal.value = prestada;
    inputDisponibleFinal.value = disponible;
    // Si existe el campo idDetallePrestamo, no modificar, solo asegurar que se envía
    if (inputIdDetalle) {
        inputIdDetalle.value = inputIdDetalle.value;
    }
}


    const cantidadInput = document.getElementById('cantidad');
    const mensajeError = document.getElementById('mensaje-error');
    const mensajeInfo = document.getElementById('mensaje-info');
    const fechaInput = document.getElementById('fechaPrestamo');
    const errorFecha = document.getElementById('error-fecha');
    const radioInputs = document.querySelectorAll('input[name="logicaHerramienta"]');
    const estadoSelect = document.getElementById('estado');
    const submitButton = document.querySelector('button[type="submit"]');
    const originalPrestada = parseInt(document.getElementById('label-prestada')?.textContent || '0', 10);
    const disponibleInicial = parseInt(cantidadInput.dataset.disponible, 10);
    const total = parseInt(cantidadInput.dataset.total, 10);
    const labelPrestada = document.getElementById('label-prestada');
    const labelDisponible = document.getElementById('label-disponible');

    function actualizarMensajeInfo() {
        const seleccion = document.querySelector('input[name="logicaHerramienta"]:checked');
        if (seleccion && mensajeInfo) {
            mensajeInfo.textContent = seleccion.value === 'sumar' ? 'sumar' : 'restar';
        }
    }

    function validarEstadoBoton(cantidadDigitada, nuevaPrestada, nuevaDisponible) {
        const seleccion = document.querySelector('input[name="logicaHerramienta"]:checked').value;
        if (isNaN(cantidadDigitada) || cantidadDigitada < 0) {
            submitButton.disabled = true;
            return;
        }
        if (seleccion === 'sumar' && nuevaDisponible < 0) {
            submitButton.disabled = true;
            return;
        }
        if (seleccion === 'restar' && (nuevaPrestada < 0 || nuevaDisponible > total)) {
            submitButton.disabled = true;
            return;
        }
        submitButton.disabled = false;
    }

    radioInputs.forEach(radio => {
        radio.addEventListener('change', function () {
            actualizarMensajeInfo();
            cantidadInput.dispatchEvent(new Event('input'));
        });
    });

    estadoSelect.addEventListener('change', function () {
        const estado = estadoSelect.value;
        if (estado === 'Devuelto') {
            document.querySelector('input[value="restar"]').checked = true;
            actualizarMensajeInfo();
            cantidadInput.value = originalPrestada;
        } else {
            document.querySelector('input[value="sumar"]').checked = true;
            actualizarMensajeInfo();
            cantidadInput.value = 0;
        }
        cantidadInput.dispatchEvent(new Event('input'));
        toggleFechaDevolucion();
    });

    actualizarMensajeInfo();

    cantidadInput.addEventListener('input', function () {
        let cantidadDigitada = parseInt(cantidadInput.value, 10);
        const seleccion = document.querySelector('input[name="logicaHerramienta"]:checked').value;
        if (isNaN(cantidadDigitada)) {
            mensajeError.textContent = 'Debes ingresar un número válido.';
            submitButton.disabled = true;
            return;
        }
        if (cantidadDigitada < 0) {
            cantidadDigitada = 0;
            cantidadInput.value = 0;
        }
        let nuevaPrestada = originalPrestada;
        let nuevaDisponible = disponibleInicial;
        if (seleccion === 'sumar') {
            nuevaPrestada += cantidadDigitada;
            nuevaDisponible -= cantidadDigitada;
            if (nuevaDisponible < 0) {
                mensajeError.textContent = `No puedes prestar más de lo disponible. Disponibles: ${disponibleInicial}`;
                cantidadInput.value = 0;
                submitButton.disabled = true;
                return;
            }
            estadoSelect.value = 'Activo';
            toggleFechaDevolucion();
        } else {
            nuevaPrestada -= cantidadDigitada;
            nuevaDisponible += cantidadDigitada;
            if (nuevaPrestada < 0) {
                mensajeError.textContent = `No puedes devolver más de lo que fue prestado.`;
                cantidadInput.value = 0;
                submitButton.disabled = true;
                return;
            }
            if (nuevaDisponible > total) {
                mensajeError.textContent = `La disponibilidad no puede superar el stock total (${total}).`;
                cantidadInput.value = 0;
                submitButton.disabled = true;
                return;
            }
            if (nuevaPrestada === 0) {
                estadoSelect.value = 'Devuelto';
                toggleFechaDevolucion();
            } else if (nuevaPrestada > 0) {
                estadoSelect.value = 'Activo';
                toggleFechaDevolucion();
            }
        }
        mensajeError.textContent = '';
        if (labelPrestada) labelPrestada.textContent = nuevaPrestada;
        if (labelDisponible) labelDisponible.textContent = nuevaDisponible;
        validarEstadoBoton(cantidadDigitada, nuevaPrestada, nuevaDisponible);
    });

    if (fechaInput) {
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
    }

    document.getElementById('formHerramienta').addEventListener('submit', function (e) {
        obtenerValores();
    });
});
                cantidadInput.value = 0;

