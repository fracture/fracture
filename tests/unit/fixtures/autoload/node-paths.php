<?php

    return [
        [
            'list' => [
                '/foo/bar',
            ],
            'result' => [
                '/foo/bar',
            ],
        ],

        [
            'list' => [
                '/first',
                '/second',
            ],
            'result' => [
                '/first',
                '/second',
            ],
        ],

        [
            'list' => [
                '/duplicate',
                '/duplicate',
            ],
            'result' => [
                '/duplicate',
            ],
        ],

        [
            'list' => [
                '/duplicate/path',
                '/duplicate/path',
                '/unique',
            ],
            'result' => [
                '/duplicate/path',
                '/unique',
            ],
        ],
    ];