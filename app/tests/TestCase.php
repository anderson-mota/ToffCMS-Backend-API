<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase {

	protected $useDatabase = true;

	public function setUp()
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
	 * Migrate the database
	 */
	private function prepareForTests()
	{
		Artisan::call('migrate');
        $this->seed();
	}

    /**
     * @param bool $error
     * @param string|null $message
     */
    public function assertNotError($error, $message = null){
        $this->assertFalse($error, $message);
        $this->assertResponseOk();
    }
}
