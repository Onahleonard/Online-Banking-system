<?php
// _inc/dbconn.php - Core Database Connection & Compatibility Layer
$serverName = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "bank_db";

$conn = null;
try {
    $conn = mysqli_connect($serverName, $dbusername, $dbpassword, $dbname);
} catch (mysqli_sql_exception $exception) {
    error_log("[dbconn] Connection error: " . $exception->getMessage());
    $conn = null;
}

if ($conn === false) {
    error_log("[dbconn] Database connection failed: " . mysqli_connect_error());
    $conn = null;
}

// Legacy mysql_* compatibility shims
if (!function_exists('mysql_query')) {
    function mysql_query($query, $link = null) {
        global $conn;
        $l = $link ? $link : $conn;
        if (!$l) return false;
        return mysqli_query($l, $query);
    }
}

if (!function_exists('mysql_fetch_array')) {
    function mysql_fetch_array($result, $result_type = MYSQLI_BOTH) {
        if (!$result || !($result instanceof mysqli_result)) return false;
        return mysqli_fetch_array($result, $result_type);
    }
}

if (!function_exists('mysql_real_escape_string')) {
    function mysql_real_escape_string($unescaped_string, $link = null) {
        global $conn;
        $l = $link ? $link : $conn;
        if (!$l) return addslashes($unescaped_string);
        return mysqli_real_escape_string($l, $unescaped_string);
    }
}

if (!function_exists('mysql_error')) {
    function mysql_error($link = null) {
        global $conn;
        $l = $link ? $link : $conn;
        if (!$l) return mysqli_connect_error();
        return mysqli_error($l);
    }
}

if (!function_exists('mysql_fetch_row')) {
    function mysql_fetch_row($result) {
        if (!$result || !($result instanceof mysqli_result)) return false;
        return mysqli_fetch_row($result);
    }
}

if (!function_exists('mysql_num_rows')) {
    function mysql_num_rows($result) {
        if (!$result || !($result instanceof mysqli_result)) return 0;
        return mysqli_num_rows($result);
    }
}

if (!function_exists('mysql_insert_id')) {
    function mysql_insert_id($link = null) {
        global $conn;
        $l = $link ? $link : $conn;
        if (!$l) return 0;
        return mysqli_insert_id($l);
    }
}

if (!function_exists('mysql_close')) {
    function mysql_close($link = null) {
        global $conn;
        $l = $link ? $link : $conn;
        if ($l) return mysqli_close($l);
        return true;
    }
}

// Auto-initialize required operational tables
if ($conn) {
    mysqli_query($conn, "CREATE TABLE IF NOT EXISTS `pending_transfers` (
      `id` INT AUTO_INCREMENT PRIMARY KEY,
      `sender_id` INT NOT NULL,
      `sender_name` VARCHAR(255) NOT NULL,
      `reciever_id` INT NOT NULL,
      `reciever_name` VARCHAR(255) NOT NULL,
      `amount` DECIMAL(10,2) NOT NULL,
      `date` DATE NOT NULL,
      `narration` VARCHAR(255),
      `status` VARCHAR(15) DEFAULT 'PENDING'
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

    mysqli_query($conn, "CREATE TABLE IF NOT EXISTS `contact_details` (
      `id` INT AUTO_INCREMENT PRIMARY KEY,
      `branch_name` VARCHAR(255) NOT NULL,
      `address` VARCHAR(255) NOT NULL,
      `phone` VARCHAR(255) NOT NULL,
      `email` VARCHAR(255) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

    $checkContact = mysqli_query($conn, "SELECT COUNT(*) FROM `contact_details`");
    if ($checkContact) {
        $countRow = mysqli_fetch_row($checkContact);
        if ($countRow && $countRow[0] == 0) {
            mysqli_query($conn, "INSERT INTO `contact_details` (`branch_name`, `address`, `phone`, `email`) VALUES
                ('Kolkata Branch', 'Globsyn Business School, IBRAD business school, Keshtopur, Kolkata.', '033-456892/12', 'kolkatabranch@onlinebank.com'),
                ('Delhi Branch', 'Globsyn Business School, Sector V-A, Malviya Nagar, Delhi.', '013-456856/32', 'delhibranch@onlinebank.com'),
                ('Bangalore Branch', 'Globsyn Business School, Near City Center, Kamarthalli, Bangalore.', '022-456854/11', 'bangalorebranch@onlinebank.com');");
        }
    }

    mysqli_query($conn, "CREATE TABLE IF NOT EXISTS `device_verification` (
      `id` INT AUTO_INCREMENT PRIMARY KEY,
      `user_id` INT NOT NULL,
      `device_token` VARCHAR(255) NOT NULL,
      `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
      UNIQUE KEY `user_device` (`user_id`, `device_token`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");

    mysqli_query($conn, "CREATE TABLE IF NOT EXISTS `temp_otp` (
      `id` INT AUTO_INCREMENT PRIMARY KEY,
      `user_id` INT NOT NULL,
      `otp_code` VARCHAR(10) NOT NULL,
      `auth_code` VARCHAR(10) DEFAULT NULL,
      `otp_verified` TINYINT(1) DEFAULT 0,
      `auth_verified` TINYINT(1) DEFAULT 0,
      `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
}
