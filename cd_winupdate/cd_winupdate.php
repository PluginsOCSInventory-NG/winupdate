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
	
	$def_onglets['OTHER'] = "OTHER";
	$def_onglets['SOFTWARE'] = "SOFTWARE"; 

	//default => first onglet
	if (empty($protectedPost['onglet'])) {
		$protectedPost['onglet'] = "OTHER";
	}

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
	
	// Set the header
	if($protectedPost['onglet'] == "OTHER"){
		print_item_header($l->g(73003));
	}
	if($protectedPost['onglet'] == "SOFTWARE"){
		print_item_header($l->g(73004));
	}
	
	$form_name="winupdate";

	$table_name=$form_name;
	$tab_options=$protectedPost;
	$tab_options['form_name']=$form_name;
	$tab_options['table_name']=$table_name;

	echo open_form($form_name);

	if($protectedPost['onglet'] == "OTHER"){

		$list_fields=array(
			$l->g(73005) => "KB",
			$l->g(73006) => "TITLE",
			$l->g(73007) => "DATE",
			$l->g(73008) => "OPERATION",
			$l->g(73009) => "STATUS",
			$l->g(73010) => "SUPPORTLINK",
			$l->g(73011) => "DESCRIPTION"
		);

		$list_col_cant_del=$list_fields;
		$default_fields= $list_fields;
		
		$sql['SQL'] = "SELECT * FROM winupdatestate WHERE (hardware_id = $systemid)";
	}

	if($protectedPost['onglet'] == "SOFTWARE"){
		
		$list_fields=array(
			$l->g(73006) => "TITLE",
			$l->g(73012) => "LASTSCANDATE",
			$l->g(73013) => "LASTINSTALLATIONDATE"
		);

		$list_col_cant_del=$list_fields;
		$default_fields= $list_fields;
	
		$sql['SQL'] = "SELECT * FROM winupdatescan WHERE (hardware_id = $systemid)";
		
	}

	ajaxtab_entete_fixe($list_fields,$default_fields,$tab_options,$list_col_cant_del);

	echo close_form();
	
	if ($ajax){
		ob_end_clean();
		tab_req($list_fields,$default_fields,$list_col_cant_del,$sql['SQL'],$tab_options);
		ob_start();
	}
?>
