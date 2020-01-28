//import Vue from 'vue'
//import App from '/resources/templates/administrator/pages/desktop/App'
//import axios from 'axios'
//import VueAxios from 'vue-axios'

//Vue.use(VueAxios, axios);
//var App = require('/resources/templates/administrator/pages/desktop/App');
Vue.config.productionTip = false;

new Vue({
    render: h => h(App),
}).$mount('#app');
/*const domain = 'http://clearsky/';

new Vue({
    el: "#app",
    data: {
        message: "Hello World",
        surname: '',
        firstName: '',
        secondName: '',
    },
    mounted: function () {
        this.getContacts().then(data => {
            this.surname = data.surname;
            this.firstName = data.firstName;
            this.secondName = data.secondName;
        });
        this.showInfo();
    },
    methods: {
        showInfo: function(){
            console.log('message');
        },
        getContacts: function(){
            return axios.get(domain+'/app/patient-card/get/1')
                .then(function (response) {
                    return response.data.card_data;

                })
                .catch(function (error) {
                    console.log(error);
                });

        }
    }
})*/