<?php

    namespace Fracture\Routing;

    class Router
    {

        protected $builder;

        protected $uri;

        protected $pool = [];


        public function __construct( $builder )
        {
            $this->builder = $builder;
        }


        public function import( $config )
        {
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


        protected function gatherRouteValues( $uri )
        {
            foreach ( $this->pool as $name => $route )
            {
                $parameters = $route->getMatch( $uri );

                if ( empty( $parameters ) === false )
                {
                    return $parameters;
                }
            }

            return [];
        }


        public function route( $request )
        {
            $uri = $request->getUri();
            $parameters = $this->gatherRouteValues( $uri );
            $request->setParameters( $parameters );
        }

    }
