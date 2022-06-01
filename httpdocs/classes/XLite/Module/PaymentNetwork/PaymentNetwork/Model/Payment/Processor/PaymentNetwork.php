<?php

/**
 * Copyright (c) 2016-present PaymentNetwork. All rights reserved.
 *
 */

namespace XLite\Module\PaymentNetwork\PaymentNetwork\Model\Payment\Processor;

/**
 * PaymentNetwork hosted integration
 *
 * @author PaymentNetwork ltd <support@example.com>
 */
class PaymentNetwork extends \XLite\Model\Payment\Base\WebBased {

  const GATEWAYURL = "https://gateway.example.com/hosted/";

  /**
   * Get operation types
   *
   * @return array
   */
  public function getOperationTypes(){
    return array(
      self::OPERATION_SALE,
    );
  }

  /**
   * Check PaymentNetwork module is configured or not
   *
   * @param \XLite\Model\Payment\Method $method Payment method
   *
   * @return boolean
   */
  public function isConfigured(\XLite\Model\Payment\Method $method){
    return parent::isConfigured($method)
      && $method->getSetting('merchantID')
      && $method->getSetting('signatureKey')
      && $method->getSetting('currencyCode')
      && $method->getSetting('countryCode');
  }

  /**
   * Get return type
   *
   * @return string
   */
  public function getReturnType() {
    return self::RETURN_TYPE_HTML_REDIRECT;
  }

  /**
   * Returns the list of settings available for this payment processor
   *
   * @return array
   */
  public function getAvailableSettings() {
    return array(
      'merchantID',
      'signatureKey',
      'customForm',
      'formResponsive',
      'currencyCode',
      'countryCode',
    );
  }

  /**
   * Process return
   *
   * @param \XLite\Model\Payment\Transaction $transaction
   *
   * @return void
   */
  public function processReturn(\XLite\Model\Payment\Transaction $transaction) {
    parent::processReturn($transaction);

    $response = \XLite\Core\Request::getInstance();

    if (isset($response->responseCode) && $response->responseCode == 0) {
      $this->setDetail('transId', $response->xref, 'Transaction ID');
      $this->transaction->setNote($response->authorisationCode);
      $status = $transaction::STATUS_SUCCESS;
    } else {
      $status = $transaction::STATUS_FAILED;
      $this->transaction->setNote($response->responseMessage);
    }

    if ($request->authorisationCode) {
      $this->setDetail('authCode', $request->authorisationCode, 'Auth code');
    }

    if (!$this->checkTotal($request->amountReceived)) {
      $status = $transaction::STATUS_FAILED;
    }

    $this->transaction->setStatus($status);

  }

  /**
   * Get settings widget or template
   *
   * @return string Widget class name or template path
   */
  public function getSettingsWidget() {
    return 'modules/PaymentNetwork/PaymentNetwork/config.twig';
  }

  /**
   * Get payment method admin zone icon URL
   *
   * @param \XLite\Model\Payment\Method $method Payment method
   *
   * @return string
   */
  public function getAdminIconURL(\XLite\Model\Payment\Method $method) {
     return true;
  }

  /**
   * Get form url
   *
   * @return string Gateway URL
   */
  protected function getFormURL() {
    return ($this->getSetting('customForm') != '') ? $this->getSetting('customForm') : self::GATEWAYURL;
  }

  /**
   * Get transaction request
   *
   * @return string POST request
   */
  protected function getFormFields() {

    $key = $this->getSetting('signatureKey');

    $fields = array(
      'merchantID'        => $this->getSetting('merchantID'),
      'type'              => 1,
      'action'            => 'SALE',
      'currencyCode'      => $this->getSetting('currencyCode'),
      'countryCode'       => $this->getSetting('countryCode'),
      'amount'            => $this->transaction->getValue()*100,
      'transactionUnique' => $this->getTransactionId(),
      'orderRef'          => $this->getTransactionId(),
      'customerName'      => $this->getCustomerName(),
      'customerAddress'   => $this->getCustomerAddress(),
      'customerPostcode'  => $this->getProfile()->getBillingAddress()->getZipcode(),
      'customerPhone'     => $this->getProfile()->getBillingAddress()->getPhone(),
      'customerEmail'     => $this->getProfile()->getLogin(),
      'redirectURL'       => $this->getReturnURL('transactionUnique'),
      'merchantData'      => 'X-Cart 5',
      'formResponsive'    => $this->getSetting('formResponsive'),
    );

    // Sort by field name
    ksort($fields);

    // Create the URL encoded signature string
    $ret = http_build_query($fields, '', '&');

    // Normalise all line endings (CRNL|NLCR|NL|CR) to just NL (%0A)
    $ret = str_replace(array('%0D%0A', '%0A%0D', '%0D'), '%0A', $ret);

    // Hash the signature string and the key together
    $ret = hash("SHA512", $ret . $key);

    // Return the signature
    $fields['signature'] = $ret;

    return $fields;

  }

  /**
   * Get customer name
   *
   * @return string Customer Name
   */
  protected function getCustomerName() {
    return $this->getProfile()->getBillingAddress()->getFirstname() .
    ' ' . $this->getProfile()->getBillingAddress()->getLastname();
  }

  /**
   * Get customer address
   *
   * @return string Customer Address
   */
  protected function getCustomerAddress() {
    return $this->getProfile()->getBillingAddress()->getStreet() . PHP_EOL .
    $this->getProfile()->getBillingAddress()->getCity() . PHP_EOL .
    $this->getProfile()->getBillingAddress()->getCountry()->getCountry();
  }
}

?>
