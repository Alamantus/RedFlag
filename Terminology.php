<?php
/**
 * Created by PhpStorm.
 * User: Robbie
 * Date: 1/19/2017
 * Time: 10:53 PM
 */

class Terminology {
    public static $warning_intro = 'The person who provided this link wanted to warn you that the contents of the link contain';

    public static $warning_types = array(
        'animal' => 'Animal Abuse',
        'cruelty' => 'Animal Cruelty',
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
    public static $reject_text = 'Oh, I didn\'t realize! Take me back!';
}