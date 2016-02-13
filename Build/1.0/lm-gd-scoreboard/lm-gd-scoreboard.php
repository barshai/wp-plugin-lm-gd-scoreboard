<?php

/*
Plugin Name: LeagueManager GameDay Scoreboard widget
Plugin URI: http://www.brcode.co.il
Description: LeagueManager scoreboard widget for GameDay theme
Version: 1.0
Author: Bar Shai
Author URI: http://www.brcode.co.il
License: GPL3
*/

class Lm_Gd_Scoreboard
{
	/**
	 * Lm_Gd_Scoreboard constructor.
	 * construct plugin's class
	 */
	public function __construct() {
		add_action( 'plugins_loaded', array( $this, 'load_text_domain' ) );

		/* Check if new theme meets plugins requirements */
		add_action( 'switch_theme', array( 'Lm_Gd_Scoreboard', 'activate' ) );

		add_action( 'widgets_init', array( $this, 'register_widget' ) );
	}

	/**
	 * This function run at plugin's activation.
	 * checks if gameday theme is active, and LeagueManager plugin is active
	 */
	static function activate() {
		$current_theme = wp_get_theme();

		if ( !is_plugin_active('leaguemanager/leaguemanager.php') || !( $current_theme->get('Name') == 'Gameday' || $current_theme->get_template() == 'gameday' ) )
		{
			add_action( 'admin_notices', array( 'Lm_Gd_Scoreboard', 'force_deactivate_message' ) );
			deactivate_plugins( plugin_basename( __FILE__ ) );
			$error_message = '';

			if ( !is_plugin_active('leaguemanager/leaguemanager.php') )
			{
				$error_message .= __( "LeagueManager plugin isn't active or installed, ", "lm_gd_scoreboard_widget" );
			}

			if ( !( $current_theme->get('Name') == 'Gameday' || $current_theme->get_template() == 'gameday' ) )
			{
				$error_message .= __( "Gameday or child theme of Gameday isn't your active theme, ", "lm_gd_scoreboard_widget" );
			}

			$error_message .= __( "therefore LeagueManager scoreboard widget for Gameday can't be activate.", "lm_gd_scoreboard_widget" );
			wp_die( $error_message );
		}
	}

	/**
	 * Echo dashboard notice with details about missed widget requirements.
	 */
	static function force_deactivate_message() {
		$current_theme = wp_get_theme();
		$error_message = '';

		if ( !is_plugin_active('leaguemanager/leaguemanager.php') )
		{
			$error_message .= __( "LeagueManager plugin isn't active or installed, ", "lm_gd_scoreboard_widget" );
		}

		if ( !( $current_theme->get('Name') == 'Gameday' || $current_theme->get_template() == 'gameday' ) )
		{
			$error_message .= __( "Gameday or child theme of Gameday isn't your active theme, ", "lm_gd_scoreboard_widget" );
		}

		$error_message .= __( "therefore LeagueManager scoreboard widget for Gameday can't be activate.", "lm_gd_scoreboard_widget" );
		?>
		<div class="error">
			<p><?php echo $error_message; ?></p>
		</div>
		<?php
	}

	/**
	 * Register new scoreboard widget
	 */
	public function register_widget() {
		/* Loads our widget class file */
		require_once( 'class-lm-gd-scoreboard-widget.php' );

		register_widget( 'Lm_Gd_Scoreboard_Widget' );
	}

	/**
	 * Loads plugin's text domain for localization
	 */
	public function load_text_domain() {
		load_plugin_textdomain( 'lm_gd_scoreboard_widget', false, plugin_basename( dirname( __FILE__ ) ) . '/languages');
	}
}

/* Checks if current wordpress installation meets plugins requirements */
register_activation_hook( __FILE__, array( 'Lm_Gd_Scoreboard' , 'activate' ) );

/* Checks if LeagueManager plugin deactivated */
register_deactivation_hook( ABSPATH . 'wp-content/plugins/leaguemanager/leaguemanager.php', array( 'Lm_Gd_Scoreboard', 'activate' ) );

$lm_gd_scoreboard_plugin = new Lm_Gd_Scoreboard();