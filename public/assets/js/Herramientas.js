

//Vaidacion de formulario para crear una nueva herramienta

document.getElementById("formHerramienta").addEventListener("submit", function(e) {
    const total = parseInt(document.getElementById("cantidadTotal").value);
    const disponible = parseInt(document.getElementById("cantidadDisponible").value);

    if (isNaN(total) || isNaN(disponible)) {
        alert("Debe ingresar valores numéricos.");
        e.preventDefault();
        return;
    }

    if (total <= 0 || disponible < 0) {
        alert("el stock debe ser mayor que cero y la disponible no puede ser negativa.");
        e.preventDefault();
        return;
    }

    if (disponible > total) {
        alert("La cantidad disponible no puede ser mayor al stock.");
        e.preventDefault();
        return;
    }
});

