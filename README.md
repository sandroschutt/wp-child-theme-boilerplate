<div align="center">
  <img src="https://github.com/sandroschutt/wp-child-theme-boilerplate/blob/main/assets/images/wp-child-theme-boilerplate-github.webp"/>
</div>

<div align="center">
  
![WordPress](https://img.shields.io/badge/WordPress-21759B?style=for-the-badge&logo=wordpress&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white) <br>
![OOP](https://img.shields.io/badge/OOP-Object--Oriented%20Programming-blue)


</div>

<p align="center"><i>Setup a WordPress Child Theme in no time!</i></p>

<p align="center" style="text-align: center"><i>With WPCTB you have a solid base structure to focus on extending your website style and features rahter than structure.</i></p>
<br/><br/>

## Overview
WPCTB is aimed to developers who are tired of setting up child themes over and over. The boilerplate template is based on the WordPress Plugin Boilerplate (WPPB), which help developers to adopt a standard while developing plugins.

This boileplate lend some of WPPB ideas and bring them to child themes, making them easy to install and configure. It does so by organizing a standard for using action and filter hooks inside a child theme, leaving function declaration and logic separate from the hook calls.

The main ideia is:
- PublicSettings: handles all frontend custom code;
- AdminSettungs: handles all admin panel custom code;
- ThemeSettings.php: handles action and filter hooks, custom functions calls and methods.

You can also leverage namespaces with the built-in autoloader!

Setup your code and get to work!
<br/><br/>

## Release notes:
- Title: WordPress Child Theme Boilerplate
- Author: Sandro Schutt
- Author URI: https://sandroschutt.com.br/about
- URL: https://github.com/sandroschutt/wp-child-theme-boilerplate/
- Version: 1.0.0

#### Tested with:
- PHP: 8.2
- WordPress: 6.6
- Themes: classic, Gutenberg, Elementor, Vamtam
<br/><br/>

## Installation
Clone or download this repository into your themes folder.

Open your root WordPress installation folder into a terminal and type:
<br/><br/>
```
cd wp-content/themes && git clone https://github.com/sandroschutt/wp-theme-setup.git
```
<br/><br/>
If you downloaded the project to your machine through the direct download button, just move it all into the themes folder located in /wp-content.

After that, just activate the theme in the wp-admin Appearence->Themes page.

> [!NOTE]
> This child theme defaults to Twenty Twenty Four as the parent theme. Don't forget to change that info in the style.css file in the root folder.

## Usage
Load your custom frontend scripts, styles and PHP in the /includes/PublicSettings.php file.

Load your custom backend (admin) scripts, styles and PHP in the /includes/AdminSettings.php file.

The boilerplate relies on OOP, so every function you add to any of the mentioned files should be called inside the /include/ThemeSettings.php file.

#### Example:
Add a test function to PublicSettings.php:
<br/><br/>
```
// includes/PublicSettings.php

function is_front_page()
{
  if(is_front_page()) {
    echo "Indeed, it is the front page.";
  }
}
```
<br/><br/>
Call it inside ThemeSettings.php
<br/><br/>
```
    public function action_hooks() {
        /**
        /* Function hook calls...
        */

        $this->public->is_front_page();
    }
```
<br/><br/>

If you want to get rid of "requires" and "includes" inside your code, just use the **\WPChildThemeBoilerplate namespace** or change it to whatever name you like.

This boilerplate packs a custom autoloader that will handle all of your php files importing inside the **includes** folder

### More information
 - [Project release post](https://sandroschutt.com.br/projects/wordpress-child-theme-setup)
 - [Author LinkedIn](https://linkedin.com/in/sandro-schutt)

<br/><br/>
### Tutorials
- Soon
