CMS17
==========

After fooling around with CMS17 and figuring out what I want its time to make a game plan.
This document will describe everything down to the smallest detail. :thumbsup:

The information in this document is not final and may chance where needed.

[TOC]

CMS structure
==========
* system/
  * supers/
    * Engine.php
    * PluginData.php
    * DataModel.php
    * Controller.php
    * Service.php
  * engines/
    * DatabaseEngine.php **_extends Engine_**
    * ServiceEngine.php **_extends Engine_**
    * PluginEngine.php **_extends Engine_**
    * TemplateEngine.php **_extends Engine_**
    * FileEngine.php **_extends Engine_**
    * SessionEngine.php **_extends Engine_**
    * RoutingEngine.php **_extends Engine_**
  * services/
    * DatabaseService.php **_extends Service_**
    * TemplateService.php **_extends Service_**
    * RoutingService.php **_extends Service_**
    * SessionService.php **_extends Service_**
* public/
  * index.php
* plugins/
  * **Plugin hierarchy**
    * views/
      * container.html
      * controlpanel.html
      * button.html
    * plugin.php **_extends Plugin_**
    * models.php **_extends Model_**
    * controllers.php **_extends Controller_**
  * **system plugins**
  * system/
  * installer/
  * cms/
  * website/
  * **user plugins**
  * page/
  * portfolio/
  * guestbook/

Supers
==========
Every single class in CMS17 will either extend Engine, Plugin, Component or Service. This is to ensure uniform functionality and easy extendability.

Engine
-----------
A engine will be in charge of the bare essentials of a certain feature. The file engine will be in charge of the actual reading and writing of files. The database engine will be the class directly talking to the database. These engines will contain the most simple functions that work independently of eachother.

Service
-----------
A service will exist between a engine and plugins, while engines have simple sets of functions for basic tasks services build upon these functions and expose these higher level functions to plugins for usage. These services exist to simplify plugins and to ease the burden upon engines keeping both services and engines as clean as possible. While hiding the sensitive parts of the CMS.

PluginData
-----------
The plugins are where all the magic happens. The pluginData class itself will be in charge of telling the system what the plugin needs. The database structure, What services to expose to the controller, wich Views to expose to the website plugin and cms plugin. It will also contain meta data like plugin title and description, the author and version number.

DataModel, View, Controller
-----------
These are the three required plugin classes. the famous Model, View and Controller. Views are simple html templates with tags in them annotated as **@_name_@**. Controllers will have access to all the services the plugin needs. Including the template engine wich will build the supplied view with all the data the model supplies. The model itself will get access to the database service if needed. And only the database service. These models represent the data structures that will be filled by the database and expanded upon by the controller to be passed to the view. I have the feeling my MVC system is completely missing the point of MVC but I only have general grasp of how MVC works.

System execution flow
==========
Here I will do my best to explain what the CMS is supposed to do and how it will achieve this.

Initialization
-----------
When the website is being visited public/index.php will be invoked. The goal of this file is to setup all Engines present. When this is done index.php will register the system plugin and give it access to all engines. The function of the system plugin is to determine wich of the three system plugins to load next. installer, cms or website. Installer will be called if the CMS is fresh and not yet initialized. If the CMS is initialized it has to make the choice of booting the cms or the website. This is where the session engine comes into play. The session engine will store user data. Who is logged in and what their rights are. And a variable stating if the user is in management modus or not. If the user is in this modus the system will boot up the CMS instead of the website. If all this is decided the system plugin will directly tell the plugin engine to load the chosen system plugin. When all this is done index.php will tell the plugin engine to register all other plugins by scraping their plugin.php page and storing everything it learns from these files so the CMS can meet all the requirements with ease. If this is done it will fire up the template engine with one of the following tags. **@installer@** **@website@** **@cms@**

system plugin loaded
-----------
The next plugin that is loaded will be one of the three remaining system plugins. They all have access to every registered tag and every engine. Execution of these three plugins is identical to eachother.  The flow of this is as follows:
* The template engine will look for a tag in the current output buffer
  * If no tag is found the template engine will stop execution and return the result for display
* When it finds a plugin it will ask the plugin engine if this is a known tag
  * if it isnt remove it from the buffer and restart the progress
* If it is a known tag require the model and controller of the plugin that registered that tag
* The registered tag will have a function definition that points to a specific controller function
* When this function is called the controller can do a bunch of things eg.
  * Ask the POST if anything special needs to happen
  * invoke a model
    * Tell it to get a data structure from the database
    * store data in the database
    * give the model extra data to populate it
  * Invoke services and use these
    * Ask the template service to build a view for it by supplying a view and the corrosponding model
      * these views have their own tags that can corrospond to two things
        * A variable supplied by the model
        * A controller function wich will invoke a whole new chain of building a component
        * If the tag cant be found in this contained template builder ignore it for the template engine itself to fill in
    * Ask the session service who is logged in and what his rights are
    * Ask the routing service if there is any extra data
  * If the controller has done everything it needed to do it has to return a string
    * This string can be a simple line of text
    * Or it can be the output the template service has built
* The template engine will replace the tag with the string the controller returned
* The process will restart

system plugin differences
-----------
While the program flow of installer, website and cms is identical. There is a difference in the tags that get loaded. the plugin manager wont expose cms tags to the website, or the other way around. The installer wont even get tags from the plugin manager since the system isnt installed yet.

Plugin Structure
==========
Here the basic structure of a plugin will be explained

plugin.php (required)
-----------
This file is the entry point of every plugin and will define the basic functionality.
````php
  namespace plugin/blog

  class Plugin extends PluginData {
    //meta data thats used to present plugins in a more user friendly way
    public final $PLUGIN_NAME = "Blog";
    public final $PLUGIN_DESCRIPTION = "A simple blog";
    public final $PLUGIN_VERSION = 0.8;

    //array of services that are needed by the plugin
    public final $SERVICES = ['database', 'template', 'session'];

    //an two dimentional array defining the tables and their structures
    //the column types of these arrays can be either 'INTEGER', 'REAL', 'TEXT' or 'BLOB'
    //anything else than these four types will be discarded and the plugin will stop loading
    public final $DATABASE_STRUCTURE = [
      'posts' => [
        'title' => 'TEXT',
        'content' => 'TEXT',
        'creatorID' => 'INT',
        'catagoryID' => 'INT',
      ]
      'catagories' => [
        'title' => 'TEXT',
        'description' => 'TEXT',
      ]
    ];

    //two dimentional array of tags wich describe the name and the controller class
    //these are the controller functions linked to tags that can be used outside of the plugin
    public final $WEBSITE_TAGS = [
      ['blog', 'controllerFunctionName'],
    ];

    //if the plugin has a configuration panel for use in the CMS report its controller class here
    //this variable does not have to exist if no panel is necesarry
    public final $CMS_PANEL = 'panelFunction';
  }
````

models.php (required)
-----------
This file will contain all models the views need to build themselfs
````php
  namespace plugin/blog/models

  class Catagory extends DataModel {
    public $title = "";
    public $description = "";

    function build($id) {
      //magical database service object, the Model superclass will set this up for you
      $catagory = $this->database->getCatagory($id);
      $this->title = $catagory['title'];
      $this->description = $catagory['description'];
    }
  }

  class Post extends DataModel {
    public $creatorID = "";
    public $title = "";
    public $content = "";

    function build($id) {
      //magical database service object, the Model superclass will set this up for you
      $post = $this->database->getPost($id);
      $this->creatorID = $post['creatorID'];
      $this->title = $post['title'];
      $this->content = $post['content'];
    }
  }
````

controllers.php (required)
-----------
This file will contain all plugin logic to supply both the model and the view with everything they need.
````php
  namespace plugin/blog/controllers

  //all controller classes will be callable internaly with @controllerClassName@

  class BlogPost extends Controller {

    function build() {
      //fetch the template service from the service array
      //this array is created by the superclass
      $template = $this->service['template'];

      //i'm not sure if this is even possible, but you get the idea.
      $model = $template->getModel('Post');
      $model->build(17);

      //The template engine will fetch the needed view for you, just supply the name

      //will fetch plugins/blog/views/blogpost.html and fill it with the supplied model data
      return $template->build('blogpost', $model);
    }
  }

  class Panel extends Controller {

    function build() {
      //here the panel will be build for the cms
    }
  }
````

views/
-----------
This folder is not required, it is possible your plugin has no views at all. The files in here are simple html files with tags in them, these function as templates for the template builder to use.
