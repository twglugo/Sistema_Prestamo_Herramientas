# Sistema de Préstamo de Herramientas

Este proyecto es un **Sistema de Préstamo de Herramientas** desarrollado en PHP y JavaScript, diseñado para gestionar el inventario y el préstamo/devolución de herramientas en una organización, taller o institución educativa.

## Características principales

- **Gestión de herramientas:** Permite registrar, modificar y listar herramientas con su cantidad total y disponible.
- **Control de préstamos:** Los usuarios pueden solicitar el préstamo de herramientas, especificando cantidad y fecha.
- **Devolución y actualización de stock:** El sistema controla la devolución parcial o total de herramientas, actualizando automáticamente el stock disponible.
- **Validaciones automáticas:** Garantiza que no se presten más herramientas de las disponibles ni se devuelvan más de las prestadas.
- **Roles de usuario:** Soporta lógica para roles (como admin), permitiendo diferentes vistas y permisos según el tipo de usuario.
- **Historial y detalles:** Consulta los detalles de cada préstamo, incluyendo usuario, herramienta, cantidad, fechas y estado (Activo/Devuelto).
- **Interfaz amigable:** Validaciones y mensajes en tiempo real para evitar errores de stock o de ingreso de datos.

## Consulta en línea

El sistema se encuentra desplegado y puede consultarse en AWS en la siguiente dirección:

[http://3.16.158.13/Sistema_Prestamo_Herramientas/public/](http://3.16.158.13/Sistema_Prestamo_Herramientas/public/)

## Modelo entidad-relación

A continuación se muestra el diagrama entidad-relación principal del sistema:

![Diagrama ER](utils/diagrama-er.png)

## Estructura del proyecto

- `src/Modelos/`: Modelos de datos principales (`Herramienta`, `Prestamo`, `DetallePrestamo`).
- `src/Controlador/`: Lógica de negocio y controladores para herramientas y préstamos.
- `public/assets/js/`: Scripts de JavaScript para validaciones y lógica del frontend.
- `config/db.php`: Configuración de la base de datos.

## Instalación

1. **Clona el repositorio:**
   ```bash
   git clone https://github.com/twglugo/Sistema_Prestamo_Herramientas.git
   ```
2. **Configura la base de datos:**
   - Crea una base de datos MySQL y ajusta las credenciales en `config/db.php`.
   - Importa el esquema y datos iniciales según corresponda.

3. **Configura el entorno web:**
   - Asegúrate de tener un servidor web con soporte PHP (Apache, Nginx, XAMPP, etc.).
   - Coloca el proyecto en la raíz pública o configura el virtual host.

## Uso básico

- Ingresa al sistema con tu usuario.
- Agrega nuevas herramientas o modifica las existentes.
- Realiza préstamos seleccionando herramienta, cantidad y fecha.
- Devuelve herramientas y el sistema actualizará automáticamente el stock y el estado del préstamo.

## Tecnologías utilizadas

- **Backend:** PHP (POO)
- **Frontend:** JavaScript, HTML, CSS
- **Base de datos:** MySQL

## Contribuciones

¡Las contribuciones son bienvenidas! Puedes abrir issues o enviar pull requests para agregar mejoras o corregir errores.

## Licencia

Este proyecto no tiene una licencia declarada.

---

**Repositorio:** [twglugo/Sistema_Prestamo_Herramientas](https://github.com/twglugo/Sistema_Prestamo_Herramientas)
