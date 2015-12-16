$(".busca").keyup(function() //se crea la funcioin keyup
{
    var texto = $(this).val();//se recupera el valor de la caja de texto y se guarda en la variable texto
    var dataString = 'palabra='+ texto;//se guarda en una variable nueva para posteriormente pasarla a search.php
    if(texto=='')//si no tiene ningun valor la caja de texto no realiza ninguna accion
    {
    }
    else
    {
        $.ajax({//metodo ajax
        type: "POST",//aqui puede  ser get o post
        url: Routing.generate('daw_autostop_buscar'),//la url adonde se va a mandar la cadena a buscar
        data: dataString,
        cache: false,
        success: function(html)//funcion que se activa al recibir un dato
        {
        $("#display").html(html).show();// funcion jquery que muestra el div con identificador display, como formato html, tambien puede ser .text
                }
        });
    }return false;    
});

$(document).mouseup(function (e)
{
    var container = $("#display");

    if (!container.is(e.target) // if the target of the click isn't the container...
        && container.has(e.target).length === 0) // ... nor a descendant of the container
    {
        container.hide();
    }
});

$("#btnseguir").click(function() {
    var usuariop = $('#btnseguir').data('path');
    
        $.ajax({//metodo ajax
        type: "GET",//aqui puede  ser get o post
        url: Routing.generate('daw_autostop_amigos',{ usuariop: usuariop }),//la url adonde se va a mandar la cadena a buscar
        data: "cajafran",
        cache: false,
        success: function(data) {
                    alert(data);
                }
            });
        
   return false;
});

$('.siguiendobtn .green').click(function() {
    
	$(this).toggleClass('glyphicon glyphicon-ok-circle green');
	$(this).toggleClass('ace-icon fa fa-plus-circle bigger-120 gray'); 
});
$('.nosiguiendobtn .gray').click(function() {
	$(this).toggleClass('ace-icon fa fa-plus-circle bigger-120 gray'); 
	$(this).toggleClass('glyphicon glyphicon-ok-circle green');
        
});

$('.siguiendobtn').click(function() {
	var $this1 = $(this).find('.txtDejarSeguir');
    if($this1.text()=="Dejar de seguir"){
        $this1.text('Seguir');         
    } else {
        $this1.text('Dejar de seguir');
        
        var usuariop = $('#btnseguir').data('path');

        alert("solicitud enviada");

            $.ajax({//metodo ajax
            type: "GET",//aqui puede  ser get o post
            url: Routing.generate('daw_autostop_amigos',{ usuariop: usuariop }),//la url adonde se va a mandar la cadena a buscar
            data: "cajafran",
            cache: false,
            success: function(data) {
                        alert(data);
                    }
                });

        return false;
    }
});
$('.nosiguiendobtn').click(function() {
    var $this1 = $(this).find('.txtSeguir');
    if($this1.text()=="Seguir"){
        $this1.text('Dejar de seguir');
        
        var usuariop = $(this).data('path');

        alert("solicitud enviada");

            $.ajax({//metodo ajax
            type: "GET",//aqui puede  ser get o post
            url: Routing.generate('daw_autostop_amigos',{ usuariop: usuariop }),//la url adonde se va a mandar la cadena a buscar
            data: "cajafran",
            cache: false,
            success: function(data) {
                        alert(data);
                    }
                });

        return false;
        
    } else {
        $this1.text('Seguir');
    }
});
