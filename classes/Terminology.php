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
    ,   'no_results' => 'Something went wrong while trying to find that warning page. Please try again later.'
    );

















    public static $warning_intro = 'The person who provided this link wanted to warn you that the contents of the link
        may contain';

    public static $warning_types = array(
        'test' => 'Testing',
        'animal_abuse' => 'Animal Abuse',
        'animal_cruelty' => 'Animal Cruelty',
        'drugs' => 'Drug Usage',
        'gore' => 'Gore',
        'profanity' => 'Profanity',
        'racism' => 'Racism',
        'rape' => 'Rape',
        'selfharm' => 'Self-Harm Mention',
        'suicide' => 'Suicide Mention',
        'torture' => 'Torture',
        'violence' => 'Violence',
    );

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