# Magento 2 Code Generator Tool

## Installation

* Git clone and composer install
* Optional create symlink to `path_to_mage2-generator.sh` file in your `$PATH`:
    `ln -s $(PWD)/mage2-generator.sh /usr/local/bin/mage2-generator`

### Setup personal config

* cp config/personal.properties.dist config/personal.properties

## Usage

* List all templates: `<path_to_mage2-generator.sh> -l` 

* Generate template: `<path_to_mage2-generator.sh> <template:command>` 

**NOTE**:
    
* This commands mut be executed on the root module folder where the "registration.php" file is. 

* For `module:generate` where this file is not existing, you must create first the module parent folder and execute the command from there.
    
## Contribute

1. New template files on "templates dir" and 
2. Set placeholders:
    * Placeholders have the following format `${param_name}` 
    * Placeholders are possible on files content as well as on folder and file names.
3. Add a new target in `build/xmlscripts/templates/<your_template>.xml` as in this example:

```
    <target name="uigridform:generate"
            description="Generate Magento 2 CRUD UI Grid and Form">

        <phingcall target="generateCode">
            <property name="template" value="uigridform"/>
            <property name="params" value="type,database_field_id"/>
        </phingcall>

    </target>
```

## Built-in Properties

- vendorname -> calculated from registration.php
- modulename -> calculated from registration.php

### Multicase properties

* For all properties a version with Uppercase first and Lowercase first are created. That means that for every property there will 2 created as follows:

    * **v**endorname = **c**ompanyexample
    * **V**endorname = **C**ompanyexample

    * **m**odulename = **e**xamplemodule
    * **M**odulename = **E**xamplemodule

    * **c**ustomparam = **s**omevalue
    * **C**ustomparam = **S**omevalue

* That way only one value needs to be entered that 2 placeholders can be used on the templates.