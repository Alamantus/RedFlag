<?php
/**
 * Created by PhpStorm.
 * User: Robbie
 * Date: 1/19/2017
 * Time: 10:53 PM
 */

class Terminology {
    public static $site_name = 'Warner';
    public static $site_tagline = 'Content Warnings Made Simple';
    public static $site_description = 'Put up a warning wall between whoever clicks your link and whatever&rsquo;s at
        the end of it with a warning about sensitive content';

    public static $error_messages = array(
        'failed' => 'Something went wrong while trying to find that warning page. Please try again later.'
    ,   'no_link' => 'Something went wrong while trying to find the link this warning page is for. Please try again later.'
    ,   'no_warnings' => 'Something went wrong while trying to find the warnings for this link. Please try again later.'
    ,   'no_results' => 'Somehow, there aren\'t any warnings associated with that link. Please try again later.'
    );

    public static $warning_intro = 'Warning! The following link may contain or be a trigger for the following:';

    public static $accept_text = 'I understand. Continue to ';
    public static $reject_text = 'Thanks for the warning! Take me back!';

    public static function convert_warning_array ($warning_types_array) {
        $result = array();
        foreach($warning_types_array as $warning_type) {
            $result[] = Terminology::$warning_types[$warning_type];
        }
        return $result;
    }
}