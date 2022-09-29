<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaskResource\Pages\CreateTask;
use App\Filament\Resources\TaskResource\Pages\EditTask;
use App\Filament\Resources\TaskResource\Pages\ListTasks;
use App\Models\Task;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $label = 'Tarefas';

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                        ->label('Nome da Tarefa')
                        ->unique(ignorable: fn($record) => $record)
                        ->required(),
                TextInput::make('cost')
                        ->label('R$ Custo')
                        ->required(),
                DatePicker::make('date_limit')
                        ->label('Data Limite')
                        ->required()
                        ->default(now())
                        ->columnSpan(['default' => 12, 'md' => 6, '2xl' => 3])
                        ->required(),
                TextInput::make('order_of_presentation')
                        ->hidden(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(('Tarefa')),
                TextColumn::make('cost')
                    ->label('R$ Custo'),
                TextColumn::make('date_limit')
                    ->date('d F Y')
                    ->label('Data Limite'),
            ])->actions([
                Action::make('up')
                    ->iconButton()
                    ->icon('heroicon-o-arrow-up')
                    ->action(fn (Task $record) => $record->moveOrderUp($record))
                    ->disabled(fn (Task $record) => $record->order_of_presentation == 1)
                    ->tooltip('Subir'),
                Action::make('down')
                    ->iconButton()
                    ->icon('heroicon-o-arrow-down')
                    ->action(fn (Task $record) => $record->moveOrderDown($record))
                    ->disabled(fn (Task $record) => $record->order_of_presentation >= Task::query()->max('order_of_presentation'))
                    ->tooltip('Descer'),
                EditAction::make()
                    ->iconButton()
                    ->tooltip('Editar')
                    ->color('success'),
                DeleteAction::make()
                    ->iconButton()
                    ->tooltip('Apagar'),
            ]);
    }

    public static function getRelations(): array
    {
        return [

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTasks::route('/'),
            'create' => CreateTask::route('/create'),
            'edit' => EditTask::route('/{record}/edit'),
        ];
    }

}
