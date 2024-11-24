<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ScheduleResource\Pages;
use App\Filament\Resources\ScheduleResource\RelationManagers;
use App\Models\Schedule;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ScheduleResource extends Resource
{
    protected static ?string $model = Schedule::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    public static function form(Form $form): Form
    {
        $startTimes = ['09:00:00' => '09:00', '10:30:00' => '10:30', '13:00:00' => '13:00', '14:30:00' => '14:30', '16:00:00' => '16:00',];
        $endTimes = ['10:30:00' => '10:30', '12:00:00' => '12:00', '14:30:00' => '14:30', '16:00:00' => '16:00', '17:30:00' => '17:30',];
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Forms\Components\Select::make('doctor_id')->relationship('doctor', 'name')->required(),
                        Forms\Components\DatePicker::make('date')->required(),
                        Forms\Components\Select::make('start_time')->options($startTimes)->required(),
                        Forms\Components\Select::make('end_time')->options($endTimes)->after('start_time')->required(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('doctor.name')->label('Nama Dokter')->sortable()->searchable(),
                TextColumn::make('date')->label('Tanggal')->sortable()->searchable(),
                TextColumn::make('start_time')->label('Waktu Mulai')->sortable()->searchable(),
                TextColumn::make('end_time')->label('Waktu Selesai')->sortable()->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSchedules::route('/'),
            'create' => Pages\CreateSchedule::route('/create'),
            'edit' => Pages\EditSchedule::route('/{record}/edit'),
        ];
    }
}
