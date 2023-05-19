<?php

ini_set(
	'open_basedir',
	!($open_basedir = ini_get('open_basedir')) ? "" : "$open_basedir:" .
		__DIR__
);
