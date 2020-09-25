<?php defined('SYSPATH') or die('No direct scrvaluet access.');

class Kohana_IpApi
{

	protected     $value;
	protected     $url;
	protected     $format;
	protected     $language;
	protected     $fields  = array();
	protected     $default = array();

	public static function instance($value = NULL, array $options = NULL)
	{
		return new self($value, $options);
	}

	public function __construct($value = NULL, array $options = NULL)
	{
		$this->value = $value;

		if ( ! is_array($options))
			$options = array();

		$localhost = array('127.0.0.1', '::1');
		$config    = Kohana::$config->load('ip-api')->as_array();

		$config = Arr::merge($config, $options);

		if (in_array($this->value, $localhost))
			$this->value = '';

		$this->language = $config['language'];
		$this->url      = rtrim($config['host'], '/').'/';
		$this->format   = $config['format'];
		$this->default  = $config['default'];
	}

	public function request()
	{
		$params = array();

		if ( ! empty($this->language))
			$params['lang'] = $this->language;

		$params['fields'] = empty($this->fields) ? $this->default : $this->fields;
		$params['fields'] = Arr::merge(array('status', 'message'), $params['fields']);

		$url = $this->url.rtrim($this->format, '/').'/'.$this->value;

		try {
			$result = Request::factory($url)
				->method(Request::GET)
				->headers('Content-Type', File::mime_by_ext($this->format));

			foreach($params as $k => $v)
			{
				if (is_array($v))
					$v = implode(',', $v);

				$result->query($k, $v);
			}

			$result = $result->execute();

			if ($this->format == 'json')
				$result = json_decode($result);
		} catch (Exception $e) {
			$result = [];
			Log::instance()->add(Log::ERROR, $e->getMessage())->write();
		}

		if (empty((array) $result))
			return (object) array_map(function(){}, array_flip($params['fields']));
		else
			return $result;
	}

	private function add_field($value)
	{
		$this->fields[] = $value;

		return $this;
	}

	public function language($value)
	{
		$this->language = $value;

		return $this;
	}

	public function country()
	{
		return $this->add_field('country');
	}

	public function country_code()
	{
		return $this->add_field('countryCode');
	}

	public function region()
	{
		return $this->add_field('region');
	}

	public function region_name()
	{
		return $this->add_field('regionName');
	}

	public function city()
	{
		return $this->add_field('city');
	}

	public function zip()
	{
		return $this->add_field('zip');
	}

	public function lat()
	{
		return $this->add_field('lat');
	}

	public function lon()
	{
		return $this->add_field('lon');
	}

	public function timezone()
	{
		return $this->add_field('timezone');
	}

	public function isp()
	{
		return $this->add_field('isp');
	}

	public function org()
	{
		return $this->add_field('org');
	}

	public function ARIN()
	{
		return $this->add_field('as');
	}

	public function reverse()
	{
		return $this->add_field('reverse');
	}

	public function mobile()
	{
		return $this->add_field('mobile');
	}

	public function proxy()
	{
		return $this->add_field('proxy');
	}

	public function query()
	{
		return $this->add_field('query');
	}

	public function status()
	{
		return $this->add_field('status');
	}
}
