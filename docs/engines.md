Engines
==========

All engines are described here, to see what the methods are of these engines navigate to the engine itself.

File
----------
If files need to be loaded or validated

Database
----------
Any database operation will be routed through this engine.

Install
----------
This engine will be in charge of installing plugins.

Security
----------
Want to check a plugin for anything suspicious? Ask the security engine what it thinks of said plugin.

Log
----------
If something weird happens tell it to the log engine! It will handle all messages and display them where needed. By default the log engine will log warnings and errors to the log table. However you can tell the log engine to directly output messages to the client. This will also show extra notices where told to.

Plugin
----------
The plugin manager is able to boot one single plugin, it can boot multiple plugins but the previous plugin needs to be released first.

Post
----------
The post engine will handle all incoming data when the website is called from /post/. It will route the received data to where it needs to be.

Routing
----------
This engine is responsible for keeping track of what core is needed, wich page to load. what action to do.

Service
----------
Services are abstracted layers between plugins and engines. As engines have full access to everything it isnt smart to

Template
----------
The template engine will find tags and invoke the callback linked to that tag. Previously tags where useable for as many times as needed but this has been changed to a one time use for extra flexibility concerning callbacks this also disallows tag loops to happen.
