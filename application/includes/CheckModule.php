<?php
	$url =  "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$url = str_replace(base_url(),'', $url);
	$cari = strpos($url,'/');
	
	if (!$cari)
		$controller_name = $url;
	else
		$controller_name = strstr($url,'/',true);

	if (!$this->session->userdata('user'))
	{
		redirect('Login');
	}

	//die($controller_name);
	$module_id = $this->ModuleModel->GetModuleIdByControllerName($controller_name);
	//die($module_id);
	$check_role = $this->ModuleModel->GetRoleModule($module_id);

	if ($check_role==NULL)
		redirect('Forbidden/ErrorNoRole');

	$this->session->set_userdata('active_module',$module_id);
	$this->session->set_userdata('can_view',($check_role->can_view==0)?false:true);
	$this->session->set_userdata('can_add',($check_role->can_add==0)?false:true);
	$this->session->set_userdata('can_edit',($check_role->can_edit==0)?false:true);
	$this->session->set_userdata('can_delete',($check_role->can_delete==0)?false:true);
	
	if(!$this->session->userdata('can_view'))
		redirect('Forbidden');

	$page_title = $this->ModuleModel->GetModuleTitle($module_id);
?>