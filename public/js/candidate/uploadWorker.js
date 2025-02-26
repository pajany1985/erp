/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*******************************************************!*\
  !*** ./Resources/assets/js/candidate/uploadWorker.js ***!
  \*******************************************************/
self.addEventListener('message', function (e) {
  var _e$data = e.data,
      file = _e$data.file,
      index = _e$data.index,
      retry = _e$data.retry,
      block_size = _e$data.block_size,
      max_retry = _e$data.max_retry,
      api_data = _e$data.api_data;
  var blob = file.slice(block_size * index, block_size * (index + 1));
  var fd = new FormData();
  fd.append('filename', file.name);
  fd.append('start', block_size * index);
  fd.append('size', file.size);
  fd.append('block', index);
  fd.append('blob', blob);
  fd.append('retry', retry);
  fd.append('cid', api_data.cid);
  fd.append('api_token', api_data.api_token);
  fd.append('qid', api_data.qid);
  fd.append('maxloop', api_data.maxloop);
  fd.append('stepconstid', api_data.stepid);
  fetch('/api/savevideo', {
    method: 'POST',
    body: fd
  }).then(function (response) {
    return response.json();
  }).then(function (data) {
    if (!data.status && retry < max_retry) {
      self.postMessage({
        status: false,
        file: file,
        index: index,
        retry: retry + 1,
        block_size: block_size,
        max_retry: max_retry,
        api_data: api_data
      });
    } else {
      self.postMessage({
        status: true,
        block: data.block,
        file_name: data.file_name,
        stepconstid: data.stepconstid
      });
    }
  })["catch"](function () {
    if (retry < max_retry) {
      self.postMessage({
        status: false,
        file: file,
        index: index,
        retry: retry + 1,
        block_size: block_size,
        max_retry: max_retry,
        api_data: api_data
      });
    } else {
      console.log('Failed index ' + index);
    }
  });
});
/******/ })()
;