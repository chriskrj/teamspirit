'use strict';

const youtubeInject = (() => {

  let videosInjected = false;
  const injectVideos = () => {

    if(!videosInjected) {
      videosInjected = true;
      // console.log('add youtube videos');

      const youtubeVideos = document.querySelectorAll('.js-youtubeinject');

      youtubeVideos.forEach(video => {
        const url = video.dataset.url;

        const container = document.createElement('div');
        container.className = 'Video-container';

        const iframe = document.createElement('iframe');
        iframe.src = url;
        iframe.allowFullscreen = true;
        iframe.className = 'Video-iframe';
        iframe.allow = 'fullscreen';
        iframe.width = '480';
        iframe.height = '270';

        container.appendChild(iframe);
        video.parentNode.replaceChild(container, video);
      });
    }
  };

  const initialize = () => {
    // console.log('initialize youtube inject');

    document.addEventListener('cookieconsent/update', event => {
      if( event.detail.youtube ) {
        injectVideos();
      }
    });
  };

  return {
    initialize
  };
})();

export default youtubeInject;
