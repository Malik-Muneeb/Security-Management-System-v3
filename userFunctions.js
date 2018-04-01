
    $(document).ready(main);

function main() {
    loadCountries();
    $("#cmbCountries").change(loadCities);
    $("#btnSave").click(saveUser);
    $("#btnClear").click(clearFields);
    loadUserTable();
}

function loadCountries() {
    var dataToSend = {
        action: "fetchCountries"
    };

    var setting = {
        type: "post",
        dataType: "json",
        url: "apiAjax.php",
        data: dataToSend,
        success: function (result) {
            var cmbCountries = $("#cmbCountries");
            cmbCountries.html("<option value='0'>--Select--</option>");
            $(result).each(function () {
                cmbCountries.append("<option value='" + $(this).attr("countryId") + "'>" + $(this).attr("name") + "</option>");
            });
        },
        error: function () {
            alert("some Error Occured while Loading Countries.");
        }
    };
    $.ajax(setting);
}

function loadCities(cId) {

    var countryId = $("#cmbCountries").val();
    var dataToSend = {
        "countryId": countryId,
        action: "fetchCities"
    };

    var settings = {
        type: "POST",
        dataType: "json",
        url: "apiAjax.php",
        data: dataToSend,
        success: function (result) {
            $("#cmbCities").empty();
            var cmbCities = $("#cmbCities");
            cmbCities.html("<option value='0'>--Select--</option>");
            $(result).each(function () {
                if($(this).attr("cityId")==cId)
                    cmbCities.append("<option value='" + $(this).attr("cityId") + "'selected>" + $(this).attr("name") + "</option>");
                else
                    cmbCities.append("<option value='" + $(this).attr("cityId") + "'>" + $(this).attr("name") + "</option>");
            });
        },
        error: function () {
            alert("some Error Occured while Loading Cities.");
        }
    };
    $.ajax(settings);
}

function saveUser() {
    var userObj = new Object();
    userObj.updateId=$("#updateId").val();
    userObj.login = document.getElementById("txtLogin").value;
    userObj.password = document.getElementById("txtPassword").value;
    userObj.name = document.getElementById("txtName").value;
    userObj.email = document.getElementById("txtEmail").value;
    var countries = document.getElementById("cmbCountries");
    userObj.country = countries.options[countries.selectedIndex].value;
    var cities = document.getElementById("cmbCities");
    userObj.city = cities.options[cities.selectedIndex].value;
    if ($("#isAdmin").prop('checked') == true)
        userObj.isAdmin = 1;
    else
        userObj.isAdmin = 0;

    if (userObj.login == "") {
        alert("Enter Login!");
        return false;
    }
    else if (userObj.password == "" || userObj.password.length < 8) {
        alert("Enter password and size of password must greater than 8");
        return false;
    }
    else if (userObj.name == "") {
        alert("Enter Name!");
        return false;
    }
    else if (userObj.email == "") {
        alert("Enter Email");
        return false;
    }
    else if (userObj.country == "0") {
        alert("Select Country!");
        return false;
    }
    else if (userObj.city == "0") {
        alert("Select City!");
        return false;
    }

    console.log(userObj.updateId);
    var dataToSend = {
        "txtUpdateId":userObj.updateId,
        "txtLogin": userObj.login,
        "txtPassword": userObj.password,
        "txtName": userObj.name,
        "txtEmail": userObj.email,
        "cmbCountries": userObj.country,
        "cmbCities": userObj.city,
        "adminStatus": userObj.isAdmin,
        action: "saveUser"
    };

    var settings = {
        type: "POST",
        dataType: "json",
        url: "apiAjax.php",
        data: dataToSend,
        success: function (result) {
            alert(result);
            $("#txtLogin").val("");
            $("#txtPassword").val("");
            $("#txtName").val("");
            $("#txtEmail").val("");
            $("#cmbCountries").val("0");
            $("#cmbCities").val("0");
            location.reload();
            //loadUserTable();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert("error while saving user");
            console.log(JSON.stringify(jqXHR));
            console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
        }
    };

    $.ajax(settings);
}

function clearFields() {
    $("#txtLogin").val("");
    $("#txtPassword").val("");
    $("#txtName").val("");
    $("#txtEmail").val("");
    $("#cmbCountries").val("0");
    $("#cmbCities").val("0");
}

function loadUserTable() {

    var dataToSend = {
        action: "getAllUsers"
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
                        "editId":editId,
                        action:"editUser"
                    }

                    var settings={
                        type:"post",
                        dataType:"json",
                        url:"apiAjax.php",
                        data:dataToSend,
                        success:function (result) {
                            $("#updateId").val(result["userId"]);
                            $("#txtLogin").val(result["login"]);
                            $("#txtPassword").val(result["password"]);
                            $("#txtName").val(result["name"]);
                            $("#txtEmail").val(result["email"]);
                            $("#cmbCountries").val(result["countryId"]);
                            loadCities(result["cityId"]);
                            //$("#cmbCities").val(result["cityId"]);
                           // $("#cmbCities").get(0).selectedIndex = result["cityId"];
                            //$("#cmbCities").val(result["cityId"]).change();
                            //$("#cmbCities").val(result["cityId"]).attr("selected");
                            //$("#cmbCities").text(result["cityName"]);
                            if(result["isAdmin"]==1)
                                $("#isAdmin").prop("checked",true);
                            else
                                $("#isAdmin").prop("checked",false);
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
                   if(confirm("Do You want to delete this record ?")){
                       var dataToSend={
                           "deleteId":deleteId,
                           action:"deleteUser"
                       }
                       var settings={
                           type:"post",
                           dataType:"json",
                           url:"apiAjax.php",
                           data:dataToSend,
                           success:function (result) {
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

