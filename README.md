# Magento 2 Code Generator Tool

[![License](https://img.shields.io/packagist/l/staempfli/magento2-code-generator.svg)](https://packagist.org/packages/staempfli/magento2-code-generator)
[![Version](https://img.shields.io/packagist/vpre/staempfli/magento2-code-generator.svg)](https://packagist.org/packages/staempfli/magento2-code-generator)
[![Code Climate](https://img.shields.io/codeclimate/github/staempfli/magento2-code-generator.svg)](https://codeclimate.com/github/staempfli/magento2-module-spreadsheet/)
[![Total Downloads](https://img.shields.io/github/downloads/staempfli/magento2-code-generator/total.svg)](https://packagist.org/packages/staempfli/magento2-code-generator)

## Installation

### Option1: Downloading .phar

```
wget https://github.com/staempfli/magento2-code-generator/releases/download/<version>/mg2-codegen.phar
chmod +x ./mg2-codegen.phar
# use the command globally on your system
sudo mv ./mg2-codegen.phar /usr/local/bin/mg2-codegen
```

### Option2: Using Composer

Install globally on your system with the following command:

```
composer global require "staempfli/magento2-code-generator"
```

Just make sure you have the composer `bin` dir in your `$PATH`. The default value is `~/.composer/vendor/bin/`

Note: if you have dependency problems with other projects installed globally, we recommend you to use [consolidation/cgr](https://github.com/consolidation/cgr)

## Usage

0. List all templates: `mg2-codegen template:list`

0. Generate template: `mg2-codegen template:generate <template>`

**NOTE**:
    
* `template:generate` command must be executed on the module root folder where the `registration.php` file is.
You can also use option `--root-dir` to specify this path, if you execute it from a different location.

* When creating a new `module`, you must create first the module parent folder and execute the command from there.

## Demo

![Video Demo](docs/img/video-demo.gif)

You can also watch a more detailed video demos on Youtube:

* [Create a CRUD EAV Module in just 5 minutes](https://www.youtube.com/watch?v=f8qBnOIRIs4)
* [Playlist Tutorials](https://www.youtube.com/playlist?list=PLBt8dizedSZCxuqK41vG01_MngJQPRuMj)

## Available Templates

```
Featured
  ajaxHtml
  consoleCommand
  crudEAV
  crudEAVWithFile
  frontController
  requireJs
  logger
  widget

More Templates
  ajaxJson
  ajaxRestApi
  blockHtml
  crud
  crudEAVWithMultipleFiles
  customConfigXml
  customDBConnection
  email
  emailFormRequest
  fileEAVAttribute
  fileEAVMultiple
  fileModel
  fileProcessor
  fotoramaSlider
  language
  model
  module
```

## Create new Templates
    
### Clone and Install Project
 
For that you cannot use the `.phar` binary, so you need to install the project:

* [Clone and Install](docs/clone-install.md)
    
### Contribute with new Templates

* If you want to contribute with new templates, just follow this manual:

    0. [How to create templates](docs/createTemplates.md)
    
### Private Templates

If current templates do not fill your needs, you can easily create your own templates. Just follow the manual:

* [How to create private templates](docs/privateTemplates.md)
    
## Prerequisites

- PHP >= 5.6.*

## Developers

* [Juan Alonso](https://github.com/jalogut)

Licence
-------
* **Software tool:** free software under the terms of [GNU General Public License, version 3 (GPLv3)](http://opensource.org/licenses/gpl-3.0)
* **Generated code:** free to use, copy, modify or distribute under the terms of the [Free Public License 1.0.0](https://opensource.org/licenses/FPL-1.0.0)

Copyright
---------
(c) 2016 Staempfli AG


