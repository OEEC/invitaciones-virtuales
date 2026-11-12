<?php

use App\Models\Invitation;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

new #[Layout('layouts.admin')] class extends Component
{
    use WithFileUploads;

    public Invitation $invitation;
    public string $title = '';
    public string $slug = '';
    public array $data = [];
    public array $files = [];      // archivo único por clave (image / audio)
    public array $newImages = [];  // varias imágenes por clave (images)
    public int $preview = 0;
    public bool $saved = false;

    public function mount(Invitation $invitation): void
    {
        $this->invitation = $invitation->load('template');
        $this->title = $invitation->title;
        $this->slug = $invitation->slug;

        $defaults = config("invitation_defaults.{$invitation->template->slug}", []);
        $saved = array_filter($invitation->data ?? [], fn ($v) => $v !== null && $v !== '');
        $this->data = array_merge($defaults, $saved);
    }

    public function addItem(string $key): void
    {
        $this->data[$key][] = '';
    }

    public function addRow(string $key): void
    {
        $sub = collect($this->invitation->template->fields)->firstWhere('key', $key)['sub'] ?? [];
        $this->data[$key][] = collect($sub)->mapWithKeys(fn ($s) => [$s['key'] => ''])->all();
    }

    public function removeItem(string $key, int $i): void
    {
        unset($this->data[$key][$i]);
        $this->data[$key] = array_values($this->data[$key]);
    }

    public function save(): void
    {
        $this->validate([
            'title' => 'required|min:3',
            'slug' => ['required', 'alpha_dash', Rule::unique('invitations', 'slug')->ignore($this->invitation->id)],
            'files.*' => 'nullable|file|max:15360',
            'newImages.*.*' => 'nullable|image|max:6144',
        ]);

        $dir = "invitations/{$this->invitation->id}";
        foreach ($this->files as $key => $file) {
            if ($file) $this->data[$key] = $file->store($dir, 'public');
        }
        foreach ($this->newImages as $key => $list) {
            foreach ($list as $file) $this->data[$key][] = $file->store($dir, 'public');
        }
        $this->files = [];
        $this->newImages = [];

        $this->invitation->update(['title' => $this->title, 'slug' => $this->slug, 'data' => $this->data]);
        $this->preview++;
        $this->saved = true;
    }

    public function url(string $path): string
    {
        return str_starts_with($path, 'invitations/')
            ? \Illuminate\Support\Facades\Storage::url($path)
            : asset('templates/'.$this->invitation->template->slug.'/'.$path);
    }
};
?>

<div class="grid lg:grid-cols-5 gap-6">
    <form wire:submit="save" class="lg:col-span-3 space-y-5">
        <div class="flex items-center justify-between">
            <a href="{{ route('admin.invitations') }}" class="text-sm text-stone-500">← Invitaciones</a>
            <div class="flex items-center gap-3">
                @if ($saved)<span class="text-sm text-green-700">Guardado ✓</span>@endif
                <button class="bg-amber-600 hover:bg-amber-700 text-white rounded px-4 py-2" wire:loading.attr="disabled">Guardar</button>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-5 space-y-3">
            <div>
                <label class="text-sm">Título interno</label>
                <input wire:model="title" class="w-full border rounded px-3 py-2">
                @error('title')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="text-sm">Dirección pública (/i/…)</label>
                <input wire:model="slug" class="w-full border rounded px-3 py-2">
                @error('slug')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-5 space-y-4">
            @foreach ($invitation->template->fields as $f)
                @php $k = $f['key'] ?? null; @endphp

                @if ($f['type'] === 'section')
                    <h2 class="pt-4 first:pt-0 font-semibold text-amber-700 border-b pb-1">{{ $f['label'] }}</h2>

                @elseif (in_array($f['type'], ['text', 'url', 'datetime-local']))
                    <div>
                        <label class="text-sm">{{ $f['label'] }}</label>
                        <input type="{{ $f['type'] }}" wire:model="data.{{ $k }}" class="w-full border rounded px-3 py-2">
                    </div>

                @elseif ($f['type'] === 'textarea')
                    <div>
                        <label class="text-sm">{{ $f['label'] }}</label>
                        <textarea wire:model="data.{{ $k }}" rows="3" class="w-full border rounded px-3 py-2"></textarea>
                    </div>

                @elseif ($f['type'] === 'list')
                    <div class="space-y-2">
                        <label class="text-sm">{{ $f['label'] }}</label>
                        @foreach ($data[$k] ?? [] as $i => $_)
                            <div class="flex gap-2" wire:key="{{ $k }}-{{ $i }}">
                                <textarea wire:model="data.{{ $k }}.{{ $i }}" rows="2" class="flex-1 border rounded px-3 py-2"></textarea>
                                <button type="button" wire:click="removeItem('{{ $k }}', {{ $i }})" class="text-red-600 px-2">✕</button>
                            </div>
                        @endforeach
                        <button type="button" wire:click="addItem('{{ $k }}')" class="text-sm text-amber-700">+ Agregar</button>
                    </div>

                @elseif ($f['type'] === 'repeater')
                    <div class="space-y-2">
                        <label class="text-sm">{{ $f['label'] }}</label>
                        @foreach ($data[$k] ?? [] as $i => $row)
                            <div class="flex gap-2 items-end border rounded p-2" wire:key="{{ $k }}-{{ $i }}">
                                @foreach ($f['sub'] as $s)
                                    <div class="flex-1 min-w-0">
                                        <label class="text-xs text-stone-500">{{ $s['label'] }}</label>
                                        <input type="{{ $s['type'] === 'color' ? 'color' : 'text' }}" wire:model="data.{{ $k }}.{{ $i }}.{{ $s['key'] }}"
                                               class="w-full border rounded px-2 py-1 {{ $s['type'] === 'color' ? 'h-9 p-0' : '' }}">
                                    </div>
                                @endforeach
                                <button type="button" wire:click="removeItem('{{ $k }}', {{ $i }})" class="text-red-600 px-2 pb-1">✕</button>
                            </div>
                        @endforeach
                        <button type="button" wire:click="addRow('{{ $k }}')" class="text-sm text-amber-700">+ Agregar</button>
                    </div>

                @elseif ($f['type'] === 'image')
                    <div>
                        <label class="text-sm">{{ $f['label'] }}</label>
                        <div class="flex items-center gap-3">
                            @if (!empty($files[$k]))
                                <img src="{{ $files[$k]->temporaryUrl() }}" class="h-16 rounded">
                            @elseif (!empty($data[$k]))
                                <img src="{{ $this->url($data[$k]) }}" class="h-16 rounded">
                            @endif
                            <input type="file" accept="image/*" wire:model="files.{{ $k }}" class="text-sm">
                        </div>
                        @error("files.$k")<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                @elseif ($f['type'] === 'audio')
                    <div>
                        <label class="text-sm">{{ $f['label'] }}</label>
                        @if (!empty($data[$k]))<audio controls src="{{ $this->url($data[$k]) }}" class="my-1 h-10"></audio>@endif
                        <input type="file" accept="audio/*" wire:model="files.{{ $k }}" class="block text-sm">
                        @error("files.$k")<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                @elseif ($f['type'] === 'images')
                    <div>
                        <label class="text-sm">{{ $f['label'] }}</label>
                        <div class="flex flex-wrap gap-2 my-2">
                            @foreach ($data[$k] ?? [] as $i => $path)
                                <div class="relative" wire:key="{{ $k }}-img-{{ $i }}">
                                    <img src="{{ $this->url($path) }}" class="h-20 w-20 object-cover rounded">
                                    <button type="button" wire:click="removeItem('{{ $k }}', {{ $i }})"
                                            class="absolute -top-2 -right-2 bg-red-600 text-white rounded-full w-5 h-5 text-xs">✕</button>
                                </div>
                            @endforeach
                        </div>
                        <input type="file" multiple accept="image/*" wire:model="newImages.{{ $k }}" class="text-sm">
                        <p class="text-xs text-stone-500">Las nuevas fotos se agregan al guardar.</p>
                        @error("newImages.$k.*")<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                @endif
            @endforeach
        </div>
    </form>

    <aside class="lg:col-span-2">
        <div class="sticky top-4">
            <p class="text-sm text-stone-500 mb-2">Vista previa (se actualiza al guardar)</p>
            <iframe wire:key="prev-{{ $preview }}" src="{{ route('invitation.show', $invitation->slug) }}?v={{ $preview }}"
                    class="w-full h-[75vh] border rounded-xl bg-white"></iframe>
        </div>
    </aside>
</div>