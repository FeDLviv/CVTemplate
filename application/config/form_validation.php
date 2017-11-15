<?php
defined('BASEPATH') or exit('No direct script access allowed');

$config = [
    'error_prefix' => '<small class="form-text text-muted text-danger">',
    'error_suffix' => '</small>',
    'admin/login' => [
        [
            'field' => 'user',
            'label' => 'Username',
            'rules' => 'trim|required|max_length[50]'
        ],
        [
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|required|max_length[20]',
        ]
    ],
    'admin/ajax_contact' => [
        [
            'field' => 'Location',
            'label' => 'Location',
            'rules' => 'trim|required|max_length[50]'
        ],
        [
            'field' => 'Email',
            'label' => 'Email',
            'rules' => 'trim|required|valid_email|max_length[100]',
        ],
        [
            'field' => 'Phone',
            'label' => 'Phone',
            'rules' => 'trim|required|regex_match[/^\+\d{2}\s\(\d{3}\)\s\d{3}\s\d{2}\s\d{2}$/]'
        ],
        [
            'field' => 'Skype',
            'label' => 'Skype',
            'rules' => 'trim|required|max_length[50]'
        ],
        [
            'field' => 'GitHub',
            'label' => 'GitHub',
            'rules' => 'trim|required|valid_url|max_length[100]'
        ]
    ]    
];


