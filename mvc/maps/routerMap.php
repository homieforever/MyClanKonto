<?php
    $values = array(
        // Seite
        
        array("/:clanid/site/", array('controller' => 'site', 'action' => '')),
        array("/:clanid/site/:site/", array('controller' => 'site', 'action' => '')),
        array("/:clanid/site/:site/:id", array('controller' => 'site', 'action' => '')),
        
        // Admin
        
        array("/:clanid/admin/", array('controller' => 'admin', 'action' => '')),
        array("/:clanid/admin/:site/", array('controller' => 'admin', 'action' => '')),
        array("/:clanid/admin/:site/:id", array('controller' => 'admin', 'action' => ''))
    );
?>