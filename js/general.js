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

var currentDate = new Date()
var month = currentDate.getMonth() + 1;
var year = currentDate.getFullYear();

$(document).ready(function () {
    $('#contentdiv').load('ControlCalendar.php?month=' + month + '&year=' + year);

    $('table#controlbuttons tr td a').click(function () {
        var page = $(this).attr('href');
        //alert(page);
        if (page == "prevmonth") {
            month = month - 1;
            if (month > 12) {
                month = 1;
                year = year + 1
            }

            if (month == 0) {
                month = 12;
                year = year - 1
            }

            $('#contentdiv').load('ControlCalendar.php?month=' + month + '&year=' + year);
        }

        if (page == "nextmonth") {
            month = month + 1;
            if (month > 12) {
                month = 1;
                year = year + 1
            }

            if (month == 0) {
                month = 12;
                year = year - 1
            }
            $('#contentdiv').load('ControlCalendar.php?month=' + month + '&year=' + year);
        }

        return false;
    });



});

$('#TableUsers select').change(function () {
    //obtiene el id del usuario de attributo id
    var valor = $(this).attr('id');
    var strsplited = valor.split("_");
    var iduser = strsplited[1];
    //obtiene el valor del control select
    var idprofilesel = $(this).val();
    $.post('UpdateProfileToUser.php', { idprofile: idprofilesel, iduser: iduser }, function (retrive) {
        if (retrive < 1) {
            alert("Error al actualizar el registro");
        }
    });
    //alert(idprofilesel);
});

$('#TableUsers input').click(function () {
    var valor = $(this).attr('id');
    var strsplited = valor.split("_");
    var iduser = strsplited[1];
    var acivationtoken = $("#activationtoken_" + iduser.toString()).val();
    var emailuser = $("#email_" + iduser.toString()).val();
    var namebutton = $(this).attr("value");
    //alert(namebutton);
    if (namebutton == 'Activar') {
        $.get("../UserActivation/activation.php", { email: emailuser, param: acivationtoken, returnajax: "true" }, function (data) {
            //alert(data);
        });
    }
    if (namebutton == 'Desactivar') {
        $.get("../UserActivation/deactivation.php", { email: emailuser, param: acivationtoken, returnajax: "true" }, function (data) {
            //alert(data);
        });
    }


    location.reload();
});

function my_curr_date() {
    var currentDate = new Date()
    var day = currentDate.getDate();
    var month = currentDate.getMonth() + 1;
    var year = currentDate.getFullYear();
    var my_date = month + "-" + day + "-" + year;
    return my_date;
}