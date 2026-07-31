<?php
session_start();
if(!isset($_SESSION['admin_login'])) {
    header('location:adminlogin.php');
    exit();
}

include '_inc/dbconn.php';

$msg = '';
if (isset($_POST['save_contact'])) {
    foreach ($_POST['branches'] as $id => $branch_data) {
        $id_escaped = mysql_real_escape_string($id);
        $name = mysql_real_escape_string($branch_data['name']);
        $address = mysql_real_escape_string($branch_data['address']);
        $phone = mysql_real_escape_string($branch_data['phone']);
        $email = mysql_real_escape_string($branch_data['email']);
        
        mysql_query("UPDATE contact_details SET branch_name='$name', address='$address', phone='$phone', email='$email' WHERE id='$id_escaped'") or die(mysql_error());
    }
    $msg = "Support contact details updated successfully!";
}

$sql = "SELECT * FROM contact_details";
$res = mysql_query($sql);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Edit Contact details</title>
        <link rel="stylesheet" href="newcss.css">
        <style>
            .contact_box {
                margin: 20px auto;
                width: 60%;
                border: 1px solid #2E4372;
                padding: 15px;
                border-radius: 8px;
                background-color: #fcfcfc;
            }
            .contact_box table {
                width: 100%;
            }
            .contact_box td {
                padding: 5px;
            }
            .msg {
                text-align: center;
                color: green;
                font-weight: bold;
                margin: 10px;
            }
        </style>
    </head>
    <body>
        <?php include 'header.php'; ?>
        <div class="displaystaff_content">
            <?php include 'admin_navbar.php'; ?>
            
            <h3 style="text-align:center;color:#2E4372;"><u>Edit Support Contact Details</u></h3>
            
            <?php if (!empty($msg)) echo "<div class='msg'>$msg</div>"; ?>
            
            <form method="POST" action="">
                <?php 
                while ($row = mysql_fetch_array($res)) {
                    $id = $row['id'];
                ?>
                    <div class="contact_box">
                        <h4 style="color:#2E4372; border-bottom:1px solid #2E4372; padding-bottom:5px; margin-top:5px;">
                            Branch ID #<?php echo $id; ?>
                        </h4>
                        <table>
                            <tr>
                                <td style="width:25%;"><strong>Branch Name:</strong></td>
                                <td><input type="text" name="branches[<?php echo $id; ?>][name]" value="<?php echo htmlspecialchars($row['branch_name']); ?>" required style="width:90%;"></td>
                            </tr>
                            <tr>
                                <td><strong>Address:</strong></td>
                                <td><textarea name="branches[<?php echo $id; ?>][address]" required style="width:90%; height:50px;"><?php echo htmlspecialchars($row['address']); ?></textarea></td>
                            </tr>
                            <tr>
                                <td><strong>Phone/Tel:</strong></td>
                                <td><input type="text" name="branches[<?php echo $id; ?>][phone]" value="<?php echo htmlspecialchars($row['phone']); ?>" required style="width:90%;"></td>
                            </tr>
                            <tr>
                                <td><strong>Email:</strong></td>
                                <td><input type="email" name="branches[<?php echo $id; ?>][email]" value="<?php echo htmlspecialchars($row['email']); ?>" required style="width:90%;"></td>
                            </tr>
                        </table>
                    </div>
                <?php } ?>
                
                <table align="center" style="margin-bottom: 30px;">
                    <tr>
                        <td>
                            <input type="submit" name="save_contact" value="SAVE ALL CHANGES" class="addstaff_button">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        <?php include 'footer.php'; ?>
    </body>
</html>

