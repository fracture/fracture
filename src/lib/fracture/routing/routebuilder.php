<?php

    namespace Fracture\Routing;

    class RouteBuilder
    {

        public function create( $name, $parameters )
        {
            $parameters += [ 'conditions' => [], 'defaults' => [] ];
            extract( $parameters );

            $pattern = new Pattern( $notation, $conditions );
            $instance = new Route( $pattern, $name, $defaults );

            $pattern->prepare();

            return $instance;
        }

    }


?>