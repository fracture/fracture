<?php

    use Fracture\Autoload\JsonNamespaceMap;
    use Fracture\Autoload\ClassLoader;


    define('SOURCE_PATH', dirname( __DIR__ ) . '/src' );


    require SOURCE_PATH . '/lib/fracture/transcription/jsontoarray.php';
    require SOURCE_PATH . '/lib/fracture/autoload/classnotfoundexception.php';
    require SOURCE_PATH . '/lib/fracture/autoload/searchable.php';
    require SOURCE_PATH . '/lib/fracture/autoload/namespacemap.php';
    require SOURCE_PATH . '/lib/fracture/autoload/jsonnamespacemap.php';
    require SOURCE_PATH . '/lib/fracture/autoload/classloader.php';


    $map = new JsonNamespaceMap;
    $loader = new ClassLoader( $map, TRUE );

    $loader->setBasePath( SOURCE_PATH );
    $loader->register();

    $map->import( SOURCE_PATH . '/application/config/namespaces.json' );

?>