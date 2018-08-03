<template>
    <div class="notify" ref="notify" id="notice">
        <h2>{{msg}}</h2>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex'
    export default {
      name: 'point',
      data() {
        return {
          timer: null,
          msg: '提示'
        }
      },
      methods: {
        run(msg) {
          clearTimeout(this.timer)
          this.msg = msg
          this.$refs.notify.style.transform = 'translateY(20px)'
          this.timer = setTimeout(() => {
            this.$refs.notify.style.transform = 'translateY(-80px)'
          },2000)
        }
      }

    }
</script>

<style scoped lang="stylus">
    .notify
        position: absolute
        top: 10px
        left: 240px
        height: 50px
        line-height 50px
        width: 300px
        transition: all 0.5s
        transform: translateY(-80px)
        h2
            color: #058
            font-size: 20px
            overflow: hidden
            text-overflow:ellipsis
            white-space: nowrap
</style>