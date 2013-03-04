<?php namespace Phpconsole;

class Console {

	/**
	 * Illuminate request interface.
	 * 
	 * @var Illuminate\Http\Request
	 */
	protected $request;

	/**
	 * Illuminate config repository.
	 * 
	 * @var Illuminate\Config\Repository
	 */
	protected $config;

	/**
	 * Phpconsole object.
	 * 
	 * @var Phpconsole\Library\Phpconsole
	 */
	protected $phpconsole;

	/**
	 * Create a new Phpconsole instance.
	 * 
	 * @param  Illuminate\Http\Request      $request
	 * @param  Illuminate\Config\Repository $config
	 * @return void
	 */
	public function __construct($request, $config)
	{
		$this->request = $request;
		$this->config = $config;

		// Create new Phpconsole instance.
		$this->phpconsole = new Phpconsole;

		// Set backtrace depth to 1 by default so we get the file
		// and line where the user called the test.
		$this->phpconsole->set_backtrace_depth(1);

		// Get the current host.
		$host = $this->request->getHost();

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

	/**
	 * Change the backtrace depth.
	 *
	 * @param  integer $depth
     * @return void
	 */
	public function setBacktraceDepth($depth)
	{
		$this->phpconsole->set_backtrace_depth($depth);
	}

}