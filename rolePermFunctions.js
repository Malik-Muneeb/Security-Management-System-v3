
$(document).ready(main);

function main() {
    loadRoles();
    loadPermissions();
    loadRolePerTable();
    //$("#btnSave").click(saveRolePer);
    //$("#btnClear").click(clearFields);
}

function loadRoles() {

    var dataToSend = {
        action: "fetchRoles"
    };

    var setting = {
        type: "post",
        dataType: "json",
        url: "apiAjax.php",
        data: dataToSend,
        success: function (result) {
            var cmbRole = $("#cmbRole");
            cmbRole.html("<option value='0'>--Select--</option>");
            $(result).each(function () {
                cmbRole.append("<option value='" + $(this).attr("roleId") + "'>" + $(this).attr("name") + "</option>");
            });
        },
        error: function () {
            alert("some Error Occured while Loading Countries.");
        }
    };
    $.ajax(setting);
}

function loadPermissions() {

    var dataToSend = {
        action: "fetchPers"
    };

    var setting = {
        type: "post",
        dataType: "json",
        url: "apiAjax.php",
        data: dataToSend,
        success: function (result) {
            var cmbPer = $("#cmbPer");
            cmbPer.html("<option value='0'>--Select--</option>");
            $(result).each(function () {
                cmbPer.append("<option value='" + $(this).attr("permissionId") + "'>" + $(this).attr("name") + "</option>");
            });
        },
        error: function () {
            alert("some Error Occured while Loading Countries.");
        }
    };
    $.ajax(setting);
}


/*
function saveRolePer() {
    var rolePerObj = new Object();
    var role = document.getElementById("cmbRole");
    rolePerObj.role = role.options[role.selectedIndex].text;
    var per = document.getElementById("cmbPer");
    rolePerObj.per = per.options[per.selectedIndex].text;
    if (rolePerObj.role == "--Select--") {
        alert("First Select Role.");
        return false;
    }
    else if (rolePerObj.per == "--Select--") {
        alert("First Select Permission.");
        return false
    }
}
*/
