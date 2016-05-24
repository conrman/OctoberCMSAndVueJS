<?php namespace SublimeArts\BlogExtension\Models;

use Model;

/**
 * Stat Model
 */
class Stat extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'sublimearts_blogextension_stats';

    public $belongsTo = [
        'post' => ['RainLab\Blog\Models\Post']
    ];

}
