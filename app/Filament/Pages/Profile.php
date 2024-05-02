<?php

namespace App\Filament\Pages;

use App\Models\OfficeAddress;
use App\Models\InspectorLicense;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Pages\Page;

class Profile extends Page implements HasForms
{
    use InteractsWithForms, InteractsWithFormActions;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static string $view = 'filament.pages.profile';

    public ?array $profileData = [];

    public ?array $inspectorLicenseData = [];

    public ?array $officeAddressData = [];

    public User $user;

    public function mount(): void
    {
        $this->user = auth()->user();
        $this->updateProfileForm->fill($this->user?->toArray());

        $this->updateInspectorLicenseForm->fill($this->user?->inspector_license?->toArray() ?? []);

        $this->updateOfficeAddressForm->fill($this->user?->office_address?->toArray() ?? []);
    }

    protected function getForms(): array
    {
        return array_merge(parent::getForms(), [
            'updateProfileForm' => $this->makeForm()
                ->schema($this->getProfileFormSchema())
                ->model(User::class)
                ->statePath('profileData'),

            'updateInspectorLicenseForm' => $this->makeForm()
                ->schema($this->getInspectorLicenseFormSchema())
                ->model(InspectorLicense::class)
                ->statePath('inspectorLicenseData'),

            'updateOfficeAddressForm' => $this->makeForm()
                ->schema($this->getOfficeAddressFormSchema())
                ->model(OfficeAddress::class)
                ->statePath('officeAddressData'),
        ]);
    }

    public function getProfileFormSchema(): array
    {
        return [
            Forms\Components\Grid::make(3)
                ->columnSpan(3)
                ->schema([
                    Forms\Components\FileUpload::make('avatar')
                        ->columnSpan(1)
                        ->image()
                        ->avatar()
                        ->directory('avatars')
                        ->required(),

                    Forms\Components\Section::make()
                        ->columns()
                        ->columnSpan(2)
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->placeholder('Name')
                                ->required(),

                            Forms\Components\TextInput::make('email')
                                ->placeholder('Email')
                                ->email()
                                ->unique(User::class, 'email', auth()->user())
                                ->required(),

                            Forms\Components\TextInput::make('phone_number')
                                ->placeholder('Phone number')
                                ->tel()
                                ->required(),
                        ]),
                ]),
        ];
    }

    protected function updateProfileFormActions(): Action
    {
        return Action::make('save')
            ->icon('heroicon-o-plus-circle')
            ->submit('updateProfile');
    }

    /**
     * To save profile
     */
    public function updateProfile(): void
    {
        $this->user->update($this->updateProfileForm->getState());

        Notification::make()
            ->title('Success')
            ->body('Profile has been updated.')
            ->success()
            ->send();
    }

    /**
     * To save Inspector License
     */
    public function updateInspectorLicense(): void
    {
        $this->user->inspector_license()->updateOrCreate(
            [],
            $this->updateInspectorLicenseForm->getState()
        );

        Notification::make()
            ->title('Success')
            ->body('Inspector license has been updated.')
            ->success()
            ->send();
    }

    protected function getInspectorLicenseFormSchema(): array
    {
        return [
            Forms\Components\Section::make()
                ->columns()
                ->schema([
                    Forms\Components\TextInput::make('inspection_license')
                        ->placeholder('Inspection license')
                        ->required(),

                    Forms\Components\TextInput::make('tax_id')
                        ->label('Tax ID (EIN)')
                        ->placeholder('Tax ID')
                        ->required(),

                    Forms\Components\TextInput::make('driver_license')
                        ->placeholder('Driver license')
                        ->required(),

                    Forms\Components\TextInput::make('driver_city_name')
                        ->placeholder('Driver city name')
                        ->required(),
                ]),
        ];
    }

    protected function updateInspectorLicenseFormActions(): Action
    {
        return Action::make('save')
            ->icon('heroicon-o-plus-circle')
            ->submit('updateInspectorLicense');
    }

    /**
     * To save Inspector License
     */
    public function updateOfficeAddress(): void
    {
        $this->user->office_address()->updateOrCreate(
            [],
            $this->updateOfficeAddressForm->getState()
        );

        Notification::make()
            ->title('Success')
            ->body('Office address has been updated.')
            ->success()
            ->send();
    }

    public function getOfficeAddressFormSchema(): array
    {
        return [
            Forms\Components\Section::make()
                ->columns()
                ->schema([
                    Forms\Components\TextInput::make('address')
                        ->placeholder('Address')
                        ->required()
                        ->columnSpanFull(),

                    Forms\Components\TextInput::make('charges')
                        ->prefixIcon('heroicon-o-currency-dollar')
                        ->label('Charge per mile')
                        ->placeholder('Charge per mile')
                        ->required(),

                    Forms\Components\TextInput::make('inspection_radius')
                        ->numeric()
                        ->label('Maximum distance till which the inspection to be done (miles)')
                        ->placeholder('Charge per mile')
                        ->required(),
                ]),
        ];
    }

    protected function updateOfficeAddressFormActions(): Action
    {
        return Action::make('save')
            ->icon('heroicon-o-plus-circle')
            ->submit('updateOfficeAddress');
    }
}
