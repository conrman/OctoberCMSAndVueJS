<?php namespace SublimeArts\Dealers\Models;

use Form;
use Model;
use System\Models\MailTemplate;
use Exception;

/**
 * MailBlocker Model
 */
class MailBlocker extends Model
{

    /**
     * @var string The database table used by the model.
     */
    public $table = 'sublimearts_dealers_mail_blockers';

    /**
     * @var array Relations
     */
    public $belongsTo = [
        'dealer' => ['SublimeArts\Dealers\Models\Dealer']
    ];

    /**
     * Sets mail blocking preferences for a dealer. Eg:
     *
     * MailBlocker::setPreferences($dealer, [acme.blog::post.new_reply => 0])
     *
     * MailBlocker::setPreferences($dealer, [acme.blog::post.new_reply => 0], [fillable => [acme.blog::post.new_reply]])
     *
     * MailBlocker::setPreferences($dealer, [template_alias => 0], [aliases => [template_alias => acme.blog::post.new_reply]])
     *
     * Supported options:
     * - aliases: Alias definitions, with alias as key and template as value.
     * - fillable: An array of expected templates, undefined templates are ignored.
     * - verify: Only allow mail templates that are registered in the system.
     *
     * @param  SublimeArts\Dealers\Models\Dealer $dealer
     * @param  array $templates Template name as key and boolean as value. If false, template is blocked.
     * @param  array $options
     * @throws Exception
     */
    public static function setPreferences($dealer, $templates, $options = [])
    {
        $templates = (array) $templates;

        if (!$dealer) {
            throw new Exception('A dealer must be provided for MailBlocker::setPreferences');
        }

        extract(array_merge([
            'aliases' => [],
            'fillable' => [],
            'verify' => false,
        ], $options));

        if ($aliases) {
            $fillable = array_merge($fillable, array_values($aliases));
            $templates = array_build($templates, function($key, $value) use ($aliases) {
                return [array_get($aliases, $key, $key), $value];
            });
        }

        if ($fillable) {
            $templates = array_intersect_key($templates, array_flip($fillable));
        }

        if ($verify) {
            $existing = MailTemplate::listAllTemplates();
            $templates = array_intersect_key($templates, $existing);
        }

        $currentBlocks = array_flip(static::checkAllForDealer($dealer));
        foreach ($templates as $template => $value) {
            // Dealer wants to receive mail and is blocking
            if ($value && isset($currentBlocks[$template])) {
                static::removeBlock($template, $dealer);
            }
            // Dealer does not want to receive mail and not blocking
            elseif (!$value && !isset($currentBlocks[$template])) {
                static::addBlock($template, $dealer);
            }
        }
    }

    /**
     * Adds a block for a dealer and a mail view/template code.
     * @param string                   $template
     * @param SublimeArts\Dealers\Models\Dealer $dealer
     * @return bool
     */
    public static function addBlock($template, $dealer)
    {
        $blocker = static::firstOrNew([
            'template' => $template,
            'dealer_id' => $dealer->id
        ]);

        $blocker->email = $dealer->email;
        $blocker->save();
        return $blocker;
    }

    /**
     * Removes a block for a dealer and a mail view/template code.
     * @param string                   $template
     * @param SublimeArts\Dealers\Models\Dealer $dealer
     * @return bool
     */
    public static function removeBlock($template, $dealer)
    {
        $blocker = static::where([
            'template' => $template,
            'dealer_id' => $dealer->id
        ])->first();

        if (!$blocker) {
            return false;
        }

        $blocker->delete();
        return true;
    }

    /**
     * Blocks all mail messages for a dealer.
     * @param SublimeArts\Dealers\Models\Dealer $dealer
     * @return bool
     */
    public static function blockAll($dealer)
    {
        return static::addBlock('*', $dealer);
    }

    /**
     * Removes block on all mail messages for a dealer.
     * @param SublimeArts\Dealers\Models\Dealer $dealer
     * @return bool
     */
    public static function unblockAll($dealer)
    {
        return static::removeBlock('*', $dealer);
    }

    /**
     * Checks if a dealer is blocking all templates.
     * @param SublimeArts\Dealers\Models\Dealer $dealer
     * @return bool
     */
    public static function isBlockAll($dealer)
    {
        return static::checkForEmail('*', $dealer->email);
    }

    /**
     * Updates mail blockers for a dealer if they change their email address
     * @param  Model $dealer
     * @return mixed
     */
    public static function syncUser($dealer)
    {
        return static::where('dealer_id', $dealer->id)->update(['email' => $dealer->email]);
    }

    /**
     * Returns a list of mail templates blocked by the dealer.
     * @param  Model $dealer
     * @return array
     */
    public static function checkAllForDealer($dealer)
    {
        return static::where('dealer_id', $dealer->id)->lists('template');
    }

    /**
     * Checks if an email address has blocked a given template,
     * returns an array of blocked emails.
     * @param  string $template
     * @param  string $email
     * @return array
     */
    public static function checkForEmail($template, $email)
    {
        if (empty($email)) {
            return [];
        }

        if (!is_array($email)) {
            $email = [$email => null];
        }

        $emails = array_keys($email);

        return static::where(function($q) use ($template) {
            $q->where('template', $template)->orWhere('template', '*');
        })
            ->whereIn('email', $emails)
            ->lists('email');
    }

    /**
     * Filters a Illuminate\Mail\Message and removes blocked recipients.
     * If no recipients remain, false is returned. Returns true if mailing
     * should proceed.
     * @param  string $template
     * @param  Illuminate\Mail\Message $message
     * @return bool
     */
    public static function filterMessage($template, $message)
    {
        $recipients = $message->getTo();
        $blockedAddresses = static::checkForEmail($template, $recipients);
        if (!count($blockedAddresses)) {
            return true;
        }

        foreach ($recipients as $address => $name) {
            if (in_array($address, $blockedAddresses)) {
                unset($recipients[$address]);
            }
        }

        $message->setTo($recipients);
        return count($recipients) ? true : false;
    }

    /**
     * @deprecated Use MailBlocker::setPreferences instead
     * @TODO Remove this function in the next major version or if year >= 2017
     */
    public static function toggleBlocks($templates, $dealer, array $inTemplates = null)
    {
        traceLog('MailBlocker::toggleBlocks is deprecated, please use MailBlocker::setPreferences instead');

        foreach ((array) $templates as $template => $value) {

            if (
                $inTemplates &&
                !array_key_exists($template, $inTemplates) &&
                !in_array($template, $inTemplates)
            ) {
                continue;
            }

            // Template uses an alias
            if (isset($inTemplates[$template])) {
                $template = $inTemplates[$template];
            }

            if ($value) {
                static::removeBlock($template, $dealer);
            }
            else {
                static::addBlock($template, $dealer);
            }
        }
    }

}