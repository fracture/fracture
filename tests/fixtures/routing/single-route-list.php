<?php


    return [
        [ '/fixtures/configs/routes-single.json',
          '/foo',
          [ 'alpha' => 'foo',
            'beta'  => 'qux' ] ],
                        
        [ '/fixtures/configs/routes-single.json',
          '/foo/bar',
          [ 'alpha' => 'foo',
            'beta'  => 'bar' ] ],
            
    ];