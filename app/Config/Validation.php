<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;

class Validation extends BaseConfig
{
    //--------------------------------------------------------------------
    // Setup
    //--------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    //--------------------------------------------------------------------
    // Rules
    //--------------------------------------------------------------------

    public $users_create = [
        'name' => 'required',
        'email' => 'required|valid_email',
        'status' => 'required',
        'password' => 'required',
        'confirm' => 'required|matches[password]',
    ];

    public $users_create_errors = [
        'name' => [
            'required' => 'You must insert name'
        ],
        'email' => [
            'required' => 'You must insert email',
            'valid_email' => 'You must insert correct email'
        ],
        'status' => [
            'required' => 'You must insert status'
        ],
        'password' => [
            'required' => 'You must insert password'
        ],
        'confirm' => [
            'required' => 'You must insert confirm password',
            'matches' => 'The password and confirm password not matches'
        ],
    ];

    public $users_update = [
        'name' => 'required',
        'email' => 'required|valid_email',
    ];

    public $users_update_errors = [
        'name' => [
            'required' => 'You must insert name'
        ],
        'email' => [
            'required' => 'You must insert email',
            'valid_email' => 'You must insert correct email'
        ],
    ];

    public $password = [
        'password' => 'required',
    ];

    public $password_errors = [
        'password' => [
            'required' => 'You must insert password'
        ],
    ];

    public $login = [
        'email' => 'required|valid_email',
        'password' => 'required',
    ];

    public $login_errors = [
        'email' => [
            'required' => 'You must insert email',
            'valid_email' => 'You must insert correct email'
        ],
        'password' => [
            'required' => 'You must insert password'
        ],
    ];

    public $status = [
        'status' => 'required',
    ];

    public $status_errors = [
        'status' => [
            'required' => 'You must insert status'
        ],
    ];
}
