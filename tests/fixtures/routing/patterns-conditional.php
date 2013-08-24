<?php

    return [
        [
            'notation'   => '',
            'conditions' => [],
            'pattern'    => '#^$#',
        ],

        [
            'notation'   => ':standard',
            'conditions' => [],
            'pattern'    => '#^/(?P<standard>[^/\\\\.,;?\n]+)$#',
        ],

        [
            'notation'   => ':simple',
            'conditions' => [
                                'simple'  => '[0-9]+',
                            ],
            'pattern'    => '#^/(?P<simple>[0-9]+)$#',
        ],

        [
            'notation'   => '/note/:note/:notepad/',
            'conditions' => [
                                'note'    => '00[a-z]{2,4}',
                                'notepad' => '[qwerty]?',
                            ],
            'pattern'    => '#^/note/(?P<note>00[a-z]{2,4})/(?P<notepad>[qwerty]?)$#',
        ],

        [
            'notation'   => '/i[[/:module]/:param][-:id]',
            'conditions' => [
                                'param' => '[a-z]+',
                                'id'    => '[\d]{1,2}',
                            ],
            'pattern'    => '#^/i(?:(?:/(?P<module>[^/\\\\.,;?\n]+))?/(?P<param>[a-z]+))?(?:-(?P<id>[\d]{1,2}))?$#',
        ],
    ];

/*
        [
            'notation'   => '',
            'conditions' => [],
            'pattern'    => '##',
        ],
//*/
