/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

jQuery.extend(
{
    postJSON: function(url, data, success_callback, fail_callback)
    {
        return jQuery.ajax(
        {
            type: "POST",
            url: url,
            data: JSON.stringify(data),
            dataType: "json",
            contentType: "application/json",
            processData: false,
            success: function(json)
            {
                success_callback(JSON.stringify(json));
            },
            error: function(json)
            {
                fail_callback(JSON.stringify(json));
            },
        });
     }
});



formatMessage = function(msg)
{
        var h = document.createElement("div");
        var message = document.getElementsByClassName("message")[0];
        message.style.display = "none";
        for( var i = 0; i < msg.length; i++)
        {
            var message1 = copyObject(message);
            message1.getElementsByClassName("message_userlink")[0].innerHTML = msg[i].user_link;
            message1.getElementsByClassName("message_content")[0].innerHTML = msg[i].message;
            message1.getElementsByClassName("message_time")[0].innerHTML = msg[i].time;
            message1.style.display = "block";
            h.appendChild(message1);

        }

        var html = h.innerHTML;
        return html;
};



postClientApi = function(method, params, success_callback, fail_callback)
{
    var data = [{ "id" : 0, "method" : method, "params" : params}];

    $.postJSON("rpc/ClientApi.php", data, success_callback, fail_callback);

}


function copyObject(oldObject)
{
    return oldObject.cloneNode(true);
}



function loadList(method, params, target, callback)
{
    
        $(target).append('<div class="loading_container" ><img src="web/img/loading.gif" /></div>');
        postClientApi(method, params, function (json)
        {
            data = JSON.parse(json)[0].result;
            $(target).children("div.loading_container").remove();
            callback(data);
        });

}
