var pjax = new Pjax({
    elements: "a",
    selectors: [".app", "title"],
    cacheBust: true
  });
$(document).on('pjax:send', function() {NProgress.configure({ showSpinner: false }); NProgress.start(); });
$(document).on('pjax:complete',   function() { NProgress.done();  });