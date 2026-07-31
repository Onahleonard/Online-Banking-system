<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Contact Us</title>
        
        <link rel="stylesheet" href="assets/css/bank-theme.css?v=<?php echo time(); ?>">
        <style>
            .heading{
                font-weight:bold;
                color:#2E4372;
            }
        </style>
    </head>
    <?php include 'header.php' ?>
    <div class='content_customer'>
        <h3 style="text-align:center;color:#2E4372;"><u>Contact Us</u></h3>
        
        <div class="contact">
        <?php 
        include '_inc/dbconn.php';
        $sql = "SELECT * FROM contact_details";
        $res = mysql_query($sql);
        if ($res && mysql_num_rows($res) > 0) {
            while ($row = mysql_fetch_array($res)) {
                echo "<h3 style='color:#2E4372;'><u>" . htmlspecialchars($row['branch_name']) . "</u></h3>";
                echo "<p><span class='heading'>Address - </span>" . htmlspecialchars($row['address']) . "</p>";
                echo "<p><span class='heading'>Tel - </span>" . htmlspecialchars($row['phone']) . "</p>";
                echo "<p><span class='heading'>Email - </span>" . htmlspecialchars($row['email']) . "</p>";
            }
        } else {
            echo "<p style='text-align:center;'>No branch details available.</p>";
        }
        ?>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</html>
