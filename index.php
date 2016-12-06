<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Aminal Giphy</title>
</head>
<body>
<header></header>
<main></main>
<footer></footer>
<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
<script type="text/javascript">

$(document).ready(function() { 
    var init = true;
    
    if (init) {
        var topics = ["dog","cat","rat","horse"]; //initial array of topics
        var buttons_div = $("<div id='buttons'>");
        $("main").append(buttons_div);

        for (i=0; i<topics.length; i++) { //add buttons to page
            var button = $("<button>").attr("data-animal", topics[i]).html(topics[i]);            
            $("#buttons").append(button);
        };

        $("main").append(f_build_html( //create form for new gif button
            "div", { id: "new_gif" }, f_build_html(
                "form", {id: "new_gif_form"}, "New gif: <br />" + f_build_html(
                    "input", {name: "new_gif_input", type: "text"}, ""
        ))));
        
        var gifs_div = $("<div id='gifs'>");
        $("main").append(gifs_div);
        
        init = false;

    };

    $("input[name='new_gif_input']").keypress(function (e) {
        var key = e.which; //e.which jquery returns which keypress
        
        if (key == 13) { //if the keypress is enter
            var text = $("input[name='new_gif_input']").val();
            topics.push(text);
            var new_topic = topics[topics.length - 1];
            var new_button = $("<button>").attr("data-animal", new_topic).html(new_topic);
            $("#buttons").append(new_button);                
        };
        
    });

    $("button").on("click", function() {
        
        $("#gifs").empty(); //empty the gifs div

        var animal = $(this).data("animal");
        var queryURL = "http://api.giphy.com/v1/gifs/search?q=" +
        animal + "&api_key=dc6zaTOxFJmzC&limit=10";

        $.ajax({ url: queryURL, method: "GET" }).done(function(response) {
            
            var results = response.data;

            for (var i = 0; i < results.length; i++) {
                
                var gif_div = $("<div class='item'>");
                var rating = results[i].rating;
                var p = $("<p>").text("Rating: " + rating);
                var animal_img = $("<img>");

                animal_img.attr("src", results[i].images.fixed_height.url);
                gif_div.prepend(p);
                gif_div.prepend(animal_img);
                $("#gifs").prepend(gif_div);

            };
        });
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

/*
    $("button").on("click", function() {
      
      var animal = $(this).data("animal");
      var queryURL = "http://api.giphy.com/v1/gifs/search?q=" +
        animal + "&api_key=dc6zaTOxFJmzC&limit=10";

      $.ajax({ url: queryURL, method: "GET" })
        .done(function(response) {
          var results = response.data;

          for (var i = 0; i < results.length; i++) {
            var gifDiv = $("<div class='item'>");

            var rating = results[i].rating;

            var p = $("<p>").text("Rating: " + rating);

            var personImage = $("<img>");
            personImage.attr("src", results[i].images.fixed_height.url);

            gifDiv.prepend(p);
            gifDiv.prepend(personImage);

            $("#gifs-appear-here").prepend(gifDiv);
          }
        });*/
/*
        for (i=0; i<results.length; i++) {
          // Make a div with jQuery and store it in a variable named animalDiv.
          var p = $("<p>").text("Rating: " + rating);
          var g = document.createElement('div');
          var animalDiv = $("<div>");
          // Make a paragraph tag with jQuery and store it in a variable named p.
          var p = $("<p>");
          // Set the inner text of the paragraph to the rating of the image in results[i].
          p.text(results[i]);
          // Make an image tag with jQuery and store it in a variable named animalImage.
          var animalImage = $("<img>");
          // Set the image's src to results[i]'s fixed_height.url.
          animalImage.attr("src", results[i].fixed_height.url);
          // Append the p variable to the animalDiv variable.
          animalDiv.append(p);
          // Append the animalImage variable to the animalDiv variable.
          animalDiv.append(animalImage);
          // Prepend the animalDiv variable to the element with an id of gifs-appear-here.
          $("#gifs-appear-here").prepend(animalDiv);
        };
*/
/*


    
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
*/
</script>
</body>
</html>