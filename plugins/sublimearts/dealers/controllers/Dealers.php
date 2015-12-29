<?php namespace SublimeArts\Dealers\Controllers;

use Lang;
use Flash;
use BackendMenu;
use BackendAuth;
use Backend\Classes\Controller;
use System\Classes\SettingsManager;
use SublimeArts\Dealers\Models\Dealer;
use SublimeArts\Dealers\Models\DealerGroup;
use SublimeArts\Dealers\Models\Settings as DealerSettings;

class Dealers extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig;

    public $requiredPermissions = ['sublimearts.dealers.access_dealers'];

    public $bodyClass = 'compact-container';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('SublimeArts.Dealers', 'dealers', 'dealers');
        SettingsManager::setContext('SublimeArts.Dealers', 'settings');
    }

    /**
     * {@inheritDoc}
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

    public function listExtendQuery($query)
    {
        $query->withTrashed();
    }

    public function formExtendQuery($query)
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
     * Manually activate a user
     */
    public function update_onActivate($recordId = null)
    {
        $model = $this->formFindModelObject($recordId);

        $model->attemptActivation($model->activation_code);

        Flash::success(Lang::get('sublimearts.dealers::lang.dealers.activated_success'));

        if ($redirect = $this->makeRedirect('update', $model)) {
            return $redirect;
        }
    }

    /**
     * Force delete a user.
     */
    public function update_onDelete($recordId = null)
    {
        $model = $this->formFindModelObject($recordId);

        $model->forceDelete();

        Flash::success(Lang::get('backend::lang.form.delete_success'));

        if ($redirect = $this->makeRedirect('delete', $model)) {
            return $redirect;
        }
    }

    /**
     * Deleted checked users
     */
    public function index_onDelete()
    {
        if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) {

            foreach ($checkedIds as $userId) {
                if (!$user = Dealer::find($userId)) {
                    continue;
                }
                $user->delete();
            }

            Flash::success(Lang::get('sublimearts.dealers::lang.dealers.delete_selected_success'));
        }
        else {
            Flash::error(Lang::get('sublimearts.dealers::lang.dealers.delete_selected_empty'));
        }

        return $this->listRefresh();
    }
}
