<?php

namespace App\Filament\Pages;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Notifications\Notification;
use Filament\Pages\Concerns\InteractsWithFormActions;

class Profile extends Page implements HasForms
{
    use InteractsWithForms, InteractsWithFormActions;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static string $view = 'filament.pages.profile';

    public ?array $data = [];

    public function mount(): void
    {
        $this->updateProfileForm->fill(auth()->user()?->toArray());
    }

    protected function getForms(): array
    {
        return array_merge(parent::getForms(), [
            'updateProfileForm' => $this->makeForm()
                ->schema($this->getProfileFormSchema())
                ->model(User::class)
                ->statePath('data'),
        ]);
    }

    public function getProfileFormSchema(): array
    {
        return [
            Forms\Components\Grid::make(3)
                ->columnSpan(3)
                ->schema([
                    Forms\Components\Section::make()
                        ->columns(1)
                        ->columnSpan(1)
                        ->schema([
                            Forms\Components\FileUpload::make('avatar')
                                ->alignCenter()
                                ->image()
                                ->directory('avatars')
                                ->required()
                                ->avatar(),
                        ]),

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
     * To save settings
     */
    public function updateProfile(): void
    {
        auth()->user()->update($this->updateProfileForm->getState());

        Notification::make()
            ->title('Success')
            ->body('Profile has been updated.')
            ->success()
            ->send();
    }
}
