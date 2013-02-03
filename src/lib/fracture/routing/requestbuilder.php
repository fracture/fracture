<?php


    namespace Fracture\Routing;

    class RequestBuilder
    {


        public function create()
        {
            $instance = new UserRequest;
            $instance->setParameters( $this->getPostValues() )
                     ->setIP( $this->getServerValue( 'REMOTE_ADDR' ) )
                     ->setMethod( $this->getServerValue( 'REQUEST_METHOD' ) );

            $instance->prepare();

            return $instance;
        }


        protected function getServerValue( $key )
        {
            if ( array_key_exists( $key, $_SERVER ) )
            {
                return $_SERVER[ $key ];
            }

            return null;
        }


        protected function getPostValues()
        {
            if ( empty( $_POST ) === false )
            {
                return $_POST;
            }

            return [];
        }

    }
