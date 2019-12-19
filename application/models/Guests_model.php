<?php

/**
 *
 */
class Guests_model extends CI_Model
{

  public function guestslist()
  {
    /* SQL:
      SELECT * FROM `guests`
      LEFT JOIN members USING(member_ID)
      WHERE date_out IS NULL
    */

    $this->db->join('members', 'member_ID');
    $this->db->join('country', 'ON(country.CC=members.negara)');
    $this->db->where('date_out IS NULL');
    $this->db->order_by('date_in','desc');
    $query = $this->db->get('guests');
    return $query->result();
  }


  public function memberslist()
  {
    $this->db->join('country', 'ON(country.CC=members.negara)');
    $query = $this->db->get('members');
    return $query->result();
  }


  public function memberDetail($id)
  {
    /* SQL
    SELECT * FROM `members`
    LEFT JOIN country ON(members.negara=country.CC)
    WHERE members.member_ID='05000037'
    */

    $where = [ 'member_ID' => $id ];

    $this->db->join('country', 'ON(members.negara=country.CC)');
    $this->db->where($where);
    $query = $this->db->get('members');
    return $query->result()[0];

  }

  public function getCountryList()
  {
    /* SQL
      SELECT * FROM `country`
    */

    $query = $this->db->get('country');
    return $query->result();
  }

  public function insertMember($data)
  {
    $data['member_ID'] = $this->newMemberId();
    $insertOK = $this->db->insert('members', $data);

    if( $insertOK ){
      return $data['member_ID'];
    } else {
      return FALSE;
    }
  }

  public function newMemberId()
  {
    /* SQL:
      SELECT RIGHT(member_ID, 6) reg
      FROM `members`
      ORDER BY member_ID DESC
      LIMIT 1
    */
    $this->db->select('RIGHT(member_ID, 6) reg');
    $this->db->order_by('member_ID','DESC');
    $this->db->limit(1);
    $query = $this->db->get('members');

    $lastID = $query->result()[0];
    $newID = date('y') . $this->tambahNol($lastID->reg + 1, 6);
    return $newID;
  }

  private function tambahNol($nilai, $digit)
  {
    return str_repeat('0', $digit - strlen($nilai) ) . $nilai;
  }

  public function guestbill($id)
  {
    /* SQL
      SELECT
        m.*, c.Country, g.room, DATEDIFF(NOW(), g.date_in) jml_hari,
        t.rate+(t.rate*v.addv) finalrate,
      (t.rate+(t.rate*v.addv)) * DATEDIFF(NOW(), g.date_in) tagihan
      FROM guests g
      LEFT JOIN members m USING(member_ID)
      LEFT JOIN rooms r USING(room)
      LEFT JOIN roomtype t ON(r.rtype=t.kode)
      LEFT JOIN views v ON(r.dview=v.vcode)
      WHERE member_ID='05001635'
      AND date_out IS NULL
      LIMIT 1
    */

    $this->db->select('m.*, c.Country, g.room, t.*, v.dview');
    $this->db->select('DATEDIFF(NOW(), g.date_in) jml_hari');
    $this->db->select('t.rate+(t.rate*v.addv) finalrate');
    $this->db->select('(t.rate+(t.rate*v.addv)) * DATEDIFF(NOW(), g.date_in) tagihan');
    $this->db->join('members m', 'member_ID', 'LEFT');
    $this->db->join('country c', 'c.CC=m.negara', 'LEFT');
    $this->db->join('rooms r', 'room', 'LEFT');
    $this->db->join('roomtype t', 'r.rtype=t.kode', 'LEFT');
    $this->db->join('views v', 'r.dview=v.vcode', 'LEFT');
    $this->db->where( ['member_ID' => $id] );
    $this->db->where('date_out IS NULL');

    $query = $this->db->get('guests g');
    return $query->result()[0];

  }

  public function checked_in($data)
  {
    $data['date_in'] = date('Y-m-d');
    $checkinOK = $this->db->insert('guests', $data);

    if( $checkinOK ){
      return $data['member_ID'];
    } else {
      return FALSE;
    }
  }

  public function checked_out($where)
  {
    /* SQL
      UPDATE guests SET date_out=CURRENT_DATE()
      WHERE member_ID='xxxxxxxxxx' AND date_out IS NULL
    */

    $this->db->where($where);
    $checkoutOK = $this->db->update('guests', 'date_out=CURRENT_DATE()');

    if( $checkoutOK ){
      return $where['member_ID'];
    } else {
      return FALSE;
    }
  }

}





 ?>
