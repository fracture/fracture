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
        $reader->getAsArray( __DIR__ . '/config/namespaces.json' ),
        __DIR__
    );

    $loader->addMap( $map,  dirname( __DIR__ ) );


    /*
     * Routing mechanism
     */

    $uri = isset( $_SERVER[ 'PATH_INFO' ] )
                ? $_SERVER[ 'PATH_INFO' ]
                : '/';

    $builder = new RequestBuilder;
    $request = $builder->create();
    $request->setUri( $uri );

    $router = new Router( new RouteBuilder );
    $router->import(
        $reader->getAsArray( __DIR__ . '/config/routes.json' )
    );

    $router->route( $request );


    // $request ready to be used
