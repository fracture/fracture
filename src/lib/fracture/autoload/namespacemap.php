<?php

    namespace Fracture\Autoload;

    abstract class NamespaceMap implements Searchable
    {

        protected $tree = [[
            'nodes' => [],
            'paths' => [],
        ]];


        public function getLocations( $className )
        {
            $segments = explode( '\\', $className );
            $filename = array_pop( $segments );

            list( $segments, $directories ) = $this->yieldNode( $segments );

            $path =  implode( DIRECTORY_SEPARATOR, $segments );
            $filepath = strtolower( $path ) . DIRECTORY_SEPARATOR . strtolower( $filename ) . '.php';

            $locations = $this->combinePaths( $directories, $filepath );

            return $locations;
        }


        protected function yieldNode( array $segments )
        {
            $current = 0;

            while( count( $segments ) !== 0 && array_key_exists( $segments[0],  $this->tree[ $current ][ 'nodes' ] ) )
            {
                $name = array_shift( $segments );
                $current = $this->tree[ $current ][ 'nodes' ][ $name ];
            }

            return [ $segments, $this->tree[ $current ][ 'paths' ] ];
        }


        protected function combinePaths( $locations, $filepath )
        {
            foreach ( $locations as $id => $path )
            {
                $locations[ $id ] = $path . DIRECTORY_SEPARATOR . $filepath;
            }

            if ( empty( $locations ) )
            {
                $locations = [ DIRECTORY_SEPARATOR . $filepath ];
            }

            return $locations;
        }


        protected function growNode( $name, $current )
        {
            if ( array_key_exists( $name,  $this->tree[ $current ][ 'nodes' ] ) === false )
            {
                $this->tree[] = [
                    'nodes' => [],
                    'paths' => [],
                ];
                $this->tree[ $current ][ 'nodes' ][ $name ] = count( $this->tree ) - 1;
            }

            return $this->tree[ $current ][ 'nodes' ][ $name ];
        }

    }