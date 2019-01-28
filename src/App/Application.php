<?php

namespace App;

class Application extends \Illuminate\Foundation\Application
{
    /**
     * Get the path to the application "app" directory.
     *
     * @param  string  $path Optionally, a path to append to the app path
     * @return string
     */
    public function path($path = '')
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'src/App'.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}
