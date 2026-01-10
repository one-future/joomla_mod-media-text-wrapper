<?php 

    /**
     * Media & Text, Module Entry Point
     * 
     * @license    GNU/GPL, see LICENSE.php
     * @link       http://docs.joomla.org/J3.x:Creating_a_simple_module/Developing_a_Basic_Module
     * mod_media_text is free software. This version may have been modified pursuant
     * to the GNU General Public License, and as distributed it includes or
     * is derivative of works licensed under the GNU General Public License or
     * other free or open source software licenses.
     */

    defined('_JEXEC') or die;

    require_once dirname(__FILE__) . '/helper.php';

    $mediatext_outputBuilder = new OutputBuilder($module->id);

    require JModuleHelper::getLayoutPath('mod_media_text');

 ?>