<?php
    
    namespace Mock\Autoload;

    function _( $string ){
        return str_replace( '/' , DIRECTORY_SEPARATOR , $string );
    }

    return [
        [
            'config' => [ 
                'Foo' => [ 'foo/bar' ],
            ],
            'path' => '/path/to',
            'class' => 'Foo\First',
            'result' => [
                _( '/path/to/foo/bar/first.php' ),
            ], 
        ],
    ];