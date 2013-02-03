<?php

    namespace Fracture\Autoload;


    class ClassLoader
    {

        protected $maps = [];


        public function addMap( Searchable $map, $basePath )
        {
            $item = [
                'map'  => $map,
                'path' => $basePath,
            ];

            $this->maps[] = $item;
        }



        public function register()
        {
            spl_autoload_register( [ $this, 'load' ] );
        }


        protected function load( $className )
        {
            foreach ( $this->maps as $option )
            {
                // gets a list of possible filepaths for the class definition
                $locations = $option['map']->getLocations( $className );

                if ( $this->hasLoadedClass( $option['path'], $locations ) )
                {
                    return true;
                }
            }

            return false;
        }


        protected function hasLoadedClass( $path, $locations )
        {
            foreach ( $locations as $filepath )
            {
                $filepath = $path . $filepath;

                if ( file_exists( $filepath ) )
                {
                    require $filepath;
                    return true;
                }
            }

            return false;
        }


    }