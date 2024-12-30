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
- Author URI: https://sandroschutt.com.br/about
- URL: https://github.com/sandroschutt/wp-child-theme-boilerplate/
- Version: 1.1.0

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

The main ideia is:

- PublicSettings: handles all frontend custom code;
- AdminSettings: handles all admin panel custom code;
- ThemeSettings: handles action and filter hooks;

You can also leverage namespaces with the built-in autoloader!

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
> This child theme defaults to Twenty Twenty Four as the parent theme. Don't forget to change that info in the <a href="https://github.com/sandroschutt/wp-child-theme-boilerplate/blob/main/style.css">style.css</a>.

## Usage

### Enqueing Scripts

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

The enqueueScripts and enqueueStyles functions are mapping the /build directory, so make sure to create your css files inside that directory or change the mapped directory in the $path variable.

### Adding custom PHP

You can write custom code and use namespaces anywhere inside the /inc folder. Keep in mind that all public facing code should be handled by the PublicSettings class, while any admin panel facing code should pass through AdminSettings.

For your code to take effect, you must create or call your code inside these two classes and call them in the constructor (if no hook is necessary) or in the ThemeSettings class, passing a class method as a callback for the hook.

The boilerplate relies on OOP, so every function you add to any of the mentioned files should be called inside the /inc/ThemeSettings.php file.

#### Example:

Add a test function to PublicSettings.php:
<br/><br/>

```
// includes/PublicSettings.php

function testBoilerplate()
{
  echo "<p>WordPress Child Theme Boilerplate is up and running!</p>";
}
```

<br/><br/>
Call it inside ThemeSettings.php
<br/><br/>

```
class ThemeSettings
{
    private $public;
    private $admin;

    public function __construct()
    {
        // Default attributes...
        $this->public->testBoilerplate();
    }
  
  // Default methods...
}
```

#### Or:

```
public function actionHooks()
{
        // Function hook calls...
        add_action("wp_init", array($this->public, "testBoilerplate"));
}
```

<br/><br/>

If you want to get rid of "requires" and "includes" inside your code, just use the **\WPChildThemeBoilerplate namespace** or change it to whatever name you like.

This boilerplate packs a custom autoloader that will handle all of your php files importing inside the **/inc** folder

<br/><br/>

### Adding shortcodes dynamically
Similar to adding scripts and styles, you can add shortcodes to your theme by just creating a shortcode file inside /lib/shortcodes. PublicSettings class will use the themeShortcodes method to scan the directory and add all shortcodes found in the folder.

The only rule here is using **( - )** to separete words in your filename. Camelcase and lowercase will also work, but underscores **( _ )** won't. Still, you have to use underscores or camelcase when declaring callbacks.

### Example:

Create a file called test-shortcode.php inside **/lib/shortcodes**. Paste the following code to your file:

```
<?php
function test_shortcode() {
  ob_start(); ?>
  <p>This is a test shortcode</p>
  <?php return ob_get_clean();
}
```

Now you just have to use that shortcode in a page or template:

In a page or post, type:

```
[test-shortcode]
```

If you are using Gutenberg, use the Shortcode block and paste the same code. You should see the shortcode message instead of the tag. If not, review the steps and turn on debugging on your wp-config.php file for troubleshooting.

<br/><br/>

### More information

- [Project release post](https://sandroschutt.com.br/projects/wordpress-child-theme-setup)
- [Author LinkedIn](https://linkedin.com/in/sandro-schutt)

<br/><br/>

### Tutorials

- Soon
