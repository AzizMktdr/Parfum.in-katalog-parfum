<?php
namespace App\Filament\Resources;

use App\Filament\Resources\AccordResource\Pages;
use App\Models\Accord;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class AccordResource extends Resource
{
    protected static ?string $model = Accord::class;
    protected static ?string $navigationIcon = 'heroicon-o-swatch';
    protected static ?string $navigationLabel = 'Accords';
    protected static ?string $navigationGroup = 'Konten';
    protected static ?int $navigationSort = 4;
    protected static ?string $modelLabel = 'Accord';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Accord')->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Accord')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, Forms\Set $set) =>
                        $set('slug', Str::slug($state))),

                Forms\Components\TextInput::make('slug')
                    ->label('Slug URL')
                    ->required()
                    ->unique(ignoreRecord: true),

                Forms\Components\ColorPicker::make('color')
                    ->label('Warna Accord')
                    ->nullable()
                    ->helperText('Warna ditampilkan sebagai label accord pada halaman detail parfum'),

                Forms\Components\Textarea::make('description')
                    ->label('Deskripsi Accord')
                    ->rows(4)
                    ->nullable()
                    ->columnSpanFull()
                    ->placeholder('Jelaskan karakteristik aroma accord ini...'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ColorColumn::make('color')->label('Warna'),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Accord')
                    ->searchable()->sortable()->weight('bold'),

                Tables\Columns\TextColumn::make('description')
                    ->label('Deskripsi')
                    ->limit(60)
                    ->toggleable(),

                Tables\Columns\TextColumn::make('products_count')
                    ->label('Dipakai di')
                    ->counts('products')
                    ->badge()->color('gray'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListAccords::route('/'),
            'create' => Pages\CreateAccord::route('/create'),
            'edit'   => Pages\EditAccord::route('/{record}/edit'),
            'view'   => Pages\ViewAccord::route('/{record}'),
        ];
    }
}
