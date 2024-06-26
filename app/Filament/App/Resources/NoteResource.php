<?php

namespace App\Filament\App\Resources;

use AbdelhamidErrahmouni\FilamentMonacoEditor\MonacoEditor;
use App\Filament\App\Resources\NoteResource\Pages;
use App\Filament\App\Resources\NoteResource\RelationManagers;
use App\Models\Note;
use App\Tables\Columns\BlockTypesBadge;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;

class NoteResource extends Resource
{
    protected static ?string $model = Note::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';
    protected static ?int $navigationSort = 1;



    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required(),
                Forms\Components\SpatieTagsInput::make('tags'),

                Forms\Components\Builder::make('content')
                    ->columnSpanFull()
                    ->blocks([
                        Forms\Components\Builder\Block::make('link')
                            ->columns(2)
                            ->inlineLabel()
                            ->icon('heroicon-o-link')
                            ->schema([
                                Forms\Components\TextInput::make('url')
                                    ->hiddenLabel()
                                    ->placeholder('url')
                                    ->required()
                                    ->prefixAction(
                                        fn ($state) => Forms\Components\Actions\Action::make('url')
                                            ->url($state)
                                            ->openUrlInNewTab()
                                            ->icon('heroicon-o-link')
                                    ),
                                Forms\Components\TextInput::make('title')
                                    ->hiddenLabel()
                                    ->placeholder('Title'),
                            ]),

                        Forms\Components\Builder\Block::make('code')
                            ->icon('heroicon-o-code-bracket')
                            ->schema([
                                Forms\Components\Select::make('language')
                                    ->options([
                                        'bash' => 'Bash',
                                        'bat' => 'Batch',
                                        'c' => 'C',
                                        'csharp' => 'C#',
                                        'css' => 'CSS',
                                        'csv' => 'CSV',
                                        'dart' => 'Dart',
                                        'diff' => 'Diff',
                                        'dockerfile' => 'Dockerfile',
                                        'elixir' => 'Elixir',
                                        'go' => 'Go',
                                        'html' => 'HTML',
                                        'ini' => 'INI',
                                        'java' => 'Java',
                                        'javascript' => 'JavaScript',
                                        'json' => 'JSON',
                                        'kotlin' => 'Kotlin',
                                        'less' => 'Less',
                                        'lua' => 'Lua',
                                        'markdown' => 'Markdown',
                                        'perl' => 'Perl',
                                        'php' => 'PHP',
                                        'python' => 'Python',
                                        'redis' => 'Redis',
                                        'ruby' => 'Ruby',
                                        'rust' => 'Rust',
                                        'scss' => 'SCSS',
                                        'sql' => 'SQL',
                                        'swift' => 'Swift',
                                        'typescript' => 'TypeScript',
                                        'xml' => 'XML',
                                        'yaml' => 'YAML',
                                    ])
                                    ->live(),

                                MonacoEditor::make('content')
                                    ->language(fn($get) => ($get('language') ?? 'html'))
                                    ->disablePreview(true),
                            ]),

                        Forms\Components\Builder\Block::make('markdown')
                            ->icon('heroicon-o-code-bracket-square')
                            ->schema([
                                Forms\Components\MarkdownEditor::make('content'),
                            ]),

                        Forms\Components\Builder\Block::make('richtext')
                            ->icon('heroicon-o-code-bracket-square')
                            ->schema([
                                Forms\Components\RichEditor::make('content'),
                            ]),

                        Forms\Components\Builder\Block::make('text')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Forms\Components\Textarea::make('content'),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),

                BlockTypesBadge::make('content')
                    ->color(Color::Cyan),

                Tables\Columns\SpatieTagsColumn::make('tags'),
            ])
            ->filters([

            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNotes::route('/'),
            'create' => Pages\CreateNote::route('/create'),
            'view' => Pages\ViewNote::route('/{record}'),
            'edit' => Pages\EditNote::route('/{record}/edit'),
        ];
    }
}
