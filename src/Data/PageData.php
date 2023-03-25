<?php

namespace SukWs\Bookshelf\Data;

readonly class PageData {
	
	public string $page_html;
	
	public ?string $title;
	public bool $gen_title;
	
	public array $configurations;
	
	public function __construct (
		string $page_html, array $configurations = array(),
		string $title = null, bool $gen_title = false
	) {
		$this->page_html = $page_html;
		$this->configurations = $configurations;
		$this->title = $title;
		$this->gen_title = $gen_title;
	}
	
	public function getConfiguration (string $key): ?string {
		return @$this->configurations[$key];
	}
	
}