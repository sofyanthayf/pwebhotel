<?php
use Restserver\Libraries\REST_Controller;

/**
 *
 */
class Rooms extends REST_Controller
{

  function __construct()
  {
    parent::__construct();
    header("Access-Control-Allow-Origin: *");
    $this->load->model('room_model');
  }

  public function roomlist_get()
  {
    $data  = $this->room_model->roomlist();
    $this->response( [ 'rooms' => $data ], 200 );
  }

  public function roomrate_get()
  {
    $data  = $this->room_model->roomrate();
    $this->response( [ 'rates' => $data ], 200 );
  }

  public function jumlahkamar_get()
  {
    $data  = $this->room_model->roomcount();
    $this->response( [ 'rooms' => $data ], 200 );
  }

  public function roomavailable_get()
  {
    $data  = $this->room_model->roomAvailable();
    $this->response( [ 'rooms' => $data ], 200 );
  }



}


 ?>
