/**
 * --------------------------------------------------------------------
 * jQuery Fancy File Input plugin
 * Author: Sean Curtis, scurtis@atlassian.com
 * Copyright © 2012 - 2013 Atlassian Pty Ltd. Licensed under the
 * Apache License, Version 2.0 (the "License"); you may not use this
 * file except in compliance with the License. You may obtain a copy
 * of the License at http://www.apache.org/licenses/LICENSE-2.0.
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or
 * implied. See the License for the specific language governing
 * permissions and limitations under the License.
 * --------------------------------------------------------------------
 */
;(function (factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD. Register as an anonymous module.
        define(['jquery'], factory);
    } else {
        // Browser globals
        factory(jQuery);
    }
}(function ($) {
    'use strict';

    var fakePathRegex = /^.*[\\\/]/;
    var multipleFileTextRegex = /\{0\}/gi;

    $.fn.fancyFileInput = function (options) {
        return this.each(function () {
            var ffi = new FancyFileInput(this, options);
            $(this).data('FancyFileInput', ffi);
        });
    };

    function FancyFileInput(el, options) {
        options = $.extend({}, FancyFileInput.defaults, options);
        this.el = el;
        this.$el = $(el);
        this.$label = this.createLabel(options.buttonText);
        this.$clearButton = $('<button>', {
            text: (this.$label.attr('data-ffi-clearButtonText') || options.clearButtonText),
            'class': 'ffi-clear',
            type: 'button',
            'tabindex': '-1'
        });
        this.multipleFileTextPattern = this.$label.attr('data-ffi-multipleFileTextPattern') || options.multipleFileTextPattern;
        this._eventNamespace = '.ffi';
        this.CLASSES = {
            disabled: 'is-disabled',
            focused: 'is-focused',
            active: 'is-active',
            valid: 'is-valid',
            invalid: 'is-invalid'
        };

        this[this.isDisabled() ? 'disable' : 'enable']();
    }

    FancyFileInput.defaults = {
        buttonText: 'Browse\u2026',
        clearButtonText: 'Clear',
        multipleFileTextPattern: '{0} files'
    };

    FancyFileInput.prototype.createLabel = function (buttonText) {
        var $label = this.$el.parent('.ffi[data-ffi-button-text]');
        if (!$label.length) {
            $label = this.$el.wrap($('<label>', { 'class': 'ffi', 'data-ffi-button-text': buttonText })).parent();
        }
        return $label;
    };

    FancyFileInput.prototype.isDisabled = function () {
        return this.$el.is(':disabled');
    };

    FancyFileInput.prototype.formatMultipleFileText = function (numFiles) {
        return this.multipleFileTextPattern.replace(multipleFileTextRegex, numFiles);
    };

    FancyFileInput.prototype.bindEvents = function () {
        this.$el
            .on('invalid'   + this._eventNamespace, $.proxy(this.checkValidity, this))
            .on('change'    + this._eventNamespace, $.proxy(this.change, this))
            .on('keydown'   + this._eventNamespace, $.proxy(this.keydown, this))
            .on('mousedown' + this._eventNamespace, $.proxy(this.mousedown, this))
            .on('mouseup'   + this._eventNamespace, $.proxy(this.mouseup, this))
            .on('focus'     + this._eventNamespace, $.proxy(this.focus, this))
            .on('blur'      + this._eventNamespace, $.proxy(this.blur, this));
        this.$clearButton.on('click' + this._eventNamespace, $.proxy(this.clear, this));
    };

    FancyFileInput.prototype.unbindEvents = function () {
        this.$el.off(this._eventNamespace);
        this.$clearButton.off(this._eventNamespace);
    };

    FancyFileInput.prototype.fireEvent = function (event) {
        this.$el.trigger(event + this._eventNamespace);
    };

    FancyFileInput.prototype.enable = function () {
        this.bindEvents();
        this.$el.prop('disabled', false);
        this.$label.removeClass(this.CLASSES.disabled);
    };

    FancyFileInput.prototype.disable = function () {
        this.unbindEvents();
        this.$el.prop('disabled', true);
        this.$label.addClass(this.CLASSES.disabled);
    };

    FancyFileInput.prototype.clear = function () {
        this.el.value = '';
        this.cloneAndReplaceField();
        this.change();
        return false;
    };

    FancyFileInput.prototype.cloneAndReplaceField = function () {
        var $clone = this.$el.clone();
        this.$el.replaceWith($clone);
        this.unbindEvents();
        this.$el = $clone;
        this.el = $clone[0];
        this.bindEvents();
    };

    FancyFileInput.prototype.focus = function () {
        this.$label.addClass(this.CLASSES.focused);
    };

    FancyFileInput.prototype.blur = function () {
        this.$label.removeClass(this.CLASSES.focused);
    };

    FancyFileInput.prototype.mousedown = function () {
        this.$label.addClass(this.CLASSES.active);
    };

    FancyFileInput.prototype.mouseup = function () {
        this.$label.removeClass(this.CLASSES.active);
    };

    FancyFileInput.prototype.keydown = function (e) {
        var keyCode = e.which;
        var BACKSPACE = 8;
        var DELETE = 46;

        if (keyCode === BACKSPACE || keyCode === DELETE) {
            this.clear();
            e.preventDefault();
        }
    };

    FancyFileInput.prototype.checkValidity = function () {
        if (!this.el.required) {
            return;
        }
        var isInvalid = this.$el.is(':invalid');

        this.$label.toggleClass(this.CLASSES.invalid, isInvalid).toggleClass(this.CLASSES.valid, !isInvalid);
    };

    FancyFileInput.prototype.change = function () {
        var files;
        var val = '';

        this.checkValidity();

        // multiple file selection
        if (this.el.multiple && this.el.files.length > 1) {
            files = this.formatMultipleFileText(this.el.files.length); // '5 files'
        } else {
            files = this.el.value; // 'README.txt'
        }

        if (files.length) {
            val = files.replace(fakePathRegex, ''); // Strips off the C:\fakepath nonsense
            this.$clearButton.appendTo(this.$label);
        } else {
            this.$clearButton.detach();
        }

        this.$el.focus();
        this.setFieldText(val);
        this.fireEvent('value-changed');
    };

    FancyFileInput.prototype.setFieldText = function (text) {
        var dataAttribute = 'data-ffi-value';
        if (text.length) {
            this.$label.attr(dataAttribute, text);
            this.fireEvent('value-added');
        } else {
            this.$label.removeAttr(dataAttribute);
            this.fireEvent('value-cleared');
        }
    };

    return FancyFileInput;
}));