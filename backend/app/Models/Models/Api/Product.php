<?php

namespace App\Models\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'situation',
        'category_id',
        'imagem_uuid'
    ];

    #crar um campo customizado chamado url
    protected $appends = ['imageUrl'];
    public function getImageUrlAttribute()
    {
        return url('/api/image/'.$this->imagem_uuid);
    }

    #retornar o nome da category

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
