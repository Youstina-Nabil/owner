<?php

session_start();

include 'config.php';
$buslinename=   $_SESSION['Redraw_Bus_line_name'];
$busno=         $_SESSION['Redraw_Bus_No'] ;

$querydelete = mysql_query("DELETE FROM `points` WHERE  (`BusLineName`='$buslinename') and (`BusNo`='$busno')" );


if($querydelete === FALSE) { 
    die('Could not delete already existing coordinates ' . mysql_error());
}

?>

<!DOCTYPE html>
<html>

    <head>
        <title>Edit Geofence</title>
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
        <style type="text/css">
            html { height: 100% }
            body { height: 100%; margin: 0; padding: 0 }
            #map-canvas {
                height: 100% 
            }

            #panel {
                width: 200px;
                font-family: Arial, sans-serif;
                font-size: 13px;
                float: right;
                margin: 10px;
            }
            
            #delete-button {
                margin-top: 5px;
            }
            
        </style>
            <link rel="stylesheet" href="css/bootstrap.css"/>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"> </script> 
        <script src="js/jquery-3.0.0.min.js"></script>
        <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBljsHY_7GbYRYTSfrmrl4ot2QQI2mOchE&libraries=drawing&callback=initialize"async defer>
        </script> 
        <script>

            var map; // Global declaration of the map
            var lat_longs = new Array();
            var markers = new Array();
            var drawingManager;
            var selectedShape;
            
            function initialize() {
                
                var latitude =30.049495697021484;
                var longitude =31.339378356933594;
                var myCenter = new google.maps.LatLng(latitude, longitude)

                var mapProp = {
                    zoom: 13,
                    center: myCenter,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                }
                map = new google.maps.Map(document.getElementById("map_canvas"), mapProp);

                drawingManager = new google.maps.drawing.DrawingManager({
                    drawingMode: google.maps.drawing.OverlayType.POLYGON,
                    drawingControl: true,
                    drawingControlOptions: {
                        position: google.maps.ControlPosition.TOP_CENTER,
                        drawingModes: [google.maps.drawing.OverlayType.POLYGON]
                    },
                    polygonOptions: {
                        editable: true,
                        draggable: true
                    }
                });
                drawingManager.setMap(map);

                //coordinates
                google.maps.event.addListener(drawingManager, "overlaycomplete", function (event) { //event --> event object to process
                    var newShape = event.overlay;
                    newShape.type = event.type;  //type of the event -->ex : google.maps.overlay.polygon
                    
                   selectedShape= newShape;
                });

                google.maps.event.addListener(drawingManager, "overlaycomplete", function (event) {
                    overlayClickListener(event.overlay);
                    $('#vertices').val(event.overlay.getPath().getArray());    //.getpath() return an MVC array of latlng instances

                });
                                
                google.maps.event.addDomListener(document.getElementById('delete-button'), 'click', deleteSelectedShape);
            }
            
            
            function overlayClickListener(overlay) {
                google.maps.event.addListener(overlay, "mouseup", function (event) {
                    $('#vertices').val(overlay.getPath().getArray());  //$(selector).action()
                });
            }
            
            
            function deleteSelectedShape() {
                if (selectedShape) {
                  selectedShape.setMap(null);
                    $('#vertices').val('');                     
                }
            }
            
           
            $(document).ready(function () { // event delegation
                $('#map_form').on('click', '#save', function () {

                    //iterate polygon vertices
                    var Result = $('#vertices').val();

                    var partsOfStr = Result.split(',');
                    var latitude ,longitude;
                    var lats =[];
                    var longs= [];
                    var test;

                    for (i = 0; i < partsOfStr.length; i++) { 
                        test =partsOfStr[i];
                         if(test.charAt(0)==='('){
                             latitude =test.slice(1);
//                             console.log(latitude);
                             lats.push(latitude);  
                             
                         }
                         
                         else if(test.charAt(test.length-1)===')'){
                             longitude=test.slice(1, -1); //str = str.substring(0, str.length - 1);
                             //console.log(longitude);
                             longs.push(longitude);
                         }
                    }



                    console.log("result is here :")
                     console.log(Result);
//                    console.log(partsOfStr);
//                    console.log(lats);
//                    console.log(longs);

                    if(Result===null || Result===""){
                        alert("please select a geofence for bus ");
                    }
                    else{
                    $.ajax({
                                type: "POST",
                                url: "Save.php",
                                data: {latitude  :lats,
                                       longitudes:longs}, 
                                cache: false,

                                success: function(){
                                    alert("Saved");
                                    window.open('Save.php'); 
                                }       
                        });
                    
                    }
                });
            });
        </script>
    </head>

    <body>
        
        <div id="panel">
            <div>
              <button id="delete-button" class="btn-success btn-lg">Delete Selected Shape</button>
            </div>
        </div>

     <div id="map_canvas" style="width:1000px; height:900px;"></div>
       <!--      <div id="map_canvas" ></div>-->
        <form method="post" accept-charset="utf-8" id="map_form">
            <input type="text" name="vertices" value="" id="vertices"  />
            <input type="button" name="save" value="Save!" id="save"  />
        </form>


    </body>
</html>