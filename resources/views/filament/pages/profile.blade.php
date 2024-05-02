<x-filament-panels::page>
    <x-filament-panels::form wire:submit.prevent="updateProfile">
        {{ $this->updateProfileForm }}

        <div>
            {{ $this->updateProfileFormActions }}
        </div>
    </x-filament-panels::form>
</x-filament-panels::page>
