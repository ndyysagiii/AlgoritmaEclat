<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Confidence extends Model
{
    use HasFactory;

    protected $table = 'confidence';

    protected $fillable = [
        'items',
        'support_xUy',
        'support_x',
        'confidence',
        'lift_ratio',
        'korelasi',
        'itemset2_id',
        'itemset3_id'
    ];

    public function itemset2()
    {
        return $this->belongsTo(Itemset2::class, 'itemset2_id');
    }

    public function itemset3()
    {
        return $this->belongsTo(Itemset3::class, 'itemset3_id');
    }
}
