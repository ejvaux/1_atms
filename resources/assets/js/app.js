
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));

const app = new Vue({
    el: '#app',
    created(){
        Echo.channel('primatech')
        .listen('triggerEvent', (e) => {
            console.log(e);
            $.ajax({
                type: 'get',
                url: "/1_atms/public/nvbr",
                global: false,
                success: function (data) {
                    $('#nvbr').html(data);
                }
              });            
            /* alert(e.message.message);
            alert(e.message.mod);
            alert(e.message.tid); */
            /* document.getElementById('notificon').append('<a value="option6">option6</a>'); */            
        });
        /* var userid = $('meta[name="userid"]').attr('content'); */
        /* var userid = document.querySelector("meta[name='userid']").getAttribute("content");
        Echo.channel('App.User.' + userid)
            .notification((notification) => {
            console.log(notification.type);
        }); */
    }
});

var $ = require("jquery");

require('select2');
window.iziToast = require('izitoast');
window.NProgress = require('nprogress');
window.swal = require('sweetalert2');