<?php
session_start();
session_destroy();
header("Location: /a2/index.php");
exit;
?>
