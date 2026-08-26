<?php
namespace App\Filament\Resources;

use App\Filament\Resources\ReviewResource\Pages;
use App\Models\Review;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationLabel = 'Review & Rating';
    protected static ?string $navigationGroup = 'Pengguna';
    protected static ?int $navigationSort = 2;
    protected static ?string $modelLabel = 'Review';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('product_slug')->label('Slug Produk')->disabled(),
            Forms\Components\TextInput::make('user.name')->label('User')->disabled(),
            Forms\Components\TextInput::make('sillage')->label('Sillage')->numeric(),
            Forms\Components\TextInput::make('projection')->label('Projection')->numeric(),
            Forms\Components\TextInput::make('longevity')->label('Longevity')->numeric(),
            Forms\Components\Textarea::make('review_text')->label('Teks Review')->rows(4)->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('product_slug')
                    ->label('Produk')
                    ->searchable()
                    ->badge()
                    ->color('gray')
                    ->formatStateUsing(fn($state) => strtoupper(str_replace('-', ' ', $state))),

                Tables\Columns\TextColumn::make('sillage')
                    ->label('Sillage')
                    ->badge()->color('info'),

                Tables\Columns\TextColumn::make('projection')
                    ->label('Projection')
                    ->badge()->color('success'),

                Tables\Columns\TextColumn::make('longevity')
                    ->label('Longevity')
                    ->badge()->color('warning'),

                Tables\Columns\TextColumn::make('avg_rating')
                    ->label('Rata-rata')
                    ->getStateUsing(fn($record) => number_format(($record->sillage + $record->projection + $record->longevity) / 3, 1))
                    ->badge()->color('danger'),

                Tables\Columns\TextColumn::make('review_text')
                    ->label('Review')
                    ->limit(60)
                    ->tooltip(fn ($record) => $record->review_text),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('from')->label('Dari'),
                        Forms\Components\DatePicker::make('until')->label('Sampai'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn($q, $d) => $q->whereDate('created_at', '>=', $d))
                            ->when($data['until'], fn($q, $d) => $q->whereDate('created_at', '<=', $d));
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReviews::route('/'),
            'view'  => Pages\ViewReview::route('/{record}'),
        ];
    }
}
