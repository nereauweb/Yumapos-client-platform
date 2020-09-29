<?php

return [

    // Titles
    'showing-all-users'     => 'Lista utenti',
    'users-menu-alt'        => 'Mostra menu di gestione utenti',
    'create-new-user'       => 'Crea nuovo utente',
    'show-deleted-users'    => 'Mostra utente eliminato',
    'editing-user'          => 'Modifica utente :name',
    'showing-user'          => 'Visualzzazione utente :name',
    'showing-user-title'    => 'Informazioni :name',

    // Flash Messages
    'createSuccess'   => 'Utente creato con successo! ',
    'updateSuccess'   => 'Utente aggiornato con successo! ',
    'deleteSuccess'   => 'Utente eliminato con successo! ',
    'deleteSelfError' => 'Non puoi eliminare te stesso! ',

    // Show User Tab
    'viewProfile'            => 'Visualizza profilo',
    'editUser'               => 'Modifica utente',
    'deleteUser'             => 'Elimina utente',
    'usersBackBtn'           => 'Torna alla lista utenti',
    'usersPanelTitle'        => 'Informazioni utente',
    'labelUserName'          => 'Username:',
    'labelEmail'             => 'Email:',
    'labelParent'            => 'Referente:',
    'labelFirstName'         => 'Nome:',
    'labelLastName'          => 'Cognome:',
    'labelRole'              => 'Ruolo:',
    'labelStatus'            => 'Status:',
    'labelAccessLevel'       => 'Accesso',
    'labelPermissions'       => 'Permessi:',
    'labelCreatedAt'         => 'Creato il:',
    'labelUpdatedAt'         => 'Aggiornato il:',
    'labelIpEmail'           => 'Email Signup IP:',
    'labelIpEmail'           => 'Email Signup IP:',
    'labelIpConfirm'         => 'Confirmation IP:',
    'labelIpSocial'          => 'Socialite Signup IP:',
    'labelIpAdmin'           => 'Admin Signup IP:',
    'labelIpUpdate'          => 'Ultimo IP aggiornamento:',
    'labelDeletedAt'         => 'Eliminato il',
    'labelIpDeleted'         => 'Eliminazione IP:',
    'usersDeletedPanelTitle' => 'Informazioni utente eliminato',
    'usersBackDelBtn'        => 'Torna agli utenti eliminati',

    'successRestore'    => 'Utente ripristinato con successo.',
    'successDestroy'    => 'Record utente cancellato con successo.',
    'errorUserNotFound' => 'Utente non trovato.',

    'labelUserLevel'  => 'Livello',
    'labelUserLevels' => 'Livelli',

    'users-table' => [
        'caption'   => '{1} :userscount user total|[2,*] :userscount total users',
        'id'        => 'ID',
        'name'      => 'Username',
        'fname'     => 'Nome',
        'lname'     => 'Cognome',
        'email'     => 'Email',
        'role'      => 'Ruolo',
        'created'   => 'Creato',
        'updated'   => 'Aggiornato',
        'actions'   => 'Azioni',
        'updated'   => 'Aggiornato',
    ],

    'buttons' => [
        'create-new'    => 'New User',
        'delete'        => '<i class="fa fa-trash-o fa-fw" aria-hidden="true"></i>  <span class="hidden-xs hidden-sm">Elimina</span><span class="hidden-xs hidden-sm hidden-md"> utente</span>',
        'show'          => '<i class="fa fa-eye fa-fw" aria-hidden="true"></i> <span class="hidden-xs hidden-sm">Mostra</span><span class="hidden-xs hidden-sm hidden-md"> utente</span>',
        'edit'          => '<i class="fa fa-pencil fa-fw" aria-hidden="true"></i> <span class="hidden-xs hidden-sm">Modifica</span><span class="hidden-xs hidden-sm hidden-md"> utente</span>',
        'back-to-users' => '<span class="hidden-sm hidden-xs">Torna a </span><span class="hidden-xs">lista utenti</span>',
        'back-to-user'  => 'Torna  <span class="hidden-xs">a visualizzazione utente</span>',
        'delete-user'   => '<i class="fa fa-trash-o fa-fw" aria-hidden="true"></i>  <span class="hidden-xs">Elimina</span><span class="hidden-xs"> utente</span>',
        'edit-user'     => '<i class="fa fa-pencil fa-fw" aria-hidden="true"></i> <span class="hidden-xs">Modifica</span><span class="hidden-xs"> utente</span>',
    ],

    'tooltips' => [
        'delete'        => 'Elimina',
        'show'          => 'Mostra',
        'edit'          => 'Modifica',
        'create-new'    => 'Crea nuovo utente',
        'back-users'    => 'Torna alla lista utenti',
        'email-user'    => 'Email :user',
        'submit-search' => 'Ricerca utente',
        'clear-search'  => 'Reset ricerca',
    ],

    'messages' => [
        'userNameTaken'          => 'Username is taken',
        'userNameRequired'       => 'Username is required',
        'fNameRequired'          => 'First Name is required',
        'lNameRequired'          => 'Last Name is required',
        'emailRequired'          => 'Email is required',
        'emailInvalid'           => 'Email is invalid',
        'passwordRequired'       => 'Password is required',
        'PasswordMin'            => 'Password needs to have at least 6 characters',
        'PasswordMax'            => 'Password maximum length is 20 characters',
        'captchaRequire'         => 'Captcha is required',
        'CaptchaWrong'           => 'Wrong captcha, please try again.',
        'roleRequired'           => 'User role is required.',
        'user-creation-success'  => 'Successfully created user!',
        'update-user-success'    => 'Successfully updated user!',
        'delete-success'         => 'Successfully deleted the user!',
        'cannot-delete-yourself' => 'You cannot delete yourself!',
    ],

    'show-user' => [
        'id'                => 'User ID',
        'name'              => 'Username',
        'email'             => '<span class="hidden-xs">User </span>Email',
        'role'              => 'User Role',
        'created'           => 'Created <span class="hidden-xs">at</span>',
        'updated'           => 'Updated <span class="hidden-xs">at</span>',
        'labelRole'         => 'User Role',
        'labelAccessLevel'  => '<span class="hidden-xs">User</span> Access Level|<span class="hidden-xs">User</span> Access Levels',
    ],

    'search'  => [
        'title'             => 'Risultati ricerca',
        'found-footer'      => ' Risultati trovati',
        'no-results'        => 'Nessun risultato',
        'search-users-ph'   => 'Ricerca utenti',
    ],

    'modals' => [
        'delete_user_message' => 'Are you sure you want to delete :user?',
    ],
];
