<?php

  include 'init.php';

  echo 'Welcome to categories page<br>';

  echo 'Your Page ID Is ' . $_GET['pageid'];

  include $tpl . 'footer.php';
