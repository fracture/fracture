<?php

    return [
        [
            'names' => [ 'foo' ],
            'key' => 'foo',
            'result' => true,
        ],

        [
            'names' => [ 'foo' ],
            'key' => 'bar',
            'result' => false,
        ],

        [
            'names' => [ 'foo', 'bar' ],
            'key' => 'bar',
            'result' => true,
        ],
    ];