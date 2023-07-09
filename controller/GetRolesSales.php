<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['role'])) {
    echo "C";
} else {
    echo $_SESSION['role'];
}
