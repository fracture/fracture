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


        /**
         * @codeCoverageIgnore
         */
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


        /**
         * @codeCoverageIgnore
         */
        protected function gatherRouteValues( $uri )
        {
            foreach ( $this->pool as $name => $route )
            {
                $parameters = $route->getMatch( $uri );

                if ( empty($parameters) === false )
                {
                    $this->currentRoute = $name;
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


?>