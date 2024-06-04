<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proses extends Model
{
    use HasFactory;

    protected $table = 'proses';

    protected $fillable = [
        'start',
        'end',
        'min_support',
        'min_confidence'
    ];

    public function itemset1()
    {
        return $this->hasMany(Itemset1::class);
    }

    public function itemset2()
    {
        return $this->hasMany(Itemset2::class);
    }

    public function itemset3()
    {
        return $this->hasMany(Itemset3::class);
    }
}
