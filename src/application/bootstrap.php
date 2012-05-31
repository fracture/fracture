<?php

    namespace Fracture;



    require '../lib/fracture/autoloading/namespacemap.php';
    require '../lib/fracture/autoloading/mappedclassloader.php';

    $map = new Autoload\NamespaceMap;
    $loader = new Autoload\ClassLoader( $map );
    $loader->register();

    $map->plot( 'Fracture', '../lib/fracture' );
    $map->plot( 'Blog', './' );



    $request = new Transfare\Request( $_SERVER['PATH_INFO'] );
    $response = new Transfare\Response;

    $router = new Transfare\Router;
    $router->import( './config/routes.json' );
    $router->route( $request );



    $dbhProvider = function()
    {
        return new \PDO( 'sqlite::memory:' );
    }

    $serviceFactory = new ServiceFactory(
        new DataMapperFactory( $dbhProvider ),
        new DomainObjectFactory
        );



    $factory = new ControllerFactory( $serviceFactory );
    $name = $request->getControllerName();
    $controler = $factory->create( $name );

    $command = $request->getCommand();
    $controller->{$command}( $request, $response );



    $factory = new Presentation\ViewFactory( $serviceFactory );
    $name = $response->getViewName();
    $view = $factory->create( $name );

    echo $view->render( $response );

?>