<?php

use App\Models\Invitation;
use App\Models\Template;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.admin')] class extends Component
{
    public string $title = '';
    public ?int $template_id = null;

    public function create(): void
    {
        $this->validate([
            'title' => 'required|min:3',
            'template_id' => 'required|exists:templates,id',
        ]);

        $slug = Str::slug($this->title);
        $base = $slug; $i = 2;
        while (Invitation::where('slug', $slug)->exists()) { $slug = $base.'-'.$i++; }

        Invitation::create(['title' => $this->title, 'template_id' => $this->template_id, 'slug' => $slug, 'data' => []]);
        $this->reset('title', 'template_id');
    }

    public function toggle(int $id): void
    {
        $inv = Invitation::findOrFail($id);
        $inv->update(['status' => $inv->status === 'published' ? 'draft' : 'published']);
    }

    public function delete(int $id): void
    {
        Invitation::findOrFail($id)->delete();
    }

    public function with(): array
    {
        return [
            'invitations' => Invitation::with('template')->withCount('guests')->latest()->get(),
            'templates' => Template::where('active', true)->get(),
        ];
    }
};
?>

<div class="space-y-8">
    <form wire:submit="create" class="bg-white rounded-xl shadow p-5 flex flex-wrap gap-3 items-end">
        <div class="flex-1 min-w-48">
            <label class="text-sm">Título</label>
            <input wire:model="title" class="w-full border rounded px-3 py-2" placeholder="Boda de Oscar y Sol">
            @error('title')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="text-sm">Plantilla</label>
            <select wire:model="template_id" class="border rounded px-3 py-2">
                <option value="">Elegir…</option>
                @foreach ($templates as $t)<option value="{{ $t->id }}">{{ $t->name }}</option>@endforeach
            </select>
            @error('template_id')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <button class="bg-amber-600 hover:bg-amber-700 text-white rounded px-4 py-2">Crear invitación</button>
    </form>

    <div class="bg-white rounded-xl shadow divide-y">
        @forelse ($invitations as $inv)
            <div class="p-4 flex items-center justify-between gap-3 flex-wrap">
                <div>
                    <p class="font-medium">{{ $inv->title }}</p>
                    <p class="text-sm text-stone-500">{{ $inv->template->name }} · {{ $inv->guests_count }} invitados · /i/{{ $inv->slug }}</p>
                </div>
                <div class="flex gap-3 text-sm items-center">
                    <span class="px-2 py-0.5 rounded-full {{ $inv->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-stone-100 text-stone-600' }}">
                        {{ $inv->status === 'published' ? 'Publicada' : 'Borrador' }}
                    </span>
                    <a href="{{ route('admin.invitations.edit', $inv) }}" class="text-amber-700 font-medium">Editar</a>
                    <a href="{{ route('admin.invitations.guests', $inv) }}" class="text-amber-700 font-medium">Invitados</a>
                    <a href="{{ route('invitation.show', $inv->slug) }}" target="_blank" class="text-stone-600">Ver</a>
                    <button wire:click="toggle({{ $inv->id }})" class="text-stone-600">{{ $inv->status === 'published' ? 'Despublicar' : 'Publicar' }}</button>
                    <button wire:click="delete({{ $inv->id }})" wire:confirm="¿Eliminar esta invitación?" class="text-red-600">Eliminar</button>
                </div>
            </div>
        @empty
            <p class="p-6 text-stone-500">Aún no hay invitaciones. Crea la primera arriba.</p>
        @endforelse
    </div>
</div>