var demo = [
	"Animal.zip",
	"Chisel.zip",
	"Flansmod.zip",
	"furniture.zip",
	"LegacyJavaFixer.zip",
	"Chisel.zip",
	"Animal.zip",
	"Chisel.zip",
	"Flansmod.zip",
	"furniture.zip",
	"LegacyJavaFixer.zip",
	"Chisel.zip"
];
jQuery(function($){
	$("#menu a").click(function(e){
		e.preventDefault();
		$("#menu a.active").removeClass("active");
		$(this).addClass("active");
		var num = parseInt($(this).attr("data-tab").replace("pane-",""))-1;
		$("#panes").animate({
			left: -num*390
		});
		console.log("dr");
	});
});