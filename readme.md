JP PRE
======
A mini CSS preprocesser for easier output of color values set in the theme customizer. Based on [an article I wrote for Tuts+](http://code.tutsplus.com/tutorials/creating-a-mini-css-preprocesser-for-theme-color-options--cms-21551).

### Usage
Add this file to your theme/ child theme and include it from functions.php preferably as a composer dependency or a Git submodule or if you must, copypasta.

Add a file to the root level of your theme/ child theme called customizer.css (or whatever you define in `JP_PRE_FILE_NAME`). In that file write CSS using the names of theme mods in brackets in place of the values. For example:
```css
h1.post-title {
    color: [post_title_color];
}
```

### FAQ
#### Why Are You Using wp_head for output not wp_add_inline_style()?
You're right wp_add_inline_style() is so much more doing it right. I'm not for two reasons:
* I don't know what the handle you used when you added your theme's css.
* You can use that same function with wp_add_inline_style()

#### How Can I Use wp_add_inline_style()?
You must follow these two easy steps:
* Define `JP_PRE_OUTPUT_IN_HEADER` false in wp-config.
* In a function hooked to wp_enqueue_scripts, after you've enqueued your main style sheet, do something like this:

`wp_add_inline_style( 'handle-for-your-stylesheet', jp_pre_theme_customizer_output() );`

#### How Can I Change The Name And/Or Location Of Customizer.css
You can set the name by defining `JP_PRE_FILE_NAME` in wp-config.

You can change the path its loaded from using the filter 'jp_pre_customizer_css_file_path'

#### Can I Use This For Other Values Besides Color Values
Probably. But, at some point it's going to make more sense to use a full PHP implementation of SASS or LESS. At that point, you should be asking yourself important questions re: bloat, options overload and your inability to make design decisions.

#### What If I'm Using Options Instead Of Theme Mods
You're doing it wrong.


