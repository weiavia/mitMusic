<template>
  <div>
    <m-header :userinfo="userInfo" @logout="logout"></m-header>
    <router-view class="container"></router-view>
    <login @loginOk="loginOk" ref="login"></login>
  </div>
</template>

<script>
import MHeader from 'components/header/header'
import Login from 'components/login/login'
import {mapGetters, mapMutations} from 'vuex'

export default {
  data() {
    return {
      userInfo: null
    }
  },
  components: {
    MHeader,
    Login
  },
  methods: {
    loginOk(userInfo) {
      this.userInfo = userInfo
    },
    logout() {
      this.userInfo = null
      this.setShow(true)
    },
    ...mapMutations({
      'setShow': 'SET_LOGIN_SHOW'
    })
  }
}
</script>

<style>
.container {
  position: absolute;
  left: 0;
  right: 0;
  top: 60px;
  bottom: 0;
  width: 100%;
  box-sizing: border-box;
  overflow: auto;
  padding: 10px 20px;
  background: #eee;
}
.el-message-box__wrapper, .el-message-box {
    z-index: 99999 !important;
}
</style>
