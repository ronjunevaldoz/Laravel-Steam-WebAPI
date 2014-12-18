Laravel-Steam-WebAPI
====================

Simple Laravel steam web api

Installation
============

```
 require "ronjune/steam": "dev-master"
 
 Provide 'Ronjune\Steam\SteamServiceProvider'
 
 Alias 'SteamWebAPI' => 'Ronjune\Steam\Facades\SteamWebAPI'
```

Usage
========
<code>
 $interface = '';
 $method = '';
 $version = 1 ; // Must be numeric and maximum length of 1. This will be automatically generated to v0001;
 
 SteamWebAPI::get($interface, $method, $version, $parameters); // Default result is json object or null
</code>
