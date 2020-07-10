<?php include './src/app/views/Header/index.php' ?>
<style><?php include 'styles.css' ?></style>
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
      <button type="submit">add new movie</button>
    </div>
  </form>
  <h2>Plan to watch</h2>
  <div class="plan-to-watch movie-list">
    <ul>
      <p>No movies added yet</p>
    </ul>
  </div>
  <hr color="#555"/>
  <h2>Watched</h2>
  <div class="watched movie-list">
    <ul>
      <?php if ($GLOBALS['movies']): ?>
        <?php foreach ($GLOBALS['movies'] as $movie): ?>
          <li data-id="<?=$movie['id']?>">
            <div>
              <img src="<?=$movie['poster']?>" alt="<?= $movie['title'] ?>">
            </div>
            <strong><?=$movie['title']?></strong>
            <p><?=$movie['year']?></p>
            <button>remove</button>
          </li>
        <?php endforeach ?>
      <?php else : ?>
      <p>No movies added yet</p>
      <?php endif ?>
    </ul>
    <div class="movie-details">
      <div>
        <main>
          <h3>Casino Royale</h3>
          <h4>After earning 00 status and a licence to kill, Secret Agent James
            Bond sets out on his first mission as 007. Bond must defeat a private
              banker funding terrorists in a high-stakes game of poker at Casino
              Royale, Montenegro.</h4>
          <button>Remove from list</button>
          <p>Starring: <strong>Daniel Craig, Eva Green, Mads Mikkelsen, Judi Dench</strong></p>
          <p>IMDb: 7.5</p>
        </main>
        <aside>
          <div class="poster"></div>
        </aside>
      </div>
    </div>
  </div>
</section>
<script>
  const credentials = <?php include './credentials.json' ?>;
  <?php include 'scripts.js' ?>
</script>
<?php include './src/app/views/Footer/index.php' ?>