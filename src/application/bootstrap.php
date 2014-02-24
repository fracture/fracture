<?php

    namespace Fracture;

    require '../lib/fracture/transcription/jsonreader.php';
    require '../lib/fracture/autoload/searchable.php';
    require '../lib/fracture/autoload/node.php';
    require '../lib/fracture/autoload/nodemap.php';
    require '../lib/fracture/autoload/classloader.php';


    $reader = new Transcription\JsonReader;

    /*
     * Sets up initialized the development stage autoloader
     */

    $loader = new Autoload\ClassLoader;
    $loader->register();

    $configuration = $reader->getAsArray( __DIR__ . '/config/namespaces.json' );

    $map = new Autoload\NodeMap( __DIR__ );
    $map->import( $configuration, __DIR__ . '/..' );

    $loader->addMap( $map );


    /*
     * Routing mechanism
     */

    $uri = isset( $_SERVER[ 'REQUEST_URI' ] )
                ? $_SERVER[ 'REQUEST_URI' ]
                : '/';

    $builder = new Http\RequestBuilder;
    $request = $builder->create( [
        'get'    => $_GET,
        'files'  => $_FILES,
        'server' => $_SERVER,
        'post'   => $_FILES,
    ] );
    $request->setUri( $uri );

    $configuration = $reader->getAsArray( __DIR__ . '/config/routes.json' );

    $router = new Routing\Router( new Routing\RouteBuilder );
    $router->import( $configuration );

    $router->route( $request );


    // $request initialization complete
    // IMPORTANT: execution continues in next file, that was included in index.php

