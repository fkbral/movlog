<?php include './src/app/views/Header/index.php' ?>
<section>
  <h1>Users <a href="#" onclick="history.back()">Back to start</a></h1>
  <ul>
  <?php foreach($GLOBALS['users'] as $user): ?>
    <li><?= $user['name'] ?></li>
    <?php endforeach ?>
  </ul>
</section>
<?php include './src/app/views/Footer/index.php' ?>