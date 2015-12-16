$("#verseguidores").click(function() //se crea la funcioin keyup
{
    $.ajax({//metodo ajax
    type: "POST",//aqui puede  ser get o post
    url: Routing.generate('daw_autostop_seguidores'),//la url adonde se va a mandar la cadena a buscar
    data: "cajafran",
    cache: false,
    success: function(html)//funcion que se activa al recibir un dato
    {
    //$("#modalSeguidores").html(html).show();// funcion jquery que muestra el div con identificador display, como formato html, tambien puede ser .text	
    }
    });

    return false;    
});