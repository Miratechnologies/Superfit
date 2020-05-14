<?php
class ModelArtisansWholesellers extends Model {

	public function addWholeseller($customer_id, $business_name, $email, $telephone, $address, $city, $state, $country, $approval_status) {
		
		$type = $this->alreadyRegistered($customer_id);
		
		// if user have not been added before
		if ($type == []) {
			
			$this->db->query( sprintf("INSERT INTO " . DB_PREFIX . "wholesellers_tbl (customer_id, business_name, email, telephone, address, city ,state, country, approval_status) VALUES (%d, '%s', '%s', '%s', '%s', '%s', '%s', '%s', %d)", (int)$this->db->escape($customer_id), $this->db->escape($business_name), $this->db->escape($email), $this->db->escape($telephone), $this->db->escape($address), $this->db->escape($city), $this->db->escape($state), $this->db->escape($country), (int)$approval_status ));

			$affected = $this->db->countAffected();

			if ($affected > 0) {
				$this->db->query( sprintf("INSERT INTO " . DB_PREFIX . "artisan_wholeseller_tbl (customer_id, type) VALUES (%d, '%s')", $customer_id, "WHOLESELLER") );

				return true;
			}
	
			return false;
		}

		// else if the user is already registered
		else if (is_array($type) && $type != [] ) {
			return false;
		}

	}

	public function getWholeseller($customer_id) {
		$query = $this->db->query( "SELECT * FROM " . DB_PREFIX . "wholesellers_tbl WHERE customer_id = " . (int)$this->db->escape($customer_id) );

		return $query->row;
   }
   
	public function getWholesellers() {
		$query = $this->db->query( "SELECT * FROM " . DB_PREFIX . "wholesellers_tbl WHERE approval_status = 1" );

		return $query->rows;
	}

	public function searchWholesellers($query) {
		$query = $this->db->query( "SELECT * FROM " . DB_PREFIX . "wholesellers_tbl WHERE approval_status = 1 AND business_name LIKE '%" . (string)$this->db->escape($query) . "%'" );

		return $query->rows;
	}

	public function findWholesellersByCity($city) {
		$query = $this->db->query( "SELECT * FROM " . DB_PREFIX . "wholesellers_tbl WHERE approval_status = 1 AND (city LIKE '%" . (string)$this->db->escape($city) . "%' OR address LIKE '%" . (string)$this->db->escape($city) . "%' OR state LIKE '%" . (string)$this->db->escape($city) . "%')" );

		return $query->rows;
	}

	public function updateWholeseller($customer_id, $business_name, $email, $telephone, $address, $city, $state, $country) {
		
		$this->db->query( sprintf("UPDATE " . DB_PREFIX . "wholesellers_tbl SET business_name = '%s', email = '%s', telephone = '%s', address = '%s', city = '%s', state = '%s', country = '%s' WHERE customer_id = %d", $this->db->escape($business_name), $this->db->escape($email), $this->db->escape($telephone), $this->db->escape($address), $this->db->escape($city), $this->db->escape($state), $this->db->escape($country), (int)$this->db->escape($customer_id) ));

		$affected = $this->db->countAffected();

		return $affected > 0 ? true : false;
		
	}

	public function deleteWholeseller($customer_id) {

		$this->db->query( "DELETE FROM " . DB_PREFIX . "wholesellers_tbl WHERE customer_id = " . (int)$this->db->escape($customer_id) );

		$affected = $this->db->countAffected();

		if ($affected > 0) {
			$this->db->query( "DELETE FROM " . DB_PREFIX . "artisan_wholeseller_tbl WHERE customer_id = " . (int)$this->db->escape($customer_id) );

			return true;
		}

		return false;
	}

	public function approveWholeseller($customer_id) {

		$this->db->query( sprintf("UPDATE " . DB_PREFIX . "wholesellers_tbl SET approval_status = %d WHERE customer_id = %d", 1, (int)$this->db->escape($customer_id) ));

		$affected = $this->db->countAffected();

		return $affected > 0 ? true : false;

	}

	public function revokeWholeseller($customer_id) {

		$this->db->query( sprintf("UPDATE " . DB_PREFIX . "wholesellers_tbl SET approval_status = %d WHERE customer_id = %d", 0, (int)$this->db->escape($customer_id) ));

		$affected = $this->db->countAffected();

		return $affected > 0 ? true : false;

	}

	private function alreadyRegistered($customer_id) {

		$query = $this->db->query("SELECT type FROM " . DB_PREFIX . "artisan_wholeseller_tbl WHERE customer_id = " . (int)$this->db->escape($customer_id) );

		return $query->row;
	}
}

?>