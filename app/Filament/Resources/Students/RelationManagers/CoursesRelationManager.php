<?php

namespace App\Filament\Resources\Students\RelationManagers;

use Filament\Actions\Action;
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
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;

class CoursesRelationManager extends RelationManager
{
    protected static string $relationship = 'courses';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('duration')
                    ->required(),
                Select::make('status')
                    ->options([
                        'completed' => 'Completed',
                        'enrolled' => 'Enrolled',
                    ])
                    ->native(false)
                    ->required(),
                DateTimePicker::make('completed_at')
                    ->timezone('Asia/Kolkata')
                    ->native(false)
                    ->placeholder(now())
                    ->required(),
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title'),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('duration'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('duration')
                    ->searchable(),
                TextColumn::make('status')
                    ->searchable(),
                ViewColumn::make('certificate')
                    ->label('Certificate')
                    ->view('filament.tables.certificate-button')
                    ->disabledClick(),
            ])
            ->searchable(false)
            ->filters([

            ])
            ->headerActions([
                // CreateAction::make(),
                AttachAction::make()->preloadRecordSelect(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DetachAction::make(),
                // DeleteAction::make(),
            ])
            ->toolbarActions([
                // BulkActionGroup::make([
                //     DetachBulkAction::make(),
                //     DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
