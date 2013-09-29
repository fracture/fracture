<?php

    use Fracture\Transcription\JsonReader;
    use Fracture\Autoload\NodeMap;
    use Fracture\Autoload\ClassLoader;


    define('SOURCE_PATH', dirname( __DIR__ ) . '/src' );
    define('TEST_PATH', dirname( __DIR__ ) . '/tests' );
    define('FIXTURE_PATH', TEST_PATH . '/unit/fixtures' );


    require SOURCE_PATH . '/lib/fracture/transcription/jsonreader.php';
    require SOURCE_PATH . '/lib/fracture/autoload/searchable.php';
    require SOURCE_PATH . '/lib/fracture/autoload/node.php';
    require SOURCE_PATH . '/lib/fracture/autoload/nodemap.php';
    require SOURCE_PATH . '/lib/fracture/autoload/classloader.php';


    $loader = new ClassLoader( TRUE );
    $loader->register();

    $reader = new JsonReader;

    $map = new NodeMap;
    $map->import(
        $reader->getAsArray( SOURCE_PATH . '/application/config/namespaces.json'),
        SOURCE_PATH
    );
    $map->import(
        [ 'Mock' => ['unit/mocks'] ],
        TEST_PATH
    );

    $loader->addMap( $map );

