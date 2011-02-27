
$(document).ready(function() {

	//Assigns "menu-active" class to menu button pointing to active url
	var aHrefs = $("a");
	$.each(aHrefs, function (i,e) {
	    var href = $(e).attr('href');
	    var currentHref = top.location.href;
	
	    if ( href == currentHref ) {
         	$(e).addClass('menu-active');
    	}
	});
	
	//Centers menu buttons' div between "www.furgovw.org" and "KDD.NACIONAL" images
	//calculates buttons' div's width and then centers it 
	var menuButtons = $("#menu a");
	var totalWidth = 0;
	$.each(menuButtons, function (i,e) {
	    var width = $(e).outerWidth(true);
	    totalWidth += width;
	});	
	$('#menuButtonsContainer').width(totalWidth);
	$('#menuButtonsContainer').css('margin', '0 auto');
});
