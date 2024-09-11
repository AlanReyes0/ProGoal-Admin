document.addEventListener('DOMContentLoaded', () => {
    const botonAgregar = document.getElementById('myButton');
    const idEquipo = new URLSearchParams(window.location.search).get('id');

    botonAgregar.addEventListener('click', () => {
        Swal.fire({
            title: 'Agregar Jugador',
            html: `
                <input id="nombre" class="swal2-input" placeholder="Nombre del Jugador">
               <select id="posicion" class="swal2-input">
                    <option value="">Selecciona una Posición</option>
                    <option value="Portero">Portero</option>
                    <option value="Defensa">Defensa</option>
                    <option value="Mediocampista">Mediocampista</option>
                    <option value="Delantero">Delantero</option>
                </select>
            `,
            confirmButtonText: 'Agregar',
            preConfirm: () => {
                const nombre = Swal.getPopup().querySelector('#nombre').value;
                const posicion = Swal.getPopup().querySelector('#posicion').value;
                if (!nombre || !posicion) {
                    Swal.showValidationMessage(`Por favor, completa todos los campos.`);
                }
                return { nombre, posicion, idEquipo };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const { nombre, posicion, idEquipo } = result.value;
                fetch('../Backend/agregar_jugador.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        'nombre': nombre,
                        'posicion': posicion,
                        'id_equipo': idEquipo
                    })
                }).then(response => response.text())
                .then(result => {
                    Swal.fire('Jugador agregado', '', 'success');
                    // Opcional: Actualiza la tabla de jugadores en la página
                    location.reload();
                }).catch(error => {
                    Swal.fire('Error', 'Hubo un problema al agregar el jugador.', 'error');
                });
            }
        });
    });
});
