<?php

namespace App\Models;

use Awcodes\Curator\Components\Forms\CuratorPicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Product extends Model
{
    use HasFactory;
    use HasSlug;

    protected $guarded = ['id'];

    public static function getForm(): array
    {
        return [
            Group::make()
                ->schema([
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('price')
                        ->required()
                        ->numeric()
                        ->prefix('$'),
                    RichEditor::make('description')
                        ->columnSpanFull(),
                ])
                ->columnSpan(8),
            Group::make()
                ->schema([
                    CuratorPicker::make('media_id')
                        ->label('Cover Image')
                ])
                ->columnSpan(4),
        ];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class);
    }

    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
