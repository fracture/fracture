<?php

    namespace Fracture\Routing;


    class Pattern
    {

        // default pattern fragment for matching URL query segment
        const STRVAL = '[^/\\\\.,;?\n]+';

        // pattern of the route notation element
        const REGKEY = '/(\:([a-zA-Z]+))/';

        // pattern fragment to match Pattern::STRVAL in a string
        const REGVAL = '[^/\\\\\\\\.,;?\n]+';


        protected $notation;

        protected $conditions;

        protected $expression;


        public function __construct( $notation, array $conditions = [] )
        {
            $this->notation = $notation;
            $this->conditions = $conditions;
        }


        public function prepare()
        {
            $notation = $this->cleanNotation( $this->notation );
            $expression = $this->parseNotation( $notation );

            if ( count( $this->conditions ) )
            {
                $expression = $this->applyConditions( $expression, $this->conditions );
            }

            $this->expression = "#^$expression$#";
        }


        protected function cleanNotation( $notation )
        {
            if ( strlen( $notation ) === 0 )
            {
                return $notation;
            }

            return $this->addSlash( $notation );
        }

        /**
         * Method ensures that all non-empty route notations expect '/' as first symbol
         */
        protected function addSlash( $notation )
        {
            $notation = trim( $notation, '/' );
            $offset = strspn( $notation, '[' );

            if ( $offset === 0 )
            {
                return '/' . $notation;
            }

            if ( substr( $notation, $offset, 1 ) !== '/' )
            {
                $notation = substr( $notation, 0, $offset) . '/' . substr( $notation, $offset );
            }

            return $notation;
        }

        /**
         * Turns route notation in a regular expression
         */
        protected function parseNotation( $notation )
        {
            $out = str_replace( [ '[', ']' ], [ '(?:', ')?' ], $notation );

            $enhancement = '(?P<\2>' . self::REGVAL . ')';
            $out = preg_replace( self::REGKEY ,$enhancement, $out );

            return $out;
        }


        /**
         * Inserts custom patterns in the existing regular expression
         */
        protected function applyConditions( $expression, $conditions )
        {
            $search = $replace = [];

            foreach ( $conditions as $key => $value)
            {
                $search[]  = "<$key>" . self::STRVAL;
                $replace[] = "<$key>$value";
            }

            return str_replace( $search, $replace, $expression );
        }


        public function getExpression()
        {
            return $this->expression;
        }


    }
