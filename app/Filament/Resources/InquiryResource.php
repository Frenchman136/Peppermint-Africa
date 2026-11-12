<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InquiryResource\Pages;
use App\Models\Inquiry;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;

class InquiryResource extends Resource
{
    protected static ?string $model = Inquiry::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-inbox';

    protected static ?int $navigationSort = 0;

    protected static ?string $navigationLabel = 'Inquiries';

    protected static ?string $recordTitleAttribute = 'name';

    /** Inquiries only come from the website contact form. */
    public static function canCreate(): bool
    {
        return false;
    }

    /** Number of new (unhandled) inquiries, shown in the sidebar. */
    public static function getNavigationBadge(): ?string
    {
        $count = Inquiry::where('status', 'new')->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('From the visitor')
                ->description('Read-only. Reply by email or phone.')
                ->schema([
                    TextInput::make('name')->disabled(),
                    TextInput::make('email')->disabled(),
                    TextInput::make('phone')->disabled(),
                    TextInput::make('organisation')->disabled(),
                    TextInput::make('service')->label('Interested in')->disabled(),
                    TextInput::make('created_at')->label('Received')->disabled(),
                    Textarea::make('message')->disabled()->rows(7)->columnSpanFull(),
                ])
                ->columns(2),

            Section::make('Follow-up')
                ->schema([
                    Select::make('status')
                        ->options(['new' => 'New', 'contacted' => 'Contacted', 'closed' => 'Closed'])
                        ->required(),
                    Textarea::make('notes')
                        ->label('Internal notes')
                        ->rows(4)
                        ->helperText('Only visible to your team.')
                        ->columnSpanFull(),
                ])
                ->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')->label('Received')->dateTime('j M Y, H:i')->sortable(),
                TextColumn::make('name')->searchable(),
                TextColumn::make('email')->searchable()->copyable(),
                TextColumn::make('service')->label('Interested in')->wrap()->toggleable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'new' => 'warning',
                        'contacted' => 'info',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')->options(['new' => 'New', 'contacted' => 'Contacted', 'closed' => 'Closed']),
            ])
            ->recordActions([EditAction::make()->label('Open')])
            ->toolbarActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInquiries::route('/'),
            'edit' => Pages\EditInquiry::route('/{record}/edit'),
        ];
    }
}
