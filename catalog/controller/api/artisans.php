<?php
class ControllerApiArtisans extends Controller {
	public function index() {
		// load the language for i18n & l10n
		$this->load->language('api/artisans');

		// Delete past customer in case there is an error
		unset($this->session->data['customer']);

		$json = array();

		if (!isset($this->session->data['api_id'])) {
			$json['error']['warning'] = $this->language->get('error_permission');
		} else {

			// to load model file, use $this->load->model('directory/filname');
			$this->load->model('artisans/artisans');

			// to call model methods, use $this->model_directory_filename->method(args);
			$rows = $this->model_artisans_artisans->getArtisans();
			
			if ($rows) {
				$json['success']['data'] = $rows;
			} else {
				$json['error']['message'] = $this->language->get('error_get_artisans');
			}

		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function add() {
		// load the language for i18n & l10n
		$this->load->language('api/artisans');

		// Delete past customer in case there is an error
		unset($this->session->data['customer']);

		$json = array();

		if (!isset($this->session->data['api_id'])) {
			$json['error']['warning'] = $this->language->get('error_permission');
		} else {
			// get the fields and trim them
			$fields = Array(
				"customer_id",
				"business_name",
				"email",
				"telephone",
				"address",
				"city",
				"state",
				"country",
				"service",
				"service_description"
			);

			// trim
			foreach ($fields as $field) {
				$this->request->post[$field] = isset($this->request->post[$field]) ? trim($this->request->post[$field]) : '';
			}
			extract($this->request->post);

			$json = Array();

			// validation
			// customer_id
			if ($customer_id) {
				$this->load->model('account/customer');
	
				$customer_info = $this->model_account_customer->getCustomer($customer_id);
				
				if (!$customer_info || !$this->customer->login($customer_info['email'], '', true)) {
					$json['error']['warning'] = $this->language->get('error_customer');
				}
			} else {
				$json['error']['warning'] = $this->language->get('error_customer');
			}
	
			// business name
			if ((utf8_strlen(trim($business_name)) < 1) || (utf8_strlen(trim($business_name)) > 100)) {
				$json['error']['business_name'] = $this->language->get('error_business_name');
			}
	
			// email
			if ((utf8_strlen($email) > 96) || (!filter_var($email, FILTER_VALIDATE_EMAIL))) {
				$json['error']['email'] = $this->language->get('error_email');
			}
	
			// telephone
			if ((utf8_strlen($telephone) < 3) || (utf8_strlen($telephone) > 32)) {
				$json['error']['telephone'] = $this->language->get('error_telephone');
			}
	
			// address
			if ((utf8_strlen($address) < 1) || (utf8_strlen($address) > 100)) {
				$json['error']['address'] = $this->language->get('error_address');
			}
	
			// city
			if ((utf8_strlen($city) < 1) || (utf8_strlen($city) > 40)) {
				$json['error']['city'] = $this->language->get('error_city');
			}
	
			// state
			if ((utf8_strlen($state) < 1) || (utf8_strlen($state) > 40)) {
				$json['error']['state'] = $this->language->get('error_state');
			}
	
			// country
			if ((utf8_strlen($country) < 1) || (utf8_strlen($country) > 40)) {
				$json['error']['country'] = $this->language->get('error_country');
			}
	
			// service
			if ((utf8_strlen($service) < 1) || (utf8_strlen($service) > 40)) {
				$json['error']['service'] = $this->language->get('error_service');
			}
	
			// service_description
			if ((utf8_strlen($service_description) < 1) || (utf8_strlen($service_description) > 100)) {
				$json['error']['service_description'] = $this->language->get('error_service_description');
			}

			if (!$json) {
				// to load model file, use $this->load->model('directory/filname');
				$this->load->model('artisans/artisans');

				// to call model methods, use $this->model_directory_filename->method(args);
				$status = $this->model_artisans_artisans->addArtisan(
					$customer_id, $business_name, $email, $telephone, $address, $city, $state, $country, $service, $service_description
				);

				//sprintf($this->language->get('text_success'), "an Artisan.");

				if ($status) {
					$json['success']['message'] = sprintf($this->language->get('success_registered'), "an Artisan.");
					$json['success']['customer_id'] = $customer_id;
				} else {
					$json['error']['registeration'] = $this->language->get('error_registeration');
				}
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));

	}

	public function get() {
		// load the language for i18n & l10n
		$this->load->language('api/artisans');

		// Delete past customer in case there is an error
		unset($this->session->data['customer']);

		$json = array();

		if (!isset($this->session->data['api_id'])) {
			$json['error']['warning'] = $this->language->get('error_permission');
		} else {

			extract($this->request->get);

			// validate the customer
			if ($customer_id) {
				$this->load->model('account/customer');
	
				$customer_info = $this->model_account_customer->getCustomer($customer_id);
				
				if (!$customer_info || !$this->customer->login($customer_info['email'], '', true)) {
					$json['error']['warning'] = $this->language->get('error_customer');
				}
			} else {
				$json['error']['warning'] = $this->language->get('error_customer');
			}

			if (!$json) {
				// to load model file, use $this->load->model('directory/filname');
				$this->load->model('artisans/artisans');

				// to call model methods, use $this->model_directory_filename->method(args);
				$row = $this->model_artisans_artisans->getArtisan($customer_id);
				
				if ($row) {
					$json['success']['data'] = $row;
				} else {
					$json['error']['message'] = $this->language->get('error_get_artisan');
				}
			}

		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function search() {
		// load the language for i18n & l10n
		$this->load->language('api/artisans');

		// Delete past customer in case there is an error
		unset($this->session->data['customer']);

		$json = array();

		if (!isset($this->session->data['api_id'])) {
			$json['error']['warning'] = $this->language->get('error_permission');
		} else {

			// get search query
			extract($this->request->get);
			$query = trim($query);
			
			if (utf8_strlen(trim($query)) < 1) {
				$json['error']['query'] = $this->language->get('error_search');
			}
			
			if (!$json) {
				// to load model file, use $this->load->model('directory/filname');
				$this->load->model('artisans/artisans');

				// to call model methods, use $this->model_directory_filename->method(args);
				$rows = $this->model_artisans_artisans->searchArtisans($query);
				
				if ($rows) {
					$json['success']['data'] = $rows;
				} else {
					$json['error']['message'] = $this->language->get('error_search_artisans');
				}
			}

		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function find() {
		// load the language for i18n & l10n
		$this->load->language('api/artisans');

		// Delete past customer in case there is an error
		unset($this->session->data['customer']);

		$json = array();

		if (!isset($this->session->data['api_id'])) {
			$json['error']['warning'] = $this->language->get('error_permission');
		} else {

			// get search query
			extract($this->request->get);
			$query = trim($city);

			if (utf8_strlen(trim($city)) < 1) {
				$json['error']['city'] = $this->language->get('error_find');
			}
			
			if (!$json) {
				// to load model file, use $this->load->model('directory/filname');
				$this->load->model('artisans/artisans');

				// to call model methods, use $this->model_directory_filename->method(args);
				$rows = $this->model_artisans_artisans->findArtisansByCity($city);
				
				if ($rows) {
					$json['success']['data'] = $rows;
				} else {
					$json['error']['message'] = $this->language->get('error_search_artisans');
				}
			}

		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function update() {
		// load the language for i18n & l10n
		$this->load->language('api/artisans');

		// Delete past customer in case there is an error
		unset($this->session->data['customer']);

		$json = array();

		if (!isset($this->session->data['api_id'])) {
			$json['error']['warning'] = $this->language->get('error_permission');
		} else {

			// get the fields and trim them
			$fields = Array(
				"customer_id",
				"business_name",
				"email",
				"telephone",
				"address",
				"city",
				"state",
				"country",
				"service",
				"service_description"
			);

			// trim
			foreach ($fields as $field) {
				$this->request->post[$field] = isset($this->request->post[$field]) ? trim($this->request->post[$field]) : '';
			}
			extract($this->request->post);

			$json = Array();

			// validation
			// customer_id
			if ($customer_id) {
				$this->load->model('account/customer');
	
				$customer_info = $this->model_account_customer->getCustomer($customer_id);
				
				if (!$customer_info || !$this->customer->login($customer_info['email'], '', true)) {
					$json['error']['warning'] = $this->language->get('error_customer');
				}
			} else {
				$json['error']['warning'] = $this->language->get('error_customer');
			}
	
			// business name
			if ((utf8_strlen(trim($business_name)) < 1) || (utf8_strlen(trim($business_name)) > 100)) {
				$json['error']['business_name'] = $this->language->get('error_business_name');
			}
	
			// email
			if ((utf8_strlen($email) > 96) || (!filter_var($email, FILTER_VALIDATE_EMAIL))) {
				$json['error']['email'] = $this->language->get('error_email');
			}
	
			// telephone
			if ((utf8_strlen($telephone) < 3) || (utf8_strlen($telephone) > 32)) {
				$json['error']['telephone'] = $this->language->get('error_telephone');
			}
	
			// address
			if ((utf8_strlen($address) < 1) || (utf8_strlen($address) > 100)) {
				$json['error']['address'] = $this->language->get('error_address');
			}
	
			// city
			if ((utf8_strlen($city) < 1) || (utf8_strlen($city) > 40)) {
				$json['error']['city'] = $this->language->get('error_city');
			}
	
			// state
			if ((utf8_strlen($state) < 1) || (utf8_strlen($state) > 40)) {
				$json['error']['state'] = $this->language->get('error_state');
			}
	
			// country
			if ((utf8_strlen($country) < 1) || (utf8_strlen($country) > 40)) {
				$json['error']['country'] = $this->language->get('error_country');
			}
	
			// service
			if ((utf8_strlen($service) < 1) || (utf8_strlen($service) > 40)) {
				$json['error']['service'] = $this->language->get('error_service');
			}
	
			// service_description
			if ((utf8_strlen($service_description) < 1) || (utf8_strlen($service_description) > 100)) {
				$json['error']['service_description'] = $this->language->get('error_service_description');
			}

			if (!$json) {
				// to load model file, use $this->load->model('directory/filname');
				$this->load->model('artisans/artisans');

				// to call model methods, use $this->model_directory_filename->method(args);
				$status = $this->model_artisans_artisans->updateArtisan(
					$customer_id, $business_name, $email, $telephone, $address, $city, $state, $country, $service, $service_description
				);

				if ($status) {
					$json['success']['message'] = sprintf($this->language->get('success_update'), "an Artisan.");

					$artisan = $this->model_artisans_artisans->getArtisan($customer_id);

					// get the customer data 
					$json['success']['artisan'] = $artisan;
				} else {
					$json['error']['update'] = $this->language->get('error_update');
				}
			}

		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));

	}

	public function delete() {
		// load the language for i18n & l10n
		$this->load->language('api/artisans');

		// Delete past customer in case there is an error
		unset($this->session->data['customer']);

		$json = array();

		if (!isset($this->session->data['api_id'])) {
			$json['error']['warning'] = $this->language->get('error_permission');
		} else {

			extract($this->request->get);

			// validate the customer
			if ($customer_id) {
				$this->load->model('account/customer');
	
				$customer_info = $this->model_account_customer->getCustomer($customer_id);
				
				if (!$customer_info || !$this->customer->login($customer_info['email'], '', true)) {
					$json['error']['warning'] = $this->language->get('error_customer');
				}
			} else {
				$json['error']['warning'] = $this->language->get('error_customer');
			}

			if (!$json) {
				// to load model file, use $this->load->model('directory/filname');
				$this->load->model('artisans/artisans');

				// to call model methods, use $this->model_directory_filename->method(args);
				$status = $this->model_artisans_artisans->deleteArtisan($customer_id);
				
				if ($status) {
					$json['success']['message'] = sprintf($this->language->get('success_delete_artisan'),"an Artisan");
				} else {
					$json['error']['message'] = $this->language->get('error_delete_artisan');
				}
			}

		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

}

?>