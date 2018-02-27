Roadmap
==========
CMS17 is far from done. Way to many wild ideas.

Major
----------
* The file engine is really fragile. It needs to be able to find files dynamicly. However, the way it does this is shitty. OS'es have different ways of reporting file paths and such. Find a more uniform way.
* Tags in templates should be resolved automaticly and not rely on registered callbacks.

Minor
----------
* Log output should appear in the body of the document itself respecting HTML structure.
* Dont collapse plugins in the control panel. Its actually pretty annoying.

Ideas
----------
* Should the router fire up the cores and pages itself or just report them and let cms17 itself handle it?
* Ask valve if you can get the right to use the combine logo as the CMS logo. lol
* Make a fresh install force the setup core to be loaded. And have the setup core remove itself and the code that loads it.
* Store enabled plugins in a php file instead of storing the info in the database and have the control panel build the file when plugins get enabled or disabled.
* Create a page engine that lift some work from the cores