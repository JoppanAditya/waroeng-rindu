<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var list<string>
     */
    public array $ruleSets = [
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
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------
    public $registration = [
        'fullname' => [
            'label' => 'Full Name',
            'rules' => [
                'required',
                'max_length[50]',
                'min_length[3]',
            ],
        ],
        'username' => [
            'label' => 'Auth.username',
            'rules' => [
                'required',
                'max_length[30]',
                'min_length[3]',
                'regex_match[/\A[a-zA-Z0-9\.]+\z/]',
                'is_unique[users.username]',
            ],
        ],
        'email' => [
            'label' => 'Auth.email',
            'rules' => [
                'required',
                'max_length[254]',
                'valid_email',
                'is_unique[auth_identities.secret]',
            ],
        ],
        'mobile_number' => [
            'label' => 'Mobile Number',
            'rules' => [
                'max_length[15]',
                'min_length[10]',
                'regex_match[/\A[0-9]+\z/]',
                'is_unique[users.mobile_number]',
            ],
        ],
        'mobile_number' => [
            'label' => 'Mobile Number',
            'rules' => [
                'required',
                'max_length[15]',
                'min_length[10]',
                'regex_match[/\A[0-9]+\z/]',
                'is_unique[users.mobile_number]',
            ],
        ],
        'gender' => [
            'label' => 'Gender',
            'rules' => [
                'required',
                'in_list[Male, Female]',
            ],
        ],
        'date_of_birth' => [
            'label' => 'Date of Birth',
            'rules' => [
                'permit_empty',
                'valid_date',
            ],
        ],
        'password' => [
            'label' => 'Auth.password',
            'rules' => [
                'required',
                'max_byte[72]',
                'strong_password[]',
            ],
            'errors' => [
                'max_byte' => 'Auth.errorPasswordTooLongBytes'
            ]
        ],
        'password_confirm' => [
            'label' => 'Auth.passwordConfirm',
            'rules' => 'required|matches[password]',
        ],
    ];
}
