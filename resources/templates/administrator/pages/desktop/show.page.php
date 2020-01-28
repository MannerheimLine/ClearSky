<div id="app">
    <h3>{{ message }}</h3>
    <p>{{ surname }}</p>
    <p>{{ firstName }}</p>
    <p>{{ secondName }}</p>
    <input type="text" v-model="message">
</div>
<script type="application/javascript" src="/resources/assets/vue/vue.js"></script>
<script type="application/javascript" src="/resources/assets/axios/axios.js"></script>
<!--<script type="application/javascript" src="/resources/templates/administrator/pages/desktop/main.js"></script>-->
<script>
    const domain = 'http://192.168.0.10';
    new Vue({
        el: "#app",
        data: {
            message: "Hello World",
            surname: '',
            firstName: '',
            secondName: '',
        },
        mounted: function () {
            //console.log(this.getContacts());
            this.getContacts().then(data => {
                this.surname = data.surname;
                this.firstName = data.firstName;
                this.secondName = data.secondName;
            });
        },
        methods: {
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
    })

</script>