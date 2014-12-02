<?php

/**
 * Created by PhpStorm.
 * User: R0N
 * Date: 11/9/2014
 * Time: 11:46 AM
 */

namespace Ronjune\Steam\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Config;

use Ronjune\Steam\Services\SteamUtil;

use Ronjune\Steam\Exceptions\SteamWebAPIRequestException;
use Ronjune\Steam\Exceptions\SteamWebAPINotReadyException;

class SteamWebAPI {

    const default_base_url = 'api.steampowered.com';
    const default_appid = '570'; // dota2
    const default_lang = 'en_US';
    const default_key = '**YOUR API KEY HERE**';
    const cookies_enabled = false;

    protected $client = null;

    protected $key ='';
    protected $appid = '';
    protected $language = '';

    protected $interface = '';
    protected $method = '';
    protected $version = 'v0001';

    protected $secure = true;
    protected $ready = false;

    protected $save_to = '';
    protected $params = [];
    protected $storage = '';
    protected $errors = [];

    protected $generated_url = '';
    protected $body_only = false;


    protected $response = null;

    

    public function __construct() {
        $this->storage = Config::get('steam::config.storage', storage_path('steam'));
        $this->key = Config::get('steam::config.api.key', self::default_key);
        $this->appid = Config::get('steam::config.api.appid', self::default_appid);
        $this->language = Config::get('steam::config.api.lang', self::default_lang);
        $this->ready = true;
    }

    // public  function getStorage($filename = '') {
    //     return $this->storage . '/' . $filename;
    // }

    // public  function setStorage($storage_path) {
    //     $this->storage = $storage_path;
    //     return  $this;
    // }

    /**
     * @return mixed
     */
    public function getAppid() {
        return  $this->appid;
    }

    /**
     * @param mixed $appid
     */
    public function setAppid($appid) {
        $this->appid = $appid;
    }

    /**
     * @return mixed
     */
    public  function getInterface() {
        return $this->interface;
    }

    /**
     * @param mixed $interface
     */
    public  function setInterface($interface) {
        $this->interface = $interface;
    }

    /**
     * @return mixed
     */
    public  function getMethod() {
        return $this->method;
    }

    /**
     * @param mixed $method
     */
    public  function setMethod($method) {
        $this->method = $method;
        return $this;
    }

    /**
     * @return mixed
     */
    public  function getVersion() {
        return $this->version;
    }

    /**
     * @param mixed $version
     */
    public  function setVersion($version) {
        $this->version = $version;
        return $this;
    }

    /**
     * @return array
     */
    public  function getParams() {
        return $this->params;
    }

    /**
     * @param array $version
     */
    public  function setParams($params) {
        $this->params = $params;
        return $this;
    }

    /**
     * @return string
     */
    public  function getSaveTo() {
        return $this->save_to;
    }

    /**
     * @param string $version
     */
    public  function saveTo($path = '') {
       $this->save_to = $path;
       return $this;
   }


   public function get(){
    $request = $this->request('get')->response;
    return  (!is_null($request)) ?  $request->json([
        'object' => true,
        'big_int_strings' => true
        ]) : null;
}

public function getBody(){
    $request = $this->request('get')->response;
    return  (!is_null($request)) ?  $request->getBody() : null;
}
public function getToArray(){
    $request = $this->request('get')->response;
    return  (!is_null($request)) ?  $request->json([
        'object' => false,
        'big_int_strings' => true
        ]) : null;
}

public function request($httpmethod = 'get', $interface = '', $method = '', $version = 'v0001', $parameters = [], $save_to = '', $secure = false) {
    if(!$this->ready){
        throw new SteamWebAPINotReadyException("SteamWebAPI instance is not created!");
    }
    $parameters = empty($parameters) ? $this->getParams() : $parameters;

    foreach ($parameters as $index => $value) {
        if (empty($value)) {
            unset($parameters[$index]);
        }
    }
    $http = $secure ? 'https://' : 'http://';

    $parameters = array_add($parameters, 'appid', $this->appid);
    $parameters = array_add($parameters, 'language', $this->language);
    $parameters = array_add($parameters, 'key', $this->key);

    $base_url = $http . self::default_base_url . '/{interface}/{method}/{version}/';

    $interface = empty($interface) ? $this->getInterface() : $interface;
    $method = empty($method) ? $this->getMethod() : $method;
    $version = empty($version) ? $this->getVersion() : $version;


    $uri_segments = [
    'interface' => $interface,
    'method' => $method,
    'version' => $version
    ];

    $base_url_options = [$base_url, $uri_segments];
    $defaults = [];
    $this->client = new Client([
        'base_url' => $base_url_options,
        'defaults' => $defaults
        ]);

    $options = [
    'query' => $parameters,
    'cookies' => self::cookies_enabled
    ];

    if (!empty($save_to)) {
        $options['save_to'] = SteamUtil::storage($save_to);
    } else {
        if(!empty($this->save_to)){
           $options['save_to'] = SteamUtil::storage($this->save_to);
       }
   }



   $request = $this->client->createRequest($httpmethod, null, $options);
   $request->addHeader('Accept-Encoding', 'GZIP');
   $request->addHeader('Content-Type', 'application/json');
   $this->generated_url = $request->getUrl();
   try {
    $this->response = $this->client->send($request);
} catch (RequestException $e) {
    $message =  "Query failed: ".str_replace($this->key, '**VALID_HIDDEN**', $request->getUrl());
                    // var_dump($e);
                    // throw new SteamWebAPIRequestException( $e->status().$message);  
}

return $this;
}

public function getErrors() {
    return $this->errors;
}

public function hasErrors() {
    return count($this->errors) > 0;
}






//    public function get($interface = '') {
//        $object = $this->getSupportedAPIList($interface);
//        if (is_object($object)) {
//            $dynamic = new Dynamic();
//            foreach ($object->methods as $method) {
//                $dynamic->{$method->name} = $method;
//            }
////            return $object->methods;
//            return $dynamic;
//        }
//    }
//
//class Dynamic {
//
//    public function __call($method, $args) {
//        if (isset($this->$method)) {
//            $func = $this->$method;
//            return call_user_func_array($func, $args);
//        }
//    }
//
//
    /**
     * Gets the value of client.
     *
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Gets the value of key.
     *
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Gets the value of language.
     *
     * @return mixed
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Gets the value of secure.
     *
     * @return mixed
     */
    public function getSecure()
    {
        return $this->secure;
    }

    /**
     * Gets the value of ready.
     *
     * @return mixed
     */
    public function getReady()
    {
        return $this->ready;
    }

    /**
     * Gets the value of generated_url.
     *
     * @return mixed
     */
    public function getGeneratedUrl()
    {
        return $this->generated_url;
    }

    /**
     * Gets the value of response.
     *
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Sets the value of client.
     *
     * @param mixed $client the client
     *
     * @return self
     */
    protected function setClient($client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Sets the value of key.
     *
     * @param mixed $key the key
     *
     * @return self
     */
    protected function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Sets the value of language.
     *
     * @param mixed $language the language
     *
     * @return self
     */
    protected function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Sets the value of secure.
     *
     * @param mixed $secure the secure
     *
     * @return self
     */
    protected function setSecure($secure)
    {
        $this->secure = $secure;

        return $this;
    }

    /**
     * Sets the value of ready.
     *
     * @param mixed $ready the ready
     *
     * @return self
     */
    protected function setReady($ready)
    {
        $this->ready = $ready;

        return $this;
    }

    /**
     * Sets the value of save_to.
     *
     * @param mixed $save_to the save to
     *
     * @return self
     */
    protected function setSaveTo($save_to)
    {
        $this->save_to = $save_to;

        return $this;
    }

    /**
     * Sets the value of errors.
     *
     * @param mixed $errors the errors
     *
     * @return self
     */
    protected function setErrors($errors)
    {
        $this->errors = $errors;

        return $this;
    }

    /**
     * Sets the value of generated_url.
     *
     * @param mixed $generated_url the generated url
     *
     * @return self
     */
    protected function setGeneratedUrl($generated_url)
    {
        $this->generated_url = $generated_url;

        return $this;
    }

    /**
     * Gets the value of body_only.
     *
     * @return mixed
     */
    public function getBodyOnly()
    {
        return $this->body_only;
    }

    /**
     * Sets the value of body_only.
     *
     * @param mixed $body_only the body only
     *
     * @return self
     */
    protected function setBodyOnly($body_only)
    {
        $this->body_only = $body_only;

        return $this;
    }

    /**
     * Sets the value of response.
     *
     * @param mixed $response the response
     *
     * @return self
     */
    protected function setResponse($response)
    {
        $this->response = $response;

        return $this;
    }
}
