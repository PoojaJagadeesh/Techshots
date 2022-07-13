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
/******/ 	return __webpack_require__(__webpack_require__.s = 2);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/script.js":
/*!********************************!*\
  !*** ./resources/js/script.js ***!
  \********************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("var timestamp = function timestamp() {\n  var timeIndex = 0;\n  var shifts = [35, 60, 60 * 3, 60 * 60 * 2, 60 * 60 * 25, 60 * 60 * 24 * 4, 60 * 60 * 24 * 10];\n  var now = new Date();\n  var shift = shifts[timeIndex++] || 0;\n  var date = new Date(now - shift * 1000);\n  return date.getTime() / 1000;\n};\n\nvar changeSkin = function changeSkin(skin) {\n  location.href = location.href.split('#')[0].split('?')[0] + '?skin=' + skin;\n};\n\nvar getCurrentSkin = function getCurrentSkin() {\n  var header = document.getElementById('header');\n  var skin = location.href.split('skin=')[1];\n\n  if (!skin) {\n    skin = 'Snapgram';\n  }\n\n  if (skin.indexOf('#') !== -1) {\n    skin = skin.split('#')[0];\n  }\n\n  var skins = {\n    Snapgram: {\n      avatars: true,\n      list: false,\n      autoFullScreen: false,\n      cubeEffect: true,\n      paginationArrows: false\n    },\n    VemDeZAP: {\n      avatars: false,\n      list: true,\n      autoFullScreen: false,\n      cubeEffect: false,\n      paginationArrows: true\n    },\n    FaceSnap: {\n      avatars: true,\n      list: false,\n      autoFullScreen: true,\n      cubeEffect: false,\n      paginationArrows: true\n    },\n    Snapssenger: {\n      avatars: false,\n      list: false,\n      autoFullScreen: false,\n      cubeEffect: false,\n      paginationArrows: false\n    }\n  };\n  var el = document.querySelectorAll('#skin option');\n  var total = el.length;\n\n  for (var i = 0; i < total; i++) {\n    var what = skin == el[i].value ? true : false;\n\n    if (what) {\n      el[i].setAttribute('selected', 'selected');\n      header.innerHTML = skin;\n      header.className = skin;\n    } else {\n      el[i].removeAttribute('selected');\n    }\n  }\n\n  return {\n    name: skin,\n    params: skins[skin]\n  };\n};//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvc2NyaXB0LmpzPzg3MzMiXSwibmFtZXMiOlsidGltZXN0YW1wIiwidGltZUluZGV4Iiwic2hpZnRzIiwibm93IiwiRGF0ZSIsInNoaWZ0IiwiZGF0ZSIsImdldFRpbWUiLCJjaGFuZ2VTa2luIiwic2tpbiIsImxvY2F0aW9uIiwiaHJlZiIsInNwbGl0IiwiZ2V0Q3VycmVudFNraW4iLCJoZWFkZXIiLCJkb2N1bWVudCIsImdldEVsZW1lbnRCeUlkIiwiaW5kZXhPZiIsInNraW5zIiwiU25hcGdyYW0iLCJhdmF0YXJzIiwibGlzdCIsImF1dG9GdWxsU2NyZWVuIiwiY3ViZUVmZmVjdCIsInBhZ2luYXRpb25BcnJvd3MiLCJWZW1EZVpBUCIsIkZhY2VTbmFwIiwiU25hcHNzZW5nZXIiLCJlbCIsInF1ZXJ5U2VsZWN0b3JBbGwiLCJ0b3RhbCIsImxlbmd0aCIsImkiLCJ3aGF0IiwidmFsdWUiLCJzZXRBdHRyaWJ1dGUiLCJpbm5lckhUTUwiLCJjbGFzc05hbWUiLCJyZW1vdmVBdHRyaWJ1dGUiLCJuYW1lIiwicGFyYW1zIl0sIm1hcHBpbmdzIjoiQUFBQSxJQUFJQSxTQUFTLEdBQUcsU0FBWkEsU0FBWSxHQUFXO0FBQ3pCLE1BQUlDLFNBQVMsR0FBRyxDQUFoQjtBQUNBLE1BQUlDLE1BQU0sR0FBRyxDQUFDLEVBQUQsRUFBSyxFQUFMLEVBQVMsS0FBSyxDQUFkLEVBQWlCLEtBQUssRUFBTCxHQUFVLENBQTNCLEVBQThCLEtBQUssRUFBTCxHQUFVLEVBQXhDLEVBQTRDLEtBQUssRUFBTCxHQUFVLEVBQVYsR0FBZSxDQUEzRCxFQUE4RCxLQUFLLEVBQUwsR0FBVSxFQUFWLEdBQWUsRUFBN0UsQ0FBYjtBQUVBLE1BQUlDLEdBQUcsR0FBRyxJQUFJQyxJQUFKLEVBQVY7QUFDQSxNQUFJQyxLQUFLLEdBQUdILE1BQU0sQ0FBQ0QsU0FBUyxFQUFWLENBQU4sSUFBdUIsQ0FBbkM7QUFDQSxNQUFJSyxJQUFJLEdBQUcsSUFBSUYsSUFBSixDQUFTRCxHQUFHLEdBQUdFLEtBQUssR0FBRyxJQUF2QixDQUFYO0FBRUEsU0FBT0MsSUFBSSxDQUFDQyxPQUFMLEtBQWlCLElBQXhCO0FBQ0QsQ0FURDs7QUFXQSxJQUFJQyxVQUFVLEdBQUcsU0FBYkEsVUFBYSxDQUFTQyxJQUFULEVBQWU7QUFDOUJDLFVBQVEsQ0FBQ0MsSUFBVCxHQUFnQkQsUUFBUSxDQUFDQyxJQUFULENBQWNDLEtBQWQsQ0FBb0IsR0FBcEIsRUFBeUIsQ0FBekIsRUFBNEJBLEtBQTVCLENBQWtDLEdBQWxDLEVBQXVDLENBQXZDLElBQTRDLFFBQTVDLEdBQXVESCxJQUF2RTtBQUNELENBRkQ7O0FBSUEsSUFBSUksY0FBYyxHQUFHLFNBQWpCQSxjQUFpQixHQUFXO0FBQzlCLE1BQUlDLE1BQU0sR0FBR0MsUUFBUSxDQUFDQyxjQUFULENBQXdCLFFBQXhCLENBQWI7QUFDQSxNQUFJUCxJQUFJLEdBQUdDLFFBQVEsQ0FBQ0MsSUFBVCxDQUFjQyxLQUFkLENBQW9CLE9BQXBCLEVBQTZCLENBQTdCLENBQVg7O0FBRUEsTUFBSSxDQUFDSCxJQUFMLEVBQVc7QUFDVEEsUUFBSSxHQUFHLFVBQVA7QUFDRDs7QUFFRCxNQUFJQSxJQUFJLENBQUNRLE9BQUwsQ0FBYSxHQUFiLE1BQXNCLENBQUMsQ0FBM0IsRUFBOEI7QUFDNUJSLFFBQUksR0FBR0EsSUFBSSxDQUFDRyxLQUFMLENBQVcsR0FBWCxFQUFnQixDQUFoQixDQUFQO0FBQ0Q7O0FBRUQsTUFBSU0sS0FBSyxHQUFHO0FBQ1ZDLFlBQVEsRUFBRTtBQUNSQyxhQUFPLEVBQUUsSUFERDtBQUVSQyxVQUFJLEVBQUUsS0FGRTtBQUdSQyxvQkFBYyxFQUFFLEtBSFI7QUFJUkMsZ0JBQVUsRUFBRSxJQUpKO0FBS1JDLHNCQUFnQixFQUFFO0FBTFYsS0FEQTtBQVNWQyxZQUFRLEVBQUU7QUFDUkwsYUFBTyxFQUFFLEtBREQ7QUFFUkMsVUFBSSxFQUFFLElBRkU7QUFHUkMsb0JBQWMsRUFBRSxLQUhSO0FBSVJDLGdCQUFVLEVBQUUsS0FKSjtBQUtSQyxzQkFBZ0IsRUFBRTtBQUxWLEtBVEE7QUFpQlZFLFlBQVEsRUFBRTtBQUNSTixhQUFPLEVBQUUsSUFERDtBQUVSQyxVQUFJLEVBQUUsS0FGRTtBQUdSQyxvQkFBYyxFQUFFLElBSFI7QUFJUkMsZ0JBQVUsRUFBRSxLQUpKO0FBS1JDLHNCQUFnQixFQUFFO0FBTFYsS0FqQkE7QUF5QlZHLGVBQVcsRUFBRTtBQUNYUCxhQUFPLEVBQUUsS0FERTtBQUVYQyxVQUFJLEVBQUUsS0FGSztBQUdYQyxvQkFBYyxFQUFFLEtBSEw7QUFJWEMsZ0JBQVUsRUFBRSxLQUpEO0FBS1hDLHNCQUFnQixFQUFFO0FBTFA7QUF6QkgsR0FBWjtBQWtDQSxNQUFJSSxFQUFFLEdBQUdiLFFBQVEsQ0FBQ2MsZ0JBQVQsQ0FBMEIsY0FBMUIsQ0FBVDtBQUNBLE1BQUlDLEtBQUssR0FBR0YsRUFBRSxDQUFDRyxNQUFmOztBQUNBLE9BQUssSUFBSUMsQ0FBQyxHQUFHLENBQWIsRUFBZ0JBLENBQUMsR0FBR0YsS0FBcEIsRUFBMkJFLENBQUMsRUFBNUIsRUFBZ0M7QUFDOUIsUUFBSUMsSUFBSSxHQUFHeEIsSUFBSSxJQUFJbUIsRUFBRSxDQUFDSSxDQUFELENBQUYsQ0FBTUUsS0FBZCxHQUFzQixJQUF0QixHQUE2QixLQUF4Qzs7QUFFQSxRQUFJRCxJQUFKLEVBQVU7QUFDUkwsUUFBRSxDQUFDSSxDQUFELENBQUYsQ0FBTUcsWUFBTixDQUFtQixVQUFuQixFQUErQixVQUEvQjtBQUVBckIsWUFBTSxDQUFDc0IsU0FBUCxHQUFtQjNCLElBQW5CO0FBQ0FLLFlBQU0sQ0FBQ3VCLFNBQVAsR0FBbUI1QixJQUFuQjtBQUNELEtBTEQsTUFLTztBQUNMbUIsUUFBRSxDQUFDSSxDQUFELENBQUYsQ0FBTU0sZUFBTixDQUFzQixVQUF0QjtBQUNEO0FBQ0Y7O0FBRUQsU0FBTztBQUNMQyxRQUFJLEVBQUU5QixJQUREO0FBRUwrQixVQUFNLEVBQUV0QixLQUFLLENBQUNULElBQUQ7QUFGUixHQUFQO0FBSUQsQ0FqRUQiLCJmaWxlIjoiLi9yZXNvdXJjZXMvanMvc2NyaXB0LmpzLmpzIiwic291cmNlc0NvbnRlbnQiOlsidmFyIHRpbWVzdGFtcCA9IGZ1bmN0aW9uKCkge1xyXG4gIHZhciB0aW1lSW5kZXggPSAwO1xyXG4gIHZhciBzaGlmdHMgPSBbMzUsIDYwLCA2MCAqIDMsIDYwICogNjAgKiAyLCA2MCAqIDYwICogMjUsIDYwICogNjAgKiAyNCAqIDQsIDYwICogNjAgKiAyNCAqIDEwXTtcclxuXHJcbiAgdmFyIG5vdyA9IG5ldyBEYXRlKCk7XHJcbiAgdmFyIHNoaWZ0ID0gc2hpZnRzW3RpbWVJbmRleCsrXSB8fCAwO1xyXG4gIHZhciBkYXRlID0gbmV3IERhdGUobm93IC0gc2hpZnQgKiAxMDAwKTtcclxuXHJcbiAgcmV0dXJuIGRhdGUuZ2V0VGltZSgpIC8gMTAwMDtcclxufTtcclxuXHJcbnZhciBjaGFuZ2VTa2luID0gZnVuY3Rpb24oc2tpbikge1xyXG4gIGxvY2F0aW9uLmhyZWYgPSBsb2NhdGlvbi5ocmVmLnNwbGl0KCcjJylbMF0uc3BsaXQoJz8nKVswXSArICc/c2tpbj0nICsgc2tpbjtcclxufTtcclxuXHJcbnZhciBnZXRDdXJyZW50U2tpbiA9IGZ1bmN0aW9uKCkge1xyXG4gIHZhciBoZWFkZXIgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnaGVhZGVyJyk7XHJcbiAgdmFyIHNraW4gPSBsb2NhdGlvbi5ocmVmLnNwbGl0KCdza2luPScpWzFdO1xyXG5cclxuICBpZiAoIXNraW4pIHtcclxuICAgIHNraW4gPSAnU25hcGdyYW0nO1xyXG4gIH1cclxuXHJcbiAgaWYgKHNraW4uaW5kZXhPZignIycpICE9PSAtMSkge1xyXG4gICAgc2tpbiA9IHNraW4uc3BsaXQoJyMnKVswXTtcclxuICB9XHJcblxyXG4gIHZhciBza2lucyA9IHtcclxuICAgIFNuYXBncmFtOiB7XHJcbiAgICAgIGF2YXRhcnM6IHRydWUsXHJcbiAgICAgIGxpc3Q6IGZhbHNlLFxyXG4gICAgICBhdXRvRnVsbFNjcmVlbjogZmFsc2UsXHJcbiAgICAgIGN1YmVFZmZlY3Q6IHRydWUsXHJcbiAgICAgIHBhZ2luYXRpb25BcnJvd3M6IGZhbHNlXHJcbiAgICB9LFxyXG5cclxuICAgIFZlbURlWkFQOiB7XHJcbiAgICAgIGF2YXRhcnM6IGZhbHNlLFxyXG4gICAgICBsaXN0OiB0cnVlLFxyXG4gICAgICBhdXRvRnVsbFNjcmVlbjogZmFsc2UsXHJcbiAgICAgIGN1YmVFZmZlY3Q6IGZhbHNlLFxyXG4gICAgICBwYWdpbmF0aW9uQXJyb3dzOiB0cnVlXHJcbiAgICB9LFxyXG5cclxuICAgIEZhY2VTbmFwOiB7XHJcbiAgICAgIGF2YXRhcnM6IHRydWUsXHJcbiAgICAgIGxpc3Q6IGZhbHNlLFxyXG4gICAgICBhdXRvRnVsbFNjcmVlbjogdHJ1ZSxcclxuICAgICAgY3ViZUVmZmVjdDogZmFsc2UsXHJcbiAgICAgIHBhZ2luYXRpb25BcnJvd3M6IHRydWVcclxuICAgIH0sXHJcblxyXG4gICAgU25hcHNzZW5nZXI6IHtcclxuICAgICAgYXZhdGFyczogZmFsc2UsXHJcbiAgICAgIGxpc3Q6IGZhbHNlLFxyXG4gICAgICBhdXRvRnVsbFNjcmVlbjogZmFsc2UsXHJcbiAgICAgIGN1YmVFZmZlY3Q6IGZhbHNlLFxyXG4gICAgICBwYWdpbmF0aW9uQXJyb3dzOiBmYWxzZVxyXG4gICAgfVxyXG4gIH07XHJcblxyXG4gIHZhciBlbCA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoJyNza2luIG9wdGlvbicpO1xyXG4gIHZhciB0b3RhbCA9IGVsLmxlbmd0aDtcclxuICBmb3IgKHZhciBpID0gMDsgaSA8IHRvdGFsOyBpKyspIHtcclxuICAgIHZhciB3aGF0ID0gc2tpbiA9PSBlbFtpXS52YWx1ZSA/IHRydWUgOiBmYWxzZTtcclxuXHJcbiAgICBpZiAod2hhdCkge1xyXG4gICAgICBlbFtpXS5zZXRBdHRyaWJ1dGUoJ3NlbGVjdGVkJywgJ3NlbGVjdGVkJyk7XHJcblxyXG4gICAgICBoZWFkZXIuaW5uZXJIVE1MID0gc2tpbjtcclxuICAgICAgaGVhZGVyLmNsYXNzTmFtZSA9IHNraW47XHJcbiAgICB9IGVsc2Uge1xyXG4gICAgICBlbFtpXS5yZW1vdmVBdHRyaWJ1dGUoJ3NlbGVjdGVkJyk7XHJcbiAgICB9XHJcbiAgfVxyXG5cclxuICByZXR1cm4ge1xyXG4gICAgbmFtZTogc2tpbiwgXHJcbiAgICBwYXJhbXM6IHNraW5zW3NraW5dIFxyXG4gIH07XHJcbn07XHJcbiJdLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///./resources/js/script.js\n");

/***/ }),

/***/ 2:
/*!**************************************!*\
  !*** multi ./resources/js/script.js ***!
  \**************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! D:\laragon\www\techshots\resources\js\script.js */"./resources/js/script.js");


/***/ })

/******/ });