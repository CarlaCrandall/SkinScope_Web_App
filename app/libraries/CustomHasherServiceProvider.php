<?php

use Illuminate\Support\ServiceProvider;

class CustomHasherServiceProvider extends ServiceProvider {

    public function register()
    {
        $this->app->bind('hash', function()
        {
            return new CustomHasher;
        });
    }

}