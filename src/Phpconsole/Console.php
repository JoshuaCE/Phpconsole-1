<?php namespace Phpconsole;

class Console {

	/**
	 * Illuminate application instance.
	 * 
	 * @var Illuminate\Foundation\Application
	 */
	protected $app;

	/**
	 * Phpconsole object.
	 * 
	 * @var Phpconsole\Library\Phpconsole
	 */
	protected $phpconsole;

	/**
	 * Create a new Phpconsole instance.
	 * 
	 * @param  Phpconsole\Library\Phpconsole $app
	 * @return void
	 */
	public function __construct($app)
	{
		$this->app = $app;

		// Create new Phpconsole instance.
		$this->phpconsole = new Phpconsole;

		// Set backtrace depth to 1 by default so we get the file
		// and line where the user called the test.
		$this->phpconsole->set_backtrace_depth(1);

		// Set the domain dynamically through Laravel.
		$host = $this->app['request']->getHost();

		// Strip optional 'www'.
		$host = preg_replace('#^www.?#', '', $host);

		// Set domain for Phpconsole.
		// Note: this currently doesn't strips subdomains. This could give
		// problems while trying to set cookies for user identifications.
		$this->phpconsole->set_domain('.' . $host);
	}

	/**
	 * Send data to phpconsole.com
	 *
	 * @param  mixed  $data
	 * @param  string $user
     * @return mixed
	 */
	public function send($data, $user = false)
	{
		return $this->phpconsole->send($data, $user);
	}

}