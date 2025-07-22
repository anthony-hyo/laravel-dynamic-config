<?php

use Illuminate\Support\Facades\DB;
use Orchestra\Testbench\TestCase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Collection;
use Anthhyo\DynamicConfig\DynamicConfig;

class DynamicConfigTest extends TestCase {

	protected function setUp(): void {
		parent::setUp();

		// Reset the singleton instance of DynamicConfig before each test
		$reflection = new \ReflectionClass(DynamicConfig::class);
		$instanceProp = $reflection->getProperty('instance');
		$instanceProp->setAccessible(true);
		$instanceProp->setValue(null);

		DB::shouldReceive('table')
			->once()
			->with('config')
			->andReturnSelf();

		DB::shouldReceive('pluck')
			->once()
			->with('Value', 'Name')
			->andReturn(collect([
				'test_key' => 'value123',
				'enabled' => 'true',
				'integer' => '42',
				'float' => '3.14',
			]));

		Cache::shouldReceive('missing')
			->once()
			->with('explosion_config')
			->andReturn(true);

		Cache::shouldReceive('forever')
			->once()
			->with('explosion_config', Mockery::type(Collection::class));

		Cache::shouldReceive('get')
			->andReturn(collect([
				'test_key' => 'value123',
				'enabled' => 'true',
				'integer' => '42',
				'float' => '3.14',
			]));
	}

	protected function tearDown(): void {
		Mockery::close();
		parent::tearDown();
	}

	public function testCanRetrieveConfigString() {
		$value = DynamicConfig::get('test_key');
		$this->assertSame('value123', $value);
	}

	public function testBooleanCast() {
		$this->assertTrue(DynamicConfig::getBoolean('enabled'));
	}

	public function testIntegerCast() {
		$this->assertSame(42, DynamicConfig::getInt('integer'));
	}

	public function testFloatCast() {
		$this->assertSame(3.14, DynamicConfig::getFloat('float'));
	}

}
