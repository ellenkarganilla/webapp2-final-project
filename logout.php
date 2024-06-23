<?php
session_start();

session_destroy();

header("Location: Page01.php");
exit;