<?php

class ModelExtensionPaymentTpay extends Model
{
    public function getMethod($address, $total)
    {
        $this->load->language('extension/payment/tpay');

        $this->config->get('payment_tpay_status') && $total >= 0.00
        && $this->session->data['currency'] == $this->config->get('tpay_currency')
            ? $status = true : $status = false;

        $method_data = array();

        if ($status) {
            $method_data = array(
                'code'       => 'tpay',
                'title'      => $this->language->get('text_title'),
                'sort_order' => $this->config->get('payment_tpay_sort_order'),
                'terms'      => ''
            );
        }

        return $method_data;
    }
}

?>
