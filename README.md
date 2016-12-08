[![Latest Stable Version](https://poser.pugx.org/pmvc-plugin/view/v/stable)](https://packagist.org/packages/pmvc-plugin/view) 
[![Latest Unstable Version](https://poser.pugx.org/pmvc-plugin/view/v/unstable)](https://packagist.org/packages/pmvc-plugin/view) 
[![Build Status](https://travis-ci.org/pmvc-plugin/view.svg?branch=master)](https://travis-ci.org/pmvc-plugin/view)
[![License](https://poser.pugx.org/pmvc-plugin/view/license)](https://packagist.org/packages/pmvc-plugin/view)
[![Total Downloads](https://poser.pugx.org/pmvc-plugin/view/downloads)](https://packagist.org/packages/pmvc-plugin/view) 

PMVC View template 
===

## Explain Template variable
   * 1. Begin
      * App assign params to template variable by logic
   * 2. Before process view
      * If plug view_config_helper
         * 1. get configs from .env.view
         * 2. merge global option 'VIEW' with configs
         * 3. merge global option 'I18N' with configs['I18N']
         * 4. if have view_config_helper callback will cook $config by callback
         * 5. Set all above configs to template variable.
   * 3. Running view process
      * View engine will extra specific tpl config to plugin config
      * Specific keys such as 'assetsRoot' will copy to template variable which the variable not exists in template variable.
   


## Install with Composer
### 1. Download composer
   * mkdir test_folder
   * curl -sS https://getcomposer.org/installer | php

### 2. Edit composer file
   * vim composer.json
```
{
    "require": {
        "pmvc-plugin/view": "dev-master"
    }
}
```
