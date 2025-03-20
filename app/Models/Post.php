<?php

namespace App\Models;

use App\Traits\RecordUserActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kyslik\ColumnSortable\Sortable;

class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory, RecordUserActivity, SoftDeletes,Sortable;

    /* properties */

    protected $fillable = ['author_id', 'photo_id', 'title', 'content', 'slug', 'is_published', 'created_by', 'updated_by'];

    // protected $guarded=['id'];
    public $sortable = ['title', 'content', 'created_at', 'updated_at'];

    /* relations */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }

    public function categories()
    {
        return $this->morphToMany(Category::class, 'categoryable');
    }

    /* filters (scopes) */
    public function scopeFilter($query, $searchterm)
    {
        if (! empty($searchterm)) {
            $query->where(function ($q) use ($searchterm) {
                $q->where('title', 'like', "%{$searchterm}%")
                    ->orWhere('content', 'like', "%{$searchterm}%");
            });
        }

        return $query;
    }

    // scope: alleen gepubliceerde posts
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->with([
                'author:id,name',
                'photo:id,path',
                'categories:id,name',
            ]);
    }
    // scope:filter op posts op basis van categorieen (polymorfe relatie)
    // dit gaat na of een post in ALLE geselecteerde categorieen zit.

    // $gefilterdePosts = Post::inCategories([1,2,3])->get();
    public function scopeInCategories($query, $categoryIds)
    {
        if (! empty($categoryIds)) {
            foreach ($categoryIds as $categoryId) {
                $query->whereHas('categories', function ($q) use ($categoryId) {
                    $q->where('categories.id', '=', $categoryId);
                });
            }
        }

        return $query;
    }

    public function comments()
    {
        return $this->hasMany(PostComment::class);
    }

    //
}
