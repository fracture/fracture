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
            $instance->setMethod( $params[ 'server' ][ 'REQUEST_METHOD' ] );
            $instance->setUploadedFiles( $params[ 'files' ] );
            $instance->setAddress( $params[ 'server' ][ 'REMOTE_ADDR' ] );
        }

    }


