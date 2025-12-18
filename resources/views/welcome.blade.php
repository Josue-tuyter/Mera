<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Finca Cacao') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <style>
            :root{--bg:#FDFDFC;--text:#1b1b18;--accent:#6B3E26}
            body{font-family:Instrument Sans,system-ui,-apple-system,Segoe UI,Roboto,"Helvetica Neue",Arial;margin:0;background:var(--bg);color:var(--text);-webkit-font-smoothing:antialiased}
            .container{max-width:1100px;margin:0 auto;padding:24px}
            .flex{display:flex}
            .items-center{align-items:center}
            .justify-between{justify-content:space-between}
            .btn{background:var(--accent);color:#fff;padding:10px 16px;border-radius:6px;text-decoration:none;display:inline-block}
            .btn-outline{background:transparent;border:1px solid var(--accent);color:var(--accent);padding:8px 14px;border-radius:6px;text-decoration:none}
            .hero{display:flex;gap:24px;align-items:center}
            .card{background:#fff;padding:18px;border-radius:10px;box-shadow:0 8px 24px rgba(11,10,9,0.04)}
            h1,h2,h3,h4{margin:0}
            p{margin:12px 0;color:#565656}
            @media (max-width:800px){.hero{flex-direction:column}}
        </style>
    </head>
    <body>
        <header class="container">
            <div class="flex items-center justify-between">
                <div>
                    <h2 style="margin:0;color:var(--accent);font-weight:700">Finca Cacao</h2>
                    <div style="font-size:13px;color:#6b6b6b">Cultivo, tradición y sostenibilidad</div>
                </div>
                <nav class="flex items-center" style="gap:12px">
                    <a href="#inicio" class="btn-outline">Inicio</a>
                    <a href="#nosotros" class="btn-outline">Nosotros</a>
                    <a href="http://127.0.0.1:8000/admin/login" class="btn">Login</a>
                </nav>
            </div>
        </header>

        <main class="container" id="inicio" style="padding-top:20px">
            <section class="hero">
                <div style="flex:1">
                    <h1 style="font-size:36px;line-height:1.05">Las labores culturales del cacao</h1>
                    <div style="font-size:16px;color:#6b6b6b;margin-top:6px">Prácticas tradicionales y técnicas modernas para un cacao de calidad</div>
                    <p>En nuestra finca combinamos conocimiento ancestral y buenas prácticas agrícolas para producir granos de cacao excepcionales. A continuación resumimos las labores culturales que realizamos durante el ciclo productivo.</p>

                    <div style="margin-top:12px">
                        <a href="#que-hacemos" class="btn" style="margin-right:8px">Qué hacemos</a>
                        <a href="#mapa" class="btn-outline">Ver mapa</a>
                    </div>
                </div>

                <div style="width:360px">
                    <div class="card">
                        <img src="https://images.unsplash.com/photo-1501004318641-b39e6451bec6?auto=format&fit=crop&w=900&q=60" alt="Cacao" style="width:100%;height:180px;object-fit:cover;border-radius:8px">
                        <h3 style="margin:12px 0 6px">Cosecha y calidad</h3>
                        <p style="margin:0;color:#6b6b6b;font-size:14px">Cosecha manual selectiva y procesos de fermentación y secado que garantizan aromas ricos y equilibrados.</p>
                    </div>
                </div>
            </section>

            <section id="que-hacemos" style="margin-top:28px">
                <h2>Labores culturales principales</h2>
                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:16px;margin-top:12px">
                    <div class="card">
                        <h4>Siembra y establecimiento</h4>
                        <p>Selección de plantones, preparación de suelos y control de sombra para un arranque vigoroso.</p>
                    </div>
                    <div class="card">
                        <h4>Poda y formación</h4>
                        <p>Poda estructural para mejorar la ventilación, luminosidad y sanidad del cultivo.</p>
                    </div>
                    <div class="card">
                        <h4>Manejo de plagas y enfermedades</h4>
                        <p>Monitoreo, control biológico y prácticas integradas para reducir impactos.</p>
                    </div>
                    <div class="card">
                        <h4>Fertilización y enmiendas</h4>
                        <p>Aplicaciones balanceadas basadas en análisis de suelo para mantener productividad.</p>
                    </div>
                    <div class="card">
                        <h4>Cosecha, fermentación y secado</h4>
                        <p>Cosecha manual, fermentación controlada y secado a temperatura adecuada para conservar calidad.</p>
                    </div>
                    <div class="card">
                        <h4>Postcosecha y trazabilidad</h4>
                        <p>Registro de lotes, trazabilidad y buenas prácticas de almacenamiento.</p>
                    </div>
                </div>
            </section>

            <section id="nosotros" style="margin-top:28px">
                <h2>Nuestra historia</h2>
                <p>Somos una finca familiar con décadas de experiencia en el cultivo del cacao. Trabajamos con comunidades locales, promovemos la sostenibilidad y buscamos mejorar continuamente la calidad de nuestros productos a través de prácticas respetuosas con el medio ambiente.</p>
            </section>

            <section id="mapa" style="margin-top:28px">
                <h2>Ubicación</h2>
                <p style="color:#6b6b6b;margin-bottom:8px">Mapa aproximado de la ubicación de la finca. Puedo integrar Google Maps si nos compartes la API key.</p>
                <div class="card">
                    <iframe width="100%" height="320" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.openstreetmap.org/export/embed.html?bbox=-76.0%2C-3.5%2C-74.0%2C-2.0&layer=mapnik&marker=-3.0,-75.0" style="border-radius:8px"></iframe>
                    <div style="font-size:12px;color:#999;margin-top:8px">Mapa: OpenStreetMap — ubicación aproximada</div>
                </div>
            </section>

            <footer style="margin-top:28px;padding:18px 0;color:#6b6b6b;text-align:center">
                <div>© {{ date('Y') }} Finca Cacao — Todos los derechos reservados</div>
                <div style="margin-top:8px"><a href="http://127.0.0.1:8000/admin/login" class="btn">Acceso administrador</a></div>
            </footer>
        </main>
    </body>
</html>
