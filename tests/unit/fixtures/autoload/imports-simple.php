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
                'Foo' => 'foo/bar',
            ],
            'path' => '/path/to',
            'class' => 'Foo\\Class',
            'result' => [
                '/path/to/foo/bar/class.php',
            ],
        ],

        [
            'config' => [
                'Foo' => [ 'foo' ],
            ],
            'path' => '/path/to',
            'class' => 'Foo\\Bar\\Class',
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

        [
            'config' => [
                'Foo' => [
                    [
                        'Bar' => [
                            'test',
                        ],
                    ],
                ],
            ],
            'path' => 'D:\\path\\to',
            'class' => 'Foo\\Bar\\Class',
            'result' => [
                'D:/path/to/test/class.php',
            ],
        ],

        [
            'config' => [
                'Foo' => [
                    [
                        'Bar' => [
                            'first',
                            'second',
                        ],
                    ],
                ],
            ],
            'path' => 'D:\\path\\to',
            'class' => 'Foo\\Bar\\Class',
            'result' => [
                'D:/path/to/first/class.php',
                'D:/path/to/second/class.php',
            ],
        ],

        [
            'config' => [
                'Foo' => [
                    'foo/location',
                    [
                        'Bar' => [
                            'first',
                            'second',
                        ],
                    ],
                ],
            ],
            'path' => 'D:\\path\\to',
            'class' => 'Foo\\Bar',
            'result' => [
                'D:/path/to/foo/location/bar.php',
            ],
        ],

        [
            'config' => [
                'Foo' => [
                    'foo/location',
                    [
                        'Empty' => [
                            [
                                'Bar' => [
                                    'first',
                                    'second',
                                    'third/location',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'path' => '/path/to',
            'class' => 'Foo\\Unknown\\Bar',
            'result' => [
                '/path/to/foo/location/unknown/bar.php',
            ],
        ],

        [
            'config' => [
                'Foo' => [
                    'foo/location',
                    [
                        'Empty' => [
                            [
                                'Bar' => [
                                    'first',
                                    'second',
                                    'third/location',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'path' => '/path/to',
            'class' => 'Foo\\Empty\\Bar',
            'result' => [
                '/path/to/foo/location/empty/bar.php',
            ],
        ],

        [
            'config' => [
                'Foo' => [
                    'foo/location',
                    [
                        'Empty' => [
                            [
                                'Bar' => [
                                    'first',
                                    'second',
                                    'third/location',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'path' => '/path/to',
            'class' => 'Foo\\EMPTY\\Bar\\Class',
            'result' => [
                '/path/to/first/class.php',
                '/path/to/second/class.php',
                '/path/to/third/location/class.php',
            ],
        ],

    ];