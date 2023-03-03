<?php

namespace SukWs\Bookshelf\SiteConfig;

enum RobotsPolicy {
	case allow;
	case deny;
	case file;
	case raw;
}
