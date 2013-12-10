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
            true,
        ],
        [
            [
                'name'      => '',
                'type'      => '',
                'tmp_name'  => '',
                'error'     => 4,
                'size'      => 0,
            ],
            false,
        ]



    ];