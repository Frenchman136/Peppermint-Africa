<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-newspaper';

    protected static string|UnitEnum|null $navigationGroup = 'Website content';

    protected static ?int $navigationSort = 7;

    protected static ?string $navigationLabel = 'Blog posts';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Article')
                ->schema([
                    TextInput::make('title')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                ->afterStateUpdated(function (Set $set, Get $get, ?string $state, string $operation) {
                    if ($operation === 'create' && blank($get('slug'))) {
                        $set('slug', Str::slug($state ?? ''));
                    }
                }),
                    TextInput::make('slug')
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true)
                        ->helperText('Part of the page address. Changing it later breaks existing links.'),
                    TextInput::make('category')
                        ->maxLength(80)
                        ->datalist(['Events', 'Public Relations', 'Strategy', 'Branding', 'Digital', 'News']),
                    TextInput::make('author_name')->default('Peppermint Africa Team')->maxLength(120),
                    Textarea::make('excerpt')
                        ->rows(2)
                        ->maxLength(300)
                        ->helperText('Short teaser shown on cards. Leave blank to use the start of the article.')
                        ->columnSpanFull(),
                    MarkdownEditor::make('body')
                        ->required()
                        ->columnSpanFull()
                        ->helperText('Use ## for headings. Raw HTML is ignored for safety.'),
                ])
                ->columns(2),

            Section::make('Cover & publishing')
                ->schema([
                    FileUpload::make('cover_image')
                        ->image()
                        ->disk('public')
                        ->directory('blog')
                        ->visibility('public')
                        ->maxSize(5120)
                        ->helperText('Wide image, about 1600 x 900.'),
                    DateTimePicker::make('published_at')
                        ->default(now())
                        ->helperText('A future date schedules the post.'),
                    Toggle::make('is_published')->label('Published')->default(true),
                    Toggle::make('is_featured')->label('Featured at the top of the Blog'),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('cover_url')->label('Cover')->square(),
                TextColumn::make('title')->searchable()->wrap(),
                TextColumn::make('category')->badge(),
                TextColumn::make('published_at')->dateTime('j M Y')->sortable(),
                ToggleColumn::make('is_featured')->label('Featured'),
                ToggleColumn::make('is_published')->label('Published'),
            ])
            ->defaultSort('published_at', 'desc')
            ->recordActions([
                Action::make('visit')
                    ->label('View on site')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->url(fn (Post $record) => route('blog.show', $record->slug))
                    ->openUrlInNewTab(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
