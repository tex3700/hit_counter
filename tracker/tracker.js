// Получение данных и отправка на сервер
document.addEventListener('DOMContentLoaded', function() {
    fetch('https://ipapi.co/json/')
        .then(response => response.json())
        .then(data => {
            const ip = data.ip;
            const city = data.city;
            const device = navigator.userAgent;

            const express = require('express');
            const app = express();
            app.get('/api/track', async (req, res) => {
                const response = await fetch('https://btx.tw1.ru/tracker/track.php', {
                    method: req.method,
                    headers: req.headers,
                    body: req.body
                });

                const data = await response.text();
                res.set("Access-Control-Allow-Origin", "*");
                res.send(data);
            });

            // Отправка данных на сервер
            fetch('/api/track', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    ip: ip,
                    city: city,
                    userAgent: device,
                    action: "track"
                })
            }).then(r => console.log(r));
        })
        .catch(error => console.error('Error:', error));
});