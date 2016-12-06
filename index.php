<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Animal Giphy</title>
</head>
<body>
<header></header>
<main></main>
<footer></footer>
<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
<script type="text/javascript">

$(document).ready(function() { 

    var topics = ["dog","cat","rat","horse"]; //initial array of topics
    var results = []; //init results, array of objects from giphy api ajax request

    $("main").append(f_build_html("div", { id: "buttons" }, "") + "<br />"); //create div #buttons

    for (i=0; i<topics.length; i++) { //add buttons to page      
        $("#buttons").append(f_build_html("button", { id: topics[i], class: "topic_button" }, topics[i])); //append button to div #buttons
    };

    $("main").append(f_build_html( //create form for new gif button
        "div", { id: "new_gif" }, f_build_html(
            "form", {id: "new_gif_form"}, "New gif: <br />" + f_build_html(
                "input", {name: "new_gif_input", type: "text"}, ""
    ))) + "<br />");
    
    $("main").append(f_build_html("div", { id: "gifs" }, ""));

    $(this).on("click", ".topic_button", function() {
        $("#gifs").empty(); //empty the gifs div
        results = []; //clear results array if already full of objects from last button click
        var topic = this.id;
        var queryURL = "http://api.giphy.com/v1/gifs/search?q=" + topic + "&api_key=dc6zaTOxFJmzC&limit=10&rating=y&rating=g&rating=pg";

        $.ajax({ url: queryURL, method: "GET" }).done(function(response) {    
            results = response.data;
            for (var i = 0; i < results.length; i++) {
                $("#gifs").append(f_build_html("img", { src: results[i].images.fixed_height.url, alt: topic, class: "gif", id: i}, "") + "<br />" + f_build_html("p", {}, "Rating: " + results[i].rating));
            };
        });
    });

    $(this).on("click", ".gif", function() {
        var gif_num = this.id;
        var gif_current_url = $("img[id=" + gif_num + "]").attr("src");
        var gif_url = results[gif_num].images.fixed_height.url;
        var gif_still_url = results[gif_num].images.fixed_height_still.url;
        
        if (gif_current_url === gif_url) {
            $("img[id=" + gif_num + "]").attr("src", gif_still_url);
        } else {
            $("img[id=" + gif_num + "]").attr("src", gif_url);
        };
    });

    $("input[name='new_gif_input']").keypress(function (e) {

        var key = e.which; //e.which jquery returns which keypress

        if (key == 13) { //if the keypress is enter
            e.preventDefault();
            var text = $("input[name='new_gif_input']").val();
            $("#buttons").append(f_build_html("button", { id: text, class: "topic_button" }, text));
            return false;       
        };
        
    });

    function f_build_html (tag, attrs, inner_html) { //helper function to build html tags
        var h = '<' + tag; //opening tag       
        for (var attr in attrs) {
            if(attrs[attr] === false) {
                continue;
            };
            h += ' ' + attr + '="' + attrs[attr] + '"';
        };
        return h += inner_html ? '>' + inner_html + '</' + tag + '>' : '/>';
    };

});

</script>
</body>
</html>