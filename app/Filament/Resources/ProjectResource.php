<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-photo';

    protected static string|UnitEnum|null $navigationGroup = 'Website content';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Projects (Work)';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Project details')
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
                        ->helperText('Part of the page address. Changing it later breaks existing links to this project.'),
                    TextInput::make('client')
                        ->maxLength(255)
                        ->helperText('e.g. USAID, Government of Makueni County'),
                    TextInput::make('year')
                        ->numeric()
                        ->minValue(2000)
                        ->maxValue(2100),
                    Select::make('service_id')
                        ->label('Service')
                        ->relationship('service', 'title')
                        ->searchable()
                        ->preload(),
                    Select::make('industry_id')
                        ->label('Sector')
                        ->relationship('industry', 'name')
                        ->searchable()
                        ->preload(),
                    Textarea::make('summary')
                        ->required()
                        ->rows(3)
                        ->maxLength(600)
                        ->helperText('One or two sentences. Shown on cards and at the top of the case study.')
                        ->columnSpanFull(),
                ])
                ->columns(2),

            Section::make('Case study')
                ->description('Optional. Each part appears on the website only when filled in. Separate paragraphs with a blank line.')
                ->schema([
                    Textarea::make('challenge')->rows(5)->columnSpanFull(),
                    Textarea::make('approach')->label('Our approach')->rows(5)->columnSpanFull(),
                    Textarea::make('result')->label('The result')->rows(5)->columnSpanFull(),
                ]),

            Section::make('Photos & video')
                ->schema([
                    FileUpload::make('cover_image')
                        ->image()
                        ->disk('public')
                        ->directory('projects')
                        ->visibility('public')
                        ->maxSize(5120)
                        ->helperText('Wide photo, ideally 1600px across. Max 5 MB.'),
                    FileUpload::make('gallery')
                        ->image()
                        ->multiple()
                        ->reorderable()
                        ->maxFiles(24)
                        ->disk('public')
                        ->directory('projects/gallery')
                        ->visibility('public')
                        ->maxSize(5120)
                        ->helperText('Drag to reorder. Max 24 photos, 5 MB each.'),
                    TextInput::make('video_url')
                        ->url()
                        ->placeholder('https://www.youtube.com/watch?v=...')
                        ->helperText('YouTube or Vimeo link. It only loads when a visitor clicks play.'),
                ]),

            Section::make('Publishing')
                ->schema([
                    Toggle::make('is_published')
                        ->label('Published (visible on the website)')
                        ->default(true),
                    Toggle::make('is_featured')
                        ->label('Featured on the Home page'),
                    TextInput::make('sort_order')
                        ->numeric()
                        ->default(0)
                        ->helperText('Lower numbers appear first.'),
                ])
                ->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('cover_url')->label('Cover')->square(),
                TextColumn::make('title')->searchable()->sortable()->wrap(),
                TextColumn::make('service.title')->label('Service')->badge()->sortable(),
                TextColumn::make('industry.name')->label('Sector')->toggleable(isToggledHiddenByDefault: true),
                ToggleColumn::make('is_featured')->label('Featured'),
                ToggleColumn::make('is_published')->label('Published'),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->filters([
                SelectFilter::make('service_id')->label('Service')->relationship('service', 'title'),
                TernaryFilter::make('is_published')->label('Published'),
            ])
            ->recordActions([
                Action::make('visit')
                    ->label('View on site')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->url(fn (Project $record) => route('work.show', $record->slug))
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
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
