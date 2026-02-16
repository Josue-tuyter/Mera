<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Los Mera - Finca de Cacao Fino de Aroma</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg1: #f7fff7;
            --bg2: #f0fff4;
            --text: #07321b;
            --muted: #4e6b55;
            --accent: #2f855a;
            --accent-2: #8bd3a9;
            --cacao: #713600;
            --card: #ffffff;
            --glass: rgba(255,255,255,0.65);
        }
        * { box-sizing: border-box; }
        body {
            font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
            margin: 0;
            background: linear-gradient(180deg, var(--bg1), var(--bg2));
            color: var(--text);
            -webkit-font-smoothing: antialiased;
            min-height: 100vh;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 36px 20px;
            position: relative;
            z-index: 2;
        }
        header .brand {
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .logo {
            width: 54px;
            height: 54px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            display: grid;
            place-items: center;
            color: white;
            font-weight: 700;
            font-size: 1.4rem;
            box-shadow: 0 6px 18px rgba(47,133,90,0.25);
        }
        nav a {
            margin-left: 16px;
            text-decoration: none;
            color: var(--text);
            padding: 10px 16px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.2s;
        }
        nav a:hover {
            background: rgba(47,133,90,0.08);
        }
        .btn {
            background: linear-gradient(90deg, var(--accent), #48bb78);
            color: white;
            padding: 12px 24px;
            border-radius: 14px;
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 10px 30px rgba(47,133,90,0.18);
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 40px rgba(47,133,90,0.25);
        }
        .btn-outline {
            background: transparent;
            border: 1px solid rgba(47,133,90,0.2);
            color: var(--accent);
            padding: 10px 18px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
        }

        /* Hero */
        .hero {
            display: flex;
            gap: 32px;
            align-items: center;
            margin-top: 24px;
            flex-wrap: wrap;
        }
        .hero-left {
            flex: 1;
            min-width: 300px;
        }
        .eyebrow {
            display: inline-block;
            background: rgba(47,133,90,0.1);
            color: var(--accent);
            padding: 8px 16px;
            border-radius: 999px;
            font-weight: 700;
            font-size: 14px;
        }
        h1 {
            font-family: 'Playfair Display', serif;
            font-size: 3.2rem;
            line-height: 1.05;
            margin: 16px 0;
            color: var(--cacao);
        }
        .lead {
            color: var(--muted);
            font-size: 1.1rem;
            margin-bottom: 24px;
            line-height: 1.6;
        }
        .actions {
            display: flex;
            gap: 16px;
            margin-top: 24px;
        }

        /* Visual card */
        .visual {
            width: 420px;
            border-radius: 20px;
            overflow: hidden;
            position: relative;
            box-shadow: 0 30px 60px rgba(9,52,26,0.12);
            min-width: 380px;
        }
        .visual img {
            width: 100%;
            height: 320px;
            object-fit: cover;
            transition: transform 0.8s cubic-bezier(0.2,0.9,0.2,1);
        }
        .visual:hover img {
            transform: scale(1.08);
        }
        .card-body {
            padding: 20px;
            background: linear-gradient(180deg, rgba(255,255,255,0.85), rgba(255,255,255,0.65));
            backdrop-filter: blur(6px);
        }
        .kicker {
            display: inline-block;
            background: rgba(47,133,90,0.12);
            color: var(--accent);
            padding: 6px 14px;
            border-radius: 999px;
            font-weight: 700;
            font-size: 13px;
        }

        /* Grid */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-top: 24px;
        }
        .feature {
            background: var(--card);
            padding: 20px;
            border-radius: 16px;
            border: 1px solid rgba(12,40,20,0.05);
            box-shadow: 0 8px 24px rgba(11,45,21,0.04);
            transition: all 0.3s ease;
        }
        .feature:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 48px rgba(11,45,21,0.08);
        }

        /* Galería */
        .gallery-grid {
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
        }
        .gallery-item img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 12px;
            transition: transform 0.5s;
        }
        .gallery-item:hover img {
            transform: scale(1.06);
        }

        /* Floating shapes */
        .float-shape {
            position: fixed;
            pointer-events: none;
            z-index: 0;
            filter: blur(28px);
            opacity: 0.7;
        }
        .shape1 {
            width: 400px;
            height: 400px;
            left: -100px;
            top: -80px;
            background: radial-gradient(circle at 30% 30%, rgba(143,197,148,0.4), transparent 40%);
        }
        .shape2 {
            width: 350px;
            height: 350px;
            right: -100px;
            bottom: -100px;
            background: radial-gradient(circle at 70% 70%, rgba(200,245,221,0.35), transparent 40%);
        }

        /* Responsive */
        @media (max-width: 900px) {
            .hero { flex-direction: column; }
            .visual { width: 100%; min-width: auto; }
            h1 { font-size: 2.5rem; }
            .actions { flex-direction: column; }
        }

        /* Reveal animation */
        .reveal {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }
        .reveal.active {
            opacity: 1;
            transform: none;
        }
    </style>
</head>
<body>
    <div class="float-shape shape1" aria-hidden></div>
    <div class="float-shape shape2" aria-hidden></div>

    <header>
        <div class="container">
            <div style="display:flex; align-items:center; justify-content:space-between; gap:16px; flex-wrap:wrap;">
                <div class="brand">
                    <div class="logo">LM</div>
                    <div>
                        <div style="font-weight:700; color:var(--cacao); font-size:22px;">Los Mera</div>
                        <div style="font-size:14px; color:var(--muted);">Finca de Cacao Fino de Aroma</div>
                    </div>
                </div>
                <nav style="display:flex; align-items:center; flex-wrap:wrap; gap:8px;">
                    <a href="{{ url('/') }}" class="btn-outline">Inicio</a>
                    <a href="{{ url('/historia') }}" class="btn-outline">Historia</a>
                    <a href="{{ url('/metodos') }}" class="btn-outline">Métodos</a>
                    <a href="#mapa" class="btn-outline">Mapa</a>
                    <a href="{{ url('/admin/login') }}" class="btn">Acceso Admin</a>
                </nav>
            </div>
        </div>
    </header>

    <main class="container" id="inicio">
        <section class="hero">
            <div class="hero-left">
                <span class="eyebrow reveal">Sostenible • Familiar • Artesanal</span>
                <h1 class="reveal">Labores culturales del cacao — tradición que se renueva</h1>
                <div class="lead reveal">
                    Combinamos prácticas ancestrales con técnicas modernas para producir granos de cacao fino de aroma con identidad y máxima calidad.
                </div>
                <div class="actions reveal">
                    <a href="#que-hacemos" class="btn">Descubrir</a>
                    <a href="#mapa" class="btn-outline">Ver ubicación</a>
                </div>
            </div>

            <aside class="visual card reveal" aria-hidden>
                <img src="{{ asset('images/imgs/img (2).jpeg') }}" alt="Mazorca de cacao en Los Mera" loading="lazy">
                <div class="card-body">
                    <div class="kicker">Cosecha selectiva</div>
                    <h3 style="margin:12px 0 8px; color:var(--cacao);">Calidad desde la planta</h3>
                    <p style="margin:0; color:var(--muted); font-size:15px;">
                        Mazorcas recolectadas a mano en nuestra finca en El Triunfo, Guayas.
                    </p>
                </div>
            </aside>
        </section>

        <section id="que-hacemos" style="margin-top:40px;">
            <h2 class="reveal" style="color:var(--cacao);">Labores culturales principales</h2>
            <div class="grid">
                <div class="feature reveal"><h4>Siembra y establecimiento</h4><p style="margin-top:10px;color:var(--muted);">Selección de plantones, preparación de suelos y manejo de sombra.</p></div>
                <div class="feature reveal"><h4>Poda y formación</h4><p style="margin-top:10px;color:var(--muted);">Poda estructural para mejorar ventilación y sanidad del cultivo.</p></div>
                <div class="feature reveal"><h4>Manejo integrado</h4><p style="margin-top:10px;color:var(--muted);">Monitoreo y control biológico para reducir impactos ambientales.</p></div>
                <div class="feature reveal"><h4>Fertilización</h4><p style="margin-top:10px;color:var(--muted);">Aplicaciones basadas en análisis para mantener productividad sostenible.</p></div>
                <div class="feature reveal"><h4>Postcosecha</h4><p style="margin-top:10px;color:var(--muted);">Fermentación y secado controlado para conservar perfiles de aroma.</p></div>
                <div class="feature reveal"><h4>Trazabilidad</h4><p style="margin-top:10px;color:var(--muted);">Registro de lotes y buenas prácticas de almacenamiento.</p></div>
            </div>
        </section>

        <section id="galeria" style="margin-top:48px;">
            <h2 class="reveal" style="color:var(--cacao);">Galería de la finca</h2>
            <p style="color:var(--muted); margin-bottom:16px;">Imágenes de nuestras labores culturales y la finca Los Mera.</p>
            <div class="grid gallery-grid">
                @for ($i = 1; $i <= 9; $i++)
                    <div class="gallery-item reveal" style="overflow:hidden; border-radius:12px; box-shadow:0 8px 24px rgba(0,0,0,0.08);">
                        <img 
                            src="{{ asset("images/imgs/img ($i).jpeg") }}" 
                            alt="Finca Los Mera - Imagen {{ $i }}" 
                            loading="lazy"
                        >
                    </div>
                @endfor
            </div>
        </section>

        <section id="mapa" style="margin-top:48px;">
            <h2 class="reveal" style="color:var(--cacao);">Ubicación</h2>
            <p style="color:var(--muted); margin-bottom:12px;">
                Nos encontramos en <strong>El Triunfo, Guayas, Ecuador</strong>.
            </p>
            <div id="map-wrap" style="border-radius:16px; overflow:hidden; border:1px solid rgba(12,40,20,0.06); min-height:400px; background:#f8fafc; box-shadow:0 10px 30px rgba(0,0,0,0.08);">
                <div id="map-loading" style="color:var(--muted); padding:24px; text-align:center;">
                    Cargando ubicación de El Triunfo, Guayas...
                </div>
            </div>

            <script>
                (function(){
                    const wrap = document.getElementById('map-wrap');
                    const loading = document.getElementById('map-loading');
                    const query = 'El Triunfo, Guayas, Ecuador';

                    fetch('https://nominatim.openstreetmap.org/search?format=json&limit=1&q=' + encodeURIComponent(query))
                        .then(r => r.json())
                        .then(results => {
                            if (!results || !results.length) throw new Error('No encontrado');
                            const lat = parseFloat(results[0].lat);
                            const lon = parseFloat(results[0].lon);

                            const delta = 0.08;
                            const left   = (lon - delta).toFixed(6);
                            const bottom = (lat - delta).toFixed(6);
                            const right  = (lon + delta).toFixed(6);
                            const top    = (lat + delta).toFixed(6);

                            const src = `https://www.openstreetmap.org/export/embed.html?bbox=${left}%2C${bottom}%2C${right}%2C${top}&layer=mapnik&marker=${lat}%2C${lon}`;

                            const iframe = document.createElement('iframe');
                            iframe.width = '100%';
                            iframe.height = '400';
                            iframe.frameBorder = '0';
                            iframe.scrolling = 'no';
                            iframe.style.border = 'none';
                            iframe.src = src;

                            wrap.innerHTML = '';
                            wrap.appendChild(iframe);
                        })
                        .catch(err => {
                            loading.innerHTML = 'No pudimos cargar el mapa automáticamente.<br>Busca "El Triunfo, Guayas" en Google Maps.';
                            console.warn('Error geocoding:', err);
                        });
                })();
            </script>
        </section>

        <footer style="margin-top:60px; padding:32px 0; text-align:center; color:var(--muted); border-top:1px solid rgba(47,133,90,0.1);">
            <div>© {{ date('Y') }} Finca Los Mera — Todos los derechos reservados</div>
            <div style="margin-top:12px;">
                <a href="{{ url('/admin/login') }}" class="btn">Acceso administrador</a>
            </div>
        </footer>
    </main>

    <script>
        function revealOnScroll() {
            document.querySelectorAll('.reveal').forEach(el => {
                const rect = el.getBoundingClientRect();
                if (rect.top < window.innerHeight - 80) {
                    el.classList.add('active');
                }
            });
        }
        window.addEventListener('scroll', revealOnScroll);
        window.addEventListener('load', revealOnScroll);
    </script>
</body>
</html>