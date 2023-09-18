<?php
//====================================================================================
// OCS INVENTORY REPORTS
// Copyleft Erwan GOALOU 2010 (erwan(at)ocsinventory-ng(pt)org)
// Web: http://www.ocsinventory-ng.org
//
// This code is open source and may be copied and modified as long as the source
// code is always made freely available.
// Please refer to the General Public Licence http://www.gnu.org/ or Licence.txt
//====================================================================================
 
	if(AJAX){
		parse_str($protectedPost['ocs']['0'], $params);
		$protectedPost+=$params;
		ob_start();
		$ajax = true;
	}
	else{
		$ajax=false;
	}
	

	$def_onglets['OTHER'] = $l->g(73001);
	$def_onglets['SOFTWARE'] = $l->g(73002); 

	//default => first onglet
	if (empty($protectedPost['onglet'])) {
		$protectedPost['onglet'] = "OTHER";
	}

	print_item_header("Windows Update State");

	if (!isset($protectedPost['SHOW']))
		$protectedPost['SHOW'] = 'NOSHOW';

	if (isset($_GET["cat"])) {
		if ($_GET["cat"] == "other") {
			$protectedPost['onglet'] = "OTHER";
		}

		if ($_GET["cat"] == "software") {
			$protectedPost['onglet'] = "SOFTWARE";
		}
	}
	
	$form_name="winupdate";

	$table_name=$form_name;
	$tab_options=$protectedPost;
	$tab_options['form_name']=$form_name;
	$tab_options['table_name']=$table_name;

	echo open_form($form_name);

	if($protectedPost['onglet'] == "OTHER"){

		$list_fields=array(
			"KB" => "KB",
			"Title" => "TITLE",
			"Install Date" => "DATE",
			"Operation Status" => "OPERATION",
			"Result Status" => "STATUS",
			"Support Link" => "SUPPORTLINK",
			"Description" => "DESCRIPTION"
		);

		$list_col_cant_del=$list_fields;
		$default_fields= $list_fields;

		
		$sql['SQL'] = "SELECT * FROM winupdatestate WHERE (hardware_id = $systemid)";
	}

	if($protectedPost['onglet'] == "SOFTWARE"){
		
		$list_fields=array(
			"Title" => "TITLE",
			"Last scan date" => "LASTSCANDATE",
			"Last installation date" => "LASTINSTALLATIONDATE"
		);

		$list_col_cant_del=$list_fields;
		$default_fields= $list_fields;
	
		$sql['SQL'] = "SELECT * FROM winupdatescan WHERE (hardware_id = $systemid)";
		
	}

	error_log($sql['SQL']);

	ajaxtab_entete_fixe($list_fields,$default_fields,$tab_options,$list_col_cant_del);

	echo close_form();
	
	if ($ajax){
		ob_end_clean();
		tab_req($list_fields,$default_fields,$list_col_cant_del,$sql['SQL'],$tab_options);
		ob_start();
	}
?>
