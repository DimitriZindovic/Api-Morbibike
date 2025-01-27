<?php

namespace App\Models;

use App\Http\Resources\UserResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use SupplementBacon\LaravelPaginable\Paginable;

class User extends Model
{
    use Paginable;

    const RESOURCE = UserResource::class;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'surname',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'name' => 'string',
            'surname'=> 'string',
        ];
    }

    public static function storeRules(): array
    {
        return [
            'name' => 'required|string',
            'surname' => 'required|string',
        ];
    }

    public static function updateRules(): array
    {
        return static::storeRules();
    }

    public function rents(): BelongsToMany
    {
        return $this->belongsToMany(Rent::class, 'rent_user');
    }
}
