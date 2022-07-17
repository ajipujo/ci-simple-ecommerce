<?php

require_once(APPPATH."views/components/head.php");
require_once(APPPATH."views/frontpage/layouts/navigation.php");
?>


<div class="content-frontpage">

<?php
require_once(APPPATH."views/".$page.".php");
?>

</div>

<?php
require_once(APPPATH."views/components/footer.php");
?>
