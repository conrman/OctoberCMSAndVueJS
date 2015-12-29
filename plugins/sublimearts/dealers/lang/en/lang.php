<?php

return [
    'plugin' => [
        'name' => 'Dealer',
        'description' => 'Dealer management.',
        'tab' => 'Dealers',
        'access_dealers' => 'Manage Dealers',
        'access_groups' => 'Manage Dealer Groups',
        'access_settings' => 'Manage Dealer Settings'
    ],
    'dealers' => [
        'menu_label' => 'Dealers',
        'all_dealers' => 'All Dealers',
        'new_dealer' => 'New Dealer',
        'list_title' => 'Manage Dealers',
        'activating' => 'Activating...',
        'trashed_hint_title' => 'Dealer has deactivated their account',
        'trashed_hint_desc' => 'This dealer has deactivated their account and no longer wants to appear on the site. They can reactivate their account at any time by signing back in.',
        'activate_warning_title' => 'Dealer not activated!',
        'activate_warning_desc' => 'This dealer has not been activated and will be unable to sign in.',
        'activate_confirm' => 'Do you really want to activate this dealer?',
        'active_manually' => 'Activate this dealer manually',
        'delete_confirm' => 'Do you really want to delete this dealer?',
        'activated_success' => 'Dealer has been activated successfully!',
        'return_to_list' => 'Return to dealers list',
        'delete_selected_empty' => 'There are no selected dealers to delete.',
        'delete_selected_confirm' => 'Delete the selected dealers?',
        'delete_selected_success' => 'Successfully deleted the selected dealers.'
    ],
    'settings' => [
        'dealers' => 'Dealers',
        'menu_label' => 'Dealer settings',
        'menu_description' => 'Manage dealer based settings.',
        'activation_tab' => 'Activation',
        'signin_tab' => 'Sign in',
        'registration_tab' => 'Registration',
        'notifications_tab' => 'Notifications',
        'allow_registration' => 'Allow dealer registration',
        'allow_registration_comment' => 'If this is disabled dealers can only be created by administrators.',
        'activate_mode' => 'Activation mode',
        'activate_mode_comment' => 'Select how a dealer account should be activated.',
        'activate_mode_auto' => 'Automatic',
        'activate_mode_auto_comment' => 'Activated automatically upon registration.',
        'activate_mode_dealer' => 'Dealer',
        'activate_mode_dealer_comment' => 'The dealer activates their own account using mail.',
        'activate_mode_admin' => 'Administrator',
        'activate_mode_admin_comment' => 'Only an Administrator can activate a dealer.',
        'welcome_template' => 'Welcome mail template',
        'welcome_template_comment' => 'This mail template is sent to a dealer when they are first activated.',
        'require_activation' => 'Sign in requires activation',
        'require_activation_comment' => 'Dealers must have an activated account to sign in.',
        'use_throttle' => 'Throttle attempts',
        'use_throttle_comment' => 'Repeat failed sign in attempts will temporarily suspend the dealer.',
        'login_attribute' => 'Login attribute',
        'login_attribute_comment' => 'Select what primary dealer detail should be used for signing in.',
        'no_mail_template' => 'Do not send a notification',
        'hint_templates' => 'You can customize mail templates by selecting Mail > Mail Templates from the settings menu.'
    ],
    'dealer' => [
        'label' => 'Dealer',
        'id' => 'ID',
        'username' => 'username',
        'company_name' => 'Company Name',
        'surname' => 'Surname',
        'email' => 'Email',
        'created_at' => 'Registered',
        'reset_password' => 'Reset Password',
        'reset_password_comment' => 'To reset this dealers password, enter a new password here.',
        'confirm_password' => 'Password Confirmation',
        'confirm_password_comment' => 'Enter the password again to confirm it.',
        'groups' => 'Groups',
        'empty_groups' => 'There are no dealer groups available.',
        'avatar' => 'Avatar',
        'details' => 'Details',
        'account' => 'Account'
    ],
    'group' => [
        'label' => 'Group',
        'id' => 'ID',
        'name' => 'Name',
        'description_field' => 'Description',
        'code' => 'Code',
        'code_comment' => 'Enter a unique code used to identify this group.',
        'created_at' => 'Created',
        'dealers_count' => 'Dealers'
    ],
    'groups' => [
        'menu_label' => 'Groups',
        'all_groups' => 'Dealer Groups',
        'new_group' => 'New Group',
        'delete_selected_confirm' => 'Do you really want to delete selected groups?',
        'list_title' => 'Manage Groups',
        'delete_confirm' => 'Do you really want to delete this group?',
        'delete_selected_success' => 'Successfully deleted the selected groups.',
        'delete_selected_empty' => 'There are no selected groups to delete.',
        'return_to_list' => 'Back to groups list',
        'return_to_dealers' => 'Back to dealers list',
        'create_title' => 'Create Dealer Group',
        'update_title' => 'Edit Dealer Group',
        'preview_title' => 'Preview Dealer Group'
    ],
    'login' => [
        'attribute_email' => 'Email',
        'attribute_username' => 'Username'
    ],
    'account' => [
        'account' => 'Account',
        'account_desc' => 'Dealer management form.',
        'redirect_to' => 'Redirect to',
        'redirect_to_desc' => 'Page name to redirect to after update, sign in or registration.',
        'code_param' => 'Activation Code Param',
        'code_param_desc' => 'The page URL parameter used for the registration activation code',
        'invalid_dealer' => 'A dealer was not found with the given credentials.',
        'invalid_activation_code' => 'Invalid activation code supplied.',
        'invalid_deactivation_pass' => 'The password you entered was invalid.',
        'success_activation' => 'Successfully activated your account.',
        'success_deactivation' => 'Successfully deactivated your account. Sorry to see you go!',
        'success_saved' => 'Settings successfully saved!',
        'login_first' => 'You must be logged in first!',
        'already_active' => 'Your account is already activated!',
        'activation_email_sent' => 'An activation email has been sent to your nominated email address.',
        'registration_disabled' => 'Registrations are currently disabled.',
        'sign_in' => 'Sign in',
        'register' => 'Register',
        'full_name' => 'Full Name',
        'email' => 'Email',
        'password' => 'Password',
        'login' => 'Login',
        'new_password' => 'New Password',
        'new_password_confirm' => 'Confirm New Password'
    ],
    'reset_password' => [
        'reset_password' => 'Reset Password',
        'reset_password_desc' => 'Forgotten password form.',
        'code_param' => 'Reset Code Param',
        'code_param_desc' => 'The page URL parameter used for the reset code'
    ],
    'session' => [
        'session' => 'Session',
        'session_desc' => 'Adds the dealer session to a page and can restrict page access.',
        'security_title' => 'Allow only',
        'security_desc' => 'Who is allowed to access this page.',
        'all' => 'All',
        'dealers' => 'Dealers',
        'guests' => 'Guests',
        'redirect_title' => 'Redirect to',
        'redirect_desc' => 'Page name to redirect if access is denied.',
        'logout' => 'You have been successfully logged out!'
    ]
];
