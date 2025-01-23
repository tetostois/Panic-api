<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panic extends Model
{
    use HasFactory;

    /**
     * Les attributs qui sont mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'longitude',
        'latitude',
        'panic_type',
        'details',
        'user_id', // Clé étrangère pour lier à l'utilisateur
    ];

    /**
     * Relation avec l'utilisateur.
     * Une panique appartient à un utilisateur.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}