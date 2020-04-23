Vue.component('chat', {
  props: ['task'],
  template: `<div><h3>Переписка</h3>
             <div class="chat__overflow">
               <div class="chat__message" v-for="item in messages" :class="{'chat__message--out': item.is_mine == 1}">
                <p class="chat__message-time">{{ item.dt_add }}</p>
                <p class="chat__message-text">{{ item.message }}</p>
               </div>
              </div>
              <p class="chat__your-message">Ваше сообщение</p>
              <form class="chat__form">
                  <textarea class="input textarea textarea-chat" rows="2" name="message-text"
                  v-model="message" placeholder="Текст сообщения">{{this.message}}</textarea>
                  <button class="button chat__button" v-on:click="sendMessage" type="button">Отправить</button>
              </form></div>`,
  mounted: function() {
    if (typeof this.task === "undefined") {
      console.error("Не передан идентификатор задания (атрибут task) в теге 'chat'")
    }
    else {
      this.api_url = '/api/messages/' + this.task;
      this.getMessages();
    }
  },
  methods: {
    sendMessage: function() {
      fetch(this.api_url, {
        method: 'POST',
        body: JSON.stringify({task: this.task, message: this.message})
      })
      .then(result => {
        if (result.status !== 201) {
          return Promise.reject(new Error('Запрошенный ресурс не существует'));
        }

        return result.json();
      })
      .then(msg => {
        this.messages.push(msg);
        this.message = null;
      })
      .catch(err => {
        console.error('Не удалось отправить сообщение', err);
      })
    },
    getMessages: function () {
      fetch(this.api_url)
      .then(result => {
        if (result.status !== 200) {
          return Promise.reject(new Error('Запрошенный ресурс не существует'));
        }

        return result.json();
      })
      .then(messages => {
        this.messages = messages;
      })
      .catch(err => {
        console.error('Не удалось получить сообщения чата', err);
      })
    }
  },
  data: function () {
    return {
      messages: [],
      api_url: null,
      message: null
    }
  }
});

var app = new Vue({
  el: "#chat-container",
});
