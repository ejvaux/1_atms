
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
        Echo.channel('notification.refresh')
        .listen('triggerEvent', (e) => {
            console.log(e);
            $.ajax({
                type: 'get',
                url: "/1_atms/public/ddmenu",
                global: false,
                success: function (data) {
                    $('#notificon').html(data);
                }
              });                    
        });
        /* Echo.private('notification')
        .listen('NotificationTask', (e) => {
            console.log(e);
        }); */
        Echo.private(`App.User.` + document.head.querySelector('meta[name="userid"]').content)
        .notification((notification) => {
            console.log(notification.type);
            /* $('#nvbr').load('/1_atms/public/nvbr'); */
            /* $('#notificon').load('/1_atms/public/ddmenu'); */
            $.ajax({
                type: 'get',
                url: "/1_atms/public/ddmenu",
                global: false,
                success: function (data) {
                    $('#notificon').html(data);
                }
            });
        });        
    }
});

var $ = require("jquery");

require('select2');
window.iziToast = require('izitoast');
window.NProgress = require('nprogress');
window.swal = require('sweetalert2');