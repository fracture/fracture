<?php


    return [ [ 'name'       => 'first',
               'parameters' => [ 'notation' => '' ],
               'urls'       => [ '' ],
               'expected'   => [ [] ] ],



             [ 'name'       => 'simple',
               'parameters' => [ 'notation' => 'nothing' ],
               'urls'       => [ '/nothing' ],
               'expected'   => [ [] ] ],



             [ 'name'       => '',
               'parameters' => [ 'notation' => '/:one' ],
               'urls'       => [ '/test', 
                                 '/data', 
                                 '/4:20' ],
               'expected'   => [ [ 'one' => 'test'],
                                 [ 'one' => 'data'],
                                 [ 'one' => '4:20' ] ] ],



             [ 'name'       => 'optional',
               'parameters' => [ 'notation' => '[/:foo]/set/:bar' ],
               'urls'       => [ '/param/set/20',
                                 '/filter/set/name',
                                 '/set/2',
                                 '/set/set/set',
                                 '/set/some_value' ],
               'expected'   => [ [ 'foo' => 'param', 'bar' => '20' ],
                                 [ 'foo' => 'filter', 'bar' => 'name' ] ,
                                 [ 'bar' => '2' ],
                                 [ 'foo' => 'set', 'bar' => 'set' ],
                                 [ 'bar' => 'some_value' ] ] ],



             [ 'name'       => '',
               'parameters' => [ 'notation' => '[/:controller[[/:id]/:action]]' ],
               'urls'       => [ '/users',
                                 '/archive/list',
                                 '/document/5/edit' ],
               'expected'   => [ [ 'controller' => 'users' ],
                                 [ 'controller' => 'archive', 'action' => 'list' ],
                                 [ 'controller' => 'document', 'action' => 'edit', 'id' => '5' ] ] ],



             [ 'name'       => 'not important',
               'parameters' => [ 'notation'   => '[:digits]',
                                 'conditions' =>  [ 'digits' => '[0-9]+' ] ],
               'urls'       => [ '/0',
                                 '/1234' ],
               'expected'   => [ [ 'digits' => '0' ],
                                 [ 'digits' => '1234' ] ] ],



             [ 'name'       => 'larger',
               'parameters' => [ 'notation'   => 'admin[/:resource[/:id/:key]]',
                                 'conditions' => [ 'id'  => '[0-9]+', 
                                                   'key' => '[ox]{6}' ] ],
               'urls'       => [ '/admin',
                                 '/admin/main/0/xooxxo',
                                 '/admin/pages' ],
               'expected'   => [ [],
                                 [ 'resource' => 'main', 'id' => '0', 'key' => 'xooxxo' ],
                                 [ 'resource' => 'pages' ] ] ],



             [ 'name'       => 'has defaults',
               'parameters' => [ 'notation' => '[:panel][/:segment]',
                                 'defaults' => [ 'segment' => 'overview' ] ],
               'urls'       => [ '/test', 
                                 '/is/expected',
                                 '/user-list' ],
               'expected'   => [ [ 'panel' => 'test', 'segment' => 'overview' ],
                                 [ 'panel' => 'is',  'segment' => 'expected' ],
                                 [ 'panel' => 'user-list', 'segment' => 'overview' ] ] ],



             [ 'name'       => 'big one',
               'parameters' => [ 'notation'  => 'i[[/:module]/:param][-:id]',
                                 'conditions' => [ 'param' => '[a-zA-Z]+',
                                                  'id'    => '[0-9]{1,2}' ],
                                 'defaults'  => [ 'module' => 'main',
                                                  'id'     => '0' ] ],
               'urls'       => [ '/i',
                                 '/i-19',
                                 '/i/test',
                                 '/i/different/test',
                                 '/i/simple-99',
                                 '/i/1/number-0',
                                 '/i/users/page-01' ], 
               'expected'   => [ [ 'module' => 'main', 'id' => '0' ],
                                 [ 'module' => 'main', 'id' => '19' ],
                                 [ 'module' => 'main', 'param' => 'test', 'id' => '0' ],
                                 [ 'module' => 'different', 'param' => 'test', 'id' => '0' ],
                                 [ 'module' => 'main', 'param' => 'simple', 'id' => '99' ],
                                 [ 'module' => '1', 'param' => 'number', 'id' => '0' ],
                                 [ 'module' => 'users', 'param' => 'page', 'id' => '01' ] ] ],


/*
             [ 'name'       => '',
               'parameters' => [ 'notation' => '' ],
               'urls'       => [],
               'expected'   => [ [] ] ],
*/
           ];


?>