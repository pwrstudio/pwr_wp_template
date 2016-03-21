/*jslint browser: true, devel: true, node: true, nomen: true, plusplus: true*/
/*global $, jQuery*/

"use strict";

var $ = require("jquery");

function slides(context) {

  return {
    loop: {},
    currentImage: {},
    imageContainer: context.children('.image-container'),
    setup: function setup() {

      this.currentImage = this.imageContainer.children('.shown');

    },
    next: function next() {

      $(this.currentImage).removeClass("shown");

      if (this.currentImage.is(':last-child')) {
        this.imageContainer
          .find('img')
          .first()
          .addClass("shown");
      } else {
        this.currentImage
          .next("img")
          .addClass("shown");
      }

      this.currentImage = this.imageContainer.children('.shown');

    },
    previous: function previous() {

      $(this.currentImage).removeClass("shown");

      if (this.currentImage.is(':first-child')) {
        this.imageContainer
          .find('img')
          .last()
          .addClass("shown");
      } else {
        this.currentImage
          .prev("img")
          .addClass("shown");
      }

      this.currentImage = this.imageContainer.children('.shown');

    },
    start: function start(delay) {

      var parent = this;

      this.loop = setInterval(function () {

        parent.next();

      }, delay);

    },
    stop: function stop() {

      clearInterval(this.loop);

    }
  };

}

module.exports = slides;