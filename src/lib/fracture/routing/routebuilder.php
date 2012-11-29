<?php

    namespace Fracture\Routing;

    class RouteBuilder
    {

        public function create( $name, $parameters )
        {
            $parameters += [ 'conditions' => [], 'defaults' => [], 'notation' => '' ];

            $pattern = new Pattern( $parameters['notation'], $parameters['conditions'] );
            $instance = new Route( $pattern, $name, $parameters['defaults'] );

            $pattern->prepare();

            return $instance;
        }


    }


?>