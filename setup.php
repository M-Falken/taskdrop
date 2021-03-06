<?php
/*
 -------------------------------------------------------------------------
 Task&drop plugin for GLPI
 Copyright (C) 2018 by the TICgal Team.

 https://github.com/ticgal/Task&drop
 -------------------------------------------------------------------------

 LICENSE

 This file is part of the Task&drop plugin.

 Task&drop plugin is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 3 of the License, or
 (at your option) any later version.

 Task&drop plugin is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with Task&drop. If not, see <http://www.gnu.org/licenses/>.
 --------------------------------------------------------------------------
 @package   Task&drop
 @author    the TICgal team
 @copyright Copyright (c) 2018 TICgal team
 @license   AGPL License 3.0 or (at your option) any later version
            http://www.gnu.org/licenses/agpl-3.0-standalone.html
 @link      https://tic.gal
 @since     2018
 ---------------------------------------------------------------------- */
define ('PLUGIN_TASKDROP_VERSION', '1.1.0');
// Minimal GLPI version, inclusive
define("PLUGIN_TASKDROP_MIN_GLPI", "9.2.0");
// Maximum GLPI version, exclusive
define("PLUGIN_TASKDROP_MAX_GLPI", "9.5");

function plugin_version_taskdrop() {
   return ['name'       => 'TaskDrop',
      'version'        => PLUGIN_TASKDROP_VERSION,
      'author'         => '<a href="https://tic.gal">TICgal</a>',
      'homepage'       => 'https://tic.gal',
      'license'        => 'GPLv3+',
      'minGlpiVersion' => "9.3",
      'requirements'   => [
         'glpi'   => [
            'min' => PLUGIN_TASKDROP_MIN_GLPI,
            'max' => PLUGIN_TASKDROP_MAX_GLPI,
         ]
      ]];
}

/**
 * Check plugin's prerequisites before installation
 */
function plugin_taskdrop_check_prerequisites() {

   if (!method_exists('Plugin', 'checkGlpiVersion')) {
      $version = preg_replace('/^((\d+\.?)+).*$/', '$1', GLPI_VERSION);
      $matchMinGlpiReq = version_compare($version, PLUGIN_TASKDROP_MIN_GLPI, '>=');
      $matchMaxGlpiReq = version_compare($version, PLUGIN_TASKDROP_MAX_GLPI, '<');
      if (!$matchMinGlpiReq || !$matchMaxGlpiReq) {
         echo vsprintf(
            'This plugin requires GLPI >= %1$s and < %2$s.',
            [
               PLUGIN_TASKDROP_MIN_GLPI,
               PLUGIN_TASKDROP_MAX_GLPI,
            ]
         );
         return false;
      }
   }

   return true;
}

/**
 * Check plugin's config before activation
 */
function plugin_taskdrop_check_config($verbose = false) {
   return true;
}

function plugin_init_taskdrop() {
   global $PLUGIN_HOOKS;

   $PLUGIN_HOOKS['csrf_compliant']['taskdrop'] = true;
   $PLUGIN_HOOKS['post_show_tab']['taskdrop']=['PluginTaskdropCalendar','listTask'];
}
