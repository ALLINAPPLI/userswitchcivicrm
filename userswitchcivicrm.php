<?php

require_once 'userswitchcivicrm.civix.php';
// phpcs:disable
use CRM_Userswitchcrm_ExtensionUtil as E;
// phpcs:enable

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function userswitchcrm_civicrm_config(&$config) {
  _userswitchcrm_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function userswitchcrm_civicrm_install() {
  _userswitchcrm_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function userswitchcrm_civicrm_enable() {
  _userswitchcrm_civix_civicrm_enable();
}

function userswitchcrm_civicrm_summaryActions(&$actions, $contactID) {
  if (current_user_can('administrator')) {
    $viewID = CRM_Core_Session::singleton()->get('view.id');
    if (!empty($viewID)) {
      $ufID = \Civi\Api4\UFMatch::get(FALSE)
                    ->addSelect('uf_id')
                    ->addWhere('contact_id', '=', $viewID)
                    ->execute()->first()['uf_id'];
    }
    if (!empty($ufID)) {
      $user = get_user_by('id', $ufID);
      $url = user_switching::switch_to_url($user);
      $actions['otherActions']['switch'] = array(
        'title' => '<i class="crm-i fa-address-book-o"></i>&nbsp;' . E::ts('Se connecter en tant que'),
        'weight' => 999,
        'ref' => 'switch',
        'key' => 'switch',
        'href' => $url,
        'class' => 'no-popup'
      );
    }
  }

}

//function userswitchcrm_civicrm_navigationMenu(&$menu) {
//  _userswitchcrm_civix_insert_navigation_menu($menu, 'Mailings', array(
//    'label' => E::ts('New subliminal message'),
//    'name' => 'mailing_subliminal_message',
//    'url' => 'civicrm/mailing/subliminal',
//    'permission' => 'access CiviMail',
//    'operator' => 'OR',
//    'separator' => 0,
//  ));
//  _userswitchcrm_civix_navigationMenu($menu);
//}
