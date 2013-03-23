<?php namespace Prologue\Phpconsole;

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
	 * Current backtrace line.
	 * 
	 * @var integer
	 */
	protected $backtrace = 2;

	/**
	 * Create a new Phpconsole instance.
	 * 
	 * @param  Illuminate\Http\Request      $request
	 * @param  Illuminate\Config\Repository $config
	 * @return void
	 */
	public function __construct($request, $config)
	{
		// Set application service providers.
		$this->request = $request;
		$this->config = $config;

		// Create new Phpconsole instance.
		$this->phpconsole = new Phpconsole;

		// Set backtrace depth to 2 by default so we get the file and line
		// where the user called the test. The reason why we're starting at 2
		// is because Laravel will first call the Facade.
		$this->setBacktraceDepth(2);

		// Automatically set the domain when creating the object.
		$this->setDomain();		

		// Load the users from the config file.
		$this->loadUsers();
	}

	/**
	 * Set the domain for the current website.
	 *
	 * @param string $domain
     * @return void
	 */
	public function setDomain($domain = null)
	{
		// If a domain was explicitly set, pass it along to the Phpconsole
		// object. Also make sure to terminate the function.
		if ($domain) {
			return $this->phpconsole->set_domain($domain);
		}

		// If no domain has been provided, automatically set it.
		// First get the current host.
		$host = $this->request->getHost();

		// Strip optional 'www'.
		$host = preg_replace('#^www.?#', '', $host);

		// Set domain for Phpconsole.
		// Note: this currently doesn't strips subdomains. This could give
		// problems while trying to set cookies for user identifications.
		$this->phpconsole->set_domain('.' . $host);
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
	 * Loads the users from the package configuration and
	 * optionally sets a default user.
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
			foreach ($users as $nickname => $keys)
			{
				// Only add the user if all the correct array keys have been set.
				if (
					array_key_exists('user_key', $keys) &&
					array_key_exists('project_key', $keys)
				)
				{
					$this->addUser($nickname, $keys['user_key'], $keys['project_key']);
				}
			}

			// Get the default user from the config file.
			$default = $this->config->get('phpconsole::default');

			// If a default user was set and exists in the users array,
			// register a user cookie for that user.
			if ($default && array_key_exists($default, $users)) {
				$this->setUserCookie($default);
			}
		}
	}

	/**
	 * Send data to a user's project.
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
	 * Increment a counter on a user's project.
	 *
	 * @param  integger $number
	 * @param  string   $user
     * @return void
	 */
	public function count($number = 1, $user = false)
	{
		$this->phpconsole->count($number, $user);
	}

	/**
	 * Sets a user cookie.
	 *
	 * @param  string $name
     * @return void
	 */
	public function setUserCookie($name)
	{
		// Increase the backtrack depth by 1 to
		// get the correct line in phpconsole.com
		$this->phpconsole->set_backtrace_depth(++$this->backtrace);

		$this->phpconsole->set_user_cookie($name);

		// Reset the backtrace.
		$this->phpconsole->set_backtrace_depth(--$this->backtrace);
	}

	/**
	 * Destroys a user cookie.
	 *
	 * @param  string $name
     * @return void
	 */
	public function destroyUserCookie($name)
	{
		// Increase the backtrack depth by 1 to
		// get the correct line in phpconsole.com
		$this->phpconsole->set_backtrace_depth(++$this->backtrace);

		$this->phpconsole->destroy_user_cookie($name);

		// Reset the backtrace.
		$this->phpconsole->set_backtrace_depth(--$this->backtrace);
	}

	/**
	 * Checks if Phpconsole is initialized.
	 *
     * @return boolean
	 */
	public function isInitialized()
	{
		return $this->phpconsole->is_initialized() ? true : false;
	}

	/**
	 * Disables Curl error reporting.
	 *
     * @return void
	 */
	public function disableCurlErrorReporting()
	{
		$this->phpconsole->disable_curl_error_reporting();
	}

	/**
	 * Change the backtrace depth.
	 *
	 * @param  integer $depth
     * @return void
	 */
	public function setBacktraceDepth($depth)
	{
		$this->backtrace = $depth;

		$this->phpconsole->set_backtrace_depth($this->backtrace);
	}

	/**
	 * Set path to SSL certificates.
	 *
	 * @param  string  $path
     * @return void
	 */
	public function setPathToCertification($path)
	{
		$this->phpconsole->set_path_to_cert($path);
	}

}