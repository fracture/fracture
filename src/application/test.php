<?php

    use Fracture\Transcription\JsonReader;

    use Fracture\Autoload\NodeMap;
    use Fracture\Autoload\ClassLoader;

    use Fracture\Routing\RouteBuilder;
    use Fracture\Routing\RequestBuilder;
    use Fracture\Routing\Router;



    require '../lib/fracture/transcription/jsonreader.php';
    require '../lib/fracture/autoload/searchable.php';
    require '../lib/fracture/autoload/node.php';
    require '../lib/fracture/autoload/nodemap.php';
    require '../lib/fracture/autoload/classloader.php';



    /*
     * Sets up initialized the development stage autoloader
     */

    $loader = new ClassLoader;
    $loader->register();

    $map = new NodeMap( __DIR__ );
    $reader = new JsonReader;
    $map->import(
        $reader->getAsArray( __DIR__ . '/test.json' ),
        __DIR__
    );

    $loader->addMap( $map,  dirname( __DIR__ ) );

    print_r( $map );

    var_dump( $map->getLocations('Test\\Lorem\\Ipsum\\Sit\\dolor') );
