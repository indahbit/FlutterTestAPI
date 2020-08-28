<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

function CleanString($someString)
{
	$someString = str_replace("\t",'',$someString);
	$someString = str_replace("\r",'',$someString);
	$someString = str_replace("\n",'',$someString);
	return $someString;
}

function BuildStringid($string_id,$addition = '')
{
	$string_id = strtolower(str_replace(' ','-',$string_id.$addition));
	$string_id = strtolower(str_replace('%','',$string_id));
	$string_id = strtolower(str_replace('(','',$string_id));
	$string_id = strtolower(str_replace(')','',$string_id));
	$string_id = strtolower(str_replace('/','',$string_id));
	$string_id = strtolower(str_replace('+','',$string_id));
	$ret = '';

	for($i=0;$i<strlen($string_id);$i++)
	{
		if(is_numeric($string_id[$i]))
		{
			$ret .= $string_id[$i];
		}
		if($string_id[$i] == '-')
		{
			$ret .= $string_id[$i];
		}
		if($string_id[$i] >= 'A' && $string_id[$i] <= 'Z')
		{
			$ret .= $string_id[$i];
		}
		if($string_id[$i] >= 'a' && $string_id[$i] <= 'z')
		{
			$ret .= $string_id[$i];
		}
	}
	return $ret;
}

function GenerateMenus($arr,$navActive)
{
	foreach($arr as $a)
	{
		$link = '#';
		$class = 'class="hasChild"';
		$active = '';
		$arrow = '<i class="fa fa-angle-down arrow"></i>';
		if(!isset($a->child) || (isset($a->child) && empty($a->child)))
		{
			$class = '';
			$arrow = '';
			if($a->link != '#')
				$link = site_url($a->link);
		}
		if($navActive == $a->link)
		{
			if($class == '')
				$class = 'class="active"';
		}
		echo '<li '.$class.' menu="'.$a->menu_id.'">';
		echo '<a href="'.$link.'" menu="'.$a->menu_id.'"><i class="fa '.$a->class_menu.'"></i>'.$a->menu_name.' '.$arrow.'</a>';
		if(isset($a->child) && !empty($a->child))
		{
			echo '<ul parent="'.$a->menu_id.'">';
			GenerateMenus($a->child,$navActive);
			echo '</ul>';
		}
		echo '</li>';
	}
}