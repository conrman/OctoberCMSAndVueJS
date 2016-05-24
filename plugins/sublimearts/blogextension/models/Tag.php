<?php namespace SublimeArts\BlogExtension\Models;

use Model, Str;

/**
 * Tag Model
 */
class Tag extends Model
{
    use \October\Rain\Database\Traits\Validation;

    public $table = 'sublimearts_blogextension_tags';

    public $rules = [
        'name' => 'required',
        'slug' => 'required|between:3,64|unique:sublimearts_blogextension_tags'
    ];

    public $belongsToMany = [
        'posts' => ['RainLab\Blog\Models\Post', 'table' => 'sublimearts_blogextension_posts_tags', 'order' => 'published_at desc',  'scope' => 'isPublished']
    ];

    public function beforeValidate()
    {
        // Generate a URL slug for this model
        if (!$this->exists && !$this->slug)
            $this->slug = Str::slug($this->name);
    }

    public function afterDelete()
    {
        $this->posts()->detach();
    }

    public function getPostCountAttribute()
    {
        return $this->posts()->count();
    }

    /**
     * Sets the "url" attribute with a URL to this object
     * @param string $pageName
     * @param Cms\Classes\Controller $controller
     */
    public function setUrl($pageName, $controller)
    {
        $params = [
            'id' => $this->id,
            'slug' => $this->slug,
        ];

        return $this->url = $controller->pageUrl($pageName, $params);
    }

}
