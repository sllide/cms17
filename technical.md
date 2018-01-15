CMS17
==========

The technical document describing the inner workings of CMS17.
Information in this document isnt final and will most likely be changed over time.



CMS structure
==========
* system/
  * AutoLoader.php
  * CMS17.php
  * abstract/
    * Core.php
    * Engine.php
    * Plugin.php
    * PluginData.php
    * PluginTemplates.php
  * cores/ **_extends Core_**
    * websiteCore.php
    * controlCore.php
    * installCore.php
  * engines/ **_extends Engine_**
    * DatabaseEngine.php
    * PluginEngine.php
    * TemplateEngine.php
    * FileEngine.php
    * SessionEngine.php
    * RoutingEngine.php
    * PostEngine.php
    * PageEngine.php
    * ServiceEngine.php
  * services/
    * DatabaseService.php
    * TemplateService.php
    * RoutingService.php
    * SessionService.php
* public/
  * index.php
* plugins/
  * example/
    * templates/
      * container.html
      * panel.html
      * ...
    * plugin.php **_extends Plugin_**
    * Data.php **_extends PluginData_**
    * Templates.php **_extends PluginTemplates_**
  * portfolio/
  * guestbook/

System execution flow
==========

CMS17.php
----------
* Load and initialize all engines.
* Decide wich core to load.
* Initialize chosen core and expose all engines to it.
* Fire up the core.

Core.php
----------
* Tell engines what they need to do.
  * Connect DatabaseEngine.
  * Register system reserved tags to TagEngine.
  * Retrieve data tags from the database and register these.
  * Let PluginEngine load all (enabled) plugins.
  * Register loaded plugin tags in tag engine.
* Decide what template to show and what data to insert.
* Setup the TemplateEngine with everything it needs.
* Let the TemplateEngine build everything.

Engines.php
----------
* TemplateEngine finds all tags and place the correct content.
* TemplateEngine will ask TagEngine for the content needed.
* TagEngine will look for the data tied to the tag.
  * Reserved system tag.
    * Ask the core what the content should be.
    * return the content to the template engine.
  * Data tag.
    * Find the tag in the database.
    * return the content to the template engine.
  * Function tag.
    * Figure out wich plugin registered this tag.
    * Ask the plugin manager to fetch the plugin that registered the tag.
    * Plugin manager will initialize the plugin if it wasnt yet.
    * Plugin build itself and initialize everything needed to build the content.
    * TagEngine will ask the plugin for the data tied to the tag registered.
    * Plugin builds the content given the tag name.
    * return the content to the template engine.
  * Tag not found.
    * return fallback string to template engine.

Reserverd tags
==========
@content@
----------
This is where the main content of the active page is loaded.

@navigation@
----------
Here links will be made for all enabled pages. It will have a template that gets inserted for every page. The template itself will support the tags **@path@** for the link itself and **@name@** for a readable page title.


Plugin Structure
==========
Here the basic structure of a plugin will be explained. All plugin classes will be returned as anonymous instances to keep the namespace clean. Adding constructors to these classes isnt possible since the super classes define these as final. This is to deny plugins from intializing before they are suposed to.

Plugin.php _(extends Plugin)_
-----------
The base and entry point of every plugin.

|Function|Return Type|Description|
|-|-|-|
|initPlugin()|Null|Called when a tag is found the plugin registered (only called once)
|initConfig()|Null|Called when the config panel is loaded (only called once)
|buildTag(String $tagName)|String (tag output)|Called when a tag is found and needs to be built
|doPost(Array $_POST)|Null|Called when the post data mentions 'plugin' => $pluginKey
|doConfigPost(Array $_POST)|Null|Called when the post data mentions 'plugin' => $pluginKey in config mode

Data.php _(extends PluginData)_
-----------
All plugin meta data will be described here. Wich services are needed. What their database structure is. And general information like what the plugin is called and who made it.

|Function|Return Type|Description|
|-|-|-|
|getName()|String|return plugin name
|getDescription()|String|return plugin description
|getAuthor()|String|return plugin author
|getVersion()|Double|return plugin version
|getTableNames()|String array|return table names in a string array
|getNeededServices()|String array|return services plugin requires
|getConfigName()|String or False|return string pointing to template function or false if there is no panel
|getPublicTags()|String array|return all tag names that are accessable from outside the plugin
|-|-|-|
|registerTableStructure(String table, Callable $builder)|Null|Asks the plugin to register a tables data types

Templates.php _(extends PluginTemplates)_
-----------
This class will contain all the functions needed to build templates.

|Function|Return Type|Description|
|-|-|-|
|{templateName}(Callable $builder)|Null|Invoked when the plugin asks for a template to be built. Register the tags needed for the template to be built and the template itself to the builder.
