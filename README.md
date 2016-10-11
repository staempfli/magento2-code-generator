# Magento 2 Code Generator Tool

## Installation

0. Download phar file:

    `wget https://github.com/staempfli/magento2-code-generator/releases/download/<version>/mg2-codegen.phar` 

    * or if you have problems with SSL certificate:

    `curl -O https://github.com/staempfli/magento2-code-generator/releases/download/<version>/mg2-codegen.phar` 

0. Make the .phar file executable:

    `chmod +x ./mg2-codegen.phar` 

0. If you want to use the command globally on your system:

    `sudo cp ./mg2-codegen.phar /usr/local/bin/mg2-codegen` 

## Usage

* List all templates: `./mg2-codegen.phar template:list` 

* Generate template: `./mg2-codegen.phar template:generate <template>` 

**NOTE**:
    
* This commands mut be executed on the root module folder where the `registration.php` file is. 

* When creating a new `module`, you must create first the module parent folder and execute the command from there.
    
## Private Templates

If current templates do not fill your needs, you can easily create your own templates. Just follow the manual:

* [How to create private templates](./docs/privateTemplates.md)
    
## Contribute

* If you want to contribute with new templates, just do the following:

    0. Fork this project
    0. Create a new template following the manual [How to create templates](./docs/createTemplates.md)
    
## Prerequisites

- PHP >= 5.6.*

