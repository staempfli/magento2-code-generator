# Magento 2 Code Generator Tool

## Installation

```
$ git clone https://github.com/staempfli/mage2-code-generator.git
$ cd mage2-code-generator && composer install

# Test that it works
$ bin/mage2-generator
```

### Global installation

* Create symlink to `bin/mage2-generator` on your preferred `$PATH`:
   
    * `$ ln -s $(PWD)/bin/mage2-generator /usr/local/bin/mage2-generator`

### Setup personal config

* `$ cp config/personal.properties.dist config/personal.properties

## Usage

* List all templates: `bin/mage2-generator generator:templates:list` 

* Generate template: `bin/mage2-generator generate` 

**NOTE**:
    
* This commands mut be executed on the root module folder where the `registration.php file is. 

* For generate `module` where this file is not existing, you must create first the module parent folder and execute the command from there.
    
## Contribute

1. Create new template files on `/templates` directory 
2. Set your placeholders:
    * Placeholders have the following format `${param_name}` 
    * Placeholders are possible on files content as well as on folder/file names.

## Built-in Properties

* vendorname -> calculated from registration.php
* modulename -> calculated from registration.php
* comments.company.name
* comments.user.mail

### Multicase properties

* For all properties a version with Uppercase first and Lowercase first are created. That means that for every property there will 2 created as follows:

    * **v**endorname = **c**ompanyexample
    * **V**endorname = **C**ompanyexample

    * **m**odulename = **e**xamplemodule
    * **M**odulename = **E**xamplemodule

    * **c**ustomparam = **s**omevalue
    * **C**ustomparam = **S**omevalue

* That way only one value needs to be entered that 2 placeholders can be used on the templates.