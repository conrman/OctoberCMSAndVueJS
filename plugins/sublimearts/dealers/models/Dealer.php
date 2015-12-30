<?php namespace SublimeArts\Dealers\Models;

use Mail;
use Event;
use October\Rain\Auth\Models\User as DealerBase;
use SublimeArts\Dealers\Models\Settings as DealerSettings;

/**
 * Dealer Model
 */
class Dealer extends DealerBase
{

    use \October\Rain\Database\Traits\SoftDeleting;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'sublimearts_dealers_dealers';

    /**
     * Validation rules
     */
    public $rules = [
        'email'    => 'required|between:6,255|email|unique:sublimearts_dealers_dealers',
        'username' => 'required|between:2,255|unique:sublimearts_dealers_dealers',
        'password' => 'required:create|between:4,255|confirmed',
        'password_confirmation' => 'required_with:password|between:4,255'
    ];

    /**
     * @var array The attributes that are mass assignable.
     */
    protected $fillable = [
        'username',
        'email',
        'company_name',
        'password',
        'password_confirmation'
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [
        'info' => 'SublimeArts\Dealers\Models\Info'
    ];

    public $attachOne = [
        'avatar' => ['System\Models\File']
    ];

    public $belongsTo = [
        'group' => ['SublimeArts\Dealers\Models\DealerGroup', 'key' => 'dealers_group_id']
    ];

    /**
     * Purge attributes from data set.
     */
    protected $purgeable = ['password_confirmation'];

    public static $loginAttribute = null;

    /**
     * @return string Returns the name for the user's login.
     */
    public function getLoginName()
    {
        if (static::$loginAttribute !== null) {
            return static::$loginAttribute;
        }
        return static::$loginAttribute = DealerSettings::get('login_attribute', DealerSettings::LOGIN_EMAIL);
    }

    /**
     * Before validation event
     * @return void
     */
    public function beforeValidate()
    {
        /*
         * When the username is not used, the email is substituted.
         */
        if (
            (!$this->username) ||
            ($this->isDirty('email') && $this->getOriginal('email') == $this->username)
        ) {
            $this->username = $this->email;
        }
    }

    public function afterLogin()
    {
        if ($this->trashed()) {
            $this->last_login = $this->freshTimestamp();
            $this->restore();
            Mail::sendTo($this, 'sublimearts.dealers::mail.reactivate', [
                'name' => $this->company_name
            ]);
            Event::fire('sublimearts.dealers.reactivate', [$this]);
        }
        else {
            parent::afterLogin();
        }
        Event::fire('sublimearts.dealers.login', [$this]);
    }

    /**
     * After delete event
     * @return void
     */
    public function afterDelete()
    {
        if ($this->isSoftDelete()) {
            Event::fire('sublimearts.dealers.deactivate', [$this]);
            return;
        }
        $this->avatar && $this->avatar->delete();
        parent::afterDelete();
    }

    public function scopeIsActivated($query)
    {
        return $query->where('is_activated', 1);
    }

    public function scopeFilterByGroup($query, $filter)
    {
        return $query->whereHas('groups', function($group) use ($filter) {
            $group->whereIn('id', $filter);
        });
    }

    /**
     * Gets a code for when the user is persisted to a cookie or session which identifies the user.
     * @return string
     */
    public function getPersistCode()
    {
        if (!$this->persist_code) {
            return parent::getPersistCode();
        }
        return $this->persist_code;
    }

    /**
     * Returns the public image file path to this user's avatar.
     */
    public function getAvatarThumb($size = 25, $options = null)
    {
        if (is_string($options)) {
            $options = ['default' => $options];
        }
        elseif (!is_array($options)) {
            $options = [];
        }
        // Default is "mm" (Mystery man)
        $default = array_get($options, 'default', 'mm');
        if ($this->avatar) {
            return $this->avatar->getThumb($size, $size, $options);
        }
        else {
            return '//www.gravatar.com/avatar/'.
            md5(strtolower(trim($this->email))).
            '?s='.$size.
            '&d='.urlencode($default);
        }
    }

    /**
     * Sends the confirmation email to a user, after activating.
     * @param  string $code
     * @return void
     */
    public function attemptActivation($code)
    {
        $result = parent::attemptActivation($code);
        if ($result === false) {
            return false;
        }
        if ($mailTemplate = DealerSettings::get('welcome_template')) {
            Mail::sendTo($this, $mailTemplate, [
                'name'  => $this->company_name,
                'email' => $this->email
            ]);
        }
        return true;
    }

    /**
     * Looks up a dealer by their email address.
     * @return self
     */
    public static function findByEmail($email)
    {
        if (!$email) {
            return;
        }
        return self::where('email', $email)->first();
    }

}