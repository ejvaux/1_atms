var pjax = new Pjax({
    elements: "a",
    selectors: ["title", "#app","#main_panel"],
    cacheBust: true,
  });
$(document).on('pjax:send', function() {NProgress.configure({ showSpinner: false }); NProgress.start(); });
$(document).on('pjax:complete',   function() { NProgress.done();  });

$(document).on({
  ajaxStart: function() { NProgress.configure({ showSpinner: false }); NProgress.start(); },   
  ajaxStop: function() { NProgress.done() }    
});