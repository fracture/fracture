<?php

    namespace Mock;

    class Pattern
    {

        protected $expression;

        public function __construct( $expression )
        {
            $this->expression = $expression;
        }


        public function getExpression()
        {
            return $this->expression;
        }


    }

    