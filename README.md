## ip-api for Kohana

#### Installation

Place config file in your modules directory.

Copy `MODPATH.menu/config/ip-api.php` into `APPPATH/config/ip-api.php` and customize.

Activate the module in `bootstrap.php`.

```php
<?php
Kohana::modules(array(
	...
	'ip-api' => MODPATH.'ip-api',
));
```
#### Using the Module
##### By IP (support IPv4 and IPv6)
Takes the IP address of your server by default when you not pass the IP address as parameter
```php
$output = IpApi::instance('208.80.152.201')->request();

// Output:
stdClass Object
(
    [as] => AS14907 Wikimedia Foundation Inc.
    [city] => San Francisco
    [country] => United States
    [countryCode] => US
    [isp] => Wikimedia Foundation
    [lat] => 37.7898
    [lon] => -122.3942
    [org] => Wikimedia Foundation
    [query] => 208.80.152.201
    [region] => CA
    [regionName] => California
    [status] => success
    [timezone] => America/Los_Angeles
    [zip] => 94105
)
```
We can override the default configuration by passing a second parameter:
```php
$config = array(
	'language'	=> 'es',
	'format'	=> 'xml'
);

$output = IpApi::instance('208.80.152.201', $config);

// Output:
<?xml version="1.0" encoding="UTF-8"?>
<query>
	<status><![CDATA[success]]></status>
	<country><![CDATA[Estados Unidos]]></country>
	<countryCode><![CDATA[US]]></countryCode>
	<region><![CDATA[CA]]></region>
	<regionName><![CDATA[California]]></regionName>
	<city><![CDATA[San Francisco]]></city>
	<zip><![CDATA[94105]]></zip>
	<lat><![CDATA[37.7898]]></lat>
	<lon><![CDATA[-122.3942]]></lon>
	<timezone><![CDATA[America/Los_Angeles]]></timezone>
	<isp><![CDATA[Wikimedia Foundation]]></isp>
	<org><![CDATA[Wikimedia Foundation]]></org>
	<as><![CDATA[AS14907 Wikimedia Foundation Inc.]]></as>
	<query><![CDATA[208.80.152.201]]></query>
</query>
```
We can request only the fields that we want

```php
$output = IpApi::instance('208.80.152.201')->country()->country_code()->request();

// Output:
stdClass Object
(
    [country] => United States
    [countryCode] => US
)
```
##### By Domain
```php
$output = IpApi::instance('wikipedia.org')->request();

// Output:
stdClass Object
(
    [as] => AS14907 Wikimedia Foundation Inc.
    [city] => San Francisco
    [country] => United States
    [countryCode] => US
    [isp] => Wikimedia Foundation
    [lat] => 37.7898
    [lon] => -122.3942
    [org] => Wikimedia Foundation
    [query] => 208.80.154.224
    [region] => CA
    [regionName] => California
    [status] => success
    [timezone] => America/Los_Angeles
    [zip] => 94105
)
```

#### Localization
Localized city, regionName and country are automatically translated in many languages.  Currently support:

| Language      | Description            |
| ------------- |:----------------------:|
| en            | English (default)      |
| de            | Deutsch (German)       |
| es            | Español (Spanish)      |
| pt-BR         | Português (Portuguese) |
| fr            | Français (French)      |
| ja            | 日本語 (Japanese)      |
| zh-CN         | 中国 (Chinese)         |
| ru            | Русский (Russian)      |

You can go to http://ip-api.com/docs/ and read the full documentation.

#### ABOUT AND LICENSE

Copyright (c) 2016, Soft Media Development. All right reserved. Website: www.smd.com.pa

This project is using IP Geolocation API from http://ip-api.com created by Vlad.

This project is made under BSD license. See LICENSE file for more information.
