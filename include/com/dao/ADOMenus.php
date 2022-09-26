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

/**
 * Description of ADOMenus
 *
 * @author Fernando Merlo
 */
class ADOMenus {

    private $mysqlconector;
    public $debug=false;

    public function __construct() {
        $this->mysqlconector= new MysqlConnector();
    }

    public function AddMenuToModuleDB($MenuObj){
     if(!is_null($MenuObj)){
         $this->mysqlconector->OpenConnection();
         $etiqueta=  mysqli_real_escape_string($this->mysqlconector->conn,$MenuObj->etiqueta);
         $activo=  mysqli_real_escape_string($this->mysqlconector->conn,$MenuObj->activo);
         $path= mysqli_real_escape_string($this->mysqlconector->conn,$MenuObj->path);
         $hasmenus= mysqli_real_escape_string($this->mysqlconector->conn,$MenuObj->hasmenus);
         $accion=  mysqli_real_escape_string($this->mysqlconector->conn,$MenuObj->accion);
         $idmodulo = mysqli_real_escape_string($this->mysqlconector->conn,$MenuObj->idmodulo);

         $sql="insert into t_menus(etiqueta,activo,path,hasmenus,accion,idmodulo) values ('$etiqueta',$activo,'$path',$hasmenus,'$accion',$idmodulo)";
         if($this->debug){
             echo $sql;
         }
         try{
            $this->mysqlconector->conn->query($sql);
            } catch (Exception $ex) {
                if($this->debug){
                    echo $ex->getMessage();
                }
            }
         $this->mysqlconector->CloseDataBase();
     }
    }

    public function UpdateMenu($MenuObj){
        if(!is_null($MenuObj)){
             $this->mysqlconector->OpenConnection();

            $etiqueta=  mysqli_real_escape_string($this->mysqlconector->conn,$MenuObj->etiqueta);
            $activo=  mysqli_real_escape_string($this->mysqlconector->conn,$MenuObj->activo);
            $path= mysqli_real_escape_string($this->mysqlconector->conn,$MenuObj->path);
            $hasmenus= mysqli_real_escape_string($this->mysqlconector->conn,$MenuObj->hasmenus);
            $accion=  mysqli_real_escape_string($this->mysqlconector->conn,$MenuObj->accion);
            $idmodulo = mysqli_real_escape_string($this->mysqlconector->conn,$MenuObj->idmodulo);
            $idmenu=  mysqli_real_escape_string($this->mysqlconector->conn,$MenuObj->idmenu);

             $sql="update t_menus set etiqueta='$etiqueta',activo=$activo,path='$path',accion='$accion' where idmenu=$idmenu";
             if($this->debug){
                echo $sql;
             }
             try{
                 $this->mysqlconector->conn->query($sql);
             } catch (Exception $ex) {
                if($this->debug){
                    echo $ex->getMessage();
                }
             }
             $this->mysqlconector->CloseDataBase();
        }
    }

    public function DeleteMenu($MenuObj){
        if(!is_null($MenuObj)){
             $this->mysqlconector->OpenConnection();
             $idmenu=  mysqli_real_escape_string($this->mysqlconector->conn,$MenuObj->idmenu);
             $sql="delete from t_menus where idmenu=$idmenu";
             if($this->debug){
                echo $sql;
             }
             try{
                 $this->mysqlconector->conn->query($sql);
             } catch (Exception $ex) {
                if($this->debug){
                    echo $ex->getMessage();
                }
             }
             $this->mysqlconector->CloseDataBase();
        }
    }

    public function GetMenusByModule($ListMenuObj,$idmodule){
        if(!is_null($ListMenuObj)){
            $this->mysqlconector->OpenConnection();

            $_idmodule=  mysqli_real_escape_string($this->mysqlconector->conn,$idmodule);

            $sql="select idmenu,etiqueta,activo,path,hasmenus,accion,idmodulo from t_menus where idmodulo=$_idmodule;";
            if($this->debug){
             echo $sql;
            }
            try{
                $result= $this->mysqlconector->conn->query($sql);
                if($result->num_rows>0){
                    while($row = $result->fetch_assoc()) {
                        $menuobj = new MenuObj();
                        $menuobj->idmenu=$row["idmenu"];
                        $menuobj->idmodulo=$row["idmodulo"];
                        $menuobj->etiqueta=$row["etiqueta"];
                        $menuobj->activo=$row["activo"];
                        $menuobj->path=$row["path"];
                        $menuobj->hasmenus=$row["hasmenus"];
                        $menuobj->accion=$row["accion"];
                        $ListMenuObj->addItem($menuobj);
                    }
                }
            } catch (Exception $ex) {
                if($this->debug){
                    echo $ex->getMessage();
                }
            }
            $this->mysqlconector->CloseDataBase();
        }
    }

    public function GetMenuByID($MenuObj){
        if(!is_null($MenuObj)){
            $this->mysqlconector->OpenConnection();
            $idmenu=  mysqli_real_escape_string($this->mysqlconector->conn,$MenuObj->idmenu);
            $sql="select idmenu,etiqueta,activo,path,hasmenus,accion,idmodulo from t_menus where idmenu=$idmenu;";
            if($this->debug){
             echo $sql;
            }
            try{
                $result= $this->mysqlconector->conn->query($sql);
                if($result->num_rows>0){
                   while($row = $result->fetch_assoc()) {
                        $MenuObj->idmenu=$row["idmenu"];
                        $MenuObj->idmodulo=$row["idmodulo"];
                        $MenuObj->etiqueta=$row["etiqueta"];
                        $MenuObj->activo=$row["activo"];
                        $MenuObj->path=$row["path"];
                        $MenuObj->hasmenus=$row["hasmenus"];
                        $MenuObj->accion=$row["accion"];
                   }
                }
            } catch (Exception $ex) {
                if($this->debug){
                    echo $ex->getMessage();
                }
            }
            $this->mysqlconector->CloseDataBase();
        }
    }

}
