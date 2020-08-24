<?php

/**
 * @package       ExpressPay Payment Module for OpenCart
 * @author        ООО "ТриИнком" <info@express-pay.by>
 * @copyright     (c) 2019 Экспресс Платежи. Все права защищены.
 */

class ControllerExtensionPaymentEposExpresspay extends Controller
{
  private $error = array();

  public function index()
  {

    $this->loadResource();

    $this->document->setTitle($this->language->get('heading_title'));

    if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
      //var_dump($this->request->post);

      $this->model_setting_setting->editSetting('payment_epos_expresspay', $this->request->post);

      $this->session->data['success'] = $this->language->get('text_success');

      //exit(1);

      $this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true));
    }

    $data = array();

    $data = $this->setBreadcrumbs($data);

    $data = $this->setButtons($data);

    $data = $this->model_extension_payment_epos_expresspay->setParametersFromConfig($this->config, $this->request->post, $data);

    $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

    $data['user_token'] = $this->session->data['user_token'];

    $data = $this->setController($data);

    $this->response->setOutput($this->load->view('extension/payment/epos_expresspay', $data));
  }

  private function validate()
  {
    /*if (!$this->user->hasPermission('modify', 'extension/payment/epos_expresspay')) {
      $this->error['warning'] = $this->language->get('errorPermission');
    }

    // Empty Token
    if(!isset($this->request->post['eposExpressPayToken']))
    {
      $this->error['eposExpressPayToken'] = $this->language->get('eposExpressPayTokenError');
    }
    //Empty ServiceId
    if(!isset($this->request->post['eposExpressPayServiceId']))
    {
      $this->error['eposExpressPayServiceId'] = $this->language->get('eposExpressPayServiceIdError');
    }
    */
    return true;
  }

  private function setButtons($data)
  {

    $data['action'] = $this->url->link('extension/payment/epos_expresspay', 'user_token=' . $this->session->data['user_token'], true);

    $data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token']  . '&type=payment', true);

    return $data;
  }

  private function setController($data)
  {

    $data['header'] = $this->load->controller('common/header');
    $data['column_left'] = $this->load->controller('common/column_left');
    $data['footer'] = $this->load->controller('common/footer');

    return $data;
  }

  private function setBreadcrumbs($data)
  {
    $data['breadcrumbs'] = array();

    $data['breadcrumbs'][] = array(
      'text'      => $this->language->get('text_home'),
      'href'      =>  $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true),
      'separator' => false
    );

    $data['breadcrumbs'][] = array(
      'text' => $this->language->get('text_extension'),
      'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true)
    );

    $data['breadcrumbs'][] = array(
      'text'      => $this->language->get('heading_title'),
      'href'      => $this->url->link('extension/payment/epos_expresspay', 'user_token=' . $this->session->data['user_token'], true),
      'separator' => ' :: '
    );

    return $data;
  }

  private function setLanguageLable($data)
  {
    $data['heading_title'] = $this->language->get('heading_title');
    $data['text_edit'] = $this->language->get('text_edit');

    $data['text_live_mode'] = $this->language->get('text_live_mode');
    $data['text_test_mode'] = $this->language->get('text_test_mode');
    $data['text_enabled'] = $this->language->get('text_enabled');
    $data['text_disabled'] = $this->language->get('text_disabled');
    $data['text_all_zones'] = $this->language->get('text_all_zones');

    $data['entry_email'] = $this->language->get('entry_email');
    $data['entry_order_status'] = $this->language->get('entry_order_status');
    $data['entry_order_status_completed_text'] = $this->language->get('entry_order_status_completed_text');
    $data['entry_order_status_pending'] = $this->language->get('entry_order_status_pending');
    $data['entry_order_status_canceled'] = $this->language->get('entry_order_status_canceled');
    $data['entry_order_status_failed'] = $this->language->get('entry_order_status_failed');
    $data['entry_order_status_failed_text'] = $this->language->get('entry_order_status_failed_text');
    $data['entry_order_status_processing'] = $this->language->get('entry_order_status_processing');
    $data['entry_geo_zone'] = $this->language->get('entry_geo_zone');
    $data['entry_status'] = $this->language->get('entry_status');
    $data['entry_sort_order'] = $this->language->get('entry_sort_order');
    $data['entry_companyid'] = $this->language->get('entry_companyid');
    $data['entry_companyid_help'] = $this->language->get('entry_companyid_help');
    $data['entry_encyptionkey'] = $this->language->get('entry_encyptionkey');
    $data['entry_encyptionkey_help'] = $this->language->get('entry_encyptionkey_help');
    $data['entry_domain_payment_page'] = $this->language->get('entry_domain_payment_page');
    $data['entry_domain_payment_page_help'] = $this->language->get('entry_domain_payment_page_help');
    $data['entry_payment_type'] = $this->language->get('entry_payment_type');
    $data['button_save'] = $this->language->get('button_save');
    $data['button_cancel'] = $this->language->get('button_cancel');
    $data['tab_general'] = $this->language->get('tab_general');
  }


  private function getBreadcrumbs()
  {
    return array();
  }

  private function loadResource()
  {

    $this->load->model('extension/payment/epos_expresspay');

    $this->load->language('extension/payment/epos_expresspay');

    $this->load->model('setting/setting');

    $this->load->model('localisation/order_status');
  }
}
