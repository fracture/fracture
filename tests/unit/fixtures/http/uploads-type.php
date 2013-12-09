<?php

    return [

        [
            [
                'name'      => 'simple.png',
                'type'      => 'image/png',
                'tmp_name'  => FIXTURE_PATH . '/files/simple.png',
                'error'     => 0,
                'size'      => 74,
            ],
            'image/png',
        ],
        [
            [
                'name'      => 'text.png',
                'type'      => 'image/png',
                'tmp_name'  => FIXTURE_PATH .  '/files/text.png',
                'error'     => 0,
                'size'      => 10,
            ],
            'text/plain',
        ],
        [
            [
                'name'      => 'no-extension',
                'type'      => 'application/octet-stream',
                'tmp_name'  => FIXTURE_PATH . '/files/tempname',          
                'error'     => 0,
                'size'      => 75,
            ],
            'image/png',
        ],

    ];