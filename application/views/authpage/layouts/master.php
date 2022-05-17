<?php
require_once(APPPATH."views/components/head.php");
?>

<div class="d-flex flex-column min-vh-100 justify-content-center align-items-center">

<?php
require_once(APPPATH."views/".$page.".php");
?>

</div>

<?php
require_once(APPPATH."views/components/footer.php");
?>
