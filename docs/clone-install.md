# Clone and Install

0. If you want to create new templates, you cannot use the `.phar` binary, so you need to install the project:

	```
	git clone https://github.com/staempfli/magento2-code-generator.git
	cd magento2-code-generator && composer install
	``` 

0. You can now use the comman in `bin` folder:

	* `bin/mg2-codegen` 

0. If you want to use the command globally on your system:

    `sudo ln -s $(PWD)/magento2-code-generator/bin/mg2-codegen /usr/local/bin/mg2-codegen`  
