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
  class reviewPlugin {
    //function used to setup widget if it isnt installed yet
    function initialize() {
      //do initial setup stuff :)
      //database tables will be initialized at this point
    }

    //these are the functions called whenever their tag is found
    //view functions need to return a string with whatever needs to be printed
    function widgetView() {
      return "<h1>Hello View!</h1>";
    }
    function pageView() {
      return file_get_contents("pageView.html");
    }

    //function used to retrieve all tags used by plugin
    function registerTags() {
      //create array to be returned
      $tags = new Array();

      //create tags
      $widget = new Array("reviewWidget", $this->widgetView);
      $page = new Array("reviewPage", $this->pageView);

      $tags[] = $widget;
      $tags[] = $page;
      return $tags;
    }
  }

  $plugins->register(new reviewPlugin());
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
