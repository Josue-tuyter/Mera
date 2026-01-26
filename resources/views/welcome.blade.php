<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Finca Cacao') }}</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

        <style>
            :root{
                --bg1: #f7fff7; --bg2: #f0fff4; --text:#07321b; --muted:#4e6b55; --accent:#2f855a; --accent-2:#8bd3a9; --card:#ffffff;
                --glass: rgba(255,255,255,0.55);
            }
            *{box-sizing:border-box}
            body{font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,Arial;margin:0;background:linear-gradient(180deg,var(--bg1),var(--bg2));color:var(--text);-webkit-font-smoothing:antialiased;min-height:100vh}
            .container{max-width:1100px;margin:0 auto;padding:36px;position:relative;z-index:2}
            header .brand{display:flex;align-items:center;gap:12px}
            .logo{width:48px;height:48px;border-radius:10px;background:linear-gradient(135deg,var(--accent),var(--accent-2));display:grid;place-items:center;color:#fff;font-weight:700;box-shadow:0 6px 18px rgba(47,133,90,0.18)}
            nav a{margin-left:12px;text-decoration:none;color:var(--text);padding:8px 12px;border-radius:10px;font-weight:600}
            .btn{background:linear-gradient(90deg,var(--accent),#48bb78);color:#fff;padding:10px 18px;border-radius:12px;text-decoration:none;display:inline-block;box-shadow:0 10px 30px rgba(47,133,90,0.12);border:0}
            .btn-outline{background:transparent;border:1px solid rgba(47,133,90,0.12);color:var(--accent);padding:8px 14px;border-radius:12px;text-decoration:none}

            /* Hero */
            .hero{display:flex;gap:28px;align-items:center;margin-top:18px}
            .hero-left{flex:1}
            .eyebrow{display:inline-block;background:rgba(47,133,90,0.08);color:var(--accent);padding:6px 12px;border-radius:999px;font-weight:700;font-size:13px}
            h1{font-family:'Playfair Display',serif;font-size:40px;line-height:1.02;margin:12px 0}
            .lead{color:var(--muted);font-size:16px;margin-bottom:16px}
            .actions{display:flex;gap:10px;margin-top:14px}

            /* Visual card */
            .visual{width:380px;border-radius:16px;overflow:hidden;position:relative;box-shadow:0 30px 60px rgba(9,52,26,0.06)}
            .visual img{width:100%;height:250px;object-fit:cover;display:block;transform:scale(1);transition:transform .7s cubic-bezier(.2,.9,.2,1)}
            .visual:hover img{transform:scale(1.06)}
            .card-body{padding:18px;background:linear-gradient(180deg, rgba(255,255,255,0.8), rgba(255,255,255,0.6));backdrop-filter:blur(4px)}
            .kicker{display:inline-block;background:rgba(47,133,90,0.09);color:var(--accent);padding:6px 10px;border-radius:999px;font-weight:700;font-size:12px}

            /* Grid */
            .grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:18px;margin-top:22px}
            .feature{background:var(--card);padding:18px;border-radius:12px;border:1px solid rgba(12,40,20,0.04);box-shadow:0 6px 20px rgba(11,45,21,0.03);transition:transform .3s,box-shadow .3s}
            .feature:hover{transform:translateY(-6px);box-shadow:0 18px 40px rgba(11,45,21,0.06)}

            /* Floating shapes */
            .float-shape{position:fixed;pointer-events:none;z-index:0;filter:blur(22px);opacity:0.85}
            .shape1{width:360px;height:360px;left:-80px;top:-60px;background:radial-gradient(circle at 30% 30%, rgba(143,197,148,0.35), transparent 30%)}
            .shape2{width:300px;height:300px;right:-80px;bottom:-80px;background:radial-gradient(circle at 70% 70%, rgba(200,245,221,0.3), transparent 30%)}

            /* Footer */
            footer{margin-top:36px;padding:22px 0;color:var(--muted);text-align:center}

            /* Responsive */
            @media (max-width:900px){
                .hero{flex-direction:column}
                .visual{width:100%}
                header .container{padding:20px}
                h1{font-size:28px}
            }

            /* Small animation */
            .reveal{opacity:0;transform:translateY(10px);transition:opacity .6s ease,transform .6s ease}
            .reveal.active{opacity:1;transform:none}
        </style>
    </head>
    <body>
        <div class="float-shape shape1" aria-hidden></div>
        <div class="float-shape shape2" aria-hidden></div>

        <header>
            <div class="container">
                <div style="display:flex;align-items:center;justify-content:space-between;gap:12px">
                    <div class="brand">
                        <div class="logo">FC</div>
                        <div>
                            <div style="font-weight:700;color:var(--accent);font-size:18px">Finca Cacao</div>
                            <div style="font-size:13px;color:var(--muted)">Cultivo, tradición y sostenibilidad</div>
                        </div>
                    </div>
                    <nav style="display:flex;align-items:center">
                        <a href="{{ url('/') }}" class="btn-outline">Inicio</a>
                        <a href="{{ url('/historia') }}" class="btn-outline">Historia</a>
                        <a href="{{ url('/metodos') }}" class="btn-outline">Métodos</a>
                        <a href="#mapa" class="btn-outline">Mapa</a>
                        <a href="{{ url('/admin/login') }}" class="btn">Acceso</a>
                    </nav>
                </div>
            </div>
        </header>

        <main class="container" id="inicio">
            <section class="hero">
                <div class="hero-left">
                    <span class="eyebrow reveal">Sostenible • Local • Artesanal</span>
                    <h1 class="reveal">Labores culturales del cacao — tradición que se renueva</h1>
                    <div class="lead reveal">Combinamos prácticas ancestrales con técnicas modernas para producir granos de cacao con identidad y calidad.</div>

                    <div class="actions reveal">
                        <a href="#que-hacemos" class="btn">Descubrir</a>
                        <a href="#mapa" class="btn-outline">Ver mapa</a>
                    </div>
                </div>

                <aside class="visual card reveal" aria-hidden>
                    <img src="https://images.unsplash.com/photo-1501004318641-b39e6451bec6?auto=format&fit=crop&w=1200&q=60" alt="Cacao" loading="lazy">
                    <div class="card-body">
                        <div class="kicker">Hecho con cuidado</div>
                        <h3 style="margin:10px 0 6px">Cosecha y calidad</h3>
                        <p style="margin:0;color:var(--muted);font-size:14px">Cosecha manual selectiva, fermentación controlada y secado para aromas equilibrados.</p>
                    </div>
                </aside>
            </section>

            <section id="que-hacemos" style="margin-top:26px">
                <h2 class="reveal">Labores culturales principales</h2>
                <div class="grid">
                    <div class="feature reveal">
                        <h4>Siembra y establecimiento</h4>
                        <p style="margin-top:8px;color:var(--muted)">Selección de plantones, preparación de suelos y manejo de sombra.</p>
                    </div>
                    <div class="feature reveal">
                        <h4>Poda y formación</h4>
                        <p style="margin-top:8px;color:var(--muted)">Poda estructural para mejorar ventilación y sanidad del cultivo.</p>
                    </div>
                    <div class="feature reveal">
                        <h4>Manejo integrado</h4>
                        <p style="margin-top:8px;color:var(--muted)">Monitoreo y control biológico para reducir impactos ambientales.</p>
                    </div>
                    <div class="feature reveal">
                        <h4>Fertilización</h4>
                        <p style="margin-top:8px;color:var(--muted)">Aplicaciones basadas en análisis para mantener productividad sostenible.</p>
                    </div>
                    <div class="feature reveal">
                        <h4>Postcosecha</h4>
                        <p style="margin-top:8px;color:var(--muted)">Fermentación y secado controlado para conservar perfiles de aroma.</p>
                    </div>
                    <div class="feature reveal">
                        <h4>Trazabilidad</h4>
                        <p style="margin-top:8px;color:var(--muted)">Registro de lotes y buenas prácticas de almacenamiento.</p>
                    </div>
                </div>
            </section>

            <section id="galeria" style="margin-top:28px">
                <h2 class="reveal">Galería</h2>
                <p style="color:var(--muted);margin-bottom:12px">Imágenes reales de la finca y nuestras labores.</p>
                <div class="grid" style="grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:14px">
                    <div class="feature reveal" style="padding:0;overflow:hidden;">
                        <img src="https://images.unsplash.com/photo-1501004318641-b39e6451bec6?auto=format&fit=crop&w=800&q=60" alt="Cacao 1" style="width:100%;height:160px;object-fit:cover;transition:transform .6s;display:block">
                    </div>
                    <div class="feature reveal" style="padding:0;overflow:hidden;">
                        <img src="https://images.unsplash.com/photo-1524594154904-cc29446f8e1b?auto=format&fit=crop&w=800&q=60" alt="Cacao 2" style="width:100%;height:160px;object-fit:cover;transition:transform .6s;display:block">
                    </div>
                    <div class="feature reveal" style="padding:0;overflow:hidden;">
                        <img src="https://images.unsplash.com/photo-1506806732259-39c2d0268443?auto=format&fit=crop&w=800&q=60" alt="Cacao 3" style="width:100%;height:160px;object-fit:cover;transition:transform .6s;display:block">
                    </div>
                    <div class="feature reveal" style="padding:0;overflow:hidden;">
                        <img src="https://images.unsplash.com/photo-1472220625704-91e1462799b2?auto=format&fit=crop&w=800&q=60" alt="Cacao 4" style="width:100%;height:160px;object-fit:cover;transition:transform .6s;display:block">
                    </div>
                </div>
            </section>

                <section id="mapa" style="margin-top:28px">
                    <h2 class="reveal">Ubicación</h2>
                    <p style="color:var(--muted);margin-bottom:8px">Ecuentranos en <strong>El Triunfo, Guayas, Ecuador</strong>.</p>
                    <div id="map-wrap" style="border-radius:12px;overflow:hidden;border:1px solid rgba(12,40,20,0.03);min-height:340px;display:grid;place-items:center;background:linear-gradient(180deg,rgba(255,255,255,0.6),transparent);">
                        <div id="map-loading" style="color:var(--muted);padding:18px">Buscando ubicación de <strong>El Triunfo, Guayas, Ecuador</strong>…</div>
                    </div>

                    <script>
                        (function(){
                            const wrap = document.getElementById('map-wrap');
                            const loading = document.getElementById('map-loading');
                            const query = 'El Triunfo, Guayas, Ecuador';

                            // Use Nominatim to geocode the locality
                            fetch('https://nominatim.openstreetmap.org/search?format=json&limit=1&q=' + encodeURIComponent(query))
                            .then(r => r.json())
                            .then(results => {
                                if(!results || !results.length) throw new Error('No encontrado');
                                const lat = parseFloat(results[0].lat);
                                const lon = parseFloat(results[0].lon);

                                // Small bbox around the point
                                const delta = 0.06; // ~6km box, adjust if needed
                                const left = (lon - delta).toFixed(6);
                                const bottom = (lat - delta).toFixed(6);
                                const right = (lon + delta).toFixed(6);
                                const top = (lat + delta).toFixed(6);

                                const src = 'https://www.openstreetmap.org/export/embed.html?bbox=' + left + '%2C' + bottom + '%2C' + right + '%2C' + top + '&layer=mapnik&marker=' + lat + '%2C' + lon;

                                const iframe = document.createElement('iframe');
                                iframe.width = '100%';
                                iframe.height = '340';
                                iframe.frameBorder = '0';
                                iframe.scrolling = 'no';
                                iframe.marginHeight = '0';
                                iframe.marginWidth = '0';
                                iframe.style.display = 'block';
                                iframe.src = src;

                                // Replace loading with iframe
                                wrap.innerHTML = '';
                                wrap.appendChild(iframe);
                            })
                            .catch(err => {
                                loading.textContent = 'No se pudo obtener la ubicación automáticamente. Puedes buscarla manualmente.';
                                console.warn('Geocoding error:', err);
                            });
                        })();
                    </script>
                </section>

            <footer>
                <div>© {{ date('Y') }} Finca Cacao — Todos los derechos reservados</div>
                <div style="margin-top:8px"><a href="{{ url('/admin/login') }}" class="btn">Acceso administrador</a></div>
            </footer>
        </main>

        <script>
            // Small reveal-on-scroll
            function revealOnScroll(){
                document.querySelectorAll('.reveal').forEach(el=>{
                    const rect = el.getBoundingClientRect();
                    if(rect.top < window.innerHeight - 60){ el.classList.add('active'); }
                });
            }
            window.addEventListener('scroll', revealOnScroll);
            window.addEventListener('load', () => { revealOnScroll(); });
        </script>
    </body>
</html>
