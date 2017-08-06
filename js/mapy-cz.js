//var map;

jQuery(document).ready(function($) {  
  $.post( mcz_map_ajax.ajaxurl,
          {
            action: 'mapy-cz-get-map',
            maps: mcz_load_maps
          },
          function(response) {
            Loader.async = true;
            Loader.load(null, {poi:true}, function() {
              
              var maps = $.parseJSON(response);
              
              for(var map_id in maps) {
                var center = SMap.Coords.fromWGS84(parseFloat(maps[map_id].lat), parseFloat(maps[map_id].lon));
                var map = new SMap(JAK.gel(map_id), center, 15);
                map.addDefaultLayer(SMap.DEF_SMART_BASE).enable();
                map.addDefaultControls();

                map.addControl(new SMap.Control.Sync({bottomSpace:0}));

                var layer = new SMap.Layer.Marker();
                map.addLayer(layer);
                layer.enable();

                /*var card = new SMap.Card();
                card.getHeader().innerHTML = "<strong>Nadpis</strong>";
                card.getBody().innerHTML = "Ahoj, já jsem <em>obsah vizitky</em>!";

                var options = { 
                    title: "Dobré ráno"
                };*/
                var marker = new SMap.Marker(center, "myMarker"/*, options*/);
                //marker.decorate(SMap.Marker.Feature.Card, card);
                layer.addMarker(marker);

                var poiLayer = new SMap.Layer.Marker();
                map.addLayer(poiLayer).enable();
                var dataProvider = map.createDefaultDataProvider();
                dataProvider.setOwner(map);
                dataProvider.addLayer(poiLayer);
                dataProvider.setMapSet(SMap.MAPSET_BASE);
                dataProvider.enable();
                
                $("#" + map_id).data("map", map);
              }
              
              /*var center = SMap.Coords.fromWGS84(parseFloat(maps.lat), parseFloat(maps.lon));
              var map = new SMap(JAK.gel("mcz_map_" + maps.id), center, 15);
              map.addDefaultLayer(SMap.DEF_SMART_BASE).enable();
              map.addDefaultControls();

              map.addControl(new SMap.Control.Sync({bottomSpace:0}));

              var layer = new SMap.Layer.Marker();
              map.addLayer(layer);
              layer.enable();

              var card = new SMap.Card();
              card.getHeader().innerHTML = "<strong>Nadpis</strong>";
              card.getBody().innerHTML = "Ahoj, já jsem <em>obsah vizitky</em>!";

              var options = { 
                  title: "Dobré ráno"
              };
              var marker = new SMap.Marker(center, "myMarker", options);
              marker.decorate(SMap.Marker.Feature.Card, card);
              layer.addMarker(marker);

              var poiLayer = new SMap.Layer.Marker();
              map.addLayer(poiLayer).enable();
              var dataProvider = map.createDefaultDataProvider();
              dataProvider.setOwner(map);
              dataProvider.addLayer(poiLayer);
              dataProvider.setMapSet(SMap.MAPSET_BASE);
              dataProvider.enable();*/
            });
          }
        );
  return false;
});