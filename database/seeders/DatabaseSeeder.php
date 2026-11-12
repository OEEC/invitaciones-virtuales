<?php

namespace Database\Seeders;

use App\Models\Template;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(['email' => 'admin@invitaciones.test'], [
            'name' => 'Admin',
            'password' => bcrypt('admin1234'),
        ]);

        // Tipos: text, textarea, datetime-local, url, list, repeater, image, images, audio
        $f = fn ($type, $key, $label, $extra = []) => ['type' => $type, 'key' => $key, 'label' => $label] + $extra;
        $sec = fn ($label) => ['type' => 'section', 'label' => $label];

        Template::updateOrCreate(['slug' => 'boda'], [
            'name' => 'Boda', 'event_type' => 'boda', 'view' => 'templates.boda',
            'fields' => [
                $sec('Los novios'),
                $f('text', 'novio', 'Nombre del novio'),
                $f('text', 'novia', 'Nombre de la novia'),
                $f('image', 'foto_hero', 'Foto principal'),
                $f('audio', 'musica', 'Canción (mp3)'),
                $f('text', 'musica_titulo', 'Título de la canción'),
                $sec('Recepción'),
                $f('datetime-local', 'fecha', 'Fecha y hora'),
                $f('text', 'lugar', 'Lugar'),
                $f('text', 'direccion', 'Dirección'),
                $f('text', 'telefono', 'Teléfono del lugar'),
                $f('url', 'mapa_url', 'Enlace del mapa'),
                $f('url', 'estacionamiento_url', 'Enlace del estacionamiento'),
                $sec('Confirmación'),
                $f('text', 'whatsapp', 'WhatsApp para confirmar (con lada, sin +)'),
                $f('text', 'fecha_limite', 'Fecha límite para confirmar'),
                $sec('Textos'),
                $f('list', 'frases', 'Frases bajo las fotos decorativas'),
                $f('list', 'poema', 'Poema (un párrafo por línea)'),
                $f('textarea', 'regalo', 'Mensaje de regalos'),
                $sec('Vestimenta'),
                $f('text', 'formalidad', 'Formalidad'),
                $f('textarea', 'nota_vestimenta', 'Nota de vestimenta'),
                $f('repeater', 'colores_evitar', 'Colores a evitar', ['sub' => [
                    ['key' => 'nombre', 'label' => 'Nombre', 'type' => 'text'],
                    ['key' => 'hex', 'label' => 'Color', 'type' => 'color'],
                ]]),
                $sec('Itinerario'),
                $f('repeater', 'itinerario', 'Eventos de la noche', ['sub' => [
                    ['key' => 'hora', 'label' => 'Hora', 'type' => 'text'],
                    ['key' => 'titulo', 'label' => 'Título', 'type' => 'text'],
                    ['key' => 'desc', 'label' => 'Descripción', 'type' => 'text'],
                    ['key' => 'icono', 'label' => 'Icono (clase Font Awesome)', 'type' => 'text'],
                ]]),
                $sec('Fotos'),
                $f('images', 'imagenes_decorativas', 'Fotos decorativas (5)'),
                $f('images', 'galeria', 'Galería'),
            ],
        ]);
        Template::updateOrCreate(['slug' => 'xv-anos'], [
            'name' => 'XV Años', 'event_type' => 'xv', 'view' => 'templates.xv',
            'fields' => [
                $f('text', 'nombre', 'Nombre de la quinceañera'), $f('datetime-local', 'fecha', 'Fecha y hora'),
                $f('text', 'lugar', 'Lugar'), $f('text', 'whatsapp', 'WhatsApp para confirmar'),
            ],
        ]);
        Template::updateOrCreate(['slug' => 'cumpleanos'], [
            'name' => 'Cumpleaños', 'event_type' => 'cumpleanos', 'view' => 'templates.cumpleanos',
            'fields' => [
                $f('text', 'nombre', 'Festejado(a)'), $f('text', 'edad', 'Años que cumple'),
                $f('datetime-local', 'fecha', 'Fecha y hora'), $f('text', 'lugar', 'Lugar'),
                $f('text', 'whatsapp', 'WhatsApp para confirmar'),
            ],
        ]);
    }
}