<?php
defined('BASEPATH') or exit('No direct script access allowed');

$config = [
    'error_prefix' => '<small class="form-text text-muted">',
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
    ]
];


