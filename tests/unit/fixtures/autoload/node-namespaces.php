<?php

    return [
        [
            'namespace' => 'foo',
            'name' => 'bar',
            'result' => 'foo\\bar',
        ],

        [
            'namespace' => 'Foo',
            'name' => 'Bar',
            'result' => 'Foo\\Bar',
        ],

        [
            'namespace' => 'foo\\bar',
            'name' => 'buz',
            'result' => 'foo\\bar\\buz',
        ],
    ];