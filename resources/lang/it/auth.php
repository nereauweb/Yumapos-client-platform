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

    'failed'   => 'Autenticazione fallita',
    'throttle' => 'Troppi tentativi consecutivi. Riprova tra :seconds secondi.',

    // Activation items
    'sentEmail'        => 'Abbiamo inviato una mail a :email.',
    'clickInEmail'     => 'Segui il link inviato per attivare il tuo account.',
    'anEmailWasSent'   => 'Una mail è stata inviata a :email in data :date.',
    'clickHereResend'  => 'Clicca qui per re-inviare la mail',
    'successActivated' => 'Successo, il tuo account è stato attivato.',
    'unsuccessful'     => 'Non è stato possibile attivare il tuo account, per cortesia riprova o contatta gli amministratori.',
    'notCreated'       => 'Non è stato possibile registrare il tuo account, per cortesia riprova o contatta gli amministratori.',
    'tooManyEmails'    => 'Troppe mail di attivazione inviate a :email. <br />Per cortesia ritenta tra <span class="label label-danger">:hours ore</span>.',
    'regThanks'        => 'Grazie per esserti registrato, ',
    'invalidToken'     => 'Token di attivazione non valido. ',
    'activationSent'   => 'Mail di attivazione inviato. ',
    'alreadyActivated' => 'Utente già attivato. ',

    // Labels
    'whoops'          => 'Attenzione! ',
    'someProblems'    => 'Ci sono dei problemi con il tuo input.',
    'email'           => 'Indirizzo E-Mail',
    'password'        => 'Password',
    'rememberMe'      => ' Ricordami',
    'login'           => 'Login',
    'forgot'          => 'Password dimenticata?',
    'forgot_message'  => 'Problemi con la password?',
    'name'            => 'Username',
    'first_name'      => 'Nome',
    'last_name'       => 'Cognome',
    'confirmPassword' => 'Conferma password',
    'register'        => 'Registrati',

    // Placeholders
    'ph_name'          => 'Username',
    'ph_email'         => 'Indirizzo E-mail',
    'ph_firstname'     => 'Nome',
    'ph_lastname'      => 'Cognome',
    'ph_password'      => 'Password',
    'ph_password_conf' => 'Conferma Password',

    // User flash messages
    'sendResetLink' => 'Invia link per il reset della password',
    'resetPassword' => 'Reset Password',
    'loggedIn'      => 'Accesso effettuato!',

    // email links
    'pleaseActivate'    => 'Ti chiediamo cortesemente di attivare il tuo account.',
    'clickHereReset'    => 'Clicca qui per resettare la tua password: ',
    'clickHereActivate' => 'Clicca qui per attivare il tuo account: ',

    // Validators
    'userNameTaken'    => 'Username in uso',
    'userNameRequired' => 'Username richiesto',
    'fNameRequired'    => 'Nome richiesto',
    'lNameRequired'    => 'Cognome richiesto',
    'emailRequired'    => 'Email richiesta',
    'emailInvalid'     => 'Email non valida',
    'passwordRequired' => 'Password richiesta',
    'PasswordMin'      => 'La password deve avere almeno 6 caratteri',
    'PasswordMax'      => 'La lunghezza massima della password è 20 caratteri',
    'captchaRequire'   => 'Captcha richiesto',
    'CaptchaWrong'     => 'Captcha errato, riprova.',
    'roleRequired'     => 'Ruolo utente richiesto.',

];
