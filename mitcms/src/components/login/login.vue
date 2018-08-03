<template>
      <div class="loginShade" v-show="loginShow">
          <div class="login-wrapper">
              <img src="http://mit.api.com/uploads/face/20180329/fda661b8ff93cceea9d780924abde671.jpg" alt="">
              <input type="text" placeholder="USERNAME" v-model="account">
              <input type="password" PLACEHOLDER="PASSWORD" v-model="password">
              <button @click="toLogin">登录</button>
          </div>
      </div>
</template>

<script>
    import {login} from 'api/user'
    import {getUserInfo} from 'api/user'
    import {getToken, saveToken} from 'common/js/token'
    import {mapGetters, mapMutations} from 'vuex'

    export default {
      data() {
        return {
          account: '',
          password: ''
        }
      },
      mounted() {
        let token = getToken()

        if(token && token != 'null') {
          this._getUserInfo()
        } else {
          this.setShow(true)
        }
      },
      methods: {
        toLogin() {
          let param = this.getParam()
          login(param).then((res) => {

            if(res.data.errorCode === 0) {
                this.setShow(false)
                saveToken(res.data.token)
                this.$emit('loginOk', res.data.userInfo)
            }
          }).catch(() => {
            this.$alert('你没有权限', '警告', {
              type: 'warning ',
              confirmButtonText: '确定'
            });
          })
        },
        getParam() {
          return {
            'account': this.account,
            'password': this.password
          }
        },
        _getUserInfo() {
          getUserInfo().then((res) => {
            this.$emit('loginOk', res.data.data)
          })
        },
        ...mapMutations({
          'setShow': 'SET_LOGIN_SHOW'
        })
      },
      computed: {
        ...mapGetters([
          'loginShow'
        ])
      }
    }
</script>

<style>
.loginShade {
    position: fixed;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: rgba(0,0,0, 0.6);
}

.login-wrapper {
    width: 300px;
    margin: 100px auto;
}

.login-wrapper img {
    width: 100px;
    height: 100px;
    margin: 0 auto;
    display: block;
    border-radius: 50%;
    margin-bottom: 20px;
}

.login-wrapper input {
    width: 100%;
    height: 40px;
    border: none;
    margin-bottom: 20px;
    font-size: 18px;
    text-align: center;
}

.login-wrapper button {
    width: 80%;
    height: 40px;
    border: none;
    background: #fff;
    margin: 0 auto;
    display: block;
    font-size: 20px;
    cursor: pointer;
}

.el-message-box__wrapper {
    z-index: 99999 !important;
}
</style>