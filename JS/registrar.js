document.addEventListener('DOMContentLoaded', (event) => {
  document.getElementById('myButton').addEventListener('click', async () => {

    const { value: formValues } = await Swal.fire({
      title: "Registrar Equipo",
      width: '600px',
      padding: '3em',
      html: `
        <div style="display: flex; flex-direction: column; gap: 5px;">
          <input id="swal-nombre_equipo" class="swal2-input" placeholder="Nombre equipo" style="width: 100%; margin-bottom: 5px;">
          <input id="swal-cantidad_jugadores" class="swal2-input" type="number" placeholder="Cantidad de jugadores" style="width: 100%; margin-bottom: 5px;" value="0" disabled>
          <input id="swal-capitan" class="swal2-input" placeholder="Capitán" style="width: 100%; margin-bottom: 5px;">
          <input id="swal-contacto" class="swal2-input" placeholder="Contacto" style="width: 100%; margin-bottom: 5px;">
          <input id="swal-escudo" class="swal2-input" placeholder="Escudo" style="width: 100%; margin-bottom: 5px;">
        </div>
      `,
      focusConfirm: false,
      preConfirm: () => {
        return {
          nombre_equipo: document.getElementById("swal-nombre_equipo").value,
          cantidad_jugadores: document.getElementById("swal-cantidad_jugadores").value, // Siempre será 0
          capitan: document.getElementById("swal-capitan").value,
          contacto: document.getElementById("swal-contacto").value,
          escudo: document.getElementById("swal-escudo").value
        };
      }
    });

    console.log(formValues); // Para depuración

    if (formValues) {
      // Crear un FormData con los datos del formulario
      const formData = new FormData();
      formData.append('nombre_equipo', formValues.nombre_equipo);
      formData.append('cantidad_jugadores', formValues.cantidad_jugadores); // Será siempre 0
      formData.append('capitan', formValues.capitan);
      formData.append('contacto', formValues.contacto);
      formData.append('escudo', formValues.escudo);

      
      const response = await fetch('../Backend/registrar.php', {
        method: 'POST',
        body: formData
      });

      const result = await response.text(); // Leer la respuesta como texto

      // Mostrar resultado en SweetAlert2
      Swal.fire({
        title: result.includes('Datos registrados con éxito.') ? 'Éxito' : 'Error',
        text: result,
        icon: result.includes('Datos registrados con éxito.') ? 'success' : 'error' // Ajustar el icono según el resultado
      }).then(() => {
        // Recargar la página después de mostrar el mensaje
        location.reload();
      });
    }
  });
});
