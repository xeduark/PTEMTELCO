document.addEventListener('DOMContentLoaded', function() {
    const jsonFile = '../js/horarios.json'; // Ruta relativa al archivo JSON

    fetch(jsonFile)
        .then(response => response.json())
        .then(data => {
            const horariosContainer = document.getElementById('horariosList'); // Corregido: usar 'horariosList' en lugar de 'horarios-list'
            horariosContainer.innerHTML = '';

            data.forEach(dia => {
                const horariosDia = document.createElement('li');
                horariosDia.textContent = `${dia.dia}: ${dia.horas.join(', ')}`;
                horariosContainer.appendChild(horariosDia);
            });
        })
        .catch(error => {
            console.error('Error al cargar los horarios:', error);
        });
});
