<?php

namespace App\Models;

use App\Models\Credit;
use App\Models\Facture;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory, SoftDeletes;

        /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'description',
    ];

    public function credits(): HasMany
    {
        return $this->hasMany(Credit::class);
    }

    public function factures(): HasMany
    {
        return $this->hasMany(Facture::class);
    }


}
