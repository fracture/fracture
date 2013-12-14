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
                '/duplicate',
                '/duplicate',
                '/unique',
            ],
            'result' => [
                '/duplicate',
                '/unique',
            ],
        ],
    ];