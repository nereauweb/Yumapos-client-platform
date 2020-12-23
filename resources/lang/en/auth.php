<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => 'These credentials do not match our records.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
    // Activation items
    'sentEmail'        => 'We sent an email to :email.',
    'clickInEmail'     => 'Follow the link sent to activate your account.',
    'anEmailWasSent'   => 'A mail been sent :email on :date.',
    'clickHereResend'  => 'Click here to re-send the email.',
    'successActivated' => 'Success, your account has been activated.',
    'unsuccessful'     => 'Your account could not be activated, please try again or contact the administrators.',
    'notCreated'       => 'Your account could not be registered, please try again or contact the administrators.',
    'tooManyEmails'    => 'Too many activation mail sent to :email. <br />Please try again in <span class="label label-danger">:hours hours</span>.',
    'regThanks'        => 'Thank you for registering, ',
    'invalidToken'     => 'Invalid activation token. ',
    'activationSent'   => 'Activation mail sent. ',
    'alreadyActivated' => 'User already active. ',

    // Labels
    'whoops'          => 'Attenction! ',
    'someProblems'    => 'There are problems with your input.',
    'email'           => 'E-Mail address',
    'password'        => 'Password',
    'rememberMe'      => ' Remember me',
    'login'           => 'Login',
    'forgot'          => 'Forgot password?',
    'forgot_message'  => 'Problems with your password?',
    'name'            => 'Username',
    'first_name'      => 'Name',
    'last_name'       => 'Surname',
    'confirmPassword' => 'Confirm password',
    'register'        => 'Register',

    // Placeholders
    'ph_name'          => 'Username',
    'ph_email'         => 'E-mail address',
    'ph_firstname'     => 'Name',
    'ph_lastname'      => 'Surname',
    'ph_password'      => 'Password',
    'ph_password_conf' => 'Confirm Password',

    // User flash messages
    'sendResetLink' => 'Send password reset link',
    'resetPassword' => 'Reset Password',
    'loggedIn'      => 'Signed in!',

    // email links
    'pleaseActivate'    => 'Please activate your account.',
    'clickHereReset'    => 'Click here to reset your password: ',
    'clickHereActivate' => 'Click here to activate your account: ',

    // Validators
    'userNameTaken'    => 'Username taken',
    'userNameRequired' => 'Username required',
    'fNameRequired'    => 'Nome required',
    'lNameRequired'    => 'Cognome required',
    'emailRequired'    => 'Email required',
    'emailInvalid'     => 'Invalid email',
    'passwordRequired' => 'Password required',
    'PasswordMin'      => 'The password must have at least 6 characters',
    'PasswordMax'      => 'The maximum password length is 20 characters',
    'captchaRequire'   => 'Captcha required',
    'CaptchaWrong'     => 'Wrong captcha, try again.',
    'roleRequired'     => 'User role required.',

    'login-title' => 'Login',
    'login-desc' => 'Sign In to your account',
    'login-error' => 'Please enter correct email and password to proceed.',

];