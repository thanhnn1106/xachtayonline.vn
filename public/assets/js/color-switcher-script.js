google.setOnLoadCallback(function()
{
    // Color changer css
	 $(".color-one").on("click", function(){
		
        $("link#menucss").attr("href", "css/horizontal-menu-5.css");
        return false;
    });
    $(".color-two").on("click", function(){
        $("link#menucss").attr("href", "css/horizontal-menu-2.css");
        return false;
    });
    
    $(".color-three").on("click", function(){
        $("link#menucss").attr("href", "css/horizontal-menu-3.css");
        return false;
    });
    
    $(".color-four").on("click", function(){
        $("link#menucss").attr("href", "css/horizontal-menu-4.css");
        return false;
    });
    $(".color-five").on("click", function(){
        $("link#menucss").attr("href", "css/horizontal-menu-1.css");
        return false;
    });

});