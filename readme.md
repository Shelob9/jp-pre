JP PRE
======
A mini CSS preprocesser for easier output of color values set in the theme customizer. Based on [an article I wrote for Tuts+](http://code.tutsplus.com/tutorials/creating-a-mini-css-preprocesser-for-theme-color-options--cms-21551).

### Usage
Add this file to your theme/ child theme preferably as a composer dependency or a Git submodule or if you must, copypasta. Include jp-pre.php and instantiate the class, sometime after 'after_theme_setup'. For example, if you added it to the root of the theme, add to functions.php

```php

add_action( 'init', 'slug_jp_pre' );
function slug_jp_pre() {
    include( dirname( __FILE__) . '/jp-pre/jp-pre.php' );
    new jp_pre_theme_customizer_output();
}

```

Add a theme support for jp-pre, with an argument for 'style-handle' equal to the handle you used to enqueue your main styleshseet. For example, in functions.php you could do:

```php

function slug_theme_setup() {
	add_theme_support( 'jp-pre', array( 'style-handle' => 'slug-style' ) );
	}
}
add_action( 'after_setup_theme', 'slug_theme_setup' );

```

Add a file to the root level of your theme/ child theme called customizer.css (or whatever you define in `JP_PRE_FILE_NAME`). In that file write CSS using the names of theme mods in brackets in place of the values. For example:
```css

h1.post-title {
    color: [post_title_color];
}

```

### FAQ
#### How Can I Change The Name And/Or Location Of Customizer.css?
You can set the name by defining `JP_PRE_FILE_NAME` in wp-config.

You can change the path its loaded from using the filter 'jp_pre_customizer_css_file_path'

#### Can I Use This For Other Values Besides Color Values?
Probably. But, at some point it's going to make more sense to use a full PHP implementation of SASS or LESS. At that point, you should be asking yourself important questions re: bloat, options overload and your inability to make design decisions.

#### What If I'm Using Options Instead Of Theme Mods
You're doing it wrong.


