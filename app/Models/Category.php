<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = ['nama_kategori'];

    public function complaint()
    {
        return $this->hasMany(Complaint::class);
    }
}
