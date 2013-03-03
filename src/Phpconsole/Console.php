<?php namespace Phpconsole;

class Console {

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
	public function __construct()
	{
		$this->phpconsole = new Phpconsole;
		$this->phpconsole->set_backtrace_depth(1);
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