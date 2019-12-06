var check = function() {
  if (document.getElementById('Password').value ==
    document.getElementById('ConfirmPassword').value) {
    document.getElementById('message').style.color = 'green';
    document.getElementById('message').innerHTML = 'Password matching';
  } else {
    document.getElementById('message').style.color = 'red';
    document.getElementById('message').innerHTML = 'Password is not matching';
  }
}

jQuery(document).ready(function($) {
	/** ******************************
		* Simple WYSIWYG
		****************************** **/
	$('#editControls a').click(function(e) {
		e.preventDefault();
		switch($(this).data('role')) {
			case 'h1':
			case 'h2':
			case 'h3':
			case 'p':
				document.execCommand('formatBlock', false, $(this).data('role'));
				break;
			default:
				document.execCommand($(this).data('role'), false, null);
				break;
		}

		var textval = $("#editor").html();
		$("#editorCopy").val(textval);
	});

	$("#editor").keyup(function() {
		var value = $(this).html();
		$("#editorCopy").val(value);
	}).keyup();
	
	$('#checkIt').click(function(e) {
		e.preventDefault();
		alert($("#editorCopy").val());
	});
});

// Notification

$(function () {

	var count = 6;
	var lastCount = 0;
  
	// Pour la maquette
	var notifications = new Array();
	notifications.push({
	  href: "#",
	  image: "Modification",
	  texte: "Votre incident " + makeBadge("17-0253") + " a été modifié",
	  date: "Mercredi 10 Mai, à 9h53"
	});
	notifications.push({
	  href: "#",
	  image: "Horloge",
	  texte: "Vous avez " + makeBadge("13") + " incidents en retards",
	  date: "Mercredi 10 Mai, à 8h00"
	});
	notifications.push({
	  href: "#",
	  image: "Visible",
	  texte: "Un nouvel incident dans votre groupe " + makeBadge("réseau"),
	  date: "Mardi 9 Mai, à 18h12"
	});
	notifications.push({
	  href: "#",
	  image: "Ajout",
	  texte: "Ouverture du problème " + makeBadge("17-0008"),
	  date: "Mardi 9 Mai, à 15h23"
	});
	notifications.push({
	  href: "#",
	  image: "Annulation",
	  texte: "Clotûre du problème " + makeBadge("17-0007"),
	  date: "Mardi 9 Mai, à 12h16"
	});
	notifications.push({
	  href: "#",
	  image: "Recherche",
	  texte: "Ouverture de l'incident " + makeBadge("17-1234") + " depuis le portail web",
	  date: "Mardi 9 Mai, à 10h14"
	});
  
	function makeBadge(texte) {
	  return "<span class=\"badge badge-default\">" + texte + "</span>";
	}
  
	appNotifications = {
  
	  // Initialisation
	  init: function () {
		// On masque les éléments
		$("#notificationsBadge").hide();
		$("#notificationAucune").hide();
  
		// On bind le clic sur les notifications
		$("#notifications-dropdown").on('click', function () {
  
		  var open = $("#notifications-dropdown").attr("aria-expanded");
  
		  // Vérification si le menu est ouvert au moment du clic
		  if (open === "false") {
			appNotifications.loadAll();
		  }
  
		});
  
		// On charge les notifications
		appNotifications.loadAll();
  
		// Polling
		// Toutes les 3 minutes on vérifie si il n'y a pas de nouvelles notifications
		setInterval(function () {
		  appNotifications.loadNumber();
		}, 180000);
  
		// Binding de marquage comme lue desktop
		$('.notification-read-desktop').on('click', function (event) {
		  appNotifications.markAsReadDesktop(event, $(this));
		});
  
	  },
  
	  // Déclenche le chargement du nombre et des notifs
	  loadAll: function () {
  
		// On ne charge les notifs que si il y a une différence
		// Ou si il n'y a aucune notifs
		if (count !== lastCount || count === 0) {
		  appNotifications.load();
		}
		appNotifications.loadNumber();
  
	  },
  
	  // Masque de chargement pour l'icône et le badge
	  badgeLoadingMask: function (show) {
		if (show === true) {
		  $("#notificationsBadge").html(appNotifications.badgeSpinner);
		  $("#notificationsBadge").show();
		  // Mobile
		  $("#notificationsBadgeMobile").html(count);
		  $("#notificationsBadgeMobile").show();
		}
		else {
		  $("#notificationsBadge").html(count);
		  if (count > 0) {
			$("#notificationsIcon").removeClass("fa-bell-o");
			$("#notificationsIcon").addClass("fa-bell");
			$("#notificationsBadge").show();
			// Mobile
			$("#notificationsIconMobile").removeClass("fa-bell-o");
			$("#notificationsIconMobile").addClass("fa-bell");
			$("#notificationsBadgeMobile").show();
		  }
		  else {
			$("#notificationsIcon").addClass("fa-bell-o");
			$("#notificationsBadge").hide();
			// Mobile
			$("#notificationsIconMobile").addClass("fa-bell-o");
			$("#notificationsBadgeMobile").hide();
		  }
  
		}
	  },
  
	  // Indique si chargement des notifications
	  loadingMask: function (show) {
  
		if (show === true) {
		  $("#notificationAucune").hide();
		  $("#notificationsLoader").show();
		} else {
		  $("#notificationsLoader").hide();
		  if (count > 0) {
			$("#notificationAucune").hide();
		  }
		  else {
			$("#notificationAucune").show();
		  }
		}
  
	  },
  
	  // Chargement du nombre de notifications
	  loadNumber: function () {
		appNotifications.badgeLoadingMask(true);
  
		// TODO : API Call pour récupérer le nombre
  
		// TEMP : pour le template
		setTimeout(function () {
		  $("#notificationsBadge").html(count);
		  appNotifications.badgeLoadingMask(false);
		}, 1000);
	  },
  
	  // Chargement de notifications
	  load: function () {
		appNotifications.loadingMask(true);
  
		// On vide les notifs
		$('#notificationsContainer').html("");
  
		// Sauvegarde du nombre de notifs
		lastCount = count;
  
		// TEMP : pour le template
		setTimeout(function () {
  
		  // TEMP : pour le template
		  for (i = 0; i < count; i++) {
  
			var template = $('#notificationTemplate').html();
			template = template.replace("{{href}}", notifications[i].href);
			template = template.replace("{{image}}", notifications[i].image);
			template = template.replace("{{texte}}", notifications[i].texte);
			template = template.replace("{{date}}", notifications[i].date);
  
			$('#notificationsContainer').append(template);
		  }
  
		  // On bind le marquage comme lue
		  $('.notification-read').on('click', function (event) {
			appNotifications.markAsRead(event, $(this));
		  });
  
		  // On arrête le chargement
		  appNotifications.loadingMask(false);
  
		  // On réactive le bouton
		  $("#notifications-dropdown").prop("disabled", false);
		}, 1000);
	  },
  
	  // Marquer une notification comme lue
	  markAsRead: function (event, elem) {
		// Permet de garde la liste ouverte
		event.preventDefault();
		event.stopPropagation();
  
		// Suppression de la notification
		elem.parent('.dropdown-notification').remove();
  
		// TEMP : pour le template
		count--;
  
		// Mise à jour du nombre
		appNotifications.loadAll();
	  },
  
	  // Marquer une notification comme lue version bureau
	  markAsReadDesktop: function (event, elem) {
		// Permet de ne pas change de page
		event.preventDefault();
		event.stopPropagation();
  
		// Suppression de la notification
		elem.parent('.dropdown-notification').removeClass("notification-unread");
		elem.remove();
  
		// On supprime le focus
		if (document.activeElement) {
		  document.activeElement.blur();
		}
  
		// TEMP : pour le template
		count--;
  
		// Mise à jour du nombre
		appNotifications.loadAll();
	  },
  
	  add: function () {
		lastCount = count;
		count++;
	  },
  
	  // Template du badge
	  badgeSpinner: '<i class="fa fa-spinner fa-pulse fa-fw" aria-hidden="true"></i>'
	};
  
	appNotifications.init();
  
  });
  