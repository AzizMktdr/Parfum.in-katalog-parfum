<?php
namespace App\Filament\Resources;

use App\Filament\Resources\HeroSlideResource\Pages;
use App\Models\HeroSlide;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HeroSlideResource extends Resource
{
    protected static ?string $model = HeroSlide::class;
    protected static ?string $navigationIcon  = 'heroicon-o-photo';
    protected static ?string $navigationLabel = 'Hero Carousel';
    protected static ?string $navigationGroup = 'Tampilan Website';
    protected static ?int    $navigationSort  = 1;
    protected static ?string $modelLabel      = 'Slide Hero';
    protected static ?string $pluralModelLabel = 'Hero Carousel';

    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\Section::make('Konten Slide')
                ->description('Teks yang tampil di hero section halaman utama.')
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->label('Judul Utama')
                        ->required()
                        ->placeholder('CALIFORNIA SIGNATURE')
                        ->helperText('Judul besar di bagian kanan hero. Gunakan HURUF KAPITAL untuk efek yang lebih impactful.')
                        ->columnSpanFull(),

                    Forms\Components\TextInput::make('subtitle')
                        ->label('Watermark / Teks Latar')
                        ->placeholder('MYKONOS')
                        ->helperText('Teks besar transparan di belakang gambar (biasanya nama brand).')
                        ->nullable(),

                    Forms\Components\Textarea::make('description')
                        ->label('Deskripsi Singkat')
                        ->rows(3)
                        ->placeholder('Aroma citrus-aquatic yang segar, ceria, dan mewah.')
                        ->helperText('Teks kecil di kiri bawah hero. Singkat, max 1-2 kalimat.')
                        ->nullable()
                        ->columnSpanFull(),
                ])->columns(2),

            Forms\Components\Section::make('Tombol & Link')
                ->schema([
                    Forms\Components\TextInput::make('button_text')
                        ->label('Teks Tombol')
                        ->default('Lihat Detail')
                        ->required(),

                    Forms\Components\TextInput::make('button_link')
                        ->label('URL Tombol')
                        ->placeholder('/product/california-signature')
                        ->helperText('Kosongkan jika ingin otomatis link ke produk yang dipilih di bawah.')
                        ->nullable(),

                    Forms\Components\Select::make('product_id')
                        ->label('Link ke Produk (opsional)')
                        ->relationship('product', 'name')
                        ->searchable()
                        ->preload()
                        ->nullable()
                        ->helperText('Jika dipilih, gambar & link tombol otomatis menggunakan data produk ini (kecuali ada override di atas).')
                        ->live()
                        ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                            // Auto-fill subtitle dengan nama brand produk jika kosong
                        }),
                ])->columns(3),

            Forms\Components\Section::make('Gambar & Tampilan')
                ->schema([
                    Forms\Components\FileUpload::make('image')
                        ->label('Gambar Produk / Hero')
                        ->image()
                        ->imageEditor()
                        ->directory('hero')
                        ->disk('public')
                        ->visibility('public')
                        ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/webp'])
                        ->maxSize(5120)
                        ->imagePreviewHeight('150')
                        ->helperText('Gambar akan otomatis di-resize ke 600×800px setelah disimpan. PNG transparan direkomendasikan.')
                        ->columnSpanFull(),

                    Forms\Components\ColorPicker::make('bg_color')
                        ->label('Warna Background Slide')
                        ->nullable()
                        ->helperText('Warna latar slide. Kosongkan untuk default hitam/putih sesuai tema.'),

                    Forms\Components\TextInput::make('order')
                        ->label('Urutan Tampil')
                        ->numeric()
                        ->default(0)
                        ->minValue(0)
                        ->helperText('Angka lebih kecil = tampil lebih dulu. 0 = pertama.'),

                    Forms\Components\Toggle::make('is_active')
                        ->label('Aktifkan Slide Ini')
                        ->default(true)
                        ->helperText('Nonaktifkan untuk menyembunyikan slide tanpa menghapus.')
                        ->columnSpanFull(),
                ])->columns(2),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Gambar')
                    ->disk('public')
                    ->width(80)->height(60)
                    ->extraImgAttributes(['style' => 'object-fit:cover; border-radius:6px;'])
                    ->defaultImageUrl(asset('images/products/california-signature.png')),

                Tables\Columns\TextColumn::make('order')
                    ->label('#')
                    ->sortable()
                    ->width(40)
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->weight('bold')
                    ->limit(40),

                Tables\Columns\TextColumn::make('subtitle')
                    ->label('Watermark')
                    ->limit(20)
                    ->color('gray'),

                Tables\Columns\TextColumn::make('product.name')
                    ->label('Produk')
                    ->badge()
                    ->color('info')
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('button_text')
                    ->label('Tombol')
                    ->limit(20),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diupdate')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('order', 'asc')
            ->reorderable('order')          // drag & drop reorder langsung di tabel!
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label('Status'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('toggle')
                    ->label(fn ($record) => $record->is_active ? 'Nonaktifkan' : 'Aktifkan')
                    ->icon(fn ($record) => $record->is_active ? 'heroicon-o-eye-slash' : 'heroicon-o-eye')
                    ->color(fn ($record) => $record->is_active ? 'warning' : 'success')
                    ->action(fn ($record) => $record->update(['is_active' => !$record->is_active]))
                    ->requiresConfirmation(false),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('activate')
                        ->label('Aktifkan semua')
                        ->icon('heroicon-o-eye')
                        ->action(fn ($records) => $records->each->update(['is_active' => true])),
                    Tables\Actions\BulkAction::make('deactivate')
                        ->label('Nonaktifkan semua')
                        ->icon('heroicon-o-eye-slash')
                        ->action(fn ($records) => $records->each->update(['is_active' => false])),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListHeroSlides::route('/'),
            'create' => Pages\CreateHeroSlide::route('/create'),
            'edit'   => Pages\EditHeroSlide::route('/{record}/edit'),
        ];
    }
}
