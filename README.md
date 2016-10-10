# Magento 2 Code Generator Tool

## Installation

```
$ git clone https://github.com/staempfli/magento2-code-generator.git
$ cd magento2-code-generator && composer install

# Test that it works
$ bin/mg2-codegen
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

* If you want to contribute with new templates, just do the following:

    0. Fork this project
    0. Create a new template following the manual (./docs/createTemplates.md)[How to create templates]
    
## Troubleshotting:

  [UnexpectedValueException]
  creating archive "/Volumes/workspace/tools/mage2-cg-symfony/mg2-codegen.phar" disabled by the php.ini setting phar.readonly
phar.readonly = off
