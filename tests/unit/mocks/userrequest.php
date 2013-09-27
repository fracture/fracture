<?php

    namespace Mock;

    class UserRequest
    {

        protected $uri;

        public function __construct( $uri )
        {
            $this->uri = $uri;
        }


        public function getUri()
        {
            return $this->uri;
        }


        public function setParameters( $parameters )
        {
            $this->parameters = $parameters;
        }


        public function getParameters()
        {
            return $this->parameters;
        }

    }

