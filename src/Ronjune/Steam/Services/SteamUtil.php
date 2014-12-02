<?php

namespace Ronjune\Steam\Services;

use Ronjune\Steam\Services\SteamWebAPI;
use Ronjune\Steam\Exceptions\SteamFileStorageFileNotFoundException;

class SteamUtil {

	const FOLDER = 'steam';


	public static function storage($filename='', $prefix ='', $sufix=''){
		$prefix = empty($prefix) ? '' : $prefix . '_';
		$sufix = empty($sufix) ? '' : '_'.$sufix;
		$created_filename = str_replace(' ','',$prefix.$filename.$sufix);
		$storage = storage_path(self::FOLDER . '/'.$created_filename);
		return $storage;
	}

	public static function fileExists($filename=''){
		if(!file_exists(SteamUtil::storage($filename))){
			return false;
		} else {
			return true;
		}
	}


	public static function getJson($filename = '') {
		$path = self::storage($filename);
		if (!file_exists($path)) {
			throw new SteamFileStorageFileNotFoundException("Steam Error: File `$filename` not found");
		} else {
			$contents = file_get_contents($path);
			$json = null;
			if (is_string($contents)) {
				$json = json_decode($contents, false);
			}
			if (json_last_error() === JSON_ERROR_NONE) {
				return $json;
			} else {
                // return INVALID JSON OR OTHER ERROR
            // json_last_error()
				return null;
			}
		}
	}

	public static function vdfToJson($vdfSource = '', $jsonDestination = '') {
		ini_set('memory_limit', '-1');
        //    $itemCache = file_get_contents(Steam::createCacheSource('items_game'));
        //load VDF data either from API call or fetching from file/url
        //no matter your method, $json must contain the VDF data to be parsed
		$vdfOriginal = file_get_contents(SteamUtil::storage($vdfSource));

        //encapsulate in braces
		$vdfNew = "{\n$vdfOriginal\n}";

        //replace open braces
		$pattern = '/"([^"]*)"(\s*){/';
		$replace = '"${1}": {';
		$vdfNew = preg_replace($pattern, $replace, $vdfNew);

        //replace values
		$pattern = '/"([^"]*)"\s*"([^"]*)"/';
		$replace = '"${1}": "${2}",';
		$vdfNew = preg_replace($pattern, $replace, $vdfNew);

        //remove trailing commas
		$pattern = '/,(\s*[}\]])/';
		$replace = '${1}';
		$vdfNew = preg_replace($pattern, $replace, $vdfNew);

        //add commas
		$pattern = '/([}\]])(\s*)("[^"]*":\s*)?([{\[])/';
		$replace = '${1},${2}${3}${4}';
		$vdfNew = preg_replace($pattern, $replace, $vdfNew);

        //object as value
		$pattern = '/}(\s*"[^"]*":)/';
		$replace = '},${1}';
		$vdfNew = preg_replace($pattern, $replace, $vdfNew);

        //we now have valid json which we can use and/or store it for later use
		file_put_contents(SteamUtil::storage($jsonDestination), $vdfNew);
	}


}