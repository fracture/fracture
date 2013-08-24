<?php

    return [
        [
            'notation' => '/test',
            'pattern'  => '#^/test$#',
        ],

        [
            'notation' => 'foo/bar',
            'pattern'  => '#^/foo/bar$#',
        ],

        [
            'notation' => '/:page',
            'pattern'  => '#^/(?P<page>[^/\\\\.,;?\n]+)$#',
        ],

        [
            'notation' => '/:resource/view',
            'pattern'  => '#^/(?P<resource>[^/\\\\.,;?\n]+)/view$#',
        ],

        [
            'notation' => 'user/:id/:nickname',
            'pattern'  => '#^/user/(?P<id>[^/\\\\.,;?\n]+)/(?P<nickname>[^/\\\\.,;?\n]+)$#',
        ],

        [
            'notation' => '',
            'pattern'  => '#^$#',
        ],

        [
            'notation' => '[lorem/ipsum]',
            'pattern'  => '#^(?:/lorem/ipsum)?$#',
        ],

        [
            'notation' => '[/:optional]',
            'pattern'  => '#^(?:/(?P<optional>[^/\\\\.,;?\n]+))?$#',
        ],

        [
            'notation' => 'test[/:id]',
            'pattern'  => '#^/test(?:/(?P<id>[^/\\\\.,;?\n]+))?$#',
        ],

        [
            'notation' => '[/:one][/:two]',
            'pattern'  => '#^(?:/(?P<one>[^/\\\\.,;?\n]+))?(?:/(?P<two>[^/\\\\.,;?\n]+))?$#',
        ],

        [
            'notation' => '[/test/:parameter]/mandatory',
            'pattern'  => '#^(?:/test/(?P<parameter>[^/\\\\.,;?\n]+))?/mandatory$#',
        ],

        [
            'notation' => '[/:controller[/:action][/:key]]',
            'pattern'  => '#^(?:/(?P<controller>[^/\\\\.,;?\n]+)(?:/(?P<action>[^/\\\\.,;?\n]+))?(?:/(?P<key>[^/\\\\.,;?\n]+))?)?$#',
        ],

        [
            'notation' => '[[/:minor]/:major]',
            'pattern'  => '#^(?:(?:/(?P<minor>[^/\\\\.,;?\n]+))?/(?P<major>[^/\\\\.,;?\n]+))?$#',
        ],
    ];

/*
        [
            'notation' => '',
            'pattern'  => '##',
        ],
//*/
