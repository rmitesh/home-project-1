<?php

namespace App\Filament\Widgets;

use App\Enums\InspectionRequestStatus;
use App\Models\InspectionRequest;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Infolists;
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
            ->whereBelongsTo(auth()->user(), 'inspector')
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
        return [];
    }

    protected function modalActions(): array
    {
        return [];
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
                        Infolists\Components\TextEntry::make('buyer.name'),
                        Infolists\Components\TextEntry::make('book_at')
                            ->suffixActions([
                                Infolists\Components\Actions\Action::make('change_status')
                                    ->icon('heroicon-m-x-mark')
                                    ->color('info')
                                    ->requiresConfirmation()
                                    ->form([
                                        Forms\Components\ToggleButtons::make('status')
                                            ->options(InspectionRequestStatus::class)
                                    ])
                                    ->action(function (array $data) {
                                        dd($data);
                                    })
                                    ->mountInfolistAction,
                            ]),
                        Infolists\Components\TextEntry::make('status'),
                        Infolists\Components\TextEntry::make('created_at'),
                        Infolists\Components\TextEntry::make('notes')
                            ->placeholder('N/A')
                            ->columnSpanFull(),
                    ]),
            ]);
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
