<?php
/**
 * Redirecturls redirecturls MODX Revolution 2.x plugin
 *
 * Copyright 2012 Jiri Pavlicek <jiri@pavlicek.cz>
 *
 * @author Jiri Pavlicek <jiri@pavlicek.cz>
 * @version Version 1.0.0
 * 03/20/12
 *
 * Redirecturls is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation; either version 2 of the License, or (at your option) any
 * later version.
 *
 * Redirecturls is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * Redirecturls; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package redirecturls
 */

/**
 * MODx Redirecturls redirecturls plugin
 *
 * Install:
 * 1) create plugin "redirecturls" on event OnPageNotFound
 * 2) create system config key "redirecturls_ids"
 *
 * Description:
 * Plugin Redirecturls rewrite more urls to one document. In the system config key 
 * "redirecturls_ids" specify one or more document IDs (separated by comma).
 * If you have more plugins on event OnPageNotFound, this plugin must be run first
 * (lowest priority value).
 *
 * Example: 
 * 1) in the system config key "redirecturls_ids" specify one or more document IDs (for example 5,6)
 * 2) you can call URL like this:
 * 	  http://yoursite/actions/ (URL of document ID 5)
 * 	  http://yoursite/actions/something1 (this will be rewritten to document ID 5)
 * 	  http://yoursite/actions/something2 (this will be rewritten to document ID 5)
 * 	  http://yoursite/actions/something3 (this will be rewritten to document ID 5)
 * 	  http://yoursite/products/ (URL of document ID 6)
 * 	  http://yoursite/products/everythingelse1 (this will be rewritten to document ID 6)
 * 	  http://yoursite/products/everythingelse2 (this will be rewritten to document ID 6)
 * 	  http://yoursite/products/everythingelse3 (this will be rewritten to document ID 6)
 *
 * Tested od MODX revolution 2.2.1-dev
 *
 * Events: OnPageNotFound
 *
 * @package redirecturls
 *
 */

global $modx;

if ($modx->event->name != 'OnPageNotFound') {
	return;
}
$redirecturls_ids = $modx->getOption('redirecturls_ids');
$redirecturls_ids = explode(',', $redirecturls_ids);
$this_uri = $_SERVER['REQUEST_URI'];

foreach ($redirecturls_ids as $id) {
	$id = trim($id);
	$uri = '/' . array_search($id, $modx->aliasMap) . '/';
	if (substr($this_uri, 0, strlen($uri)) == $uri) {
		$modx->sendForward($id);
	}
}

return;
