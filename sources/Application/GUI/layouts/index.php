<?php ?>

<!--<script src="https://unpkg.com/vue"></script>-->
<html>
    <head>
        <meta charset="utf-8">
        <script src="https://cdn.jsdelivr.net/npm/vue@2.6.10/dist/vue.js"></script>
    </head>
    <body>
    <div id="app">
        <p>{{ message }}</p>
    </div>
    <script>
        var app = new Vue({
            el: '#app',
            data: {
                message: 'Привет, Vue!'
            }
        })
    </script>
    <div id="app-4">
        <ol>
            <li v-for="todo in todos">
                {{ todo.text }}
            </li>
        </ol>
    </div>

    <script>
        var app4 = new Vue({
            el: '#app-4',
            data: {
                todos: [
                    { text: 'Изучить JavaScript' },
                    { text: 'Изучить Vue' },
                    { text: 'Создать что-нибудь классное' }
                ]
            }
        })
    </script>

    <div id="app-5">
        <p>{{ message }}</p>
        <button v-on:click="reverseMessage">Перевернуть сообщение</button>
    </div>

    <script>
        var app5 = new Vue({
            el: '#app-5',
            data: {
                message: 'Привет, Vue.js!'
            },
            methods: {
                reverseMessage: function () {
                    this.message = this.message.split('').reverse().join('')
                }
            }
        })
    </script>

    <div id="app-6">
        <p>{{ message }}</p>
        <input v-model="message">
    </div>

    <script>
        var app6 = new Vue({
            el: '#app-6',
            data: {
                message: 'Привет, Vue!'
            }
        })
    </script>

    <div id="app-7">
        <ol>
            <!--
              Теперь мы можем передать каждому компоненту todo-item объект
              с информацией о задаче, который будет динамически меняться.
              Мы также определяем для каждого компонента "key",
              значение которого мы разберём далее в руководстве.
            -->
            <todo-item
                v-for="item in groceryList"
                v-bind:todo="item"
                v-bind:key="item.id"
            ></todo-item>
        </ol>
    </div>

    <script>
        Vue.component('todo-item', {
            props: ['todo'],
            template: '<li>{{ todo.text }}</li>'
        })

        var app7 = new Vue({
            el: '#app-7',
            data: {
                groceryList: [
                    { id: 0, text: 'Овощи' },
                    { id: 1, text: 'Сыр' },
                    { id: 2, text: 'Что там ещё люди едят?' }
                ]
            }
        })
    </script>
    </body>
</html>