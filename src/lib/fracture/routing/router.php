<?php

    namespace Fracture\Routing;

    class Router
    {

        use \Fracture\Transcription\JsonToArray;


        protected $builder;
        
        protected $uri;

        protected $pool = [];

        protected $currentRoute = null;


        public function __construct( $builder )
        {
            $this->builder = $builder;
        }


        public function import( $filepath )
        {
            $config = $this->fetchConfig( $filepath );
            $this->pool = $this->createRoutes( $config );
        }


        protected function createRoutes( $config )
        {
            $routes = [];

            foreach ( $config as $name => $params )
            {
                $route = $this->builder->create( $name, $params );
                $routes[ $name ] = $route;
            }

            return $routes;
        }



        public function route( $request )
        {
            $uri = $request->getUri();

            foreach ( $this->pool as $name => $route )
            {
                if ( $parameters = $route->getMatch( $uri ) )
                {
                    $this->currentRoute = $route;
                    $request->setParameters( $parameters );
                    return;
                }
            }
        }

    }


?>