<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    protected $fillable = [
        'title_ar', 'title_en', 'slug', 'body_ar', 'body_en', 
        'image', 'featured_image', 'status', 'category', 'views', 
        'tags', 'meta_title_ar', 'meta_title_en', 
        'meta_description_ar', 'meta_description_en'
    ];
    
    protected $casts = [
        'views' => 'integer',
        'status' => 'boolean',
    ];



    use Sluggable;

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }



    public function status()
    {
        return $this->status ? trans('back.Active') : trans('back.Inactive');
    }

    public function featured()
    {
        return $this->featured ? trans('back.featured') : trans('back.not_featured');
    }


    public function Images()
    {
        return $this->hasMany(Image::class, );
    }
    
    // Increment views
    public function incrementViews()
    {
        $this->increment('views');
    }
    
    // Get category label
    public function getCategoryLabelAttribute()
    {
        $categories = [
            'news' => ['ar' => 'أخبار', 'en' => 'News'],
            'tips' => ['ar' => 'نصائح', 'en' => 'Tips'],
            'guides' => ['ar' => 'أدلة', 'en' => 'Guides'],
            'offers' => ['ar' => 'عروض', 'en' => 'Offers'],
            'events' => ['ar' => 'فعاليات', 'en' => 'Events'],
        ];
        
        $locale = app()->getLocale();
        return $categories[$this->category][$locale] ?? $this->category;
    }
    
    // Get tags as array
    public function getTagsArrayAttribute()
    {
        return $this->tags ? explode(',', $this->tags) : [];
    }
    
    // Scope for published posts
    public function scopePublished($query)
    {
        return $query->where('status', 1);
    }
    
    // Scope for category
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
    
    // Scope for popular posts
    public function scopePopular($query)
    {
        return $query->orderBy('views', 'desc');
    }

}
