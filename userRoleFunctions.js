$(document).ready(main);

function main() {
    loadUsers();
    loadRoles();
    loadUserRoleTable();
    $("#btnSave").click(saveUserRole);
    $("#btnClear").click(function () {
        $("#cmbRole").val(0);
        $("#cmbUser").val(0);
    });
}

function loadUsers() {

    var dataToSend = {
        action: "fetchUsers"
    };

    var setting = {
        type: "post",
        dataType: "json",
        url: "apiAjax.php",
        data: dataToSend,
        success: function (result) {
            var cmbUser = $("#cmbUser");
            cmbUser.html("<option value='0'>--Select--</option>");
            $(result).each(function () {
                cmbUser.append("<option value='" + $(this).attr("userId") + "'>" + $(this).attr("name") + "</option>");
            });
        },
        error: function () {
            alert("some Error Occured while Loading Users.");
        }
    };
    $.ajax(setting);
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

function saveUserRole() {
    var userRoleObj = new Object();
    userRoleObj.updateId = $("#updateId").val();
    userRoleObj.role = $("#cmbRole").val();
    userRoleObj.user = $("#cmbUser").val();

    if (userRoleObj.user == 0) {
        alert("First Select User.");
        return false;
    }
    else if (userRoleObj.role == 0) {
        alert("First Select Role.");
        return false;
    }

    var dataToSend = {
        "txtUpdateId": userRoleObj.updateId,
        "cmbRole": userRoleObj.role,
        "cmbUser": userRoleObj.user,
        action: "saveUserRole"
    };

    var settings = {
        type: "POST",
        dataType: "json",
        url: "apiAjax.php",
        data: dataToSend,
        success: function (result) {
            alert(result);
            $("#cmbRole").val(0);
            $("#cmbUser").val(0);
            location.reload();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert("error while saving permission");
            console.log(JSON.stringify(jqXHR));
            console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
        }
    }
    $.ajax(settings);
}

function loadUserRoleTable() {
    var dataToSend = {
        action: "getAllUsersRoles"
    }

    var settings = {
        type: "post",
        dataType: "json",
        url: "apiAjax.php",
        data: dataToSend,
        success: function (result) {
            var table = $("#myTable");
            $(result).each(function () {
                var tr = $("<tr>");
                tr.append("<td>" + $(this).attr("id") + "</td>");
                tr.append("<td>" + $(this).attr("userName") + "</td>");
                tr.append("<td>" + $(this).attr("roleName") + "</td>");
                var edit = $("<td><a style = 'cursor:pointer;' id ='" + $(this).attr("id") + "'>Edit</a></td>");
                var editId = parseInt($(this).attr("id"));

                edit.click(function () {
                    var dataToSend = {
                        "editId": editId,
                        action: "editUserRole"
                    }

                    var settings = {
                        type: "post",
                        dataType: "json",
                        url: "apiAjax.php",
                        data: dataToSend,
                        success: function (result) {
                            $("#updateId").val(result["id"]);
                            $("#cmbRole").val(result["roleId"]);
                            $("#cmbUser").val(result["userId"]);
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            alert("Error occured while Editing User-Role");
                            console.log(JSON.stringify(jqXHR));
                            console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                        }
                    }
                    $.ajax(settings);
                });
                tr.append(edit);
                var deleteId = parseInt($(this).attr("id"));
                var deleteLink = $("<td><a style = 'cursor:pointer;' >Delete</a></td>");
                deleteLink.click(function () {
                    if (confirm("Do You want to delete this user-role ?")) {
                        var dataToSend = {
                            "deleteId": deleteId,
                            action: "deleteUserRole"
                        }
                        var settings = {
                            type: "post",
                            dataType: "json",
                            url: "apiAjax.php",
                            data: dataToSend,
                            success: function (result) {
                                alert(result);
                                tr.remove();
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                alert("Error occured while deleting User-Role");
                                console.log(JSON.stringify(jqXHR));
                                console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                            }
                        }
                        $.ajax(settings);
                    }
                });
                tr.append(deleteLink);
                table.append(tr);
            });

        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert("Error occured while loading User-role table");
            console.log(JSON.stringify(jqXHR));
            console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
        }
    };
    $.ajax(settings);
}
