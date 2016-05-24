<?php namespace SublimeArts\BlogExtension;

use System\Classes\PluginBase;
use RainLab\Blog\Models\Post as PostModel;
use RainLab\Blog\Controllers\Posts as PostsController;
use Backend;
use Event;


/**
 * BlogExtension Plugin Information File
 */
class Plugin extends PluginBase
{

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'BlogExtension',
            'description' => 'Adds some custom features to the RainLab.Blog Plugin',
            'author'      => 'SublimeArts for VerveTronix',
            'homepage'    => 'http://www.sublimearts.me',
            'icon'        => 'icon-leaf'
        ];
    }

    public function boot()
    {
        PostModel::extend(function($model) {
            $model->belongsToMany['tags'] = ['SublimeArts\BlogExtension\Models\Tag', 'table' => 'sublimearts_blogextension_posts_tags', 'order' => 'name asc'];
        });

        PostsController::extendListColumns(function($list, $model) {
            if(!$model instanceOf PostModel)
                return;

            $list->addColumns([
                'tags' => [
                    'label' => 'Tags',
                    'relation' => 'tags',
                    'select' => 'name',
                    'searchable' => 'true'
                ]
            ]);
        });

        PostsController::extendFormFields(function($form, $model, $context) {
            // if(!$model instanceOf PostModel)
            //     return;

            $form->addSecondaryTabFields([
                'tags' => [
                    'tab'  => 'Tags',
                    'type' => 'relation',
                    'commentAbove' => 'Select tags to be attached to this post'
                ]
            ]);
        });

        Event::listen('backend.menu.extendItems', function($manager)
        {
           $manager->addSideMenuItems('RainLab.Blog', 'blog', [
                'tags' => [
                    'label'       => 'Tags',
                    'icon'        => 'icon-tags',
                    'code'        => 'tags',
                    'owner'       => 'RainLab.Blog',
                    'url'         => Backend::url('sublimearts/blogextension/tags')
                ],
            ]);

        });
    }
}
