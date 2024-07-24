<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Onecup extends Model
{
    use HasFactory;

    protected $fillable = [
        // 既存の属性
        'name',
        'quantity', // 新しく追加
    ];
}
