<?php

    namespace Fracture\Http;

    class Request
    {

        private $method = null;

        private $parameters = [];

        private $files = [];

        private $fileBagBuilder = null;

        private $address = null;

        private $uri = null;


        public function __construct( $fileBagBuilder = null )
        {
            $this->fileBagBuilder = $fileBagBuilder;
        }


        private function getResolvedMethod()
        {
            $method = $this->method;

            // to mimic RESTlike API this lets you define override
            // for request method in form element with name '_method'
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


        public function prepare()
        {
            $this->method = $this->getResolvedMethod();
        }




        public function setParameters( $list )
        {
            $duplicates = array_intersect_key( $list,
                                               $this->parameters );

            // checks of parameters with overlapping names
            if ( count( $duplicates ) > 0 )
            {
                $message = 'You are trying to override following parameter(s): "' .
                            implode( '", "', array_keys( $duplicates ) ) . '"';

                trigger_error( $message , \E_USER_WARNING );
            }

            $this->parameters += $list;
        }


        public function getParameter( $name )
        {
            if ( array_key_exists( $name, $this->parameters ) )
            {
                return $this->parameters[ $name ];
            }

            return null;
        }


        public function setMethod( $value )
        {
            $method = strtolower( $value );
            $this->method = $method;
        }


        public function getMethod()
        {
            return $this->method;
        }



        public function setUploadedFiles( $list )
        {
            if ( $this->fileBagBuilder !== null )
            {
                $list = $this->fileBagBuilder->create( $list );
            }

            $this->files = $list;
        }


        public function getUpload( $name )
        {
            if ( isset ( $this->files[ $name ] ) )
            {
                return $this->files[ $name ];
            }

            return null;
        }


        private function sanitizeUri( $uri )
        {
            $uri = explode('?', $uri)[0];
            // to remove './' at the start of $uri
            $uri = '/' . $uri;
            $uri = preg_replace( [ '#(/)+#', '#/(\./)+#' ], '/', $uri );
            $uri = trim( $uri, '/' );
            return $uri;
        }


        /**
         * Method for handling '../' in URL query
         */
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
        }


        public function getUri()
        {
            return $this->uri;
        }



        public function setAddress( $address )
        {
            if ( filter_var( $address, FILTER_VALIDATE_IP ) === false )
            {
                $address = null;
            }

            $this->address = $address;
        }


        public function getAddress()
        {
            return $this->address;
        }


    }