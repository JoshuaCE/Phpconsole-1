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

		// Set backtrace depth to 2 by default so we get the file and line
		// where the user called the test. The reason why we're starting at 2
		// is because Laravel will first call the Facade.
		$this->phpconsole->set_backtrace_depth(2);

		// Get the current host.
		$host = $this->request->getHost();

		// Strip optional 'www'.
		$host = preg_replace('#^www.?#', '', $host);

		// Set domain for Phpconsole.
		// Note: this currently doesn't strips subdomains. This could give
		// problems while trying to set cookies for user identifications.
		$this->phpconsole->set_domain('.' . $host);

		// Load the users from the config file.
		$this->loadUsers();
	}

	/**
	 * Add a user to the Phpconsole object.
	 *
	 * @param string $nickname
	 * @param string $user_key
	 * @param string $project_key
     * @return void
	 */
	public function addUser($nickname, $user_key, $project_key)
	{
		$this->phpconsole->add_user($nickname, $user_key, $project_key);
	}

	/**
	 * Loads the users from the package configuration.
	 *
     * @return void
	 */
	public function loadUsers()
	{
		// Get the users from the package configuration file.
		$users = $this->config->get('phpconsole::users');

		// Check to see if there are users set.
		if (is_array($users) && !empty($users))
		{
			// Itterate over each user and add them to the Phpconsole object.
			foreach ($users as $user)
			{
				// Only add the user if all the correct array keys have been set.
				if (
					array_key_exists('nickname', $user) &&
					array_key_exists('user_key', $user) &&
					array_key_exists('project_key', $user)
				)
				{
					$this->addUser($user['nickname'], $user['user_key'], $user['nickname']);
				}
			}
		}
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