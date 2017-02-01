<?php
/**
 * Created by PhpStorm.
 * User: Robbie
 * Date: 1/19/2017
 * Time: 10:53 PM
 */

class Terminology {
    public static $site_name = 'RedFlag';
    public static $site_tagline = 'Content Warnings Made Simple';
    public static $site_description = 'Put up a warning wall between whoever clicks your link and whatever&rsquo;s at
        the end of it with a warning about sensitive content';

    public static $site_footer = '
<div class="level">
    <div class="level-left">
        <div class="level-item">
            Like what we&rsquo;re doing?&nbsp;<a class="button is-primary is-small" href="https://ko-fi.com/A367JK3" title="via Ko-Fi">Buy Me a Coffee</a><br />
        </div>
    </div>
    <div class="level-right">
        <div class="level-item">
            <a href="./issues" class="button is-small is-primary is-outlined" target="_blank">Report an Issue</a>
        </div>
    </div>
</div>
    ';

    public static $error_messages = array(
        'failed' => 'Something went wrong while trying to find that warning page. Please try again later.'
    ,   'no_link' => 'Something went wrong while trying to find the link this warning page is for. Please try again later.'
    ,   'no_warnings' => 'Something went wrong while trying to find the warnings for this link. Please try again later.'
    ,   'no_results' => 'Somehow, there aren\'t any warnings associated with that link. Please try again later.'
    ,   'no_page' => 'There is no page at that URL.'
    );

    public static $warning_intro = 'Warning! The following link may contain or be a trigger for the following:';

    public static $accept_text = 'I understand. Continue to ';
    public static $reject_text = 'Thanks for the warning! Take me back!';

    public static $about_text = '
# What is RedFlag?

RedFlag is a simple but effective way to responsibly share links about or containing potentially sensitive subjects.
All you need to do is select up to 3 content warnings, paste the link to the website, and get your RedFlag link for that
site. Instead of displaying a preview of the content, RedFlag will display a "Warning" image, allowing you to explain
what&rsquo;s on the other side of the wall and letting people choose whether or not they want to look at the content.

When someone uses the RedFlag link, they will be greeted with a full red screen with a warning about what kinds of
sensitive materials may be on the page and be given the opportunity to go back if they do not want to view the content or
press onward to the site.

# Why RedFlag?

There&rsquo;s a lot of stuff on the internet. Most of it is good, excellent stuff, but sometimes, it can get pretty unsavory.
RedFlag allows you to share potentially negative or harmful content while giving those who may be more sensitive to that
kind of material a chance to opt out of seeing it.

The inspiration for this site comes from an article that went around in January 2017 about a brutally murdered dog. Dog
rescues and many other sources shared this article, which featured and previewed the grizzly images. While it is important
to know about this kind of thing, I can&rsquo;t imagine anyone who would actually want to see the images that were posted.

RedFlag is here to provide a better experience on social media and for clicking regular links in general by letting your
followers not have their day ruined by unexpected horrific content.
    ';

    public static $propose_text = '
# Propose a New Warning

There&rsquo;s no way we can offer a complete list of things that anyone would want to warn others about, so we appreciate
that you want to help us create as full and complete a list as possible!

Please write your warning suggestion below with Capitalization and correct spelling, and please be sure that it is definitely
not already on the list. After you submit, your proposed warning will become visible to everyone for 30 days. If it is not
used for at least 15 different links in 30 days, it will disappear from the warnings list, though any links created using
it will still display the warning.
    ';

    public static function convert_warning_array ($warning_types_array) {
        $result = array();
        foreach($warning_types_array as $warning_type) {
            $result[] = Terminology::$warning_types[$warning_type];
        }
        return $result;
    }
}