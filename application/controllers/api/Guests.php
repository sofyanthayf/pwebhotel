<?php
use Restserver\Libraries\REST_Controller;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Content-Type: application/json");

class Guests extends REST_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->model('guests_model');
  }

  public function guestslist_get()
  {
    $data  = $this->guests_model->guestslist();
    $this->response( [ 'guests' => $data ], 200 );
  }

  public function guestbill_get()
  {
    $id = $this->get('id');
    $data  = $this->guests_model->guestbill( $id );
    $this->response( [ 'guest' => $data ], 200 );
  }


  public function memberslist_get()
  {
    $data  = $this->guests_model->memberslist();
    $this->response( [ 'members' => $data ], 200 );
  }

  public function detail_get()
  {
    $id = $this->get('id');
    $data  = $this->guests_model->memberDetail($id);
    $this->response( [ 'members' => $data ], 200 );
  }

  public function countrylist_get()
  {
    $data = $this->guests_model->getCountryList();
    $this->response( [ 'countries' => $data ], 200 );
  }

  public function newmember_post()
  {
    var_dump($this->input->post());
    $data = json_decode($this->post()[0], true);
    $ok = $this->guests_model->insertMember($data);

    if( $ok ) {
      $this->response( ['status'=>'OK', 'member_ID'=> $ok ], 200 );
    } else {
      $this->response( ['status'=>'Failed'], 500 );
    }
  }

  public function checkedin_post()
  {
    $where = json_decode($this->post()[0], true);
    $ok = $this->guests_model->checked_out($where);

    if( $ok ) {
      $this->response( ['status'=>'OK', 'member_ID'=> $ok ], 200 );
    } else {
      $this->response( ['status'=>'Failed'], 500 );
    }
  }

  public function checkedout_post()
  {
    $data = json_decode($this->post()[0], true);
    $ok = $this->guests_model->checked_out($data);
// var_dump($data);
    if( $ok ) {
      $this->response( ['status'=>'OK', 'member_ID'=> $ok ], 200 );
    } else {
      $this->response( ['status'=>'Failed'], 500 );
    }
  }

}

 ?>
