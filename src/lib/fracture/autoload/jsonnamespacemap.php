<?php

    namespace Fracture\Autoload;

    class JsonNamespaceMap extends NamespaceMap
    {

        protected $basePath = '/';


        public function setBasePath( $basePath )
        {
            $this->basePath = $basePath;
        }


        public function import( $filepath )
        {
            $config = $this->retrieveData( $filepath );
            $this->applyValues( $config );
        }


        protected function retrieveData( $filepath )
        {
            if ( !file_exists( $filepath ) )
            {
                throw new \Exception( "File '{$filepath}' was not found!" );
            }

            $json = file_get_contents( $filepath );
            return json_decode( $json, true );
        }


        protected function applyValues( $config, $id = 0 )
        {
            foreach ( $config as $name => $data )
            {
                $this->growBranch( $name, $data, $id );
            }
        }


        protected function growBranch( $name, $data, $id )
        {
            $current =  $this->growNode( $name, $id );

            foreach( $data as $parameter )
            {
                $this->handleParameter( $parameter, $current );
            }
        }


        protected function handleParameter( $parameter, $id )
        {
            if ( is_array( $parameter ) )
            {
                $this->applyValues( $parameter, $id );
            }

            if ( is_string( $parameter ) )
            {
                $this->tree[ $id ][ 'paths' ][] = $this->basePath . '/' . $parameter;
            }
        }


    }

?>