function initUbicacion(){
    
}

window.addEventListener("load", initUbicacion, false);


 
        websocket.on("socket/connect", function(session){
            session.subscribe("acme/channel", function(uri, payload){
                console.log("Received message", payload.msg);
            });

            session.call("sample/sum", {"term1": 2, "term2": 5}).then(
                    function(result)
                    {
                        console.log("RPC Valid!", result);
                    },
                    function(error, desc)
                    {
                        console.log("RPC Error", error, desc);
                    }
            );

            session.publish("acme/channel", {"msg": "This is a message!"});

            session.publish("acme/channel", {"msg": "Im leaving, I will not see the next message"});

            session.unsubscribe("acme/channel");

            session.publish("acme/channel", {"msg": "I wont see this"});

            session.subscribe("acme/channel", function(uri, payload){
                console.log("Received message", payload.msg);
                var list = document.getElementById("contenido");
                var li = document.createElement("li");
                //var realArray = $.makeArray( payload )
                $.map(payload,function(value, key){
                    li.appendChild(document.createTextNode(JSON.stringify(value)));
                    list.appendChild(li);
                });          
            });
            session.publish("acme/channel", {msg: "Im back!"});
        });

        websocket.on("socket/disconnect", function(error){
            //error provides us with some insight into the disconnection: error.reason and error.code

            console.log("Disconnected for " + error.reason + " with code " + error.code);
        });


