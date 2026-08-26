<?php
namespace App\Filament\Resources;

use App\Filament\Resources\NoteResource\Pages;
use App\Models\Note;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class NoteResource extends Resource
{
    protected static ?string $model = Note::class;
    protected static ?string $navigationIcon = 'heroicon-o-sparkles';
    protected static ?string $navigationLabel = 'Notes';
    protected static ?string $navigationGroup = 'Konten';
    protected static ?int $navigationSort = 3;
    protected static ?string $modelLabel = 'Note';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Note')->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Note')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, Forms\Set $set) =>
                        $set('slug', Str::slug($state))),

                Forms\Components\TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->unique(ignoreRecord: true),

                Forms\Components\Select::make('type')
                    ->label('Tipe Note')
                    ->options([
                        'citrus'    => 'Citrus',
                        'floral'    => 'Floral',
                        'wood'      => 'Woody',
                        'gourmand'  => 'Gourmand',
                        'aquatic'   => 'Aquatic',
                        'aromatic'  => 'Aromatic',
                        'oriental'  => 'Oriental',
                        'green'     => 'Green',
                        'musk'      => 'Musk',
                        'spice'     => 'Spice',
                        'top'       => 'Top Note (Generic)',
                        'middle'    => 'Middle Note (Generic)',
                        'base'      => 'Base Note (Generic)',
                    ])
                    ->required()
                    ->default('middle'),

                Forms\Components\TextInput::make('icon')
                    ->label('Emoji/Icon')
                    ->nullable()
                    ->placeholder('🌸'),
            ])->columns(2),

            Forms\Components\Section::make('Gambar & Deskripsi')->schema([
                Forms\Components\FileUpload::make('image_path')
                    ->label('Gambar Note')
                    ->image()
                    ->imageEditor()
                    ->directory('notes')
                    ->disk('public')
                    ->visibility('public')
                    ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/webp'])
                    ->maxSize(1024)
                    ->helperText('Ukuran ideal: 200×200px, PNG transparan')
                    ->nullable(),

                Forms\Components\Textarea::make('description')
                    ->label('Deskripsi')
                    ->rows(3)
                    ->nullable()
                    ->columnSpanFull(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('icon')
                    ->label('')->width(40),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Note')
                    ->searchable()->sortable()->weight('bold'),

                Tables\Columns\TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->color(fn (string $state): string => match($state) {
                        'citrus', 'aquatic'   => 'info',
                        'floral', 'green'     => 'success',
                        'wood', 'aromatic'    => 'warning',
                        'oriental', 'gourmand'=> 'danger',
                        'top'   => 'info',
                        'middle'=> 'success',
                        'base'  => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),

                Tables\Columns\TextColumn::make('products_count')
                    ->label('Dipakai di')
                    ->counts('products')
                    ->badge()->color('gray'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'citrus'   => 'Citrus', 'floral' => 'Floral',
                        'wood'     => 'Woody',  'gourmand' => 'Gourmand',
                        'aquatic'  => 'Aquatic','aromatic' => 'Aromatic',
                        'oriental' => 'Oriental','green'   => 'Green',
                        'top'      => 'Top',    'middle'   => 'Middle',
                        'base'     => 'Base',
                    ])
                    ->label('Tipe Note'),
            ])
            ->actions([
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
            'index'  => Pages\ListNotes::route('/'),
            'create' => Pages\CreateNote::route('/create'),
            'edit'   => Pages\EditNote::route('/{record}/edit'),
        ];
    }
}
