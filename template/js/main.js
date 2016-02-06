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
	});
	$("#mod").change(function(e){
		e.preventDefault();
		var form = document.forms.namedItem("upload");

		console.log(e);
		var xhr = new XMLHttpRequest();
		xhr.addEventListener("load", function(e){
			console.log("complete");
		});
		xhr.addEventListener("progress", function(e){
			var percent = Math.round(e.loaded/e.total * 100);
			console.log(percent+"%");
		});
		xhr.open("POST","api/mods",true);
		xhr.send(new FormData(form));
	});
});