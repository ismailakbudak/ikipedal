
<?php if (!defined('BASEPATH')) {exit('No direct script access allowed');
}

/**
 *   Return offer locations lat and lng
 *
 *   @param
 *   @return
 **/
function getLocation(&$offer, $locations) {
	$result = 0;
	error_reporting(0);
	foreach ($locations as $val) {

		$name = $val['name'];
		$from = $offer['o_from'];
		$to = $offer['d_to'];

		$name = trim($name);
		$from = trim($from);
		$to = trim($to);

		if (strcmp($name, $from) === 0) {
			$offer['from_lat'] = $val['lat'];
			$offer['from_lng'] = $val['lng'];
			$result++;
		}
		if (strcmp($name, $to) === 0) {
			$offer['to_lat'] = $val['lat'];
			$offer['to_lng'] = $val['lng'];
			$result++;
		}
		if ($result == 2) {
			break;
		}
	}

	return $result;
}
