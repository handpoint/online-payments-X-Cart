<?php

/**
 * X-Cart
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the software license agreement
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.x-cart.com/license-agreement.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to licensing@x-cart.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not modify this file if you wish to upgrade X-Cart to newer versions
 * in the future. If you wish to customize X-Cart for your needs please
 * refer to http://www.x-cart.com/ for more information.
 *
 * @category  X-Cart 5
 * @author    PaymentNetwork Ltd <support@example.com>
 * @copyright Copyright (c) 2016-present PaymentNetwork Ltd <support@example.com>. All rights reserved
 * @license   http://www.x-cart.com/license-agreement.html X-Cart 5 License Agreement
 * @link      http://www.x-cart.com/
 */

namespace XLite\Module\PaymentNetwork\PaymentNetwork;

abstract class Main extends \XLite\Module\AModule {

  /**
   * Author name
   *
   * @return string
   */
  public static function getAuthorName() {
    return 'PaymentNetwork';
  }

  /**
   * Module name
   *
   * @return string
   */
  public static function getModuleName() {
    return 'PaymentNetwork Hosted';
  }

  /**
   * Get module major version
   *
   * @return string
   */
  public static function getMajorVersion() {
    return '5.3';
  }

  /**
   * Module version
   *
   * @return string
   */
  public static function getMinorVersion() {
    return '1';
  }

  /**
   * Module description
   *
   * @return string
   */
  public static function getDescription() {
    return 'Adds the ability to take card payments for your online store ' .
           'via PaymentNetwork Hosted Payment Gateway.';
  }

  /**
   * The module type
   *
   * @return integer|null
   */
  public static function getModuleType() {
    return static::MODULE_TYPE_PAYMENT;
  }
}
