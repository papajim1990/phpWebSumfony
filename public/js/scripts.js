/**
 * Created by user1 on 20/1/2018.
 */
// Returns text statistics for the specified editor by id
function getStats(id) {
    var body = tinymce.get(id).getBody(), text = tinymce.trim(body.innerText || body.textContent);

    return {
        chars: text.length,
        words: text.split(/[\w\u2019\'-]+/).length
    };
}
function submitForm() {
    // Check if the user has entered less than 1000 characters
    if (getStats('content').chars > 1000) {
        alert("You need to enter 1000 characters or less.");
        return false;
    }else {
        return true;
    }

}
$( ".insertform" ).submit(function( event ) {
    var flag=submitForm();
    if (flag){

    }else {
        event.preventDefault();
    }
});
$(".img-to-delete").click(function(){
    var element=$(this).parent();
    var src=$(this).parent().find("img").attr("src").replace("..","").replace("/","").replace("images","");
    alert(src);
    var url="/DeleteFile";
    jQuery.ajax({
        url: url,
        data: {
            imgurl: src
        },method: 'POST'
    }).done(function(data) {
        $(element).remove();


        });
});
