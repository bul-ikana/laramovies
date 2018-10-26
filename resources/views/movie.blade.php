@extends('base')

@section('content')
    <div class="spinner" id="spinner">
      <div class="rect1"></div>
      <div class="rect2"></div>
      <div class="rect3"></div>
      <div class="rect4"></div>
      <div class="rect5"></div>
    </div>
    <div class="row" id="content" style="display:none">
        <div class="col-md-8">
            <h1 id="name"></h1>
            <a id="link" href="#"><img id="photo" src=""></a>
            <p id="description"></p>
            <p><strong>Relase date:</strong> <span id="release_date"></span></p>
            <p><strong>Rating:</strong> <span id="rating"></span>/5</p>
            <p><strong>Ticket price:</strong> $<span id="ticket_price"></span></p>
            <p><strong>Country:</strong> <span id="country"></span></p>
            <p><strong id="genre_title"></strong> <span id="genre">t</span></p>
        </div>
        <div class="col-md-4">
            <h4>List of movies:</h4>
            <ul class="list-group" id="movie-list"> </ul>
        </div>

        <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
        <script type="text/javascript">
            axios
                .get('{{ url("/api/films") }}')
                .then( function (response) {
                    console.log(response.data)

                    document.getElementById("spinner").style.display = 'none'
                    document.getElementById("content").style.display = 'flex'
                    document.getElementById("name").innerHTML = response.data.last_film.name
                    document.getElementById("photo").src = response.data.last_film.photo
                    document.getElementById("link").href = response.data.last_film.photo
                    document.getElementById("description").innerHTML = response.data.last_film.description
                    document.getElementById("release_date").innerHTML = response.data.last_film.release_date
                    document.getElementById("rating").innerHTML = response.data.last_film.rating
                    document.getElementById("ticket_price").innerHTML = response.data.last_film.ticket_price
                    document.getElementById("country").innerHTML = response.data.last_film.country
                    document.getElementById("genre_title").innerHTML = response.data.last_film.genres.length ? response.data.last_film.genres.length > 1 ? "Genres:" : "Genre:" : ''
                    document.getElementById("genre").innerHTML = response.data.last_film.genres.map(x => x.name).join(', ')

                    var ul = document.getElementById("movie-list")
                    var all_films = response.data.all_films
                    for (movie in all_films) {
                        var li = document.createElement('li')
                        li.setAttribute('class', 'list-group-item');

                        var a = document.createElement('a')
                        a.href = "{{ url("/films/") }}/" + movie
                        a.innerHTML = all_films[movie]

                        li.appendChild(a)
                        ul.appendChild(li)
                    }
                })
        </script>

    </div>
@endsection
