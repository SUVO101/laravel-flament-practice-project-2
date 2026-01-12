<?php

namespace App\Filament\Resources\Students\Tables;

use App\Models\Student;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Response;

class StudentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('phone')
                    ->searchable(),
                TextColumn::make('address')
                    ->searchable(),
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
            ])
            ->headerActions([
            Action::make('export_csv')
                ->label('Export CSV')
                ->icon('heroicon-o-arrow-down-tray')
                ->action(function () {

                   return response()->streamDownload(function () {

                        $handle = fopen('php://output', 'w');

                        // CSV header
                        fputcsv($handle, ['Name', 'Email', 'Phone', 'Address']);

                        // Data
                        Student::chunk(100, function ($students) use ($handle) {
                            foreach ($students as $student) {
                                fputcsv($handle, [
                                    $student->name,
                                    $student->email,
                                    $student->phone,
                                    $student->address,
                                ]);
                            }
                        });

                        fclose($handle);

                    }, 'students.csv');
                }),
        ])
            ;
    }
}
