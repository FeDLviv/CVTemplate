<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CV admin</title>
    <link rel="stylesheet" href="<?= base_url(); ?>css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="<?= base_url(); ?>css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="<?= base_url(); ?>css/admin.min.css" type="text/css">
</head>

<body>

    <nav id="mainNavbar">
        <ul class="bg-gray">
            <li>
                <a id="menu-toggle" href="#"><i class="fa fa-caret-square-o-left fa-lg fa-fw" aria-hidden="true"></i>&nbsp;Menu</a>
            </li>
            <li>
                <a href="<?= base_url(); ?>/admin/logout"><i class="fa fa-sign-out fa-lg fa-fw" aria-hidden="true"></i>&nbsp;Logout</a>
            </li>
        </ul>
    </nav>

    <div class="wrapper">

        <nav id="sidebar" class="nav flex-column bg-gray">
            <a class="nav-link active" data-toggle="tab" href="#settings">
                <i class="fa fa-cog fa-fw" aria-hidden="true"></i>&nbsp;Settings
            </a>
            <a class="nav-link" data-toggle="tab" href="#contact">
                <i class="fa fa-address-card fa-fw" aria-hidden="true"></i>&nbsp;Contact
            </a>
            <a class="nav-link" data-toggle="tab" href="#education">
                <i class="fa fa-university fa-fw" aria-hidden="true"></i>&nbsp;Education
            </a>
            <a class="nav-link" data-toggle="tab" href="#work">
                <i class="fa fa-briefcase fa-fw" aria-hidden="true"></i>&nbsp;Work experience
            </a>
            <a class="nav-link" data-toggle="tab" href="#skills">
                <i class="fa fa-code fa-fw" aria-hidden="true"></i>&nbsp;Skills
            </a>
            <a class="nav-link" data-toggle="tab" href="#languages">
                <i class="fa fa-language fa-fw" aria-hidden="true"></i>&nbsp;Languages
            </a>
        </nav>

        <div id="content">
            <div class="container-fluid p-3">
                <div class="row">
                    <div class="col">

                        <div class="tab-content">
                            <div id="settings" class="tab-pane fade show active">
                                <h3>Settings</h3>
                            </div>

                            <div id="contact" class="tab-pane fade">

                                <h3>Contact</h3>
                                <form id="formContact" action="<?= base_url(); ?>admin/ajax_contact" method="POST">
                                    <?php foreach($contacts as $key => $val) :?>
                                        <div class="form-group row">
                                            <label for="<?= $key ?>" class="col-2 col-form-label"><?= $key ?></label>
                                            <div class="col-10">
                                                <input class="form-control" type="text" value="<?= $val ?>" id="<?= $key ?>">
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                    <button id="butContact" type="submit" class="btn btn-primary">Save</button>    
                                </form>

                            </div>

                            <div id="education" class="tab-pane fade">
                                <h3>Education</h3>
                            </div>
                            <div id="work" class="tab-pane fade">
                                <h3>Work experience</h3>
                            </div>
                            <div id="skills" class="tab-pane fade">
                                <h3>Skills</h3>
                            </div>
                            <div id="languages" class="tab-pane fade">
                                <h3>Languages</h3>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="<?= base_url(); ?>js/jquery-3.2.1.min.js"></script>
    <script src="<?= base_url(); ?>js/bootstrap.min.js"></script>
    <script src="<?= base_url(); ?>js/admin.min.js"></script>

</body>

</html>