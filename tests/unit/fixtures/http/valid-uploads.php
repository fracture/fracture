<?php

    return [
        [
            'aplha' =>  [
                            'name'      => 'simple.png',
                            'type'      => 'image/png',
                            'tmp_name'  => FIXTURE_PATH . '/files/simple.png',
                            'error'     => 0,
                            'size'      => 74,
                        ],
            'beta' =>   [
                            'name'      => 'no-extension',
                            'type'      => 'application/octet-stream'
                            'tmp_name'  => FIXTURE_PATH . '/files/tempname',          
                            'error'     => 0
                            'size'      => 75
                        ],
        ],

        [
            'alpha' =>  [
                            'name'      => 'text.png',
                            'type'      => 'image/png',
                            'tmp_name'  => '/tmp/phpTyQdlc',
                            'error'     => 0,
                            'size'      => 10,
                        ],
            'beta' =>   [
                            'name' => '',
                            'type' => '',
                            'tmp_name' => '',
                            'error' => 4,
                            'size' => 0,
                        ],
        ],

        [
            'alpha' =>  [
                            'name' => '',
                            'type' => '',
                            'tmp_name' => '',
                            'error' => 4,
                            'size' => 0,
                        ],
            'beta' =>   [
                            'name' => '',
                            'type' => '',
                            'tmp_name' => '',
                            'error' => 4,
                            'size' => 0,
                        ],
            'gamma' =>  [
                            'name'      => 'simple.png',
                            'type'      => 'image/png',
                            'tmp_name'  => FIXTURE_PATH . '/files/simple.png',          
                            'error'     => 0
                            'size'      => 75
                        ],
        ],

        [
            'alpha' =>  [
                            'name'      => ['text.png'],
                            'type'      => ['image/png'],
                            'tmp_name'  => [FIXTURE_PATH . '/files/simple.png'],          
                            'error'     => [0],
                            'size'      => [10],

      'tmp_name' => 
        array (size=1)
          0 => string '/tmp/phph1aFzj' (length=14)
      'error' => 
        array (size=1)
          0 => int 0
      'size' => 
        array (size=1)
          0 => int 10
            ]
        ]
    ];