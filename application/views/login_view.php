<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Authentication</title>
</head>

<body>

    <?php echo form_open('admin/authentication'); ?>

        <h3>User</h3>
        <input type="text" name="user" value="<?= set_value('user') ?>" required size="50">
        <?php echo form_error('user', '<div class="error">', '</div>'); ?>

        <h3>Password</h3>
        <input type="text" name="password" value="<?php echo set_value('password'); ?>" required size="20">
        <?php echo form_error('password', '<div class="error">', '</div>'); ?>

        <button type="submit">OK</button>

    </form>

</body>

</html>
