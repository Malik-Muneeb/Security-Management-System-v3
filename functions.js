$(document).ready(main);

function main() {
    //loadUserTable();
    loadCountries();
    $("#cmbCountries").change(loadCities);
    $("#btnSave").click(saveUser);
    $("#btnClear").click(clearFields);

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

function loadCities() {

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

    console.log(userObj.isAdmin);
    var dataToSend = {
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