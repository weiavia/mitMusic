<template>
    <div>
        <div class="wrapper">
            <div class="time currentTime">{{format(currentTime)}}</div>
            <div class="bar" ref="bar"
                 @click.stop="changeTime"
            >
                <div class="curBar" ref="curBar"></div>
            </div>
            <div class="time endTime">{{format(duration)}}</div>
        </div>
    </div>
</template>

<script>
    export default {
      name: 'progress-bar',
      props: {
        currentTime: {
          default: 0
        },
        duration: {
          default: 0
        }
      },
      data() {
        return {
          changeFlag: true,
          timer: null
        }
      },
      mounted() {
        this.barTotalWidth = this.$refs.bar.offsetWidth
        this.curBar = this.$refs.curBar
      },
      methods: {
        changeTime(e) {
          let curPos = e.offsetX;
          let scale = curPos / this.barTotalWidth
          this.setBarOffset(scale)
          this.$emit('changeTime', scale)
        },
        setBarOffset(scale) {
          this.curBar.style.width = (scale * this.barTotalWidth) + 'px'
        },
        format(interval) {
          interval = interval | 0
          const minute = interval / 60 | 0
          const second = this._pad(interval % 60)
          return `${minute}:${second}`
        },
        _pad(num, n = 2) {
          let len = num.toString().length
          while (len < n) {
            num = '0' + num
            len++
          }
          return num
        }
      },
      watch: {
        currentTime(newTime) {
          let scale = newTime / this.duration
          this.setBarOffset(scale)
        }
      },
    }
</script>

<style lang="stylus" scoped="">
    .wrapper
        width: 100%
        background: #fff;
        height: 20px
        font-size: 15px
        display: flex
        justify-content: space-between
        align-items: center
        .time
            padding: 0 5px
            line-height: 20px
        .bar
            width: 100%
            height: 10px
            background: #000;
            cursor: pointer
            .curBar
                width: 0
                height: 100%
                background: #555555;
                transition: width 0.2s
</style>