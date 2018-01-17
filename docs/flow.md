Program flow
==========

Before booting cms17 a few things need to be done. The root dir should be set to the level above public, this is to avoid those pesky ../ paths. Whats not going to happen is autoloading. CMS17 will dynamicly load everything through cores and engines to keep the plug, in plugins.

new CMS17();
----------
The heart and soul of cms17! The puppet master in charge of all cores and engines. One of the first thing cms17 does is initialize and setup all engines. After this is done it will ask the routing engine what core should be loaded. After it has done this the core will take over and build the website.

new Core();
----------
The core will be in charge of handling everything considered top level for what it needs to build. It will decide wich page to show and what plugins to initialize. It does this by talking to the engines. And with the help of those and mostly only those engines it will be able to setup everything needed.

**This generally shows what the WebCore can do as example**
* **TemplateEngine** Register single use callback tags content and plugin.
* **RoutingEngine** Wich page is being requested?
* **DatabaseEngine** What data does this page have?
* **TemplateEngine** Build the template database engine gave.
  * **TemplateEngine** Recursively search for tag.
  * Found data tag.
    * **TemplateEngine** Ask database for data.
  * Found content tag.
    * **TemplateEngine** Ask core for data.
    * **Core** Return page content via callback function.
  * Found plugin tag.
    * **TemplateEngine** Ask core for data.
    * **PluginEngine** Load plugin.
    * **DatabaseEngine** Is plugin enabled?
    * Plugin is disabled.
      * **LogEngine** Report loading of disabled plugin.
    * Plugin is enabled.
      * **FileEngine** Does plugin exist and is it complete?
      * (Part of) plugin is missing.
        * **LogEngine** Report missing plugin files.
      * Plugin is valid.
        * **PluginEngine** Load and validate plugin data.
        * Plugin requests invalid services.
          * **LogEngine** Report plugin requesting invalid services.
        * Plugin doesnt extend correct classes.
          * **LogEngine** Report plugin not having correct classes.
        * Plugin is valid.
          * **PluginEngine** Expose requested services to plugin.
          * **PluginEngine** Invoke plugin entry point.
            * **Plugin** Poke services until satisfied.
            * **Plugin** Return data.
  * Found unexisting tag.
    * **LogEngine** Report missing tag name.
    * **TemplateEngine** Remove tag from template.
  * Didnt find tag.
    * **TemplateEngine** Return parsed template.
* **Core** echo the resulting string that every step above manipulated. (Yes, really)
