<?php

  function lang($phrase)
  {
      static $lang = array(
        // Navbar Links
        'DASHBOARD'   => 'Dashboard',
        'CATEGORIES'  => 'Categories',
        'ITEMS'       => 'Items',
        'MEMBERS'     => 'Members',
        'COMMENTS'    => 'Comments',
        'STATISTICS'  => 'Statstics',
        'LOGS'        => 'Logs'
    );
      return $lang[$phrase];
  }
