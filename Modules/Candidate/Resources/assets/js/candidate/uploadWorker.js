self.addEventListener('message', function(e) {
    const { file, index, retry, block_size, max_retry, api_data } = e.data;
  
    const blob = file.slice(block_size * index, block_size * (index + 1));
    const fd = new FormData();
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
    }).then(response => response.json())
      .then(data => {
        if (!data.status && retry < max_retry) {
          self.postMessage({ status: false, file, index, retry: retry + 1, block_size, max_retry, api_data });
        } else {
          self.postMessage({ status: true, block: data.block, file_name: data.file_name, stepconstid: data.stepconstid });
        }
      }).catch(() => {
        if (retry < max_retry) {
          self.postMessage({ status: false, file, index, retry: retry + 1, block_size, max_retry, api_data });
        } else {
          console.log('Failed index ' + index);
        }
      });
  });
  