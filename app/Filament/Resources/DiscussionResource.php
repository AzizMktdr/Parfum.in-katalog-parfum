<?php
namespace App\Filament\Resources;

use App\Filament\Resources\DiscussionResource\Pages;
use App\Models\Discussion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DiscussionResource extends Resource
{
    protected static ?string $model = Discussion::class;
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';
    protected static ?string $navigationLabel = 'Diskusi Komunitas';
    protected static ?string $navigationGroup = 'Pengguna';
    protected static ?int $navigationSort = 3;
    protected static ?string $modelLabel = 'Diskusi';
    protected static ?string $pluralModelLabel = 'Diskusi Komunitas';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('user.name')
                ->label('Dibuat oleh')
                ->disabled(),

            Forms\Components\TextInput::make('title')
                ->label('Judul')
                ->required()
                ->maxLength(255),

            Forms\Components\Textarea::make('body')
                ->label('Isi Diskusi')
                ->required()
                ->rows(6)
                ->columnSpanFull(),

            Forms\Components\TextInput::make('likes_count')
                ->label('Jumlah Like')
                ->numeric()
                ->disabled(),

            Forms\Components\TextInput::make('replies_count')
                ->label('Jumlah Balasan')
                ->numeric()
                ->disabled(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul Diskusi')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(50),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Penulis')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('body')
                    ->label('Isi')
                    ->limit(60)
                    ->wrap(),

                Tables\Columns\TextColumn::make('replies_count')
                    ->label('Balasan')
                    ->badge()
                    ->color('info')
                    ->sortable(),

                Tables\Columns\TextColumn::make('likes_count')
                    ->label('Like')
                    ->badge()
                    ->color('danger')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('has_replies')
                    ->label('Punya Balasan')
                    ->query(fn ($query) => $query->where('replies_count', '>', 0)),

                Tables\Filters\Filter::make('no_replies')
                    ->label('Belum Ada Balasan')
                    ->query(fn ($query) => $query->where('replies_count', 0)),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->label('Hapus')
                    ->modalHeading('Hapus Diskusi')
                    ->modalDescription('Diskusi dan semua balasannya akan dihapus permanen. Lanjutkan?'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListDiscussions::route('/'),
            'create' => Pages\CreateDiscussion::route('/create'),
            'view'   => Pages\ViewDiscussion::route('/{record}'),
            'edit'   => Pages\EditDiscussion::route('/{record}/edit'),
        ];
    }
}
