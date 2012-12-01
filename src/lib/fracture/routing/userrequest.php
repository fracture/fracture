<?php

    namespace Fracture\Routing;

    class UserRequest
    {
        

        protected $uri;

        protected $method;

        protected $parameters = [];



        public function __construct( $uri )
        {
            $this->uri = $uri;
        }


        public function collectData()
        {
            $this->parameters = $_POST;
            $this->method = $this->getResolvedMethod();
        }

        protected function getResolvedMethod()
        {
            $method = NULL;

            if ( isset( $_SERVER[ 'REQUEST_METHOD' ] ) ) 
            {
                $method = strtolower( $_SERVER[ 'REQUEST_METHOD' ] );
            }

            if ( $method === 'post' && array_key_exists( '_method', $this->parameters ) )
            {
                $replacement = strtolower( $this->parameters[ '_method' ] );

                if ( in_array( $replacement, [ 'put', 'delete' ] ) )
                {
                    $method = $replacement;
                }

                unset( $this->parameters[ '_method' ] );
            }

            return $method;
        }



        public function setParameters( $parameters )
        {
            $duplicates = array_intersect_key( $parameters,
                                               $this->parameters );

            if ( count( $duplicates ) > 0 )
            {
                $message = 'duplication between POST variable and routed parameters: "'.
                            implode( '", "', array_keys( $duplicates ) ) . '"';

                trigger_error( $message , \E_USER_WARNING );
            }

            $this->parameters += $parameters;
        }



        public function getParameter( $name )
        {
            if ( array_key_exists( $name, $this->parameters ) )
            {
                return $this->parameters[ $name ];
            }

            return NULL;
        }


        public function getUri()
        {
            return $this->uri;
        }


        public function getMethod()
        {
            return $this->method;
        }


    }


?>