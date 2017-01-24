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

    public static function render_comma_list ($string_array) {
        $result = '';
        $array_length = count($string_array);
        for ($i = 0; $i < $array_length; $i++) {
            $result .= $string_array[$i];
            if ($array_length > 1) {
                if ($array_length > 2 && $i < $array_length - 1) {
                    $result .= ',';
                }
                $result .= ' ';
                if ($i === $array_length - 2) {
                    $result .= 'and ';
                }
            }
        }

        return $result;
    }

    public static function get_website_path () {
        $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'https' : 'http';
        return $protocol . '://' . $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);
    }

    private static function render_html_wrapper ($page_content, $page_title = false, $image_text = false) {
        $page_title = ($page_title !== false) ? $page_title : Terminology::$site_name;
        $image_text = ($image_text !== false) ? urlencode($image_text) : Terminology::$site_name;
        $image_url = Display::get_website_path() . '/actions/warn-image.php?text=' . $image_text;
        $page_description = Terminology::$site_description;

        return ('
<!doctype html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>' . $page_title . '</title>
    <!-- Search engines -->
    <meta name="description" content="' . $page_description . '">
    <!-- Google Plus -->
    <!-- Update your html tag to include the itemscope and itemtype attributes. -->
    <!-- html itemscope itemtype="http://schema.org/{CONTENT_TYPE}" -->
    <meta itemprop="name" content="'. $page_title . '" />
    <meta itemprop="description" content="' . $page_description . '" />
    <meta itemprop="image" content="' . $image_url . '" />
    <!-- Twitter -->
    <meta name="twitter:card" content="' . $page_title . '" />
    <meta name="twitter:site" content="@twitter_site_handle" />
    <meta name="twitter:title" content="'. $page_title . '" />
    <meta name="twitter:description" content="' . $page_description . '" />
    <meta name="twitter:creator" content="@robbieantenesse" />
    <meta name="twitter:image:src" content="' . $image_url . '&height=600" />
    <!-- Open Graph General (Facebook & Pinterest) -->
    <meta property="og:title" content="'. $page_title . '" />
    <meta property="og:description" content="' . $page_description . '" />
    <meta property="og:site_name" content="' . Terminology::$site_name . '" />
    <meta property="og:image" content="' . $image_url . '&height=600" />
    <meta property="og:type" content="website" />
    
    <!-- Stylesheets -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.3.1/css/bulma.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
</head>
<body>'
    . $page_content .
'<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/placeholders/4.0.1/placeholders.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.5.16/clipboard.min.js"></script>
<script src="js/polyfills.js"></script>
<script src="js/regex-weburl.js"></script>
<script src="js/jquery-events.js"></script>
</body>
</html>
        ');
    }

    public static function render_form () {
        $form_content = ('
<section class="section">
    <div class="container">
        <label class="label">
            Warnings
        </label>
        <span class="help is-danger" id="warningsError"></span>
        <p class="control is-loading" id="warningsControl">
            <span class="select is-fullwidth">
                <select id="warnings" multiple="multiple"></select>
            </span>
        </p>
        <label class="label" for="#url">
            URL
        </label>
        <span class="help is-danger" id="urlError"></span>
        <p class="control">
            <input class="input" id="url" type="text" placeholder="Link to Warn About" />
        </p>
        <p class="control">
            <button class="button is-large" id="submit">
                Get Link!
            </button>
        </p>
        <p class="control has-addons" id="output"></p>
    </div>
</section>
        ');

        return $form_content;
    }

    public static function render_main_page ($error_message = false) {
        $error_html = '';
        if ($error_message) {
            $error_html = ('
<div class="container has-text-centered">
    <div class="notification is-warning">
        ' . Terminology::$error_messages[$error_message] . '
    </div>
</div>
            ');
        }

        $page_content = ('
<section class="hero is-primary is-medium">
    <!-- Hero header: will stick at the top -->
    <div class="hero-head">
        <header class="nav">
            <div class="container">
                <div class="nav-left">
                    <a class="nav-item" href="../">
                        <h2 class="title">
                            ' . Terminology::$site_name . '
                        </h2>
                    </a>
                </div>
            </div>
        </header>
    </div>

    <!-- Hero content: will be in the middle -->
    <div class="hero-body">
        ' . $error_html . '
        <div class="container has-text-centered">
            <h1 class="title">
                ' . Terminology::$site_tagline . '
            </h1>
            <h2 class="subtitle">
                ' . Terminology::$site_description . '
            </h2>
        </div>
    </div>
</section>
' . Display::render_form() . '
        ');

        echo Display::render_html_wrapper($page_content);
    }

    public static function render_warning_page ($url, $warnings) {
//        $values = explode('|', $url);
        // array_pop() removes the last value from the referenced array.
//        $link = array_pop($values);
//        $warning_term_array = Terminology::convert_warning_array($values);
        $warning_term_list = Display::render_comma_list($warnings);

        $page_content = ('
<section class="hero is-fullheight is-danger">
    <div class="hero-body">
        <div class="container has-text-centered">
            <h3 class="subtitle is-3">
                ' . Terminology::$warning_intro . '
            </h3>
            <h1 class="title is-1">
                ' . $warning_term_list . '
            </h1>
            
            <div class="container">
                <a class="button is-info is-medium" id="backButton" href="' . $_SERVER['HTTP_REFERER'] . '">
                    ' . Terminology::$reject_text . '
                </a>
                <br /><br />
                <a class="button is-warning is-small is-outlined" href="' . $url . '">
                    ' . Terminology::$accept_text . $url . '
                </a>
            </div>
        </div>
    </div>
    <footer class="hero-foot">
        <div class="container has-text-centered">
            Create your own warning with
            <a href="' . Display::get_website_path() . '">
                ' . Terminology::$site_name . '
            </a>
        </div>
    </footer>
</section>
        ');

        echo Display::render_html_wrapper($page_content, $warning_term_list . 'Warning', $warning_term_list);
    }
}