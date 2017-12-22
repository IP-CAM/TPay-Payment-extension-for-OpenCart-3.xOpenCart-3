<?php

class ControllerExtensionPaymentTpay extends Controller
{
	private $error = array();

	public function index()
	{
		$this->load->language('extension/payment/tpay');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('setting/setting');

		if ($this->request->server['REQUEST_METHOD'] == 'POST' && $this->validate())
		{
			$this->load->model('setting/setting');
			$this->model_setting_setting->editSetting('payment_tpay', $this->request->post);
			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment', true));
		}

		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_tpay_status']	= $this->language->get('entry_tpay_status');
		$data['entry_tpay_status_yes'] = $this->language->get('entry_tpay_status_yes');
		$data['entry_tpay_status_no'] = $this->language->get('entry_tpay_status_no');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');


		$data['entry_settings_seller'] = $this->language->get('entry_settings_seller');
		$data['entry_tpay_seller_id'] = $this->language->get('entry_tpay_seller_id');
		$data['entry_tpay_conf_code'] = $this->language->get('entry_tpay_conf_code');
		$data['entry_tpay_conf_code_hint'] = $this->language->get('entry_tpay_conf_code_hint');

		$data['entry_settings_orders'] = $this->language->get('entry_settings_orders');
		$data['entry_tpay_currency'] = $this->language->get('entry_tpay_currency');
		$data['entry_tpay_order_status_error'] = $this->language->get('entry_tpay_order_status_error');
		$data['entry_tpay_order_status_completed'] = $this->language->get('entry_tpay_order_status_completed');
		$data['entry_tpay_new_order'] = $this->language->get('entry_tpay_new_order');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['tab_general'] = $this->language->get('tab_general');

		$data['error_warning'] = (isset($this->error['warning']) ? $this->error['warning'] : '');
		$data['error_merchant'] = (isset($this->error['merchant']) ? $this->error['merchant'] : '');
		$data['error_password'] = (isset($this->error['password']) ? $this->error['password'] : '');

		$data['entry_view_settings'] = $this->language->get('entry_view_settings');
		$data['entry_tpay_payment_place'] = $this->language->get('entry_tpay_payment_place');
		$data['entry_tpay_payment_place_0'] = $this->language->get('entry_tpay_payment_place_0');
		$data['entry_tpay_payment_place_1'] = $this->language->get('entry_tpay_payment_place_1');

		$data['entry_tpay_payment_view'] = $this->language->get('entry_tpay_payment_view');
		$data['entry_tpay_payment_view_0'] = $this->language->get('entry_tpay_payment_view_0');
		$data['entry_tpay_payment_view_1'] = $this->language->get('entry_tpay_payment_view_1');

		$data['payment_tpay_order_status_error'] = (isset($this->request->post['payment_tpay_order_status_error']) ? $this->request->post['payment_tpay_order_status_error'] : $this->config->get('payment_tpay_order_status_error'));
		$data['payment_tpay_order_status_completed'] = (isset($this->request->post['payment_tpay_order_status_completed']) ? $this->request->post['payment_tpay_order_status_completed'] : $this->config->get('payment_tpay_order_status_completed'));
		$data['payment_tpay_order_status_new'] = (isset($this->request->post['payment_tpay_order_status_new']) ? $this->request->post['payment_tpay_order_status_new'] : $this->config->get('payment_tpay_order_status_new'));
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'href'      => HTTPS_SERVER . 'index.php?route=common/home&user_token=' . $this->session->data['user_token'],
			'text'      => $this->language->get('text_home'),
			'separator' => FALSE
		);

		$data['breadcrumbs'][] = array(
			'href'      => HTTPS_SERVER . 'index.php?route=extension/payment/tpay&user_token=' . $this->session->data['user_token'],
			'text'      => $this->language->get('text_payment'),
			'separator' => ' :: '
		);

		$data['breadcrumbs'][] = array(
			'href'      => HTTPS_SERVER . 'index.php?route=extension/payment/tpay&user_token=' . $this->session->data['user_token'],
			'text'      => $this->language->get('heading_title'),
			'separator' => ' :: '
		);

		$data['action'] = HTTPS_SERVER . 'index.php?route=extension/payment/tpay&user_token=' . $this->session->data['user_token'];
		$data['cancel'] = HTTPS_SERVER . 'index.php?route=extension/payment&user_token=' . $this->session->data['user_token'];


		$data['payment_tpay_status'] = (isset($this->request->post['payment_tpay_status']) ? $this->request->post['payment_tpay_status'] : $this->config->get('payment_tpay_status'));
		$data['payment_tpay_sort_order'] = (isset($this->request->post['payment_tpay_sort_order']) ? $this->request->post['payment_tpay_sort_order'] : $this->config->get('payment_tpay_sort_order'));
		$data['payment_tpay_seller_id'] = (isset($this->request->post['payment_tpay_seller_id']) ? $this->request->post['payment_tpay_seller_id'] : $this->config->get('payment_tpay_seller_id'));
		$data['payment_tpay_conf_code'] = (isset($this->request->post['payment_tpay_conf_code']) ? $this->request->post['payment_tpay_conf_code'] : $this->config->get('payment_tpay_conf_code'));
		$data['payment_tpay_payment_place'] = (isset($this->request->post['payment_tpay_payment_place']) ? $this->request->post['payment_tpay_payment_place'] : $this->config->get('payment_tpay_payment_place'));
		$data['payment_tpay_payment_view'] = (isset($this->request->post['payment_tpay_payment_view']) ? $this->request->post['payment_tpay_payment_view'] : $this->config->get('payment_tpay_payment_view'));

		$this->load->model('localisation/currency');

		for($i = 0 ; $i < 10 ; $i++){
			$currency_info = $this->model_localisation_currency->getCurrency($i);
			if (!empty($currency_info)) {
				$data['curr'][] = $currency_info['code'];
			}
		}


		$data['payment_tpay_currency'] = (isset($this->request->post['payment_tpay_currency']) ? $this->request->post['payment_tpay_currency'] : $this->config->get('payment_tpay_currency'));

		$this->load->model('localisation/order_status');
		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$this->template = 'extension/payment/tpay';
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');
		$this->response->setOutput($this->load->view('extension/payment/tpay', $data));

	}

	private function validate()
	{
		if (!$this->user->hasPermission('modify', 'extension/payment/tpay')) $this->error['warning'] = $this->language->get('error_permission');

		if (empty($this->request->post['payment_tpay_seller_id'])) $this->error['merchant'] = $this->language->get('error_merchant');
		return $this->error ? false : true;

	}
}

?>
