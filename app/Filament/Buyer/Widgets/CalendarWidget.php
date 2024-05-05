<?php

namespace App\Filament\Buyer\Widgets;

use App\Models\InspectionRequest;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Infolists;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Saade\FilamentFullCalendar\Actions;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class CalendarWidget extends FullCalendarWidget
{
    public Model | string | null $model = InspectionRequest::class;
 
    public function fetchEvents(array $fetchInfo): array
    {
        return InspectionRequest::where('book_at', '>=', $fetchInfo['start'])
            ->where('book_at', '<=', $fetchInfo['end'])
            ->whereBelongsTo(auth()->user(), 'buyer')
            ->get()
            ->map(function (InspectionRequest $inspectionRequest) {
                return [
                    'id' => $inspectionRequest->id,
                    'title' => $inspectionRequest->request_number,
                    'start' => $inspectionRequest->book_at,
                ];
            })
            ->toArray();
    }
 
    public static function canView(): bool
    {
        return false;
    }

    protected function headerActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('New request'),
        ];
    }

    protected function modalActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function viewAction(): Action
    {
        return Actions\ViewAction::make()
            ->infolist([
                Infolists\Components\Section::make()
                    ->columns(4)
                    ->schema([
                        Infolists\Components\TextEntry::make('request_number'),
                        Infolists\Components\TextEntry::make('property.address')
                            ->columnSpan(3),
                        Infolists\Components\TextEntry::make('inspector.name'),
                        Infolists\Components\TextEntry::make('inspector.office_address.address')
                            ->label('Inspector address')
                            ->columnSpan(3),
                        Infolists\Components\TextEntry::make('book_at'),
                        Infolists\Components\TextEntry::make('status'),
                        Infolists\Components\TextEntry::make('created_at'),
                        Infolists\Components\TextEntry::make('notes')
                            ->placeholder('N/A')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public function getFormSchema(): array
    {
        return [
            Forms\Components\Section::make()
                ->columns()
                ->schema([
                    Forms\Components\Select::make('property_id')
                        ->columnSpanFull()
                        ->required()
                        ->placeholder('Choose your property')
                        ->relationship('property', 'address')
                        ->searchable()
                        ->preload(),

                    Forms\Components\Select::make('inspector_id')
                        ->required()
                        ->placeholder('Choose inspector')
                        ->relationship(
                            'inspector',
                            'name',
                            fn (Builder $query) =>
                                $query->role(User::ROLE_INSPECTOR)
                        )
                        ->searchable()
                        ->preload(),

                    Forms\Components\DateTimePicker::make('book_at')
                        ->default(now())
                        ->minDate(now())
                        ->native(false)
                        ->seconds(false)
                        ->required(),

                    Forms\Components\Textarea::make('notes')
                        ->columnSpanFull()
                        ->placeholder('Add note for the inspector...')
                        ->maxLength(151),
                ]),
        ];
    }

    public function eventDidMount(): string
    {
        return <<<JS
            function({ event, timeText, isStart, isEnd, isMirror, isPast, isFuture, isToday, el, view }) {
                el.classList.add('cursor-pointer');
                el.setAttribute("x-tooltip", "tooltip");
                el.setAttribute("x-data", "{ tooltip: '"+ event.title +"' }");
            }
        JS;
    }
}
