<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title><?= $head ?></title>
    <link rel="shortcut icon" href="<?= base_url(); ?>images/icon.png" type="image/png">
    <link rel="stylesheet" href="<?= base_url(); ?>css/normalize.css" type="text/css">
    <link rel="stylesheet" href="<?= base_url(); ?>css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="<?= base_url(); ?>css/style.min.css" type="text/css">
    <script src="<?= base_url(); ?>js/script.min.js" type="text/javascript"></script>
    <script>
        (function(i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function() {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-99340284-1', 'auto');
        ga('send', 'pageview');
    </script>
</head>

<body>
    <div id="wrapper">
        <header id="header">
            <div id="logo" data-tooltip="Download CV">
                <a href="<?= $CV_path ?>" download><img src="images/logo.png" alt=""></a>
            </div>
            <div id="photo">
                <img src="<?= $photo_path ?>" alt="">
            </div>
            <div id="name">
                <?= $title ?>
            </div>
        </header>
        <main id="content">
            <?php if (count($contacts)) :?>
                <h1><i class="fa fa-address-card fa-fw" aria-hidden="true"></i>&nbsp;Contact:</h1>
                <table>
                    <?php foreach ($contacts as $key => $val) :?>
                        <tr>
                            <td><?= $key ?>:</td>
                            <?php switch ($key) :
                                case 'Email':
                                            ?>
                                <td><a href="mailto:<?= $val ?>?subject=CV"><?= $val ?></a></td>
                            <?php
                                          break; ?>
                            <?php case 'Phone':
                                            ?>
                                <td id="telephone"><?= $val ?></td>
                            <?php
                                          break; ?>
                            <?php case 'GitHub':
                                            ?>
                                <td><a href="<?= $val ?>" target="_blank"><?= basename($val) ?></a></td>
                            <?php
                                          break; ?>
                            <?php default:
                                            ?>
                                <td><?= $val ?></td>
                            <?php
                                          break; ?>
                            <?php endswitch; ?>
                        </tr>           
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
            <?php if (count($education)) :?>
                <h1><i class="fa fa-university fa-fw" aria-hidden="true"></i>&nbsp;Education:</h1>
                <table>
                    <?php foreach ($education as $row) :?>
                        <tr>
                            <td><?= $row['institute'] ?> <span class="font-date">(<?= $row['start'] ?>-<?= $row['stop'] ?>)</span></td>
                            <td>
                                <ul>
                                    <li><?= $row['title'] ?></li>
                                    <?php if (isset($row['speciality'])) :?>
                                        <li>Speciality: <span class="font-comment"><?= $row['speciality'] ?></span></li>
                                    <?php endif; ?>
                                    <?php if (isset($row['specialization'])) :?>
                                        <li>Specialization: <span class="font-comment"><?= $row['specialization'] ?></span></li>
                                    <?php endif; ?>
                                </ul>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
            <?php if (count($works)) :?>
                <h1><i class="fa fa-briefcase fa-fw" aria-hidden="true"></i>&nbsp;Work experience:</h1>
                <table>
                    <?php foreach ($works as $row) :?>
                        <tr>
                            <td><?= $row['organisation'] ?> <span class="font-date">(<?= $row['start'] ?>-<?= $row['stop'] ?>)</span></td>
                            <td><?= $row['position'] ?></li></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
            <?php if (count($skills)) :?>
                <h1><i class="fa fa-code fa-fw" aria-hidden="true"></i>&nbsp;Skills:</h1>
                <table>
                    <?php if (isset($skills['language'])) :?>
                        <tr>
                            <td>Programming languages:</td>
                            <td>
                                <?php foreach ($skills['language'] as $row) :?>
                                    <?= $row['name'] ?><span class="font-comment"> (<?= $row['level'] ?>)</span><?php if (end($skills['language']) !== $row) :
?>,<?php
endif; ?>
                                <?php endforeach; ?>
                            </td>                   
                        </tr>
                    <?php endif; ?>
                    <?php if (isset($skills['database'])) :?>
                        <tr>
                            <td>Databases:</td>
                            <td>
                                <?php foreach ($skills['database'] as $row) :?>
                                    <?= $row['name'] ?><span class="font-comment"> (<?= $row['level'] ?>)</span><?php if (end($skills['database']) !== $row) :
?>,<?php
endif; ?>
                                <?php endforeach; ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php if (isset($skills['technologie'])) :?>
                        <tr>
                            <td>Other software/technologies:</td>
                            <td>
                                <?php foreach ($skills['technologie'] as $row) :?>
                                    <?= $row['name'] ?><span class="font-comment"> (<?= $row['level'] ?>)</span><?php if (end($skills['technologie']) !== $row) :
?>,<?php
endif; ?>
                                <?php endforeach; ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php if (isset($skills['os'])) :?>
                        <tr>
                            <td>Operating systems:</td>
                            <td>
                                <?php foreach ($skills['os'] as $row) :?>
                                    <?= $row['name'] ?><span class="font-comment"> (<?= $row['level'] ?>)</span><?php if (end($skills['os']) !== $row) :
?>,<?php
endif; ?>
                                <?php endforeach; ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                </table>
            <?php endif; ?>
            <?php if (count($languages)) :?>
                <h1><i class="fa fa-language fa-fw" aria-hidden="true"></i>&nbsp;Languages:</h1>
                <table>
                    <tr>
                        <td></td>
                        <td>
                            <?php foreach ($languages as $row) :?>
                                <?= $row['name'] ?><span class="font-comment"> (<?= $row['level'] ?>)</span><?php if (end($languages) !== $row) :
?>,<?php
endif; ?>
                            <?php endforeach; ?>
                        </td>
                    </tr>
                </table>
            <?php endif; ?>
        </main>
        <footer id="footer">
            <p data-tooltip="Only HTML, CSS, JS">Last edited: <?= $last_change ?></p>
            <div id="scrollup">
                <i class="fa fa-chevron-circle-up fa-3x" aria-hidden="true"></i>
            </div>
        </footer>
    </div>
</body>

</html>
