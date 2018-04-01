
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

function loadRolePerTable() {
    var dataToSend = {
        action: "getAllRolesPers"
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
                tr.append("<td>" + $(this).attr("roleName") + "</td>");
                tr.append("<td>" + $(this).attr("perName") + "</td>");
                var edit = $("<td><a style = 'cursor:pointer;' id ='" + $(this).attr("id") + "'>Edit</a></td>");
                var editId = parseInt($(this).attr("id"));

                edit.click(function () {
                    var dataToSend = {
                        "editId": editId,
                        action:"editRolePer"
                    }

                    var settings = {
                        type: "post",
                        dataType: "json",
                        url: "apiAjax.php",
                        data: dataToSend,
                        success: function (result) {
                            $("#updateId").val(result["id"]);
                            $("#cmbRole").val(result["roleId"]);
                            $("#cmbPer").val(result["perId"]);
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            alert("Error occured while Editing Role-Permission");
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
                    if (confirm("Do You want to delete this role-permission ?")) {
                        var dataToSend = {
                            "deleteId": deleteId,
                            action: "deleteRolePer"
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
                                alert("Error occured while deleting Role-Permission");
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
            alert("Error occured while loading Users");
            console.log(JSON.stringify(jqXHR));
            console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
        }
    };
    $.ajax(settings);
}
