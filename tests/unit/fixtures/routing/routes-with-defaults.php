<?php

    /*
     * :alpha - first named parameter in pattern
     * :beta  - second parameter
     * :gamma - third parameter
     *
     * static - specified part of the pattern
     *
     * foo    - first unspecified segment in URL
     * bar    - second segment
     * buz    - third segment
     *
     * qux    - default value
     */

    return [
        #notation:      '/static'
        [
            'expression' => '#^/static$#',
            'url'        => '/static',
            'defaults'   => [],
            'expected'   => [],
        ],

        #notation:      '/'
        [
            'expression' => '#^/$#',
            'url'        => '/',
            'defaults'   => [
                                'alpha' => 'qux',
                            ],
            'expected'   => [
                                'alpha' => 'qux',
                            ],
        ],

        #notation:      '/:alpha'
        [
            'expression' => '#^/(?P<alpha>[^/\\\\.,;?\n]+)$#',
            'url'        => '/foo',
            'defaults'   => [
                                'beta'  => 'qux',
                            ],
            'expected'   => [
                                'alpha' => 'foo',
                                'beta'  => 'qux',
                            ],
        ],

        #notation:      '[/:alpha]''
        [
            'expression' => '#^(?:/(?P<alpha>[^/\\\\.,;?\n]+))?$#',
            'url'        => '/foo',
            'defaults'   => [
                                'alpha' => 'qux',
                            ],
            'expected'   => [
                                'alpha' => 'foo',
                            ],
        ],

        #notation:      '[[/:alpha]/:beta]'
        [
            'expression' => '#^(?:(?:/(?P<alpha>[^/\\\\.,;?\n]+))?/(?P<beta>[^/\\\\.,;?\n]+))?$#',
            'url'        => '/foo',
            'defaults'   => [
                                'alpha' => 'qux',
                                'beta'  => 'qux',
                            ],
            'expected'   => [
                                'alpha' => 'qux',
                                'beta'  => 'foo',
                            ],
        ],

        [
            'expression' => '#^(?:(?:/(?P<alpha>[^/\\\\.,;?\n]+))?/(?P<beta>[^/\\\\.,;?\n]+))?$#',
            'url'        => '/foo/bar',
            'defaults'   => [
                                'alpha' => 'qux',
                                'beta'  => 'qux',
                            ],
            'expected'   => [
                                'alpha' => 'foo',
                                'beta'  => 'bar',
                            ],
        ],

        #notation:      '/'
        [
            'expression' => '#^/$#',
            'url'        => '/',
            'defaults'   => [],
            'expected'   => [],
        ],
    ];

/*
        #notation:      ''
        [
            'expression' => '#^$#',
            'url'        => '',
            'defaults'   => [],
            'expected'   => [],
        ],
//*/
