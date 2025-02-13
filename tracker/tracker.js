// Получение данных и отправка на сервер
document.addEventListener('DOMContentLoaded', function() {
    fetch('https://ipapi.co/json/')
        .then(response => response.json())
        .then(data => {
            const ip = data.ip;
            const city = data.city;
            const device = navigator.userAgent;

            // Отправка данных на сервер
            fetch('track.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    ip: ip,
                    city: city,
                    device: device
                })
            });
        })
        .catch(error => console.error('Error:', error));
});