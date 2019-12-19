const endpoint_url = 'https://hotel.p-web.click/api';

function getRoomRate() {
  fetch(endpoint_url + "/rooms/jumlahkamar")
    .then(status)
    .then(json)
    .then(function(data) {

      var tb_header = `
            <table id="tb_roomrate">
              <thead>
                <tr>
                  <th>Room Type</th>
                  <th>Room Rate</th>
                  <th>Available</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          `;

      $("#dttable").html( tb_header );
      $("#tb_title").html( "Room Rate" );

      $('#tb_roomrate').DataTable({
          "data": data.rooms,
          "columns": [
            { "data": "rtype" },
            { "data": "rate" },
            { "data": "jumlah_kamar" }
          ]
      });
      $('select').formSelect();
    })
    .catch(error);
}

function getRoomList() {
  fetch(endpoint_url + "/rooms/roomlist")
    .then(status)
    .then(json)
    .then(function(data) {

      var tb_header = `
            <table id="tb_roomrate">
              <thead>
                <tr>
                  <th>Room#</th>
                  <th>Type</th>
                  <th>View</th>
                  <th>Rate</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          `;

      $("#dttable").html( tb_header );
      $("#tb_title").html( "Rooms" );

      $('#tb_roomrate').DataTable({
          "data": data.rooms,
          "columns": [
            { "data": "room" },
            { "data": "rtype" },
            { "data": "dview" },
            { "data": "vrate" }
          ]
      });

      $('select').formSelect();
    })
    .catch(error);
}

function getGuestsList() {
  fetch(endpoint_url + "/guests/guestslist")
    .then(status)
    .then(json)
    .then(function(data) {
      var tb_header = `
            <table id="tb_guestslist">
              <thead>
                <tr>
                  <th>Guest</th>
                  <th>From</th>
                  <th>Room</th>
                  <th>Check-In</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          `;

      $("#dttable").html( tb_header );
      $("#tb_title").html( "Guests" );

      $('#tb_guestslist').DataTable({
          "data": data.guests,
          "columns": [
            { "render": function(data, type, row, meta) {
                          data = '<a href="guest.html?id=' + row.member_ID +'">' + row.nama + '</a>';
                          return data;
                        } },
            { "data": "Country" },
            { "data": "room" },
            { "data": "date_in" }
          ],
          "order": [[3, 'asc']]
      });

      $('select').formSelect();
    })
    .catch(error);
}

function getGuestDetail(id) {
  console.log(id);
  fetch( endpoint_url + "/guests/guestbill/id/" + id )
    .then(status)
    .then(json)
    .then(function(data) {
      document.getElementById("nama_guest").innerHTML = data.guest.nama;
      document.getElementById("guest_alamat").innerHTML = data.guest.alamat;
      document.getElementById("guest_kota").innerHTML = data.guest.kota;
      document.getElementById("guest_negara").innerHTML = data.guest.Country;
      document.getElementById("guest_kodepos").innerHTML = data.guest.kodepos;
      document.getElementById("guest_telepon").innerHTML = data.guest.telepon;
      document.getElementById("guest_hp").innerHTML = data.guest.hp;

      document.getElementById("guest_room").innerHTML = data.guest.room;
      document.getElementById("guest_stay").innerHTML = data.guest.jml_hari + ' night(s)';
      document.getElementById("guest_rtype").innerHTML = data.guest.rtype;
      document.getElementById("guest_rview").innerHTML = data.guest.dview;
      document.getElementById("guest_rate").innerHTML = data.guest.finalrate + ' /night';
      document.getElementById("guest_billing").innerHTML = data.guest.tagihan;

      document.getElementById("btcheckin").href="checkin.html?id=" + data.members.member_ID;

    })
    .catch(error);
}

function getMembersList() {
  fetch(endpoint_url + "/guests/memberslist")
    .then(status)
    .then(json)
    .then(function(data) {
      var tb_header = `
            <table id="tb_memberslist">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Nama</th>
                  <th>City</th>
                  <th>Country</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          `;

      $("#dttable").html( tb_header );
      $("#tb_title").html( "Members" );

      $('#tb_memberslist').DataTable({
          "data": data.members,
          "columns": [
            { "data": "member_ID" },
            { "render": function(data, type, row, meta) {
                          data = '<a href="member.html?id=' + row.member_ID +'">' + row.nama + '</a>';
                          return data;
                        } },
            { "data": "kota" },
            { "data": "Country" }
          ],
          "order": [[0, 'desc']]
      });

      $('select').formSelect();
    })
    .catch(error);
}

function getMemberDetail(id) {
  fetch( endpoint_url + "/guests/detail/id/" + id )
    .then(status)
    .then(json)
    .then(function(data) {
      document.getElementById("nama_member").innerHTML = data.members.nama;
      document.getElementById("member_alamat").innerHTML = data.members.alamat;
      document.getElementById("member_kota").innerHTML = data.members.kota;
      document.getElementById("member_negara").innerHTML = data.members.Country;
      document.getElementById("member_kodepos").innerHTML = data.members.kodepos;
      document.getElementById("member_telepon").innerHTML = data.members.telepon;
      document.getElementById("member_hp").innerHTML = data.members.hp;

      document.getElementById("btcheckin").href="checkin.html?id=" + data.members.member_ID;

    })
    .catch(error);
}

function getCountries() {
  fetch( endpoint_url + "/guests/countrylist" )
    .then(status)
    .then(json)
    .then(function(data) {
      data.countries.forEach(function(country) {
        var elemen = document.createElement("option");
        elemen.value = country.CC;
        elemen.innerHTML = country.Country;
        document.getElementById("negara").appendChild(elemen);
      });

      $('select').formSelect();

    })
    .catch(error);
}

function newMemberSave(){
  var new_member = {
    'nama': document.getElementById("nama").value,
    'alamat': document.getElementById("alamat").value,
    'kota': document.getElementById("kota").value,
    'negara': document.getElementById("negara").value,
    'kodepos': document.getElementById("kodepos").value,
    'telepon': document.getElementById("telepon").value,
    'hp': document.getElementById("handphone").value
  }

  fetch( endpoint_url + "/guests/newmember", {
    method: 'POST',
    body: JSON.stringify(new_member)
  } )
    .then(status)
    .then(json)
    .then(function(data) {
      console.log(data);
      if( data.status == 'OK' ){
        document.getElementById("btsave").disabled = true;
        alert( "New member saved");

        document.getElementById("btcheckin").href="checkin.html?id=" + data.member_ID;

      } else {
        alert( "Save data failed, try again");
      }
    })
    .catch(error);
}


function getRoomAvailable() {
  fetch( endpoint_url + "/rooms/roomavailable" )
    .then(status)
    .then(json)
    .then(function(data) {
      data.rooms.forEach(function(room) {
        var elemen = document.createElement("option");
        elemen.value = room.room;
        elemen.innerHTML = room.room + ' -  ' + room.dview ;
        document.getElementById("roomselect").appendChild(elemen);
      });

      $('select').formSelect();

    })
    .catch(error);
}

function memberCheckIn() {
  var urlParams = new URLSearchParams(window.location.search);
  var checkin_data = {
    'member_ID': urlParams.get("id"),
    'room': document.getElementById("roomselect").value
  }
  console.log(checkin_data);

  fetch( endpoint_url + "/guests/checkedin", {
    method: 'POST',
    body: JSON.stringify(checkin_data)
  } )
    .then(status)
    .then(json)
    .then(function(data) {
      console.log(data);
      if( data.status == 'OK' ){
        document.getElementById("btcheckedin").disabled = true;
        alert( "Member Checked-in");
      } else {
        alert( "Checked-in failed, try again");
      }
  })
  .catch(error);

}

function guestCheckOut() {
  var urlParams = new URLSearchParams(window.location.search);
  var checkout_data = {
    'member_ID': urlParams.get("id"),
  }

  fetch( endpoint_url + "/guests/checkedout", {
    method: 'POST',
    body: JSON.stringify(checkout_data)
  } )
    .then(status)
    .then(json)
    .then(function(data) {
      console.log(data);
      if( data.status == 'OK' ){
        document.getElementById("btcheckedout").disabled = true;
        alert( "Guest Checked-Out");
      } else {
        alert( "Checked-out failed, try again");
      }
  })
  .catch(error);

}
