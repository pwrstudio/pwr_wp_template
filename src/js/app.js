/*jslint browser: true, devel: true, node: true, nomen: true, plusplus: true*/
/*global $, jQuery*/

(function () {

  "use strict";
  
  // Require jQuery
  global.$                = require("jquery");
    
  var shared              = require("./shared"),
      debounce            = require('debounce');
      
  require("swiper");
  require("fullpage.js");
  
  // Modernizr tests
  // require('browsernizr/test/webgl');
  // require('browsernizr/test/workers/webworkers');
  // require('browsernizr/test/webrtc/peerconnection');
  // require('browsernizr/test/storage/localstorage');
  // require('browsernizr/test/audio/webaudio');
  // require('browsernizr/test/websockets');
  // var Modernizr = require('browsernizr');
  
  $(function () {
    
    console.log("READY");
    
    //    var swiper = new Swiper('.swiper-container', {
    //      speed: 1000
    //      autoplay: 40
    //    });

    //    $('#fullpage').fullpage();  

  });

}());