<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikeOcurrence extends Model
{
    use HasFactory;

    protected $table = 'like_ocurrences';

    protected $fillable = ['user_id', 'ocurrence_id'];
}
