<template>
  <div class="home">
    <Navigator :session="session" />
    <Jumbotron />
    <HomeComponent v-if="boards" :session="session" :boards="boards" />
    <Foot/>
  </div>
</template>

<script>
  import Navigator from '../components/Navigator'
  import Jumbotron from '../components/Jumbotron'
  import HomeComponent from '../components/HomeComponent'
  import Foot from '../components/Foot'

  export default {
    name: 'home',
    components: {
      Navigator,
      Jumbotron,
      HomeComponent,
      Foot
    },
    props: {
      session: {
        user_id: null,
        user_is_admin: null,
        user_name: null
      }
    },
    data() {
      return {
        boards: {
          board: {
            board_id: null,
            board_name: null,
            board_intro: null
          }
        }
      }
    },
    beforeMount() {
      const self = this
      self.$emit('update')
      fetch(api + '/')
        .then((response) => {
          return response.json()
        })
        .then((data) => {
          self.boards = data.boards
        })
    }
  }
</script>
