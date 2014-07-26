<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase {

	protected $useDatabase = true;

	/**
	 *
	 */
	public function     setUp()
	{
		parent::setUp();

		if($this->useDatabase)
		{
			$this->prepareForTests();
		}
	}

	/**
	 * Creates the application.
	 *
	 * @return \Symfony\Component\HttpKernel\HttpKernelInterface
	 */
	public function createApplication()
	{
		$unitTesting = true;
		$testEnvironment = 'testing';

		return require __DIR__.'/../../bootstrap/start.php';
	}

	/**
	 *
	 */
	public function prepareForTests()
	{
		Artisan::call('migrate');
		Artisan::call('db:seed');
	}

	public function setUpDb()
	{
		DB::statement('create database cms_api_tests;');
	}

	/**
	 *
	 */
	public function tearDownDb()
	{
		DB::statement('drop database cms_api_tests;');
	}

}
