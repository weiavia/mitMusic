<template>
    <div>
        <div class="volumeWrapper">
            <i class="iconfont" :class="volumeIcon"></i>
            <div class="barWrapper" @mousedown="barDown"  ref="barWrapper">
                <div class="curBar" ref="curBar"></div>
                <div class="barBtn" ref="barBtn"></div>
            </div>
        </div>
    </div>
</template>

<script>
  const btnOffset = 10

  export default {
    name: 'volume',
    data() {
      return {
        moveFlag: false,
        scale: 1
      }
    },
    mounted() {
      this.barBtn = this.$refs.barBtn
      this.curBar = this.$refs.curBar
      this.maxPos = this.$refs.barWrapper.getBoundingClientRect().right
      this.minPos = this.$refs.barWrapper.getBoundingClientRect().left
      document.addEventListener('mousemove', this.mMove, false)
      document.addEventListener('mouseup', this.mUp, false)
    },
    methods: {
      barDown(e) {
        let pos = this.barBtn.getBoundingClientRect()
        this.moveFlag = true
        this.oldX = e.clientX
        let newPos = (this.barBtn.offsetLeft + e.clientX - pos.left) - btnOffset
        this.barBtn.style.left = newPos + 'px'
        this.curBar.style.width = newPos + 'px'

        this.scale = this.curBar.offsetWidth / this.$refs.barWrapper.offsetWidth
        this.$emit('changeVolume', this.scale)
      },
      mMove(e) {
        if (!this.moveFlag)
          return

        let curX = e.clientX
        let offset = curX - this.oldX
        this.oldX = curX

        let newPos = this.barBtn.offsetLeft + offset

        this.maxPos = this.$refs.barWrapper.getBoundingClientRect().right
        this.minPos = this.$refs.barWrapper.getBoundingClientRect().left

        if (newPos + this.minPos > this.maxPos - btnOffset) {
          newPos = this.maxPos - this.minPos - btnOffset
        } else if (newPos < -btnOffset) {
          newPos = -btnOffset
        }

        this.barBtn.style.left = newPos + 'px'
        this.curBar.style.width = (newPos + btnOffset) + 'px'

        this.scale = this.curBar.offsetWidth / this.$refs.barWrapper.offsetWidth
        this.$emit('changeVolume', this.scale)
      },
      mUp() {
        this.moveFlag = false
      }
    },
    computed: {
      volumeIcon() {
        return this.scale === 0 ? 'icon-52jingyin' : 'icon-yinliang'
      }
    }
  }
</script>

<style lang="stylus" scoped>
    .volumeWrapper
        display: flex
        align-items center
        .iconfont
            font-size: 30px
        .barWrapper
            cursor: pointer
            height: 6px
            width: 100%
            margin-left: 20px
            margin-right: 10px
            background: #000;
            position: relative
            .curBar
                height: 100%
                background: #058;
                width: 100%
            .barBtn
                width: 20px
                height: 20px
                background: #777;
                border-radius: 50%
                position: absolute
                top: -7px
                left: 230px
</style>