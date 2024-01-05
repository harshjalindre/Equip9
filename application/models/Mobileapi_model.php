<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mobileapi_model extends CI_Model {

    public function save_location($latitude, $longitude)
    {
        
        $data = array(
            'latitude' => $latitude,
            'longitude' => $longitude,
        );
        return $this->db->insert('locations', $data);
    }

    public function update_location($id, $latitude, $longitude)
    {
        $data = array(
            'latitude' => $latitude,
            'longitude' => $longitude,
        );
        $this->db->where('id', $id);
        return $this->db->update('locations', $data);
    }

    public function soft_delete_location($id)
    {
        
        $data = array('is_deleted' => 1);
        $this->db->where('id', $id);
        return $this->db->update('locations', $data);
    }

    public function get_all_locations()
    {
        
        $this->db->where('is_deleted', 0); 
        $query = $this->db->get('locations');
        return $query->result_array();
    }


    
    public function calculate_distance($lat1, $lon1, $lat2, $lon2, $unit)
    {
        
        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);

        
        $Latitude = $lat2 - $lat1;
        $Longitude = $lon2 - $lon1;
        $a = sin($Latitude / 2) * sin($Latitude / 2) + cos($lat1) * cos($lat2) * sin($Longitude / 2) * sin($Longitude / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        // Distance formula
        $radius = ($unit == 'km') ? 6371 : 3959;
        $distance = $radius * $c;

        return $distance;
    }
}


// Create Table Query

//  CREATE TABLE `equipnine`.`locations` (`id` INT  NOT NULL AUTO_INCREMENT , PRIMARY KEY(`id`) , `latitude` VARCHAR(100) NOT NULL , `longitude` VARCHAR(100) NOT NULL , `is_deleted` ENUM("0","1") NOT NULL COMMENT '\"Inactive\",\"Active\"' ) ENGINE = InnoDB;