<?php namespace SublimeArts\BlogExtension\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use SublimeArts\BlogExtension\Models\Tag;
use Flash;

/**
 * Tags Back-end Controller
 */
class Tags extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('SublimeArts.BlogExtension', 'blogextension', 'tags');
    }

    /** Allow bulk deletion of Blog Tags in the backend */
    public function index_onDelete()
    {
        /** See if any rows were checked */
        if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) {

            foreach ($checkedIds as $tagId) {
                /** Don't do anything if a tag with the required ID is not found */
                if (( ! $tag = Tag::find($tagId)))
                    continue;

                /** Else delete the tag */
                $tag->delete();
            }

            Flash::success('Successfully deleted those tags.');
        }

        return $this->listRefresh();
    }
}
