# How to create new templates

In order to create new templates you just need to do the following.

## Template files

0. Create new folder with your `templateName` into the `templates` folder.
0. Create you template files under your new template.
0. Set your placeholders:
    * Placeholders must have the following format `${param_name}` 
    * Placeholders are possible on files content as well as on folder/file names.

## Template documentation

0. Create a new folder called `.no-copied-config` into you template
0. Add there a description.txt file with a short description that clarifies what the template is for:
	* This description will be show when running `./mg2-codegen.phar template:info <template>`  		 

### OPTIONAL

* If your template requires some manual steps after the code is generated, you can document this info in:
	*  `.no-copied-config/after-generate-info.txt`
	* This info will be displayed at the end of the code generation command. You can also use placeholders on this file.

* If you want that your template executes other templates before, you can set dependencies in:
	* `.no-copied-config/config.yml` 

		```
		dependencies:
		  0: <template-name>
		  1: <template-name>
		```

### Example

You can check a template example here [Template Samples](../samples)

## Important info

### Built-in Properties

Following properties are automatically set:

* `vendorname` -> calculated from registration.php
* `modulename` -> calculated from registration.php
* `CommentsCompanyName` 
* `commentsUserEmail` 
* `commentsYear` 

### Multicase properties

* For all placehoders two versions with `Uppercase first` and `lowercase` are created. That means, that for every praceholder there will be 2 created:

    * **v**endorname = **c**ompanyexample
    * **V**endorname = **C**ompanyexample

    * **m**odulename = **e**xamplemodule
    * **M**odulename = **E**xamplemodule

    * **c**ustomparam = **s**omevalue
    * **C**ustomparam = **S**omevalue

* Thanks to that, the user needs to enter only 1 value but 2 different placeholders can be used on the templates.