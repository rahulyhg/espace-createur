/**
 * Make a tour of the site
 * By: Louis <louis@ne02ptzero.me>
 */

content = {
	0: {
		"title": "Bienvenue !",
		"text": "Ça y est, nous y sommes ! Faisons un rapide tour ensemble voulez-vous ?",
		"placement": "bottom"
	},
	1: {
		"title": "Menu des Créations",
		"text": "Ici, vous pouvez Ajouter, Modifier et supprimer vos Créations, ainsi que gérer vos collections",
		"placement": "bottom"
	},
	2: {
		"title": "Menu des Ventes",
		"text": "Ici, vous pouvez gérer le statut de vos ventes, factures et exporter le tout.",
		"placement": "bottom"
	},
	3: {
		"title": "Menu des Notifications",
		"text": "Ici, vous gérerez vos Notifications. Nous verrons plus tard pour les détails !",
		"placement": "bottom"
	},
	4: {
		"title": "Menu Mon Compte",
		"text": "Ici, vous pouvez gérer vos infos personelles.",
		"placement": "bottom"
	},
	5: {
		"title": "Menu des Tickets",
		"text": "Aussi appelé le bureau des plaintes, c'est par ici que vous devrez aller si vous rencontrez le moindre problème, technique ou non.",
		"placement": "bottom"
	},
	6: {
		"title": "...",
		"text": "Bon, on avait encore de la place dans le menu. Du coup on a mis ça. Bref, rentrons dans les détails !",
		"placement": "bottom",
		"link": "Products/"
	},
	7: {
		"title": "C'est marqué dessus",
		"text": "On va partir du principe que vous savez lire.",
		"placement": "right"
	},
	8: {
		"title": "Tout sélectionner",
		"text": "Ce bouton permet de sélectionner tout vos produits à la fois.",
		"placement": "right",
		"link": "Sales"
	},
	9: {
		"title": "Graphique de vos ventes",
		"text": "Ici, il y a un graphique de vos ventes effectuées durant les 6 derniers jours",
		"placement": "right",
		"link": "Notifications/index/read"
	},
	10: {
		"title": "Un petit résumé",
		"text": "Bienvenue sur l'écran des Notifications ! Il est primordial, car a chaque fois que vous ajoutez / modifiez une création, un Administrateur doit <u>absolument le valider</u> pour que votre modification soit effective. Et c'est ici que ça se passe !",
		"placement": "bottom"
	},
	11: {
		"title": "Done !",
		"text": "Il semblerait que notre petit tour soit terminé ! Pensez à ajouter vos Créations rapidement :) Une question ? Un Ticket !",
		"done": 1,
		"placement": "bottom"
	}
};



v = localStorage.getItem("v");
if (v == null)
	v = 0;

	function	tour() {
		console.log("HERE, "+v);
		for (i = 0; content[i] != undefined; i++) {
			$(".popOver"+i).popover({
				"placement": content[i]["placement"],
				"title": content[i]["title"],
				"content": content[i]["text"] + "<button class='btn btn-danger tourNext'>Suivant <i class='fa fa-chevron-right'></i></button>",
				"html": true
			});
		}
		$(".popOver"+v).popover('show');
	}

$(document).ready(function () {
	$(document).on("click", ".tourNext" ,function() {
		console.log(v);
		if (content[v]["link"] != undefined) {
			localStorage.setItem("v", ((v * 1) +  1));
			window.location.href = "http://team.emma-chloe.com/ec/" + content[v]["link"] + "?tour";
		} else if (content[v]["done"] != undefined) {
			localStorage.setItem("v", 0);
			window.location.href = "http://team.emma-chloe.com/ec/";
		}
		$(".popOver"+v).popover('hide');
		$(".popOver"+v).popover('destroy');
		v++;
		$(".popOver"+v).popover('show');
	});
});
