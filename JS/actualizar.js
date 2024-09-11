document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.update-button').forEach(button => {
        button.addEventListener('click', () => {
            const idEquipo = button.getAttribute('data-id');
            const nombreEquipo = button.getAttribute('data-nombre');
            const cantidadJugadores = button.getAttribute('data-jugadores');
            const capitan = button.getAttribute('data-capitan');
            const contacto = button.getAttribute('data-contacto');
            const escudo = button.getAttribute('data-escudo');

            Swal.fire({
                title: 'Actualizar equipo',
                html: `
                    <label>Nombre equipo: </label>
                    <input id="swal-nombre_equipo" class="swal2-input" value="${nombreEquipo}">
                    <label>Jugadores: </label>
                    <input id="swal-cantidad_jugadores" class="swal2-input" type="number" value="${cantidadJugadores}">
                    <label>Capitán: </label>
                    <input id="swal-capitan" class="swal2-input" value="${capitan}">
                    <label>Contacto: </label>
                    <input id="swal-contacto" class="swal2-input" value="${contacto}">
                    <label>Escudo: </label>
                    <input id="swal-escudo" class="swal2-input" value="${escudo}">
                `,
                focusConfirm: false,
                preConfirm: () => {
                    const nombreEquipo = document.getElementById('swal-nombre_equipo').value;
                    const cantidadJugadores = document.getElementById('swal-cantidad_jugadores').value;
                    const capitan = document.getElementById('swal-capitan').value;
                    const contacto = document.getElementById('swal-contacto').value;
                    const escudo = document.getElementById('swal-escudo').value;

                    return { idEquipo, nombreEquipo, cantidadJugadores, capitan, contacto, escudo };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const data = result.value;

                    fetch('../Backend/actualizar_equipo.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `id=${data.idEquipo}&nombre=${data.nombreEquipo}&jugadores=${data.cantidadJugadores}&capitan=${data.capitan}&contacto=${data.contacto}&escudo=${data.escudo}`
                    })
                    .then(response => response.text())
                    .then(data => {
                        if (data === 'success') {
                            Swal.fire(
                                '¡Actualizado!',
                                'El equipo ha sido actualizado.',
                                'success'
                            ).then(() => location.reload());
                        } else {
                            Swal.fire(
                                'Error',
                                'Hubo un problema al actualizar el equipo.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });
});
