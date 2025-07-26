BX.saleOrderAjax = { // bad solution, actually, a singleton at the page

  BXCallAllowed: false,

  options: {},
  indexCache: {},
  controls: {},

  modes: {},
  properties: {},

  // called once, on component load
  init: function (options) {
    var ctx = this;
    this.options = options;

    window.submitFormProxy = BX.proxy(function () {
      ctx.submitFormProxy.apply(ctx, arguments);
    }, this);

    BX(function () {
      ctx.initDeferredControl();
    });
    BX(function () {
      ctx.BXCallAllowed = true; // unlock form refresher
    });

    this.controls.scope = BX('bx-soa-order');

    // user presses "add location" when he cannot find location in popup mode
    BX.bindDelegate(this.controls.scope, 'click', {className: '-bx-popup-set-mode-add-loc'}, function () {

      var input = BX.create('input', {
        attrs: {
          type: 'hidden',
          name: 'PERMANENT_MODE_STEPS',
          value: '1'
        }
      });

      BX.prepend(input, BX('bx-soa-order'));

      ctx.BXCallAllowed = false;
      BX.Sale.OrderAjaxComponent.sendRequest();
    });
  },

  cleanUp: function () {

    for (var k in this.properties) {
      if (this.properties.hasOwnProperty(k)) {
        if (typeof this.properties[k].input != 'undefined') {
          BX.unbindAll(this.properties[k].input);
          this.properties[k].input = null;
        }

        if (typeof this.properties[k].control != 'undefined')
          BX.unbindAll(this.properties[k].control);
      }
    }

    this.properties = {};
  },

  addPropertyDesc: function (desc) {
    this.properties[desc.id] = desc.attributes;
    this.properties[desc.id].id = desc.id;
  },

  // called each time form refreshes
  initDeferredControl: function () {
    var ctx = this,
      k,
      row,
      input,
      locPropId,
      m,
      control,
      code,
      townInputFlag,
      adapter;

    // first, init all controls
    if (typeof window.BX.locationsDeferred != 'undefined') {

      this.BXCallAllowed = false;

      for (k in window.BX.locationsDeferred) {

        window.BX.locationsDeferred[k].call(this);
        window.BX.locationsDeferred[k] = null;
        delete (window.BX.locationsDeferred[k]);

        this.properties[k].control = window.BX.locationSelectors[k];
        delete (window.BX.locationSelectors[k]);
      }
    }

    for (k in this.properties) {

      // zip input handling
      if (this.properties[k].isZip) {
        row = this.controls.scope.querySelector('[data-property-id-row="' + k + '"]');
        if (BX.type.isElementNode(row)) {

          input = row.querySelector('input[type="text"]');
          if (BX.type.isElementNode(input)) {
            this.properties[k].input = input;

            // set value for the first "location" property met
            locPropId = false;
            for (m in this.properties) {
              if (this.properties[m].type == 'LOCATION') {
                locPropId = m;
                break;
              }
            }

            if (locPropId !== false) {
              BX.bindDebouncedChange(input, function (value) {

                var zipChangedNode = BX('ZIP_PROPERTY_CHANGED');
                zipChangedNode && (zipChangedNode.value = 'Y');

                input = null;
                row = null;

                if (BX.type.isNotEmptyString(value) && /^\s*\d+\s*$/.test(value) && value.length > 3) {

                  ctx.getLocationsByZip(value, function (locationsData) {
                    ctx.properties[locPropId].control.setValueByLocationIds(locationsData);
                  }, function () {
                    try {
                      // ctx.properties[locPropId].control.clearSelected();
                    } catch (e) {}
                  });
                }
              });
            }
          }
        }
      }

      // location handling, town property, etc...
      if (this.properties[k].type == 'LOCATION') {

        if (typeof this.properties[k].control != 'undefined') {

          control = this.properties[k].control; // reference to sale.location.selector.*
          code = control.getSysCode();

          // we have town property (alternative location)
          if (typeof this.properties[k].altLocationPropId != 'undefined') {
            if (code == 'sls') // for sale.location.selector.search
            {
              // replace default boring "nothing found" label for popup with "-bx-popup-set-mode-add-loc" inside
              control.replaceTemplate('nothing-found', this.options.messages.notFoundPrompt);
            }

            if (code == 'slst')  // for sale.location.selector.steps
            {
              (function (k, control) {

                // control can have "select other location" option
                control.setOption('pseudoValues', ['other']);

                // insert "other location" option to popup
                control.bindEvent('control-before-display-page', function (adapter) {

                  control = null;

                  var parentValue = adapter.getParentValue();

                  // you can choose "other" location only if parentNode is not root and is selectable
                  if (parentValue == this.getOption('rootNodeValue') || !this.checkCanSelectItem(parentValue))
                    return;

                  var controlInApater = adapter.getControl();

                  if (typeof controlInApater.vars.cache.nodes['other'] == 'undefined') {
                    controlInApater.fillCache([{
                      CODE: 'other',
                      DISPLAY: ctx.options.messages.otherLocation,
                      IS_PARENT: false,
                      VALUE: 'other'
                    }], {
                      modifyOrigin: true,
                      modifyOriginPosition: 'prepend'
                    });
                  }
                });

              })(k, control);
            }
          }
        }
      }
    }
  },

  getLocationsByZip: function (value, successCallback, notFoundCallback) {
    if (typeof this.indexCache[value] != 'undefined') {
      successCallback.apply(this, [this.indexCache[value]]);
      return;
    }

    var ctx = this;

    BX.ajax({
      url: this.options.source,
      method: 'post',
      dataType: 'json',
      async: true,
      processData: true,
      emulateOnload: true,
      start: true,
      data: {'ACT': 'GET_LOCS_BY_ZIP', 'ZIP': value},
      //cache: true,
      onsuccess: function (result) {
        if (result.result) {
          ctx.indexCache[value] = result.data;
          successCallback.apply(ctx, [result.data]);
        } else {
          notFoundCallback.call(ctx);
        }
      },
      onfailure: function (type, e) {
        // on error do nothing
      }
    });
  }
};
