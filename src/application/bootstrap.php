<?php

    use Fracture\Autoload\SimpleNamespaceMap;
    use Fracture\Autoload\ClassLoader;


    require '../lib/fracture/src/autoload/classnotfoundexception.php';
    require '../lib/fracture/src/autoload/searchable.php';
    require '../lib/fracture/src/autoload/namespacemap.php';
    require '../lib/fracture/src/autoload/simplenamespacemap.php';
    require '../lib/fracture/src/autoload/classloader.php';


    /*
     * Sets up initialized the development stage autoloader
     */
    $map = new SimpleNamespaceMap( __DIR__ );
    $loader = new ClassLoader( $map );
    $loader->register();

    $map->addNamespacePath( 'Foo\\Bar' , '../foo/bar' );
    $map->addNamespacePath( 'Test' , '../lolz' );
    $map->addNamespacePath( 'Test' , '../xxxxxxx' );
    $map->addNamespacePath( 'Foo' , '../something' );


?>