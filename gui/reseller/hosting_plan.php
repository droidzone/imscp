<?php
/**
 * i-MSCP a internet Multi Server Control Panel
 *
 * @copyright 	2001-2006 by moleSoftware GmbH
 * @copyright 	2006-2010 by ispCP | http://isp-control.net
 * @copyright 	2010 by i-msCP | http://i-mscp.net
 * @version 	SVN: $Id$
 * @link 		http://i-mscp.net
 * @author 		ispCP Team
 * @author 		i-MSCP Team
 *
 * @license
 * The contents of this file are subject to the Mozilla Public License
 * Version 1.1 (the "License"); you may not use this file except in
 * compliance with the License. You may obtain a copy of the License at
 * http://www.mozilla.org/MPL/
 *
 * Software distributed under the License is distributed on an "AS IS"
 * basis, WITHOUT WARRANTY OF ANY KIND, either express or implied. See the
 * License for the specific language governing rights and limitations
 * under the License.
 *
 * The Original Code is "VHCS - Virtual Hosting Control System".
 *
 * The Initial Developer of the Original Code is moleSoftware GmbH.
 * Portions created by Initial Developer are Copyright (C) 2001-2006
 * by moleSoftware GmbH. All Rights Reserved.
 * Portions created by the ispCP Team are Copyright (C) 2006-2010 by
 * isp Control Panel. All Rights Reserved.
 * Portions created by the i-MSCP Team are Copyright (C) 2010 by
 * i-MSCP a internet Multi Server Control Panel. All Rights Reserved.
 */

// Begin page line
require '../include/imscp-lib.php';

check_login(__FILE__);

$cfg = iMSCP_Registry::get('config');

$tpl = new iMSCP_pTemplate();
$tpl->define_dynamic('page', $cfg->RESELLER_TEMPLATE_PATH . '/hosting_plan.tpl');
$tpl->define_dynamic('page_message', 'page');
$tpl->define_dynamic('logged_from', 'page');
// Table with hosting plans
$tpl->define_dynamic('hp_table', 'page');
$tpl->define_dynamic('hp_entry', 'hp_table');
$tpl->define_dynamic('hp_delete', 'page');
$tpl->define_dynamic('hp_menu_add', 'page');

$tpl->assign(
	array(
		'TR_RESELLER_MAIN_INDEX_PAGE_TITLE' => tr('i-MSCP - Reseller/Main Index'),
		'THEME_COLOR_PATH' => "../themes/{$cfg->USER_INITIAL_THEME}",
		'THEME_CHARSET' => tr('encoding'),
		'ISP_LOGO' => get_logo($_SESSION['user_id'])
	)
);

/*
 *
 * static page messages.
 *
 */

gen_reseller_mainmenu($tpl, $cfg->RESELLER_TEMPLATE_PATH . '/main_menu_hosting_plan.tpl');
gen_reseller_menu($tpl, $cfg->RESELLER_TEMPLATE_PATH . '/menu_hosting_plan.tpl');

gen_logged_from($tpl);

gen_hp_table($tpl, $_SESSION['user_id']);

$tpl->assign(
	array(
		'TR_HOSTING_PLANS' => tr('Hosting plans'),
		'TR_PAGE_MENU' => tr('Manage hosting plans'),
		'TR_PURCHASING' => tr('Purchasing'),
		'TR_ADD_HOSTING_PLAN' => tr('Add hosting plan'),
		'TR_TITLE_ADD_HOSTING_PLAN' => tr('Add new user hosting plan'),
		'TR_BACK' => tr('Back'),
		'TR_TITLE_BACK' => tr('Return to previous menu'),
		'TR_MESSAGE_DELETE' => tr('Are you sure you want to delete %s?', true, '%s')
	)
);

gen_hp_message($tpl);
generatePageMessage($tpl);

$tpl->parse('PAGE', 'page');
$tpl->prnt();

// BEGIN FUNCTION DECLARE PATH

function gen_hp_message(&$tpl) {
	// global $externel_event, $hp_added, $hp_deleted, $hp_updated;
	global $external_event;

	if (isset($_SESSION["hp_added"])
		&& $_SESSION["hp_added"] == '_yes_') {
		$external_event = '_on_';
		set_page_message(tr('Hosting plan added!'));
		unset($_SESSION["hp_added"]);
		unset($GLOBALS['hp_added']);
	} else if (isset($_SESSION["hp_deleted"])
		&& $_SESSION["hp_deleted"] == '_yes_') {
		$external_event = '_on_';
		set_page_message(tr('Hosting plan deleted!'));
		unset($_SESSION["hp_deleted"]);
		unset($GLOBALS['hp_deleted']);
	} else if (isset($_SESSION["hp_updated"])
		&& $_SESSION["hp_updated"] == '_yes_') {
		$external_event = '_on_';
		set_page_message(tr('Hosting plan updated!'));
		unset($_SESSION["hp_updated"]);
		unset($GLOBALS['hp_updated']);
	} else if (isset($_SESSION["hp_deleted_ordererror"])
		&& $_SESSION["hp_deleted_ordererror"] == '_yes_') {
		//$external_event = '_on_';
		set_page_message(tr('Hosting plan can\'t be deleted, there are orders!'));
		unset($_SESSION["hp_deleted_ordererror"]);
	}

} // End of gen_hp_message()

/**
 * Extract and show data for hosting plans
 */
function gen_hp_table(&$tpl, $reseller_id) {
	global $external_event;

	$cfg = iMSCP_Registry::get('config');

	if (isset($cfg->HOSTING_PLANS_LEVEL)
		&& $cfg->HOSTING_PLANS_LEVEL === 'admin') {
		$query = "
			SELECT
				t1.`id`, t1.`reseller_id`, t1.`name`, t1.`props`, t1.`status`,
				t2.`admin_id`, t2.`admin_type`
			FROM
				`hosting_plans` AS t1,
				`admin` AS t2
			WHERE
				t2.`admin_type` = ?
			AND
				t1.`reseller_id` = t2.`admin_id`
			AND
				t1.`status` = 1
			ORDER BY
				t1.`name`
		";

		$rs = exec_query($query, 'admin');
		$tr_edit = tr('View details');
		$tpl->assign('HP_MENU_ADD', '');
	} else {
		$query = "
			SELECT
				`id`, `name`, `props`, `status`
			FROM
				`hosting_plans`
			WHERE
				`reseller_id` = ?
			ORDER BY
				`name`
		";
		$rs = exec_query($query, $reseller_id);
		$tr_edit = tr('Edit');
	}

	if ($rs->rowCount() == 0) {
		// if ($external_event == '_off_') {
		set_page_message(tr('Hosting plans not found!'));
		// }
		$tpl->assign('HP_TABLE', '');
	} else { // There are data for hosting plans :-)
		if ($external_event == '_off_') {
			$tpl->assign('HP_MESSAGE', '');
		}

		$tpl->assign(
			array(
				'TR_HOSTING_PLANS' 	=> tr('Hosting plans'),
				'TR_NOM' 			=> tr('No.'),
				'TR_EDIT' 			=> $tr_edit,
				'TR_PLAN_NAME' 		=> tr('Name'),
				'TR_ACTION' 		=> tr('Actions')
			)
		);

		$coid = isset($cfg->CUSTOM_ORDERPANEL_ID)
			? $cfg->CUSTOM_ORDERPANEL_ID
			: '';

		$i = 1;
		$orders_count = 0;
		while ($data = $rs->fetchRow()) {
			list(
				$hp_php,
				$hp_cgi,
				$hp_sub,
				$hp_als,
				$hp_mail,
				$hp_ftp,
				$hp_sql_db,
				$hp_sql_user,
				$hp_traff,
				$hp_disk,
				$hp_backup,
				$hp_dns,
				$hp_allowsoftware
			) = explode(";", $data['props']);
			
			if($hp_allowsoftware == "_no_" || $hp_allowsoftware == "" || $hp_allowsoftware == "_yes_" && get_reseller_sw_installer($reseller_id) == "yes") {
				$orders_count++;
				$tpl->assign(array('CLASS_TYPE_ROW' => ($i % 2 == 0) ? 'content' : 'content2'));

				$status = ($data['status']) ? tr('Enabled') : tr('Disabled');

				$tpl->assign(
					array(
						'PLAN_NOM' => $i++,
						'PLAN_NAME' => tohtml($data['name']),
						'PLAN_NAME2' => addslashes(clean_html($data['name'])),
						'PLAN_ACTION' => tr('Delete'),
						'PLAN_SHOW' => tr('Show hosting plan'),
						'PURCHASING' => $status,
						'CUSTOM_ORDERPANEL_ID' => $coid,
						'HP_ID' => $data['id'],
						'RESELLER_ID' => $_SESSION['user_id']
					)
				);

				$tpl->parse('HP_ENTRY', '.hp_entry');
			}
		}

		if ($orders_count == 0) {
			set_page_message(tr('Hosting plans not found!'));
			$tpl->assign('HP_TABLE', '');
		} else {
			$tpl->parse('HP_TABLE', 'hp_table');
		}
	}

}

unsetMessages();