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

        private $parsers = [];



        public function create( $params )
        {
            $params += $this->defaults;

            $instance = $this->buildInstance();
            $this->applyHeaders( $instance, $params['server'] );
            $this->applyParams( $instance, $params );
            if ( $instance->getMethod() !== 'get') {
                $this->applyContentParsers( $instance );
            }
            $instance->prepare();

            return $instance;
        }


        public function addContentParser( $type, $parser )
        {
            $this->parsers[ $type ] = $parser;
        }


        protected function buildInstance()
        {
            $fileBuilder = new UploadedFileBuilder;
            $fileBagBuilder = new fileBagBuilder( $fileBuilder );

            return new Request( $fileBagBuilder );
        }


        protected function applyContentParsers( $instance )
        {
            $data = [];

            $header = $instance->getContentTypeHeader();

            if ( $header === null )
            {
                return;
            }

            foreach ( $this->parsers as $value => $parser )
            {
                if ( $header->contains( $value ) )
                {
                    $data += call_user_func( $parser );
                }
            }

            $instance->setParameters( $data );
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


        protected function applyHeaders( $instance, $params )
        {
            if (array_key_exists('HTTP_ACCEPT', $params)) {
                $header = new AcceptHeader($params['HTTP_ACCEPT']);
                $header->prepare();
                $instance->setAcceptHeader($header);
            }

            if (array_key_exists('CONTENT_TYPE', $params)) {
                $header = new ContentTypeHeader($params['CONTENT_TYPE']);
                $header->prepare();
                $instance->setContentTypeHeader($header);
            }
        }


        /**
         * @codeCoverageIgnore
         */
        protected function isCLI()
        {
            return php_sapi_name() === 'cli';
        }

    }


