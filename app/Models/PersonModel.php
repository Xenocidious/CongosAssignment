<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class PersonModel extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'persons';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'surname',
        'email'
    ];

    /**
     * Get the addresses associated with the person.
     */
    public function addresses(): HasMany
    {
        return $this->hasMany(AddressModel::class, 'person_id');
    }

    /**
     * Get the notes associated with the person.
     */
    public function notes(): HasMany
    {
        return $this->hasMany(NoteModel::class, 'related_id')->where('type', 'person');
    }
}
