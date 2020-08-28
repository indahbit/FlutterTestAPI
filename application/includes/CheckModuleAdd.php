<?php
	if (!$this->session->userdata('user'))
		redirect('Login');

	$url =  "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$url = str_replace(base_url(),'', $url);
	$cari = strpos($url,'/');
	if (!$cari)
		$controller_name = $url;
	else
		$controller_name = strstr($url,'/',true);

	$module_id = $this->ModuleModel->GetModuleIdByControllerName($controller_name);
	$check_role = $this->ModuleModel->GetRoleModule($module_id);

	$this->session->set_userdata('active_module',$module_id);
	$this->session->set_userdata('can_view',($check_role->can_view==0)?false:true);
	$this->session->set_userdata('can_add',($check_role->can_add==0)?false:true);
	$this->session->set_userdata('can_edit',($check_role->can_edit==0)?false:true);
	$this->session->set_userdata('can_delete',($check_role->can_delete==0)?false:true);
	
	if(!$this->session->userdata('can_add'))
		redirect('Forbidden');

	$page_title = $this->ModuleModel->GetModuleTitle($module_id).' (ADD)';
?>