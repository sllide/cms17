CMS17
==========

After fooling around with CMS17 and figuring out what I want its time to make a game plan. :thumbsup:

The information in this document is not final and may chance where needed.



CMS structure
==========
* system/
  * CMS17.php
  * abstract/
    * Core.php
    * Plugin.php
    * PluginData.php
    * PluginBuilder.php
  * cores/
    * websiteCore.php **_extends Core_**
    * controlCore.php **_extends Core_**
    * installCore.php **_extends Core_**
  * engines/
    * DatabaseEngine.php
    * PluginEngine.php
    * TemplateEngine.php
    * FileEngine.php
    * SessionEngine.php
    * RoutingEngine.php
    * PostEngine.php
    * PageEngine.php
    * ToolEngine.php
  * tools/
    * DatabaseTool.php
    * TemplateTool.php
    * RoutingTool.php
    * SessionTool.php
* public/
  * index.php
* plugins/
  * **Plugin hierarchy**
    * templates/
      * container.html
      * panel.html
      * ...
    * plugin.php **_extends Plugin_**
    * PluginData.php **_extends PluginData_**
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

WebsiteCore.php
* Tell PluginEngine to gather all enabled plugin data.
* Check if the Post is set and let the PostEngine handle it.
* Give The TemplateEngine access to the plugin fetch method.
* Let the TemplateEngine build all tags.
* Done.

Plugin Structure
==========
Here the basic structure of a plugin will be explained. All plugin classes will be returned as anonymous instances to keep the namespace clean. If one of these classes contains a constructor it will halt execution and remove the plugin from the plugin engine.

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

PluginData.php _(extends PluginData)_
-----------
|Function|Return Type|Description|
|-|-|-|
|getName()|String|return plugin name
|getDescription()|String|return plugin description
|getAuthor()|String|return plugin author
|getVersion()|Double|return plugin version
|getTableNames()|String array|return table names in a string array
|getNeededServices()|String array|return services plugin requires
|getConfigName()|String or False|return string pointing to template function or false if there is no panel
|-|-|-|
|registerTableStructure(String table, Callable $builder)|Null|Asks the plugin to register a tables data types
|registerTags(Callable $registerer)|Null|Asks the plugin to register its public tags

Templates.php _(extends PluginTemplates)_
-----------
This class will contain all the functions needed to build templates.

|Function|Return Type|Description|
|-|-|-|
|{templateName}(Callable $builder)|Null|Invoked when the plugin asks for a template to be built. Register the tags needed for the template to be built and the template itself to the builder.
