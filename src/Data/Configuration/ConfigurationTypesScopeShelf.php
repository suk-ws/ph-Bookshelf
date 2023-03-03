<?php

namespace SukWs\Bookshelf\Data\Configuration;

class ConfigurationTypesScopeShelf {
	
	public static array $scope_shelf = array();
	public static array $scope_page = array();
	
}

ConfigurationTypesScopeShelf::$scope_shelf[] = new ConfigurationType("site.robots", ConfigurationScope::Shelf);
ConfigurationTypesScopeShelf::$scope_page[] = new ConfigurationType("old.title.gen", ConfigurationScope::Page);
ConfigurationTypesScopeShelf::$scope_page[] = new ConfigurationType("highlightjs", ConfigurationScope::Page);
ConfigurationTypesScopeShelf::$scope_page[] = new ConfigurationType("highlightjs.language", ConfigurationScope::Page);
ConfigurationTypesScopeShelf::$scope_page[] = new ConfigurationType("highlightjs.theme", ConfigurationScope::Page);
ConfigurationTypesScopeShelf::$scope_page[] = new ConfigurationType("codeblock.bg-color", ConfigurationScope::Page);
ConfigurationTypesScopeShelf::$scope_page[] = new ConfigurationType("codeblock.fg-color", ConfigurationScope::Page);
ConfigurationTypesScopeShelf::$scope_page[] = new ConfigurationType("codeblock.tab-size", ConfigurationScope::Page);
ConfigurationTypesScopeShelf::$scope_page[] = new ConfigurationType("regex.highlight", ConfigurationScope::Page);
ConfigurationTypesScopeShelf::$scope_page[] = new ConfigurationType("listing.marker.rainbow", ConfigurationScope::Page);
ConfigurationTypesScopeShelf::$scope_page[] = new ConfigurationType("title.permalink.flash", ConfigurationScope::Page);
ConfigurationTypesScopeShelf::$scope_page[] = new ConfigurationType("web-title.rolling", ConfigurationScope::Page);
