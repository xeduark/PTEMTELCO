document.addEventListener('DOMContentLoaded', function () {
    var mensajeElement = document.getElementById('mensaje');
    if (mensajeElement.innerText !== '') {
        mensajeElement.style.display = 'block';
        setTimeout(function () {
            mensajeElement.style.display = 'none';
        }, 3000); // 3000 milisegundos (3 segundos)
    }
});