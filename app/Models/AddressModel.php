<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class AddressModel extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'addresses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'person_id',
        'street_name',
        'street_number',
        'postal_code',
        'city'
    ];

    /**
     * Get the person associated with the address.
     */
    public function person()
    {
        return $this->belongsTo(PersonModel::class, 'person_id');
    }

    /**
     * Get the notes associated with the person.
     */
    public function notes(): HasMany
    {
        return $this->hasMany(NoteModel::class, 'related_id')->where('type', 'address');
    }
}
