<?php

    namespace Fracture\Routing;

    class UserRequest
    {
        

        protected $uri;

        protected $resource;

        protected $action;

        protected $parameters = [];



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
            $this->resource = $parameters['resource'];
            $this->action = $parameters['action'];

            unset( $parameters['action'], $parameters['resource'] );
            $this->parameters = $parameters;
        }




        public function getResourceName()
        {
            return $this->resource;
        }



        public function getCommand()
        {
            $method = $this->getMethod();
            return $method . $this->action;
        }


        public function getMethod()
        {
            $method = strtolower( $_SERVER['REQUEST_METHOD'] );

            if ( $method === 'post' && array_key_exists( '_method', $_POST ) )
            {
                $replacement = strtolower( $_POST['_method'] );
                if ( in_array( $replacement, ['put', 'delete'] ) )
                {
                    $method = $alternative;
                }
            }

            return $method;
        }


        public function getQuery( $key )
        {
            if ( array_key_exists( $key , $_GET ) )
            {
                return $_GET[ $key ];
            }

            return null;
        }


        public function getPost( $key )
        {
            if ( array_key_exists( $key , $_POST ) )
            {
                return $_POST[ $key ];
            }

            return null;
        }


    }


?>