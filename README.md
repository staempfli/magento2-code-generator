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

* List all templates: `bin/mage2-generator -l` 

* Generate template: `bin/mage2-generator <template:command>` 

**NOTE**:
    
* This commands mut be executed on the root module folder where the `registration.php file is. 

* For `module:generate` where this file is not existing, you must create first the module parent folder and execute the command from there.
    
## Contribute

1. Create new template files on `/templates` directory 
2. Set your placeholders:
    * Placeholders have the following format `${param_name}` 
    * Placeholders are possible on files content as well as on folder/file names.
3. Add a new target in `build/xmlscripts/templates/<your_template>.xml` as in this example:

```
<?xml version="1.0" encoding="UTF-8"?>

<project name="<your_template>" basedir="../../..">

    <target name="<your_template>:generate"
            description="<description>">

        <phingcall target="generateCode">
            <property name="template" value="<your_template_parent_folder_name>"/>
            <property name="params" value="<coma_separated_placeholder_params"/>
        </phingcall>

    </target>

</project>
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