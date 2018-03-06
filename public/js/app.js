var app = new Vue({
  el: '#app',

  delimiters: ['${', '}'],

  data: {
    items: []
  },

  methods: {
    load (service) {
      axios.get('http://distractiondashboard.test/api/news/' + service).then((response) => {
        this.items = response.data
      })
    }
  },

  mounted () {
    this.load('hackernews')
  }
})
