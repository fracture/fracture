<?php


    return [ [ 'name'       => 'simple',
               'parameters' => [ 'notation' => 'nothing' ],
               'urls'       => [ 'everything',
                                 '/nothing/nothing',
                                 '' ] ],



             [ 'name'       => '',
               'parameters' => [ 'notation' => '/:one' ],
               'urls'       => [ '/foo/bar',
                                 '/',
                                 'noslash' ] ],



             [ 'name'       => 'optional',
               'parameters' => [ 'notation' => '[/:foo]/set/:bar' ],
               'urls'       => [ '/set',
                                 '/set/multiple/params',
                                 '/foo/0/bar',
                                 '/one/two/set/three' ] ],



             [ 'name'       => '',
               'parameters' => [ 'notation' => '[/:controller[[/:id]/:action]]' ],
               'urls'       => [ '/one/two/three/four',
                                 '/' ] ],



             [ 'name'       => 'not important',
               'parameters' => [ 'notation'   => '[:digits]',
                                 'conditions' =>  [ 'digits' => '[0-9]+' ] ],
               'urls'       => [ '/anytext',
                                 '/1_1',
                                 '/0/1' ] ],



             [ 'name'       => 'larger',
               'parameters' => [ 'notation'   => 'admin[/:resource[/:id/:key]]',
                                 'conditions' => [ 'id'  => '[0-9]+', 
                                                   'key' => '[ox]{6}' ] ],
               'urls'       => [ '/user',
                                 '/not/admin/',
                                 '/admin/test/1/ox',
                                 '/admin/test/abc/ooxxoo' ] ],



             [ 'name'       => 'big one',
               'parameters' => [ 'notation'  => '/i[[/:module]/:param][-:id]',
                                 'conditions' => [ 'param' => '[a-zA-Z]+',
                                                   'id'    => '[0-9]{1,2}' ] ],
               'urls'       => [ '/u',
                                 '/i-f',
                                 '/i/lookup-123',
                                 '/i/00000',
                                 '/i/3-3',
                                 '/i/1/text/1',
                                 '/i/i/1-1',
                                 '/i/valid/valid-invalid' ] ],


/*
             [ 'name'       => '',
               'parameters' => [ 'notation' => '' ],
               'urls'       => [],
               'expected'   => [ [] ] ],
*/
           ];

           

?>