@extends('base')

@section('content')
  <form id="movie-form" onsubmit="event.preventDefault(); movieSubmit();">
    <div class="form-group">
      <label for="name">Name</label>
      <input required type="text" class="form-control" id="name" name="name" aria-describedby="name-help">
      <small id="name-help" class="form-text text-muted">The movie name</small>
    </div>

    <div class="form-group">
      <label for="description">Description</label>
      <input required type="text" class="form-control" id="description" name="description" aria-describedby="description-help">
      <small id="description-help" class="form-text text-muted">A little summary of the movie's plot. </small>
    </div>

    <div class="form-group">
      <label for="release_date">Release date</label>
      <input required type="date" class="form-control" id="release_date" name="release_date" aria-describedby="release_date-help">
      <small id="release_date-help" class="form-text text-muted">The date the movie was released</small>
    </div>

    <div class="form-group">
      <label for="rating">Rating</label>
      <input required type="number" class="form-control" id="rating" name="rating" aria-describedby="rating-help">
      <small id="rating-help" class="form-text text-muted">A rating for the movie, from 1 to 5. Be honest!</small>
    </div>

    <div class="form-group">
      <label for="ticket_price">Ticket price</label>
      <input required type="number" step="any" class="form-control" name="ticket_price" id="ticket_price" aria-describedby="ticket_price-help">
      <small id="ticket_price-help" class="form-text text-muted">How much does a ticket costs for this movie?</small>
    </div>

    <div class="form-group">
      <label for="country">Country</label>
      <input required type="text" step="any" class="form-control" id="country" name="country" aria-describedby="country-help">
      <small id="country-help" class="form-text text-muted">Where is this movie from?</small>
    </div>

    <div class="form-group">
      <label for="photo">Photo</label>
      <input required type="url" step="any" class="form-control" id="photo" name="photo" aria-describedby="photo-help">
      <small id="photo-help" class="form-text text-muted">Paste the URL of an image for this movie. You can easily get one from Google.</small>
    </div>

    <button  id="btn-submit" type="submit" class="btn btn-secondary">Submit!</button>

    <script type="text/javascript">
      function movieSubmit() {

        document.getElementById('btn-submit').innerHTML = "Saving..."

        formdata = new FormData(document.getElementById('movie-form'));
        axios
          .post('{{ url('/api/films') }}', formdata)
          .then(function (response) {
            if(confirm("The movie has been saved! Wanna see it?")) {
                window.location.href = "{{ url('/') }}"
            }
          })
      }
    </script>
  </form>
@endsection
