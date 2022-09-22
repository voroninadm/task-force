// Функция ymaps.ready() будет вызвана, когда
// загрузятся все компоненты API, а также когда будет готово DOM-дерево.
const map = document.querySelector('#map');

if (map) {
    ymaps.ready(init);

    function init() {
        // Создание карты.
        const myMap = new ymaps.Map('map', {
            // Координаты центра карты.
            // Порядок по умолчанию: «широта, долгота».
            center: [map.dataset.lat, map.dataset.long],
            // Уровень масштабирования. Допустимые значения:
            // от 0 (весь мир) до 19.
            zoom: 17
        }),

        // Создаём макет содержимого.
        MyIconContentLayout = ymaps.templateLayoutFactory.createClass(
            '<div style="color: #FFFFFF; font-weight: bold;">$[properties.iconContent]</div>'
        ),

            myPlacemark = new ymaps.Placemark(myMap.getCenter(), {
                hintContent: 'Место исполнения задания',
                balloonContent: 'Место исполнения задания',
            }, {
                // Опции.
                // Необходимо указать данный тип макета.
                iconLayout: 'default#image',
                // Своё изображение иконки метки.
                iconImageHref: '../../img/location-icon.svg',
                // Размеры метки.
                iconImageSize: [30, 42],
                // Смещение левого верхнего угла иконки относительно
                // её "ножки" (точки привязки).
                iconImageOffset: [-10, -45]
            })

        myMap.geoObjects
            .add(myPlacemark)
    }
}
