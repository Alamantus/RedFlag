<?php
/**
 * Created by PhpStorm.
 * User: Robbie
 * Date: 1/23/2017
 * Time: 8:28 PM
 */

require_once('../classes/EasyCrypt.php');
require_once('../classes/DBControl.php');

$easycrypt = new EasyCrypt();
$db = new DBControl('../resources/redflag.db');

$now = time();
$insert_query = ('
INSERT INTO `warnings` (`term`, `created`)
VALUES ("' . $easycrypt->encrypt('Abandonment') . '", ' . $now . '),
("' . $easycrypt->encrypt('Ableism') . '", ' . $now . '),
("' . $easycrypt->encrypt('Abortion') . '", ' . $now . '),
("' . $easycrypt->encrypt('Alcohol') . '", ' . $now . '),
("' . $easycrypt->encrypt('Alcoholism') . '", ' . $now . '),
("' . $easycrypt->encrypt('Amputation') . '", ' . $now . '),
("' . $easycrypt->encrypt('Animal Abuse') . '", ' . $now . '),
("' . $easycrypt->encrypt('Animal Cruelty') . '", ' . $now . '),
("' . $easycrypt->encrypt('Animal Death') . '", ' . $now . '),
("' . $easycrypt->encrypt('Animal Violence') . '", ' . $now . '),
("' . $easycrypt->encrypt('Anxiety') . '", ' . $now . '),
("' . $easycrypt->encrypt('Autism') . '", ' . $now . '),
("' . $easycrypt->encrypt('Bipolar Disorder') . '", ' . $now . '),
("' . $easycrypt->encrypt('Blood') . '", ' . $now . '),
("' . $easycrypt->encrypt('Body Horror') . '", ' . $now . '),
("' . $easycrypt->encrypt('Body Shaming') . '", ' . $now . '),
("' . $easycrypt->encrypt('Bones') . '", ' . $now . '),
("' . $easycrypt->encrypt('Bullying') . '", ' . $now . '),
("' . $easycrypt->encrypt('Cannibalism') . '", ' . $now . '),
("' . $easycrypt->encrypt('Car Accident') . '", ' . $now . '),
("' . $easycrypt->encrypt('Child Abuse') . '", ' . $now . '),
("' . $easycrypt->encrypt('Childbirth') . '", ' . $now . '),
("' . $easycrypt->encrypt('Classism') . '", ' . $now . '),
("' . $easycrypt->encrypt('Death') . '", ' . $now . '),
("' . $easycrypt->encrypt('Decapitation') . '", ' . $now . '),
("' . $easycrypt->encrypt('Depictions of Medical Procedures') . '", ' . $now . '),
("' . $easycrypt->encrypt('Depression') . '", ' . $now . '),
("' . $easycrypt->encrypt('Dissociation') . '", ' . $now . '),
("' . $easycrypt->encrypt('Domestic Violence') . '", ' . $now . '),
("' . $easycrypt->encrypt('Drug Use') . '", ' . $now . '),
("' . $easycrypt->encrypt('Drunkenness') . '", ' . $now . '),
("' . $easycrypt->encrypt('Eating Disorder') . '", ' . $now . '),
("' . $easycrypt->encrypt('Emotional Abuse') . '", ' . $now . '),
("' . $easycrypt->encrypt('Enslavement/Coersion') . '", ' . $now . '),
("' . $easycrypt->encrypt('Eugenics') . '", ' . $now . '),
("' . $easycrypt->encrypt('Gore') . '", ' . $now . '),
("' . $easycrypt->encrypt('Hallucinations') . '", ' . $now . '),
("' . $easycrypt->encrypt('Homophobia') . '", ' . $now . '),
("' . $easycrypt->encrypt('Incest') . '", ' . $now . '),
("' . $easycrypt->encrypt('Insects') . '", ' . $now . '),
("' . $easycrypt->encrypt('Islamophobia') . '", ' . $now . '),
("' . $easycrypt->encrypt('Kidnapping') . '", ' . $now . '),
("' . $easycrypt->encrypt('Mental Abuse') . '", ' . $now . '),
("' . $easycrypt->encrypt('Mental Illness') . '", ' . $now . '),
("' . $easycrypt->encrypt('Miscarriages') . '", ' . $now . '),
("' . $easycrypt->encrypt('Murder') . '", ' . $now . '),
("' . $easycrypt->encrypt('Nazi Symbolism/Paraphernalia') . '", ' . $now . '),
("' . $easycrypt->encrypt('Nazism') . '", ' . $now . '),
("' . $easycrypt->encrypt('Needles') . '", ' . $now . '),
("' . $easycrypt->encrypt('Neglect') . '", ' . $now . '),
("' . $easycrypt->encrypt('OCD') . '", ' . $now . '),
("' . $easycrypt->encrypt('Panic Attacks') . '", ' . $now . '),
("' . $easycrypt->encrypt('Paranoia') . '", ' . $now . '),
("' . $easycrypt->encrypt('Pedophilia') . '", ' . $now . '),
("' . $easycrypt->encrypt('Personality Disorder') . '", ' . $now . '),
("' . $easycrypt->encrypt('Physical Abuse') . '", ' . $now . '),
("' . $easycrypt->encrypt('Pornography') . '", ' . $now . '),
("' . $easycrypt->encrypt('Pregnancy') . '", ' . $now . '),
("' . $easycrypt->encrypt('Prostitution') . '", ' . $now . '),
("' . $easycrypt->encrypt('Psychosis') . '", ' . $now . '),
("' . $easycrypt->encrypt('Racial Slurs') . '", ' . $now . '),
("' . $easycrypt->encrypt('Racism') . '", ' . $now . '),
("' . $easycrypt->encrypt('Rape') . '", ' . $now . '),
("' . $easycrypt->encrypt('Scarification') . '", ' . $now . '),
("' . $easycrypt->encrypt('Schizophrenia') . '", ' . $now . '),
("' . $easycrypt->encrypt('Self-Harm') . '", ' . $now . '),
("' . $easycrypt->encrypt('Sex-Positive Shaming') . '", ' . $now . '),
("' . $easycrypt->encrypt('Sexism') . '", ' . $now . '),
("' . $easycrypt->encrypt('Sexual Abuse') . '", ' . $now . '),
("' . $easycrypt->encrypt('Sexual Assault') . '", ' . $now . '),
("' . $easycrypt->encrypt('Sexual Harrassment') . '", ' . $now . '),
("' . $easycrypt->encrypt('Sexual Slurs') . '", ' . $now . '),
("' . $easycrypt->encrypt('Shooting') . '", ' . $now . '),
("' . $easycrypt->encrypt('Skeletons') . '", ' . $now . '),
("' . $easycrypt->encrypt('Skulls') . '", ' . $now . '),
("' . $easycrypt->encrypt('Slut Shaming') . '", ' . $now . '),
("' . $easycrypt->encrypt('Smoking') . '", ' . $now . '),
("' . $easycrypt->encrypt('Snakes') . '", ' . $now . '),
("' . $easycrypt->encrypt('Spiders') . '", ' . $now . '),
("' . $easycrypt->encrypt('Stalking') . '", ' . $now . '),
("' . $easycrypt->encrypt('Substance Abuse') . '", ' . $now . '),
("' . $easycrypt->encrypt('Suicide') . '", ' . $now . '),
("' . $easycrypt->encrypt('Swearing') . '", ' . $now . '),
("' . $easycrypt->encrypt('Terrorism') . '", ' . $now . '),
("' . $easycrypt->encrypt('Torture') . '", ' . $now . '),
("' . $easycrypt->encrypt('Transphobia') . '", ' . $now . '),
("' . $easycrypt->encrypt('Verbal Abuse') . '", ' . $now . '),
("' . $easycrypt->encrypt('Violence') . '", ' . $now . '),
("' . $easycrypt->encrypt('Vomit') . '", ' . $now . '),
("' . $easycrypt->encrypt('Warfare') . '", ' . $now . '),
("' . $easycrypt->encrypt('Weapons') . '", ' . $now . '),
("' . $easycrypt->encrypt('Xenophobia') . '", ' . $now . ');
');

if ($db->query($insert_query)) {
    echo 'Inserted successfully!';
} else {
    echo $db->error;
}
