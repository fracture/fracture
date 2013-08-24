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
            'expected'   => [],
        ],

        #notation:      '/static/static'
        [
            'expression' => '#^/static/static$#',
            'url'        => '/static/static',
            'expected'   => [],
        ],

        #notation:      '/:alpha'
        [
            'expression' => '#^/(?P<alpha>[^/\\\\.,;?\n]+)$#',
            'url'        => '/foo',
            'expected'   => [
                                'alpha' => 'foo',
                            ],
        ],

        #notation:      '/:alpha/static'
        [
            'expression' => '#^/(?P<alpha>[^/\\\\.,;?\n]+)/static$#',
            'url'        => '/foo/static',
            'expected'   => [
                                'alpha' => 'foo'
                            ],
        ],

        #notation:      '/static/:alpha'
        [
            'expression' => '#^/static/(?P<alpha>[^/\\\\.,;?\n]+)$#',
            'url'        => '/static/foo',
            'expected'   => [
                                'alpha' => 'foo'
                            ],
        ],

        #notation:      '/:alpha/:beta'
        [
            'expression' => '#^/(?P<alpha>[^/\\\\.,;?\n]+)/(?P<beta>[^/\\\\.,;?\n]+)$#',
            'url'        => '/foo/bar',
            'expected'   => [
                                'alpha' => 'foo',
                                'beta'  => 'bar',
                            ],
        ],

        #notation:      '/:alpha/static/:beta'
        [
            'expression' => '#^/(?P<alpha>[^/\\\\.,;?\n]+)/static/(?P<beta>[^/\\\\.,;?\n]+)$#',
            'url'        => '/foo/static/bar',
            'expected'   => [
                                'alpha' => 'foo',
                                'beta'  => 'bar',
                            ],
        ],

        #notation:      '[/static/static]'
        [
            'expression' => '#^(?:/static/static)?$#',
            'url'        => '/static/static',
            'expected'   => [],
        ],

        #notation:      '[/:alpha]'
        [
            'expression' => '#^(?:/(?P<alpha>[^/\\\\.,;?\n]+))?$#',
            'url'        => '/foo',
            'expected'   => [
                                'alpha' => 'foo',
                            ],
        ],

        #notation:      '/static[/:alpha]'
        [
            'expression' => '#^/static(?:/(?P<alpha>[^/\\\\.,;?\n]+))?$#',
            'url'        => '/static',
            'expected'   => [],
        ],

        [
            'expression' => '#^/static(?:/(?P<alpha>[^/\\\\.,;?\n]+))?$#',
            'url'        => '/static/foo',
            'expected'   => [
                                'alpha' => 'foo',
                            ],
        ],

        #notation:      '[/:alpha][/:beta]'
        [
            'expression' => '#^(?:/(?P<alpha>[^/\\\\.,;?\n]+))?(?:/(?P<beta>[^/\\\\.,;?\n]+))?$#',
            'url'        => '',
            'expected'   => [],
        ],

        [
            'expression' => '#^(?:/(?P<alpha>[^/\\\\.,;?\n]+))?(?:/(?P<beta>[^/\\\\.,;?\n]+))?$#',
            'url'        => '/foo',
            'expected'   => [
                                'alpha' => 'foo',
                            ],
        ],

        [
            'expression' => '#^(?:/(?P<alpha>[^/\\\\.,;?\n]+))?(?:/(?P<beta>[^/\\\\.,;?\n]+))?$#',
            'url'        => '/foo/bar',
            'expected'   => [
                                'alpha' => 'foo',
                                'beta'  => 'bar',
                            ],
        ],

        #notation:      '[/static/:alpha]/static'
        [
            'expression' => '#^(?:/static/(?P<alpha>[^/\\\\.,;?\n]+))?/static$#',
            'url'        => '/static',
            'expected'   => [],
        ],

        [
            'expression' => '#^(?:/static/(?P<alpha>[^/\\\\.,;?\n]+))?/static$#',
            'url'        => '/static/value/static',
            'expected'   => [
                                'alpha' => 'value',
                            ],
        ],

        #notation:      '/'
        [
            'expression' => '#^/$#',
            'url'        => '/',
            'expected'   => [],
        ],
    ];

/*
        #notation:      ''
        [
            'expression' => '#^$#',
            'url'        => '',
            'expected'   => [],
        ],
//*/
