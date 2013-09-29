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



    $reader = new JsonReader;

    /*
     * Sets up initialized the development stage autoloader
     */

    $loader = new ClassLoader;
    $loader->register();

    $configuration = $reader->getAsArray( __DIR__ . '/config/namespaces.json' );

    $map = new NodeMap( __DIR__ );
    $map->import( $configuration, __DIR__ . '/..' );

    $loader->addMap( $map );


    /*
     * Routing mechanism
     */

    $uri = isset( $_SERVER[ 'PATH_INFO' ] )
                ? $_SERVER[ 'PATH_INFO' ]
                : '/';

    $builder = new RequestBuilder;
    $request = $builder->create();
    $request->setUri( $uri );

    $configuration = $reader->getAsArray( __DIR__ . '/config/routes.json' );

    $router = new Router( new RouteBuilder );
    $router->import( $configuration );

    $router->route( $request );


    // $request ready to be used
