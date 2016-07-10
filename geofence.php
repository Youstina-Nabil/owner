<?php

session_start();
$user = 'root';
$pass = '';
$db = 'customer_side_db';
$connect = new mysqli('localhost', $user, $pass, $db) or die("Unable to connect");


if (!isset($_GET['Bus_no']) || !isset($_GET['LicensePlate']) || !isset($_GET['AccountId'])) {
    $result = "Problem loading";
    echo $result;
} else {

    $busno = $_GET['Bus_no'];
    $plate = $_GET['LicensePlate'];
    $AccId = $_GET['AccountId'];
      
    $_SESSION['Bus_no'] = $busno; // put bus no in session array
    $_SESSION['LicensePlate'] = $plate;
    $_SESSION['AccountId'] = $AccId;
    

    $latAndLong = mysqli_query($connect, " SELECT bus.CurrentLatitude,bus.CurrentLongtitude FROM bus WHERE (bus.BusNo='$busno')and(bus.LicensePlate='$plate')");
    if ($latAndLong === FALSE) {

        die('Could not connect 8: ' . mysql_error());
    }
    while ($rows = mysqli_fetch_assoc($latAndLong)) {
        $lat = $rows['CurrentLatitude'];
        $long = $rows['CurrentLongtitude'];

        echo $lat;
        echo '<br>';
        echo $long;
    }
}
//$latAndLong=
?>
<!DOCTYPE html>
<html>

    <head>
        <title>Geofence</title>
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
        <style type="text/css">
            html { height: 100% }
            body { height: 100%; margin: 0; padding: 0 }
            #map-canvas {
                height: 100% 
            }


/*            #map-canvas, html, body {
                padding: 0;
                margin: 0;
                height: 100%;
            }*/

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
<!--        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script> -->
        <script src="js/jquery-3.0.0.min.js"></script>
        <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBljsHY_7GbYRYTSfrmrl4ot2QQI2mOchE&libraries=drawing&callback=initialize"async defer>
        </script> 
        <script>

            var map; // Global declaration of the map
            //var iw = new google.maps.InfoWindow(); // Global declaration of the infowindow
            var lat_longs = new Array();
            var markers = new Array();
            var drawingManager;
            var selectedShape;
           // var pathArr;
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


                pathArr = new google.maps.MVCArray();
                //Drawing
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

                    // pathArr =event.overlay.getPath();
//                    console.log(pathArr.getAt(0).lat());

                    //console.log(pathArr.length);
                    // console.log(pathArr.getAt(0).lat());


                    //pathArr = event.overlay.getPath();
                    //console.log(pathArr.getAt(0).lat());


                });
                
                
                
                
                google.maps.event.addDomListener(document.getElementById('delete-button'), 'click', deleteSelectedShape);



            

            }
            function overlayClickListener(overlay) {
                google.maps.event.addListener(overlay, "mouseup", function (event) {
                    $('#vertices').val(overlay.getPath().getArray());  //$(selector).action()
//                    pathArr = overlay.getPath();
//                    var lat = pathArr.getAt(0).lat();
//                    console.log(lat);

                });
            }
            
            

            
            function deleteSelectedShape() {
                if (selectedShape) {
                  selectedShape.setMap(null);
                    $('#vertices').val('');                     
                }
            }
            
            


            //google.maps.event.addDomListener(window, 'load', initialize);

//            $(function(){
//                $('#save').click(function(){
//                    //iterate polygon vertices?
//                    
//                    var Result = $('#vertices').val();
//                    alert( "Handler for .click() called." );
//                    console.log("hiiiiiiiii");
//                });
//            });
           
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
              <button id="delete-button">Delete Selected Shape</button>
            </div>
        </div>

        <div id="map_canvas" style="width:500px; height:450px;"></div>
        <form method="post" accept-charset="utf-8" id="map_form">
            <input type="text" name="vertices" value="" id="vertices"  />
            <input type="button" name="save" value="Save!" id="save"  />
        </form>


    </body>
</html>