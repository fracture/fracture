<?php


    return [

        [ 'uri'      => '',
          'expected' => '/' ],

        [ 'uri'      => 'foo/bar',
          'expected' => '/foo/bar' ],

        [ 'uri'      => 'foo/',
          'expected' => '/foo' ],

        [ 'uri'      => './',
          'expected' => '/' ],

        [ 'uri'      => './foo/',
          'expected' => '/foo' ],

        [ 'uri'      => 'foo/./bar/./',
          'expected' => '/foo/bar' ],

        [ 'uri'      => 'foo.bar',
          'expected' => '/foo.bar' ],

        [ 'uri'      => 'foo./bar',
          'expected' => '/foo./bar' ],

        [ 'uri'      => 'foo./bar./',
          'expected' => '/foo./bar.' ],

        [ 'uri'      => 'foo/////bar',
          'expected' => '/foo/bar' ],

        [ 'uri'      => '///foo/bar/',
          'expected' => '/foo/bar' ],

        [ 'uri'      => '///foo///bar//',
          'expected' => '/foo/bar' ],

        [ 'uri'      => '/././foo/././bar/./',
          'expected' => '/foo/bar' ],

        [ 'uri'      => '../../../',
          'expected' => '/' ],

        [ 'uri'      => '/foo/../bar/',
          'expected' => '/bar' ],

        [ 'uri'      => '/foo/../../bar/',
          'expected' => '/bar' ],

        [ 'uri'      => '/foo/bar/../../baz/',
          'expected' => '/baz' ],


    ];

/*
        [ 'uri' => '',
          'expected' => '/' ],
*/