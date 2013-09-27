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
            'url'        => '/',
        ],

        [
            'expression' => '#^/static$#',
            'url'        => '/foo',
        ],

        #notation:      '/:alpha'
        [
            'expression' => '#^/(?P<alpha>[^/\\\\.,;?\n]+)$#',
            'url'        => '/',
        ],

        [
            'expression' => '#^/(?P<alpha>[^/\\\\.,;?\n]+)$#',
            'url'        => '/foo/bar',
        ],


        [
            'expression' => '#^/(?P<alpha>[^/\\\\.,;?\n]+)$#',
            'url'        => '/namespace\\class',
        ],

        #notation:      '/static/:alpha'
        [
            'expression' => '#^/static/(?P<alpha>[^/\\\\.,;?\n]+)$#',
            'url'        => '/static/foo/bar',
        ],

        [
            'expression' => '#^/static/(?P<alpha>[^/\\\\.,;?\n]+)$#',
            'url'        => '/foo/static',
        ],

        #notation:      '/:alpha/static/:beta'
        [
            'expression' => '#^/(?P<alpha>[^/\\\\.,;?\n]+)/static/(?P<beta>[^/\\\\.,;?\n]+)$#',
            'url'        => '/',
        ],

        [
            'expression' => '#^/(?P<alpha>[^/\\\\.,;?\n]+)/static/(?P<beta>[^/\\\\.,;?\n]+)$#',
            'url'        => '/foo/bar/buz',
        ],

        [
            'expression' => '#^/(?P<alpha>[^/\\\\.,;?\n]+)/static/(?P<beta>[^/\\\\.,;?\n]+)$#',
            'url'        => '/foo/static',
        ],

        #notation:      '[/:alpha]'
        [
            'expression' => '#^(?:/(?P<alpha>[^/\\\\.,;?\n]+))?$#',
            'url'        => '/',
        ],

        [
            'expression' => '#^(?:/(?P<alpha>[^/\\\\.,;?\n]+))?$#',
            'url'        => '/foo/bar',
        ],

        #notation:      '/static[/:alpha]'
        [
            'expression' => '#^/static(?:/(?P<alpha>[^/\\\\.,;?\n]+))?$#',
            'url'        => '/',
        ],

        [
            'expression' => '#^/static(?:/(?P<alpha>[^/\\\\.,;?\n]+))?$#',
            'url'        => '/static/foo/bar',
        ],

        #notation:      '[/:alpha][/:beta]'
        [
            'expression' => '#^(?:/(?P<alpha>[^/\\\\.,;?\n]+))?(?:/(?P<beta>[^/\\\\.,;?\n]+))?$#',
            'url'        => '/',
        ],

        [
            'expression' => '#^(?:/(?P<alpha>[^/\\\\.,;?\n]+))?(?:/(?P<beta>[^/\\\\.,;?\n]+))?$#',
            'url'        => '/foo/bar/buz',
        ],

        #notation:      '[/static/:alpha]/static'
        [
            'expression' => '#^(?:/static/(?P<alpha>[^/\\\\.,;?\n]+))?/static$#',
            'url'        => '/foo',
        ],

        [
            'expression' => '#^(?:/static/(?P<alpha>[^/\\\\.,;?\n]+))?/static$#',
            'url'        => '/static/foo',
        ],

        [
            'expression' => '#^(?:/static/(?P<alpha>[^/\\\\.,;?\n]+))?/static$#',
            'url'        => '/foo/static',
        ],

        #notation:      '/:alpha'
        #conditions:    alpha => [0-9+]
        [
            'expression' => '#^/(?P<alpha>[0-9]+)$#',
            'url'        => '/foo',
        ],

        [
            'expression' => '#^/(?P<alpha>[0-9]+)$#',
            'url'        => '/123/foo',
        ],

        #notation:      '/static/:alpha/:beta'
        #conditions:    alpha => 00[a-z]{2,4} , beta => [abc]
        [
            'expression' => '#^/static/(?P<alpha>00[a-z]{2,4})/(?P<beta>[abc]?)$#',
            'url'        => '/',
        ],

        [
            'expression' => '#^/static/(?P<alpha>00[a-z]{2,4})/(?P<beta>[abc]?)$#',
            'url'        => '/static',
        ],

        [
            'expression' => '#^/static/(?P<alpha>00[a-z]{2,4})/(?P<beta>[abc]?)$#',
            'url'        => '/static/foo/bar',
        ],

        [
            'expression' => '#^/static/(?P<alpha>00[a-z]{2,4})/(?P<beta>[abc]?)$#',
            'url'        => '/static/00foo/d',
        ],

        #notation:      '/static[[/:alpha]/:beta][-:gamma]'
        #conditions     beta => [a-z]+ , gamma => [\d]{1,2}
        [
            'expression' => '#^/static(?:(?:/(?P<alpha>[^/\\\\.,;?\n]+))?/(?P<beta>[a-z]+))?(?:-(?P<gamma>[\d]{1,2}))?$#',
            'url'        => '/foo',
        ],

        [
            'expression' => '#^/static(?:(?:/(?P<alpha>[^/\\\\.,;?\n]+))?/(?P<beta>[a-z]+))?(?:-(?P<gamma>[\d]{1,2}))?$#',
            'url'        => '/static/00',
        ],

        [
            'expression' => '#^/static(?:(?:/(?P<alpha>[^/\\\\.,;?\n]+))?/(?P<beta>[a-z]+))?(?:-(?P<gamma>[\d]{1,2}))?$#',
            'url'        => '/static-foo',
        ],

        [
            'expression' => '#^/static(?:(?:/(?P<alpha>[^/\\\\.,;?\n]+))?/(?P<beta>[a-z]+))?(?:-(?P<gamma>[\d]{1,2}))?$#',
            'url'        => '/static/foo/bar-baz',
        ],

        #notation:      '/'
        [
            'expression' => '#^/$#',
            'url'        => '/x',
        ],
    ];

/*
        #notation:      ''
        #conditions     element => regexp
        [
            'expression' => '',
            'url'        => '',
        ],
//*/
