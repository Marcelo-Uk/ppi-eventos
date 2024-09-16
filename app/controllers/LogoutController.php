<?php
session_start();
session_destroy();
header("Location: /eventos/public/index.php");
