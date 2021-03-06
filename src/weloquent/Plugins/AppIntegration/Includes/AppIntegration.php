<?php namespace Weloquent\Plugins\AppIntegration\Includes;

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the dashboard.
 *
 * @since      1.0.0
 *
 * @package    AppIntegration
 * @subpackage AppIntegration/includes
 */
use Brain\Cortex;
use Weloquent\Core\Application;
use Weloquent\Plugins\AppIntegration\Admin\AppIntegrationAdmin;
use Weloquent\Plugins\AppIntegration\Front\AppIntegrationPublic;
use Illuminate\Support\Facades\App;

/**
 * The core plugin class.
 *
 * This is used to define internationalization, dashboard-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    AppIntegration
 * @subpackage AppIntegration/includes
 * @author     Your Name <email@example.com>
 */
class AppIntegration
{

	protected static $instance;
	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      AppIntegrationLoader $loader Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $plugin_name The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string $version The current version of the plugin.
	 */
	protected $version;
	/**
	 * @var Application
	 */
	private $app;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the Dashboard and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 * @param Application $app
	 */
	public function __construct(Application $app)
	{
		$this->plugin_name = 'weloquent';
		$this->version     = '1.0.0';
		$this->app         = $app;

		$this->loadDependencies();
		$this->setLocale();

		if (is_admin())
		{
			$this->defineAdminHooks();
		}
		else
		{
			$this->definePublicHooks();
		}

	}

	public static function getInstance()
	{
		if (!self::$instance)
		{
			self::$instance = new static(App::getFacadeApplication());
		}

		return self::$instance;
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - AppIntegrationLoader. Orchestrates the hooks of the plugin.
	 * - AppIntegrationI18n. Defines internationalization functionality.
	 * - AppIntegrationAdmin. Defines all hooks for the dashboard.
	 * - AppIntegrationPublic. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function loadDependencies()
	{
		$this->loader = new AppIntegrationLoader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the AppIntegration_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function setLocale()
	{

		$plugin_i18n = new AppIntegrationI18n();
		$plugin_i18n->set_domain($this->get_plugin_name());

		$this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');

	}

	/**
	 * Register all of the hooks related to the dashboard functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function defineAdminHooks()
	{

		$plugin_admin = new AppIntegrationAdmin($this->get_plugin_name(), $this->get_version());

		//		$this->loader->add_action('action rook name', $plugin_admin, 'methodCalledName');

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function definePublicHooks()
	{

		$plugin_public = new AppIntegrationPublic($this->get_plugin_name(), $this->get_version());
		//		$this->loader->add_action('action rook name', $plugin_public, 'methodCalledName');

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run()
	{
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name()
	{
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    AppIntegrationLoader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader()
	{
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version()
	{
		return $this->version;
	}

}
