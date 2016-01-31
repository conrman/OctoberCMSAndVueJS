<?php namespace SublimeArts\Dealers\Controllers;

use Lang;
use Flash;
use BackendMenu;
use Backend\Classes\Controller;
use System\Classes\SettingsManager;
use SublimeArts\Dealers\Models\Dealer;
use SublimeArts\Dealers\Models\Settings as DealerSettings;
use SublimeArts\Dealers\Models\DealerGroup;


class Dealers extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public $requiredPermissions = ['sublimearts.dealers.access_dealers'];

    public $bodyClass = 'compact-container';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('SublimeArts.Dealers', 'dealers', 'dealers');
        SettingsManager::setContext('SublimeArts.Dealers', 'settings');
    }

    /**
     * Manually activate a Dealer
     */
    public function update_onActivate($recordId = null)
    {
        $model = $this->formFindModelObject($recordId);

        $model->attemptActivation($model->activation_code);

        Flash::success('Dealer was successfully Activated!');

        if ($redirect = $this->makeRedirect('update', $model)) {
            return $redirect;
        }
    }

    /**
     * Make it easier to spot Non-Active and Trashed dealers in the list
     */
    public function listInjectRowClass($record, $definition = null)
    {
        if ($record->trashed()) {
            return 'strike';
        }

        if (!$record->is_activated) {
            return 'disabled';
        }
    }

    public function formExtendQuery($query)
    {
        $query->withTrashed();
    }

    public function listExtendQuery($query)
    {
        $query->withTrashed();
    }

    /**
     * Display username field if settings permit
     */
    public function formExtendFields($form)
    {
        /*
         * Show the username field if it is configured for use
         */
        if (
            DealerSettings::get('login_attribute') == DealerSettings::LOGIN_USERNAME &&
            array_key_exists('username', $form->getFields())
        ) {
            $form->getField('username')->hidden = false;
        }
    }


    /**
     * Deleted checked users
     */
    public function index_onDelete()
    {
        if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) {

            foreach ($checkedIds as $dealerId) {
                if (!$dealer = Dealer::find($dealerId)) {
                    continue;
                }
                $dealer->delete();
            }

            Flash::success('Selected Dealers were deleted.');
        }
        else {
            Flash::error('No Dealers Selected!');
        }

        return $this->listRefresh();
    }

    /**
     * Force delete a user.
     */
    public function update_onDelete($recordId = null)
    {
        $model = $this->formFindModelObject($recordId);

        $model->forceDelete();

        Flash::success('Dealer deleted successfully!');

        if ($redirect = $this->makeRedirect('delete', $model)) {
            return $redirect;
        }
    }

}
