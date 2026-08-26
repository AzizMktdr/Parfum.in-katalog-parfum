<?php
namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Note;
use App\Models\Accord;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $navigationIcon = 'heroicon-o-beaker';
    protected static ?string $navigationLabel = 'Data Parfum';
    protected static ?string $navigationGroup = 'Konten';
    protected static ?int $navigationSort = 1;
    protected static ?string $modelLabel = 'Parfum';
    protected static ?string $pluralModelLabel = 'Data Parfum';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Utama')
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Nama Parfum')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($state, Forms\Set $set) =>
                            $set('slug', Str::slug($state))),

                    Forms\Components\TextInput::make('slug')
                        ->label('Slug')
                        ->required()
                        ->unique(ignoreRecord: true),

                    Forms\Components\Select::make('brand_id')
                        ->label('Brand')
                        ->options(fn() => \Illuminate\Support\Facades\Cache::remember(
                            'brands_options', 300,
                            fn() => \App\Models\Brand::orderBy('name')->pluck('name', 'id')
                        ))
                        ->searchable()
                        ->required()
                        ->native(false),

                    Forms\Components\Select::make('category')
                        ->label('Kategori')
                        ->options([
                            'Parfum'  => 'Parfum (Extrait)',
                            'EDP'     => 'Eau de Parfum (EDP)',
                            'EDT'     => 'Eau de Toilette (EDT)',
                            'EDC'     => 'Eau de Cologne (EDC)',
                            'Body Mist' => 'Body Mist',
                        ])
                        ->default('EDP')
                        ->required(),

                    Forms\Components\Select::make('collection')
                        ->label('Koleksi')
                        ->options([
                            'night' => 'Night',
                            'day'   => 'Day',
                            'sport' => 'Sport',
                            'unisex' => 'Unisex',
                        ])
                        ->nullable(),

                    Forms\Components\TextInput::make('price')
                        ->label('Harga (Rp)')
                        ->numeric()
                        ->prefix('Rp')
                        ->nullable(),

                    Forms\Components\TextInput::make('volume_ml')
                        ->label('Volume (ml)')
                        ->numeric()
                        ->suffix('ml')
                        ->nullable(),

                    Forms\Components\Toggle::make('is_active')
                        ->label('Aktif')
                        ->default(true),
                ])->columns(2),

            Forms\Components\Section::make('Deskripsi & Gambar')
                ->schema([
                    Forms\Components\Textarea::make('description')
                        ->label('Deskripsi')
                        ->rows(4)
                        ->columnSpanFull(),

                    Forms\Components\FileUpload::make('image')
                        ->label('Gambar Parfum')
                        ->image()
                        ->disk('public')
                        ->directory('products')
                        ->visibility('public')
                        ->maxSize(5120)
                        ->imagePreviewHeight('150')
                        ->helperText('Gambar akan otomatis di-resize ke 600×600px setelah disimpan.')
                        ->columnSpanFull(),

                     Forms\Components\TextInput::make('affiliate_link')
                        ->label('Link Shopee')
                        ->url()
                        ->placeholder('https://shopee.co.id/...')
                        ->prefix('🛍️')
                        ->helperText('Link produk di Shopee atau marketplace lain')
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make('Notes')
                ->schema([
                    Forms\Components\Select::make('topNotes')
                        ->label('Top Notes')
                        ->options(fn() => \Illuminate\Support\Facades\Cache::remember(
                            'notes_top', 300,
                            fn() => \App\Models\Note::where('type','top')->orderBy('name')->pluck('name', 'id')
                        ))
                        ->multiple()->searchable()->native(false),

                    Forms\Components\Select::make('middleNotes')
                        ->label('Middle Notes')
                        ->options(fn() => \Illuminate\Support\Facades\Cache::remember(
                            'notes_middle', 300,
                            fn() => \App\Models\Note::where('type','middle')->orderBy('name')->pluck('name', 'id')
                        ))
                        ->multiple()->searchable()->native(false),

                    Forms\Components\Select::make('baseNotes')
                        ->label('Base Notes')
                        ->options(fn() => \Illuminate\Support\Facades\Cache::remember(
                            'notes_base', 300,
                            fn() => \App\Models\Note::where('type','base')->orderBy('name')->pluck('name', 'id')
                        ))
                        ->multiple()->searchable()->native(false),
                ])->columns(3),

            Forms\Components\Section::make('Accords')
                ->schema([
                    Forms\Components\Select::make('accords')
                        ->label('Accords')
                        ->options(fn() => \Illuminate\Support\Facades\Cache::remember(
                            'accords_options', 300,
                            fn() => \App\Models\Accord::orderBy('name')->pluck('name', 'id')
                        ))
                        ->multiple()->searchable()->native(false)->columnSpanFull(),
                ]),
        ]);
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->with(['brand']); // eager load brand — stop N+1 query
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Foto')
                    ->disk('public')
                    ->width(52)->height(52)
                    ->defaultImageUrl(asset('images/products/california-signature.png')),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Parfum')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('brand.name')
                    ->label('Brand')
                    ->sortable()
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->color(fn (string $state): string => match($state) {
                        'Parfum' => 'danger',
                        'EDP'    => 'warning',
                        'EDT'    => 'info',
                        default  => 'gray',
                    }),

                Tables\Columns\TextColumn::make('collection')
                    ->label('Koleksi')
                    ->badge()
                    ->color('success'),

                Tables\Columns\TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('brand')
                    ->relationship('brand', 'name')
                    ->label('Filter Brand'),

                Tables\Filters\SelectFilter::make('category')
                    ->options([
                        'Parfum' => 'Parfum', 'EDP' => 'EDP',
                        'EDT' => 'EDT', 'EDC' => 'EDC',
                    ])
                    ->label('Filter Kategori'),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
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
            ])
            ->defaultSort('name')
            ->defaultPaginationPageOption(10); // load lebih sedikit per halaman
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view'   => Pages\ViewProduct::route('/{record}'),
            'edit'   => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
