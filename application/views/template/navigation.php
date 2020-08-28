<style type="text/css">
	a {
		color: black;
	}
	a:hover {
		color: yellow;
		font-weight: bold;
		text-shadow:none;
		background-color:black;
	}
</style>
<script>
$(document).ready(function(){
	$("ul.root li.hasChild a").click(function(e) {
		e.stopPropagation(); 		//ketika klik yg di dalam, ga naik ke atasnya. jadi klik submenu yg jalan hanya submenunya saja
								
		if ($(this).attr('href') == '#')
		{
			e.preventDefault();		//untuk mencegah defaultnya
			
			$("ul.root li.hasChild ul").slideUp(function(){
				$(this).parent().find('i').removeClass("fa-caret-down");
				$(this).parent().find('i').addClass("fa-hand-o-right");
			})
			
			var ul=$(this).parent().find('ul:visible');		//$(this) adalah element yang sedang ditunjuk
			//console.log(ul.length);
			if (ul.length > 0)
				$(this).parent().find('ul').slideUp(function(){
					$(this).parent().find('i').removeClass("fa-caret-down");
					$(this).parent().find('i').addClass("fa-hand-o-right");
				});		//fungsi2 jquery lihat di jquery.com
			else
				$(this).parent().find('ul').slideDown(function(){
					$(this).parent().find('i').removeClass("fa-hand-o-right");
					$(this).parent().find('i').addClass("fa-caret-down");
				});
		}
	});
});
</script>
