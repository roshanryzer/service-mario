/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/admin/js/core/app.js":
/*!****************************************!*\
  !*** ./resources/admin/js/core/app.js ***!
  \****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

(function (window, document, $) {
  "use strict";

  var $html = $("html");
  var $body = $("body");
  var $danger = "#ea5455";
  var $primary = "#7367f0";
  var $textcolor = "#4e5154";
  $(window).on("load", function () {
    var rtl;
    var compactMenu = false; // Set it to true, if you want default menu to be compact

    if ($body.hasClass("menu-collapsed")) {
      compactMenu = true;
    }

    if ($("html").data("textdirection") == "rtl") {
      rtl = true;
    }

    setTimeout(function () {
      $html.removeClass("loading").addClass("loaded");
    }, 1200);
    $.app.menu.init(compactMenu); // Navigation configurations

    var config = {
      speed: 300 // set speed to expand / collpase menu

    };

    if ($.app.nav.initialized === false) {
      $.app.nav.init(config);
    }

    Unison.on("change", function (bp) {
      $.app.menu.change();
    }); // Tooltip Initialization

    $('[data-toggle="tooltip"]').tooltip({
      container: "body"
    }); // Top Navbars - Hide on Scroll

    if ($(".navbar-hide-on-scroll").length > 0) {
      $(".navbar-hide-on-scroll.fixed-top").headroom({
        offset: 205,
        tolerance: 5,
        classes: {
          // when element is initialised
          initial: "headroom",
          // when scrolling up
          pinned: "headroom--pinned-top",
          // when scrolling down
          unpinned: "headroom--unpinned-top"
        }
      }); // Bottom Navbars - Hide on Scroll

      $(".navbar-hide-on-scroll.fixed-bottom").headroom({
        offset: 205,
        tolerance: 5,
        classes: {
          // when element is initialised
          initial: "headroom",
          // when scrolling up
          pinned: "headroom--pinned-bottom",
          // when scrolling down
          unpinned: "headroom--unpinned-bottom"
        }
      });
    } // Collapsible Card


    $('a[data-action="collapse"]').on("click", function (e) {
      e.preventDefault();
      $(this).closest(".card").children(".card-content").collapse("toggle"); // Adding bottom padding on card collapse

      $(this).closest(".card").children(".card-header").css("padding-bottom", "1.5rem");
      $(this).closest(".card").find('[data-action="collapse"]').toggleClass("rotate");
    }); // Toggle fullscreen

    $('a[data-action="expand"]').on("click", function (e) {
      e.preventDefault();
      $(this).closest(".card").find('[data-action="expand"] i').toggleClass("icon-maximize icon-minimize");
      $(this).closest(".card").toggleClass("card-fullscreen");
    }); //  Notifications & messages scrollable

    $(".scrollable-container").each(function () {
      var scrollable_container = new PerfectScrollbar($(this)[0], {
        wheelPropagation: false
      });
    }); // Reload Card

    $('a[data-action="reload"]').on("click", function () {
      var block_ele = $(this).closest(".card").find(".card-content");
      var reloadActionOverlay;

      if ($body.hasClass("dark-layout")) {
        var reloadActionOverlay = "#10163a";
      } else {
        var reloadActionOverlay = "#fff";
      } // Block Element


      block_ele.block({
        message: '<div class="feather icon-refresh-cw icon-spin font-medium-2 text-primary"></div>',
        timeout: 2000,
        //unblock after 2 seconds
        overlayCSS: {
          backgroundColor: reloadActionOverlay,
          cursor: "wait"
        },
        css: {
          border: 0,
          padding: 0,
          backgroundColor: "none"
        }
      });
    }); // Close Card

    $('a[data-action="close"]').on("click", function () {
      $(this).closest(".card").removeClass().slideUp("fast");
    }); // Match the height of each card in a row

    setTimeout(function () {
      $(".row.match-height").each(function () {
        $(this).find(".card").not(".card .card").matchHeight(); // Not .card .card prevents collapsible cards from taking height
      });
    }, 500);
    $('.card .heading-elements a[data-action="collapse"]').on("click", function () {
      var $this = $(this),
          card = $this.closest(".card");
      var cardHeight;

      if (parseInt(card[0].style.height, 10) > 0) {
        cardHeight = card.css("height");
        card.css("height", "").attr("data-height", cardHeight);
      } else {
        if (card.data("height")) {
          cardHeight = card.data("height");
          card.css("height", cardHeight).attr("data-height", "");
        }
      }
    }); // Add sidebar group active class to active menu

    $(".main-menu-content").find("li.active").parents("li").addClass("sidebar-group-active"); // Add open class to parent list item if subitem is active except compact menu

    var menuType = $body.data("menu");

    if (menuType != "horizontal-menu" && compactMenu === false) {
      $(".main-menu-content").find("li.active").parents("li").addClass("open");
    }

    if (menuType == "horizontal-menu") {
      $(".main-menu-content").find("li.active").parents("li:not(.nav-item)").addClass("open");
      $(".main-menu-content").find('li.active').closest('li.nav-item').addClass('sidebar-group-active open'); // $(".main-menu-content")
      //   .find("li.active")
      //   .parents("li")
      //   .addClass("active");
    } //card heading actions buttons small screen support


    $(".heading-elements-toggle").on("click", function () {
      $(this).next(".heading-elements").toggleClass("visible");
    }); //  Dynamic height for the chartjs div for the chart animations to work

    var chartjsDiv = $(".chartjs"),
        canvasHeight = chartjsDiv.children("canvas").attr("height"),
        mainMenu = $(".main-menu");
    chartjsDiv.css("height", canvasHeight);

    if ($body.hasClass("boxed-layout")) {
      if ($body.hasClass("vertical-overlay-menu")) {
        var menuWidth = mainMenu.width();
        var contentPosition = $(".app-content").position().left;
        var menuPositionAdjust = contentPosition - menuWidth;

        if ($body.hasClass("menu-flipped")) {
          mainMenu.css("right", menuPositionAdjust + "px");
        } else {
          mainMenu.css("left", menuPositionAdjust + "px");
        }
      }
    } //Custom File Input


    $(".custom-file input").change(function (e) {
      $(this).next(".custom-file-label").html(e.target.files[0].name);
    });
    /* Text Area Counter Set Start */

    $(".char-textarea").on("keyup", function (event) {
      checkTextAreaMaxLength(this, event); // to later change text color in dark layout

      $(this).addClass("active");
    });
    /*
    Checks the MaxLength of the Textarea
    -----------------------------------------------------
    @prerequisite:  textBox = textarea dom element
            e = textarea event
                    length = Max length of characters
    */

    function checkTextAreaMaxLength(textBox, e) {
      var maxLength = parseInt($(textBox).data("length")),
          counterValue = $(".counter-value"),
          charTextarea = $(".char-textarea");

      if (!checkSpecialKeys(e)) {
        if (textBox.value.length < maxLength - 1) textBox.value = textBox.value.substring(0, maxLength);
      }

      $(".char-count").html(textBox.value.length);

      if (textBox.value.length > maxLength) {
        counterValue.css("background-color", $danger);
        charTextarea.css("color", $danger); // to change text color after limit is maxedout out

        charTextarea.addClass("max-limit");
      } else {
        counterValue.css("background-color", $primary);
        charTextarea.css("color", $textcolor);
        charTextarea.removeClass("max-limit");
      }

      return true;
    }
    /*
    Checks if the keyCode pressed is inside special chars
    -------------------------------------------------------
    @prerequisite:  e = e.keyCode object for the key pressed
    */


    function checkSpecialKeys(e) {
      if (e.keyCode != 8 && e.keyCode != 46 && e.keyCode != 37 && e.keyCode != 38 && e.keyCode != 39 && e.keyCode != 40) return false;else return true;
    }

    $(".content-overlay").on("click", function () {
      $(".search-list").removeClass("show");
      $(".app-content").removeClass("show-overlay");
      $(".bookmark-wrapper .bookmark-input").removeClass("show");
    }); // To show shadow in main menu when menu scrolls

    var container = document.getElementsByClassName("main-menu-content");

    if (container.length > 0) {
      container[0].addEventListener("ps-scroll-y", function () {
        if ($(this).find(".ps__thumb-y").position().top > 0) {
          $(".shadow-bottom").css("display", "block");
        } else {
          $(".shadow-bottom").css("display", "none");
        }
      });
    }
  }); // Hide overlay menu on content overlay click on small screens

  $(document).on("click", ".sidenav-overlay", function (e) {
    // Hide menu
    $.app.menu.hide();
    return false;
  }); // Execute below code only if we find hammer js for touch swipe feature on small screen

  if (typeof Hammer !== "undefined") {
    // Swipe menu gesture
    var swipeInElement = document.querySelector(".drag-target");

    if ($(swipeInElement).length > 0) {
      var swipeInMenu = new Hammer(swipeInElement);
      swipeInMenu.on("panright", function (ev) {
        if ($body.hasClass("vertical-overlay-menu")) {
          $.app.menu.open();
          return false;
        }
      });
    } // menu swipe out gesture


    setTimeout(function () {
      var swipeOutElement = document.querySelector(".main-menu");
      var swipeOutMenu;

      if ($(swipeOutElement).length > 0) {
        swipeOutMenu = new Hammer(swipeOutElement);
        swipeOutMenu.get("pan").set({
          direction: Hammer.DIRECTION_ALL,
          threshold: 250
        });
        swipeOutMenu.on("panleft", function (ev) {
          if ($body.hasClass("vertical-overlay-menu")) {
            $.app.menu.hide();
            return false;
          }
        });
      }
    }, 300); // menu overlay swipe out gestrue

    var swipeOutOverlayElement = document.querySelector(".sidenav-overlay");

    if ($(swipeOutOverlayElement).length > 0) {
      var swipeOutOverlayMenu = new Hammer(swipeOutOverlayElement);
      swipeOutOverlayMenu.on("panleft", function (ev) {
        if ($body.hasClass("vertical-overlay-menu")) {
          $.app.menu.hide();
          return false;
        }
      });
    }
  }

  $(document).on("click", ".menu-toggle, .modern-nav-toggle", function (e) {
    e.preventDefault(); // Toggle menu

    $.app.menu.toggle();
    setTimeout(function () {
      $(window).trigger("resize");
    }, 200);

    if ($("#collapse-sidebar-switch").length > 0) {
      setTimeout(function () {
        if ($body.hasClass("menu-expanded") || $body.hasClass("menu-open")) {
          $("#collapse-sidebar-switch").prop("checked", false);
        } else {
          $("#collapse-sidebar-switch").prop("checked", true);
        }
      }, 50);
    } // Hides dropdown on click of menu toggle
    // $('[data-toggle="dropdown"]').dropdown('hide');
    // Hides collapse dropdown on click of menu toggle


    if ($(".vertical-overlay-menu .navbar-with-menu .navbar-container .navbar-collapse").hasClass("show")) {
      $(".vertical-overlay-menu .navbar-with-menu .navbar-container .navbar-collapse").removeClass("show");
    }

    return false;
  });
  $(".navigation").find("li").has("ul").addClass("has-sub");
  $(".carousel").carousel({
    interval: 2000
  }); // Page full screen

  $(".nav-link-expand").on("click", function (e) {
    if (typeof screenfull != "undefined") {
      if (screenfull.isEnabled) {
        screenfull.toggle();
      }
    }
  });

  if (typeof screenfull != "undefined") {
    if (screenfull.isEnabled) {
      $(document).on(screenfull.raw.fullscreenchange, function () {
        if (screenfull.isFullscreen) {
          $(".nav-link-expand").find("i").toggleClass("icon-minimize icon-maximize");
          $("html").addClass("full-screen");
        } else {
          $(".nav-link-expand").find("i").toggleClass("icon-maximize icon-minimize");
          $("html").removeClass("full-screen");
        }
      });
    }
  }

  $(document).ready(function () {
    /**********************************
     *   Form Wizard Step Icon
     **********************************/
    $(".step-icon").each(function () {
      var $this = $(this);

      if ($this.siblings("span.step").length > 0) {
        $this.siblings("span.step").empty();
        $(this).appendTo($(this).siblings("span.step"));
      }
    });
  }); // Update manual scroller when window is resized

  $(window).resize(function () {
    $.app.menu.manualScroller.updateHeight();
  });
  $("#sidebar-page-navigation").on("click", "a.nav-link", function (e) {
    e.preventDefault();
    e.stopPropagation();
    var $this = $(this),
        href = $this.attr("href");
    var offset = $(href).offset();
    var scrollto = offset.top - 80; // minus fixed header height

    $("html, body").animate({
      scrollTop: scrollto
    }, 0);
    setTimeout(function () {
      $this.parent(".nav-item").siblings(".nav-item").children(".nav-link").removeClass("active");
      $this.addClass("active");
    }, 100);
  }); // change language according to data-language of dropdown item

  $(".dropdown-language .dropdown-item").on("click", function () {
    var $this = $(this);
    $this.siblings(".selected").removeClass("selected");
    $this.addClass("selected");
    var selectedLang = $this.text();
    var selectedFlag = $this.find(".flag-icon").attr("class");
    $("#dropdown-flag .selected-language").text(selectedLang);
    $("#dropdown-flag .flag-icon").removeClass().addClass(selectedFlag); // var currentLanguage = $this.data("language");
    // i18next.changeLanguage(currentLanguage, function (err, t) {
    //   $(".main-menu, .horizontal-menu-wrapper").localize();
    // });
  }); // set language flag icon as

  var language = $('html')[0].lang;

  if (language !== null) {
    // get the selected flag class
    var selectedFlag = $(".dropdown-language .dropdown-item[data-language=" + language + "]").find(".flag-icon").attr("class");
    var selectedLang = $(".dropdown-language .dropdown-item[data-language=" + language + "]").text(); // set the class in button

    $("#dropdown-flag .selected-language").text(selectedLang);
    $("#dropdown-flag .flag-icon").removeClass().addClass(selectedFlag);
  }
  /********************* Bookmark & Search ***********************/
  // This variable is used for mouseenter and mouseleave events of search list


  var $filename = $(".search-input input").data("search"),
      bookmarkWrapper = $(".bookmark-wrapper"),
      bookmarkStar = $(".bookmark-wrapper .bookmark-star"),
      bookmarkInput = $(".bookmark-wrapper .bookmark-input"),
      navLinkSearch = $(".nav-link-search"),
      searchInput = $(".search-input"),
      searchInputInputfield = $(".search-input input"),
      searchList = $(".search-input .search-list"),
      appContent = $(".app-content"),
      bookmarkSearchList = $(".bookmark-input .search-list"); // Bookmark icon click

  bookmarkStar.on("click", function (e) {
    e.stopPropagation();
    bookmarkInput.toggleClass("show");
    bookmarkInput.find("input").val("");
    bookmarkInput.find("input").blur();
    bookmarkInput.find("input").focus();
    bookmarkWrapper.find(".search-list").addClass("show");
    var arrList = $("ul.nav.navbar-nav.bookmark-icons li"),
        $arrList = "",
        $activeItemClass = "";
    $("ul.search-list li").remove();

    for (var i = 0; i < arrList.length; i++) {
      if (i === 0) {
        $activeItemClass = "current_item";
      } else {
        $activeItemClass = "";
      }

      $arrList += '<li class="auto-suggestion d-flex align-items-center justify-content-between cursor-pointer ' + $activeItemClass + '">' + '<a class="d-flex align-items-center justify-content-between w-100" href=' + arrList[i].firstChild.href + ">" + '<div class="d-flex justify-content-start align-items-center">' + '<span class="mr-75 ' + arrList[i].firstChild.firstChild.className + '"  data-icon="' + arrList[i].firstChild.firstChild.className + '"></span>' + "<span>" + arrList[i].firstChild.dataset.originalTitle + "</span>" + "</div>" + '<span class="float-right bookmark-icon feather icon-star warning"></span>' + "</a>" + "</li>";
    }

    $("ul.search-list").append($arrList);
  }); // Navigation Search area Open

  navLinkSearch.on("click", function () {
    var $this = $(this);
    var searchInput = $(this).parent(".nav-search").find(".search-input");
    searchInput.addClass("open");
    searchInputInputfield.focus();
    searchList.find("li").remove();
    bookmarkInput.removeClass("show");
  }); // Navigation Search area Close

  $(".search-input-close i").on("click", function () {
    var $this = $(this),
        searchInput = $(this).closest(".search-input");

    if (searchInput.hasClass("open")) {
      searchInput.removeClass("open");
      searchInputInputfield.val("");
      searchInputInputfield.blur();
      searchList.removeClass("show");
      appContent.removeClass("show-overlay");
    }
  }); // Filter

  if ($('.search-list-main').length) {
    var searchListMain = new PerfectScrollbar(".search-list-main", {
      wheelPropagation: false
    });
  }

  if ($('.search-list-bookmark').length) {
    var searchListBookmark = new PerfectScrollbar(".search-list-bookmark", {
      wheelPropagation: false
    });
  } // update Perfect Scrollbar on hover


  $(".search-list-main").mouseenter(function () {
    searchListMain.update();
  });
  searchInputInputfield.on("keyup", function (e) {
    $(this).closest(".search-list").addClass("show");

    if (e.keyCode !== 38 && e.keyCode !== 40 && e.keyCode !== 13) {
      if (e.keyCode == 27) {
        appContent.removeClass("show-overlay");
        bookmarkInput.find("input").val("");
        bookmarkInput.find("input").blur();
        searchInputInputfield.val("");
        searchInputInputfield.blur();
        searchInput.removeClass("open");

        if (searchInput.hasClass("show")) {
          $(this).removeClass("show");
          searchInput.removeClass("show");
        }
      } // Define variables


      var value = $(this).val().toLowerCase(),
          //get values of input on keyup
      activeClass = "",
          bookmark = false,
          liList = $("ul.search-list li"); // get all the list items of the search

      liList.remove(); // To check if current is bookmark input

      if ($(this).parent().hasClass("bookmark-input")) {
        bookmark = true;
      } // If input value is blank


      if (value != "") {
        appContent.addClass("show-overlay"); // condition for bookmark and search input click

        if (bookmarkInput.focus()) {
          bookmarkSearchList.addClass("show");
        } else {
          searchList.addClass("show");
          bookmarkSearchList.removeClass("show");
        }

        if (bookmark === false) {
          searchList.addClass("show");
          bookmarkSearchList.removeClass("show");
        }

        var $startList = "",
            $otherList = "",
            $htmlList = "",
            $bookmarkhtmlList = "",
            $pageList = '<li class=" d-flex align-items-center">' + '<a href="#" class="pb-25">' + '<h6 class="text-primary mb-0">Pages</h6>' + '</a>' + '</li>',
            $activeItemClass = "",
            $bookmarkIcon = "",
            $defaultList = "",
            a = 0; // getting json data from file for search results

        $.getJSON("data/" + $filename + ".json", function (data) {
          for (var i = 0; i < data.listItems.length; i++) {
            // if current is bookmark then give class to star icon
            if (bookmark === true) {
              activeClass = ""; // resetting active bookmark class

              var arrList = $("ul.nav.navbar-nav.bookmark-icons li"),
                  $arrList = ""; // Loop to check if current seach value match with the bookmarks already there in navbar

              for (var j = 0; j < arrList.length; j++) {
                if (data.listItems[i].name === arrList[j].firstChild.dataset.originalTitle) {
                  activeClass = " warning";
                  break;
                } else {
                  activeClass = "";
                }
              }

              $bookmarkIcon = '<span class="float-right bookmark-icon feather icon-star' + activeClass + '"></span>';
            } // Search list item start with entered letters and create list


            if (data.listItems[i].name.toLowerCase().indexOf(value) == 0 && a < 5) {
              if (a === 0) {
                $activeItemClass = "current_item";
              } else {
                $activeItemClass = "";
              }

              $startList += '<li class="auto-suggestion d-flex align-items-center justify-content-between cursor-pointer ' + $activeItemClass + '">' + '<a class="d-flex align-items-center justify-content-between w-100" href=' + data.listItems[i].url + ">" + '<div class="d-flex justify-content-start align-items-center">' + '<span class="mr-75 ' + data.listItems[i].icon + '" data-icon="' + data.listItems[i].icon + '"></span>' + "<span>" + data.listItems[i].name + "</span>" + "</div>" + $bookmarkIcon + "</a>" + "</li>";
              a++;
            }
          }

          for (var i = 0; i < data.listItems.length; i++) {
            if (bookmark === true) {
              activeClass = ""; // resetting active bookmark class

              var arrList = $("ul.nav.navbar-nav.bookmark-icons li"),
                  $arrList = ""; // Loop to check if current seach value match with the bookmarks already there in navbar

              for (var j = 0; j < arrList.length; j++) {
                if (data.listItems[i].name === arrList[j].firstChild.dataset.originalTitle) {
                  activeClass = " warning";
                } else {
                  activeClass = "";
                }
              }

              $bookmarkIcon = '<span class="float-right bookmark-icon feather icon-star' + activeClass + '"></span>';
            } // Search list item not start with letters and create list


            if (!(data.listItems[i].name.toLowerCase().indexOf(value) == 0) && data.listItems[i].name.toLowerCase().indexOf(value) > -1 && a < 5) {
              if (a === 0) {
                $activeItemClass = "current_item";
              } else {
                $activeItemClass = "";
              }

              $otherList += '<li class="auto-suggestion d-flex align-items-center justify-content-between cursor-pointer ' + $activeItemClass + '">' + '<a class="d-flex align-items-center justify-content-between w-100" href=' + data.listItems[i].url + ">" + '<div class="d-flex justify-content-start align-items-center">' + '<span class="mr-75 ' + data.listItems[i].icon + '" data-icon="' + data.listItems[i].icon + '"></span>' + "<span>" + data.listItems[i].name + "</span>" + "</div>" + $bookmarkIcon + "</a>" + "</li>";
              a++;
            }
          }

          $defaultList = $(".main-search-list-defaultlist").html();

          if ($startList == "" && $otherList == "") {
            $otherList = $(".main-search-list-defaultlist-other-list").html();
          } // concatinating startlist, otherlist, defalutlist with pagelist


          $htmlList = $pageList.concat($startList, $otherList, $defaultList);
          $("ul.search-list").html($htmlList); // concatinating otherlist with startlist

          $bookmarkhtmlList = $startList.concat($otherList);
          $("ul.search-list-bookmark").html($bookmarkhtmlList);
        });
      } else {
        if (bookmark === true) {
          var arrList = $("ul.nav.navbar-nav.bookmark-iconss li"),
              $arrList = "";

          for (var i = 0; i < arrList.length; i++) {
            if (i === 0) {
              $activeItemClass = "current_item";
            } else {
              $activeItemClass = "";
            }

            $arrList += '<li class="auto-suggestion d-flex align-items-center justify-content-between cursor-pointer">' + '<a class="d-flex align-items-center justify-content-between w-100" href=' + arrList[i].firstChild.href + ">" + '<div class="d-flex justify-content-start align-items-center">' + '<span class="mr-75 ' + arrList[i].firstChild.firstChild.className + '"  data-icon="' + arrList[i].firstChild.firstChild.className + '"></span>' + "<span>" + arrList[i].firstChild.dataset.originalTitle + "</span>" + "</div>" + '<span class="float-right bookmark-icon feather icon-star warning"></span>' + "</a>" + "</li>";
          }

          $("ul.search-list").append($arrList);
        } else {
          // if search input blank, hide overlay
          if (appContent.hasClass("show-overlay")) {
            appContent.removeClass("show-overlay");
          } // If filter box is empty


          if (searchList.hasClass("show")) {
            searchList.removeClass("show");
          }
        }
      }
    }
  }); // Add class on hover of the list

  $(document).on("mouseenter", ".search-list li", function (e) {
    $(this).siblings().removeClass("current_item");
    $(this).addClass("current_item");
  });
  $(document).on("click", ".search-list li", function (e) {
    e.stopPropagation();
  });
  $("html").on("click", function ($this) {
    if (!$($this.target).hasClass("bookmark-icon")) {
      if (bookmarkSearchList.hasClass("show")) {
        bookmarkSearchList.removeClass("show");
      }

      if (bookmarkInput.hasClass("show")) {
        bookmarkInput.removeClass("show");
      }
    }
  }); // Prevent closing bookmark dropdown on input textbox click

  $(document).on("click", ".bookmark-input input", function (e) {
    bookmarkInput.addClass("show");
    bookmarkSearchList.addClass("show");
  }); // Favorite star click

  $(document).on("click", ".bookmark-input .search-list .bookmark-icon", function (e) {
    e.stopPropagation();

    if ($(this).hasClass("warning")) {
      $(this).removeClass("warning");
      var arrList = $("ul.nav.navbar-nav.bookmark-icons li");

      for (var i = 0; i < arrList.length; i++) {
        if (arrList[i].firstChild.dataset.originalTitle == $(this).parent()[0].innerText) {
          arrList[i].remove();
        }
      }

      e.preventDefault();
    } else {
      var arrList = $("ul.nav.navbar-nav.bookmark-icons li");
      $(this).addClass("warning");
      e.preventDefault();
      var $url = $(this).parent()[0].href,
          $name = $(this).parent()[0].innerText,
          $icon = $(this).parent()[0].firstChild.firstChild.dataset.icon,
          $listItem = "",
          $listItemDropdown = "";
      $listItem = '<li class="nav-item d-none d-lg-block">' + '<a class="nav-link" href="' + $url + '" data-toggle="tooltip" data-placement="top" title="" data-original-title="' + $name + '">' + '<i class="ficon ' + $icon + '"></i>' + "</a>" + "</li>";
      $("ul.nav.bookmark-icons").append($listItem);
      $('[data-toggle="tooltip"]').tooltip();
    }
  }); // If we use up key(38) Down key (40) or Enter key(13)

  $(window).on("keydown", function (e) {
    var $current = $(".search-list li.current_item"),
        $next,
        $prev;

    if (e.keyCode === 40) {
      $next = $current.next();
      $current.removeClass("current_item");
      $current = $next.addClass("current_item");
    } else if (e.keyCode === 38) {
      $prev = $current.prev();
      $current.removeClass("current_item");
      $current = $prev.addClass("current_item");
    }

    if (e.keyCode === 13 && $(".search-list li.current_item").length > 0) {
      var selected_item = $(".search-list li.current_item a");
      window.location = selected_item.attr("href");
      $(selected_item).trigger("click");
    }
  });
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  }); // Waves Effect

  Waves.init();
  Waves.attach(".btn", ["waves-light"]);
})(window, document, jQuery);

var Roshan = /*#__PURE__*/function () {
  function Roshan() {
    _classCallCheck(this, Roshan);

    this.countCharacter();
    Roshan.initResources();
    Roshan.initMediaIntegrate();
  }

  _createClass(Roshan, [{
    key: "countCharacter",
    value: function countCharacter() {
      $.fn.charCounter = function (max, settings) {
        max = max || 100;
        settings = $.extend({
          container: '<span></span>',
          classname: 'charcounter',
          // format: '(%1 ' + RoshanVariables.languages.system.character_remain + ')',
          format: '(%1 character(s) remain)',
          pulse: true,
          delay: 0
        }, settings);
        var p, timeout;

        var count = function count(el, container) {
          el = $(el);

          if (el.val().length > max) {
            el.val(el.val().substring(0, max));

            if (settings.pulse && !p) {
              pulse(container, true);
            }
          }

          if (settings.delay > 0) {
            if (timeout) {
              window.clearTimeout(timeout);
            }

            timeout = window.setTimeout(function () {
              container.html(settings.format.replace(/%1/, max - el.val().length));
            }, settings.delay);
          } else {
            container.html(settings.format.replace(/%1/, max - el.val().length));
          }
        };

        var pulse = function pulse(el, again) {
          if (p) {
            window.clearTimeout(p);
            p = null;
          }

          el.animate({
            opacity: 0.1
          }, 100, function () {
            $(el).animate({
              opacity: 1.0
            }, 100);
          });

          if (again) {
            p = window.setTimeout(function () {
              pulse(el);
            }, 200);
          }
        };

        return this.each(function (index, el) {
          var container;

          if (!settings.container.match(/^<.+>$/)) {
            // use existing element to hold counter message
            container = $(settings.container);
          } else {
            // append element to hold counter message (clean up old element first)
            $(el).next('.' + settings.classname).remove();
            container = $(settings.container).insertAfter(el).addClass(settings.classname);
          }

          $(el).unbind('.charCounter').bind('keydown.charCounter', function () {
            count(el, container);
          }).bind('keypress.charCounter', function () {
            count(el, container);
          }).bind('keyup.charCounter', function () {
            count(el, container);
          }).bind('focus.charCounter', function () {
            count(el, container);
          }).bind('mouseover.charCounter', function () {
            count(el, container);
          }).bind('mouseout.charCounter', function () {
            count(el, container);
          }).bind('paste.charCounter', function () {
            setTimeout(function () {
              count(el, container);
            }, 10);
          });

          if (el.addEventListener) {
            el.addEventListener('input', function () {
              count(el, container);
            }, false);
          }

          count(el, container);
        });
      };

      $(document).on('click', 'input[data-counter], textarea[data-counter]', function (event) {
        $(event.currentTarget).charCounter($(event.currentTarget).data('counter'), {
          container: '<small></small>'
        });
      });
    }
  }], [{
    key: "blockUI",
    value: function blockUI(options) {
      options = $.extend(true, {}, options);
      var html = '';

      if (options.animate) {
        html = '<div class="loading-message ' + (options.boxed ? 'loading-message-boxed' : '') + '">' + '<div class="block-spinner-bar"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>' + '</div>';
      } else if (options.iconOnly) {
        html = '<div class="loading-message ' + (options.boxed ? 'loading-message-boxed' : '') + '"><img src="/vendor/core/images/loading-spinner-blue.gif"></div>';
      } else if (options.textOnly) {
        html = '<div class="loading-message ' + (options.boxed ? 'loading-message-boxed' : '') + '"><span>&nbsp;&nbsp;' + (options.message ? options.message : 'LOADING...') + '</span></div>';
      } else {
        html = '<div class="loading-message ' + (options.boxed ? 'loading-message-boxed' : '') + '"><img src="/vendor/core/images/loading-spinner-blue.gif"><span>&nbsp;&nbsp;' + (options.message ? options.message : 'LOADING...') + '</span></div>';
      }

      if (options.target) {
        // element blocking
        var el = $(options.target);

        if (el.height() <= $(window).height()) {
          options.cenrerY = true;
        }

        el.block({
          message: html,
          baseZ: options.zIndex ? options.zIndex : 1000,
          centerY: options.cenrerY !== undefined ? options.cenrerY : false,
          css: {
            top: '10%',
            border: '0',
            padding: '0',
            backgroundColor: 'none'
          },
          overlayCSS: {
            backgroundColor: options.overlayColor ? options.overlayColor : '#555',
            opacity: options.boxed ? 0.05 : 0.1,
            cursor: 'wait'
          }
        });
      } else {
        // page blocking
        $.blockUI({
          message: html,
          baseZ: options.zIndex ? options.zIndex : 1000,
          css: {
            border: '0',
            padding: '0',
            backgroundColor: 'none'
          },
          overlayCSS: {
            backgroundColor: options.overlayColor ? options.overlayColor : '#555',
            opacity: options.boxed ? 0.05 : 0.1,
            cursor: 'wait'
          }
        });
      }
    }
  }, {
    key: "unblockUI",
    value: function unblockUI(target) {
      if (target) {
        $(target).unblock({
          onUnblock: function onUnblock() {
            $(target).css('position', '');
            $(target).css('zoom', '');
          }
        });
      } else {
        $.unblockUI();
      }
    }
  }, {
    key: "showNotice",
    value: function showNotice(messageType, message) {
      toastr.clear();
      toastr.options = {
        closeButton: true,
        positionClass: 'toast-bottom-right',
        onclick: null,
        showDuration: 1000,
        hideDuration: 1000,
        timeOut: 10000,
        extendedTimeOut: 1000,
        showEasing: 'swing',
        hideEasing: 'linear',
        showMethod: 'fadeIn',
        hideMethod: 'fadeOut'
      };
      var messageHeader = '';

      switch (messageType) {
        case 'error':
          // messageHeader = RoshanVariables.languages.notices_msg.error;
          messageHeader = "Error";
          break;

        case 'success':
          // messageHeader = RoshanVariables.languages.notices_msg.success;
          messageHeader = "Success";
          break;
      }

      toastr[messageType](message, messageHeader);
    }
  }, {
    key: "handleError",
    value: function handleError(data) {
      if (typeof data.errors !== 'undefined' && !_.isArray(data.errors)) {
        Roshan.handleValidationError(data.errors);
      } else {
        if (typeof data.responseJSON !== 'undefined') {
          if (typeof data.responseJSON.errors !== 'undefined') {
            if (data.status === 422) {
              Roshan.handleValidationError(data.responseJSON.errors);
            }
          } else if (typeof data.responseJSON.message !== 'undefined') {
            Roshan.showNotice('error', data.responseJSON.message);
          } else {
            $.each(data.responseJSON, function (index, el) {
              $.each(el, function (key, item) {
                Roshan.showNotice('error', item);
              });
            });
          }
        } else {
          Roshan.showNotice('error', data.statusText);
        }
      }
    }
  }, {
    key: "handleValidationError",
    value: function handleValidationError(errors) {
      var message = '';
      $.each(errors, function (index, item) {
        message += item + '<br />';
        var $input = $('*[name="' + index + '"]');

        if ($input.closest('.next-input--stylized').length) {
          $input.closest('.next-input--stylized').addClass('field-has-error');
        } else {
          $input.addClass('field-has-error');
        }

        var $input_array = $('*[name$="[' + index + ']"]');

        if ($input_array.closest('.next-input--stylized').length) {
          $input_array.closest('.next-input--stylized').addClass('field-has-error');
        } else {
          $input_array.addClass('field-has-error');
        }
      });
      Roshan.showNotice('error', message);
    }
  }, {
    key: "initDatePicker",
    value: function initDatePicker(element) {
      if (jQuery().bootstrapDP) {
        var format = $(document).find(element).data('date-format');

        if (!format) {
          format = 'yyyy-mm-dd';
        }

        $(document).find(element).bootstrapDP({
          maxDate: 0,
          changeMonth: true,
          changeYear: true,
          autoclose: true,
          dateFormat: format
        });
      }
    }
  }, {
    key: "initResources",
    value: function initResources() {
      if (jQuery().select2) {
        $(document).find('.select-multiple').select2({
          width: '100%',
          allowClear: true
        });
        $(document).find('.select-search-full').select2({
          width: '100%'
        });
        $(document).find('.select-full').select2({
          width: '100%',
          minimumResultsForSearch: -1
        });
      }

      if (jQuery().timepicker) {
        if (jQuery().timepicker) {
          $('.timepicker-default').timepicker({
            autoclose: true,
            showSeconds: true,
            minuteStep: 1,
            defaultTime: false
          });
          $('.timepicker-no-seconds').timepicker({
            autoclose: true,
            minuteStep: 5,
            defaultTime: false
          });
          $('.timepicker-24').timepicker({
            autoclose: true,
            minuteStep: 5,
            showSeconds: false,
            showMeridian: false,
            defaultTime: false
          });
        }
      }

      if (jQuery().inputmask) {
        $(document).find('.input-mask-number').inputmask({
          alias: 'numeric',
          rightAlign: false,
          digits: 2,
          groupSeparator: ',',
          placeholder: '0',
          autoGroup: true,
          autoUnmask: true,
          removeMaskOnSubmit: true
        });
      }

      if (jQuery().colorpicker) {
        $('.color-picker').colorpicker({});
      }

      if (jQuery().fancybox) {
        $('.iframe-btn').fancybox({
          width: '900px',
          height: '700px',
          type: 'iframe',
          autoScale: false,
          openEffect: 'none',
          closeEffect: 'none',
          overlayShow: true,
          overlayOpacity: 0.7
        });
        $('.fancybox').fancybox({
          openEffect: 'none',
          closeEffect: 'none',
          overlayShow: true,
          overlayOpacity: 0.7,
          helpers: {
            media: {}
          }
        });
      }

      if (jQuery().areYouSure) {
        $('form').areYouSure();
      }

      Roshan.initDatePicker('.datepicker');

      if (jQuery().textareaAutoSize) {
        $('textarea.textarea-auto-height').textareaAutoSize();
      }
    }
  }, {
    key: "numberFormat",
    value: function numberFormat(number, decimals, dec_point, thousands_sep) {
      // *     example 1: number_format(1234.56);
      // *     returns 1: '1,235'
      // *     example 2: number_format(1234.56, 2, ',', ' ');
      // *     returns 2: '1 234,56'
      // *     example 3: number_format(1234.5678, 2, '.', '');
      // *     returns 3: '1234.57'
      // *     example 4: number_format(67, 2, ',', '.');
      // *     returns 4: '67,00'
      // *     example 5: number_format(1000);
      // *     returns 5: '1,000'
      // *     example 6: number_format(67.311, 2);
      // *     returns 6: '67.31'
      // *     example 7: number_format(1000.55, 1);
      // *     returns 7: '1,000.6'
      // *     example 8: number_format(67000, 5, ',', '.');
      // *     returns 8: '67.000,00000'
      // *     example 9: number_format(0.9, 0);
      // *     returns 9: '1'
      // *    example 10: number_format('1.20', 2);
      // *    returns 10: '1.20'
      // *    example 11: number_format('1.20', 4);
      // *    returns 11: '1.2000'
      // *    example 12: number_format('1.2000', 3);
      // *    returns 12: '1.200'
      var n = !isFinite(+number) ? 0 : +number,
          prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
          sep = typeof thousands_sep === 'undefined' ? ',' : thousands_sep,
          dec = typeof dec_point === 'undefined' ? '.' : dec_point,
          toFixedFix = function toFixedFix(n, prec) {
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        var k = Math.pow(10, prec);
        return Math.round(n * k) / k;
      },
          s = (prec ? toFixedFix(n, prec) : Math.round(n)).toString().split('.');

      if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
      }

      if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
      }

      return s.join(dec);
    }
  }, {
    key: "initMediaIntegrate",
    value: function initMediaIntegrate() {
      if (jQuery().rsMedia) {
        $('[data-type="rs-media-standard-alone-button"]').rsMedia({
          multiple: false,
          onSelectFiles: function onSelectFiles(files, $el) {
            $($el.data('target')).val(files[0].url);
          }
        });
        $(document).find('.btn_gallery').rsMedia({
          multiple: false,
          onSelectFiles: function onSelectFiles(files, $el) {
            switch ($el.data('action')) {
              case 'media-insert-ckeditor':
                $.each(files, function (index, file) {
                  var link = file.url;

                  if (file.type === 'youtube') {
                    link = link.replace('watch?v=', 'embed/');
                    CKEDITOR.instances[$el.data('result')].insertHtml('<iframe width="420" height="315" src="' + link + '" frameborder="0" allowfullscreen></iframe>');
                  } else if (file.type === 'image') {
                    CKEDITOR.instances[$el.data('result')].insertHtml('<img src="' + link + '" alt="' + file.name + '" />');
                  } else {
                    CKEDITOR.instances[$el.data('result')].insertHtml('<a href="' + link + '">' + file.name + '</a>');
                  }
                });
                break;

              case 'media-insert-tinymce':
                $.each(files, function (index, file) {
                  var link = file.url;
                  var html = '';

                  if (file.type === 'youtube') {
                    link = link.replace('watch?v=', 'embed/');
                    html = '<iframe width="420" height="315" src="' + link + '" frameborder="0" allowfullscreen></iframe>';
                  } else if (file.type === 'image') {
                    html = '<img src="' + link + '" alt="' + file.name + '" />';
                  } else {
                    html = '<a href="' + link + '">' + file.name + '</a>';
                  }

                  tinymce.activeEditor.execCommand('mceInsertContent', false, html);
                });
                break;

              case 'select-image':
                var firstImage = _.first(files);

                $el.closest('.image-box').find('.image-data').val(firstImage.url);
                $el.closest('.image-box').find('.preview_image').attr('src', firstImage.thumb);
                $el.closest('.image-box').find('.preview-image-wrapper').show();
                break;

              case 'attachment':
                var firstAttachment = _.first(files);

                $el.closest('.attachment-wrapper').find('.attachment-url').val(firstAttachment.url);
                $('.attachment-details').html('<a href="' + firstAttachment.url + '" target="_blank">' + firstAttachment.url + '</a>');
                break;
            }
          }
        });
        $(document).on('click', '.btn_remove_image', function (event) {
          event.preventDefault();
          $(event.currentTarget).closest('.image-box').find('.preview-image-wrapper').hide();
          $(event.currentTarget).closest('.image-box').find('.image-data').val('');
        });
        $(document).on('click', '.btn_remove_attachment', function (event) {
          event.preventDefault();
          $(event.currentTarget).closest('.attachment-wrapper').find('.attachment-details a').remove();
          $(event.currentTarget).closest('.attachment-wrapper').find('.attachment-url').val('');
        });
      }
    }
  }, {
    key: "initCodeEditor",
    value: function initCodeEditor(id) {
      $(document).find('#' + id).wrap('<div id="wrapper_' + id + '"><div class="container_content_codemirror"></div> </div>');
      $('#wrapper_' + id).append('<div class="handle-tool-drag" id="tool-drag_' + id + '"></div>');
      CodeMirror.fromTextArea(document.getElementById(id), {
        extraKeys: {
          'Ctrl-Space': 'autocomplete'
        },
        lineNumbers: true,
        mode: 'css',
        autoRefresh: true,
        lineWrapping: true
      });
      $('.handle-tool-drag').mousedown(function (event) {
        var _self = $(event.currentTarget);

        _self.attr('data-start_h', _self.parent().find('.CodeMirror').height()).attr('data-start_y', event.pageY);

        $('body').attr('data-dragtool', _self.attr('id')).on('mousemove', Roshan.onDragTool);
        $(window).on('mouseup', Roshan.onReleaseTool);
      });
    }
  }]);

  return Roshan;
}();

$(document).ready(function () {
  new Roshan();
  window.Roshan = Roshan;
});

/***/ }),

/***/ 1:
/*!**********************************************!*\
  !*** multi ./resources/admin/js/core/app.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\laragon\www\service-mario\resources\admin\js\core\app.js */"./resources/admin/js/core/app.js");


/***/ })

/******/ });