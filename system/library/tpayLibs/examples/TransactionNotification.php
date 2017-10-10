<?php

/*
 * Created by tpay.com
 */

namespace tpayLibs\examples;

use tpayLibs\src\_class_tpay\Notifications\BasicNotificationHandler;

include_once 'loader.php';

class TransactionNotification extends BasicNotificationHandler
{
    public function __construct($secret, $id)
    {
        $this->merchantSecret = $secret;
        $this->merchantId = $id;
        parent::__construct();

    }

}
