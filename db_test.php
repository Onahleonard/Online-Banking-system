<?php

require_once __DIR__ . "/_inc/dbconn.php";

if ($conn instanceof mysqli) {
    echo "DATABASE OK";
} else {
    echo "DATABASE FAILED";
}