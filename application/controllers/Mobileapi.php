<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mobileapi extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('mobileapi_model');
    }


	public function index()
	{
		
	}


    public function save_location()
    {
        $latitude = $this->input->post('latitude');
        $longitude = $this->input->post('longitude');

        $result = $this->mobileapi_model->save_location($latitude, $longitude);

        if ($result) {
            $this->output->set_status_header(201);
            echo json_encode(['message' => 'Location saved successfully']);
        } else {
            $this->output->set_status_header(500);
            echo json_encode(['error' => 'Internal Server Error']);
        }
    }

    public function update_location()
    {
        $id = $this->input->post('id');
        $latitude = $this->input->post('latitude');
        $longitude = $this->input->post('longitude');

        $result = $this->mobileapi_model->update_location($id, $latitude, $longitude);

        if ($result) {
            echo json_encode(['message' => 'Location updated successfully']);
        } else {
            $this->output->set_status_header(500);
            echo json_encode(['error' => 'Internal Server Error']);
        }
    }

    public function delete_location($id)
    {
        $result = $this->mobileapi_model->soft_delete_location($id);

        if ($result) {
            echo json_encode(['message' => 'Location deleted successfully']);
        } else {
            $this->output->set_status_header(500);
            echo json_encode(['error' => 'Internal Server Error']);
        }
    }

    public function view_locations()
    {
        $data['locations'] = $this->mobileapi_model->get_all_locations();
        echo json_encode($data);
    }

    public function calculate_distance()
    {
        $latitude1 = $this->input->post('latitude1');
        $longitude1 = $this->input->post('longitude1');
        $latitude2 = $this->input->post('latitude2');
        $longitude2 = $this->input->post('longitude2');
        $unit = $this->input->post('unit'); // 'km' or 'miles'

        $distance = $this->mobileapi_model->calculate_distance($latitude1, $longitude1, $latitude2, $longitude2, $unit);

        if ($distance !== false) {
            echo json_encode(['distance' => $distance]);
        } else {
            $this->output->set_status_header(400);
            echo json_encode(['error' => 'Invalid input or calculation error']);
        }
    }


}
