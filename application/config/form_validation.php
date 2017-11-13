<?php
defined('BASEPATH') or exit('No direct script access allowed');

$config = [
    'admin/authentication' => [
        [
            'field' => 'user',
            'label' => 'User',
            'rules' => 'trim|required|max_length[50]'
        ],
        [
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|required|max_length[20]',
        ]
    ]
];
