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
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
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
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(1);
module.exports = __webpack_require__(2);


/***/ }),
/* 1 */
/***/ (function(module, exports) {

function main() {

    if (window.location.href.indexOf("bets") > -1) {
        var bet_id = document.querySelector("#bet_id").value;
    }

    if (window.location.href.indexOf("games") > -1 || window.location.href.indexOf("bets") > -1) {
        var updateScores = function updateScores(a, b) {
            aLabel.innerHTML = a;
            bLabel.innerHTML = b;
        };

        var game_id = document.querySelector("#game_id").value;

        var aPlusButton = document.querySelector("#teamAplus");
        var aMinusButton = document.querySelector("#teamAminus");
        var bPlusButton = document.querySelector("#teamBplus");
        var bMinusButton = document.querySelector("#teamBminus");

        var aLabel = document.querySelector("#aScore");
        var bLabel = document.querySelector("#bScore");

        var aScore = parseInt(aLabel.innerHTML);
        var bScore = parseInt(bLabel.innerHTML);

        try {
            var submitButton = document.querySelector("#newbetsubmit");
            submitButton.addEventListener('click', function (el) {
                console.log(game_id);
                var csrf = document.querySelector("meta[name='csrf-token']").getAttribute('content');
                el.preventDefault();
                var data = {
                    a: aLabel.innerHTML,
                    b: bLabel.innerHTML,
                    game_id: game_id
                };

                var xhr = new XMLHttpRequest();
                xhr.open('POST', '/bets/add');
                xhr.setRequestHeader("X-CSRF-TOKEN", csrf);
                xhr.setRequestHeader("content-type", "application/json");
                xhr.send(JSON.stringify(data));

                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) window.location.replace("/");
                    }
                };
            });
        } catch (e) {}

        try {
            var editsubmitButton = document.querySelector("#editbetsubmit");
            editsubmitButton.addEventListener('click', function (el) {
                console.log(game_id);
                var csrf = document.querySelector("meta[name='csrf-token']").getAttribute('content');
                el.preventDefault();
                var data = {
                    a: aLabel.innerHTML,
                    b: bLabel.innerHTML
                };

                var xhr = new XMLHttpRequest();
                xhr.open('POST', '/bets/edit/' + bet_id);
                xhr.setRequestHeader("X-CSRF-TOKEN", csrf);
                xhr.setRequestHeader("content-type", "application/json");
                xhr.send(JSON.stringify(data));

                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) window.location.replace("/");
                    }
                };
            });
        } catch (e) {}

        aPlusButton.addEventListener('click', function (el) {
            aScore += 1;
            updateScores(aScore, bScore);
        });

        aMinusButton.addEventListener('click', function (el) {
            aScore -= 1;
            updateScores(aScore, bScore);
        });

        bPlusButton.addEventListener('click', function (el) {
            bScore += 1;
            updateScores(aScore, bScore);
        });

        bMinusButton.addEventListener('click', function (el) {
            bScore -= 1;
            updateScores(aScore, bScore);
        });
    }

    var bet_displays = document.getElementsByClassName("bet_display");

    var _loop = function _loop(i) {
        bet_displays[i].addEventListener('click', function (e) {
            var bet_id = bet_displays[i].getAttribute("data-bet_id");
            window.location.replace("/bets/" + bet_id);
        });
    };

    for (var i = 0; i < bet_displays.length; i++) {
        _loop(i);
    }
}

window.onload = main;

/***/ }),
/* 2 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ })
/******/ ]);