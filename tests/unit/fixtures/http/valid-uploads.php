<?php

    return [
        [
            'alpha' => [
                'name'      => 'simple.png',
                'type'      => 'image/png',
                'tmp_name'  => FIXTURE_PATH . '/files/simple.png',
                'error'     => 0,
                'size'      => 74,
            ],
            'beta' => [
                'name'      => 'no-extension',
                'type'      => 'application/octet-stream'
                'tmp_name'  => FIXTURE_PATH . '/files/tempname',          
                'error'     => 0,
                'size'      => 75,
            ],
        ],

        [
            'alpha' => [
                'name'      => 'text.png',
                'type'      => 'image/png',
                'tmp_name'  => '/tmp/phpTyQdlc',
                'error'     => 0,
                'size'      => 10,
            ],
            'beta' => [
                'name'      => '',
                'type'      => '',
                'tmp_name'  => '',
                'error'     => 4,
                'size'      => 0,
            ],
        ],

        [
            'alpha' => [
                'name'      => '',
                'type'      => '',
                'tmp_name'  => '',
                'error'     => 4,
                'size'      => 0,
            ],
            'beta' => [
                'name'      => '',
                'type'      => '',
                'tmp_name'  => '',
                'error'     => 4,
                'size'      => 0,
            ],
            'gamma' => [
                'name'      => 'simple.png',
                'type'      => 'image/png',
                'tmp_name'  => FIXTURE_PATH . '/files/simple.png',          
                'error'     => 0,
                'size'      => 75,
            ],
        ],

        [
            'alpha' => [
                'name'      => ['text.png'],
                'type'      => ['image/png'],
                'tmp_name'  => [FIXTURE_PATH . '/files/text.png'],          
                'error'     => [0],
                'size'      => [10],
            ],
        ],

        [
            'alpha' => [
                'name'      => ['tempname', 'simple.png'],
                'type'      => ['application/octet-stream', 'image/png'],
                'tmp_name'  => [FIXTURE_PATH . '/files/tempname', FIXTURE_PATH . '/files/simple.png'],
                'error'     => [0, 0],
                'size'      => [75, 74],
            ],
        ],

        [
            'alpha' => [
                'name'      => [ 'simple.png', ''],
                'type'      => ['image/png', ''],
                'tmp_name'  => [FIXTURE_PATH . '/files/simple.png', ''],
                'error'     => [0, 4],
                'size'      => [74, 0],
            ],
            'beta' => [
                'name'      => ['simple.png'],
                'type'      => ['image/png'],
                'tmp_name'  => [FIXTURE_PATH . '/files/simple.png'],
                'error'     => [0],
                'size'      => [74],
            ],
            'gamma' => [
                'name'      => 'no-extension',
                'type'      => 'application/octet-stream'
                'tmp_name'  => FIXTURE_PATH . '/files/tempname',          
                'error'     => 0,
                'size'      => 75,
            ],            
        ],
    ];