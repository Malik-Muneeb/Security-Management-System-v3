$(document).ready(main);

function main() {

    $("#btnSave").click(saveRole);
}

function saveRole() {
    var roleObj = new Object();
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
                tr.append("<td>" + $(this).attr("id") + "</td>");
                tr.append("<td>" + $(this).attr("name") + "</td>");
                tr.append("<td>" + $(this).attr("email") + "</td>");
                var edit = $("<td><a style = 'cursor:pointer;' id ='" + $(this).attr("id") + "'>Edit</a></td>");
                var editId = parseInt($(this).attr("id"));

                edit.click(function () {

                    var dataToSend = {
                        "editId": editId,
                        action: "editUser"
                    }

                    var settings = {
                        type: "post",
                        dataType: "json",
                        url: "apiAjax.php",
                        data: dataToSend,
                        success: function (result) {
                            $("#updateId").val(result["userId"]);
                            $("#txtLogin").val(result["login"]);
                            $("#txtPassword").val(result["password"]);
                            $("#txtName").val(result["name"]);
                            $("#txtEmail").val(result["email"]);
                            $("#cmbCountries").val(result["countryId"]);
                            loadCities();
                            $("#cmbCities").val(result["cityId"]);
                            // $("#cmbCities").get(0).selectedIndex = result["cityId"];
                            //$("#cmbCities").val(result["cityId"]).change();
                            //$("#cmbCities").val(result["cityId"]).attr("selected");
                            //$("#cmbCities").text(result["cityName"]);
                            if (result["isAdmin"] == 1)
                                $("#isAdmin").prop("checked", true);
                            else
                                $("#isAdmin").prop("checked", false);
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
                var deleteId = parseInt($(this).attr("id"));
                var deleteLink = $("<td><a style = 'cursor:pointer;' >Delete</a></td>");
                deleteLink.click(function () {
                    if (confirm("Do You want to delete this record ?")) {
                        var dataToSend = {
                            "deleteId": deleteId,
                            action: "deleteUser"
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
