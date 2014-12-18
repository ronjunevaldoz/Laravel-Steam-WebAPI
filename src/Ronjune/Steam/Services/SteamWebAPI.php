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
use Ronjune\Steam\Exceptions\WebApiException;

class SteamWebAPI {

    const BASE_URL = 'api.steampowered.com';
    const VERSION = 1;
    const APPID = '570'; // dota2
    const LANG = 'en_US';
    const KEY = '**YOUR API KEY HERE**';
    const SECURE = true;
    const COOKIES_ENABLED = false;
    const AUTO_RESULT = true; // always return object result if true.

    private $auto = self::AUTO_RESULT;
    private $client = null;

    private $base_url = '';
    private $key ='';
    private $appid = '';
    private $language = '';

    private $interface = '';
    private $method = '';
    private $version = '';

    private $secure = '';

    private $save_to = '';
    private $params = [];
    private $storage = '';
    private $generated_url = '';

    private $response = null;
    private $result = null; // string(body) json object or array

    public function __construct() {
        $storage = Config::get('steam::config.storage', storage_path('steam'));
        $key = Config::get('steam::config.api.key', self::KEY);
        $appid = Config::get('steam::config.api.appid', self::APPID);
        $lang = Config::get('steam::config.api.lang', self::LANG);
        $version =  Config::get('steam::config.api.version', self::VERSION);
        $base_url = Config::get('steam::config.api.base_url', self::BASE_URL);

        $this->setBaseUrl($base_url);
        $this->setStorage($storage);
        $this->setKey($key);
        $this->setAppid($appid); 
        $this->setLanguage($lang); 
        $this->setVersion($version);
    }

    
    public function request($httpmethod = 'get', $interface = '', $method = '', $version = '', $parameters = [], $save_to = '', $secure = '') {
        
        if(!isset($parameters['appid'])){
            $parameters = array_add($parameters, 'appid', $this->appid);
        }

        if(!isset($parameters['language'])){
            $parameters = array_add($parameters, 'language', $this->language);
        }

        if(!isset($parameters['key'])){
            $parameters = array_add($parameters, 'key', $this->key);
        }

        $this->sanitizeRequestParameters($parameters);

        $secure = empty($secure) ? self::SECURE : false;
        $protocol = $secure ? 'https' : 'http';
        $base_url = "$protocol://{$this->base_url}/{interface}/{method}/v{version}/";


        $interface = empty($interface) ? $this->interface : $interface;
        $method = empty($method) ? $this->method : $method;
        $version = empty($version) ? $this->version : $version;

        if(empty($interface)){
            throw new WebApiException("Invalid or Empty Web Api Interface: $interface");
        }
        if(empty($method)){
            throw new WebApiException("Invalid or Empty Web Api Method: $method");
        }
         if(empty($version)){
            throw new WebApiException("Invalid or Empty Web Api Version: $version");
        }
        
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
            'cookies' => self::COOKIES_ENABLED
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
            
        }

        return $this;
    }


    private function sanitizeRequestParameters($parameters = []){
        $parameters = empty($parameters) ? $this->params : $parameters;
        foreach ($parameters as $index => $parameter) {
            if (empty($parameter)) {
                unset($parameter[$index]);
            }
        }
    }




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
        return $this;
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
        return $this;
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
        if(!preg_match('/^[0-9]{1}$/', $version)){
            throw new WebApiException("Invalid Web Api Version: $version, Expected numeric with maximum length of 1.");
        } else {
            $version = str_pad($version, 4, '0', STR_PAD_LEFT);
            $this->version = $version;
        }
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
     * @param string $version
     */
    public  function saveTo($path = '') {
         $this->save_to = $path;
         return $this;
     }


    public function get($interface = '', $method = '', $version = '', $parameters = [], $save_to = '', $secure = ''){
        $this->result = $this->request('get',$interface,$method,$version,$parameters,$save_to,$secure)->getResponse();
        if( $this->result != null){
            return $this->auto ? $this->toObject() : $this;
        } else {
            return null;
        }
    }

    public function post($interface = '', $method = '', $version = '', $parameters = [], $save_to = '', $secure = ''){
         $this->result = $this->request('post',$interface,$method,$version,$parameters,$save_to,$secure)->getResponse();
        if( $this->result != null){
            return $this->auto ? $this->toObject() : $this;
        } else {
            return null;
        }
    }

    public function setAuto($auto = true){
        $this->auto = $auto;
    }

    public function getResult(){
        return $this->result;
    }

    public function toBody(){
        return $this->result->getBody();
    }

    public function toArray(){
         return $this->result->json([
            'object' => false,
            'big_int_strings' => true
            ]);
    }

    public function toObject(){
         return $this->result->json([
            'object' => true,
            'big_int_strings' => true
            ]);
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
        // if($this->response == null){
        //     throw new WebApiException("Web Api Response: null");
        // }
        return $this->response;
    }


    /**
     * Sets the value of key.
     *
     * @param mixed $key the key
     *
     * @return self
     */
    public function setKey($key)
    {
        if(!is_string($key) || empty($key) || !preg_match('/^[0-9A-F]{32}$/', $key)){
            $key = $this->hideKey($key);
            throw new WebApiException("Invalid or Empty Web Api Key: $key");
        }else {
             $this->key = $key;
        }
        return $this;
    }

    private function hideKey($key, $mask ='**HIDDEN**'){
        return str_replace($key, $mask, $key);
    }

    /**
     * Sets the value of language.
     *
     * @param mixed $language the language
     *
     * @return self
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }


    /**
     * Gets the value of base_url.
     *
     * @return mixed
     */
    public function getBaseUrl()
    {
        return $this->base_url;
    }

    /**
     * Sets the value of base_url.
     *
     * @param mixed $base_url the base url
     *
     * @return self
     */
    public function setBaseUrl($base_url)
    {
        $this->base_url = $base_url;

        return $this;
    }

    /**
     * Gets the value of storage.
     *
     * @return mixed
     */
    public function getStorage()
    {
        return $this->storage;
    }

    /**
     * Sets the value of storage.
     *
     * @param mixed $storage the storage
     *
     * @return self
     */
    public function setStorage($storage)
    {
        $this->storage = $storage;

        return $this;
    }
}
