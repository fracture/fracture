<?php


    return 
    [ [ 'expression' => '#^/test$#',
        'url'        => '/test',
        'expected'   => [] ],

      [ 'expression' => '#^/foo/bar$#',
        'url'        => '/foo/bar',
        'expected'   => [] ],

      [ 'expression' => '#^/(?P<item>[^/\.,;?\n]+)$#',
        'url'        => '/some-value',
        'expected'   => [ 'item' => 'some-value'] ],

      [ 'expression' => '#^/(?P<parameter>[^/\.,;?\n]+)/fixed$#',
        'url'        => '/value/fixed',
        'expected'   => [ 'parameter' => 'value' ] ],

      [ 'expression' => '#^/admin/(?P<section>[^/\.,;?\n]+)$#',
        'url'        => '/admin/login',
        'expected'   => [ 'section' => 'login' ] ],

      [ 'expression' => '#^/(?P<one>[^/\.,;?\n]+)/(?P<two>[^/\.,;?\n]+)$#',
        'url'        => '/alpha/beta',
        'expected'   => [ 'one' => 'alpha',
                          'two' => 'beta' ] ],

      [ 'expression' => '#^/(?P<main>[^/\.,;?\n]+)/category/(?P<sub>[^/\.,;?\n]+)$#',
        'url'        => '/document/category/overview',
        'expected'   => [ 'main' => 'document',
                          'sub'  => 'overview' ] ],

      [ 'expression' => '#^(:?/lorem/ipsum)?$#',
        'url'        => '/lorem/ipsum',
        'expected'   => [] ],

      [ 'expression' => '#^(:?/(?P<optional>[^/\.,;?\n]+))?$#',
        'url'        => '/value',
        'expected'   => [ 'optional' => 'value' ] ],

      [ 'expression' => '#^/test(:?/(?P<id>[^/\.,;?\n]+))?$#',
        'url'        => '/test',
        'expected'   => [] ],

      [ 'expression' => '#^/test(:?/(?P<id>[^/\.,;?\n]+))?$#',
        'url'        => '/test/1234',
        'expected'   => [ 'id' => '1234' ] ],

      [ 'expression' => '#^(:?/(?P<either>[^/\.,;?\n]+))?(:?/(?P<or>[^/\.,;?\n]+))?$#',
        'url'        => '',
        'expected'   => [] ],

      [ 'expression' => '#^(:?/(?P<either>[^/\.,;?\n]+))?(:?/(?P<or>[^/\.,;?\n]+))?$#',
        'url'        => '/first-one',
        'expected'   => [ 'either' => 'first-one' ] ],

      [ 'expression' => '#^(:?/(?P<either>[^/\.,;?\n]+))?(:?/(?P<or>[^/\.,;?\n]+))?$#',
        'url'        => '/first/second',
        'expected'   => [ 'either' => 'first',
                          'or'     => 'second' ] ],

      [ 'expression' => '#^(:?/test/(?P<parameter>[^/\.,;?\n]+))?/mandatory$#',
        'url'        => '/mandatory',
        'expected'   => [] ],

      [ 'expression' => '#^(:?/test/(?P<parameter>[^/\.,;?\n]+))?/mandatory$#',
        'url'        => '/test/value/mandatory',
        'expected'   => [ 'parameter' => 'value' ] ],

      [ 'expression' => '#^/$#',
        'url'        => '/',
        'expected'   => [] ] ];


/*
      [ 'expression' => '#^$#',
        'url'        => '',
        'expected'   => [] ],
*/


?>