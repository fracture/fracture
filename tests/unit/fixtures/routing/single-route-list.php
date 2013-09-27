<?php

    return [
        [
            '/fixtures/configs/routes-single.json',
            '/foo',
            [ 
                'alpha' => 'foo',
                'beta'  => 'qux',
            ],
        ],

        [
            '/fixtures/configs/routes-single.json',
            '/foo/bar',
            [ 
                'alpha' => 'foo',
                'beta'  => 'bar',
            ],
        ],

        [
            '/fixtures/configs/routes-multiple.json',
            '/value',
            [
                'alpha' => 'value',
                'beta'  => 'bar',
                'gamma' => 'buz',
            ],
        ],

        [
            '/fixtures/configs/routes-multiple.json',
            '/user/1234',
            [
                'alpha' => '1234',
                'beta'  => 'fallback',
            ],
        ],

        [
            '/fixtures/configs/routes-multiple.json',
            '/user/0/value',
            [
                'alpha' => '0',
                'beta'  => 'value',
            ],
        ],

        [
            '/fixtures/configs/routes-multiple.json',
            '/static/123123',
            [
                'alpha' => 'foo',
                'beta'  => '123123',
                'omega' => 'unrouted',
            ],
        ],

        [
            '/fixtures/configs/routes-multiple.json',
            '/static/long-text',
            [
                'alpha' => 'foo',
                'beta'  => 'long-text',
                'omega' => 'unrouted',
            ],
        ],
            
        [
            '/fixtures/configs/routes-multiple.json',
            '/static/text/foo',
            [
                'alpha' => 'text',
                'beta'  => 'foo',
                'omega' => 'unrouted',
            ],
        ],

        [
            '/fixtures/configs/routes-multiple.json',
            '/lorem/ipsum',
            [
                'alpha' => 'lorem',
                'beta'  => 'bar',
                'gamma' => 'ipsum',
            ],
        ],

        [
            '/fixtures/configs/routes-multiple.json',
            '/lorem',
            [
                'alpha' => 'lorem',
                'beta'  => 'bar',
                'gamma' => 'buz',
            ],
        ],

        [
            '/fixtures/configs/routes-multiple.json',
            '/cogito/ergo/sum',
            [
                'alpha' => 'cogito',
                'beta'  => 'ergo',
                'gamma' => 'sum',
            ],
        ],

            
    ];