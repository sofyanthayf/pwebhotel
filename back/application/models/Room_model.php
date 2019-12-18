<?php

/**
 *
 */
class Room_model extends CI_Model
{

  public function roomrate()
  {
    /* SQL:
     SELECT * FROM roomtype
    */

    $query = $this->db->get('roomtype');
    return $query->result();
  }


  public function roomcount()
  {
    /* SQL:
      SELECT t.rtype, t.rate, COUNT(*) jumlah_kamar
      FROM rooms r
      LEFT JOIN roomtype t ON (r.rtype=t.kode)
      GROUP BY r.rtype
    */

    $this->db->select('t.rtype, t.rate, COUNT(*) jumlah_kamar');
    $this->db->from('rooms r');
    $this->db->join('roomtype t', 'ON(r.rtype=t.kode)');
    $this->db->group_by('r.rtype');

    $query = $this->db->get();
    return $query->result();
  }


  public function roomlist($value='')
  {
    /* SQL:
     SELECT r.room, t.rtype, v.dview, t.rate
     FROM rooms r
     LEFT JOIN roomtype t ON (r.rtype=t.kode)
     LEFT JOIN views v ON (r.dview=v.vcode)
    */

    $this->db->select('r.room, t.rtype, v.dview, t.rate, t.rate+(t.rate*v.addv) vrate');
    $this->db->from('rooms r');
    $this->db->join('roomtype t', 'ON(r.rtype=t.kode)');
    $this->db->join('views v', 'ON(r.dview=v.vcode)');

    $query = $this->db->get();
    return $query->result();
  }


  public function roomAvailable()
  {
    /* SQL:
    SELECT r.room, t.rtype, v.dview, t.rate
    FROM rooms r
    LEFT JOIN views v ON (r.dview=v.vcode)
    LEFT JOIN roomtype t ON (r.rtype=t.kode)
    WHERE r.room NOT IN (SELECT room FROM `guests` WHERE date_out IS NULL)
    */
    $this->db->select('r.room, v.dview, t.rate, t.rate+(t.rate*v.addv) vrate');
    $this->db->join('roomtype t', 'ON(r.rtype=t.kode)');
    $this->db->join('views v', 'ON(r.dview=v.vcode)');
    $this->db->where('r.room NOT IN (SELECT room FROM `guests` WHERE date_out IS NULL)');
    $query = $this->db->get('rooms r');
    return $query->result();

  }

}


















 ?>
