// JS para lógica de modificar cantidad prestada y disponible en el formulario de préstamo usuario

document.addEventListener('DOMContentLoaded', function() {
    const cantidadInput = document.getElementById('cantidad');
    const radioRestar = document.querySelector('input[name="logicaHerramienta"][value="restar"]');
    const labelPrestada = document.getElementById('label-prestada');
    const labelDisponible = document.getElementById('label-disponible');
    const mensajeInfo = document.getElementById('mensaje-info');
    const mensajeError = document.getElementById('mensaje-error');
    const cantidadPrestadaFinal = document.getElementById('cantidadPrestadaFinal');
    const cantidadDisponibleFinal = document.getElementById('cantidadDisponibleFinal');
    const estadoSelect = document.getElementById('estado');

    // Valores iniciales
    let originalPrestada = parseInt(cantidadInput.getAttribute('data-original'));
    let disponible = parseInt(cantidadInput.getAttribute('data-disponible'));
    let total = parseInt(cantidadInput.getAttribute('data-total'));

    // Si el préstamo está devuelto, mostrar 0 en cantidad prestada
    if (estadoSelect && estadoSelect.value === 'Devuelto') {
        labelPrestada.textContent = '0';
        cantidadInput.value = 0;
        cantidadInput.disabled = true;
        mensajeInfo.textContent = '';
        cantidadPrestadaFinal.value = 0;
        cantidadDisponibleFinal.value = disponible;
        return;
    }


    // Limitar el input a min 1 y max originalPrestada
    cantidadInput.setAttribute('min', '1');
    cantidadInput.setAttribute('max', originalPrestada);

    function actualizarLabels() {
        let cantidad = parseInt(cantidadInput.value) || 0;
        // Limitar cantidad a máximo la cantidad prestada original
        if (cantidad > originalPrestada) {
            cantidad = originalPrestada;
            cantidadInput.value = originalPrestada;
        }
        if (cantidad < 1) {
            cantidad = 1;
            cantidadInput.value = 1;
        }
        // Calcular dinámicamente
        let nuevaPrestada = originalPrestada - cantidad;
        let nuevaDisponible = disponible + cantidad;
        mensajeInfo.textContent = 'restar';
        mensajeError.textContent = '';

        if (cantidad === originalPrestada) {
            // Si se entrega todo, marcar como devuelto
            if (estadoSelect) {
                for (let i = 0; i < estadoSelect.options.length; i++) {
                    if (estadoSelect.options[i].value === 'Devuelto') {
                        estadoSelect.selectedIndex = i;
                        break;
                    }
                }
            }
            mensajeError.textContent = '¡Entrega completa! El préstamo será marcado como DEVUELTO.';
        } else {
            // Visualmente dejar en Activo
            if (estadoSelect) {
                for (let i = 0; i < estadoSelect.options.length; i++) {
                    if (estadoSelect.options[i].value === 'Activo') {
                        estadoSelect.selectedIndex = i;
                        break;
                    }
                }
            }
        }

        // Actualizar los labels dinámicamente
        labelPrestada.textContent = nuevaPrestada;
        labelDisponible.textContent = nuevaDisponible;
        cantidadPrestadaFinal.value = nuevaPrestada;
        cantidadDisponibleFinal.value = nuevaDisponible;
    }

    cantidadInput.addEventListener('input', actualizarLabels);
    radioRestar.addEventListener('change', function() {
        cantidadInput.value = '';
        mensajeError.textContent = '';
        actualizarLabels();
    });

    actualizarLabels();
});
