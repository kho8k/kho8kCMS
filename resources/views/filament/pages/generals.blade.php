<x-filament::page>
    <form wire:submit.prevent="submit">
        {{ $this->form }}
        <x-filament::button
            type="submit"
            class="mt-6">
            Lưu
        </x-filament::button>
    </form>
</x-filament::page>