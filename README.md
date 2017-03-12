# Magento 2 Code Generator Tool

## Installation

### Option1: Downloading .phar

```
wget https://github.com/staempfli/magento2-code-generator/releases/download/<version>/mg2-codegen.phar
chmod +x ./mg2-codegen.phar
# use the command globally on your system
sudo mv ./mg2-codegen.phar /usr/local/bin/mg2-codegen
```

### Option2: Using Composer

```
composer require "staempfli/magento2-code-generator":"~1.0"
```


## Usage

0. List all templates: `mg2-codegen template:list`

0. Generate template: `mg2-codegen template:generate <template>`

**NOTE**:
    
* `template:generate` command must be executed on the module root folder where the `registration.php` file is.
You can also use option `--root-dir` to specify this path, if you execute it from a different location.

* When creating a new `module`, you must create first the module parent folder and execute the command from there.

## Demo

![Video Demo](docs/img/video-demo.gif)

You can also watch a more detailed video demos in youtube:

* [Create a CRUD EAV Module in just 5 minutes](https://www.youtube.com/watch?v=f8qBnOIRIs4)
* [Playlist Tutorials](https://www.youtube.com/playlist?list=PLBt8dizedSZCxuqK41vG01_MngJQPRuMj)
    
## Create new Templates
    
### Clone and Install project
 
For that you cannot use the `.phar` binary, so you need to install the project:

* [Clone and Install](docs/clone-install.md)
    
### Contribute with new templates

* If you want to contribute with new templates, just follow this manual:

    0. [How to create templates](docs/createTemplates.md)
    
### Private Templates

If current templates do not fill your needs, you can easily create your own templates. Just follow the manual:

* [How to create private templates](docs/privateTemplates.md)
    
## Prerequisites

- PHP >= 5.6.*

