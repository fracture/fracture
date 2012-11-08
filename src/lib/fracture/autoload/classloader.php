<?php

    namespace Fracture\Autoload;


    class ClassLoader
    {

        protected $map;

        protected $silent;

        protected $basePath = DIRECTORY_SEPARATOR;

        
        public function __construct( Searchable $map, $silent = false )
        {
            $this->map = $map;
            $this->silent = $silent;
        }
        

        public function setBasePath( $basePath )
        {
            $this->basePath = $basePath;
        }


        public function register()
        {
            spl_autoload_register( array( $this, 'load' ) );
        }



        protected function load( $className )
        {

            $locations = $this->map->getLocations( $className );

            foreach ( $locations as $filepath )
            {
                $filepath = $this->basePath . $filepath;
                if ( file_exists( $filepath ) )
                {
                    require $filepath;
                    return;
                }
            }

            if ( $this->silent === FALSE )
            {
                throw new ClassNotFoundException( "Class '$className' not found!" );
            }
        }


    }

?>