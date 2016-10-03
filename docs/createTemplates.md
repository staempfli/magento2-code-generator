# How to create new templates

0. description.txt
0. template files
0. [config.yml]
0. [afterGenerate.txt]


1. Create new template files on `/templates` directory 
2. Set your placeholders:
    * Placeholders have the following format `${param_name}` 
    * Placeholders are possible on files content as well as on folder/file names.

## Important info


### Built-in Properties

* vendorname -> calculated from registration.php
* modulename -> calculated from registration.php
* CommentsCompanyName
* commentsUserEmail

### Multicase properties

* For all properties a version with Uppercase first and Lowercase first are created. That means that for every property there will 2 created as follows:

    * **v**endorname = **c**ompanyexample
    * **V**endorname = **C**ompanyexample

    * **m**odulename = **e**xamplemodule
    * **M**odulename = **E**xamplemodule

    * **c**ustomparam = **s**omevalue
    * **C**ustomparam = **S**omevalue

* That way only one value needs to be entered that 2 placeholders can be used on the templates.