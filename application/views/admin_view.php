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
    <link rel="stylesheet" href="<?= base_url(); ?>css/bootstrap-editable.css" type="text/css">
    <link rel="stylesheet" href="<?= base_url(); ?>css/admin.min.css" type="text/css">
</head>

<body>

    <nav id="mainNavbar">
        <ul class="bg-gray">
            <li>
                <a id="menu-toggle" href="#"><i class="fa fa-caret-square-o-left fa-lg fa-fw" aria-hidden="true"></i>&nbsp;Menu</a>
            </li>
            <li id="linkSite">
                <a href="<?= base_url(); ?>"><i class="fa fa-home fa-lg" aria-hidden="true"></i>&nbsp;<?= $settings['Head'] ?></a>
            </li>
            <li>
                <a href="<?= base_url(); ?>/admin/logout"><i class="fa fa-sign-out fa-lg fa-fw" aria-hidden="true"></i>&nbsp;Logout</a>
            </li>
        </ul>
    </nav>

    <div id="wrapper">

        <nav id="sidebar" class="nav flex-column bg-gray">
            <a class="nav-link active" data-toggle="tab" href="#settings">
                <i class="fa fa-cog fa-fw" aria-hidden="true"></i>&nbsp;<span class="item">Settings</span>
            </a>
            <a class="nav-link" data-toggle="tab" href="#contact">
                <i class="fa fa-address-card fa-fw" aria-hidden="true"></i>&nbsp;<span class="item">Contact</span>
            </a>
            <a class="nav-link" data-toggle="tab" href="#education">
                <i class="fa fa-university fa-fw" aria-hidden="true"></i>&nbsp;<span class="item">Education</span>
            </a>
            <a class="nav-link" data-toggle="tab" href="#work">
                <i class="fa fa-briefcase fa-fw" aria-hidden="true"></i>&nbsp;<span class="item">Work experience</span>
            </a>
            <a class="nav-link" data-toggle="tab" href="#skills">
                <i class="fa fa-code fa-fw" aria-hidden="true"></i>&nbsp;<span class="item">Skills</span>
            </a>
            <a class="nav-link" data-toggle="tab" href="#languages">
                <i class="fa fa-language fa-fw" aria-hidden="true"></i>&nbsp;<span class="item">Languages</span>
            </a>
        </nav>

        <div id="content">
            <div class="container-fluid p-3">
                <div class="row">
                    <div class="col">

                        <div class="tab-content">

                            <div id="settings" class="tab-pane fade show active">
                                <h3><i class="fa fa-cog fa-fw" aria-hidden="true"></i>&nbsp;Settings</h3>
                                <form id="formSettings" action="<?= base_url(); ?>admin/ajax_settings" method="POST" enctype="multipart/form-data">
                                    <?php foreach ($settings as $key => $val) :?>
                                        <div class="form-group row">
                                            <label for="<?= $key ?>" class="col-2 col-form-label">
                                                <?= $key ?>
                                            </label>
                                            <div class="col-10">
                                                <?php if ($key == 'CV_path' || $key == 'Photo_path') :?>
                                                    <div class="btn-group">
                                                        <input id="<?= $key ?>" class="form-control-file" type="file" name="<?= $key ?>" accept="<?= ($key=='Photo_path') ? '.png' : '.pdf' ?>">
                                                        <button id="but<?= $key ?>" class="btn btn-outline-primary" <?php if ($val === '') {
                                                            echo 'disabled';
}?>>Delete</button>
                                                    </div>
                                                <?php else :?>
                                                    <input id="<?= $key ?>" class="form-control" type="text" name="<?= $key ?>" value="<?= $val ?>" placeholder="<?= $val ?>" required maxlength="30">
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                    <button id="butContact" type="submit" class="btn btn-primary">Save</button>
                                </form>
                            </div>

                            <div id="contact" class="tab-pane fade">
                                <h3><i class="fa fa-address-card" aria-hidden="true"></i>&nbsp;Contact</h3>
                                <form id="formContact" action="<?= base_url(); ?>admin/ajax_contact" method="POST">
                                    <?php foreach ($contacts as $key => $val) :?>
                                    <div class="form-group row">
                                        <label for="<?= $key ?>" class="col-2 col-form-label">
                                            <?= $key ?>
                                        </label>
                                        <div class="col-10">
                                            <?php switch ($key) :
                                                case 'Email':
                                                            ?>
                                            <input id="<?= $key ?>" class="form-control" type="email" name="<?= $key ?>" value="<?= $val ?>" placeholder="<?= $val ?>"
                                                required maxlength="100">
                                            <?php
                                                          break; ?>
                                                <?php case 'Phone':
                                                        ?>
                                                <input id="<?= $key ?>" class="form-control" type="text" name="<?= $key ?>" value="<?= $val ?>" placeholder="<?= $val ?>"
                                                    required pattern="^\+\d{2}\s\(\d{3}\)\s\d{3}\s\d{2}\s\d{2}$">
                                                <?php
                                                          break; ?>
                                                    <?php case 'GitHub':
                                                        ?>
                                                    <input id="<?= $key ?>" class="form-control" type="text" name="<?= $key ?>" value="<?= $val ?>" placeholder="<?= $val ?>"
                                                        required type="URL" maxlength="100">
                                                    <?php
                                                          break; ?>
                                                        <?php default:
                                                        ?>
                                                        <input id="<?= $key ?>" class="form-control" type="text" name="<?= $key ?>" value="<?= $val ?>" placeholder="<?= $val ?>"
                                                            required maxlength="50">
                                                        <?php
                                                          break; ?>
                                                            <?php endswitch; ?>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                    <button id="butContact" type="submit" class="btn btn-primary">Save</button>
                                </form>
                            </div>

                            <div id="education" class="tab-pane fade">
                                <h3><i class="fa fa-university fa-fw" aria-hidden="true"></i>&nbsp;Education</h3>
                                <table id="tabEducation" class="table table-bordered table-hover table-sm">
                                    <thead class="thead-inverse">
                                        <tr>
                                            <?php foreach ($tables['education'] as $col) :?>
                                                <th><?= $col ?></th>
                                            <?php endforeach; ?> 
                                                <th>action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th class="text-center">NEW:</th>
                                            <td><a href="" class="education-ediatble-add education-ediatble-add-req" data-name="institute" data-type="text"></a></td>
                                            <td><a href="" class="education-ediatble-add education-ediatble-add-req" data-name="title" data-type="text"></a></td>
                                            <td><a href="" class="education-ediatble-add education-ediatble-add-not-req" data-name="speciality" data-type="text"></a></td>
                                            <td><a href="" class="education-ediatble-add education-ediatble-add-not-req" data-name="specialization" data-type="text"></a></td>
                                            <td><a href="" class="education-ediatble-add education-ediatble-add-date" data-name="start" data-type="text"></a></td>
                                            <td><a href="" class="education-ediatble-add education-ediatble-add-date-not-req" data-name="stop" data-type="text"></a></td>                                            
                                            <th colspan="2" class="text-center">
                                                <button id="butAddEducation" class="btn btn-outline-primary btn-block" data-ajax="<?= base_url(); ?>admin/ajax_insert_education">Add</button>
                                            </th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php if (count($education)) :?>
                                            <?php foreach ($education as $row) :?>
                                                <tr>
                                                    <td class="text-center"><?= $row['id'] ?></td>
                                                    <td><a href="" class="education-ediatble" data-pk="<?= $row['id'] ?>" data-name="institute" data-url="<?= base_url(); ?>admin/ajax_update_row" data-type="text"><?= $row['institute'] ?></a></td>
                                                    <td><a href="" class="education-ediatble" data-pk="<?= $row['id'] ?>" data-name="title" data-url="<?= base_url(); ?>admin/ajax_update_row" data-type="text"><?= $row['title'] ?></a></td>
                                                    <td><a href="" class="education-ediatble-not-req" data-pk="<?= $row['id'] ?>" data-name="speciality" data-url="<?= base_url(); ?>admin/ajax_update_row" data-type="text"><?= $row['speciality'] ?></a></td>
                                                    <td><a href="" class="education-ediatble-not-req" data-pk="<?= $row['id'] ?>" data-name="specialization" data-url="<?= base_url(); ?>admin/ajax_update_row" data-type="text"><?= $row['specialization'] ?></a></td>
                                                    <td><a href="" class="education-ediatble-date" data-pk="<?= $row['id'] ?>" data-name="start" data-url="<?= base_url(); ?>admin/ajax_update_row" data-type="text"><?= $row['start'] ?></a></td>
                                                    <td><a href="" class="education-ediatble-date-not-req" data-pk="<?= $row['id'] ?>" data-name="stop" data-url="<?= base_url(); ?>admin/ajax_update_row" data-type="text"><?= $row['stop'] ?></a></td>
                                                    <td class="text-center"><?= $row['dateChange'] ?></td>
                                                    <td class="text-center"><button class="btn btn-outline-primary" data-url="<?= base_url(); ?>admin/ajax_delete_row">Delete</button></td>
                                                <tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>     
                                    </tbody>
                                </table>
                            </div>

                            <div id="work" class="tab-pane fade">
                                <h3>Work experience</h3>
                            </div>

                            <div id="skills" class="tab-pane fade">
                                <h3>Skills</h3>
                            </div>

                            <div id="languages" class="tab-pane fade">
                                <h3><i class="fa fa-language" aria-hidden="true"></i>&nbsp;Languages</h3>
                                <table id="tabLanguage" class="table table-bordered table-hover table-sm">
                                    <thead class="thead-inverse">
                                        <tr>
                                            <?php foreach ($tables['language'] as $col) :?>
                                                <th><?= $col ?></th>
                                            <?php endforeach; ?> 
                                                <th>action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th class="text-center">NEW:</th>
                                            <td><a href="" class="language-ediatble-add" data-name="name" data-type="text"></a></td>
                                            <td><a href="" class="language-ediatble-add" data-name="level" data-type="select" data-source="<?= base_url(); ?>admin/ajax_language_enum"></a></td>
                                            <th colspan="2" class="text-center">
                                                <button id="butAddLanguage" class="btn btn-outline-primary btn-block" data-ajax="<?= base_url(); ?>admin/ajax_insert_language">Add</button>
                                            </th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php if (count($languages)) :?>
                                            <?php foreach ($languages as $row) :?>
                                                <tr>
                                                    <td class="text-center"><?= $row['id'] ?></td>
                                                    <td><a href="" class="language-ediatble" data-pk="<?= $row['id'] ?>" data-name="name" data-url="<?= base_url(); ?>admin/ajax_update_row" data-type="text"><?= $row['name'] ?></a></td>
                                                    <td><a href="" class="language-ediatble" data-pk="<?= $row['id'] ?>" data-name="level" data-url="<?= base_url(); ?>admin/ajax_update_row" data-type="select" data-source="<?= base_url(); ?>admin/ajax_language_enum"><?= $row['level'] ?></a></td>
                                                    <td class="text-center"><?= $row['dateChange'] ?></td>
                                                    <td class="text-center"><button class="btn btn-outline-primary" data-url="<?= base_url(); ?>admin/ajax_delete_row">Delete</button></td>
                                                <tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>     
                                    </tbody>
                                </table>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <div id="modalDialog" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">CV admin</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4 id="modalText"></h4>
                    <div id="modalError"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url(); ?>js/lib/jquery-3.2.1.min.js"></script>
    <script src="<?= base_url(); ?>js/lib/bootstrap.min.js"></script>
    <script src="<?= base_url(); ?>js/lib/bootstrap-editable.min.js"></script>
    <script src="<?= base_url(); ?>js/admin.min.js"></script>

</body>

</html>
