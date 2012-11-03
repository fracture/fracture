<?php

    namespace Fracture\Routing;


    class Pattern
    {

        const REGKEY = '/(\:([a-zA-Z]+))/';
        const REGVAL = '[^/\.,;?\n]+';


        protected $notation;
        protected $conditions;
        protected $expression;


        public function __construct( $notation , array $conditions = array() )
        {
            $this->notation = $notation;
            $this->conditions = $conditions;    
        }


        public function prepare()
        {
            $notation = $this->notation;
            $conditions = $this->conditions;

            $expression = $this->parseNotation( $notation );
            
            if ( count( $conditions ) )
            {
                $expression = $this->applyConditions( $expression , $conditions );
            }

            $this->expression = "#$expression#";
        }



        protected function parseNotation( $notation )
        {
            $out = trim( $notation , '/');

            $out = str_replace
            (
                array( '['   , ']' ),
                array( '(:?' , ')?' ),
                $out    
            );

            $out = preg_replace
            (
                Pattern::REGKEY ,
                '(?P<\2>' . Pattern::REGVAL . ')' ,
                $out
            );

            return $out;
        }



        protected function applyConditions( $expression , $conditions )
        {
            $search = $replace = array();

            foreach ( $conditions as $key => $value)
            {
                $key = substr( $key , 1);
                $search[]  = "<$key>".Pattern::REGVAL;
                $replace[] = "<$key>$value";
            }

            return str_replace($search, $replace, $expression );
        }


        public function getExpression()
        {
            return $this->expression;
        }
        

    }

?>