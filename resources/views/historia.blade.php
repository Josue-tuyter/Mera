<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Historia — {{ config('app.name', 'Finca Cacao') }}</title>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Playfair+Display:wght@600&display=swap" rel="stylesheet">
        <style>
            body{font-family:Inter,system-ui;margin:0;background:#f7fff7;color:#07321b;padding:28px}
            .container{max-width:900px;margin:0 auto}
            .hero{background:linear-gradient(180deg,#fff,#f6fff8);padding:18px;border-radius:12px;box-shadow:0 8px 30px rgba(0,0,0,0.05)}
            h1{font-family:'Playfair Display',serif}
            .image{width:100%;height:260px;object-fit:cover;border-radius:10px;margin-top:12px}
            .btn{display:inline-block;margin-top:12px;padding:8px 14px;background:#2f855a;color:#fff;border-radius:10px;text-decoration:none}
        </style>
    </head>
    <body>
        <div class="container">
            <a href="{{ url('/') }}" class="btn">← Volver</a>
            <div class="hero" style="margin-top:12px">
                <h1>Historia de la finca</h1>
                <p style="color:#4e6b55">Una tradición familiar dedicada al cacao que se transmite de generación en generación. Nuestra historia combina prácticas agroecológicas con el fortalecimiento de la comunidad local.</p>
                <img class="image" src="{{ asset('images/imgs/img (2).jpeg') }}" alt="Historia">
                <h3 style="margin-top:12px">Nuestros inicios</h3>
                <p style="color:#4e6b55">La finca se estableció hace varias décadas con el objetivo de producir cacao de alta calidad, conservando técnicas tradicionales y adaptando mejoras agronómicas.</p>
                <h3>Compromiso social</h3>
                <p style="color:#4e6b55">Trabajamos con familias locales para generar oportunidades y promover prácticas sostenibles.</p>
            </div>
        </div>
    </body>
</html>
