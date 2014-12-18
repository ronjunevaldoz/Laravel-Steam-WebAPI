<?php

namespace Ronjune\Steam\Services;

use Ronjune\Steam\Services\SteamWebAPI;
use Ronjune\Steam\Services\EconItems;
class AppSchema {

	private $items_game_url = '';
	private $qualities = [];
	private $qualityNames = [];
	private $originNames = [];
	private $items = [];
	private $item_sets = [];

	const APP_SCHEMA_JSON = 'schema.json';
	const APP_SCHEMA_ITEMS_GAME_VDF = 'items_game.vdf';
	const APP_SCHEMA_ITEMS_GAME_JSON = 'items_game.json';

	private $app_schema_path  = '';
	private $app_items_game_path = '';

	private $schema = null;

	public function __construct(){
        $this->app_schema_path = SteamUtil::storage(self::APP_SCHEMA_JSON);
        $this->app_items_game_json_path = SteamUtil::storage(self::APP_SCHEMA_ITEMS_GAME_JSON);
        $this->app_items_game_vdf_path = SteamUtil::storage(self::APP_SCHEMA_ITEMS_GAME_VDF);
    }

    public function deleteFiles(){
        \File::delete($this->app_schema_path);
        \File::delete($this->app_items_game_json_path);
        \File::delete($this->app_items_game_vdf_path);
    }

	public function create(){
		ini_set('max_execution_time', 0);
		if (!file_exists($this->app_schema_path)) {
            // Download and Save schema to steam storage

			\EconItems::getSchema(self::APP_SCHEMA_JSON);
		}

		$json = $this->fetch();

		$result = !is_null($json) && is_object($json) && isset($json->result) ? $json->result : null;

		if(!is_null($result)){

			$this->items_game_url = $result->items_game_url;
			$this->qualities = $result->qualities;
			$this->qualityNames = $result->qualityNames;
			$this->originNames = $result->originNames;
			$this->items = $result->items;
			$this->item_sets = $result->item_sets;

			if (!file_exists($this->app_items_game_vdf_path)) {
	            // SAVE Items Game using items_game_url
				copy($this->items_game_url, $this->app_items_game_vdf_path);
			}

			if (!\file_exists($this->app_items_game_json_path)) {
	            // Convert VDF (.vdf file) into JSON
				SteamUtil::vdfToJson(self::APP_SCHEMA_ITEMS_GAME_VDF,self::APP_SCHEMA_ITEMS_GAME_JSON);
			} 
		}
	}


	private function fetch($schema = true){
		return SteamUtil::getJson($schema == true ? self::APP_SCHEMA_JSON: self::APP_SCHEMA_ITEMS_GAME_JSON);
	}

    /**
     * Gets the value of items_game_url.
     *
     * @return mixed
     */
    public function getItemsGameUrl()
    {
        return $this->items_game_url;
    }

    /**
     * Sets the value of items_game_url.
     *
     * @param mixed $items_game_url the items game url
     *
     * @return self
     */
    private function setItemsGameUrl($items_game_url)
    {
        $this->items_game_url = $items_game_url;

        return $this;
    }

    /**
     * Gets the value of qualities.
     *
     * @return mixed
     */
    public function getQualities()
    {
        return $this->qualities;
    }

    /**
     * Sets the value of qualities.
     *
     * @param mixed $qualities the qualities
     *
     * @return self
     */
    private function setQualities($qualities)
    {
        $this->qualities = $qualities;

        return $this;
    }

    /**
     * Gets the value of qualityNames.
     *
     * @return mixed
     */
    public function getQualityNames()
    {
        return $this->qualityNames;
    }

    /**
     * Sets the value of qualityNames.
     *
     * @param mixed $qualityNames the quality names
     *
     * @return self
     */
    private function setQualityNames($qualityNames)
    {
        $this->qualityNames = $qualityNames;

        return $this;
    }

    /**
     * Gets the value of originNames.
     *
     * @return mixed
     */
    public function getOriginNames()
    {
        return $this->originNames;
    }

    /**
     * Sets the value of originNames.
     *
     * @param mixed $originNames the origin names
     *
     * @return self
     */
    private function setOriginNames($originNames)
    {
        $this->originNames = $originNames;

        return $this;
    }

    /**
     * Gets the value of items.
     *
     * @return mixed
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Sets the value of items.
     *
     * @param mixed $items the items
     *
     * @return self
     */
    private function setItems($items)
    {
        $this->items = $items;

        return $this;
    }

    /**
     * Gets the value of item_sets.
     *
     * @return mixed
     */
    public function getItemSets()
    {
        return $this->item_sets;
    }

    /**
     * Sets the value of item_sets.
     *
     * @param mixed $item_sets the item sets
     *
     * @return self
     */
    private function setItemSets($item_sets)
    {
        $this->item_sets = $item_sets;

        return $this;
    }

    /**
     * Gets the value of app_schema_path.
     *
     * @return mixed
     */
    public function getAppSchemaPath()
    {
        return $this->app_schema_path;
    }

    /**
     * Sets the value of app_schema_path.
     *
     * @param mixed $app_schema_path the app schema path
     *
     * @return self
     */
    private function setAppSchemaPath($app_schema_path)
    {
        $this->app_schema_path = $app_schema_path;

        return $this;
    }

    /**
     * Gets the value of app_items_game_path.
     *
     * @return mixed
     */
    public function getAppItemsGamePath()
    {
        return $this->app_items_game_path;
    }

    /**
     * Sets the value of app_items_game_path.
     *
     * @param mixed $app_items_game_path the app items game path
     *
     * @return self
     */
    private function setAppItemsGamePath($app_items_game_path)
    {
        $this->app_items_game_path = $app_items_game_path;

        return $this;
    }

    /**
     * Gets the value of schema.
     *
     * @return mixed
     */
    public function getSchema()
    {
        return $this->schema;
    }

    /**
     * Sets the value of schema.
     *
     * @param mixed $schema the schema
     *
     * @return self
     */
    private function setSchema($schema)
    {
        $this->schema = $schema;

        return $this;
    }
}