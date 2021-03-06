<?php namespace Prologue\Phpconsole;

use Illuminate\Support\ServiceProvider;

class PhpconsoleServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('prologue/phpconsole');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['phpconsole'] = $this->app->share(function($app)
		{
			return new Console($app['request'], $app['config']);
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('phpconsole');
	}

}