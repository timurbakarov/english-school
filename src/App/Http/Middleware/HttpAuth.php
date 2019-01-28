<?php

namespace App\Http\Middleware;

use App\Application;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Config\Repository;

class HttpAuth extends Middleware
{
    /**
     * @var Repository
     */
    private $config;

    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param array ...$guards
     * @return mixed
     */
    public function handle($request, \Closure $next, ... $guards)
    {
        if(app()->environment() != 'testing') {
            $this->httpAuth();
        }

        return $next($request);
    }

    /**
     *
     */
    private function httpAuth()
    {
        if (!$this->validCredentials()) {
            header('WWW-Authenticate: Basic realm="My Realm"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'Access denied';
            exit;
        }
    }

    /**
     * @return bool
     */
    private function validCredentials()
    {
        if(!isset($_SERVER['PHP_AUTH_USER']) OR !isset($_SERVER['PHP_AUTH_PW'])) {
            return false;
        }

        if(!$_SERVER['PHP_AUTH_USER'] OR !$_SERVER['PHP_AUTH_PW']) {
            return false;
        }

        return $_SERVER['PHP_AUTH_USER'] == $this->config->get('httpauth.username')
            && $_SERVER['PHP_AUTH_PW'] == $this->config->get('httpauth.password');
    }
}
