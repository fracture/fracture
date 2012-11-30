<?php

    return
    [ [ 'expression' => '#^/foo$#',
        'url'        => '/foo',
        'defaults'   => [],
        'expected'   => [] ],

      [ 'expression' => '#^/$#',
        'url'        => '/',
        'defaults'   => [ 'test' => 'data' ],
        'expected'   => [ 'test' => 'data' ] ],

      [ 'expression' => '#^/(?P<param>[^/\.,;?\n]+)$#',
        'url'        => '/data',
        'defaults'   => [ 'lorem' => 'ipsum' ],
        'expected'   => [ 'param'  => 'data',
                          'lorem' => 'ipsum' ] ],

      [ 'expression' => '#^(:?/(?P<optional>[^/\.,;?\n]+))?$#',
        'url'        => '/foobar',
        'defaults'   => [ 'optional' => 'default' ],
        'expected'   => [ 'optional' => 'foobar' ] ],

      [ 'expression' => '#^(:?(:?/(?P<minor>[^/\.,;?\n]+))?/(?P<major>[^/\.,;?\n]+))?$#',
        'url'        => '/test',
        'defaults'   => [ 'minor' => 'list',
                          'major' => 'public' ],
        'expected'   => [ 'minor' => 'list',
                          'major' => 'test' ] ],

      [ 'expression' => '#^(:?(:?/(?P<minor>[^/\.,;?\n]+))?/(?P<major>[^/\.,;?\n]+))?$#',
        'url'        => '/another/test',
        'defaults'   => [ 'minor' => 'list',
                          'major' => 'public' ],
        'expected'   => [ 'minor' => 'another',
                          'major' => 'test' ] ],

      [ 'expression' => '#^/$#',
        'url'        => '/',
        'defaults'   => [],
        'expected'   => [] ] ];


/*
      [ 'expression' => '#^$#',
        'url'        => '',
        'defaults'   => [],
        'expected'   => [] ],
*/