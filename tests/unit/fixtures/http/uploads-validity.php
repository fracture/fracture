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
            true,
        ],
        [
            [
                'name'      => '',
                'type'      => '',
                'tmp_name'  => '',
                'error'     => UPLOAD_ERR_NO_FILE,
                'size'      => 0,
            ],
            false,
        ]



    ];