
$(document).ready(function () {
    
    // You have to create a `Bricklayer` instance for every Bricklayer container you have.
    $(".blogBricklayer").each(function(){    
        var bricklayer = new window.Bricklayer(this);
    });
    
});
