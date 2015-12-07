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
* TheTVDB Class
*
* @package    TheTVDB API
* @author     Ekachai Omkaew <ekaomk@gmail.com>
* @copyright  1997-2015 Ekachai Omkaew
* @license    GNU General Public License (GNU GPL or GPL): http://www.gnu.org/licenses/
*/

class TheTVDB{

  function __construct($api_key){
    $this->api_key = $api_key;
    $this->mirror_url = "http://thetvdb.com/api/$this->api_key/mirrors.xml";
    $this->search_series_url = "%s/api/GetSeries.php?seriesname=%s";
    $this->series_data_url = "%s/api/%s/series/%d/";
    $this->series_data_full_url = "%s/api/%s/series/%d/all/";
  }

  function get_mirror(){
    return $this->get_data_object($this->mirror_url);
  }

  function get_series_data($series_id, $full){
    $mirror_url = $this->get_mirror()->Mirror->mirrorpath;
    return $this->get_data_object(sprintf(($full ? $this->series_data_full_url : $this->series_data_url), $mirror_url, $this->api_key, $series_id));
  }

  function search_series(){
    $mirror_url = $this->get_mirror()->Mirror->mirrorpath;
    switch (count(func_get_args())) {
      case 1:
      return $this->get_data_object(sprintf($this->search_series_url, $mirror_url, urlencode(func_get_args()[0])));
      break;

      case 2: {
        $index = func_get_args()[1] - 1;
        $result = $this->get_data_object(sprintf($this->search_series_url, $mirror_url, urlencode(func_get_args()[0])));
        if(is_array($result->Series))
        return $result->Series[$index];
        else
        return $result->Series;
      }
      break;

      default:
      echo 'Error: Parameter error.';
      exit(0);
      break;
    }
  }

  function get_data_object($url){
    libxml_use_internal_errors(true);
    $data = $this->curl_get_file_contents($url);
    $xml = simplexml_load_string($data);

    if(!$xml) {
      echo 'Error: Invalid api key.';
      exit(0);
    }
    $json_str = json_encode($xml);
    $data_obj = json_decode($json_str);
    return $data_obj;
  }

  function curl_get_file_contents($url)
  {
    $curl = curl_init();
    $options = Array(
    CURLOPT_URL            => $url,
    CURLOPT_RETURNTRANSFER => TRUE,
    CURLOPT_ENCODING       => 'UTF-8' );
    curl_setopt_array($curl, $options);

    $data = curl_exec($curl);
    curl_close($curl);
    return $data;
  }
}


?>
