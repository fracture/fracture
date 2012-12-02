<?php

    namespace Fracture\Routing;

    class UserRequest
    {
        

        protected $uri;

        protected $ip;

        protected $method = NULL;

        protected $parameters = [];



        public function setMethod( $method )
        {
            $this->method = strtolower( $method );
            return $this;
        }


        public function getMethod()
        {
            return $this->method;
        }


        public function setUri( $uri )
        {
            $this->uri = $uri;
            return $this;
        }


        public function getUri()
        {
            return $this->uri;
        }


        public function setIp( $ip )
        {
            $this->ip = $ip;
            return $this;
        }


        public function getIp()
        {
            return $this->ip;
        }


        public function prepare()
        {
            $this->method = $this->getResolvedMethod();
        }


        protected function getResolvedMethod()
        {
            $method = $this->method;

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
                $message = 'You are trying to override following parameter(s): "'.
                            implode( '", "', array_keys( $duplicates ) ) . '"';

                trigger_error( $message , \E_USER_WARNING );
            }

            $this->parameters += $parameters;

            return $this;
        }



        public function getParameter( $name )
        {
            if ( array_key_exists( $name, $this->parameters ) )
            {
                return $this->parameters[ $name ];
            }

            return NULL;
        }


    }
