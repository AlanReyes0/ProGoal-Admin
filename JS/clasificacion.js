document.addEventListener('DOMContentLoaded', () => {
    async function loadClasificacion() {
        try {
            const response = await fetch('../Backend/cargar_clasificacion.php');
            if (!response.ok) {
                throw new Error('Error al cargar la clasificación. Status: ' + response.status);
            }

            const result = await response.json();
            if (result.error) {
                throw new Error(result.error);
            }

            console.log('Datos de clasificación:', result); // Para depuración

            const clasificacionContainer = document.getElementById('clasificacion');
            clasificacionContainer.innerHTML = '';

            const table = document.createElement('table');
            table.classList.add('tabla-clasificacion');
            table.innerHTML = `
                <thead>
                    <tr>
                        <th>Posición</th>
                        <th>Equipo</th>
                        <th>Partidos Jugados</th>
                        <th>Partidos Ganados</th>
                        <th>Partidos Empatados</th>
                        <th>Partidos Perdidos</th>
                        <th>Goles a Favor</th>
                        <th>Goles en Contra</th>
                        <th>Diferencia de Goles</th>
                        <th>Puntos</th>
                    </tr>
                </thead>
                <tbody>
                    ${result.clasificacion.map((equipo, index) => `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${equipo.nombre_equipo}</td>
                            <td>${equipo.partidos_jugados}</td>
                            <td>${equipo.partidos_ganados}</td>
                            <td>${equipo.partidos_empatados}</td>
                            <td>${equipo.partidos_perdidos}</td>
                            <td>${equipo.goles_favor}</td>
                            <td>${equipo.goles_contra}</td>
                            <td>${equipo.goles_favor - equipo.goles_contra}</td>
                            <td>${equipo.puntos}</td>
                        </tr>`).join('')}
                </tbody>
            `;
            clasificacionContainer.appendChild(table);
        } catch (error) {
            console.error('Error al cargar la clasificación:', error);
            Swal.fire('Error', 'No se pudo cargar la clasificación.', 'error');
        }
    }

    loadClasificacion();
});
