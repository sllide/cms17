## Plugins
To ensure functionality is in place a few plugins are going to be written:
* page displayer (system plugin)
* navigation plugin (system plugin)
* review plugin
* portfolio plugin

Plugins will exist out of a folder with a entry file named plugin.php.
Other than that file everything is fair game and can be dropped wherever needed.
##### plugin.php
  the entry file containing everything php related. Here the programmer has plenty of freedom doing whatever he wants. However, there are a few required functions that need to be defined.
  ```php
  class examplePlugin extends Plugin {

    //This will be the method to define any database related structure
    function getDataStructure() {
      return "";
    }

    //setup will be called if the getDataStructure function reporst a different structure than the database reports
    function setup($db) {
      return true;
    }

    //this is a method called when a tag is found in a template
    //this method is hooked in the function below
    function view() {
      //get page data
      return "Hello example plugin!";
    }

    //A required function needed to register all tags the plugin provides
    //Can be empty if there are no tags, it has to exist tho.
    function registerTags($tagEngine) {
      $tagEngine->register("example", [$this, 'view']);
    }
  }

  return new examplePlugin();
  ```

#### Database
A SQLite database containing a few system tables needed for the cms to function. Plugins will populate the database further where needed.

I'm really not sure what to do with this yet.

### tags
Contains all user defined tags.

| name          | type  | functionality
| - |
| name    | string | tag name
| value   | string | tag value
