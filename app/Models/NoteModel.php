<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoteModel extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'notes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'related_id',
        'type', // e.g. person or address
        'note'
    ];

    public function related()
    {
        if (str_to_lower($this->type) === 'person') {
            return $this->belongsTo(Person::class, 'related_id');
        }

        if (str_to_lower($this->type) === 'address') {
            return $this->belongsTo(Address::class, 'related_id');
        }

        return null;
    }
}
