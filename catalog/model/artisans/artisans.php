<?php
class ModelArtisansArtisans extends Model {

	public function addArtisan($customer_id, $business_name, $email, $telephone, $address, $city, $state, $country, $service, $service_description) {
		
		$type = $this->alreadyRegistered($customer_id);
		
		// if user have not been added before
		if ($type == []) {
			
			$this->db->query( sprintf("INSERT INTO " . DB_PREFIX . "artisans_tbl (customer_id, business_name, email, telephone, address, city ,state, country, service, service_description) VALUES (%d, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')", (int)$this->db->escape($customer_id), $this->db->escape($business_name), $this->db->escape($email), $this->db->escape($telephone), $this->db->escape($address), $this->db->escape($city), $this->db->escape($state), $this->db->escape($country), $this->db->escape($service), $this->db->escape($service_description) ));

			$affected = $this->db->countAffected();

			if ($affected > 0) {
				$this->db->query( sprintf("INSERT INTO " . DB_PREFIX . "artisan_wholeseller_tbl (customer_id, type) VALUES (%d, '%s')", $customer_id, "ARTISAN") );

				return true;
			}
	
			return false;
		}

		// else if the user is already registered
		else if (is_array($type) && $type != [] ) {
			return false;
		}

	}

	public function getArtisan($customer_id) {
		$query = $this->db->query( "SELECT * FROM " . DB_PREFIX . "artisans_tbl WHERE customer_id = " . (int)$this->db->escape($customer_id) );

		return $query->row;
	}

	public function getArtisans() {
		$query = $this->db->query( "SELECT * FROM " . DB_PREFIX . "artisans_tbl" );

		return $query->rows;
	}

	public function searchArtisans($query) {
		$query = $this->db->query( "SELECT * FROM " . DB_PREFIX . "artisans_tbl WHERE business_name LIKE '%" . (string)$this->db->escape($query) . "%' OR service LIKE '%" . (string)$this->db->escape($query) . "%' OR service_description LIKE '%" . (string)$this->db->escape($query) . "%'" );

		return $query->rows;
	}

	public function findArtisansByCity($city) {
		$query = $this->db->query( "SELECT * FROM " . DB_PREFIX . "artisans_tbl WHERE city LIKE '%" . (string)$this->db->escape($city) . "%' OR address LIKE '%" . (string)$this->db->escape($city) . "%'" );

		return $query->rows;
	}

	public function updateArtisan($customer_id, $business_name, $email, $telephone, $address, $city, $state, $country, $service, $service_description) {
		
		$this->db->query( sprintf("UPDATE " . DB_PREFIX . "artisans_tbl SET business_name = '%s', email = '%s', telephone = '%s', address = '%s', city = '%s', state = '%s', country = '%s', service = '%s', service_description = '%s' WHERE customer_id = %d", $this->db->escape($business_name), $this->db->escape($email), $this->db->escape($telephone), $this->db->escape($address), $this->db->escape($city), $this->db->escape($state), $this->db->escape($country), $this->db->escape($service), $this->db->escape($service_description), (int)$this->db->escape($customer_id) ));

		$affected = $this->db->countAffected();

		return $affected > 0 ? true : false;
		
	}

	public function deleteArtisan($customer_id) {

		$this->db->query( "DELETE FROM " . DB_PREFIX . "artisans_tbl WHERE customer_id = " . (int)$this->db->escape($customer_id) );

		$affected = $this->db->countAffected();

		if ($affected > 0) {
			$this->db->query( "DELETE FROM " . DB_PREFIX . "artisan_wholeseller_tbl WHERE customer_id = " . (int)$this->db->escape($customer_id) );

			return true;
		}

		return false;
	}

	private function alreadyRegistered($customer_id) {

		$query = $this->db->query("SELECT type FROM " . DB_PREFIX . "artisan_wholeseller_tbl WHERE customer_id = " . (int)$this->db->escape($customer_id) );

		return $query->row;
	}
}

?>