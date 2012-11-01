<?php

    use Fracture\Autoload\JsonNamespaceMap;
    use Fracture\Autoload\ClassLoader;


    require '../lib/fracture/autoload/classnotfoundexception.php';
    require '../lib/fracture/autoload/searchable.php';
    require '../lib/fracture/autoload/namespacemap.php';
    require '../lib/fracture/autoload/jsonnamespacemap.php';
    require '../lib/fracture/autoload/classloader.php';


    /*
     * Sets up initialized the development stage autoloader
     */
    $map = new JsonNamespaceMap( __DIR__ );
    $loader = new ClassLoader( $map );
    $loader->register();

    $map->setBasePath( dirname( __DIR__ ) );
    $map->import( __DIR__ . '/config/namespaces.json' );


?>