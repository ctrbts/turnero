<?php

/*
 * Copyright (C) 2016 Fernando Merlo
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */
//include ("topinclude.php");
$l_modules = new ArrayList();
$o_ADOModules =  new ADOModules();
$o_ADOModules->GetModulesActive($l_modules);

$showUserMenu = false;
$userobj = new UserObj();
$l_modules;
if (isset($_SESSION['Show_login'])) {
    if (!$_SESSION['Show_login']) {
        $showUserMenu = true;
        if (isset($_SESSION['UserObj'])) {
            $userobj = unserialize($_SESSION['UserObj']);
            $userobj->GetProfile();
            $userobj->ProfileObj->GetListIdModules();
        }
    } else {
        $userobj->idprofile = 1;
        $userobj->GetProfile();
        $userobj->ProfileObj->GetListIdModules();
    }
}
?>
<div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
        <!-- Boton de inicio -->
        <?php if ($showUserMenu) { ?>
            <a class="navbar-brand" href="<?php echo $config->domain . $direccion ?>/"><span>Inicio</span></a>
        <?php } else { ?>
            <a class="navbar-brand" href="<?php echo $config->domain . $direccion ?>"><span>Inicio</span></a>
        <?php } ?>

        <!-- Boton de toggle -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- inicia menu -->
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <!-- inicia menus dinamicos -->
                <?php
                foreach ($l_modules->array as $item) {
                    $val = false;
                    foreach ($userobj->ProfileObj->ListIdModules->array as $i) {
                        if ($i == $item->idmodulo) {
                            $val = true;
                        }
                    }

                    if ($val) {
                        if ($item->path != "#") {
                            $href = $config->domain . "/" . $config->pathServer . $item->path;
                        } else {
                            $href = "#";
                        }
                        $item->getMenus();
                        if ($item->ListofMenuObj->size() > 0) {
                ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="<?php echo $href ?>" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <?php echo $item->etiqueta ?>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php
                            foreach ($item->ListofMenuObj->array as $itm) {
                                if ($itm->path != "#") {
                                    $href = $config->domain . "/" . $config->pathServer . $itm->path;
                                } else {
                                    $href = "#";
                                }
                                echo '<a class="dropdown-item" href="' . $href . '">' . $itm->etiqueta . '</a>';
                            }

                            echo ' </div>';
                            echo ' </li>';
                        } else {
                            echo ' <li class="nav-item active">';
                            echo ' <a class="nav-link" href="' . $href . '">' . $item->etiqueta . '</a>';
                            echo '</li>';
                        }
                    }
                }
                        ?>
                        <!-- Termina menus dinamicos -->

                        <!-- Menus estaticos cuando el usuario esta activo-->
                        <?php
                        if ($showUserMenu) {
                        ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <?php echo 'Perfil' ?>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="<?php echo $profilepage ?>">Ver Mi Perfil</a>
                                    <a class="dropdown-item" href="<?php echo $logoutpage ?>">Cerrar Sesion</a>
                                </div>
                            </li>
                        <?php
                        }
                        ?>
            </ul>
        </div>
    </nav>
</div>