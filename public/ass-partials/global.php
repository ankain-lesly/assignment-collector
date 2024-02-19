<?php
session_start();
date_default_timezone_set("Africa/Douala");

$deadline = "Mon Feb 19, 2023 10:00 PM";
// $deadline = "Nov 8, 2023 6:30 PM";

$onDate = strtotime($deadline) > time();

$status = $_GET['status'] ?? null;
$submitted = $_SESSION['submitted'] ?? null;

// auth
$user = $_SESSION['auth_user'] ?? null;

if ($status === "resubmit") {
  unset($_SESSION['submitted']);
  header("Location: /assignments");
}
