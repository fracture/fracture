<?php

    use Fracture\Transcription\JsonReader;

    use Fracture\Autoload\JsonNamespaceMap;
    use Fracture\Autoload\SimpleNamespaceMap;
    use Fracture\Autoload\ClassLoader;


    define('SOURCE_PATH', dirname( __DIR__ ) . '/src' );
    define('TEST_PATH', dirname( __DIR__ ) . '/tests' );


    require SOURCE_PATH . '/lib/fracture/transcription/jsonreader.php';
    require SOURCE_PATH . '/lib/fracture/autoload/searchable.php';
    require SOURCE_PATH . '/lib/fracture/autoload/namespacemap.php';
    require SOURCE_PATH . '/lib/fracture/autoload/jsonnamespacemap.php';
    require SOURCE_PATH . '/lib/fracture/autoload/simplenamespacemap.php';
    require SOURCE_PATH . '/lib/fracture/autoload/classloader.php';


    $loader = new ClassLoader( TRUE );
    $loader->register();

    $soureMap = new JsonNamespaceMap;
    $reader = new JsonReader;
    $soureMap->import(
        $reader->getAsArray( SOURCE_PATH . '/application/config/namespaces.json')
    );

    $loader->addMap( $soureMap, SOURCE_PATH );

    $mockMap = new SimpleNamespaceMap;
    $mockMap->addNamespacePath( 'Mock' , '/mocks' );

    $loader->addMap( $mockMap, TEST_PATH );
