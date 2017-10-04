<?php

class CRM_Volunteer_Angular {

  private static $loaded = FALSE;

  /**
   * @return boolean
   */
  public static function isLoaded() {
    return self::$loaded;
  }

  /**
   * Loads dependencies for CiviVolunteer Angular app.
   *
   * @param string $defaultRoute
   *   If the base page is loaded with no route, show this one.
   */
  public static function load($defaultRoute) {
    if (self::isLoaded()) {
      return;
    }

    CRM_Core_Resources::singleton()->addScriptFile('civicrm', 'packages/jquery/plugins/jquery.notify.min.js', 10, 'html-header');

    $loader = new \Civi\Angular\AngularLoader();
    $loader->setModules(array('volunteer'));
    $loader->setPageName('civicrm/vol');
    $loader->load();
    \Civi::resources()->addSetting(array(
      'crmApp' => array(
        'defaultRoute' => $defaultRoute,
      ),
    ));

    $cvsetting = civicrm_api('Setting', 'getsingle', array(
        'version' => 3,
        'group' => 'org.civicrm.volunteer',
        'return' => array('volunteer_floating_cart_enabled','volunteer_show_cart_contents'),
      ));

    \Civi::resources()->addSetting(array('CiviVolunteer' => $cvsetting));

    self::$loaded = TRUE;
  }

}
