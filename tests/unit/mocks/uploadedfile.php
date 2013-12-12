<?php

    namespace Mock;

    class UploadedFile extends \Fracture\Http\UploadedFile
    {

        protected function seemsTampered( $filename )
        {
            return false;
        }
    }