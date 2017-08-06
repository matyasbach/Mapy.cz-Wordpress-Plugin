[English bellow](#mapycz-wordpress-plugin-en)

# Mapy.cz Wordpress Plugin
Zobrazení mapy mapy.cz kdekoliv na wordpress webu. Zatím umí pouze zobrazit 1 bod na mapě.

## Jak na to
1. Vytvořte mapu v administrátorské sekci - potřebuje nějaké vlastní ID a souřadnice
2. Kde je potřeba zobrazit mapu, vložte shortcode `[mcz_map id="vlastní_ID" class="vlastní_třída"]`
    - atribut *class* je nepovinný, přidá mapě zadanou třídu pro vlastní css apod.
    - mapa bude mít třídy `vlastní_třída`, `mcz-map` a `mcz-map-vlastní_ID` a id `mcz-map-vlastní_ID`

## Lepší funkce?
Rád přidám jakoukoliv funkci, stačí napsat nebo vytvořit issue/feature request (tahleta primitivní verze zatím stačila pro mé použití).

## Licence
Se samotným pluginem si dělejte, co chcete, ale pro použití na stránce se ujistěte, že splňujete [licenční podmínky Mapy.cz API](https://api.mapy.cz/)


# Mapy.cz Wordpress Plugin (en)
Displays mapy.cz maps on your website. Currently offers only basic functionality - display map with one specified point.

## How to use it
1. create map in admin menu with custom ID and coordinates
2. put shortcode `[mcz_map id="your_custom_ID" class="your_custom_class"]` where you want your map to appear
    - attribute *class* is not required, can be used for custom styling etc.
    - map will have classes `your_custom_class`, `mcz-map` and  `mcz-map-your_custom_ID` and id `mcz-map-your_custom_ID`

## Need more?
I will be happy to make more functions. Just write me or create issue/feature request. This primitive version of plugin was good enough for my use.

## License
You can do whatever you want with this plugin but for üse on your website make sure you fulfill [conditions of Mapy.cz API](https://api.mapy.cz/) (in Czech only).
