<?php

class GFCommon {

	const URL_REWRITE = false;

	public static function formatLink($module, $action, array $querystring = null) {

		if(is_null($querystring)) {
			$querystring = array();
		}

		if(isset($_SESSION['token']['id'])) {
			$querystring[] = 'token=' . $_SESSION['token']['id'];
		}


		if(GFCommon::URL_REWRITE) {
			return $module.'/'.$action.'/?'.implode('&',$querystring);
		} else {
			if(count($querystring) > 0) {
				$action .= '&';
			}
			return '?module='.$module.'&action='.$action.implode('&',$querystring);
		}
	}
}