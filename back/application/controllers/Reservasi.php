<?php

/**
 *
 */
class Reservasi extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('room_model');
  }

  public function index()
  {
    $data['rate'] = $this->room_model->roomrate();
    // var_dump($data);
    $this->load->view('reservasi/reservasi', $data);
  }

}

















 ?>
