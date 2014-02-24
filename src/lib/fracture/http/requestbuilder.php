<?php

    namespace Fracture\Http;

    class RequestBuilder
    {

        private $defaults = [
            'get'    => [],
            'post'   => [],
            'server' => [],
            'files'  => [],
        ];

        public function create( $params )
        {
            $params += $this->defaults;

            $instance = $this->buildInstance();
            $this->applyParams( $instance, $params );
            $instance->prepare();

            return $instance;
        }



        protected function buildInstance()
        {
            $fileBuilder = new UploadedFileBuilder;
            $fileBagBuilder = new fileBagBuilder( $fileBuilder );

            return new Request( $fileBagBuilder );
        }


        protected function applyParams( $instance, $params )
        {
            $instance->setParameters( $params[ 'get' ] );
            $instance->setParameters( $params[ 'post' ] );
            $instance->setUploadedFiles( $params[ 'files' ] );
            if ( !$this->isCLI() )
            {
                $instance->setMethod( $params[ 'server' ][ 'REQUEST_METHOD' ] );
                $instance->setAddress( $params[ 'server' ][ 'REMOTE_ADDR' ] );
            }
        }


        /*
         * @codeCoverageIgnore
         */
        protected function isCLI()
        {
            return php_sapi_name() === 'cli';
        }

    }


