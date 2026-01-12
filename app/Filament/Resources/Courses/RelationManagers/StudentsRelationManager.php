<?php

namespace App\Filament\Resources\Courses\RelationManagers;

use Filament\Actions\AttachAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DetachAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class StudentsRelationManager extends RelationManager
{
    protected static string $relationship = 'students';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('phone')
                    ->tel()
                    ->default(null),
                Select::make('status')
                    ->options([
                        'enrolled' => 'Enrolled',
                        'completed' => 'Completed',
                    ])->native(false)
                    ->required(),
                DateTimePicker::make('completed_at')->placeholder('-')->native(false),
                TextInput::make('address')
                    ->default(null),
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('email')
                    ->label('Email address'),
                TextEntry::make('phone')
                    ->placeholder('-'),
                TextEntry::make('address')
                    ->placeholder('-'),
                TextEntry::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'enrolled' => 'warning',
                        'completed' => 'success',
                    }),
                TextEntry::make('completed_at')
                    ->since()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->since()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->placeholder('-'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('phone')
                     ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('address')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'enrolled' => 'warning',
                        'completed' => 'success',
                    }),
                TextColumn::make('completed_at')
                    ->since()->placeholder('-'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
                AttachAction::make()->preloadRecordSelect(),
    //             AttachAction::make() ->preloadRecordSelect()->schema(fn (AttachAction $action): array => [
    //                         $action->getRecordSelect()->label('Select Student')->placeholder('Choose a student...'),

    //                         Select::make('status')->options([
    //                             'enrolled' => 'Enrolled',
    //                             'completed' => 'Completed',
    //                         ])->native(false)->required(),

    //                         DateTimePicker::make('completed_at')->native(false),
    // ]),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DetachAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
