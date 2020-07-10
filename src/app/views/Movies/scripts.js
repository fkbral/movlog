const searchForm = document.getElementById('search-form');
const searchInput = document.getElementById('search');
const searchResultsUl = document.querySelector('#search-results ul');
const movieListUl = document.querySelector('.watched.movie-list ul');
const movieListLi = document.querySelectorAll('.movie-list li');

let searchMatches = [];
let movieList = [];

[...movieListLi].map(watched => {
  watched.querySelector('button').onclick = handleRemoveMovie;
  movieList.push(watched);
  return watched;
});

searchForm.onsubmit = ((event) => {
  event.preventDefault();

  const searchTitle = searchInput.value;
  searchInput.value = '';

  fetch(`https://omdbapi.com/?s=${searchTitle}&apikey=${credentials.apiKey}`).then(result => {
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
      element.innerText = match.Title;
      element.onclick = handleAddMovie;
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

function handleAddMovie(event){
  const element = event.target;
  const index = Array.prototype.indexOf.call(element.parentNode.children, element);
  const movie = searchMatches[index];

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
    image.setAttribute('src', data.poster);
    image.setAttribute('alt', data.title);

    const p1 = document.createElement('p');
    p1.innerText = data.title;

    const p2 = document.createElement('p');
    p2.innerText = data.year;

    const button = document.createElement('button');
    button.innerText = 'remove';
    button.onclick = handleRemoveMovie;

    movieElement.appendChildren([image, p1, p2, button]);

    movieListUl.appendChild(movieElement);
    movieList.push(movieElement);

    return data;
  });
}

function handleRemoveMovie(event) {
  const element = event.target.parentNode;
  const index = Array.prototype.indexOf.call(element.parentNode.children, element);
  const movieIdToRemove = movieList[index].dataset.id;

  fetch(`movies?movieId=${movieIdToRemove}`, { method: 'delete' })
  .then(result => result.json())
  .then(data => {

    movieList = movieList.filter(movie => {
      if(movie.dataset.id !== movieIdToRemove){
        return movie;
      }
    });
  
    const movieToRemoveLi = document.querySelector(`.watched.movie-list ul 
    li[data-id="${movieIdToRemove}"]`);

    movieToRemoveLi.remove();
    
    return data;
  });
}