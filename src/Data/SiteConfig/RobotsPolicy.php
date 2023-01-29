<?php

namespace SukWs\Bookshelf\Data\SiteConfig;

enum RobotsPolicy {
	case allow;
	case deny;
	case file;
	case raw;
}
