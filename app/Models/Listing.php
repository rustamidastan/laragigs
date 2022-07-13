<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class listing extends Model
{
    use HasFactory;

   protected $fillable = ['title', 'email', 'tags', 'description', 'location', 'website', 'company', 'logo', 'user_id'];

    public function scopeFilter($query, array $filters) {
        if($filters['tag'] ?? false) {
            $query->where('tags', 'like', '%'.request('tag').'%');
        }

        if($filters['search'] ?? false) {
            $query->where('title', 'like', '%'.request('search').'%')
            ->orWhere('description', 'like', '%'.request('search').'%')
            ->orWhere('location', 'like', '%'.request('search').'%');
        }
    }

    //Relationship To User

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
