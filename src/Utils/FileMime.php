<?php

namespace SukWs\Bookshelf\Utils;

use Elephox\Mimey\MimeMappingBuilder;
use Elephox\Mimey\MimeTypes;

class FileMime {
	
	private static MimeTypes $mimes;
	
	static function init (): void {
		$builder = MimeMappingBuilder::create();
		$builder->add('text/markdown', 'md');
		$builder->add('text/markdown', 'mkd');
		$builder->add('text/markdown', 'mdwn');
		$builder->add('text/markdown', 'mdown');
		$builder->add('text/markdown', 'mdtxt');
		$builder->add('text/markdown', 'mdtext');
		$builder->add('text/markdown', 'markdown');
		self::$mimes = new MimeTypes($builder->getMapping());
	}
	
	public static function fromExtension($ext): string {
		return self::$mimes->getMimeType($ext) ?: "application/octet-stream";
	}
	
} FileMime::init();
