<?php

namespace Anthhyo\DynamicConfig;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DynamicConfig {

	private static ?self $instance = null;

	private Collection $config;

	private function __construct() {
		if (Cache::missing('explosion_config')) {
			$configs = DB::table('config')->pluck('Value', 'Name');
			Cache::forever('explosion_config', $configs);
		}

		$this->config = Cache::get('explosion_config');
	}

	public static function instance(): self {
		if (is_null(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public static function doesExist(string $name): bool {
		return self::instance()->config->has($name);
	}

	public static function doesNotExist(string $name): bool {
		return !self::doesExist($name);
	}

	public static function get(string $name, ?string $default = null): mixed {
		$value = self::instance()->config->get($name, $default);
		return !is_null($default) && is_null($value) ? $default : $value;
	}

	public static function getInt(string $name, ?string $default = null): ?int {
		return is_null($val = self::get($name, $default)) ? null : (int) $val;
	}

	public static function getBoolean(string $name, ?string $default = null): ?bool {
		return is_null($val = self::get($name, $default)) ? null : filter_var($val, FILTER_VALIDATE_BOOLEAN);
	}

	public static function getFloat(string $name, ?string $default = null): ?float {
		return is_null($val = self::get($name, $default)) ? null : (float) $val;
	}

	public static function getString(string $name, ?string $default = null): ?string {
		return is_null($val = self::get($name, $default)) ? null : (string) $val;
	}
}
