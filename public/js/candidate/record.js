/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./node_modules/@babel/runtime/regenerator/index.js":
/*!**********************************************************!*\
  !*** ./node_modules/@babel/runtime/regenerator/index.js ***!
  \**********************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

module.exports = __webpack_require__(/*! regenerator-runtime */ "./node_modules/regenerator-runtime/runtime.js");


/***/ }),

/***/ "./node_modules/regenerator-runtime/runtime.js":
/*!*****************************************************!*\
  !*** ./node_modules/regenerator-runtime/runtime.js ***!
  \*****************************************************/
/***/ ((module) => {

/**
 * Copyright (c) 2014-present, Facebook, Inc.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 */

var runtime = (function (exports) {
  "use strict";

  var Op = Object.prototype;
  var hasOwn = Op.hasOwnProperty;
  var undefined; // More compressible than void 0.
  var $Symbol = typeof Symbol === "function" ? Symbol : {};
  var iteratorSymbol = $Symbol.iterator || "@@iterator";
  var asyncIteratorSymbol = $Symbol.asyncIterator || "@@asyncIterator";
  var toStringTagSymbol = $Symbol.toStringTag || "@@toStringTag";

  function define(obj, key, value) {
    Object.defineProperty(obj, key, {
      value: value,
      enumerable: true,
      configurable: true,
      writable: true
    });
    return obj[key];
  }
  try {
    // IE 8 has a broken Object.defineProperty that only works on DOM objects.
    define({}, "");
  } catch (err) {
    define = function(obj, key, value) {
      return obj[key] = value;
    };
  }

  function wrap(innerFn, outerFn, self, tryLocsList) {
    // If outerFn provided and outerFn.prototype is a Generator, then outerFn.prototype instanceof Generator.
    var protoGenerator = outerFn && outerFn.prototype instanceof Generator ? outerFn : Generator;
    var generator = Object.create(protoGenerator.prototype);
    var context = new Context(tryLocsList || []);

    // The ._invoke method unifies the implementations of the .next,
    // .throw, and .return methods.
    generator._invoke = makeInvokeMethod(innerFn, self, context);

    return generator;
  }
  exports.wrap = wrap;

  // Try/catch helper to minimize deoptimizations. Returns a completion
  // record like context.tryEntries[i].completion. This interface could
  // have been (and was previously) designed to take a closure to be
  // invoked without arguments, but in all the cases we care about we
  // already have an existing method we want to call, so there's no need
  // to create a new function object. We can even get away with assuming
  // the method takes exactly one argument, since that happens to be true
  // in every case, so we don't have to touch the arguments object. The
  // only additional allocation required is the completion record, which
  // has a stable shape and so hopefully should be cheap to allocate.
  function tryCatch(fn, obj, arg) {
    try {
      return { type: "normal", arg: fn.call(obj, arg) };
    } catch (err) {
      return { type: "throw", arg: err };
    }
  }

  var GenStateSuspendedStart = "suspendedStart";
  var GenStateSuspendedYield = "suspendedYield";
  var GenStateExecuting = "executing";
  var GenStateCompleted = "completed";

  // Returning this object from the innerFn has the same effect as
  // breaking out of the dispatch switch statement.
  var ContinueSentinel = {};

  // Dummy constructor functions that we use as the .constructor and
  // .constructor.prototype properties for functions that return Generator
  // objects. For full spec compliance, you may wish to configure your
  // minifier not to mangle the names of these two functions.
  function Generator() {}
  function GeneratorFunction() {}
  function GeneratorFunctionPrototype() {}

  // This is a polyfill for %IteratorPrototype% for environments that
  // don't natively support it.
  var IteratorPrototype = {};
  define(IteratorPrototype, iteratorSymbol, function () {
    return this;
  });

  var getProto = Object.getPrototypeOf;
  var NativeIteratorPrototype = getProto && getProto(getProto(values([])));
  if (NativeIteratorPrototype &&
      NativeIteratorPrototype !== Op &&
      hasOwn.call(NativeIteratorPrototype, iteratorSymbol)) {
    // This environment has a native %IteratorPrototype%; use it instead
    // of the polyfill.
    IteratorPrototype = NativeIteratorPrototype;
  }

  var Gp = GeneratorFunctionPrototype.prototype =
    Generator.prototype = Object.create(IteratorPrototype);
  GeneratorFunction.prototype = GeneratorFunctionPrototype;
  define(Gp, "constructor", GeneratorFunctionPrototype);
  define(GeneratorFunctionPrototype, "constructor", GeneratorFunction);
  GeneratorFunction.displayName = define(
    GeneratorFunctionPrototype,
    toStringTagSymbol,
    "GeneratorFunction"
  );

  // Helper for defining the .next, .throw, and .return methods of the
  // Iterator interface in terms of a single ._invoke method.
  function defineIteratorMethods(prototype) {
    ["next", "throw", "return"].forEach(function(method) {
      define(prototype, method, function(arg) {
        return this._invoke(method, arg);
      });
    });
  }

  exports.isGeneratorFunction = function(genFun) {
    var ctor = typeof genFun === "function" && genFun.constructor;
    return ctor
      ? ctor === GeneratorFunction ||
        // For the native GeneratorFunction constructor, the best we can
        // do is to check its .name property.
        (ctor.displayName || ctor.name) === "GeneratorFunction"
      : false;
  };

  exports.mark = function(genFun) {
    if (Object.setPrototypeOf) {
      Object.setPrototypeOf(genFun, GeneratorFunctionPrototype);
    } else {
      genFun.__proto__ = GeneratorFunctionPrototype;
      define(genFun, toStringTagSymbol, "GeneratorFunction");
    }
    genFun.prototype = Object.create(Gp);
    return genFun;
  };

  // Within the body of any async function, `await x` is transformed to
  // `yield regeneratorRuntime.awrap(x)`, so that the runtime can test
  // `hasOwn.call(value, "__await")` to determine if the yielded value is
  // meant to be awaited.
  exports.awrap = function(arg) {
    return { __await: arg };
  };

  function AsyncIterator(generator, PromiseImpl) {
    function invoke(method, arg, resolve, reject) {
      var record = tryCatch(generator[method], generator, arg);
      if (record.type === "throw") {
        reject(record.arg);
      } else {
        var result = record.arg;
        var value = result.value;
        if (value &&
            typeof value === "object" &&
            hasOwn.call(value, "__await")) {
          return PromiseImpl.resolve(value.__await).then(function(value) {
            invoke("next", value, resolve, reject);
          }, function(err) {
            invoke("throw", err, resolve, reject);
          });
        }

        return PromiseImpl.resolve(value).then(function(unwrapped) {
          // When a yielded Promise is resolved, its final value becomes
          // the .value of the Promise<{value,done}> result for the
          // current iteration.
          result.value = unwrapped;
          resolve(result);
        }, function(error) {
          // If a rejected Promise was yielded, throw the rejection back
          // into the async generator function so it can be handled there.
          return invoke("throw", error, resolve, reject);
        });
      }
    }

    var previousPromise;

    function enqueue(method, arg) {
      function callInvokeWithMethodAndArg() {
        return new PromiseImpl(function(resolve, reject) {
          invoke(method, arg, resolve, reject);
        });
      }

      return previousPromise =
        // If enqueue has been called before, then we want to wait until
        // all previous Promises have been resolved before calling invoke,
        // so that results are always delivered in the correct order. If
        // enqueue has not been called before, then it is important to
        // call invoke immediately, without waiting on a callback to fire,
        // so that the async generator function has the opportunity to do
        // any necessary setup in a predictable way. This predictability
        // is why the Promise constructor synchronously invokes its
        // executor callback, and why async functions synchronously
        // execute code before the first await. Since we implement simple
        // async functions in terms of async generators, it is especially
        // important to get this right, even though it requires care.
        previousPromise ? previousPromise.then(
          callInvokeWithMethodAndArg,
          // Avoid propagating failures to Promises returned by later
          // invocations of the iterator.
          callInvokeWithMethodAndArg
        ) : callInvokeWithMethodAndArg();
    }

    // Define the unified helper method that is used to implement .next,
    // .throw, and .return (see defineIteratorMethods).
    this._invoke = enqueue;
  }

  defineIteratorMethods(AsyncIterator.prototype);
  define(AsyncIterator.prototype, asyncIteratorSymbol, function () {
    return this;
  });
  exports.AsyncIterator = AsyncIterator;

  // Note that simple async functions are implemented on top of
  // AsyncIterator objects; they just return a Promise for the value of
  // the final result produced by the iterator.
  exports.async = function(innerFn, outerFn, self, tryLocsList, PromiseImpl) {
    if (PromiseImpl === void 0) PromiseImpl = Promise;

    var iter = new AsyncIterator(
      wrap(innerFn, outerFn, self, tryLocsList),
      PromiseImpl
    );

    return exports.isGeneratorFunction(outerFn)
      ? iter // If outerFn is a generator, return the full iterator.
      : iter.next().then(function(result) {
          return result.done ? result.value : iter.next();
        });
  };

  function makeInvokeMethod(innerFn, self, context) {
    var state = GenStateSuspendedStart;

    return function invoke(method, arg) {
      if (state === GenStateExecuting) {
        throw new Error("Generator is already running");
      }

      if (state === GenStateCompleted) {
        if (method === "throw") {
          throw arg;
        }

        // Be forgiving, per 25.3.3.3.3 of the spec:
        // https://people.mozilla.org/~jorendorff/es6-draft.html#sec-generatorresume
        return doneResult();
      }

      context.method = method;
      context.arg = arg;

      while (true) {
        var delegate = context.delegate;
        if (delegate) {
          var delegateResult = maybeInvokeDelegate(delegate, context);
          if (delegateResult) {
            if (delegateResult === ContinueSentinel) continue;
            return delegateResult;
          }
        }

        if (context.method === "next") {
          // Setting context._sent for legacy support of Babel's
          // function.sent implementation.
          context.sent = context._sent = context.arg;

        } else if (context.method === "throw") {
          if (state === GenStateSuspendedStart) {
            state = GenStateCompleted;
            throw context.arg;
          }

          context.dispatchException(context.arg);

        } else if (context.method === "return") {
          context.abrupt("return", context.arg);
        }

        state = GenStateExecuting;

        var record = tryCatch(innerFn, self, context);
        if (record.type === "normal") {
          // If an exception is thrown from innerFn, we leave state ===
          // GenStateExecuting and loop back for another invocation.
          state = context.done
            ? GenStateCompleted
            : GenStateSuspendedYield;

          if (record.arg === ContinueSentinel) {
            continue;
          }

          return {
            value: record.arg,
            done: context.done
          };

        } else if (record.type === "throw") {
          state = GenStateCompleted;
          // Dispatch the exception by looping back around to the
          // context.dispatchException(context.arg) call above.
          context.method = "throw";
          context.arg = record.arg;
        }
      }
    };
  }

  // Call delegate.iterator[context.method](context.arg) and handle the
  // result, either by returning a { value, done } result from the
  // delegate iterator, or by modifying context.method and context.arg,
  // setting context.delegate to null, and returning the ContinueSentinel.
  function maybeInvokeDelegate(delegate, context) {
    var method = delegate.iterator[context.method];
    if (method === undefined) {
      // A .throw or .return when the delegate iterator has no .throw
      // method always terminates the yield* loop.
      context.delegate = null;

      if (context.method === "throw") {
        // Note: ["return"] must be used for ES3 parsing compatibility.
        if (delegate.iterator["return"]) {
          // If the delegate iterator has a return method, give it a
          // chance to clean up.
          context.method = "return";
          context.arg = undefined;
          maybeInvokeDelegate(delegate, context);

          if (context.method === "throw") {
            // If maybeInvokeDelegate(context) changed context.method from
            // "return" to "throw", let that override the TypeError below.
            return ContinueSentinel;
          }
        }

        context.method = "throw";
        context.arg = new TypeError(
          "The iterator does not provide a 'throw' method");
      }

      return ContinueSentinel;
    }

    var record = tryCatch(method, delegate.iterator, context.arg);

    if (record.type === "throw") {
      context.method = "throw";
      context.arg = record.arg;
      context.delegate = null;
      return ContinueSentinel;
    }

    var info = record.arg;

    if (! info) {
      context.method = "throw";
      context.arg = new TypeError("iterator result is not an object");
      context.delegate = null;
      return ContinueSentinel;
    }

    if (info.done) {
      // Assign the result of the finished delegate to the temporary
      // variable specified by delegate.resultName (see delegateYield).
      context[delegate.resultName] = info.value;

      // Resume execution at the desired location (see delegateYield).
      context.next = delegate.nextLoc;

      // If context.method was "throw" but the delegate handled the
      // exception, let the outer generator proceed normally. If
      // context.method was "next", forget context.arg since it has been
      // "consumed" by the delegate iterator. If context.method was
      // "return", allow the original .return call to continue in the
      // outer generator.
      if (context.method !== "return") {
        context.method = "next";
        context.arg = undefined;
      }

    } else {
      // Re-yield the result returned by the delegate method.
      return info;
    }

    // The delegate iterator is finished, so forget it and continue with
    // the outer generator.
    context.delegate = null;
    return ContinueSentinel;
  }

  // Define Generator.prototype.{next,throw,return} in terms of the
  // unified ._invoke helper method.
  defineIteratorMethods(Gp);

  define(Gp, toStringTagSymbol, "Generator");

  // A Generator should always return itself as the iterator object when the
  // @@iterator function is called on it. Some browsers' implementations of the
  // iterator prototype chain incorrectly implement this, causing the Generator
  // object to not be returned from this call. This ensures that doesn't happen.
  // See https://github.com/facebook/regenerator/issues/274 for more details.
  define(Gp, iteratorSymbol, function() {
    return this;
  });

  define(Gp, "toString", function() {
    return "[object Generator]";
  });

  function pushTryEntry(locs) {
    var entry = { tryLoc: locs[0] };

    if (1 in locs) {
      entry.catchLoc = locs[1];
    }

    if (2 in locs) {
      entry.finallyLoc = locs[2];
      entry.afterLoc = locs[3];
    }

    this.tryEntries.push(entry);
  }

  function resetTryEntry(entry) {
    var record = entry.completion || {};
    record.type = "normal";
    delete record.arg;
    entry.completion = record;
  }

  function Context(tryLocsList) {
    // The root entry object (effectively a try statement without a catch
    // or a finally block) gives us a place to store values thrown from
    // locations where there is no enclosing try statement.
    this.tryEntries = [{ tryLoc: "root" }];
    tryLocsList.forEach(pushTryEntry, this);
    this.reset(true);
  }

  exports.keys = function(object) {
    var keys = [];
    for (var key in object) {
      keys.push(key);
    }
    keys.reverse();

    // Rather than returning an object with a next method, we keep
    // things simple and return the next function itself.
    return function next() {
      while (keys.length) {
        var key = keys.pop();
        if (key in object) {
          next.value = key;
          next.done = false;
          return next;
        }
      }

      // To avoid creating an additional object, we just hang the .value
      // and .done properties off the next function object itself. This
      // also ensures that the minifier will not anonymize the function.
      next.done = true;
      return next;
    };
  };

  function values(iterable) {
    if (iterable) {
      var iteratorMethod = iterable[iteratorSymbol];
      if (iteratorMethod) {
        return iteratorMethod.call(iterable);
      }

      if (typeof iterable.next === "function") {
        return iterable;
      }

      if (!isNaN(iterable.length)) {
        var i = -1, next = function next() {
          while (++i < iterable.length) {
            if (hasOwn.call(iterable, i)) {
              next.value = iterable[i];
              next.done = false;
              return next;
            }
          }

          next.value = undefined;
          next.done = true;

          return next;
        };

        return next.next = next;
      }
    }

    // Return an iterator with no values.
    return { next: doneResult };
  }
  exports.values = values;

  function doneResult() {
    return { value: undefined, done: true };
  }

  Context.prototype = {
    constructor: Context,

    reset: function(skipTempReset) {
      this.prev = 0;
      this.next = 0;
      // Resetting context._sent for legacy support of Babel's
      // function.sent implementation.
      this.sent = this._sent = undefined;
      this.done = false;
      this.delegate = null;

      this.method = "next";
      this.arg = undefined;

      this.tryEntries.forEach(resetTryEntry);

      if (!skipTempReset) {
        for (var name in this) {
          // Not sure about the optimal order of these conditions:
          if (name.charAt(0) === "t" &&
              hasOwn.call(this, name) &&
              !isNaN(+name.slice(1))) {
            this[name] = undefined;
          }
        }
      }
    },

    stop: function() {
      this.done = true;

      var rootEntry = this.tryEntries[0];
      var rootRecord = rootEntry.completion;
      if (rootRecord.type === "throw") {
        throw rootRecord.arg;
      }

      return this.rval;
    },

    dispatchException: function(exception) {
      if (this.done) {
        throw exception;
      }

      var context = this;
      function handle(loc, caught) {
        record.type = "throw";
        record.arg = exception;
        context.next = loc;

        if (caught) {
          // If the dispatched exception was caught by a catch block,
          // then let that catch block handle the exception normally.
          context.method = "next";
          context.arg = undefined;
        }

        return !! caught;
      }

      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        var record = entry.completion;

        if (entry.tryLoc === "root") {
          // Exception thrown outside of any try block that could handle
          // it, so set the completion value of the entire function to
          // throw the exception.
          return handle("end");
        }

        if (entry.tryLoc <= this.prev) {
          var hasCatch = hasOwn.call(entry, "catchLoc");
          var hasFinally = hasOwn.call(entry, "finallyLoc");

          if (hasCatch && hasFinally) {
            if (this.prev < entry.catchLoc) {
              return handle(entry.catchLoc, true);
            } else if (this.prev < entry.finallyLoc) {
              return handle(entry.finallyLoc);
            }

          } else if (hasCatch) {
            if (this.prev < entry.catchLoc) {
              return handle(entry.catchLoc, true);
            }

          } else if (hasFinally) {
            if (this.prev < entry.finallyLoc) {
              return handle(entry.finallyLoc);
            }

          } else {
            throw new Error("try statement without catch or finally");
          }
        }
      }
    },

    abrupt: function(type, arg) {
      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        if (entry.tryLoc <= this.prev &&
            hasOwn.call(entry, "finallyLoc") &&
            this.prev < entry.finallyLoc) {
          var finallyEntry = entry;
          break;
        }
      }

      if (finallyEntry &&
          (type === "break" ||
           type === "continue") &&
          finallyEntry.tryLoc <= arg &&
          arg <= finallyEntry.finallyLoc) {
        // Ignore the finally entry if control is not jumping to a
        // location outside the try/catch block.
        finallyEntry = null;
      }

      var record = finallyEntry ? finallyEntry.completion : {};
      record.type = type;
      record.arg = arg;

      if (finallyEntry) {
        this.method = "next";
        this.next = finallyEntry.finallyLoc;
        return ContinueSentinel;
      }

      return this.complete(record);
    },

    complete: function(record, afterLoc) {
      if (record.type === "throw") {
        throw record.arg;
      }

      if (record.type === "break" ||
          record.type === "continue") {
        this.next = record.arg;
      } else if (record.type === "return") {
        this.rval = this.arg = record.arg;
        this.method = "return";
        this.next = "end";
      } else if (record.type === "normal" && afterLoc) {
        this.next = afterLoc;
      }

      return ContinueSentinel;
    },

    finish: function(finallyLoc) {
      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        if (entry.finallyLoc === finallyLoc) {
          this.complete(entry.completion, entry.afterLoc);
          resetTryEntry(entry);
          return ContinueSentinel;
        }
      }
    },

    "catch": function(tryLoc) {
      for (var i = this.tryEntries.length - 1; i >= 0; --i) {
        var entry = this.tryEntries[i];
        if (entry.tryLoc === tryLoc) {
          var record = entry.completion;
          if (record.type === "throw") {
            var thrown = record.arg;
            resetTryEntry(entry);
          }
          return thrown;
        }
      }

      // The context.catch method must only be called with a location
      // argument that corresponds to a known catch block.
      throw new Error("illegal catch attempt");
    },

    delegateYield: function(iterable, resultName, nextLoc) {
      this.delegate = {
        iterator: values(iterable),
        resultName: resultName,
        nextLoc: nextLoc
      };

      if (this.method === "next") {
        // Deliberately forget the last sent value so that we don't
        // accidentally pass it on to the delegate.
        this.arg = undefined;
      }

      return ContinueSentinel;
    }
  };

  // Regardless of whether this script is executing as a CommonJS module
  // or not, return the runtime object so that we can declare the variable
  // regeneratorRuntime in the outer scope, which allows this module to be
  // injected easily by `bin/regenerator --include-runtime script.js`.
  return exports;

}(
  // If this script is executing as a CommonJS module, use module.exports
  // as the regeneratorRuntime namespace. Otherwise create a new empty
  // object. Either way, the resulting object will be used to initialize
  // the regeneratorRuntime variable at the top of this file.
   true ? module.exports : 0
));

try {
  regeneratorRuntime = runtime;
} catch (accidentalStrictMode) {
  // This module should not be running in strict mode, so the above
  // assignment should always work unless something is misconfigured. Just
  // in case runtime.js accidentally runs in strict mode, in modern engines
  // we can explicitly access globalThis. In older engines we can escape
  // strict mode using a global Function call. This could conceivably fail
  // if a Content Security Policy forbids using Function, but in that case
  // the proper solution is to fix the accidental strict mode problem. If
  // you've misconfigured your bundler to force strict mode and applied a
  // CSP to forbid Function, and you're not willing to fix either of those
  // problems, please detail your unique predicament in a GitHub issue.
  if (typeof globalThis === "object") {
    globalThis.regeneratorRuntime = runtime;
  } else {
    Function("r", "regeneratorRuntime = r")(runtime);
  }
}


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be in strict mode.
(() => {
"use strict";
/*!*************************************************!*\
  !*** ./Resources/assets/js/candidate/record.js ***!
  \*************************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
 // Class definition



function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

var RecordVideo = function () {
  var max_retry = 10;
  var block_size = 194304;
  var max_threads = 4;
  var maxloop = 0;
  var uploadWorker = new Worker('/js/candidate/uploadWorker.js');
  var curr_threads = 0;
  var logs = [];
  var stack = [];
  var ajaxData = [];
  var intervalId = null;
  var formSubmitButton;
  var stepperform;

  uploadWorker.onmessage = function (e) {
    console.log(e.data);
    var _e$data = e.data,
        status = _e$data.status,
        file = _e$data.file,
        index = _e$data.index,
        retry = _e$data.retry,
        block = _e$data.block,
        file_name = _e$data.file_name,
        stepconstid = _e$data.stepconstid;
    curr_threads--;
    console.log('status', status);
    console.log('stepid', stepconstid);

    if (!status) {
      stack.push({
        file: file,
        index: index,
        retry: retry,
        stepconstid: stepconstid
      });
      console.log('stack push ');
      console.log(stack);
    } else {
      logs[block] = true;
      ajaxData['data'] = {
        file_name: file_name,
        stepconstid: stepconstid
      };
      console.log('check function call ');
      console.log(logs);
      check();
    }
  };

  var loadcurstep_id = document.querySelector(".current").getAttribute("data-stepid");
  var stepid = loadcurstep_id;
  savecandidatelog('question_' + stepid);
  console.log(stepid);
  var countdown = 3;
  $('#stremdiv_' + stepid).html('<video id="streamVideo_' + stepid + '" playsinline autoplay muted width="100%" height="auto" class="no-mirror"> </video>');
  $('#viddiv_' + stepid).html('<video id="playvideo_' + stepid + '"  width="100%" height="auto"> </video>');
  var stepper = document.querySelector("#kt_stepper_example_basic1");
  var stepperobj = new KTStepper(stepper);
  var totalstep = stepperobj.totalStepsNumber;
  console.log('total step ' + totalstep);
  stepperobj.goTo(stepid);

  if (totalstep == stepperobj.getCurrentStepIndex()) {
    $('#submitrecord').css('display', 'block');
    $('#submitrecord').css('pointer-events', 'auto');
  } else {
    $('#submitrecord').css('display', 'none');
    $('#submitrecord').css('pointer-events', 'none');
  }

  stepperobj.on("kt.stepper.next", function (stepper) {
    console.log('total next ' + stepperobj.getCurrentStepIndex());
    stepperobj.goNext();
    streamVideo();
  });
  stepperobj.on("kt.stepper.change", function () {
    console.log('total change ' + stepperobj.getCurrentStepIndex());
    var curntstep = stepperobj.getCurrentStepIndex();
    stepid = stepperobj.getCurrentStepIndex() + 1;
    savecandidatelog('question_' + stepid);
    $('#viddiv_' + curntstep).html('');
    $('#stremdiv_' + curntstep).html('');
    $('#viddiv_' + stepid).html('<video id="playvideo_' + stepid + '"  width="100%" height="auto" > </video>');
    $('#stremdiv_' + stepid).html('<video id="streamVideo_' + stepid + '" playsinline autoplay muted width="100%" height="auto" class="no-mirror"> </video>');
    $('.stoprecord').prop('disabled', true);
    $('.stoprecord').css('display', 'none');
    $('.stoprecord').removeClass('btn-danger');
    $('.stoprecord').addClass('btn-dark');
    $('.startrecord').prop('disabled', false);
    $('.startrecord').css('display', '');
    $('.startfunction').show();
    $('.completefunction').hide();
    countdown = 3;

    if (totalstep == stepid) {
      $('#submitrecord').css('display', 'block');
      $('#submitrecord').css('pointer-events', 'auto');
    }
  });
  stepperobj.on("kt.stepper.previous", function (stepper) {
    stepperobj.goPrevious();
  });
  var streamBlock = document.querySelector("#streamBlock_" + stepid);
  var playBlock = document.querySelector("#playvideo_" + stepid);
  var StrblockUI;
  var recordButton = document.querySelector('button#record_' + stepid);
  var IntrcountDwn;
  var timerInterval; // const mimeType = 'video/webm;codecs=h264,opus';

  var newmimeType;
  var mediaRecorder; // let recordedBlobs;

  var recordedBlobs = [];
  var fineshedTime;
  var reTake = 0;
  var playvideo_source;
  var overlaytarget = document.querySelector("#kt_content_container");
  var overlayblockUI = new KTBlockUI(overlaytarget, {
    message: '<div class="blockui-message"><span class="spinner-border text-primary"></span><span class="process_content">Processing Video</span></div>'
  }); // new 

  var chunkCount = 0;
  var successfulUploads = 0;
  var totalChunks = 0;
  var start = 0;
  var pendingChunks = new Map();
  var filename; // Replace with your actual filename

  var stepconstid;
  var mimeType = 'video/mp4; codecs="avc1.42E01E, mp4a.40.2"';
  var chunkmimedatatype = ''; // new end

  var extension = '.mp4';
  var userAgent = navigator.userAgent || navigator.vendor || window.opera;
  console.log('userAgent');
  console.log(userAgent); // alert(userAgent);

  if (/iPad|iPhone|iPod|Macintosh/.test(userAgent)) {
    // iOS or macOS
    mimeType = 'video/mp4; codecs="avc1.42E01E, mp4a.40.2"';
    extension = '.mp4';
  } else if (/Windows/.test(userAgent)) {
    // Windows
    mimeType = 'video/webm; codecs=vp8, opus';
    extension = '.webm';
  } else {
    // Default to MP4 if the OS is not identified (e.g., Linux or other systems)
    mimeType = 'video/webm; codecs=vp8, opus';
    extension = '.webm';
  }

  console.log(extension);

  var startTimer = function startTimer() {
    var timemin = $('.countdown_' + stepid).attr('data-timecount');
    var minsec = $('.countdown_' + stepid).attr('data-minsec');
    var timer2 = timemin + ":01";
    var secondsinc_count = 0;
    timerInterval = setInterval(function () {
      var timer = timer2.split(':');
      var minutes = parseInt(timer[0], 10);
      var seconds = parseInt(timer[1], 10);
      --seconds;
      secondsinc_count++;
      minutes = seconds < 0 ? --minutes : minutes;
      seconds = seconds < 0 ? 59 : seconds;
      seconds = seconds < 10 ? '0' + seconds : seconds;

      if (secondsinc_count >= minsec) {
        $('.stoprecord').prop('disabled', false);
        $('.stoprecord').removeClass('btn-dark');
        $('.stoprecord').addClass('btn-danger');
      }

      $('#recorded_sec_' + stepid).val(secondsinc_count);
      $('.countdown_' + stepid).html(' ' + minutes + 'M ' + seconds + 'S');

      if (seconds <= 0 && minutes <= 0) {
        clearInterval(timerInterval);
        stopRecording();
      }

      timer2 = minutes + ':' + seconds;
    }, 1000);
  };

  var recordCountDown = function recordCountDown() {
    $('#counter_' + stepid).show();

    if (countdown == 0) {
      clearInterval(IntrcountDwn);
      startRecording();
    } else {
      document.getElementById("counter_" + stepid).innerHTML = countdown;
    }

    countdown = countdown - 1;
  };

  var startRecording = function startRecording() {
    recordedBlobs = [];
    $('#msg').hide();

    try {
      mediaRecorder = new MediaRecorder(window.stream, {
        mimeType: mimeType,
        videoBitsPerSecond: 1500000,
        // Lower bitrate for compatibility
        audioBitsPerSecond: 96000 // Standard bitrate for AAC

      });
    } catch (e) {
      console.error('Exception while creating MediaRecorder:', e);
      return;
    } //test


    mediaRecorder.start(1000);

    mediaRecorder.onstop = /*#__PURE__*/function () {
      var _ref = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee(event) {
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                _context.next = 2;
                return confirmAllChunksUploaded();

              case 2:
                recordplay();
                console.log('Recorder stopped: ', event);
                console.log('Recorded Blobs: ', recordedBlobs);

              case 5:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }));

      return function (_x) {
        return _ref.apply(this, arguments);
      };
    }();

    mediaRecorder.onstart = function (event) {
      // test
      // mimeType = mediaRecorder.mimeType || 'video/webm';
      // let extension;
      // // mimeType = 'video/mp4'
      // extension = '.mp4';
      var timedisplay = $('.countdown_' + stepid).attr('data-timedisplay');
      $('#counter_' + stepid).hide();
      $('.startrecord').hide();
      $('#streamBlock_' + stepid).removeClass('overlay-block');
      $('.countdown_' + stepid).html(timedisplay);
      $('.timecount_' + stepid).css('display', 'block');
      $('.stoprecord').css('display', '');
      startTimer();
      var today = new Date();
      var year = today.getFullYear();
      var month = today.getMonth() + 1;
      var d = today.getDate();
      var hour = today.getHours();
      var mins = today.getMinutes();
      var sec = today.getSeconds();
      var randvalue = Math.floor(Math.random() * 100000 + 1); // filename = year + '' + month + '' + d + '' + hour + '' + mins + '' + sec + '' + randvalue + ".mp4";

      filename = "".concat(year).concat(month).concat(d).concat(hour).concat(mins).concat(sec).concat(randvalue).concat(extension);
      stepconstid = stepid;
      console.log('stepconstid', stepconstid);
      console.log('filename', filename);
    }; // mediaRecorder.ondataavailable = handleDataAvailable;


    mediaRecorder.ondataavailable = function (event) {
      if (event.data && event.data.size > 0) {
        // pendingChunks.push({ data: event.data, start });
        // sendChunkToServer(event.data, start, filename, stepconstid);
        // start += event.data.size;
        var chunk = {
          data: event.data,
          start: start,
          filename: filename,
          stepconstid: stepconstid
        };
        console.log(chunk);
        pendingChunks.set(start, chunk);
        sendChunkToServer(chunk);
        start += event.data.size;
        console.log('MIME type:', chunk.data.type);
        chunkmimedatatype = chunk.data.type;
      }
    };

    function sendChunkToServer(chunk) {
      var formData = new FormData();
      formData.append('blob', chunk.data);
      formData.append('start', chunk.start);
      formData.append('filename', chunk.filename);
      formData.append('stepconstid', chunk.stepconstid);
      formData.append('api_token', $('#auth_token_' + chunk.stepconstid).val());
      formData.append('cid', $('#cid_' + chunk.stepconstid).val());
      formData.append('qid', $('#qid_' + chunk.stepconstid).val());
      $.ajax({
        url: '/api/savevideo',
        // Your server endpoint
        type: 'POST',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: formData,
        processData: false,
        contentType: false,
        success: function success(data) {
          if (data.status === true) {
            console.log('Chunk uploaded successfully:', data);
            pendingChunks["delete"](chunk.start);
            recordedBlobs.push(chunk.data); // Keep track of uploaded chunks
          } else {
            console.error('Chunk upload failed:', data.message); // Retry uploading the chunk if it failed

            setTimeout(function () {
              return sendChunkToServer(chunk);
            }, 1000);
          }
        },
        error: function error(xhr, status, _error) {
          console.error('Error uploading chunk:', _error); // Retry uploading the chunk in case of error

          setTimeout(function () {
            return sendChunkToServer(chunk);
          }, 1000);
        }
      });
    }

    function confirmAllChunksUploaded() {
      var checkInterval = setInterval(function () {
        if (pendingChunks.size === 0) {
          clearInterval(checkInterval);
          console.log('All chunks have been uploaded successfully.');
          saveFileNameToDatabase(filename, stepconstid);
        } else {
          console.log('Waiting for all chunks to be uploaded...');
        }
      }, 1000); // Check every second
    }

    function saveFileNameToDatabase(filename, stepconstid) {
      // alert(chunkmimedatatype);
      $.ajax({
        url: "/api/savevideoattempt",
        method: "post",
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
          "recorded_sec": $('#recorded_sec_' + stepconstid).val(),
          "cid": $('#cid_' + stepconstid).val(),
          "qid": $('#qid_' + stepconstid).val(),
          "file_name": filename,
          "api_token": $('#auth_token_' + stepconstid).val()
        },
        success: function success(data) {
          console.log('Save video attempt success: ', data);

          if (data.success == '1') {
            // Swal.fire({
            //     icon: 'success',
            //     title: 'Success',
            //     text: 'Video saved successfully!',
            //     customClass: {
            //         confirmButton: "btn btn-success",
            //     }
            // });
            overlayblockUI.release();
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong, Please try again',
              customClass: {
                confirmButton: "btn btn-danger"
              }
            }).then(function () {
              window.location.reload();
            });
          }
        },
        error: function error(xhr, status, _error2) {
          console.error('Error saving video attempt: ', _error2);
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong, Please try again',
            customClass: {
              confirmButton: "btn btn-danger"
            }
          }).then(function () {
            window.location.reload();
          });
        }
      });
    } //   async function sendChunkToServer(chunk) {
    //     const formData = new FormData();
    //     formData.append('blob', chunk.data);
    //     formData.append('start', chunk.start);
    //     formData.append('filename', chunk.filename);
    //     formData.append('stepconstid', chunk.stepconstid);
    //     formData.append('api_token', $('#auth_token_' + stepconstid).val());
    //     formData.append('cid', $('#cid_' + stepconstid).val());
    //     formData.append('qid', $('#qid_' + stepconstid).val());
    //     try {
    //         const response = await fetch('/api/savevideo', { // Update with your server endpoint
    //             method: 'POST',
    //             headers: {
    //               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), // Add CSRF token here
    //           },
    //             body: formData
    //         });
    //         const data = await response.json();
    //         if (data.status === true) {
    //             console.log('Chunk uploaded successfully:', data);
    //             pendingChunks.delete(chunk.start);
    //             recordedBlobs.push(chunk.data); // Keep track of uploaded chunks
    //         } else {
    //             console.error('Chunk upload failed:', data.message);
    //             // Retry uploading the chunk if it failed
    //             setTimeout(() => sendChunkToServer(chunk), 1000);
    //         }
    //     } catch (error) {
    //         console.error('Error uploading chunk:', error);
    //         // Retry uploading the chunk in case of error
    //         setTimeout(() => sendChunkToServer(chunk), 1000);
    //     }
    // }
    // async function confirmAllChunksUploaded() {
    //     while (pendingChunks.size > 0) {
    //         await new Promise(resolve => setTimeout(resolve, 1000)); // Wait for 1 second
    //         console.log('Waiting for all chunks to be uploaded...');
    //     }
    //     console.log('All chunks have been uploaded successfully.');
    //     saveFileNameToDatabase(filename, stepconstid);
    // }
    // function saveFileNameToDatabase(filename, stepconstid) {
    //   $.ajax({
    //       url: "/api/savevideoattempt",
    //       method: "post",
    //       headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), // Add CSRF token here
    //     },
    //       data: {
    //           "recorded_sec": $('#recorded_sec_' + stepconstid).val(),
    //           "cid": $('#cid_' + stepconstid).val(),
    //           "qid": $('#qid_' + stepconstid).val(),
    //           "file_name": filename,
    //           "api_token": $('#auth_token_' + stepconstid).val()
    //       },
    //       success: function(data) {
    //           console.log('Save video attempt success: ', data);
    //           if (data.success == '1') {
    //               Swal.fire({
    //                   icon: 'success',
    //                   title: 'Success',
    //                   text: 'Video saved successfully!',
    //                   customClass: {
    //                       confirmButton: "btn btn-success",
    //                   }
    //               });
    //           } else {
    //               Swal.fire({
    //                   icon: 'error',
    //                   title: 'Oops...',
    //                   text: 'Something went wrong, Please try again',
    //                   customClass: {
    //                       confirmButton: "btn btn-danger",
    //                   }
    //               }).then(() => {
    //                   window.location.reload();
    //               });
    //           }
    //       },
    //       error: function(xhr, status, error) {
    //           console.error('Error saving video attempt: ', error);
    //           Swal.fire({
    //               icon: 'error',
    //               title: 'Oops...',
    //               text: 'Something went wrong, Please try again',
    //               customClass: {
    //                   confirmButton: "btn btn-danger",
    //               }
    //           }).then(() => {
    //               window.location.reload();
    //           });
    //       }
    //   });
    // }

  };

  var stopRecording = function stopRecording() {
    mediaRecorder.stop();
    overlayblockUI.block();
    stream.getVideoTracks()[0].stop();
    stream.getAudioTracks()[0].stop();
    $('.timecount_' + stepid).css('display', 'none');
    $('.startfunction').css('display', 'none');
    var attempt = $('.attempt_' + stepid).attr('data-attempt');

    if (attempt >= 1) {
      attempt = attempt - 1;
    } else {
      attempt = 0;
    }

    $('.attempt_' + stepid).html(attempt);
    $('.attempt_' + stepid).attr('data-attempt', attempt);
    clearInterval(timerInterval);
  };

  var startCountdown = function startCountdown() {
    $('.startrecord').prop('disabled', true);
    IntrcountDwn = setInterval(function () {
      recordCountDown();
    }, 1000);
  };

  var mincount = function mincount() {
    var interval;
    $(document).on("click", ".startrecord", function (e) {
      $('.notrecording_' + stepid).hide();
      startCountdown();
    });
    $(document).on("click", ".stoprecord", function (e) {
      stopRecording();
    });
    $(document).on("click", ".backto_overview_" + stepid, function (e) {
      $.ajax({
        url: "/removesession",
        method: "post"
      }).then(function (response3) {
        window.location.replace('/overview');
      });
    });
    $(document).on("click", ".retakerecord", function (e) {
      reTake = '1';
      savecandidatelog('question_' + stepid + '_retake');
      $('#playblock_' + stepid).hide();
      $('#streamBlock_' + stepid).show();
      $('#streamBlock_' + stepid).addClass('overlay-block');
      $('.completefunction').hide();
      $('.startfunction').show();
      $('.stoprecord').prop('disabled', true);
      $('.stoprecord').removeClass('btn-danger');
      $('.stoprecord').addClass('btn-dark');
      clearInterval(timerInterval);
      streamVideo();
      countdown = 3;
      startCountdown();
    });
  };

  function recordplay() {
    $('#streamBlock_' + stepid).hide();
    $('#playblock_' + stepid).removeClass('d-none');
    $('#playblock_' + stepid).show();
    var superBuffer = new Blob(recordedBlobs, {
      type: mimeType
    });
    playvideo_source = document.getElementById('playvideo_' + stepid);
    playvideo_source.setAttribute('src', window.URL.createObjectURL(superBuffer));
    var attmptleft_cnt = $('.attempt_' + stepid).attr('data-attempt');

    if (attmptleft_cnt <= 0) {
      $('.startfunction').hide();
      $('.submitrecord, .completerecord').removeClass('w-75');
      $('.submitrecord, .completerecord').addClass('w-100');
      $('.mid_div').removeClass('w-25px');
      $('.retakerecord').hide();
    } else {
      $('.submitrecord, .completerecord').removeClass('w-100');
      $('.submitrecord, .completerecord').addClass('w-75');
      $('.mid_div').addClass('w-25px');
      $('.retakerecord').show();
    }

    $('.current').addClass('curntcomplete');
    $('.completefunction').css('display', 'block');
    $(document).on("click", ".videodiv_" + stepid, function (e) {
      $('#playvideo_' + stepid).trigger('play');
      $('#videoplay_' + stepid).css('display', 'none');
      $('#custom-opacity_' + stepid).css('opacity', '0');
      var videoended = document.getElementById("playvideo_" + stepid);

      videoended.onended = function () {
        $('#videoplay_' + stepid).css('display', 'block');
        $('#custom-opacity_' + stepid).css('opacity', '1');
      };
    });
  }

  var completeAllQuestion = function completeAllQuestion() {
    $(document).on("click", "#submitrecord", function (e) {
      var candidate_id = $('#candid_id').val();
      $('#submitrecord').html('Please wait...');
      $('#submitrecord').css('pointer-events', 'none');
      $('#submitrecord').css('display', 'none');
      $('.completefunction').hide();
      $.ajax({
        url: "/updatecompleteqstn",
        method: "post",
        data: {
          "candidate_id": candidate_id
        },
        success: function success(data) {
          savecandidatelog('allquestion_completed');
          $('#submitrecord').html('Submit');

          if (data.success == '1') {
            window.location.replace('/thankyou');
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong, Please try again',
              customClass: {
                confirmButton: "btn btn-danger"
              }
            });
          }
        }
      });
    });
  };

  var setQuestionIndex = function setQuestionIndex() {
    $(document).on("click", ".qstndetail", function (e) {
      var qstn_index = $(this).attr('data-indexid');
      var qstn_url = $(this).attr('data-url');
      $.ajax({
        url: "setqstnsessionindex",
        method: "post",
        data: {
          qstn_index: qstn_index
        }
      }).then(function (response3) {
        window.location.replace(qstn_url);
      });
    });
    $(document).on("click", ".backto_overview", function (e) {
      $.ajax({
        url: "/removesession",
        method: "post"
      }).then(function (response3) {
        window.location.replace('/overview');
      });
    });
  };

  var showLoader = function showLoader(elem) {
    StrblockUI = new KTBlockUI(elem);
    StrblockUI.block();
  };

  var hideLoader = function hideLoader(elem) {
    StrblockUI.release();
  };

  var streamVideo = /*#__PURE__*/function () {
    var _streamVideo = _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().mark(function _callee2() {
      var constraints, _stream;

      return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default().wrap(function _callee2$(_context2) {
        while (1) {
          switch (_context2.prev = _context2.next) {
            case 0:
              _context2.prev = 0;
              constraints = {
                audio: {
                  echoCancellation: {
                    exact: 1
                  }
                },
                video: {
                  width: {
                    ideal: 640
                  },
                  height: {
                    ideal: 480
                  },
                  frameRate: {
                    ideal: 15,
                    max: 15
                  }
                }
              };
              _context2.next = 4;
              return navigator.mediaDevices.getUserMedia(constraints);

            case 4:
              _stream = _context2.sent;
              handleSuccess(_stream);
              _context2.next = 11;
              break;

            case 8:
              _context2.prev = 8;
              _context2.t0 = _context2["catch"](0);
              Swal.fire({
                text: "We're having trouble connecting to your hardwares, Please try again or switch to a different device.",
                icon: "warning",
                buttonsStyling: true,
                confirmButtonText: "Ok",
                customClass: {
                  confirmButton: "btn btn-danger"
                }
              }).then(function (willDelete) {
                $.ajax({
                  url: "/runtestsession",
                  method: "post",
                  data: {
                    runtest: ''
                  }
                }).then(function (data) {
                  window.location = "/overview";
                });
              });

            case 11:
              $(document).on("click", "#send", function (e) {
                uploadtest();
              });

            case 12:
            case "end":
              return _context2.stop();
          }
        }
      }, _callee2, null, [[0, 8]]);
    }));

    function streamVideo() {
      return _streamVideo.apply(this, arguments);
    }

    return streamVideo;
  }();

  var handleDataAvailable = function handleDataAvailable(event) {
    newmimeType = event.data.type;

    if (event.data && event.data.size > 0) {
      recordedBlobs.push(event.data);
      uploadtest();
      recordplay();
    }
  };

  var savevideo = function savevideo() {
    var blobfile = new Blob(recordedBlobs, {
      type: 'video/webm'
    });
    var formData = new FormData();
    formData.append('video-blob', blobfile);
    formData.append('cid', $('#cid_' + stepid).val());
    formData.append('api_token', $('#auth_token_' + stepid).val());
    formData.append('qid', $('#qid_' + stepid).val());
    $.ajax({
      type: 'POST',
      url: '/api/savevideo',
      enctype: 'multipart/form-data',
      data: formData,
      processData: false,
      contentType: false,
      beforeSend: function beforeSend() {// toastr.success("Downloading Video");
      }
    }).done(function (data) {
      $('.attempt_' + stepid).html(data.attempt_left);
      overlayblockUI.release();

      if (data.attempt_left <= 0) {
        $('.startfunction').hide();
        $('.submitrecord, .completerecord').removeClass('w-75');
        $('.submitrecord, .completerecord').addClass('w-100');
        $('.mid_div').removeClass('w-25px');
        $('.retakerecord').hide();
      } else {
        $('.submitrecord, .completerecord').removeClass('w-100');
        $('.submitrecord, .completerecord').addClass('w-75');
        $('.mid_div').addClass('w-25px');
        $('.retakerecord').show();
      }

      $('.completefunction').css('display', 'block');
    });
  };

  var handleSuccess = function handleSuccess(stream) {
    window.stream = stream;
    var strvid = document.querySelector('video#streamVideo_' + stepid);
    strvid.srcObject = stream;
    $('.notrecording_' + stepid).hide();

    if (reTake == '0') {
      $('.notrecording_' + stepid).show();
    }
  };

  var uploadtest = function uploadtest() {
    var result = [];
    var resultCount = 0;
    var today = new Date();
    var year = today.getFullYear();
    var month = today.getMonth() + 1;
    var d = today.getDate();
    var hour = today.getHours();
    var mins = today.getMinutes();
    var sec = today.getSeconds();
    var randvalue = Math.floor(Math.random() * 100000 + 1);
    var filname = year + '' + month + '' + d + '' + hour + '' + mins + '' + sec + '' + randvalue;
    var file = new File(recordedBlobs, filname + ".mp4", {
      type: newmimeType
    });
    var stepidconst = document.querySelector(".current").getAttribute("data-stepid");
    var max = Math.ceil(file.size / block_size);
    maxloop = max;

    for (var i = 0; i < max; i++) {
      logs[i] = false;
    }

    for (var i = 0; i < max; i++) {
      stack.push({
        file: file,
        index: i,
        retry: 0
      });
    }

    intervalId = setInterval(function () {
      loopAjax(stepidconst);
    }, 10);
  };

  var sendAjax = function sendAjax(file, index, retry) {
    curr_threads++;

    if (retry > max_retry) {
      console.log('failed index ' + index);
      return;
    }

    var blob = file.slice(block_size * index, block_size * (index + 1));
    var fd = new FormData();
    fd.append('filename', file.name);
    fd.append('start', block_size * index);
    fd.append('size', file.size);
    fd.append('block', index);
    fd.append('blob', blob);
    fd.append('retry', retry);
    fd.append('cid', $('#cid_' + stepid).val());
    fd.append('api_token', $('#auth_token_' + stepid).val());
    fd.append('qid', $('#qid_' + stepid).val());
    fd.append('maxloop', maxloop);
    $.ajax({
      type: 'post',
      data: fd,
      processData: false,
      contentType: false,
      dataType: 'json',
      url: '/api/savevideo',
      success: function success(data) {
        curr_threads--;

        if (!data.status) {
          pushAjax(file, index, retry + 1);
        } else {
          logs[data.block] = true;
          ajaxData['data'] = data;
          check();
        }
      },
      error: function error() {
        curr_threads--;
        pushAjax(file, index, retry + 1);
      }
    });
  };

  var loopAjax = function loopAjax(stepidconst) {
    console.log('loopajax run');
    console.log("stepidconst ", stepidconst);

    if (curr_threads < max_threads) {
      var task = stack.shift();

      if (task) {
        curr_threads++;
        task.block_size = block_size;
        task.max_retry = max_retry;
        task.api_data = {
          cid: $('#cid_' + stepidconst).val(),
          api_token: $('#auth_token_' + stepid).val(),
          qid: $('#qid_' + stepidconst).val(),
          maxloop: maxloop,
          stepid: stepidconst
        };
        uploadWorker.postMessage(task);
      }
    }
  };

  var check = function check() {
    var dataajax = ajaxData['data'];
    var status = true;
    console.log(logs);
    $.each(logs, function (index, value) {
      if (!value) {
        status = false;
        return false;
      }
    });

    if (status) {
      clearInterval(intervalId);
      $.ajax({
        url: "/api/savevideoattempt",
        method: "post",
        data: {
          "recorded_sec": $('#recorded_sec_' + dataajax.stepconstid).val(),
          "cid": $('#cid_' + dataajax.stepconstid).val(),
          "qid": $('#qid_' + dataajax.stepconstid).val(),
          "file_name": dataajax.file_name,
          "api_token": $('#auth_token_' + stepid).val()
        },
        success: function success(data) {
          console.log('success check function ');
          console.log(data);

          if (data.success == '1') {
            if (totalstep == stepid) {// overlayblockUI.release();
            }
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Something went wrong, Please try again',
              customClass: {
                confirmButton: "btn btn-danger"
              }
            }).then(function (willDelete) {
              window.location.reload();
            });
          }
        }
      });
    }
  };

  return {
    init: function init() {
      mincount();
      streamVideo();
      completeAllQuestion();
    }
  };
}();

KTUtil.onDOMContentLoaded(function () {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": true,
    "progressBar": false,
    "positionClass": "toastr-top-center",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "300",
    "timeOut": "1000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
  };
  RecordVideo.init();
});

function savecandidatelog(action) {
  var width = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
  var height = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
  var screenresolution = width + ' x ' + height;
  var currentURL = window.location.href;
  var candidate_id = $('#candid_id').val();
  fetch('https://api.ipify.org/?format=json').then(function (response) {
    return response.json();
  }).then(function (data) {
    var clientIP = data.ip;
    console.log("Client IP Address: " + clientIP);
    $.ajax({
      url: "/savecandidatelog",
      method: "post",
      data: {
        "screenresolution": screenresolution,
        action: action,
        currentURL: currentURL,
        candidate_id: candidate_id,
        clientIP: clientIP
      },
      success: function success(data) {
        if (data.success == '1') {
          console.log('saved');
        } else {
          console.log('not saved');
        }
      }
    });
  });
}
})();

/******/ })()
;