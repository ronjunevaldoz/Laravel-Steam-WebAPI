<?php

namespace Ronjune\Steam;

use Illuminate\Support\ServiceProvider;

class SteamServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot() {
        $this->package('ronjune/steam');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        // new

        $this->app->bind('steamwebapi', function() {
            return new Services\SteamWebAPI();
        });
        $this->app->bind('steamwebapiutil', function() {
            return new Services\SteamWebAPIUtil();
        });
        $this->app->bind('steamuser', function() {
            return new Services\SteamUser();
        });

        $this->app->bind('steameconomy', function() {
            return new Services\SteamEconomy();
        });

        $this->app->bind('econitems', function() {
            return new Services\EconItems();
        });

        
        $this->app->bind('steam', function() {
            return new Services\Steam();
        });

        
        $this->app->bind('steam_remote_storage', function() {
            return new Services\SteamRemoteStorage();
        });

        $this->app->bind('appschema', function() {
            return new Services\AppSchema();
        });

        $this->app->bind('steam_util', function() {
            return new Services\SteamUtil();
        });



        /*  ------------------------------------
         *  DotA2 (Defence of the Ancients 2)
         *  ------------------------------------
         *  Matches, GameItems, Rarities, etc..
         */



        $this->app->bind('econdota2', function() {
            return new Services\DotA2\EconDota2();
        });

        
        $this->app->bind('dota2match', function() {
            return new Services\DotA2\DotA2Match();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {
        return array(
            'steam',
            'steam_util', 
            'steamwebapi',
            'steamwebapiutil',
            'steam_remote_storage', 
            'steamuser',
            'steameconomy',
            'econitems', 
            'econdota2',  
            'appschema',
            'dota2match'
            );
    }

}
