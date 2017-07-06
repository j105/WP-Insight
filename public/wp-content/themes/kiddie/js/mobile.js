/*
* Kiddie detect mobile devices
*/
var kiddieIsMobile = {
	Android: function() {
		return navigator.userAgent.match(/Android/i);
	},
	BlackBerry: function() {
		return navigator.userAgent.match(/BlackBerry/i);
	},
	iOS: function() {
		return navigator.userAgent.match(/iPhone|iPad|iPod/i);
	},
	Opera: function() {
		return navigator.userAgent.match(/Opera Mini/i);
	},
	Windows: function() {
		return navigator.userAgent.match(/IEMobile/i);
	},
	any: function() {
		return (kiddieIsMobile.Android() || kiddieIsMobile.BlackBerry() || kiddieIsMobile.iOS() || kiddieIsMobile.Opera() || kiddieIsMobile.Windows());
	}
};