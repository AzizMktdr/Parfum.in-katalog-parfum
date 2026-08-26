<?php
namespace App\Filament\Resources;

use App\Filament\Resources\BrandResource\Pages;
use App\Models\Brand;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class BrandResource extends Resource
{
    protected static ?string $model = Brand::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';
    protected static ?string $navigationLabel = 'Brand';
    protected static ?string $navigationGroup = 'Konten';
    protected static ?int $navigationSort = 2;
    protected static ?string $modelLabel = 'Brand';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Utama')->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Brand')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, Forms\Set $set) =>
                        $set('slug', Str::slug($state))),

                Forms\Components\TextInput::make('slug')
                    ->label('Slug URL')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->helperText('URL: /brands/{slug}'),

                Forms\Components\TextInput::make('est')
                    ->label('Tahun Berdiri (Est.)')
                    ->placeholder('2019')
                    ->nullable(),

                Forms\Components\TextInput::make('country')
                    ->label('Negara Asal')
                    ->placeholder('Indonesia')
                    ->nullable(),

                Forms\Components\TextInput::make('website')
                    ->label('Website')
                    ->url()
                    ->placeholder('https://mykonos.id')
                    ->nullable(),
            ])->columns(2),

            Forms\Components\Section::make('Logo & Deskripsi')->schema([
                Forms\Components\FileUpload::make('logo')
                    ->label('Logo Brand')
                    ->image()
                    ->imageEditor()
                    ->directory('brands')
                    ->disk('public')
                    ->visibility('public')
                    ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/webp', 'image/svg+xml'])
                    ->maxSize(2048)
                    ->imagePreviewHeight('120')
                    ->helperText('Gambar akan otomatis di-resize ke 400×400px setelah disimpan.')
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('description')
                    ->label('Deskripsi Brand')
                    ->rows(5)
                    ->placeholder('Ceritakan tentang brand ini...')
                    ->columnSpanFull(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo')
                    ->label('Logo')
                    ->disk('public')
                    ->width(56)->height(56)
                    ->defaultImageUrl(fn ($record) => null)
                    ->extraImgAttributes(['style' => 'object-fit:contain; background:#f5f5f5; border-radius:8px; padding:4px;']),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Brand')
                    ->searchable()->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('est')
                    ->label('Est.')
                    ->sortable(),

                Tables\Columns\TextColumn::make('country')
                    ->label('Negara')
                    ->searchable(),

                Tables\Columns\TextColumn::make('products_count')
                    ->label('Produk')
                    ->counts('products')
                    ->sortable()->badge()->color('success'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
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
            'index'  => Pages\ListBrands::route('/'),
            'create' => Pages\CreateBrand::route('/create'),
            'edit'   => Pages\EditBrand::route('/{record}/edit'),
            'view'   => Pages\ViewBrand::route('/{record}'),
        ];
    }
}
