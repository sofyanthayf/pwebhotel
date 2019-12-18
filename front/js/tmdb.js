const key = '608ce5e628b4dc66eea24ea292eb79b2';
const endpoint_url = 'https://api.themoviedb.org/3';

document.addEventListener("DOMContentLoaded", function() {
  var page = window.location.hash.substr(1);

  getListMovie();
});

// Blok kode untuk melakukan request API

function getListMovie() {
  fetch(endpoint_url + "/movie/now_playing?api_key=" + key + "&language=en-US&page=1")
    .then(status)
    .then(json)
    .then(function(data) {
      // Objek/array JavaScript dari response.json() masuk lewat data.
      // Menyusun komponen card movie secara dinamis
      var moviesHTML = "";
      data.results.forEach(function(movie) {
        moviesHTML += `
            <div class="col m3 s6">
              <div class="card">
                <a href="./movie.html?id=${movie.id}">
                  <div class="card-image waves-effect waves-block waves-light">
                    <img src="https://image.tmdb.org/t/p/w500${movie.poster_path}" />
                  </div>
                </a>
                <div class="card-content text-center">
                  <strong>${movie.title}</strong>
                </div>
              </div>
            </div>
            `;
      });
      // Sisipkan komponen card ke dalam elemen dengan id #content
      document.getElementById("movie_list").innerHTML = moviesHTML;
    })
    .catch(error);
}
