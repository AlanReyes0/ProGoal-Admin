document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('generarJornadas').addEventListener('click', async () => {
        const { value: confirm } = await Swal.fire({
            title: 'Generar Jornadas',
            text: "¿Estás seguro de que quieres generar nuevas jornadas?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, generar',
            cancelButtonText: 'Cancelar'
        });

        if (confirm) {
            const response = await fetch('../Backend/generar_jornadas.php', {
                method: 'POST'
            });
            const result = await response.text();

            Swal.fire({
                title: result.includes('con éxito') ? 'Éxito' : 'Error',
                text: result,
                icon: result.includes('con éxito') ? 'success' : 'error'
            }).then(() => {
                location.reload(); // Recargar la página para mostrar las nuevas jornadas
            });
        }
    });

    async function loadJornadas() {
        try {
            const response = await fetch('../Backend/cargar_jornadas.php');
            if (!response.ok) {
                throw new Error('Error al cargar las jornadas. Status: ' + response.status);
            }

            const result = await response.json();
            console.log('Datos cargados:', result); // Para depuración

            const jornadasContainer = document.getElementById('jornadas');
            jornadasContainer.innerHTML = '';

            result.jornadas.forEach((jornada, index) => {
                const jornadaElement = document.createElement('div');
                jornadaElement.innerHTML = `<h2>Jornada ${index + 1}</h2><table class="tabla-jornadas">
                    <thead>
                        <tr>
                            <th>ID Partido</th>
                            <th>Equipo 1</th>
                            <th>Equipo 2</th>
                            <th>Resultado Equipo 1</th>
                            <th>Resultado Equipo 2</th>
                            <th>Actualizar</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${jornada.partidos.map(partido => `
                        <tr>
                            <td>${partido.id_partido}</td>
                            <td>${partido.equipo1}</td>
                            <td>${partido.equipo2}</td>
                            <td><input type='number' data-id='${partido.id_partido}' class='resultado-equipo1' value='${partido.resultado_equipo1 || 0}'></td>
                            <td><input type='number' data-id='${partido.id_partido}' class='resultado-equipo2' value='${partido.resultado_equipo2 || 0}'></td>
                            <td><button data-id='${partido.id_partido}' class='btn-actualizar'>Actualizar</button></td>
                        </tr>`).join('')}
                    </tbody>
                </table>
                <p>Descansa: ${jornada.descanso}</p>`;
                jornadasContainer.appendChild(jornadaElement);
            });
        } catch (error) {
            console.error('Error al cargar las jornadas:', error);
            Swal.fire('Error', 'No se pudo cargar la información de las jornadas.', 'error');
        }
    }

    loadJornadas();

    document.addEventListener('click', async (event) => {
        if (event.target.classList.contains('btn-actualizar')) {
            const idPartido = event.target.getAttribute('data-id');
            const resultadoEquipo1 = document.querySelector(`.resultado-equipo1[data-id="${idPartido}"]`).value;
            const resultadoEquipo2 = document.querySelector(`.resultado-equipo2[data-id="${idPartido}"]`).value;

            const response = await fetch('../Backend/resultado_partidos.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: new URLSearchParams({
                    'id_partido': idPartido,
                    'resultado_equipo1': resultadoEquipo1,
                    'resultado_equipo2': resultadoEquipo2
                })
            });

            const result = await response.text();

            Swal.fire({
                title: result.includes('con éxito') ? 'Éxito' : 'Error',
                text: result,
                icon: result.includes('con éxito') ? 'success' : 'error'
            });
        }
    });
});
