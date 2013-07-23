<?php

$global_menu = [];
$sub_menu = [];
$full_menu = [];

if(isset($_SESSION['token'])) {
	echo "Bienvenue " . $_SESSION['token']['username'];
}

foreach($globalMapping as $module_name => $module) {
	include SERVER_ROOT . '/modules/' . $module . '/mapping.php';

	$full_menu[$module_name] = [];
	$global_menu[] = $module_name;

	foreach ($moduleMapping[$module] as $action_name => $action) {

		$aclOk = GFCommonAuth::checkAcl($action->acl, true);

		//if($aclOk)
		echo '<br>'.$action_name;
		var_dump($aclOk);
		if($aclOk == true && $action_name == 'logout') {
			$aclOk = false;
		}

		if($action->inMenu != false && $aclOk) {
			$sub_menu[$action_name] = $action->inMenu;
			$full_menu[$module_name][$action_name] = $action->inMenu;
		}
	}
}

function printFullMenu(Array $menu) {

	GFCommonJavascript::AddScript('lib/jquery', GFCommonJavascript::ScopeCore);
	GFCommonJavascript::AddScript('lib/jquery-ui', GFCommonJavascript::ScopeLib);
	GFCommonJavascript::AddStyle('lib/jquery-ui');

	GFCommonJavascript::AddScript('<script>
	  $(function() {
	    $( "#menu" ).accordion();
	  });
  </script>', GFCommonJavascript::ScopeInline);

	/*echo '<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
   <script>
	  $(function() {
	    $( "#menu" ).accordion();
	  });
  </script>';*/

	echo '<div id="menu">';

	foreach($menu as $section => $submenu) {
		if(count($submenu) > 0) {
			echo "<h3>$section</h3><div><ul>";
			foreach ($submenu as $menu_action => $menu_name) {
				echo "<li><a href='?module=$section&action=$menu_action'>$menu_name</a></li>";
			}
			echo '</ul></div>';
		}
	}
	echo '</div>';
}