<?php

namespace App\Filament\Resources\Users;

use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\Schemas\UserForm;
use App\Filament\Resources\Users\Tables\UsersTable;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;


use Filament\Tables\Table;
// use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use App\Notifications\AccountVerifiedNotification;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'first_name';

    public static function form(Schema $schema): Schema
    {
        // return UserForm::configure($schema);
        return $schema->schema([
            Section::make('Basic user information')->schema([
                TextInput::make('first_name')->required()->label('first_name'),
                TextInput::make('last_name')->required()->label('last_name'),
                TextInput::make('phone')->required()->label('Phone'),

                Select::make('role')
                    ->label('Role')
                    ->options([
                        'admin' => 'Admin',
                        'user' => 'User',
                    ])
                    ->required(),
                Toggle::make('is_verified')->label('Verified')->default(false)
                    ->disabled(fn(string $operation, $record) => $operation === 'edit' && $record && $record->is_verified),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('first_name')->label('First Name')->searchable()->sortable(),
            TextColumn::make('last_name')->label('Last Name')->searchable()->sortable(),
            TextColumn::make('phone')->label('Phone'),
            TextColumn::make('role')->label('Role')->badge()->color(fn(string $state): string => match ($state) {
                'admin' => 'danger',
                'user' => 'success',
            }),
            IconColumn::make('is_verified')->label('Verified')->boolean(),
        ])
            ->filters([
                Filter::make('pending_approval')->label('Pending Approval')->query(fn(Builder $query) => $query->where('is_verified', false))
            ])
            ->actions([
                Action::make('Verify User')->label('Verify User')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function(User $record){
                        $record->update(['is_verified' => true]);
                        // Send notification
                        $notification = new AccountVerifiedNotification($record);
                        $record->notify($notification);
                        $notification->toFirebase($record);
                        Notification::make()
                            ->title('User Verified.')
                            ->body('The user has been verified and notified successfully')
                            ->success()
                            ->send();
                    })
                    ->hidden(fn(User $record) => $record->is_verified),
                EditAction::make(),
                DeleteAction::make(),
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
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
