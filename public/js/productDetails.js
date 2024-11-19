/*
 * ATTENTION: An "eval-source-map" devtool has been used.
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file with attached SourceMaps in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/productDetails.js":
/*!****************************************!*\
  !*** ./resources/js/productDetails.js ***!
  \****************************************/
/***/ (() => {

eval("function _toConsumableArray(r) { return _arrayWithoutHoles(r) || _iterableToArray(r) || _unsupportedIterableToArray(r) || _nonIterableSpread(); }\nfunction _nonIterableSpread() { throw new TypeError(\"Invalid attempt to spread non-iterable instance.\\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.\"); }\nfunction _unsupportedIterableToArray(r, a) { if (r) { if (\"string\" == typeof r) return _arrayLikeToArray(r, a); var t = {}.toString.call(r).slice(8, -1); return \"Object\" === t && r.constructor && (t = r.constructor.name), \"Map\" === t || \"Set\" === t ? Array.from(r) : \"Arguments\" === t || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(t) ? _arrayLikeToArray(r, a) : void 0; } }\nfunction _iterableToArray(r) { if (\"undefined\" != typeof Symbol && null != r[Symbol.iterator] || null != r[\"@@iterator\"]) return Array.from(r); }\nfunction _arrayWithoutHoles(r) { if (Array.isArray(r)) return _arrayLikeToArray(r); }\nfunction _arrayLikeToArray(r, a) { (null == a || a > r.length) && (a = r.length); for (var e = 0, n = Array(a); e < a; e++) n[e] = r[e]; return n; }\nvar imgs = document.querySelectorAll('.img-select a');\nvar imgBtns = _toConsumableArray(imgs);\nvar imgId = 1;\nimgBtns.forEach(function (imgItem) {\n  imgItem.addEventListener('click', function (event) {\n    event.preventDefault();\n    imgId = imgItem.dataset.id;\n    slideImage();\n  });\n});\nfunction slideImage() {\n  var _document$querySelect;\n  var displayWidth = (_document$querySelect = document.querySelector('.img-showcase img:first-child')) === null || _document$querySelect === void 0 ? void 0 : _document$querySelect.clientWidth;\n  document.querySelector('.img-showcase').style.transform = \"translateX(\".concat(-(imgId - 1) * displayWidth, \"px)\");\n}\nwindow.addEventListener('resize', slideImage);//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJuYW1lcyI6WyJpbWdzIiwiZG9jdW1lbnQiLCJxdWVyeVNlbGVjdG9yQWxsIiwiaW1nQnRucyIsIl90b0NvbnN1bWFibGVBcnJheSIsImltZ0lkIiwiZm9yRWFjaCIsImltZ0l0ZW0iLCJhZGRFdmVudExpc3RlbmVyIiwiZXZlbnQiLCJwcmV2ZW50RGVmYXVsdCIsImRhdGFzZXQiLCJpZCIsInNsaWRlSW1hZ2UiLCJfZG9jdW1lbnQkcXVlcnlTZWxlY3QiLCJkaXNwbGF5V2lkdGgiLCJxdWVyeVNlbGVjdG9yIiwiY2xpZW50V2lkdGgiLCJzdHlsZSIsInRyYW5zZm9ybSIsImNvbmNhdCIsIndpbmRvdyJdLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvcHJvZHVjdERldGFpbHMuanM/ODA3NyJdLCJzb3VyY2VzQ29udGVudCI6WyJjb25zdCBpbWdzID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbCgnLmltZy1zZWxlY3QgYScpO1xuY29uc3QgaW1nQnRucyA9IFsuLi5pbWdzXTtcbmxldCBpbWdJZCA9IDE7XG5cbmltZ0J0bnMuZm9yRWFjaCgoaW1nSXRlbSkgPT4ge1xuICAgIGltZ0l0ZW0uYWRkRXZlbnRMaXN0ZW5lcignY2xpY2snLCAoZXZlbnQpID0+IHtcbiAgICAgICAgZXZlbnQucHJldmVudERlZmF1bHQoKTtcbiAgICAgICAgaW1nSWQgPSBpbWdJdGVtLmRhdGFzZXQuaWQ7XG4gICAgICAgIHNsaWRlSW1hZ2UoKTtcbiAgICB9KTtcbn0pO1xuXG5mdW5jdGlvbiBzbGlkZUltYWdlKCl7XG4gICAgY29uc3QgZGlzcGxheVdpZHRoID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcignLmltZy1zaG93Y2FzZSBpbWc6Zmlyc3QtY2hpbGQnKT8uY2xpZW50V2lkdGg7XG4gICAgZG9jdW1lbnQucXVlcnlTZWxlY3RvcignLmltZy1zaG93Y2FzZScpLnN0eWxlLnRyYW5zZm9ybSA9IGB0cmFuc2xhdGVYKCR7LSAoaW1nSWQgLSAxKSAqIGRpc3BsYXlXaWR0aH1weClgO1xufVxud2luZG93LmFkZEV2ZW50TGlzdGVuZXIoJ3Jlc2l6ZScsIHNsaWRlSW1hZ2UpO1xuIl0sIm1hcHBpbmdzIjoiOzs7Ozs7QUFBQSxJQUFNQSxJQUFJLEdBQUdDLFFBQVEsQ0FBQ0MsZ0JBQWdCLENBQUMsZUFBZSxDQUFDO0FBQ3ZELElBQU1DLE9BQU8sR0FBQUMsa0JBQUEsQ0FBT0osSUFBSSxDQUFDO0FBQ3pCLElBQUlLLEtBQUssR0FBRyxDQUFDO0FBRWJGLE9BQU8sQ0FBQ0csT0FBTyxDQUFDLFVBQUNDLE9BQU8sRUFBSztFQUN6QkEsT0FBTyxDQUFDQyxnQkFBZ0IsQ0FBQyxPQUFPLEVBQUUsVUFBQ0MsS0FBSyxFQUFLO0lBQ3pDQSxLQUFLLENBQUNDLGNBQWMsQ0FBQyxDQUFDO0lBQ3RCTCxLQUFLLEdBQUdFLE9BQU8sQ0FBQ0ksT0FBTyxDQUFDQyxFQUFFO0lBQzFCQyxVQUFVLENBQUMsQ0FBQztFQUNoQixDQUFDLENBQUM7QUFDTixDQUFDLENBQUM7QUFFRixTQUFTQSxVQUFVQSxDQUFBLEVBQUU7RUFBQSxJQUFBQyxxQkFBQTtFQUNqQixJQUFNQyxZQUFZLElBQUFELHFCQUFBLEdBQUdiLFFBQVEsQ0FBQ2UsYUFBYSxDQUFDLCtCQUErQixDQUFDLGNBQUFGLHFCQUFBLHVCQUF2REEscUJBQUEsQ0FBeURHLFdBQVc7RUFDekZoQixRQUFRLENBQUNlLGFBQWEsQ0FBQyxlQUFlLENBQUMsQ0FBQ0UsS0FBSyxDQUFDQyxTQUFTLGlCQUFBQyxNQUFBLENBQWlCLEVBQUdmLEtBQUssR0FBRyxDQUFDLENBQUMsR0FBR1UsWUFBWSxRQUFLO0FBQzdHO0FBQ0FNLE1BQU0sQ0FBQ2IsZ0JBQWdCLENBQUMsUUFBUSxFQUFFSyxVQUFVLENBQUMiLCJpZ25vcmVMaXN0IjpbXSwiZmlsZSI6Ii4vcmVzb3VyY2VzL2pzL3Byb2R1Y3REZXRhaWxzLmpzIiwic291cmNlUm9vdCI6IiJ9\n//# sourceURL=webpack-internal:///./resources/js/productDetails.js\n");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval-source-map devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./resources/js/productDetails.js"]();
/******/ 	
/******/ })()
;