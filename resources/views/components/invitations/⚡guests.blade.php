<?php

use App\Models\Guest;
use App\Models\Invitation;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.admin')] class extends Component
{
    public Invitation $invitation;
    public string $name = '';
    public string $phone = '';
    public int $max_companions = 0;
    public string $bulk = '';
    public string $filter = 'all';

    public function mount(Invitation $invitation): void
    {
        $this->invitation = $invitation;
    }

    public function add(): void
    {
        $this->validate([
            'name' => 'required|min:2|max:120',
            'phone' => 'nullable|max:30',
            'max_companions' => 'required|integer|min:0|max:10',
        ]);
        $this->invitation->guests()->create([
            'name' => $this->name, 'phone' => preg_replace('/\D+/', '', $this->phone) ?: null,
            'max_companions' => $this->max_companions,
        ]);
        $this->reset('name', 'phone', 'max_companions');
    }

    // Una línea por invitado: "Nombre, teléfono, acompañantes"
    public function addBulk(): void
    {
        foreach (preg_split('/\r?\n/', $this->bulk) as $line) {
            $parts = array_map('trim', explode(',', $line));
            if (($parts[0] ?? '') === '') continue;
            $this->invitation->guests()->create([
                'name' => $parts[0],
                'phone' => isset($parts[1]) ? (preg_replace('/\D+/', '', $parts[1]) ?: null) : null,
                'max_companions' => min((int) ($parts[2] ?? 0), 10),
            ]);
        }
        $this->reset('bulk');
    }

    public function delete(int $id): void
    {
        $this->invitation->guests()->findOrFail($id)->delete();
    }

    public function link(Guest $g): string
    {
        return route('invitation.show', [$this->invitation->slug, $g->token]);
    }

    public function whatsapp(Guest $g): string
    {
        $text = "Hola {$g->name}, te compartimos tu invitación: ".$this->link($g);
        return 'https://wa.me/'.($g->phone ?? '').'?text='.rawurlencode($text);
    }

    public function with(): array
    {
        $all = $this->invitation->guests()->orderBy('name')->get();
        return [
            'guests' => $this->filter === 'all' ? $all : $all->where('rsvp', $this->filter),
            'total' => $all->count(),
            'yes' => $all->where('rsvp', 'yes')->count(),
            'no' => $all->where('rsvp', 'no')->count(),
            'pending' => $all->where('rsvp', 'pending')->count(),
            'attendees' => $all->where('rsvp', 'yes')->sum(fn ($g) => 1 + $g->companions),
        ];
    }
};
?>

<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('admin.invitations') }}" class="text-sm text-stone-500">← Invitaciones</a>
            <h1 class="text-xl font-semibold">Invitados · {{ $invitation->title }}</h1>
        </div>
        <a href="{{ route('admin.invitations.edit', $invitation) }}" class="text-sm text-amber-700">Editar invitación</a>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-5 gap-3 text-center">
        @foreach ([['Invitados', $total, 'all'], ['Confirmados', $yes, 'yes'], ['No asisten', $no, 'no'], ['Pendientes', $pending, 'pending']] as [$label, $n, $f])
            <button wire:click="$set('filter', '{{ $f }}')" class="bg-white rounded-xl shadow p-3 {{ $filter === $f ? 'ring-2 ring-amber-500' : '' }}">
                <div class="text-2xl font-semibold">{{ $n }}</div><div class="text-xs text-stone-500">{{ $label }}</div>
            </button>
        @endforeach
        <div class="bg-amber-50 rounded-xl shadow p-3">
            <div class="text-2xl font-semibold text-amber-700">{{ $attendees }}</div><div class="text-xs text-stone-500">Personas que asistirán</div>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-4">
        <form wire:submit="add" class="bg-white rounded-xl shadow p-4 space-y-3">
            <h2 class="font-medium">Agregar invitado</h2>
            <div>
                <input wire:model="name" placeholder="Nombre (o familia)" class="w-full border rounded px-3 py-2">
                @error('name')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div class="flex gap-2">
                <input wire:model="phone" placeholder="WhatsApp con lada (52…)" class="flex-1 border rounded px-3 py-2">
                <input wire:model="max_companions" type="number" min="0" max="10" title="Acompañantes permitidos" class="w-20 border rounded px-3 py-2">
            </div>
            <button class="bg-amber-600 hover:bg-amber-700 text-white rounded px-4 py-2">Agregar</button>
        </form>
        <form wire:submit="addBulk" class="bg-white rounded-xl shadow p-4 space-y-3">
            <h2 class="font-medium">Agregar varios</h2>
            <textarea wire:model="bulk" rows="3" placeholder="Una línea por invitado:&#10;Nombre, teléfono, acompañantes" class="w-full border rounded px-3 py-2 text-sm"></textarea>
            <button class="bg-stone-700 hover:bg-stone-800 text-white rounded px-4 py-2">Importar</button>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow divide-y">
        @forelse ($guests as $g)
            <div class="p-4 flex flex-wrap items-center justify-between gap-3" wire:key="g-{{ $g->id }}">
                <div>
                    <p class="font-medium">{{ $g->name }}
                        <span class="text-xs ml-1 px-2 py-0.5 rounded-full
                            {{ ['yes' => 'bg-green-100 text-green-700', 'no' => 'bg-red-100 text-red-700', 'pending' => 'bg-stone-100 text-stone-600'][$g->rsvp] }}">
                            {{ ['yes' => 'Confirmó', 'no' => 'No asiste', 'pending' => 'Pendiente'][$g->rsvp] }}
                        </span>
                    </p>
                    <p class="text-sm text-stone-500">
                        Hasta {{ $g->max_companions }} acomp.
                        @if ($g->rsvp === 'yes') · viene con {{ $g->companions }} @endif
                        @if ($g->message) · “{{ $g->message }}” @endif
                    </p>
                </div>
                <div class="flex gap-3 text-sm items-center">
                    <button type="button" x-data x-on:click="navigator.clipboard.writeText('{{ $this->link($g) }}'); $el.textContent='¡Copiado!'; setTimeout(() => $el.textContent='Copiar enlace', 1500)"
                            class="text-amber-700">Copiar enlace</button>
                    <a href="{{ $this->whatsapp($g) }}" target="_blank" class="text-green-700">WhatsApp</a>
                    <button wire:click="delete({{ $g->id }})" wire:confirm="¿Eliminar a {{ $g->name }}?" class="text-red-600">Eliminar</button>
                </div>
            </div>
        @empty
            <p class="p-6 text-stone-500">Sin invitados en esta vista.</p>
        @endforelse
    </div>
</div>