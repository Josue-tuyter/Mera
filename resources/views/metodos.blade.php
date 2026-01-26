<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Métodos — {{ config('app.name', 'Finca Cacao') }}</title>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
        <style>
            body{font-family:Inter,system-ui;margin:0;background:#f7fff7;color:#07321b;padding:28px}
            .container{max-width:900px;margin:0 auto}
            .card{background:#fff;padding:18px;border-radius:12px;box-shadow:0 8px 30px rgba(0,0,0,0.05)}
            .grid{display:grid;grid-template-columns:1fr;gap:12px;margin-top:12px}
            .method-img{width:100%;height:200px;object-fit:cover;border-radius:8px}
            .btn{display:inline-block;margin-top:12px;padding:8px 14px;background:#2f855a;color:#fff;border-radius:10px;text-decoration:none}
        </style>
    </head>
    <body>
        <div class="container">
            <a href="{{ url('/') }}" class="btn">← Volver</a>
            <div class="card">
                <h1>Métodos y labores culturales</h1>
                <p style="color:#4e6b55">Descripción detallada de las prácticas que realizamos para garantizar la sanidad y calidad del cacao.</p>
                <div class="grid">
                    <div>
                        <h3>Siembra y establecimiento</h3>
                        <img class="method-img" src="https://images.unsplash.com/photo-1506806732259-39c2d0268443?auto=format&fit=crop&w=1200&q=60" alt="Siembra">
                        <p style="color:#4e6b55">Preparación de suelo, selección de plantones y manejo de sombra.</p>
                    </div>
                    <div>
                        <h3>Poda y formación</h3>
                        <img class="method-img" src="https://images.unsplash.com/photo-1472220625704-91e1462799b2?auto=format&fit=crop&w=1200&q=60" alt="Poda">
                        <p style="color:#4e6b55">Poda estructural para mejorar ventilación y luminosidad.</p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
