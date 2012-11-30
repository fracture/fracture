<?php

    use Fracture\Autoload\JsonNamespaceMap;
    use Fracture\Autoload\ClassLoader;

    use Fracture\Routing\RouteBuilder;
    use Fracture\Routing\Router;
    use Fracture\Routing\UserRequest;



    require '../lib/fracture/transcription/jsontoarray.php';
    require '../lib/fracture/autoload/classnotfoundexception.php';
    require '../lib/fracture/autoload/searchable.php';
    require '../lib/fracture/autoload/namespacemap.php';
    require '../lib/fracture/autoload/jsonnamespacemap.php';
    require '../lib/fracture/autoload/classloader.php';



    /*
     * Sets up initialized the development stage autoloader
     */

    $loader = new ClassLoader;
    $loader->register();

    $map = new JsonNamespaceMap( __DIR__ );
    $map->import( __DIR__ . '/config/namespaces.json' );

    $loader->addMap( $map,  dirname( __DIR__ ) );


    /*
     * Routing mechanism 
     */

    $uri =  isset( $_SERVER[ 'PATH_INFO' ] ) ? $_SERVER[ 'PATH_INFO' ] : '/';

    $request = new UserRequest( $uri );
    $request->collectData();

    $router = new Router( new RouteBuilder );
    $router->import( __DIR__ . '/config/routes.json' );

    $router->route( $request );


    // $request ready to be used

?>