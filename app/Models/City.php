<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = ['state_id','country_id', 'name'];

    public function state() {
        return $this->belongsTo(State::class);
    }

    public function country() {
        return $this->belongsTo(Country::class);
    }

    public function employees() {
            return $this->hasMany(Employee::class);
    }

}
