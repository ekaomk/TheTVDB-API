<?php

/**
* TheTVDB API is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version,
* and distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* Sample PHP File
*
* @package    TheTVDB API
* @author     Ekachai Omkaew <ekaomk@gmail.com>
* @copyright  1997-2015 Ekachai Omkaew
* @license    GNU General Public License (GNU GPL or GPL): http://www.gnu.org/licenses/
*/

require_once('TheTVDB.class.php');

// Replace your API key here (Require)
$api = new TheTVDB("ABCDEF0123456789");

echo '<br>'; echo '----------------------------------------------------------------------------------------------------------- GET MIRROR EXAMPLE -----------------------------------------------------------------------------------------------------------'; echo '<br>';
// Get api path to show (optional)
$mirror = $api->get_mirror();
echo
'Mirror ID: ' . $mirror->Mirror->id .
'<br>Mirror Path: ' . $mirror->Mirror->mirrorpath . // API path
'<br>Mirror Type Mask: ' . $mirror->Mirror->typemask;

echo '<br>'; echo '<br>'; echo '--------------------------------------------------------------------------------------------------------- SEARCH SERIES EXAMPLE ---------------------------------------------------------------------------------------------------------'; echo '<br>';
// Search series name with 'Overlord'
$search_series_result_all = $api->search_series('Overlord');
// Search series name with 'Overlord' and get result index 1 (First result)
$search_series_result_specific = $api->search_series('Overlord', 1);
// Set series id to variable to get series data
$series_id = $search_series_result_specific->seriesid;
// Print search result
echo json_encode($search_series_result_specific);

echo '<br>'; echo '<br>'; echo '------------------------------------------------------------------------------------------------------- GET SERIES DATA EXAMPLE -------------------------------------------------------------------------------------------------------'; echo '<br>';
// Get full series data
$series_full = $api->get_series_data($series_id, true);
// Get sample series data
$series_sample = $api->get_series_data($series_id, false);
// Print Series data
echo json_encode($series_full);

?>
