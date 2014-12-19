Launch Effect
=======
A viral marketing theme for WordPress empowering designers, marketers, and enthusiasts to build websites with relative ease.

You can view the current version information [here](https://github.com/barrel/Launch-Effect/blob/master/readme.txt)

## Deployment

#### Branches

- **Master**: contains the latest release.
- **Develop**: is where you test bug fixes.

#### ToDos
- add changes to [readme.txt](https://github.com/barrel/Launch-Effect/blob/master/readme.txt)
- change version number in [functions.php](https://github.com/barrel/Launch-Effect/blob/master/functions.php)

    ```
    define("LE_VERSION", "X.xx");
    ```

#### To create both the free and premium versions for upload:

```./deploy.sh X.xx```

Run the above in terminal, where ```X.xx``` is the version number *change this value each time*.



<br />

> "Make every detail perfect and limit the number of details to perfect."
>  - Jack Dorsey


<br />



## Compiled Files
The following is a list of compiled files and the files they include. This project uses [Grunt](http://gruntjs.com) to automate build tasks. See below for instructions on how to use it.

### Build Instructions
- Install [Node.js](http://nodejs.org)
- Install grunt-cli: `npm install -g grunt-cli`
- Install dev dependencies: `npm install`
- Run `grunt` to compile, or `grunt server` to start a live gruntment environment.

#### Global
These files apply to both versions, lite &amp; premium.

##### Stylesheets

- ```ss/launch-effect.min.css```
  	- [ss/main.css](https://github.com/barrel/Launch-Effect/blob/grunt/ss/main.css)
- ```ss/launch-effect-responsive.min.css```
  	- [ss/responsive.css](https://github.com/barrel/Launch-Effect/blob/grunt/ss/responsive.css)

##### JavaScript

- ```js/launch-effect.min.js```: this is now loaded in the ***footer***
  	- [js/jqModal.js](https://github.com/barrel/Launch-Effect/blob/grunt/js/jqModal.js)
  	- [js/spin.js](https://github.com/barrel/Launch-Effect/blob/grunt/js/spin.js)
  	- [js/jquery.imagesloaded.js](https://github.com/barrel/Launch-Effect/blob/grunt/js/jquery.imagesloaded.js)
  	- [js/init.js](https://github.com/barrel/Launch-Effect/blob/grunt/js/init.js)


#### Admin
These files are loading for the admin settings panel.

##### Stylesheets

- ```functions/ss/launch-effect-admin.min.css```
  	- [functions/ss/stats.css](https://github.com/barrel/Launch-Effect/blob/grunt/functions/ss/stats.css)
  	- [functions/ss/main.css](https://github.com/barrel/Launch-Effect/blob/grunt/functions/ss/main.css)
  	- [functions/js/jpicker/css/jPicker-1.1.6.css](https://github.com/barrel/Launch-Effect/blob/grunt/functions/js/jpicker/css/jPicker-1.1.6.css) (deprecated)
  	- [functions/js/jqueryui/css/overcast/jquery-ui-1.8.16.custom.css](https://github.com/barrel/Launch-Effect/blob/grunt/functions/js/jqueryui/css/overcast/jquery-ui-1.8.16.custom.css)

##### JavaScript

- ```functions/js/launch-effect-admin.min.js```
  	- [js/jqModal.js](https://github.com/barrel/Launch-Effect/blob/grunt/js/jqModal.js)
  	- [functions/js/jpicker/jpicker-1.1.6.js](https://github.com/barrel/Launch-Effect/blob/grunt/functions/js/jpicker/jpicker-1.1.6.js) (deprecated)
  	- [functions/js/jqueryui/js/jquery-ui-1.8.16.custom.min.js](https://github.com/barrel/Launch-Effect/blob/grunt/functions/js/jqueryui/js/jquery-ui-1.8.16.custom.min.js) (deprecated)
  	- [functions/js/jquery.scrollTo-min.js](https://github.com/barrel/Launch-Effect/blob/grunt/functions/js/jquery.scrollTo-min.js)
 	- [functions/js/init.js](https://github.com/barrel/Launch-Effect/blob/grunt/functions/js/init.js)


#### Premium
These files are loading for the premium version.

##### Stylesheets

- ```premium/ss/launch-effect-premium.min.css```
  	- [premium/ss/main.css](https://github.com/barrel/Launch-Effect/blob/grunt/premium/ss/main.css)
  	- [premium/js/fancybox/jquery.fancybox-1.3.4.css](https://github.com/barrel/Launch-Effect/blob/grunt/premium/js/fancybox/jquery.fancybox-1.3.4.css)


##### JavaScript

- ```premium/js/launch-effect-premium.min.js```: this is now loaded in the ***footer***
  	- [premium/js/jquery.countdown.js](https://github.com/barrel/Launch-Effect/blob/grunt/premium/js/jquery.countdown.js)
  	- [premium/js/fancybox/jquery.fancybox-1.3.4.js](https://github.com/barrel/Launch-Effect/blob/grunt/premium/js/fancybox/jquery.fancybox-1.3.4.js)
  	- [premium/js/init.js](https://github.com/barrel/Launch-Effect/blob/grunt/premium/js/init.js)

#### Other
The slideshow background js is now compiled with [js/init.js](https://github.com/barrel/Launch-Effect/blob/grunt/js/init.js) into ```js/launch-effect.min.js```. The variables for the speed and duration are passed as javascript variables before ```wp_footer();``` is called. 


