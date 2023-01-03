<?php

namespace App\Models\User\HomePage;

use App\Models\User\Language;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionTitle extends Model
{
    use HasFactory;

    public $table = 'user_section_titles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'language_id',
        'user_id',
        'category_section_title',
        'featured_courses_section_title',
        'featured_instructors_section_title',
        'testimonials_section_title',
        'features_section_title',
        'blog_section_title'
    ];

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}
