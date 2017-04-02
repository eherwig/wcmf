<?php
/**
 * wCMF - wemove Content Management Framework
 * Copyright (C) 2005-2017 wemove digital solutions GmbH
 *
 * Licensed under the terms of the MIT License.
 *
 * See the LICENSE file distributed with this work for
 * additional information.
 */
namespace wcmf\application\controller;

use wcmf\lib\config\Configuration;
use wcmf\lib\core\IllegalArgumentException;
use wcmf\lib\core\Session;
use wcmf\lib\i18n\Localization;
use wcmf\lib\i18n\Message;
use wcmf\lib\model\Node;
use wcmf\lib\persistence\PersistenceAction;
use wcmf\lib\persistence\PersistenceFacade;
use wcmf\lib\presentation\ActionMapper;
use wcmf\lib\presentation\ApplicationError;
use wcmf\lib\presentation\Controller;
use wcmf\lib\security\PermissionManager;
use wcmf\lib\security\principal\PrincipalFactory;
use wcmf\lib\security\principal\User;

/**
 * UserController is used to change the current user's password.
 *
 * The controller supports the following actions:
 *
 * <div class="controller-action">
 * <div> __Action__ _default_ </div>
 * <div>
 * Handle actions regarding the current user
 *
 * For details about the parameters, see documentation of the methods.
 *
 * | __Response Actions__   | |
 * |------------------------|-------------------------
 * | `ok`                   | In all cases
 * </div>
 * </div>
 *
 * @author ingo herwig <ingo@wemove.com>
 */
class UserController extends Controller {
  use \wcmf\lib\presentation\ControllerMethods;

  private $principalFactory = null;

  /**
   * Constructor
   * @param $session
   * @param $persistenceFacade
   * @param $permissionManager
   * @param $actionMapper
   * @param $localization
   * @param $message
   * @param $configuration
   * @param $principalFactory
   */
  public function __construct(Session $session,
          PersistenceFacade $persistenceFacade,
          PermissionManager $permissionManager,
          ActionMapper $actionMapper,
          Localization $localization,
          Message $message,
          Configuration $configuration,
          PrincipalFactory $principalFactory) {
    parent::__construct($session, $persistenceFacade, $permissionManager,
            $actionMapper, $localization, $message, $configuration);
    $this->principalFactory = $principalFactory;
  }

  /**
   * Change the user's password
   *
   * | Parameter           | Description
   * |---------------------|----------------------
   * | _in_ `oldpassword`  | The old password
   * | _in_ `newpassword1` | The new password
   * | _in_ `newpassword2` | The new password
   */
  public function changePassword() {
    $session = $this->getSession();
    $permissionManager = $this->getPermissionManager();
    $persistenceFacade = $this->getPersistenceFacade();
    $request = $this->getRequest();
    $response = $this->getResponse();

    // load model
    $authUser = $this->principalFactory->getUser($session->getAuthUser());
    if ($authUser) {
      // add permissions for this operation
      $oidStr = $authUser->getOID()->__toString();
      $tmpPerm1 = $permissionManager->addTempPermission($oidStr, '', PersistenceAction::READ);
      $tmpPerm2 = $permissionManager->addTempPermission($oidStr, '', PersistenceAction::UPDATE);

      // start the persistence transaction
      $transaction = $persistenceFacade->getTransaction();
      $transaction->begin();
      try {
        $this->changePasswordImpl($authUser, $request->getValue('oldpassword'),
          $request->getValue('newpassword1'), $request->getValue('newpassword2'));
        $transaction->commit();
      }
      catch(\Exception $ex) {
        $response->addError(ApplicationError::fromException($ex));
        $transaction->rollback();
      }
      // remove temporary permissions
      $permissionManager->removeTempPermission($tmpPerm1);
      $permissionManager->removeTempPermission($tmpPerm2);
    }
    // success
    $response->setAction('ok');
  }


  /**
   * Set a configuration for the user
   *
   * | Parameter    | Description
   * |--------------|-----------------------------
   * | _in_ `name`  | The configuration name
   * | _in_ `value` | The configuration value
   */
  public function setConfigValue() {
    $session = $this->getSession();
    $request = $this->getRequest();
    $response = $this->getResponse();
    $persistenceFacade = $this->getPersistenceFacade();
    $transaction = $this->getPersistenceFacade()->getTransaction();

    // load model
    $transaction->begin();
    $authUser = $this->principalFactory->getUser($session->getAuthUser());
    if ($authUser) {
      $configKey = $request->getValue('name');
      $configValue = $request->getValue('value');

      // find configuration
      $configObj = null;
      $configList = Node::filter($authUser->getValue('UserConfig'), null, null,
              ['name' => $configKey]);
      if (sizeof($configList) > 0) {
        $configObj = $configList[0];
      }
      else {
        $configObj = $persistenceFacade->create('UserConfig');
        $configObj->setValue('name', $configKey);
        $authUser->addNode($configObj);
      }

      // set value
      if ($configObj != null) {
        $configObj->setValue('value', $configValue);
      }
    }
    $transaction->commit();

    // success
    $response->setAction('ok');
  }

  /**
   * Get a configuration for the user
   *
   * | Parameter     | Description
   * |---------------|----------------------------
   * | _in_ `name`   | The configuration name
   * | _out_ `value` | The configuration value
   */
  public function getConfigValue() {
    $session = $this->getSession();
    $request = $this->getRequest();
    $response = $this->getResponse();

    // load model
    $authUser = $this->principalFactory->getUser($session->getAuthUser());
    if ($authUser) {
      $configKey = $request->getValue('name');

      // find configuration
      $configObj = null;
      $configList = Node::filter($authUser->getValue('UserConfig'), null, null,
              ['name' => $configKey]);
      $configValue = sizeof($configList) > 0 ?
              $configObj = $configList[0]->getValue('value') : null;
      $response->setValue('value', $configValue);
    }
    // success
    $response->setAction('ok');
  }

  /**
   * Change a users password.
   * @param $user The User instance
   * @param $oldPassword The old password of the user
   * @param $newPassword The new password for the user
   * @param $newPasswordRepeated The new password of the user again
   */
  protected function changePasswordImpl(User $user, $oldPassword, $newPassword, $newPasswordRepeated) {
    $message = $this->getMessage();
    // check old password
    if (!$user->verifyPassword($oldPassword)) {
      throw new IllegalArgumentException($message->getText("The old password is incorrect"));
    }
    if (strlen($newPassword) == 0) {
      throw new IllegalArgumentException($message->getText("The password can't be empty"));
    }
    if ($newPassword != $newPasswordRepeated) {
      throw new IllegalArgumentException($message->getText("The given passwords don't match"));
    }
    // set password
    $user->setPassword($newPassword);
  }
}
?>
