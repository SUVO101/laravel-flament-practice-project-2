<?php

namespace App\Filament\Resources\Courses\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CoursesTable
{
    public static function configure(Table $table): Table
    {
        return $table
                ->modifyQueryUsing(fn (Builder $query): Builder => 
                    $query->withCount([
                        'students as enrolled_count' => function ($q) {
                            $q->where('course_student.status', 'enrolled');  // ← use FULL table.column
                        },
                        'students as completed_count' => function ($q) {
                            $q->where('course_student.status', 'completed');
                        },
                    ])
                )
            ->columns([
                TextColumn::make('title')
                ->label('Name')
                    ->searchable()
                    ->alignCenter(),
                TextColumn::make('duration')
                    ->searchable()->alignCenter(),
                TextColumn::make('enrolled_count')
                ->label('Enrolled Students')
                ->badge()
                ->color('warning')
                ->sortable(false)->alignCenter(),

            TextColumn::make('completed_count')
                ->label('Completed Students')
                ->badge()
                ->color('success')
                ->sortable(false)->alignCenter(),
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
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make()
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
