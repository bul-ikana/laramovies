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

            <hr>

            <div id="comments"> </div>

            @auth
                <h4>Leave a comment:</h4>
                <form id="comment-form" onsubmit="event.preventDefault(); commentSubmit();">
                    <div class="form-group">
                      <input required type="text" class="form-control" id="name" name="name" aria-describedby="name-help" placeholder="Title">
                    </div>

                    <div class="form-group">
                      <input required type="text" class="form-control" id="comment" name="comment" aria-describedby="comment-help" placeholder="Comment">
                    </div>

                    <input type="hidden" name="user_id" value="{{ \Auth::id() }}">

                    <button  id="btn-submit" type="submit" class="btn btn-secondary">Submit!</button>
                </form>
            @endauth
        </div>
        <div class="col-md-4">

                <ul class="navbar-nav ml-auto auth-ul">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item btn btn-outline-secondary btn-sm btn-auth float-right">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        <li class="nav-item btn btn-outline-secondary btn-sm btn-auth float-right">
                            @if (Route::has('register'))
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            @endif
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle text-right" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>

            <div>
                <h4>List of movies:</h4>
                <ul class="list-group" id="movie-list"> </ul>
                <br>
                <a href="{{ route('create') }}" class="btn btn-secondary btn-block">Add a movie!</a>
            </div>
        </div>

        <script type="text/javascript">
            var film_id = 0;
            axios
                .get('{{ url("/api/films") }}{{ !empty($slug) ? '/' . $slug : '' }}')
                .then( function (response) {
                    console.log(response.data)

                    film_id = response.data.last_film.id

                    // Movie data
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

                    // Movie list
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

                    // Comments
                    var commentsdiv = document.getElementById("comments")
                    var comments = response.data.last_film.comments

                    for (comment in comments) {
                        var div = document.createElement('div')

                        var h4 = document.createElement('h4')

                        var small = document.createElement('small')
                        small.setAttribute('class', 'author')
                        small.innerHTML = "By: " + comments[comment].user.name

                        var p = document.createElement('p')
                        p.innerHTML = comments[comment].comment

                        var hr = document.createElement('hr')

                        h4.innerHTML = comments[comment].name

                        div.appendChild(h4)
                        div.appendChild(small)
                        div.appendChild(p)
                        commentsdiv.appendChild(div)
                        commentsdiv.appendChild(hr)
                    }
                })

            function commentSubmit () {
                document.getElementById('btn-submit').innerHTML = "Saving..."
                formdata = new FormData(document.getElementById('comment-form'));
                axios
                  .post('{{ url('/api/films') }}/' + film_id + '/comments', formdata)
                  .then(function (response) {
                        var commentsdiv = document.getElementById("comments")
                        var div = document.createElement('div')

                        var h4 = document.createElement('h4')

                        var small = document.createElement('small')
                        small.setAttribute('class', 'author')
                        small.innerHTML = "By: " + response.data.user.name

                        var p = document.createElement('p')
                        p.innerHTML = response.data.comment

                        var hr = document.createElement('hr')

                        h4.innerHTML = response.data.name

                        div.appendChild(h4)
                        div.appendChild(small)
                        div.appendChild(p)
                        commentsdiv.appendChild(div)
                        commentsdiv.appendChild(hr)

                        document.getElementById('btn-submit').innerHTML = "Submit!"
                        document.getElementById('comment-form').reset()
                  })
            }
        </script>

    </div>
@endsection
