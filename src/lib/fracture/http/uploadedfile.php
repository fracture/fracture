<?php
    
    namespace Fracture\Http;

    class UploadedFile
    {

        private $rawParams = [];

        private $type = null;


        public function __construct( $params )
        {
            $this->rawParams = $params;
        }


        public function prepare()
        {
            if ( class_exists('\FInfo') ) 
            {
                $info = new \FInfo( FILEINFO_MIME_TYPE );
                $this->type = $info->file( $this->getPath() );
            }
        }
        

        public function isValid()
        {
            return  $this->rawParams['error'] === 0;
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