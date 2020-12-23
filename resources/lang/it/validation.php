<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'        => ':attribute deve essere accettato.',
    'active_url'      => ':attribute non è un URL valido.',
    'after'           => ':attribute deve essere successivo al :date.',
    'after_or_equal'  => ':attribute deve essere successivo o equivalente al to :date.',
    'alpha'           => ':attribute può contenere solo lettere.',
    'alpha_dash'      => ':attribute può contenere solo lettere, numeri e spazi.',
    'alpha_num'       => ':attribute Può contenere solo lettere e numeri.',
    'array'           => ':attribute deve essere un array.',
    'before'          => ':attribute deve essere precedente al :date.',
    'before_or_equal' => ':attribute deve essere precedente o equivalente al :date.',
    'between'         => [
        'numeric' => ':attribute deve essere tra :min e :max.',
        'file'    => ':attribute deve essere tra :min e :max kilobyte.',
        'string'  => ':attribute deve essere tra :min e :max caratteri.',
        'array'   => ':attribute deve essere tra :min e :max oggetti.',
    ],
    'boolean'        => 'Il campo :attribute deve essere vero o falso.',
    'confirmed'      => 'La conferma di :attribute non corrisponde.',
    'date'           => 'Il :attribute non è una data valida.',
    'date_format'    => ':attribute non corrisponde al formato :format.',
    'different'      => ':attribute e :other devono essere diversi.',
    'digits'         => ':attribute deve essere :digits cifre.',
    'digits_between' => ':attribute deve essere tra :min e :max cifre.',
    'dimensions'     => ':attribute ha dimensioni immagine non valide.',
    'distinct'       => 'Il campo :attribute ha valori duplicati.',
    'email'          => ':attribute deve essere un indirizzo email valido.',
    'exists'         => ':attribute selezionato non è valido.',
    'file'           => ':attribute deve essere un file.',
    'filled'         => 'Il campo :attribute deve avere un valore.',
    'image'          => ':attribute deve avere un immagine.',
    'in'             => ':attribute selezionato non è valido.',
    'in_array'       => 'Il campo :attribute non esiste in :other.',
    'integer'        => ':attribute deve essere un intero.',
    'ip'             => ':attribute deve essere un indirizzo IP valido.',
    'json'           => ':attribute deve essere una stringa JSON valida.',
    'max'            => [
        'numeric' => ':attribute non può essere maggiore di :max.',
        'file'    => ':attribute non può essere maggiore di :max kilobyte.',
        'string'  => ':attribute non può avere piu di :max caratteri.',
        'array'   => ':attribute non può avere piu di :max oggetti.',
    ],
    'mimes'     => ':attribute deve essere un file del tipo: :values.',
    'mimetypes' => ':attribute deve essere un file del tipo: :values.',
    'min'       => [
        'numeric' => ':attribute deve essere almeno :min.',
        'file'    => ':attribute deve essere almeno :min kilobyte.',
        'string'  => ':attribute deve avere almeno :min caratteri.',
        'array'   => ':attribute deve avere almeno :min oggetti.',
    ],
    'not_in'               => ':attribute selezionato non è valido.',
    'numeric'              => ':attribute deve essere un numero.',
    'present'              => 'Il campo :attribute deve essere presente.',
    'regex'                => ':attribute formato non valido.',
    'required'             => 'Il campo :attribute è richiesto.',
    'required_if'          => 'Il campo :attribute è richiesto quando :other è :value.',
    'required_unless'      => 'Il campo :attribute è richiesto unless :other è in :values.',
    'required_with'        => 'Il campo :attribute è richiesto quando :values è presente.',
    'required_with_all'    => 'Il campo :attribute è richiesto quando :values è presente.',
    'required_without'     => 'Il campo :attribute è richiesto quando :values non è presente.',
    'required_without_all' => 'Il campo :attribute è richiesto quando nessuno di :values sono presenti.',
    'same'                 => ':attribute e :other devono combaciare.',
    'size'                 => [
        'numeric' => 'Il :attribute deve essere :size.',
        'file'    => 'Il :attribute deve essere :size kilobyte.',
        'string'  => 'Il :attribute deve essere :size caratteri.',
        'array'   => 'Il :attribute deve contenere :size oggetti.',
    ],
    'string'   => 'Il :attribute deve essere una stringa.',
    'timezone' => 'Il :attribute deve essere una zona valida.',
    'unique'   => 'Il :attribute è già stato usato.',
    'uploaded' => ':attribute non è riuscito a caricare.',
    'url'      => ':attribute formato invalido.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
