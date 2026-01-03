<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\DocumentResource\Pages;
use App\Models\Document;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Dokumen Ijazah';
    protected static ?string $pluralModelLabel = 'Dokumen';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),

                Tables\Columns\TextColumn::make('nisn')
                    ->label('NISN'),

                Tables\Columns\TextColumn::make('phone')
                    ->label('No. WA'),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'primary' => 'uploaded',
                        'warning' => 'ocr_processing',
                        'info' => 'review_pending',
                        'success' => 'verified',
                        'danger' => 'rejected',
                    ]),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->date('d M Y H:i'),
            ])

            ->actions([
                Action::make('review')
                    ->label('Review')
                    ->url(fn ($record) => static::getUrl('edit', ['record' => $record]))
                    ->icon('heroicon-m-eye'),

                Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-m-check')
                    ->color('success')
                    ->visible(fn($record) => $record->status === 'review_pending')
                    ->action(fn($record) => $record->update(['status' => 'verified'])),

                Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-m-x-mark')
                    ->color('danger')
                    ->form([
                        Forms\Components\Textarea::make('rejection_reason')
                            ->label('Alasan Penolakan')
                    ])
                    ->visible(fn($record) => $record->status === 'review_pending')
                    ->action(fn($record, $data) =>
                        $record->update([
                            'status' => 'rejected',
                            'rejection_reason' => $data['rejection_reason']
                        ])
                    ),
            ])
            ->bulkActions([]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->label('Nama')->disabled(),
                Forms\Components\TextInput::make('nisn')->label('NISN')->disabled(),
                Forms\Components\TextInput::make('phone')->label('No WA')->disabled(),
                Forms\Components\FileUpload::make('file_path')
                    ->label('File PDF')
                    ->downloadable()
                    ->disk('public')
                    ->disabled(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDocuments::route('/'),
            'edit' => Pages\EditDocument::route('/{record}/edit'),
        ];
    }
}
