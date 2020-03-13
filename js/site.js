jQuery(document).ready(function($) {
  $("#editControls a").click(function(e) {
    e.preventDefault();
    switch ($(this).data("role")) {
      case "h1":
      case "h2":
      case "h3":
      case "p":
        document.execCommand("formatBlock", false, $(this).data("role"));
        break;
      default:
        document.execCommand($(this).data("role"), false, null);
        break;
    }

    var textval = $("#editor").html();
    $("#editorCopy").val(textval);
  });

  $("#editor")
    .keyup(function() {
      var value = $(this).html();
      $("#editorCopy").val(value);
    })
    .keyup();

  $("#checkIt").click(function(e) {
    e.preventDefault();
    alert($("#editorCopy").val());
  });
});

// Notification

$(function() {
  var count = 0;
  if (typeof n_count !== "undefined") {
    var count = n_count;
  }
  var lastCount = 0;

  function makeBadge(texte) {
    return '<span class="badge badge-default">' + texte + "</span>";
  }

  appNotifications = {
    // Initialization
    init: function() {
      // We mask the elements.
      $("#notificationsBadge").hide();
      $("#notificationAucune").hide();

      // We bind the click on the notifications
      $("#notifications-dropdown").on("click", function() {
        var open = $("#notifications-dropdown").attr("aria-expanded");

        // Check if the menu is open when you click
        if (open === "false") {
          appNotifications.loadAll();
        }
      });

      // We load the notifications
      //appNotifications.loadAll();
      appNotifications.loadNumber();

      // Polling
      // Every 3 minutes we check if there are no new notifications
      setInterval(function() {
        appNotifications.loadNumber();
      }, 180000);

      // Binding marking as read desktop
      $(".notification-read-desktop").on("click", function(event) {
        appNotifications.markAsReadDesktop(event, $(this));
      });
    },

    // Triggers the loading of the number and the notificationss
    loadAll: function() {
      // Notifiers are only loaded if there is a difference
      // Or if there are no notifications

      if (count !== lastCount || count === 0) {
        appNotifications.load();
      }
      appNotifications.loadNumber();
    },

    // Loading mask for the icon and the badge
    badgeLoadingMask: function(show) {
      if (show === true) {
        $("#notificationsBadge").html(appNotifications.badgeSpinner);
        $("#notificationsBadge").show();
        // Mobile
        $("#notificationsBadgeMobile").html(count);
        $("#notificationsBadgeMobile").show();
      } else {
        $("#notificationsBadge").html(count);
        if (count > 0) {
          $("#notificationsIcon").removeClass("fa-bell-o");
          $("#notificationsIcon").addClass("fa-bell");
          $("#notificationsBadge").show();
          // Mobile
          $("#notificationsIconMobile").removeClass("fa-bell-o");
          $("#notificationsIconMobile").addClass("fa-bell");
          $("#notificationsBadgeMobile").show();
        } else {
          $("#notificationsIcon").addClass("fa-bell-o");
          $("#notificationsBadge").hide();
          // Mobile
          $("#notificationsIconMobile").addClass("fa-bell-o");
          $("#notificationsBadgeMobile").hide();
        }
      }
    },

    // Indicates whether to load notifications
    loadingMask: function(show) {
      if (show === true) {
        $("#notificationAucune").hide();
        $("#notificationsLoader").show();
      } else {
        $("#notificationsLoader").hide();
        if (count > 0) {
          $("#notificationAucune").hide();
        } else {
          $("#notificationAucune").show();
        }
      }
    },

    // Loading the number of notifications
    loadNumber: function() {
      appNotifications.badgeLoadingMask(true);

      // TODO : Call API to retrieve the number

      // TEMP : for the template
      setTimeout(function() {
        $("#notificationsBadge").html(count);
        appNotifications.badgeLoadingMask(false);
      }, 1000);
    },

    // Loading notifications
    load: function() {
      appNotifications.loadingMask(true);

      // We empty the notifs
      $("#notificationsContainer").html("");

      // Saving the number of notifiers
      lastCount = count;

      // TEMP : for the template
      setTimeout(function() {
        // TEMP : for the template
        for (i = 0; i < count; i++) {
          var template = $("#notificationTemplate").html();
          template = template.replace("{{image}}", notifications[i].image);
          template = template.replace("{{href}}", notifications[i].href);
          template = template.replace("{{texte}}", notifications[i].texte);
          template = template.replace("{{date}}", notifications[i].date);

          $("#notificationsContainer").append(template);
        }

        // We bind the marking as read
        $(".notification-read").on("click", function(event) {
          appNotifications.markAsRead(event, $(this));
        });

        // We stop loading
        appNotifications.loadingMask(false);

        // The button is reactivated
        $("#notifications-dropdown").prop("disabled", false);
      }, 1000);
    },

    // Mark a notification as read
    markAsRead: function(event, elem) {
      // Keeps the list open
      event.preventDefault();
      event.stopPropagation();

      // Deleting the notification
      elem.parent(".dropdown-notification").remove();

      // TEMP : for the template
      count--;

      // Update the number
      appNotifications.loadAll();
    },

    // Mark a notification as the desktop version
    markAsReadDesktop: function(event, elem) {
      // Do not change pages
      event.preventDefault();
      event.stopPropagation();

      // Deleting the notification
      elem.parent(".dropdown-notification").removeClass("notification-unread");
      elem.remove();

      // We remove the focus
      if (document.activeElement) {
        document.activeElement.blur();
      }

      // TEMP : for the template
      count--;

      // Update the number
      appNotifications.loadAll();
    },

    add: function() {
      lastCount = count;
      count++;
    },

    // Badge template
    badgeSpinner:
      '<i class="fa fa-spinner fa-pulse fa-fw" aria-hidden="true"></i>'
  };

  appNotifications.init();
});

function submitAnswer(user_id, q_id) {
  var answer = $("#editor").html();
  var action = "answer";
  $.ajax({
    url:"/action.php",
    method:"POST",
    data: {answer:answer, action:action, q_id:q_id, user_id:user_id},
    success:function(response){
      if(response == -1){
        return;
      }
      else{
        location.reload();
      }
    }
  });
}
