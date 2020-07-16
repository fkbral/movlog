<?php include './src/app/views/Header/index.php' ?>
<link rel="stylesheet" href="movies/styles.css">
<div id="movie-modal" class="backdrop">
  <div class="modal">
    <button data-close>
      <span>x</span>
    </button>
    <div class="content">
      <div class="poster">
        <img src="" alt=""
        onerror="this.onerror=null; this.src='./public/assets/no-cover.jpg'"
        >
      </div>
      <div class="details">
        <p class="title">
          <strong><span></span></strong>
          <small class="year"><span></span></small>
          <small class="runtime"><span></span></small>
          <small class="rated"><span></span></small>
        </p>
        <hr color="#555">
        <p class="released"><strong>Released: </strong><span></span></p>
        <p class="actors"><strong>Starring: </strong><span></span></p>
        <p class="director"><strong>Director: </strong><span></span></p>
        <p class="writer"><strong>Writer: </strong><span></span></p>
        <p class="genre"><strong>Genre: </strong><span></span></p>
        <br/>
        <p class="plot"><span></span></p>
        <br/>
        <p class="awards"><strong>Awards: </strong><span></p>
        <br/>
        <div class="rating">
          <i class="fab fa-imdb"></i>
          <strong class="imdb_rating"><span>8.0</span></strong>
        </div>
      </div>
    </div>
  </div>
</div>
<section>
  <h1>My Movies <a href="#" onclick="history.back()">Back to start</a> </h1>
  <form action="." id="search-form">
    <div class="search-group">
      <div>
        <input 
        id="search" type="text" 
        placeholder="search for movie title" 
        autocomplete="off">
        <div id="search-results">
          <ul></ul>
        </div>
      </div>
      <button type="submit">
        <i class="fas fa-search"></i>
        <span>search</span>
      </button>
    </div>
  </form>
  <h2>Plan to watch</h2>
  <div class="planned movie-list">
    <ul>
      <?php if ($GLOBALS['movies']): ?>
        <?php foreach ($GLOBALS['movies'] as $movie): ?>
          <?php if ($movie['status'] == 0): ?>
            <li data-id="<?=$movie['id']?>">
              <div data-cover>
                <div class="actions">
                  <div class="removeAndStatus">
                    <button data-action="status"
                      data-id="<?=$movie['id']?>"
                      data-status="<?=$movie['status']?>"
                    >
                      <i class="far fa-eye fa-fw"></i>
                    </button>
                    <button data-id="<?=$movie['id']?>" data-action="remove">
                      <i class="far fa-trash-alt fa-fw"></i>
                    </button>
                  </div>
                  <button class="to-details" data-action="fetch" 
                  data-id="<?=$movie['id']?>"
                  data-details="<?=$movie['has_details']?>">
                    <i class="fas fa-chevron-up"></i>
                  </button>
                </div>
                <img src="<?=$movie['poster']?>" alt="<?=$movie['title']?>"
                onerror="this.onerror=null; this.src='./public/assets/no-cover.jpg'"
                >
              </div>
              <strong><?=$movie['title']?></strong>
              <p><?=$movie['year']?></p>
            </li>
          <?php endif ?>
        <?php endforeach ?>
      <?php else : ?>
      <p>No movies added yet</p>
      <?php endif ?>
    </ul>
  </div>
  <hr color="#555"/>
  <h2>Watched</h2>
  <div class="watched movie-list">
    <ul>
      <?php if ($GLOBALS['movies']): ?>
        <?php foreach ($GLOBALS['movies'] as $movie): ?>
          <?php if ($movie['status'] == 1): ?>
            <li data-id="<?=$movie['id']?>">
              <div data-cover>
                <div class="actions">
                  <div class="removeAndStatus">
                    <button data-action="status"
                    data-id="<?=$movie['id']?>"
                    data-status="<?=$movie['status']?>"
                    >
                      <i class="far fa-clock fa-fw"></i>
                    </button>
                    <button data-id="<?=$movie['id']?>" data-action="remove">
                      <i class="far fa-trash-alt fa-fw"></i>
                    </button>
                  </div>
                  <button class="to-details" data-action="fetch"
                  data-id="<?=$movie['id']?>"
                  data-details="<?=$movie['has_details']?>"
                  >
                    <i class="fas fa-chevron-up"></i>
                  </button>
                </div>
                <img src="<?=$movie['poster']?>" alt="<?=$movie['title']?>"
                onerror="this.onerror=null; this.src='./public/assets/no-cover.jpg'"
                >
              </div>
              <strong><?=$movie['title']?></strong>
              <p><?=$movie['year']?></p>
            </li>
          <?php endif ?>
        <?php endforeach ?>
      <?php else : ?>
      <p>No movies added yet</p>
      <?php endif ?>
    </ul>
  </div>
</section>
<script>
  const credentials = <?php include './credentials.json' ?>;
  const movies = <?php echo json_encode($GLOBALS['movies']) ?>;
  <?php include 'scripts.js' ?>
</script>
<?php include './src/app/views/Footer/index.php' ?>