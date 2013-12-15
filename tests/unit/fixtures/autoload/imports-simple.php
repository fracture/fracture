<?php

    namespace Mock\Autoload;


    return [
        [
            'config' => [
                'Foo' => [ 'foo/bar' ],
            ],
            'path' => '/path/to',
            'class' => 'Foo\\Class',
            'result' => [
                '/path/to/foo/bar/class.php',
            ],
        ],

        [
            'config' => [
                'Foo' => [ 'foo\\bar' ],
            ],
            'path' => 'D:\\path\\to',
            'class' => 'Foo\\Class',
            'result' => [
                'D:/path/to/foo/bar/class.php',
            ],
        ],
    ];