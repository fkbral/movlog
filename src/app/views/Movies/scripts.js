const searchForm = document.getElementById('search-form');
const searchInput = document.getElementById('search');
const searchResults = document.querySelector('#search-results');
const searchResultsUl = searchResults.querySelector('ul');
const movieListUlPlanned = document.querySelector('.planned.movie-list ul');
const movieListUlWatched = document.querySelector('.watched.movie-list ul');
const movieListLi = document.querySelectorAll('.movie-list li');
const movieModal = document.getElementById('movie-modal');
let searchMatches = [];
let movieList = [];
const fallbackImageSrc = './public/assets/no-cover.jpg';

searchInput.addEventListener('focus', event => {
  searchResults.classList.add('active');
});

function setSearchInputFocus() {
  if(searchResults.classList.contains('active')){
    searchInput.focus();
    searchResults.classList.remove('active');
  }
}

document.addEventListener('click', event => {
  if(event.target.classList.contains('backdrop')){
    movieModal.classList.remove('active');
    setSearchInputFocus();
  }
});

movieModal.querySelector('[data-close]').addEventListener('click', event => {
  movieModal.classList.remove('active');
  setSearchInputFocus();
});

document.addEventListener('keydown', event => {
  if(!movieModal.classList.contains('active')) return;
  if(event.key === 'Escape'){
    movieModal.classList.remove('active');
    setSearchInputFocus();
  }
});

[...movieListLi].map(watched => {
  watched.querySelector('[data-action="remove"]').onclick = handleRemoveMovie;
  watched.querySelector('[data-action="fetch"]').onclick = handleGetMovieDetails;
  watched.querySelector('[data-action="status"]').onclick = handleUpdateMovieWatchStatus;
  movieList.push(watched);
  return watched;
});

searchForm.onsubmit = ((event) => {
  event.preventDefault();

  if(searchInput.value === '') return;

  const searchTitle = searchInput.value;
  searchInput.value = '';

  fetch(`https://omdbapi.com/?s=${searchTitle}&apikey=${credentials.apiKey}`)
  .then(result => {
    return result.json();
  }).then(data => {

    searchMatches = [];
    searchResultsUl.innerHTML = '';

    const matches = data.Search;

    if(!matches){
      searchResultsUl.innerHTML = '<li>no results found.</li>'
      return;
    }

    matches.map(match => {
      if(match.Type === 'game') return;
      searchMatches.push(match);

      const element = document.createElement('li');
      const movieTitleAndYearDiv = document.createElement('div');

      for (key in match){
        let node;
        if(key==='Title' || key ==='Year'){
          node = document.createElement('p');
          node.innerText = match[key];
          movieTitleAndYearDiv.appendChild(node);
        }
        if(key ==='Poster'){
          node = document.createElement('img');
          node.src = match[key] !== 'N/A' ? match[key] : fallbackImageSrc;
          node.alt = match['Title'];
          const imageDiv = document.createElement('div');
          imageDiv.dataset.more = '';
          const openModalButton = document.createElement('button');
          const openModalButtonIcon = document.createElement('i');
          openModalButtonIcon.classList.add('fas', 'fa-chevron-left');
          openModalButton.appendChild(openModalButtonIcon);
          openModalButton.dataset.id = match.imdbID;
          openModalButton.dataset.details = '0';
          openModalButton.onclick = event => handleGetMovieDetails(event, true);
          imageDiv.appendChildren([openModalButton, node]);
          element.appendChild(imageDiv);
        }
      }

      movieTitleAndYearDiv.appendChild(createAddToListButtons(match.imdbID));

      element.prepend(movieTitleAndYearDiv);
      searchResultsUl.appendChild(element);
      return match;
    });

  });
});

HTMLElement.prototype.appendChildren = function appendChildren(array=[]) {
  array.forEach(child => {
    this.appendChild(child);
  });
}

function createAddToListButtons(id){
  const addToWatchedButton = document.createElement('button');
  const addToWatchedButtonIcon = document.createElement('i');
  addToWatchedButtonIcon.classList.add('far','fa-eye');
  addToWatchedButton.appendChild(addToWatchedButtonIcon);
  addToWatchedButton.dataset.id = id;
  addToWatchedButton.dataset.status = 1;
  addToWatchedButton.onclick = handleAddMovie;

  const addToPlanedButton = document.createElement('button');
  const addToPlanedButtonIcon = document.createElement('i');
  addToPlanedButtonIcon.classList.add('far','fa-clock');
  addToPlanedButton.appendChild(addToPlanedButtonIcon);
  addToPlanedButton.dataset.id = id;
  addToPlanedButton.dataset.status = 0;
  addToPlanedButton.onclick = handleAddMovie;

  const addToListButtonsDiv = document.createElement('div');
  addToListButtonsDiv.classList.add('add-to-list-buttons');
  addToListButtonsDiv.appendChildren([addToWatchedButton, addToPlanedButton]);

  return addToListButtonsDiv;
}

function createMovieCardButtons(data){
  const actionsDiv = document.createElement('div');
  actionsDiv.classList.add('actions');

  const removeAndStatusDiv = document.createElement('div');
  removeAndStatusDiv.classList.add('removeAndStatus');

  const watchButton = document.createElement('button');
  const watchButtonIcon = document.createElement('i');
  watchButtonIcon.classList.add(
    'far', data.status ? 'fa-clock' : 'fa-eye', 'fa-fw'
  );
  watchButton.dataset.action = 'status';
  watchButton.dataset.id = data.id;
  watchButton.dataset.status = data.status;
  watchButton.onclick = handleUpdateMovieWatchStatus;
  watchButton.appendChild(watchButtonIcon);

  const removeButton = document.createElement('button');
  const removeButtonIcon = document.createElement('i');
  removeButtonIcon.classList.add('far', 'fa-trash-alt', 'fa-fw');
  removeButton.dataset.id = data.id;
  removeButton.onclick = handleRemoveMovie;
  removeButton.appendChild(removeButtonIcon);

  const toDetailsButton = document.createElement('button');
  toDetailsButton.classList.add('to-details');
  toDetailsButton.dataset.action = 'fetch';
  toDetailsButton.dataset.id = data.id;
  toDetailsButton.dataset.details = '0';
  const toDetailsButtonIcon = document.createElement('i');
  toDetailsButtonIcon.classList.add('fas', 'fa-chevron-up');
  toDetailsButton.onclick = handleGetMovieDetails;
  toDetailsButton.appendChild(toDetailsButtonIcon);

  removeAndStatusDiv.appendChildren([watchButton, removeButton]);
  actionsDiv.appendChildren([removeAndStatusDiv, toDetailsButton]);
  
  return actionsDiv;
}

function handleAddMovie(event){
  const element = event.target;
  // const index = Array.prototype.indexOf.call(element.parentNode.children, element);
  const movie = Array.prototype.find.call(
    searchMatches, search => search.imdbID === element.dataset.id);
  movie.status = parseInt(element.dataset.status);

  const formData = new FormData();
  formData.append('movie', JSON.stringify(movie));

  fetch('movies', {
    method: 'post',
    body: formData,
  }).then(result => result.json())
  .then(data => {
    const movieElement = document.createElement('li');

    movieElement.setAttribute('data-id', `${data['id']}`);

    const image = document.createElement('img');
    image.setAttribute('src', data.poster !== 'N/A' ? data.poster : fallbackImageSrc);
    image.setAttribute('alt', data.title);

    const imageDiv = document.createElement('div');
    imageDiv.dataset.cover = '';
    const movieCardButtons = createMovieCardButtons(data);

    imageDiv.appendChild(movieCardButtons);
    imageDiv.appendChild(image);

    const p1 = document.createElement('strong');
    p1.innerText = data.title;

    const p2 = document.createElement('p');
    p2.innerText = data.year;

    movieElement.appendChildren([imageDiv, p1, p2]);

    if(movie.status == 0){
      movieListUlPlanned.appendChild(movieElement);
      if(movieListUlPlanned.childElementCount === 0);
        movieListUlPlanned.querySelector('p').style.display = 'none';
    }
    else{
      movieListUlWatched.appendChild(movieElement);
      if(movieListUlWatched.childElementCount === 0);
        movieListUlWatched.querySelector('p').style.display = 'none';
    }
    movieList.push(movieElement);
    movies.push(data);

    return data;
  });
}

function handleRemoveMovie(event) {
  const movieIdToRemove = event.target.dataset.id;

  fetch(`movies?movieId=${movieIdToRemove}`, { method: 'delete' })
  .then(result => result.json())
  .then(data => {
  
    const movieToRemoveLi = document.querySelector(`.movie-list ul 
    li[data-id="${movieIdToRemove}"]`);

    movieToRemoveLi.remove();

    movieList = movieList.filter(movie => {
      if(movie.dataset.id !== movieIdToRemove){
        return movie;
      }
    });
    
    return data;
  });
}

function handleUpdateMovieWatchStatus(event) {
  const movieIdToUpdateStatus = event.target.dataset.id;
  const status = event.target.dataset.status === '1' ? '0' : '1';

  fetch(`movies?movieId=${movieIdToUpdateStatus}&type=status&status=${status}`,
  { method: 'post' })
  .then(result => result.json())
  .then(data => {
    const movieLi = document.querySelector(`li[data-id="${movieIdToUpdateStatus}"]`);
    movieLi.remove();
    const button = movieLi.querySelector('[data-action="status"]');
    const icon = button.querySelector('i');
    if(status === '1'){
      button.dataset.status = '1';
      icon.classList.remove('fa-eye');
      icon.classList.add('fa-clock');
      movieListUlWatched.append(movieLi);
    }
    else {
      button.dataset.status = '0';
      icon.classList.remove('fa-clock');
      icon.classList.add('fa-eye');
      movieListUlPlanned.append(movieLi);
    }
    return data;
  });
}

function handleGetMovieDetails(event, readonly = false){
  if(readonly){
    searchInput.focus();
  }
  const movieIdToFetchDetails = event.target.dataset.id;
  const movieHasDetails = event.target.dataset.details;

  if(movieHasDetails === '1') return openLightBox(event.target);

  fetch(`https://omdbapi.com/?i=${movieIdToFetchDetails}&apikey=${credentials.apiKey}`)
  .then(result => result.json())
  .then(data => {
    event.target.dataset.details = '1';

    const movieToUpdateDetails = !readonly ? movies.find(movie => 
      movie.id === movieIdToFetchDetails
    ) : {};

    for (key in data){
      if(key !== 'imdbRating')
        movieToUpdateDetails[key.toLowerCase()] = data[key];
      else
        movieToUpdateDetails['imdb_rating'] = data[key];
    }

    if(!readonly) saveMovieDetails(data);
    else {
      movieToUpdateDetails.id = movieIdToFetchDetails;
      movies.push(movieToUpdateDetails)
    };

    openLightBox(event.target);
    
    return data;
  });

}

function openLightBox(target){
  const id = target.dataset.id;

  const movie = movies.find(movie => movie.id === id);

  for(key in movie) {
    const span = movieModal.querySelector(`.${key} span`);
    if(span){
      span.innerText = movie[key];
    }
  }

  if(movie.poster){
    movieModal.querySelector('.poster img').setAttribute(
      'src', movie.poster !== 'N/A' ? movie.poster : fallbackImageSrc
    );
    movieModal.querySelector('.poster img').setAttribute('alt', movie.title);
  }

  movieModal.classList.add('active');
}

function saveMovieDetails(movieDetails) {

  const formData = new FormData();
  formData.append('payload', JSON.stringify(movieDetails));

  fetch(`movies?movieId=${movieDetails.imdbID}&type=details`,
  { method: 'post', body:formData })
  .then(result => result.json())
  .then(data => {
    return data;
  });
}