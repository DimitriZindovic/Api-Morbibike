<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Rent extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'bike_id',
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
            'bike_id' => 'required|exists:bikes,id',
            'name' => 'required|string',
            'start_date'=> 'required|date',
            'end_date'=> 'required|date',
            'user_id'=> 'required|array',
            'user_id.*' => 'exists:users,id',
        ];
    }

    public static function updateRules(): array
    {
        return static::storeRules();
    }

    protected function bike(): BelongsTo
    {
        return $this->belongsTo(Bike::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'rent_user');
    }
}
