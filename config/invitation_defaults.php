<?php

// Valores por defecto de cada plantilla (clave = slug de la plantilla).
// Lo que el editor guarde en invitations.data sobreescribe estos valores.
return [
    'boda' => [
        'foto_hero' => 'img/couple.png',
        'musica' => 'sound/todo_en_mi_vida.mp3',
        'imagenes_decorativas' => ['img/fuente1.jpg', 'img/baile.jpg', 'img/abrazo.jpg', 'img/anillo.jpg', 'img/caminando.jpg'],
        'galeria' => ['img/1.png', 'img/2.png', 'img/3.png', 'img/4.png'],
        'novio' => 'Oscar',
        'novia' => 'Sol',
        'fecha' => '2025-10-31T20:00',
        'lugar' => 'Quinta San Eduardo',
        'direccion' => 'Calz Cuauhtemoc 444, Tercero de Cobián Centro, Torreón, Coah.',
        'telefono' => '+52 871 713 1743',
        'mapa_url' => 'https://maps.app.goo.gl/8MoNTDikzoHW9xK86',
        'estacionamiento_url' => 'https://maps.app.goo.gl/v4Nk6JiEq96Yk7cv5',
        'whatsapp' => '528701692732',
        'fecha_limite' => '10 de octubre',
        'musica_titulo' => 'Nuestro vals',
        'formalidad' => 'Elegante de noche.',
        'nota_vestimenta' => 'Por favor evita los colores pastel, todos los demás colores están permitidos.',
        'regalo' => '"Su presencia es nuestro mejor regalo. Afortunadamente, tenemos todo en casa, pero si desean obsequiarnos algo, agradeceremos de corazón su apoyo para nuestra luna de miel. Podrán dejarlo en el buzón o mediante transferencia el dia de la boda."',
        'frases' => [
            'Estiro el brazo lo más lejos por tratar de no soltar tu mano y no quedarme atrás.',
            'Y bailar, como bailan la luna y el sol a escondidas en nuestro salón cuando nadie nos ve',
            'Comenzamos a soñar con un mundo entre los dos una extraña comunión entre la luna y el sol',
            'Corazón no hagas caso a la cordura, aunque tenga la razón si abres tus alas al viento, verás que este es el momento de escribir otro comienzo en el que estemos tú y yo',
            'De todos los caminos por seguir ¿Sabes? Yo te escojo a ti',
        ],
        'poema' => [
            '¡Oh, luna de octubre, tan llena de magia, tus ojos reflejan promesas que enlazan!',
            'Y el otoño eterno, el aura y la brisa, nos jura un amor sin prisa, que arde, que es fuerte, un amor más allá de la muerte.',
            '¡Oh, luna de octubre!, que caiga la noche, que el viento murmure, que el alma celebre lo que el amor jure.',
        ],
        'colores_evitar' => [
            ['nombre' => 'Verde militar', 'hex' => '#5D6532'],
            ['nombre' => 'Blanco', 'hex' => '#FFFFFF'],
            ['nombre' => 'Dorado', 'hex' => '#d4af37'],
            ['nombre' => 'Plateado', 'hex' => '#C0C0C0'],
        ],
        'itinerario' => [
            ['hora' => '20:00', 'icono' => 'fa-solid fa-people-group', 'titulo' => 'Llegada de invitados', 'desc' => 'Recepción de invitados para ceremonia'],
            ['hora' => '20:10', 'icono' => 'fa-solid fa-hands-praying', 'titulo' => 'Bendición y agradecimientos', 'desc' => 'Pequeña ceremonia de bendición'],
            ['hora' => '20:30', 'icono' => 'fas fa-ring', 'titulo' => 'Ceremonia', 'desc' => 'Ceremonia civil en jardín (firma de acta, votos)'],
            ['hora' => '21:00', 'icono' => 'fa-solid fa-door-open', 'titulo' => 'Entrada especial', 'desc' => 'Entrada de los novios a la recepción'],
            ['hora' => '21:10', 'img' => 'img/icons/first_dance.png', 'titulo' => 'Primer baile', 'desc' => 'Primer baile de los novios'],
            ['hora' => '21:30', 'icono' => 'fa-solid fa-champagne-glasses', 'titulo' => 'Brindis, Banquete y Pastel', 'desc' => 'Brindis de agradecimiento, cena y corte del pastel'],
            ['hora' => '22:30', 'icono' => 'fas fa-music', 'titulo' => 'Abrimos pista de Baile', 'desc' => 'Baile con todos'],
            ['hora' => '24:00', 'img' => 'img/icons/ramo.png', 'titulo' => 'Ramo y liga', 'desc' => 'Ramo y liga'],
            ['hora' => '24:15', 'icono' => 'fa-solid fa-icons', 'titulo' => 'Fiesta', 'desc' => 'Fiesta total hasta las 1:55 am'],
            ['hora' => '2:00', 'icono' => 'fa-solid fa-bed', 'titulo' => 'Despedida', 'desc' => 'Cierre de la fiesta'],
        ],
    ],
];