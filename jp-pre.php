<?php
/**
 * WordPress customizer CSS color pre-processor.
 *
 * Based on my tuts+ http://code.tutsplus.com/tutorials/creating-a-mini-css-preprocesser-for-theme-color-options--cms-21551
 *
 * @package   @jp_pre
 * @author    Josh Pollock <Josh@JoshPress.net>
 * @license   GPL-2.0+
 * @link
 * @copyright 2014 Josh Pollock
 */

/**
 * The key for caching.
 *
 * @since 0.1.0
 */
if ( ! defined( 'JP_PRE_TRANSIENT_KEY' ) ) {
	define( 'JP_PRE_TRANSIENT_KEY', 'jp_pre_theme_customizer_css' );
}

/**
 * File name for the customizer css
 *
 * @since 0.1.0
 */
if ( ! defined( 'JP_PRE_FILE_NAME' ) ) {
	define( 'JP_PRE_FILE_NAME', 'customizer.css' );

}

/**
 * Whether to output CSS in header or not
 *
 * See readme for using this + wp_add_inline_style() to be more doing it right
 *
 * @since 0.1.0
 */
if ( ! defined( 'JP_PRE_OUTPUT_IN_HEADER') ) {
	define( 'JP_PRE_OUTPUT_IN_HEADER', true );
}

class jp_pre_theme_customizer_output {


    /**
     * An array of theme_mod names as key and default values to use if not set as value.
     *
     * @return array An array of theme_mod => default
	 *
	 * @since 0.1.0
     */
    function theme_mods() {
        return array(
            'site_title_color' => 'ff000',
            'site_description_color'=> '000'
        );

    }

    /**
     * Prepare the colors getting values of theme_mods
     *
     * @return array An array of theme_mod => hex value
	 *
	 * @since 0.1.0
     */
    function prepare_values() {
		//start color false
		$colors = false;
        //get our theme_mods and default values
        $theme_mods = $this->theme_mods();

        //for each theme_mod output the value of the theme_mod or the default
        foreach( $theme_mods as $theme_mod => $default ) {
            $colors[ $theme_mod ] = get_theme_mod( $theme_mod, $default );
        }

		//return if is array
		if ( is_array( $colors ) ) {
			return $colors;
		}

    }

    /**
     * Process and optimize the css.
     *
     * @return string|bool Returns the css as a string or false if file couldn't be loaded.
	 *
	 * @since 0.1.0
     */
    function process() {
		//get file
		$file = $this->path() . JP_PRE_FILE_NAME;

        if ( file_exists( $file ) ) {
            //get contents of the file
            $css = file_get_contents( $file );

            //get our colors
            $colors = $this->prepare_values();

            //replace each color
            foreach ( $colors as $theme_mod => $color ) {
                $search = $search = '['.$color.']';
                $css = str_replace( $search, $color, $css );
            }

            //add style tags
            $css = '<style type="text/css">'.$css;
            $css = $css.'</style>';

            return $css;

        }

    }


	/**
	 * The file path to load customizer.php form
	 *
	 * Defaults to get_stylesheet_directory but can be changed using 'jp_pre_customizer_css_file_path' filter.
	 *
	 * @return string
	 */
	function path() {
		$path = get_stylesheet_directory();

		/**
		 * Change the path to load customizer.css from
		 *
		 * @param string $path The path to load from. Default is get_style_sheet_directory
		 *
		 * @since 0.1.0
		 */

		$path = apply_filters( 'jp_pre_customizer_css_file_path', $path );

		return trailingslashit( $path );

	}



}

/**
 * Output processed CSS from the theme customizer
 *
 * @since 0.1.0
 */
if ( JP_PRE_OUTPUT_IN_HEADER ) {
	add_action( 'wp_head', 'jp_pre_theme_customizer_output' );
}
function jp_pre_theme_customizer_output() {
    //either set $css to the transient or rebuild.
    if ( false === ( $css = get_transient( JP_PRE_TRANSIENT_KEY ) ) ) {
        //make sure class is reachable
        if ( class_exists( 'jp_pre_theme_customizer' ) ) {
            //initialize the class and get processed CSS
            $class = new jp_pre_theme_customizer_output();
            $css = $class->process();

            //cache $css for next time.
            set_transient( JP_PRE_TRANSIENT_KEY, $css );
        }
    }

    //to be safe make sure process() method didn't return false or anything other than a string
    if ( $css && is_string( $css ) ) {
        echo $css;

    }

}

/**
 * Clear the cache $css when the theme mods are updated.
 *
 * @since 0.1.0
 */
$theme = get_stylesheet();
add_action("update_option_theme_mods_{$theme}", array( $this, 'jp_pre_theme_customizer_css_transient' ) );
function jp_pre_reset_theme_customizer_css_transient() {

	delete_transient( JP_PRE_TRANSIENT_KEY );

}
