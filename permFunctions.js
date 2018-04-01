$(document).ready(main);

function main() {
    loadPerTable();
    $("#btnSave").click(savePer);
    $("#btnClear").click(clearFields);
}

function savePer() {
    var perObj = new Object();
    perObj.updateId = $("#updateId").val();
    perObj.perName = document.getElementById("txtName").value;
    perObj.perDesc = document.getElementById("txtDesc").value;
    if (perObj.perName == "") {
        alert("Enter Permission!");
        return false;
    }
    else if (perObj.perDesc == "") {
        alert("Enter permissions's description");
        return false;
    }

    var dataToSend = {
        "txtUpdateId": perObj.updateId,
        "txtName": perObj.perName,
        "txtDesc": perObj.perDesc,
        action: "savePer"
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
            alert("error while saving permission");
            console.log(JSON.stringify(jqXHR));
            console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
        }
    }
    $.ajax(settings);
}

function loadPerTable() {

    var dataToSend = {
        action: "getAllPers"
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
                tr.append("<td>" + $(this).attr("permissionId") + "</td>");
                tr.append("<td>" + $(this).attr("name") + "</td>");
                tr.append("<td>" + $(this).attr("description") + "</td>");
                var edit = $("<td><a style = 'cursor:pointer;' id ='" + $(this).attr("permissionId") + "'>Edit</a></td>");
                var editId = parseInt($(this).attr("permissionId"));

                edit.click(function () {
                    var dataToSend = {
                        "editId": editId,
                        action:"editPer"
                    }

                    var settings = {
                        type: "post",
                        dataType: "json",
                        url: "apiAjax.php",
                        data: dataToSend,
                        success: function (result) {
                            $("#updateId").val(result["permissionId"]);
                            $("#txtName").val(result["name"]);
                            $("#txtDesc").val(result["description"]);
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            alert("Error occured while Editing Permission");
                            console.log(JSON.stringify(jqXHR));
                            console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                        }
                    }
                    $.ajax(settings);
                });
                tr.append(edit);
                var deleteId = parseInt($(this).attr("permissionId"));
                var deleteLink = $("<td><a style = 'cursor:pointer;' >Delete</a></td>");
                deleteLink.click(function () {
                    if (confirm("Do You want to delete this permission ?")) {
                        var dataToSend = {
                            "deleteId": deleteId,
                            action: "deletePer"
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

function clearFields() {
    $("#txtName").val("");
    $("#txtDesc").val("");
}

