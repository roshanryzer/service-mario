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
/******/ 	return __webpack_require__(__webpack_require__.s = 3);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/admin/js/media/file-manager.js":
/*!**************************************************!*\
  !*** ./resources/admin/js/media/file-manager.js ***!
  \**************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

/*=========================================================================================
    File Name: app-file-manager.js
    Description: app-file-manager js
    ==========================================================================================*/
// all the elements references
var sidebarFileManager = $('.sidebar-file-manager');
var sidebarToggler = $('.file-manager-toggler');
var fileManagerOverlay = $('.file-manager-content-overlay');
var sidebarRight = $('.right-sidebar'); // sidebar file manager list scrollbar

if ($('.list').length > 0) {
  var sidebarLeftList = new PerfectScrollbar('.list', {
    suppressScrollX: true
  });
} // right-content-wrapper and rightside bar scrollbar


if ($('.file-manager-main-content .right-sidebar').length > 0) {
  var rightsidebar = new PerfectScrollbar('.file-manager-main-content .right-sidebar .card-body', {
    suppressScrollX: true,
    wheelPropagation: false
  });
}

if ($('.file-manager-main-content').length > 0) {
  var rightContentWrapper = new PerfectScrollbar('.file-manager-main-content .bottom-content', {
    cancelable: true,
    wheelPropagation: false
  });
} // click event for show sidebar


sidebarToggler.on("click", function () {
  sidebarFileManager.toggleClass('show');
  fileManagerOverlay.toggleClass('show');
}); // remove sidebar

$(".file-manager-content-overlay, .sidebar-close-icon").on("click", function () {
  sidebarFileManager.removeClass("show");
  fileManagerOverlay.removeClass("show");
  sidebarRight.removeClass('show');
}); // On click of "app-file-info and files-info" opening right sidebar

$('.folder-info, .files-info').on('click', function (e) {
  if (!e.target.classList.contains('icon-more-vertical') && !e.target.classList.contains('media-object')) {
    sidebarRight.addClass('show');
    fileManagerOverlay.addClass('show');
  }
}); // opening right sidebar on click of a table row

$('#data-list-view tbody > tr').on('click', function (e) {
  if (!e.target.classList.contains('icon-more-vertical')) {
    sidebarRight.addClass('show');
    fileManagerOverlay.addClass('show');
  }
}); // on screen Resize remove .show from overlay and sidebar

$(window).on('resize', function () {
  if ($(window).width() > 768) {
    if (fileManagerOverlay.hasClass('show')) {
      sidebarFileManager.removeClass('show');
      fileManagerOverlay.removeClass('show');
      sidebarRight.removeClass('show');
    }
  }
}); // making active to list item in links on click

$(".file-manager-application .sidebar-menu-list .list-group a").on('click', function () {
  if ($('.file-manager-application .sidebar-menu-list .list-group a').hasClass('active')) {
    $('.file-manager-application .sidebar-menu-list .list-group a').removeClass('active');
  }

  $(this).addClass("active");
}); // init list view datatable

var dataListView = $(".data-list-view").DataTable(_defineProperty({
  responsive: false,
  scrollCollapse: true,
  paging: false,
  searching: false,
  ordering: false,
  select: true,
  info: false
}, "select", {
  style: 'single'
}));

/***/ }),

/***/ 3:
/*!********************************************************!*\
  !*** multi ./resources/admin/js/media/file-manager.js ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\laragon\www\service-mario\resources\admin\js\media\file-manager.js */"./resources/admin/js/media/file-manager.js");


/***/ })

/******/ });