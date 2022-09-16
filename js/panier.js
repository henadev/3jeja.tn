"use strict";

const query_url_string_search = window.location.search;

const urlId = new URLSearchParams(query_url_string_search);

const id = urlId.get("id");
console.log(id);


$('#panier').on('click',function(){
    $.post(
         'show_product.php?id=$id',
        {id:'id'},
        function(data){
            console.log(data);
        }
    )
});



