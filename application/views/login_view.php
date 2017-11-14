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
    <link rel="stylesheet" href="<?= base_url(); ?>css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="<?= base_url(); ?>css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="<?= base_url(); ?>css/admin.min.css" type="text/css">
</head>

<body class="bg-gray">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-5">

                <form action="<?= base_url(); ?>admin/login" method="POST" class="mt-5 px-5 pb-5 pt-3 bg-white">

                    <h1 class="display-4 mb-5">Please login</h1>

                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user fa-lg" aria-hidden="true"></i></span>
                            <input type="text" class="form-control form-control-lg" name="user" value="<?= set_value('user') ?>" placeholder="Username" required maxlength="50">
                        </div>
                        <?= form_error('user') ?>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                            <input type="password" class="form-control form-control-lg" name="password" value="<?php echo set_value('password'); ?>" placeholder="Password" required maxlength="20">
                        </div>
                        <?= form_error('password'); ?>
                    </div>

                    <div class="input-group">
                        <button type="submit" class="btn-block btn btn-primary btn-lg">Login</button>
                    </div>
                        
                    <?php if(isset($msg)) :?>
                        <p class="text-danger mt-4"><?= $msg ?></p>
                    <?php endif ?>

                </form>

            </div>
        </div>
    </div>

</body>

</html>