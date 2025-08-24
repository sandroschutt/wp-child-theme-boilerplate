<div align="center">
  <img src="https://github.com/sandroschutt/wp-child-theme-boilerplate/blob/main/assets/images/wp-child-theme-boilerplate-github.webp"/>
</div>

<div align="center">

![OOP](https://img.shields.io/badge/OOP-Object--Oriented%20Programming-blue) <br/>
![WordPress](https://img.shields.io/badge/WordPress-21759B?style=for-the-badge&logo=wordpress&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white) <br>
![Node.js](https://img.shields.io/badge/Node.js-339933?style=for-the-badge&logo=node.js&logoColor=white)
![Gulp](https://img.shields.io/badge/Gulp-CF4647?style=for-the-badge&logo=gulp&logoColor=white)

</div>

## Release notes:

- Title: WordPress Child Theme Boilerplate
- Author: Sandro Schutt
- Author URI: https://github.com/sandroschutt/
- URL: https://github.com/sandroschutt/wp-child-theme-boilerplate/
- Version: 1.9

### Changelog:
 - Moved autoload.php to root folder in order to make namespaces to work inside the theme scope;
 - Removed AdminSettings, PublicSettings and SettingsInterface for cleaner code;
 - Changed the logic in the shortcodes autoinclusion for more precise control over this functionality;
 - Introduced new default classes in a Assets bundle (Styles, Scripts, Shortcodes);
- Introduced a Helper class to handle folder reading and generic routines;
- Added annotations to all functions for better code reading;
- Simplified functions.php;
- Added regular dependencies to the theme in favor of dev dependencies;

### New features:
- Dynamic styles and scripts enqueueing (global);
- Dynamic styles and scripts enqueueing (pages);
- Dynamic shortcode creation;
- JS and CSS minification;

<br/><br/>
<p align="center"><i>Setup a WordPress Child Theme in no time!</i></p>

<p align="center" style="text-align: center"><i>With WPCTB you have a solid base that let you focus on extending your website style and features rahter than structure.</i></p>
<br/><br/>

## Overview

WPCTB is aimed to developers who are tired of setting up child themes over and over. It is based on the WordPress Plugin Boilerplate (WPPB), which help developers adopt a standard while building plugins.

This boileplate lend some of WPPB ideas and bring them to child themes, making them easy to install and configure. It does so by organizing action and filter hooks, leaving function declaration and logic separate from the hook calls.

With the built in autoloader, you can leverage namespaces and OOP without having to install Composer, making your code cleaner and easy to manage.

Another feature to make WP work more straightforward is the auto inclusion of styles and scripts. As longs as your scripts are loaded in the **/build/** folder, there is nothing else you have to do other than write your own JS and CSS. <a href="#autoloading-scripts">Check this section for more details on how to usee this feature</a>

Setup your code and get to work!
<br/><br/>

#### Tested with:

- PHP: 8.1.2
- WordPress: 6.7.1
- Themes: Classic, Gutenberg, Elementor, Vamtam
  <br/><br/>

## Installation

Clone this repository into your themes folder.

Open your root WordPress installation folder into a terminal and type:
<br/><br/>

```
cd wp-content/themes && git init && git clone https://github.com/sandroschutt/wp-child-theme-boilerplate.git
```

Or download the .zip file and install it manually from the admin panel.

<br/><br/>
If you downloaded the project to your machine through the direct download button, just move it all into /wp-content/themes.

After that, just activate the theme in the wp-admin->Appearence->Themes.

> [!NOTE]
> This child theme defaults to Twenty Twenty Five as the parent theme. Don't forget to change that info in style.css.

## Usage

### <span id="autoloading-scripts">Enqueing Scripts</span>

Working with WPCTB became easier! Now you dont have to manually enqueue scripts, styles and even shortcodes. All you need to do is create your files in the /src folder and run Gulp to compile and minify them all at once. Here is how you do that:

Open a terminal inside WPCTB's root folder and type:

```
~$ npm install
```

Now create a .js or .scss file inside the /src folder:

#### Example:

```
// /src/js/example.js
document.addEventListener("DOMContentLoaded", () => {
  let greet = "Hello World!";

  if(greet !== null && greet !== "") {
    console.log(greet)
  }
})
```

After the file is created, run Gulp by typing:

```
~$ gulp
```

Gulp will compile and minify all scss and js files inside the /src folder. Now, you should see the example.js file in the /build directory.

```
/build
  /js
    example.js
    example.min.js
```

If you don't want to use the gulp minified files and use a plugin for running that task instead, you'll have to change the extensions from ".min.css" to ".css" in <a href="https://github.com/sandroschutt/wp-child-theme-boilerplate/blob/main/inc/PublicSettings.php">/inc/PublicSettings.php</a>.

The Scripts and Styles classes maps the /build directory, so make sure to create your css files inside that directory or change the mapped directory in the $path variable for each class.

### Adding custom PHP

You can write custom code and use namespaces anywhere inside the boilerplate.

If you want to hook directly into the ThemeSettings class, you will have to use classes. Than you can call an instance of that class or its static methods inside ThemeSettings's constructor. Another route is to just create an instance of that class in functions.php.

For the time being, procedural code still relies in default PHP inclusion. You can use functions.php for that.

#### Example:

Add a test function to Shortocodes.php:
<br/><br/>

```
// Assets/Shortcodes.php

public static function test()
{
  // Test code...
}
```

<br/><br/>
Call it inside ThemeSettings.php
<br/><br/>

```
class ThemeSettings
{
    public function __construct()
    {
        // Default code...
        \WPChild\Assets\Shortcodes::test(); // Will run the method
    }
  
  // Default methods...
}
```

You can also use it inside a action or filter hook using the array param provided by WordPress:

```
public function actionHooks()
{
    // Function hook calls...
    add_action("wp_head", array(\WPChild\Assets\Shortcodes, "test"));
}
```

That will work given you are calling a static method that doesnt require the class instance directly. For non static methods, you should create an instance of the class and call it in the constructor:

```
class ThemeSettings
{
    private $shortcodes;
    
    public function __construct()
    {
        // Default code...
        $this->shortcodes = new \WPChild\Assets\Shortcodes;
        $this->shortcodes->nonStaticMethod();
    }
    
    public function actionHooks()
   {
      // Function hook calls...
      add_action("wp_head", array($this->shortcodes, "nonStaticMethod"));
   }
  
  // Default methods...
}
```
<br/><br/>

If you want to get rid of "requires" and "includes" inside your code, just use the **\WPChild namespace** or change it to whatever name you like.

This boilerplate packs a custom autoloader that will handle all of your php files importing inside the **/inc** folder

<br/><br/>

### Adding shortcodes dynamically
Similar to adding scripts and styles, you can add shortcodes to your theme by just creating a shortcode file inside /lib/shortcodes and that is all. Shortcodes class will handle the rest for you. Just create your file and use the add_shortcode function to register it.

```
<?php
function test_shortcode() {
  ob_start(); ?>
  <p>This is a test shortcode</p>
  <?php return ob_get_clean();
}

add_shortcode('test', 'test_shortcode');
```

Now you just have to use that shortcode in a page or template:

In a page or post, type:

```
[test-shortcode]
```

If you are using Gutenberg, use the Shortcode block and paste the same code. You should see the shortcode message instead of the tag. If not, review the steps and turn on debugging on your wp-config.php file for troubleshooting.


<br>

### More information

- [Project release post](https://sandroschutt.com.br/projects/wordpress-child-theme-setup)
- [Author LinkedIn](https://linkedin.com/in/sandro-schutt)
