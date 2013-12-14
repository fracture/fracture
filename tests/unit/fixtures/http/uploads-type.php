<?php

    return [

        [
            [
                'name'      => 'simple.png',
                'type'      => 'image/png',
                'tmp_name'  => FIXTURE_PATH . '/files/simple.png',
                'error'     => UPLOAD_ERR_OK,
                'size'      => 74,
            ],
            'image/png',
            true, // does the extension match
        ],
        [
            [
                'name'      => 'text.png',
                'type'      => 'image/png',
                'tmp_name'  => FIXTURE_PATH .  '/files/text.png',
                'error'     => UPLOAD_ERR_OK,
                'size'      => 10,
            ],
            'text/plain',
            false,
        ],
        [
            [
                'name'      => 'no-extension',
                'type'      => 'application/octet-stream',
                'tmp_name'  => FIXTURE_PATH . '/files/tempname',          
                'error'     => UPLOAD_ERR_OK,
                'size'      => 75,
            ],
            'image/png',
            false,
        ],

    ];