[![Latest Stable Version](https://poser.pugx.org/pmvc-plugin/view/v/stable)](https://packagist.org/packages/pmvc-plugin/view) 
[![Latest Unstable Version](https://poser.pugx.org/pmvc-plugin/view/v/unstable)](https://packagist.org/packages/pmvc-plugin/view) 
[![CircleCI](https://circleci.com/gh/pmvc-plugin/view/tree/master.svg?style=svg)](https://circleci.com/gh/pmvc-plugin/view/tree/master)
[![License](https://poser.pugx.org/pmvc-plugin/view/license)](https://packagist.org/packages/pmvc-plugin/view)
[![Total Downloads](https://poser.pugx.org/pmvc-plugin/view/downloads)](https://packagist.org/packages/pmvc-plugin/view) 

PMVC View template 
===

## Explain Template variable
   * 1. Initiate
      * App assign params to template variable by logic
   * 2. Before process view
      * If plug [view_config_helper](https://github.com/pmvc-plugin/view_config_helper). (Why need use view_config_helper)
         * 1. Load global option 'VIEW'.
         * 2. Merge global option 'I18N' with VIEW['I18N']
         * 3. Get configs from .env.view and merge to configs, it's useful when you need develop and overwrite remote configs.
         * 4. If have view_config_helper callback will cook $config by callback
         * 5. Set all above configs to template variable.
   * 3. Running view process
      * View engine will extra specific tpl config to plugin config
      * Specific keys such as 'assetsRoot' will copy from template variable to plugin config, if we have variabe need overwirte plugin config from view_config_helper.

### Explain theme config
__Config location__ : [SiteFolder]/themes/[ThemeName]/config/config.php
* Example: https://github.com/pmvc-theme/hello_react/blob/master/config/config.php
```php
${_INIT_CONFIG}=[
  'backend' => [], // will append with view plugin and use in backend.
  'view' => [], // will append to front-end view variable, and could see it in browser (JS) level.
  'compile' => [], // use webpack compile only
];
```
* https://github.com/pmvc-plugin/view/blob/master/src/ViewEngine.php#L154-L155

### How to handle output header?
https://github.com/pmvc-plugin/view/wiki#how-to-config-header

## Pass Template Folder
* user pmvc config _TEMPLATE_DIR
* https://github.com/pmvc-plugin/controller/blob/master/src/Constants.php#L48

## Purpose
   * Use __invoke to get other framework object instance
      * https://github.com/pmvc-plugin/view/blob/master/src/ViewEngine.php#L29-L32

## Shareable forward
   * https://github.com/pmvc-plugin/default_forward

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
