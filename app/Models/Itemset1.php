<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itemset1 extends Model
{
    use HasFactory;

    protected $table = 'itemset1';

    protected $fillable = [
        'atribut',
        'support',
        'keterangan',
        'proses_id'
    ];

    public function proses()
    {
        return $this->belongsTo(Proses::class);
    }
}
