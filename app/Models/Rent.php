<?php

namespace App\Models;

use App\Http\Resources\RentResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use SupplementBacon\LaravelPaginable\Paginable;

class Rent extends Model
{
    use Paginable;

    const RESOURCE = RentResource::class;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'start_date',
        'end_date',
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
            'start_date'=> 'date',
            'end_date'=> 'date',
        ];
    }

    public static function storeRules(): array
    {
        return [
            'name' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'users' => 'required|array',
            'users.*.user' => 'exists:users,id',
            'users.*.bike' => 'exists:bikes,id',
        ];
    }

    public static function updateRules(): array
    {
        return static::storeRules();
    }

    public function bikes(): BelongsToMany
    {
        return $this->belongsToMany(Bike::class, 'rent_user')->withPivot('user_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'rent_user')->withPivot('bike_id');
    }
}
