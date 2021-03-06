<?php

    namespace Fracture\Http;

    class UploadedFile
    {

        private $rawParams = [];

        private $type = null;

        private $isValid = true;


        public function __construct( $params )
        {
            $this->rawParams = $params;
        }


        public function prepare()
        {
            $filename = $this->getPath();

            if ( $this->rawParams['error'] !== UPLOAD_ERR_OK ||
                $this->isDubious( $filename ) === true )
            {
                $this->isValid = false;
                return;
            }

            if ( class_exists('\FInfo') )
            {
                $info = new \FInfo( FILEINFO_MIME_TYPE );
                $this->type = $info->file( $filename );
            }
        }


        private function isDubious( $filename )
        {
            return
                file_exists( $filename ) === false ||
                is_readable( $filename ) === false ||
                filesize( $filename ) === 0 ||
                $this->seemsTampered( $filename );
        }


        /**
         * Verfification for whether file was actually uploaded
         * using native PHP function
         *
         * @codeCoverageIgnore
         * @return bool
         */
        protected function seemsTampered( $filename )
        {
            return is_uploaded_file( $filename ) === false;
        }


        public function isValid()
        {
            return  $this->isValid;
        }


        public function hasProperExtension()
        {
            return $this->rawParams['type'] === $this->type;
        }


        public function getName()
        {
            return $this->rawParams['name'];
        }


        public function getSize()
        {
            return $this->rawParams['size'];
        }


        public function getMimeType()
        {
            if ( $this->type !== null )
            {
                return $this->type;
            }

            return $this->rawParams['type'];
        }


        public function getPath()
        {
            return $this->rawParams['tmp_name'];
        }

    }