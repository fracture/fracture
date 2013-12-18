<?php

    namespace Fracture\Http;

    class UploadedFileBuilder
    {

        public function create( $params )
        {
            $instance = $this->buildInstance( $params );
            $instance->prepare();

            return $instance;
        }


        protected function buildInstance( $params )
        {
            return new UploadedFile( $params );
        }

    }


