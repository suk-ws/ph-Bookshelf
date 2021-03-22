<?php

define("APP_NAME", "ph-Bookshelf");
define("VERSION", "0.1");
define("GITBOOK_VERSION", "3.2.3");

function get_frontpage_generate_version (): string {
	return APP_NAME." ".VERSION." with Gitbook ".GITBOOK_VERSION;
}
