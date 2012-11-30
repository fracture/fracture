<?php

    use Fracture\Autoload\JsonNamespaceMap;
    use Fracture\Autoload\SimpleNamespaceMap;
    use Fracture\Autoload\ClassLoader;


    define('SOURCE_PATH', dirname( __DIR__ ) . '/src' );
    define('TEST_PATH', dirname( __DIR__ ) . '/tests' );


    require SOURCE_PATH . '/lib/fracture/transcription/jsontoarray.php';
    require SOURCE_PATH . '/lib/fracture/autoload/classnotfoundexception.php';
    require SOURCE_PATH . '/lib/fracture/autoload/searchable.php';
    require SOURCE_PATH . '/lib/fracture/autoload/namespacemap.php';
    require SOURCE_PATH . '/lib/fracture/autoload/jsonnamespacemap.php';
    require SOURCE_PATH . '/lib/fracture/autoload/simplenamespacemap.php';
    require SOURCE_PATH . '/lib/fracture/autoload/classloader.php';


    $map1 = new JsonNamespaceMap;
    $src_loader = new ClassLoader( $map1, TRUE );

    $src_loader->setBasePath( SOURCE_PATH );
    $src_loader->register();

    $map1->import( SOURCE_PATH . '/application/config/namespaces.json' );


    $map2 = new SimpleNamespaceMap;
    $mock_loader = new ClassLoader( $map2, TRUE );
    $mock_loader->setBasePath( TEST_PATH );
    $mock_loader->register();
    
    $map2->addNamespacePath( 'Mock' , '/mocks' );
?>