/*
  Leaflet.AwesomeMarkers, a plugin that adds colorful iconic markers for Leaflet, based on the Font Awesome icons
  (c) 2012-2013, Lennard Voogdt

  http://leafletjs.com
  https://github.com/lvoogdt
*/

/*global L*/

(function (window, document, undefined) {
    "use strict";
    /*
     * Leaflet.AwesomeMarkers assumes that you have already included the Leaflet library.
     */

    L.AwesomeMarkers = {};

    L.AwesomeMarkers.version = '2.0.1';

    L.AwesomeMarkers.Icon = L.Icon.extend({
        options: {
            iconSize: [75, 90],
            iconAnchor:   [40, 90],
            popupAnchor: [-1, -90],
            shadowAnchor: [10, 12],
            shadowSize: [36, 16],
            className: 'sebastian-marker',
            extraClasses: '',
            iconType: 'default',
            iconLabel: '0',
			iconLabelHeight: 49,
			iconLabelWidth: 63,
			iconLabelBackground: '#e5e5e5',
			iconLabelMarginLeft: 6,
			iconLabelMarginTop: 6,
			id: '',
        },

        initialize: function (options) {
            options = L.Util.setOptions(this, options);
        },

        createIcon: function () {
            var div = document.createElement('div'),
                options = this.options;

            if (options.iconLabel) {
                div.innerHTML = this._createInner();
            }

            if (options.bgPos) {
                div.style.backgroundPosition =
                    (-options.bgPos.x) + 'px ' + (-options.bgPos.y) + 'px';
            }

            this._setIconStyles(div, 'icon-' + options.iconType);
			
			var id = "";
			if(options.id !== '') {
				div.setAttribute('id', options.id);
			}
			//div.setAttribute('onmouseover', 'onmouseoverIcon(this)');
			
            return div;
        },

        _createInner: function() {
            var options = this.options;
            return "<div class='icon-label' style='height:" + options.iconLabelHeight + "px; width:" + options.iconLabelWidth + "px; background:" + options.iconLabelBackground + "; position:absolute; margin-left: " + options.iconLabelMarginLeft + "px; margin-top: " + options.iconLabelMarginTop + "px;'>" + options.iconLabel + "</div>";
        },

        _setIconStyles: function (img, name) {
            var options = this.options,
                size = L.point(options[name === 'shadow' ? 'shadowSize' : 'iconSize']),
                anchor;

            if (name === 'shadow') {
                anchor = L.point(options.shadowAnchor || options.iconAnchor);
            } else {
                anchor = L.point(options.iconAnchor);
            }

            if (!anchor && size) {
                anchor = size.divideBy(2, true);
            }

            img.className = 'sebastian-marker-' + name;

            if (anchor) {
                img.style.marginLeft = (-anchor.x) + 'px';
                img.style.marginTop  = (-anchor.y) + 'px';
            }

            if (size) {
                img.style.width  = size.x + 'px';
                img.style.height = size.y + 'px';
            }
        },

        createShadow: function () {
            var div = document.createElement('div');

            this._setIconStyles(div, 'shadow');
            return div;
      }
    });
        
    L.AwesomeMarkers.icon = function (options) {
        return new L.AwesomeMarkers.Icon(options);
    };

}(this, document));