<?php

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Illuminate\Container\Container;
use Illuminate\Contracts\Bus\Dispatcher;


if (!function_exists('public_path')) {
    /**
     * Return the path to public dir
     *
     * @param null $path
     *
     * @return string
     */
    function public_path($path = null)
    {
        return rtrim(app()->basePath('public/' . $path), '/');
    }
}

if (!function_exists('generateOtp')) {

    /**
     * @return string
     */
    function generateOtp()
    {
        $randomOtp = mt_rand(1000, 9999);

        return $randomOtp ? $randomOtp : 1234;
    }
}

if (!function_exists('sendMail')) {

    /**
     * @return string
     */
    function sendMail($data, $subject, $name = '', $email)
    {
        Mail::send('emails.mail', $data, function ($message) use ($name, $email, $subject) {
            $message->to($email, $name)
                ->subject($subject);
            $message->from(config('mail.username'), env('APP_NAME'));
        });

        // check for failures
        if (Mail::failures()) {

            return false;
        }

        return true;
    }
}


if (!function_exists('include_route_files')) {

    /**
     * @param $folder
     * @return mixed
     */
    function include_route_files($folder)
    {
        try {
            $rdi = new recursiveDirectoryIterator($folder);
            $it = new recursiveIteratorIterator($rdi);
            while ($it->valid()) {
                if (!$it->isDot() && $it->isFile() && $it->isReadable() && $it->current()->getExtension() === 'php') {
                    require $it->key();
                }
                $it->next();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}

if (! function_exists('abort')) {
    /**
     * Throw an HttpException with the given data.
     *
     * @param  int     $code
     * @param  string  $message
     * @param  array   $headers
     * @return void
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    function abort($code, $message = '', array $headers = [])
    {
        return app()->abort($code, $message, $headers);
    }
}

if (! function_exists('app')) {
    /**
     * Get the available container instance.
     *
     * @param  string  $make
     * @param  array   $parameters
     * @return mixed|\Laravel\Lumen\Application
     */
    function app($make = null, $parameters = [])
    {
        if (is_null($make)) {
            return Container::getInstance();
        }

        return Container::getInstance()->make($make, $parameters);
    }
}



if (! function_exists('decrypt')) {
    /**
     * Decrypt the given value.
     *
     * @param  string  $value
     * @return string
     */
    function decrypt($value)
    {
        return app('encrypter')->decrypt($value);
    }
}

if (! function_exists('dispatch')) {
    /**
     * Dispatch a job to its appropriate handler.
     *
     * @param  mixed  $job
     * @return mixed
     */
    function dispatch($job)
    {
        return app(Dispatcher::class)->dispatch($job);
    }
}

if (! function_exists('config')) {
    /**
     * Get / set the specified configuration value.
     *
     * If an array is passed as the key, we will assume you want to set an array of values.
     *
     * @param  array|string  $key
     * @param  mixed  $default
     * @return mixed
     */
    function config($key = null, $default = null)
    {
        if (is_null($key)) {
            return app('config');
        }

        if (is_array($key)) {
            return app('config')->set($key);
        }

        return app('config')->get($key, $default);
    }
}

if (! function_exists('database_path')) {
    /**
     * Get the path to the database directory of the install.
     *
     * @param  string  $path
     * @return string
     */
    function database_path($path = '')
    {
        return app()->databasePath().($path ? '/'.$path : $path);
    }
}

if (! function_exists('encrypt')) {
    /**
     * Encrypt the given value.
     *
     * @param  string  $value
     * @return string
     */
    function encrypt($value)
    {
        return app('encrypter')->encrypt($value);
    }
}

if (! function_exists('env')) {
    /**
     * Gets the value of an environment variable. Supports boolean, empty and null.
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    function env($key, $default = null)
    {
        $value = getenv($key);

        if ($value === false) {
            return value($default);
        }

        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;

            case 'false':
            case '(false)':
                return false;

            case 'empty':
            case '(empty)':
                return '';

            case 'null':
            case '(null)':
                return;
        }

        if (Str::startsWith($value, '"') && Str::endsWith($value, '"')) {
            return substr($value, 1, -1);
        }

        return $value;
    }
}

if (! function_exists('event')) {
    /**
     * Fire an event and call the listeners.
     *
     * @param  string  $event
     * @param  mixed   $payload
     * @param  bool    $halt
     * @return array|null
     */
    function event($event, $payload = [], $halt = false)
    {
        return app('events')->fire($event, $payload, $halt);
    }
}

if (! function_exists('factory')) {
    /**
     * Create a model factory builder for a given class, name, and amount.
     *
     * @param  dynamic  class|class,name|class,amount|class,name,amount
     * @return \Illuminate\Database\Eloquent\FactoryBuilder
     */
    function factory()
    {
        app('db');

        $factory = app('Illuminate\Database\Eloquent\Factory');

        $arguments = func_get_args();

        if (isset($arguments[1]) && is_string($arguments[1])) {
            return $factory->of($arguments[0], $arguments[1])->times(isset($arguments[2]) ? $arguments[2] : 1);
        } elseif (isset($arguments[1])) {
            return $factory->of($arguments[0])->times($arguments[1]);
        } else {
            return $factory->of($arguments[0]);
        }
    }
}

if (! function_exists('info')) {
    /**
     * Write some information to the log.
     *
     * @param  string  $message
     * @param  array   $context
     * @return void
     */
    function info($message, $context = [])
    {
        return app('Psr\Log\LoggerInterface')->info($message, $context);
    }
}


if (! function_exists('resource_path')) {
    /**
     * Get the path to the resources folder.
     *
     * @param  string  $path
     * @return string
     */
    function resource_path($path = '')
    {
        return app()->basePath().'/resources'.($path ? '/'.$path : $path);
    }
}

if (! function_exists('response')) {
    /**
     * Return a new response from the application.
     *
     * @param  object|string  $content
     * @param  int     $status
     * @param  array   $headers
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    function response($content = '', $status = 200, array $headers = [])
    {
        $factory = new Laravel\Lumen\Http\ResponseFactory;

        if (func_num_args() === 0) {
            return $factory;
        }

        return $factory->make($content, $status, $headers);
    }
}

if (! function_exists('route')) {
    /**
     * Generate a URL to a named route.
     *
     * @param  string  $name
     * @param  array   $parameters
     * @param  bool    $secure
     * @return string
     */
    function route($name, $parameters = [], $secure = null)
    {
        return (new Laravel\Lumen\Routing\UrlGenerator(app()))
                ->route($name, $parameters, $secure);
    }
}

if (! function_exists('storage_path')) {
    /**
     * Get the path to the storage folder.
     *
     * @param  string  $path
     * @return string
     */
    function storage_path($path = '')
    {
        return app()->storagePath($path);
    }
}

if (! function_exists('trans')) {
    /**
     * Translate the given message.
     *
     * @param  string  $id
     * @param  array   $parameters
     * @param  string  $domain
     * @param  string  $locale
     * @return string
     */
    function trans($id = null, $parameters = [], $domain = 'messages', $locale = null)
    {
        if (is_null($id)) {
            return app('translator');
        }

        return app('translator')->trans($id, $parameters, $domain, $locale);
    }
}

if (! function_exists('url')) {
    /**
     * Generate a url for the application.
     *
     * @param  string  $path
     * @param  mixed   $parameters
     * @param  bool    $secure
     * @return string
     */
    function url($path = null, $parameters = [], $secure = null)
    {
        return (new Laravel\Lumen\Routing\UrlGenerator(app()))
                                ->to($path, $parameters, $secure);
    }
}

if (! function_exists('view')) {
    /**
     * Get the evaluated view contents for the given view.
     *
     * @param  string  $view
     * @param  array   $data
     * @param  array   $mergeData
     * @return \Illuminate\View\View
     */
    function view($view = null, $data = [], $mergeData = [])
    {
        $factory = app('view');

        if (func_num_args() === 0) {
            return $factory;
        }

        return $factory->make($view, $data, $mergeData);
    }


}

if(!function_exists('config_path'))
{
        /**
        * Return the path to config files
        * @param null $path
        * @return string
        */
        function config_path($path=null)
        {
                return app()->getConfigurationPath(rtrim($path, ".php"));
        }
}

if(!function_exists('storage_path'))
{

        /**
        * Return the path to storage dir
        * @param null $path
        * @return string
        */
        function storage_path($path=null)
        {
                return app()->storagePath($path);
        }
}

if(!function_exists('database_path'))
{

        /**
        * Return the path to database dir
        * @param null $path
        * @return string
        */
        function database_path($path=null)
        {
                return app()->databasePath($path);
        }
}


if(!function_exists('lang_path'))
{

        /**
        * Return the path to lang dir
        * @param null $str
        * @return string
        */
        function lang_path($path=null)
        {
                return app()->getLanguagePath($path);
        }
}

if ( ! function_exists('asset'))
{
    /**
     * Generate an asset path for the application.
     *
     * @param  string  $path
     * @param  bool    $secure
     * @return string
     */
    function asset($path, $secure = null)
    {
        return app('url')->asset($path, $secure);
    }
}

if ( ! function_exists('elixir'))
{
    /**
     * Get the path to a versioned Elixir file.
     *
     * @param  string  $file
     * @return string
     */
    function elixir($file)
    {
        static $manifest = null;
        if (is_null($manifest))
        {
            $manifest = json_decode(file_get_contents(public_path().'/build/rev-manifest.json'), true);
        }
        if (isset($manifest[$file]))
        {
            return '/build/'.$manifest[$file];
        }
        throw new InvalidArgumentException("File {$file} not defined in asset manifest.");
    }
}

if ( ! function_exists('auth'))
{
    /**
     * Get the available auth instance.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    function auth()
    {
        return app('Illuminate\Contracts\Auth\Guard');
    }
}

if ( ! function_exists('bcrypt'))
{
    /**
     * Hash the given value.
     *
     * @param  string  $value
     * @param  array   $options
     * @return string
     */
    function bcrypt($value, $options = array())
    {
        return app('hash')->make($value, $options);
    }
}

if ( ! function_exists('redirect'))
{
    /**
     * Get an instance of the redirector.
     *
     * @param  string|null  $to
     * @param  int     $status
     * @param  array   $headers
     * @param  bool    $secure
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    function redirect($to = null, $status = 302, $headers = array(), $secure = null)
    {
        if (is_null($to)) return app('redirect');
        return app('redirect')->to($to, $status, $headers, $secure);
    }
}

if ( ! function_exists('response'))
{
    /**
     * Return a new response from the application.
     *
     * @param  string  $content
     * @param  int     $status
     * @param  array   $headers
     * @return \Symfony\Component\HttpFoundation\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    function response($content = '', $status = 200, array $headers = array())
    {
        $factory = app('Illuminate\Contracts\Routing\ResponseFactory');
        if (func_num_args() === 0)
        {
            return $factory;
        }
        return $factory->make($content, $status, $headers);
    }
}

if ( ! function_exists('secure_asset'))
{
    /**
     * Generate an asset path for the application.
     *
     * @param  string  $path
     * @return string
     */
    function secure_asset($path)
    {
        return asset($path, true);
    }
}

if ( ! function_exists('secure_url'))
{
    /**
     * Generate a HTTPS url for the application.
     *
     * @param  string  $path
     * @param  mixed   $parameters
     * @return string
     */
    function secure_url($path, $parameters = array())
    {
        return url($path, $parameters, true);
    }
}


if ( ! function_exists('session'))
{
    /**
     * Get / set the specified session value.
     *
     * If an array is passed as the key, we will assume you want to set an array of values.
     *
     * @param  array|string  $key
     * @param  mixed  $default
     * @return mixed
     */
    function session($key = null, $default = null)
    {
        if (is_null($key)) return app('session');
        if (is_array($key)) return app('session')->put($key);
        return app('session')->get($key, $default);
    }
}


if ( ! function_exists('cookie'))
{
    /**
     * Create a new cookie instance.
     *
     * @param  string  $name
     * @param  string  $value
     * @param  int     $minutes
     * @param  string  $path
     * @param  string  $domain
     * @param  bool    $secure
     * @param  bool    $httpOnly
     * @return \Symfony\Component\HttpFoundation\Cookie
     */
    function cookie($name = null, $value = null, $minutes = 0, $path = null, $domain = null, $secure = false, $httpOnly = true)
    {
        $cookie = app('Illuminate\Contracts\Cookie\Factory');
        if (is_null($name))
        {
            return $cookie;
        }
        return $cookie->make($name, $value, $minutes, $path, $domain, $secure, $httpOnly);
    }

}
