<?php
namespace Modules\Admin\Http\Traits;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

trait AuthorizePaymentTrait {


	public function pay($getrequestdata) {

		$refId = 'ref' . time();  	

		

		$merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
		// if($_SERVER['REMOTE_ADDR'] == '103.8.117.128' || $_SERVER['REMOTE_ADDR'] == '59.92.235.93'){
		   $merchantAuthentication->setName("8A738kghaG5");
		   $merchantAuthentication->setTransactionKey("57GHgM99b233ZEq5");
		// }else{
		//     $merchantAuthentication->setName("993QJmnY");
	    //    $merchantAuthentication->setTransactionKey("4Ra2b3YzQf79f6eY");
		// }
		
		$creditCard = new AnetAPI\CreditCardType();
		$creditCard->setCardNumber($getrequestdata['card_number']);
		$creditCard->setExpirationDate($getrequestdata['card_exp_year'].'-'.str_pad($getrequestdata['card_exp_month'], 2, '0', STR_PAD_LEFT));
		$creditCard->setCardCode($getrequestdata['cvv']);

		$paymentOne = new AnetAPI\PaymentType();
		$paymentOne->setCreditCard($creditCard);

    	// Create order information
		$order = new AnetAPI\OrderType();
		$order->setInvoiceNumber($refId);
		$order->setDescription('IdealVideo Standalone Purchase');	


		$customerAddress = new AnetAPI\CustomerAddressType();
		$customerAddress->setFirstName($getrequestdata['first_name']);
		$customerAddress->setLastName($getrequestdata['last_name']);
		$customerAddress->setCompany($getrequestdata['company_name']);
		$customerAddress->setAddress($getrequestdata['billing_address']);
		$customerAddress->setCity($getrequestdata['billing_city']);
		$customerAddress->setState($getrequestdata['billing_state']);
		$customerAddress->setZip($getrequestdata['billing_zip']);
		$customerAddress->setCountry("USA");

		$customerData = new AnetAPI\CustomerDataType();
		$customerData->setId(time());
		$customerData->setEmail($getrequestdata['email']);

		$transactionRequestType = new AnetAPI\TransactionRequestType();
		$transactionRequestType->setTransactionType("authCaptureTransaction"); 
		$transactionRequestType->setAmount($getrequestdata['amount']);
		$transactionRequestType->setOrder($order);
		$transactionRequestType->setPayment($paymentOne);
		$transactionRequestType->setBillTo($customerAddress);
		$transactionRequestType->setCustomer($customerData);


		$authrequest = new AnetAPI\CreateTransactionRequest();
		$authrequest->setMerchantAuthentication($merchantAuthentication);
		$authrequest->setTransactionRequest($transactionRequestType);
		$authrequest->setRefId($refId);

		$controller = new AnetController\CreateTransactionController($authrequest);
		$response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);
		// if($_SERVER['REMOTE_ADDR'] == '103.8.117.128' || $_SERVER['REMOTE_ADDR'] == '59.92.235.93'){
		// }else{
		// 	$response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::PRODUCTION);
		// }
		

		if ($response != null) {
        // Check to see if the API request was successfully received and acted upon
			if ($response->getMessages()->getResultCode() == "Ok") {
            // Since the API request was successful, look for a transaction response
            // and parse it to display the results of authorizing the card
				$tresponse = $response->getTransactionResponse();

				if ($tresponse != null && $tresponse->getMessages() != null) {


					return ['responsecode' => $tresponse->getResponseCode(),'response' => $tresponse ];
				} else {

					if ($tresponse->getErrors() != null) {

						return ['responsecode' => $tresponse->getErrors()[0]->getErrorCode(), 'errortext' => $tresponse->getErrors()[0]->getErrorText()];

					}
				}

			} else {

				$tresponse = $response->getTransactionResponse();

				if ($tresponse != null && $tresponse->getErrors() != null) {    

					$tresponse->getErrors()[0]->getErrorText();
					$tresponse->getErrors()[0]->getErrorCode();

					return ['responsecode' => $tresponse->getErrors()[0]->getErrorCode(), 'errortext' => $tresponse->getErrors()[0]->getErrorText()];


				} else {

					return ['responsecode' => $response->getMessages()->getMessage()[0]->getCode(), 'errortext' => $response->getMessages()->getMessage()[0]->getText()];


				}
			}      
		} else {
       // $trans->reason = 'No Response from the Gateway';

		}


	}

	

}	