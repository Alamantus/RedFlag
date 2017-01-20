<?php
/**
 * Created by PhpStorm.
 * User: Robbie
 * Date: 1/19/2017
 * Time: 10:38 PM
 */
require_once('Terminology.php');

class Display {
    public static function render_link ($url) {
        $link_html = '<a href="' . $url . '" target="_self">';
            $link_html .= Terminology::$accept_text;
            $link_html .= $url;
        $link_html .= '</a>';

        echo $link_html;
    }

    public static function render_warning ($warning_type) {
        $terms = new Terminology();

        $warning_html = '<div class="warning">';
            $warning_html .= Terminology::$warning_intro . '<br />';
            $warning_html .= Terminology::$warning_types[$warning_type];
        $warning_html .= '</div>';

        echo $warning_html;
    }

    public static function render_page ($warning_type, $url) {
        echo ('
<!doctype html>
<html>
<head>
    <title>' . Terminology::$warning_types[$warning_type] . ' Warning</title>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.3.1/css/bulma.min.css" />
</head>
<body>
<section class="hero is-fullheight is-danger">
    <div class="hero-body">
        <div class="container has-text-centered">
            <h3 class="subtitle is-3">
                ' . Terminology::$warning_intro . '
            </h3>
            <h1 class="title is-1">
                ' . Terminology::$warning_types[$warning_type] . '
            </h1>
            
            <div class="container">
                <a class="button is-info is-large" href="' . $url . '">
                    ' . Terminology::$accept_text . $url . '
                </a>
                <br /><br />
                <a class="button is-warning is-outlined is-medium" href="' . $_SERVER['HTTP_REFERER'] . '">
                    ' . Terminology::$reject_text . '
                </a>
            </div>
        </div>
    </div>
</section>
</body>
</html>
    ');
    }
}