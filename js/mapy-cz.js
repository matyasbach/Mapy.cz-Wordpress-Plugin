jQuery(document).ready(function($) {
  $.post(
    mcz_map_ajax.ajaxurl,
    {
      action: "mapy-cz-get-map",
      maps: mcz_load_maps
    },
    function(response) {
      var map_id;
      Loader.async = true;
      Loader.load(null, { poi: true }, function() {
        var maps = $.parseJSON(response);

        for (map_id in maps) {
          var center = SMap.Coords.fromWGS84(
              maps[map_id].lat,
              maps[map_id].lon
            ),
            map = new SMap(JAK.gel(map_id), center, 15);

          map.addDefaultLayer(SMap.DEF_SMART_BASE).enable();
          map.addDefaultControls();
          map.addControl(new SMap.Control.Sync({ bottomSpace: 0 }));

          var layer = new SMap.Layer.Marker();
          map.addLayer(layer).enable();

          var marker = new SMap.Marker(center, "myMarker" /*, options*/);
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
      });
    }
  );
  return false;
});
