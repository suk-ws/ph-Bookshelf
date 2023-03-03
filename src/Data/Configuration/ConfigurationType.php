<?php

namespace SukWs\Bookshelf\Data\Configuration;

readonly class ConfigurationType {
	
	public string $id;
	
	public ConfigurationScope $scope;
	
	public function __construct (string $id, ConfigurationScope $scope) {
		$this->id = $id;
		$this->scope = $scope;
	}
	
}