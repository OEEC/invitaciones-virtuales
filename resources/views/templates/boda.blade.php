@php
    $m = fn ($p) => str_starts_with($p, 'invitations/') ? \Illuminate\Support\Facades\Storage::url($p) : asset('templates/boda/'.$p);
    $f = \Carbon\Carbon::parse($d['fecha'])->locale('es');
    $fechaLarga = $f->translatedFormat('j \d\e F \d\e Y');
    $fechaCorta = mb_strtoupper(str_replace('.', '', $f->translatedFormat('j \D\E M Y')));
    $fechaDia = ucfirst($f->translatedFormat('l, j \d\e F \d\e Y'));
    $hora = $f->format('H:i');
    $anio = $f->year;
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $d['novio'] }} & {{ $d['novia'] }} - {{ $fechaLarga }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('templates/boda') }}/img/icons/skull.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fleur+De+Leah&family=Kings&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="{{ asset('templates/boda') }}/css/style.css" rel="stylesheet">
    <style>.hero-image { background-image: url('{{ $m($d['foto_hero']) }}'); }</style>
</head>
<body>
        <!-- Decoración otoñal -->
    <div class="falling-background"></div>
        <!-- Hero Section con imagen centrada -->
    <section class="hero" id="inicio">
        <div class="hero-image-container">
            <div class="hero-image"></div>
            <div class="hero-content">
                <h1 class="hero-title fleur-de-leah-regular">{{ $d['novio'] }} <span class="amp">&</span> {{ $d['novia'] }}</h1>
                <div class="hero-date kings-regular">{{ $fechaCorta }}</div>
            </div>
        </div>
    </section>
        <!-- Boton musica -->
    <section class="music-button-section">
        <h1 class="kings-regular" style="font-size: 2rem;">Escucha una de las canciones más especiales para nosotros</h1>
        <div class="buttons-container">
            <div class="music-option">
                <div class="botón" id="botón1">
                    <div class="fondo" x="0" y="0" width="200" height="200"></div>
                    <div class="icono" width="200" height="200">
                        <div class="parte izquierda" x="0" y="0" fill="#fff"></div>
                        <div class="parte derecha" x="0" y="0" fill="#fff"></div>
                    </div>
                    <div class="puntero"></div>
                </div>
                <p class="kings-regular music-label">{{ $d['musica_titulo'] }}</p>
            </div>
        </div>
    </section>
    <div class="leaf-divider">
        <hr>
        <span class="leaves">🍁 🍂 🍁</span>
        <hr>
    </div>
    <!--img decortativa 1 -->
    <section class="imagen-section">
        <div class="image-container">
            <img src="{{ $m($d['imagenes_decorativas'][0] ?? '') }}" 
                 alt="Corazón decorativo" 
                 class="section-image">
        </div>
        <!-- Texto agregado debajo de la imagen - CORREGIDO -->
        <h2 class="kings-regular image-caption">{{ $d['frases'][0] ?? '' }}</h2>
    </section>
    <!-- Navbar - CORREGIDA -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="#inicio" class="navbar-logo">{{ $d['novio'] }} & {{ $d['novia'] }}</a>
            <button class="navbar-toggle" id="navbar-toggle">&#9776;</button>

            <ul class="nav-menu" id="nav-menu">
                <li><a href="#cuenta-regresiva">Cuenta Regresiva</a></li>
                <li><a href="#poema">Poema</a></li>
                <li><a href="#recepcion">Recepción</a></li>
                <li><a href="#vestimenta">Vestimenta</a></li>
                <li><a href="#itinerario">Itinerario</a></li>
                <li><a href="#galeria">Galería</a></li>
                <li><a href="#confirmacion">Confirmar</a></li>
            </ul>
        </div>
    </nav>
    <div class="leaf-divider">
        <hr>
        <span class="leaves">🍁 🍂 🍁</span>
        <hr>
    </div>
    <!-- Countdown Section -->
    <section class="section" id="cuenta-regresiva">
        <div class="container">
            <div class="section-title">
                <h2>Cuenta Regresiva</h2>
                <p>Faltan pocos días para nuestro gran momento</p>
            </div>
            <div class="countdown">
                <div class="countdown-item">
                    <div class="countdown-number" id="days">00</div>
                    <div class="countdown-label">Días</div>
                </div>
                <div class="countdown-item">
                    <div class="countdown-number" id="hours">00</div>
                    <div class="countdown-label">Horas</div>
                </div>
                <div class="countdown-item">
                    <div class="countdown-number" id="minutes">00</div>
                    <div class="countdown-label">Minutos</div>
                </div>
                <div class="countdown-item">
                    <div class="countdown-number" id="seconds">00</div>
                    <div class="countdown-label">Segundos</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Poema section-->
    <section class="section poema-section" id="poema">
        <div class="container">
            <div class="img-poem">
                <img src="{{ asset('templates/boda') }}/img/poema.png" alt="Poema de amor">
            </div>
            <div class="poema-text kings-regular">
                @foreach ($d['poema'] as $p)<p>{{ $p }}</p>@endforeach
            </div>
        </div>
    </section>
    <div class="leaf-divider">
        <hr>
        <span class="leaves">🍁 🍂 🍁</span>
        <hr>
    </div>
    <!--img decortativa 2 -->
    <section class="imagen-section">
        <div class="image-container">
            <img src="{{ $m($d['imagenes_decorativas'][1] ?? '') }}" 
                 alt="Corazón decorativo" 
                 class="section-image">
        </div>
        <!-- Texto agregado debajo de la imagen - CORREGIDO -->
        <h2 class="kings-regular image-caption">{{ $d['frases'][1] ?? '' }}</h2>
    </section>
    <div class="leaf-divider">
        <hr>
        <span class="leaves">🍁 🍂 🍁</span>
        <hr>
    </div>
    <!-- Reception Section -->
    <section class="section" id="recepcion">
        <div class="container">
            <div class="section-title">
                <h2>La Recepción</h2>
                <p>Detalles de nuestra celebración</p>
            </div>
            <div class="reception-container">
                <div class="reception-image">
                    <img src="https://images.unsplash.com/photo-1511795409834-ef04bbd61622?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2069&q=80" alt="Lugar de la recepción">
                </div>
                <div class="reception-details">
                    <h3>{{ $d['lugar'] }}</h3>
                    <p><i class="fas fa-calendar-alt reception-icon"></i> {{ $fechaDia }}</p>
                    <p><i class="fas fa-clock reception-icon"></i> {{ $hora }} horas</p>
                    <p><i class="fas fa-map-marker-alt reception-icon"></i> {{ $d['direccion'] }}</p>
                    <p><i class="fas fa-phone reception-icon"></i> {{ $d['telefono'] }}</p>
                    <a href="{{ $d['mapa_url'] }}" class="map-btn" target="_blank">Ver mapa del salon</a>
                    <a href="{{ $d['estacionamiento_url'] }}" class="park-map-btn" target="_blank"> Ver Mapa de estacionamiento</a>
                </div>
            </div>
        </div>
    </section>
    <div class="leaf-divider">
        <hr>
        <span class="leaves">🍁 🍂 🍁</span>
        <hr>
    </div>
        <!--img decortativa 2 -->
    <section class="imagen-section">
        <div class="image-container">
            <img src="{{ $m($d['imagenes_decorativas'][2] ?? '') }}" 
                 alt="Corazón decorativo" 
                 class="section-image">
        </div>
        <!-- Texto agregado debajo de la imagen - CORREGIDO -->
        <h2 class="kings-regular image-caption">{{ $d['frases'][2] ?? '' }}</h2>
    </section>
    <div class="leaf-divider">
        <hr>
        <span class="leaves">🍁 🍂 🍁</span>
        <hr>
    </div>

    <!-- Dress Code Section -->
    <section class="section dress-code" id="vestimenta">
        <div class="container">
            <div class="section-title">
                <h2>Código de Vestimenta</h2>
                <p>Por favor, <b>evita</b> los siguientes colores:</p>
            </div>
            <div class="colors-container">
                @foreach ($d['colores_evitar'] as $c)
                <div class="color-card">
                    <div class="color-sample" style="background-color: {{ $c['hex'] }};"></div>
                    <div class="color-name">{{ $c['nombre'] }}</div>
                </div>
                @endforeach
            </div>
            <div class="dress-code-note">
            <p><strong>Formalidad:</strong> {{ $d['formalidad'] }}</p>
            <p><strong>Nota:</strong> {{ $d['nota_vestimenta'] }}</p>
            </div>
        </div>
    </section>
    <div class="leaf-divider">
        <hr>
        <span class="leaves">🍁 🍂 🍁</span>
        <hr>
    </div>
    <!--img decortativa 3 -->
    <section class="imagen-section">
        <div class="image-container">
            <img src="{{ $m($d['imagenes_decorativas'][3] ?? '') }}" 
                 alt="Corazón decorativo" 
                 class="section-image">
        </div>
        <!-- Texto agregado debajo de la imagen - CORREGIDO -->
        <h2 class="kings-regular image-caption">{{ $d['frases'][3] ?? '' }}</h2>
    </section>
    <div class="leaf-divider">
        <hr>
        <span class="leaves">🍁 🍂 🍁</span>
        <hr>
    </div>
    <!-- Itinerary Section -->
    <section class="section" id="itinerario">
        <div class="container">
            <div class="section-title">
                <h2>Itinerario de la Noche</h2>
                <p>Minuto a minuto de nuestra celebración</p>
            </div>
            <div class="timeline">
                @foreach ($d['itinerario'] as $it)
                <div class="timeline-item">
                    <div class="timeline-content">
                        <div class="timeline-time">
                            @if (!empty($it['img']))<img src="{{ asset('templates/boda/'.$it['img']) }}" width="25" height="25" style="padding-top: 2px;">
                            @else<i class="{{ $it['icono'] ?? 'fas fa-star' }}" style="padding-right: 10px;"></i>@endif
                            {{ $it['hora'] }}
                        </div>
                        <h4>{{ $it['titulo'] }}</h4>
                        <p>{{ $it['desc'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="section" id="galeria">
        <div class="container">
            <div class="section-title">
                <h2>Nuestros Momentos</h2>
                <p>Algunas fotos especiales de nuestro camino juntos</p>
            </div>
            <div class="gallery-grid">
                @foreach ($d['galeria'] as $foto)
                <div class="gallery-item">
                    <img src="{{ $m($foto) }}" alt="Foto {{ $loop->iteration }}">
                </div>
                @endforeach
            </div>
        </div>
    </section>
        <div class="leaf-divider">
        <hr>
        <span class="leaves">🍁 🍂 🍁</span>
        <hr>
    </div>
    <!--img decortativa 3 -->
    <section class="imagen-section">
        <div class="image-container">
            <img src="{{ $m($d['imagenes_decorativas'][4] ?? '') }}" 
                 alt="Corazón decorativo" 
                 class="section-image">
        </div>
        <!-- Texto agregado debajo de la imagen - CORREGIDO -->
        <h2 class="kings-regular image-caption">{{ $d['frases'][4] ?? '' }}</h2>
    </section>
    <div class="leaf-divider">
        <hr>
        <span class="leaves">🍁 🍂 🍁</span>
        <hr>
    </div>
        <section class="section poema-section" id="buzon">
        <div class="container">
            <div class="poema-text kings-regular">
                <p>{{ $d['regalo'] }}</p>
            </div>
            <div class="img-poem">
                <img src="{{ asset('templates/boda') }}/img/buzon.png" alt="buzonr">
            </div>
        </div>
    </section>

    <!-- Confirmation Form -->
    <section class="section" id="confirmacion">
    <div class="container">
        <div class="section-title">
        <h2>Confirmar Asistencia</h2>
        <p>Por favor, confirma tu presencia antes del {{ $d['fecha_limite'] }}</p>
        </div>
        <div class="form-container">
        @if ($guest)
            <style>
                .form-group select, .form-group textarea { width:100%; padding:12px 15px; border:1px solid #ddd; border-radius:5px; font-family:inherit; font-size:1rem; }
                .rsvp-ok { text-align:center; padding:10px 0; }
            </style>
            @if (session('rsvp_ok'))<p class="rsvp-ok"><strong>¡Gracias, {{ $guest->name }}! Tu respuesta quedó registrada.</strong></p>@endif
            @if ($guest->rsvp !== 'pending' && !session('rsvp_ok'))
                <p class="rsvp-ok">Ya respondiste: <strong>{{ $guest->rsvp === 'yes' ? 'Sí asistiré' : 'No podré asistir' }}</strong>. Puedes cambiarla abajo.</p>
            @endif
            <form method="POST" action="{{ route('invitation.rsvp', [$invitation->slug, $guest->token]) }}">
                @csrf
                <p style="margin-bottom:15px;">Hola <strong>{{ $guest->name }}</strong>, ¿nos acompañas?</p>
                <div class="form-group">
                    <label for="rsvp">Tu respuesta *</label>
                    <select id="rsvp" name="rsvp" required>
                        <option value="yes" @selected($guest->rsvp === 'yes')>¡Sí, ahí estaré!</option>
                        <option value="no" @selected($guest->rsvp === 'no')>No podré asistir</option>
                    </select>
                </div>
                @if ($guest->max_companions > 0)
                <div class="form-group">
                    <label for="companions">Acompañantes (máximo {{ $guest->max_companions }})</label>
                    <select id="companions" name="companions">
                        @for ($i = 0; $i <= $guest->max_companions; $i++)<option value="{{ $i }}" @selected($guest->companions === $i)>{{ $i }}</option>@endfor
                    </select>
                </div>
                @endif
                <div class="form-group">
                    <label for="message">Mensaje para los novios <span class="optional">(opcional)</span></label>
                    <textarea id="message" name="message" rows="3">{{ $guest->message }}</textarea>
                </div>
                <button type="submit" class="form-submit">Enviar respuesta</button>
            </form>
        @else
        <form id="confirmationForm">
            <div class="form-group">
            <label for="name">Tu nombre completo *</label>
            <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
            <label for="companion">Nombre de tu acompañante <span class="optional">(opcional)</span></label>
            <input type="text" id="companion" name="companion">
            </div>

            <div class="form-group">
            <label for="phone">Tu número de teléfono *</label>
            <input type="tel" id="phone" name="phone" required>
            </div>

            <button type="submit" class="form-submit">Confirmar Asistencia por WhatsApp</button>
        </form>
        @endif
        </div>
    </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-hearts">
                ❤ ❤ ❤
            </div>
            <p class="footer-text">Con amor, {{ $d['novio'] }} y {{ $d['novia'] }}</p>
            <p>{{ $fechaLarga }} · {{ $d['lugar'] }}</p>
            <div class="copyright">
                &copy; {{ $anio }} {{ $d['novio'] }} & {{ $d['novia'] }} · Todos los derechos reservados
            </div>
        </div>
    </footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/howler/2.2.3/howler.min.js"></script>
    <script>
    window.INVITACION = {
        novio: @json($d['novio']),
        novia: @json($d['novia']),
        fecha: @json($d['fecha']),
        whatsapp: @json($d['whatsapp']),
        musica: @json($m($d['musica'])),
    };
    </script>
    <script src="{{ asset('templates/boda/js/index.js') }}"></script>
</body>
</html>


