<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Error 404</title>
    <link rel="shortcut icon" href="<?= base_url(); ?>img/icon.png" type="image/png">
    <link rel="stylesheet" href="<?= base_url(); ?>css/normalize.css" type="text/css">
    <link rel="stylesheet" href="<?= base_url(); ?>css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="<?= base_url(); ?>css/style.min.css" type="text/css">
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
    <div id="error-wrapper">
        <header id="error-header">
            <i class="fa fa-exclamation-triangle fa-2x fa-fw" aria-hidden="true"></i>&nbsp;ERROR 404
        </header>
        <div id="error-content">
            <p><?= $content ?><i class="fa fa-frown-o fa-fw" aria-hidden="true"></i></p>
        </div>
        <footer id="error-footer">
            <a href="<?= base_url(); ?>" data-tooltip="<?= $head ?>"><i class="fa fa-home fa-5x" aria-hidden="true"></i></a>
        </footer>
    </div>
</body>

</html>
