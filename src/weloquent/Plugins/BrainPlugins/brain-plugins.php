<?php
/**
 * Plugin Name: Cortex Plugin
 * Plugin URI: http://giuseppe-mazzapica.github.io/Cortex/
 * Description: Cortex implements a routing system in WordPress.
 * Version: 0.1.0
 * Author: Giuseppe Mazzapica
 * Requires at least: 3.9
 * Tested up to: 3.9.1
 *
 */
if (!defined('ABSPATH'))
{
	exit();
}

$vendor = str_replace(DS.'src', '', SRC_PATH);

add_action('brain_init', function ($brain) use ($vendor)
{

    // request
	if (file_exists($vendor . '/vendor/brain/amygdala/src/BrainModule.php'))
	{
		$brain->addModule(new Brain\Amygdala\BrainModule);
	}

    // hooks
	if (file_exists($vendor . '/vendor/brain/striatum/src/BrainModule.php'))
	{
		$brain->addModule(new Brain\Striatum\BrainModule);
	}

    // route
	if (file_exists($vendor . '/vendor/brain/cortex/src/BrainModule.php'))
	{
		$brain->addModule(new Brain\Cortex\BrainModule);
	}

    // assets
	if (file_exists($vendor . '/vendor/brain/occipital/src/BrainModule.php'))
	{
		$brain->addModule(new Brain\Occipital\BrainModule);
	}

});

add_action('setup_theme', function ()
{
	Brain\Container::boot(new \Pimple\Container);
}, 0);