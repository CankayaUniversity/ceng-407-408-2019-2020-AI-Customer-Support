$(document).ready(function() {
  var navListItems = $("div.setup-panel div a"),
    allWells = $(".setup-content"),
    allNextBtn = $(".nextBtn");

  allWells.hide();

  navListItems.click(function(e) {
    e.preventDefault();
    var $target = $($(this).attr("href")),
      $item = $(this);

    if (!$item.hasClass("disabled")) {
      navListItems.removeClass("btn-success").addClass("btn-default");
      $item.addClass("btn-success");
      allWells.hide();
      $target.show();
      $target.find("input:eq(0)").focus();
    }
  });

  allNextBtn.click(function() {
    var curStep = $(this).closest(".setup-content"),
      curStepBtn = curStep.attr("id"),
      nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]')
        .parent()
        .next()
        .children("a"),
      curInputs = curStep.find("input[type='text'],input[type='url']"),
      isValid = true;

    $(".form-group").removeClass("has-error");
    for (var i = 0; i < curInputs.length; i++) {
      if (!curInputs[i].validity.valid) {
        isValid = false;
        $(curInputs[i])
          .closest(".form-group")
          .addClass("has-error");
      }
    }

    if (isValid) nextStepWizard.removeAttr("disabled").trigger("click");
  });

  $("div.setup-panel div a.btn-success").trigger("click");
});

function saveGeneralSettings() {
  var siteTitle = $("#siteTitle").val();
  var siteSlogan = $("#siteSlogan").val();
  var systemAddress = $("#systemAddress").val();
  var siteAddress = $("#siteAddress").val();
  var siteEmail = $("#siteEmail").val();
  var Servername = $("#Servername").val();
  var Username = $("#Username").val();
  var Password = $("#Password").val();
  var DB_Name = $("#DB_Name").val();
  var action = "GeneralSettings";

  $.ajax({
    url: "/install/insActions.php",
    method: "POST",
    data: {
      action: action,
      siteTitle: siteTitle,
      siteSlogan: siteSlogan,
      systemAddress: systemAddress,
      siteAddress: siteAddress,
      siteEmail: siteEmail,
      Servername: Servername,
      Username: Username,
      Password: Password,
      DB_Name: DB_Name
    },
    success: function(response) {
      if (response) {
      } else {
        console.log("olmadı!");
      }
    }
  });
}

function saveAdminSettings() {
  var AdminUsername = $("#AdminUsername").val();
  var AdminPassword = $("#AdminPassword").val();
  var AdminFirstName = $("#AdminFirstName").val();
  var AdminSurname = $("#AdminSurname").val();
  var AdminEmail = $("#AdminEmail").val();
  var Servername = $("#Servername").val();
  var Username = $("#Username").val();
  var Password = $("#Password").val();
  var DB_Name = $("#DB_Name").val();
  var action = "AdminSettings";

  $.ajax({
    url: "/install/insActions.php",
    method: "POST",
    dataType: "JSON",
    data: {
      action: action,
      AdminUsername: AdminUsername,
      AdminPassword: AdminPassword,
      AdminFirstName: AdminFirstName,
      AdminSurname: AdminSurname,
      AdminEmail: AdminEmail,
      Servername: Servername,
      Username: Username,
      Password: Password,
      DB_Name: DB_Name
    },
    success: function(response) {
      if (response) {
      } else {
        alert("olmadı!");
      }
    }
  });
}
