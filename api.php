<?php
	function toArray($result) {
		$array = array();
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				array_push($array, $row);
			}
		}
		return $array;
	}

	function toMoney($price) {
		return number_format($price).'đ';
	}

	function getCurrentDateTime() {
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		return date('Y/m/d H:i:s');
	}
?>