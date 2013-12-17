<?php

    namespace Fracture\Routing;

    class RouteBuilder
    {

        private $defaults = [
            'conditions' => [],
            'defaults'   => [],
            'notation'   => '',
        ];

        public function create( $name, $parameters )
        {
            $parameters += $this->defaults;

            $pattern = new Pattern( $parameters[ 'notation' ], $parameters[ 'conditions' ] );
            $instance = new Route( $pattern, $name, $parameters[ 'defaults' ] );

            $pattern->prepare();

            return $instance;
        }


    }
