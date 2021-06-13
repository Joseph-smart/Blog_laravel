<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
//    use SoftDeletes;
    protected $table = 'article';
    protected $primaryKey = 'id';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'cate_id',
        'title',
        'tag',
        'description',
        'cover',
        'content',
        'view',
    ];
}
