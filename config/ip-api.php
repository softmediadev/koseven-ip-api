<?php defined('SYSPATH') or die('No direct script access.');

return array
(
	'protocol' => 'http',
	'host' => 'ip-api.com',
	'format' => 'json',
	'language' => I18n::$lang,
	'default' => array('country', 'countryCode', 'region', 'regionName', 'city', 'zip', 'lat', 'lon', 'timezone', 'isp', 'org', 'as', 'query', 'status', 'message')
);