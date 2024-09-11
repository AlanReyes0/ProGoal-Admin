document.addEventListener('DOMContentLoaded', () => {
    console.log('Script cargado');

    document.querySelectorAll('.delete-button').forEach(button => {
        button.addEventListener('click', () => {
            const idEquipo = button.getAttribute('data-id');

            console.log(`ID Equipo: ${idEquipo}`);

            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminarlo',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('../Backend/eliminar_equipo.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `id_equipo=${idEquipo}`
                    })
                    .then(response => response.text())
                    .then(response => {
                        console.log(`Respuesta del servidor: ${response}`);

                        if (response === 'success') {
                            Swal.fire(
                                'Eliminado!',
                                'El equipo ha sido eliminado.',
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                'Hubo un problema al eliminar el equipo.',
                                'error'
                            );
                        }
                    })
                    .catch(error => {
                        console.error('Error en fetch:', error);
                        Swal.fire(
                            'Error!',
                            'Hubo un problema al eliminar el equipo.',
                            'error'
                        );
                    });
                }
            });
        });
    });
});
