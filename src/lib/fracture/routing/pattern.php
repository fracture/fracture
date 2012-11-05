<?php

    namespace Fracture\Routing;


    class Pattern
    {

        const REGKEY = '/(\:([a-zA-Z]+))/';

        const REGVAL = '[^/\.,;?\n]+';


        protected $notation;

        protected $conditions;
        
        protected $expression;


        public function __construct( $notation , array $conditions = [] )
        {
            $this->notation = $notation;
            $this->conditions = $conditions;    
        }


        public function prepare()
        {
            $expression = $this->parseNotation( $this->notation );
            
            if ( count( $this->conditions ) )
            {
                $expression = $this->applyConditions( $expression , $this->conditions );
            }

            $this->expression = "#$expression#";
        }



        protected function parseNotation( $notation )
        {
            $out = trim( $notation , '/');

            $out = str_replace
            (
                [ '['   , ']'  ],
                [ '(:?' , ')?' ],
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
            $search = $replace = [];

            foreach ( $conditions as $key => $value)
            {
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