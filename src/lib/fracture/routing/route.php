<?php

    namespace Fracture\Routing;

    class Route implements Matchable
    {

        protected $name;

        protected $pattern;

        protected $defaults;


        public function __construct( $pattern, $name, $defaults = [] )
        {
            $this->name = $name;
            $this->pattern = $pattern;
            $this->defaults = $defaults;
        }


        public function getMatch( $uri )
        {
            $expression = $this->pattern->getExpression();
            $matches = [];

            if ( preg_match( $expression, $uri, $matches ) === 0 )
            {
                return false;
            }

            $matches = $this->cleanMatches( $matches );
            return $matches + $this->defaults;
        }


        protected function cleanMatches( $matches )
        {
            $list = [];

            foreach ( $matches as $key => $value )
            {
                if ( is_numeric( $key ) === false && $value !== '' )
                {
                    $list[ $key ] = $value;
                }
            }

            return $list;
        }

    }
