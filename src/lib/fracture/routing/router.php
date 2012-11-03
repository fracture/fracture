<?php

    namespace Fracture\Routing;

    class Router
    {


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


        protected function fetchConfig( $filepath )
        {
            if ( !file_exists( $filepath ) )
            {
                throw new \Exception( "File '$filepath' not found!" );
            }
    
            $json = file_get_contents( $filepath );
            $data = json_decode( $json, TRUE );
    
            if ( ! is_array( $data ) )
            {
                throw new \Exception( "Not valid JSON from '$filepath' file!" );
            }
    
            return $data;
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