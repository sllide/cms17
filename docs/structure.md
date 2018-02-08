# System Structure

CMS17 is structured in such a way that every part of the system has its own folder. Every part of this system will have access to the parts they are allowed to use.

## /system/cores
Cores are what define the basic functionality of the mode CMS17 resides in. Cores can be anything they want to be as they have access to all engines and can build upon this. Cores can extend functionality in any way by creating extra classes only accessable by that core itself.

#### File Structure
  * **AbstractCore.php** The basic functionality of a core will be defined here.
  * Core folder/
    * **Core.php** The entry point of a core.
    * classes/
      * **Extention.php** A anonymous class that the core can request and use.
      * ..
    * templates/
      * **template.html** A template to build upon.
      * ..


## /system/engines
Engines will define the basic functionality of something. Be it Files, Databases, or Templates. These engines are useable by the cores and the services plugins use.

#### File Structure
  * **AbstractEngine.php** The basic functionality of a engine will be defined here.
  * Engine folder/
    * **Engine.php** The entry point of a engine.
    * classes/
      * **Extention.php** A anonymous class that the engine can request and use.
      * ..

## /system/services
Services are the middleman between plugins and engines. While engines define basic functionality this is where the system resides and allowing plugins to use these can be dangerous. Services will

#### File Structure
  * **AbstractService.php** The basic functionality of a service will be defined here.
  * Engine folder/
    * **Service.php** The entry point of a service.
    * classes/
      * **Extention.php** A anonymous class that the service can request and use.
      * ..

## /plugins
While every other plugin like system described here has a pretty simmilar file structure plugins are a whole different case. plugins will be way more restricted compared to everything else as this is where (hopefully) third-party code will reside.

#### File Structure
  * **AbstractPlugin.php** The basic functionality of a plugin will be defined here.
  * **AbstractPluginData.php** This file will setup basic fallback information about the plugin.
  * **AbstractPluginPost.php** Post data will be routed in here.
  * **AbstractPluginController.php** The basic functionality of a plugin will be defined here.
  * Plugin folder/
    * **Plugin.php** The entry point of a plugin.
    * **Data.php** Class that contains information about plugin.
    * **Post.php** This is where post data will be routed to.
    * **Controller.php** The backend control panel tied to the plugin.
    * templates/
      * **index.html** A template to build upon.
      * ..
