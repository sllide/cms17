<?php
  abstract class PluginData {
    public final function __construct() {}

    public abstract function getName();
    public abstract function getDescription();
    public abstract function getAuthor();
    public abstract function getVersion();

    public abstract function hasConfigPanel();

    public abstract function getTableNames();
    public abstract function getNeededServices();
    public abstract function getTags();

    public abstract function registerTableStructure($table, Callable $registerer);
  }
?>
