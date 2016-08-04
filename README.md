# Magento 2 Code Generator Tool

## Installation

- Git clone and composer install
- Optional create symlink to .sh file in PATH

### Setup personal config

- cp config/personal.properties.dist config/personal.properties

## Usage

- List all templates: <path_to_mage2-generator.sh> -l
- Generate template: <path_to_mage2-generator.sh> <template:command>

- NOTE:
    - This commands mut be executed on the root module folder where the "registration.php" file is. 
    For `module:generate` where this file is not existing, you must create first the module parent folder and execute the command from there.
    
## Contribute

- New template file on "templates dir" and set placeholders
- Add new target as in this example:

```
    <target name="uigridform:generate"
            description="Generate Magento 2 CRUD UI Grid and Form">

        <phingcall target="generateCode">
            <property name="template" value="uigridform"/>
            <property name="params" value="type,database_field_id_name"/>
        </phingcall>

    </target>
```

## Built-in Properties

- vendorname -> calculated from registration.php
- modulename -> calculated from registration

### Multicase properties

- For all properties a version with Uppercase first and Lowercase first are created. That means that for every property there will 2 created as follows:

* **v**endorname = **c**ompanyexample
* **V**endorname = **C**ompanyexample

* **m**odulename = **e**xamplemodule
* **M**odulename = **E**xamplemodule

* **c**ustomparam = **s**omevalue
* **C**ustomparam = **S**omevalue

That way only one value needs to be entered that 2 placeholders can be used on the templates.