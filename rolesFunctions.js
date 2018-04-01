$(document).ready(main);

function main() {
    loadRoleTable();
    $("#btnSave").click(saveRole);
}

function saveRole() {
    var roleObj = new Object();
    roleObj.updateId=$("#updateId").val();
    roleObj.roleName = document.getElementById("txtName").value;
    roleObj.roleDesc = document.getElementById("txtDesc").value;

    if (roleObj.roleName == "") {
        alert("Enter Role!");
        return false;
    }
    else if (roleObj.roleDesc == "") {
        alert("Enter role's description");
        return false;
    }

    var dataToSend = {
        "txtUpdateId":roleObj.updateId,
        "txtName": roleObj.roleName,
        "txtDesc": roleObj.roleDesc,
        action: "saveRole"
    }

    var settings = {
        type: "POST",
        dataType: "json",
        url: "apiAjax.php",
        data: dataToSend,
        success: function (result) {
            alert(result);
            $("#txtName").val("");
            $("#txtDesc").val("");
            location.reload();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert("error while saving user");
            console.log(JSON.stringify(jqXHR));
            console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
        }
    }
    $.ajax(settings);
}

function loadRoleTable() {

    var dataToSend = {
        action: "getAllRoles"
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
                tr.append("<td>" + $(this).attr("roleId") + "</td>");
                tr.append("<td>" + $(this).attr("name") + "</td>");
                tr.append("<td>" + $(this).attr("description") + "</td>");
                var edit = $("<td><a style = 'cursor:pointer;' id ='" + $(this).attr("roleId") + "'>Edit</a></td>");
                var editId = parseInt($(this).attr("roleId"));

                edit.click(function () {

                    var dataToSend = {
                        "editId": editId,
                        action: "editRole"
                    }

                    var settings = {
                        type: "post",
                        dataType: "json",
                        url: "apiAjax.php",
                        data: dataToSend,
                        success: function (result) {
                            $("#updateId").val(result["roleId"]);
                            $("#txtName").val(result["name"]);
                            $("#txtDesc").val(result["description"]);
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            alert("Error occured while Editing User");
                            console.log(JSON.stringify(jqXHR));
                            console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                        }
                    }
                    $.ajax(settings);
                });
                tr.append(edit);
                var deleteId = parseInt($(this).attr("roleId"));
                var deleteLink = $("<td><a style = 'cursor:pointer;' >Delete</a></td>");
                deleteLink.click(function () {
                    if (confirm("Do You want to delete this role ?")) {
                        var dataToSend = {
                            "deleteId": deleteId,
                            action: "deleteRole"
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
                                alert("Error occured while deleting User");
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
