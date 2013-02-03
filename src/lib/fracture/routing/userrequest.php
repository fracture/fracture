<?php

    namespace Fracture\Routing;

    class UserRequest
    {


        protected $uri;

        protected $ip;

        protected $method = null;

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


        private function sanitizeUri( $uri )
        {
            $uri = '/' . $uri;
            $uri = preg_replace( ['#(/)+#' , '#/(\./)+#'] , '/', $uri);
            $uri = trim( $uri, '/');
            return $uri;
        }


        private function adjustUriSegments( $list, $item )
        {
            if ( $item === '..' )
            {
                array_pop( $list );
            }
            else
            {
                array_push( $list, $item );
            }

            return $list;
        }


        protected function resolveUri( $uri )
        {
            $parts = explode( '/', $uri );
            $segments = [];
            foreach ( $parts as $element )
            {
                $segments = $this->adjustUriSegments( $segments, $element );
            }
            return implode( '/', $segments );
        }


        public function setUri( $uri )
        {
            $uri = $this->sanitizeUri( $uri );
            $uri = $this->resolveUri( $uri );
            $this->uri = '/' . $uri;
            return $this;
        }


        public function getUri()
        {
            return $this->uri;
        }


        public function setIp( $ip )
        {
            if ( filter_var( $ip, FILTER_VALIDATE_IP ) === false )
            {
                $ip = null;
            }

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

            return null;
        }


    }
