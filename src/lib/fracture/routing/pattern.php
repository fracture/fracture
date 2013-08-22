<?php

    namespace Fracture\Routing;


    class Pattern
    {

        const REGKEY = '/(\:([a-zA-Z]+))/';

        const REGVAL = '[^/\.,;?\n]+';


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


        protected function parseNotation( $notation )
        {
            $out = str_replace( [ '[', ']' ], [ '(?:', ')?' ], $notation );

            $enhancement = '(?P<\2>' . Pattern::REGVAL . ')';
            $out = preg_replace( Pattern::REGKEY ,$enhancement, $out );

            return $out;
        }



        protected function applyConditions( $expression, $conditions )
        {
            $search = $replace = [];

            foreach ( $conditions as $key => $value)
            {
                $search[]  = "<$key>" . Pattern::REGVAL;
                $replace[] = "<$key>$value";
            }

            return str_replace( $search, $replace, $expression );
        }


        public function getExpression()
        {
            return $this->expression;
        }


    }
