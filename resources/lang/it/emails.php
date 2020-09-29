<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Emails Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used for various emails that
    | we need to display to the user. You are free to modify these
    | language lines according to your application's requirements.
    |
    */

    /*
     * Activate new user account email.
     *
     */

    'activationSubject'  => 'Attivazione richiesta',
    'activationGreeting' => 'Benvenuto!',
    'activationMessage'  => 'Per accedere ai servizi, è richiesta l\'attivazione dell\'account.',
    'activationButton'   => 'Attiva',
    'activationThanks'   => 'Grazie per aver utilizzato la nostra applicazione!',

    /*
     * Goobye email.
     *
     */
    'goodbyeSubject'  => 'Ci dispiace vederti andar via...',
    'goodbyeGreeting' => 'Ciao :username,',
    'goodbyeMessage'  => 'Ci dispiace vederti andar via. Ti informiamo che il tuo account è stato eliminato. Grazie per il tempo condiviso. Hai '.config('settings.restoreUserCutoff').' giorni per ripristinare il tuo account.',
    'goodbyeButton'   => 'Ripristina Account',
    'goodbyeThanks'   => 'Speriamo di rivederti presto!',

];
