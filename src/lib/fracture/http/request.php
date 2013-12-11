<?php

    namespace Http;

    class Request
    {

        private $method = '';

        private $parameters = [];

        private $files = [];



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

            $this->method = $method;
        }


        public function getMethod()
        {
            return $this->method;
        }



        public function setUploadedFiles( $list )
        {
            $files = new FileBag( $list );
            $files->prepare();
            $this->files[ $name ] = $files;
        }


        public function getUploadedFile( $name )
        {
            if ( $this->files->hasItem( $name ) )
            {
                return $this->files->fetchItem( $name );
            }

            return null;
        }


    }