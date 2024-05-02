<x-filament-panels::page>
    <x-filament::section>
        <x-filament-panels::form wire:submit.prevent="updateProfile">
            {{ $this->updateProfileForm }}

            <div>
                {{ $this->updateProfileFormActions }}
            </div>
        </x-filament-panels::form>
    </x-filament::section>

    <x-filament::section heading="License Details" description="Update your License details.">
        <x-filament-panels::form wire:submit.prevent="updateInspectorLicense">
            {{ $this->updateInspectorLicenseForm }}

            <div>
                {{ $this->updateInspectorLicenseFormActions }}
            </div>
        </x-filament-panels::form>
    </x-filament::section>

    <x-filament::section heading="Office Address" description="Update your office address here.">
        <x-filament-panels::form wire:submit.prevent="updateOfficeAddress">
            {{ $this->updateOfficeAddressForm }}

            <div>
                {{ $this->updateOfficeAddressFormActions }}
            </div>
        </x-filament-panels::form>
    </x-filament::section>
</x-filament-panels::page>
