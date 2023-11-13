<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WorkResource\Pages;
use App\Models\Work;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class WorkResource extends Resource
{
    protected static ?string $model = Work::class;

    protected static ?string $recordTitleAttribute = 'employee.names';

    protected static ?string $navigationIcon = 'heroicon-o-queue-list';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('employee_id')
                    ->label('Employee')
                    ->relationship('employee', 'phone_number')
                    ->reactive()
                    ->searchable()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('names')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Enter employee names'),

                        Forms\Components\TextInput::make('phone_number')
                            ->label('Phone number')
                            ->unique()
                            ->required()
                            ->placeholder('Enter phone number'),
                        Forms\Components\Hidden::make('user_id')
                            ->default(Auth::user()->id),

                    ])
                    ->required(),

                Forms\Components\TextInput::make('bar_amount')
                    ->label('Bar Amount')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set) {
                        $total = $get('bar_amount') + $get('kitchen_amount') + $get('chamber_amount') + $get('bingalo_amount');
                        $set('total', $total);
                    })
                    ->numeric()
                    ->placeholder('Enter bar amount'),

                Forms\Components\TextInput::make('kitchen_amount')
                    ->label('Kitchen Amount')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set) {
                        $total = $get('bar_amount') + $get('kitchen_amount') + $get('chamber_amount') + $get('bingalo_amount');
                        $set('total', $total);
                    })
                    ->numeric()
                    ->placeholder('Enter kitchen amount'),

                Forms\Components\TextInput::make('chamber_amount')
                    ->label('Chamber Amount')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set) {
                        $total = $get('bar_amount') + $get('kitchen_amount') + $get('chamber_amount') + $get('bingalo_amount');
                        $set('total', $total);
                    })
                    ->numeric()
                    ->placeholder('Enter chamber amount'),

                Forms\Components\TextInput::make('bingalo_amount')
                    ->label('Bingalo Amount')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set) {
                        $total = $get('bar_amount') + $get('kitchen_amount') + $get('chamber_amount') + $get('bingalo_amount');
                        $set('total', $total);
                    })
                    ->numeric()
                    ->placeholder('Enter bingalo amount'),

                Forms\Components\TextInput::make('cash_in')
                    ->label('Cash In')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set) {
                        $total = $get('total', 0);
                        $cashIn = $get('cash_in', 0);
                        $cashOut = $get('cash_out', 0);
                        $payout = ($total / 30) + $cashIn - $cashOut;
                        $set('payout', $payout);
                    })
                    ->numeric()
                    ->placeholder('Enter cash in'),

                Forms\Components\TextInput::make('cash_out')
                    ->label('Cash Out')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set) {
                        $total = $get('total', 0);
                        $cashIn = $get('cash_in', 0);
                        $cashOut = $get('cash_out', 0);
                        $payout = ($total / 30) + $cashIn - $cashOut;
                        $set('payout', $payout);
                    })
                    ->numeric()
                    ->placeholder('Enter cash out'),

                Forms\Components\Hidden::make('payout')
                    ->label('Payout')
                    ->disabled()
                    ->dehydrated(),

                Forms\Components\TextInput::make('total')
                    ->label('Total')
                    ->disabled()
                    ->dehydrated()
                    ->required()
                    ->numeric()
                    ->placeholder('Total will be calculated'),
                Forms\Components\Hidden::make('user_id')
                    ->default(Auth::user()->id),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employee.names')
                    ->sortable(),
                Tables\Columns\TextColumn::make('bar_amount')
                    ->numeric()
                    ->money('rwf')
                    ->sortable(),
                Tables\Columns\TextColumn::make('kitchen_amount')
                    ->numeric()
                    ->money('rwf')
                    ->sortable(),
                Tables\Columns\TextColumn::make('chamber_amount')
                    ->numeric()
                    ->money('rwf')
                    ->sortable(),
                Tables\Columns\TextColumn::make('bingalo_amount')
                    ->numeric()
                    ->money('rwf')
                    ->sortable(),
                Tables\Columns\TextColumn::make('cash_in')
                    ->numeric()
                    ->money('rwf')
                    ->sortable(),
                Tables\Columns\TextColumn::make('cash_out')
                    ->numeric()
                    ->money('rwf')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->numeric()
                    ->money('rwf')
                    ->sortable(),
                Tables\Columns\TextColumn::make('payout')
                    ->numeric()
                    ->money('rwf')
                    ->sortable(),
            ])
            ->filters([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageWorks::route('/'),
        ];
    }
}
