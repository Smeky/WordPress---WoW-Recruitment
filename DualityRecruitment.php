<?php
/* 
	Plugin Name: Duality WoW Recruitement
	Plugin URI: http://www.duality-wow.com
	Description: Plugin to display guild's recruitment.
	Author: Tomas (Smeky) Sobota
	Version: 0.1
*/

function wowdr_load_widget() {
    register_widget('Duality_WoW_Recruit_Widget');
}

function wowdr_load_plugin_css() {
    wp_register_style('wowdr_style', plugins_url('/css/wowdr_style.css', __FILE__));
    wp_enqueue_style('wowdr_style');
}

add_action('wp_enqueue_scripts', 'wowdr_load_plugin_css');
add_action('widgets_init', 'wowdr_load_widget');

register_activation_hook(__FILE__, 'wowdr_widget_install');
register_deactivation_hook(__FILE__, 'wowdr_widget_uninstall');

define(WOWDR_ROOT, __FILE__);


/* Globals */
$wowdr_options = get_option('wowdr_options');
$wowdr_classes = array (
    'class_dk' => array(
        'name'          => 'Death Knight',
        'name_img'      => 'DeathKnight',
        'color'         => '#C41F3B',
        'spec_count'    => 3,
        'spec_1_name'   => 'Blood',
        'spec_2_name'   => 'Frost',
        'spec_3_name'   => 'Unholy'
    ),
    'class_dh' => array(
        'name'          => 'Demon Hunter',
        'name_img'      => 'DemonHunter',
        'color'         => '#A330C9',
        'spec_count'    => 2,
        'spec_1_name'   => 'Havoc',
        'spec_2_name'   => 'Vengeance'
    ),
    'class_druid' => array(
        'name'          => 'Druid',
        'name_img'      => 'Druid',
        'color'         => '#FF7D0A',
        'spec_count'    => 4,
        'spec_1_name'   => 'Balance',
        'spec_2_name'   => 'Feral',
        'spec_3_name'   => 'Guardian',
        'spec_4_name'   => 'Restoration'
    ),
    'class_hunter' => array(
        'name'          => 'Hunter',
        'name_img'      => 'Hunter',
        'color'         => '#ABD473',
        'spec_count'    => 3,
        'spec_1_name'   => 'Survival',
        'spec_2_name'   => 'Marksmanship',
        'spec_3_name'   => 'Beast Master'
    ),
    'class_mage' => array(
        'name'          => 'Mage',
        'name_img'      => 'Mage',
        'color'         => '#69CCF0',
        'spec_count'    => 3,
        'spec_1_name'   => 'Frost',
        'spec_2_name'   => 'Fire',
        'spec_3_name'   => 'Arcane'
    ),
    'class_monk' => array(
        'name'          => 'Monk',
        'name_img'      => 'Monk',
        'color'         => '#00FF96',
        'spec_count'    => 3,
        'spec_1_name'   => 'Brewmaster',
        'spec_2_name'   => 'Windwalker',
        'spec_3_name'   => 'Mistweaver'
    ),
    'class_paladin' => array(
        'name'          => 'Paladin',
        'name_img'      => 'Paladin',
        'color'         => '#F58CBA',
        'spec_count'    => 3,
        'spec_1_name'   => 'Retribution',
        'spec_2_name'   => 'Holy',
        'spec_3_name'   => 'Protection'
    ),
    'class_priest' => array(
        'name'          => 'Priest',
        'name_img'      => 'Priest',
        'color'         => '#FFFFFF',
        'spec_count'    => 3,
        'spec_1_name'   => 'Discipline',
        'spec_2_name'   => 'Holy',
        'spec_3_name'   => 'Shadow'
    ),
    'class_rogue' => array(
        'name'          => 'Rogue',
        'name_img'      => 'Rogue',
        'color'         => '#FFF569',
        'spec_count'    => 3,
        'spec_1_name'   => 'Assassination',
        'spec_2_name'   => 'Outlaw',
        'spec_3_name'   => 'Subtlety'
    ),
    'class_shaman' => array(
        'name'          => 'Shaman',
        'name_img'      => 'Shaman',
        'color'         => '#0070DE',
        'spec_count'    => 3,
        'spec_1_name'   => 'Elemental',
        'spec_2_name'   => 'Enhancement',
        'spec_3_name'   => 'Restoration'
    ),
    'class_warlock' => array(
        'name'          => 'Warlock',
        'name_img'      => 'Warlock',
        'color'         => '#9482C9',
        'spec_count'    => 3,
        'spec_1_name'   => 'Destruction',
        'spec_2_name'   => 'Affliction',
        'spec_3_name'   => 'Demonology'
    ),
    'class_warrior' => array(
        'name'          => 'Warrior',
        'name_img'      => 'Warrior',
        'color'         => '#C79C6E',
        'spec_count'    => 3,
        'spec_1_name'   => 'Fury',
        'spec_2_name'   => 'Arms',
        'spec_3_name'   => 'Protection'
    ),
);

$wowdr_prios = array (
    1 => 'High',
    2 => 'Medium',
    3 => 'Low'
);

include "src/Widget.php";

?>